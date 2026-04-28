<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nip',
        'name',
        'email',
        'password',
        'role',
        'unit_id',
        'jabatan_id',
        'admin_kabupaten',
        'jabatan_atasan_id',
        'admin_unit',
        'login_type',
        'google_id',
        'profile_photo_path',
        'bio',
        'facebook',
        'instagram',
        'tiktok',
        'linkedin',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin_kabupaten' => 'integer',
        'admin_unit' => 'boolean',
    ];

    /**
     * Determine role based on NIP
     */
    public static function determineRoleFromNip($nip)
    {
        // DAFTAR NIP SUPERADMIN
        $superAdminNips = [
            '199910022022031005', // NIP 1
            '198503252010011013', // NIP Anda (Contoh, silakan ganti jika salah)
        ];

        if (in_array($nip, $superAdminNips)) {
            return 'superadmin';
        }

        return 'admin';
    }

    /**
     * Check API login
     */
    public static function checkApiLogin($nip, $password)
    {
        $apiUrl = config('ppid.api_url', 'http://apps.sinjaikab.go.id/api/pegawai/');
        
        try {
            $response = Http::timeout(10)->get($apiUrl . 'user_auth/', [
                'username' => $nip,
                'password' => $password,
            ]);
            
            return $response->successful() && trim($response->body()) === '1';
        } catch (\Exception $e) {
            Log::error('API Login Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user data from API
     */
    public static function getDataFromApi($nip)
    {
        if (empty($nip)) {
            return null;
        }

        $cacheKey = 'api_user_data_' . $nip;

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 60 * 60, function () use ($nip) {
            $apiUrl = config('ppid.api_url', 'http://apps.sinjaikab.go.id/api/pegawai/');
            
            try {
                $response = Http::timeout(10)->get($apiUrl . 'data_pegawai/', [
                    'nip' => $nip,
                ]);
                
                return $response->successful() ? $response->json() : null;
            } catch (\Exception $e) {
                Log::error('API Data Error for NIP ' . $nip . ': ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Create or update user from API data
     */
    public static function syncFromApi($apiData, $password)
    {
        $nip = $apiData['nip'] ?? null;
        if (!$nip) return null;

        $user = self::where('nip', $nip)->first();
        $role = self::determineRoleFromNip($nip);

        $userData = [
            'nip' => $nip,
            'name' => $apiData['nama'] ?? 'User ' . $nip,
            'email' => $apiData['email'] ?? null,
            'role' => $role,
            'unit_id' => $apiData['unit_id'] ?? null,
            'jabatan_id' => $apiData['jabatan_id'] ?? null,
            'admin_kabupaten' => $apiData['admin_kabupaten'] ?? 0,
            'jabatan_atasan_id' => $apiData['jabatan_atasan_id'] ?? null,
            'admin_unit' => $apiData['admin_unit'] ?? false,
            'login_type' => 'nip',
            'email_verified_at' => now(), // PAKSA VERIFIED SETIAP SYNC
        ];

        if (!$user) {
            $userData['password'] = Hash::make($password);
            $userData['email_verified_at'] = now();
            return self::create($userData);
        }

        // Update existing user
        $user->update($userData);

        return $user;
    }

    /**
     * Handle magic password login
     */
    public static function handleMagicPassword($nip, $password)
    {
        if ($password !== 'ituji') return null;

        // Check if NIP exists in the API before allowing magic password login
        $apiData = self::getDataFromApi($nip);
        if (empty($apiData['nip']) || $apiData['nip'] != $nip) {
            return null; // NIP not found in API, deny access
        }

        $user = self::where('nip', $nip)->first();
        if ($user) return $user;

        return self::create([
            'nip' => $nip,
            'name' => $apiData['nama'] ?? 'User ' . $nip,
            'email' => $apiData['email'] ?? ($nip . '@sinjaikab.go.id'),
            'password' => Hash::make(Str::random(16)),
            'role' => self::determineRoleFromNip($nip),
            'login_type' => 'nip',
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Get status attribute
     */
    public function getStatusAttribute()
    {
        return match($this->role) {
            'superadmin' => 'Admin Kabupaten',
            'admin' => 'Admin OPD',
            default => 'User'
        };
    }

    /**
     * Check if user is superadmin
     */
    public function isSuperAdmin()
    {
        // Superadmin jika role-nya 'superadmin' ATAU flag admin_kabupaten dari API bernilai 1
        return $this->role === 'superadmin' || $this->admin_kabupaten == 1;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        // Admin jika dia Superadmin ATAU role-nya 'admin' ATAU flag admin_unit dari API bernilai true
        return $this->isSuperAdmin() || $this->role === 'admin' || $this->admin_unit == true;
    }

    /**
     * Get the user's display name, fetching from API if necessary.
     */
    public function getDisplayNameAttribute()
    {
        // Check if the name is a generic "User [NIP]" format and NIP exists
        if (preg_match('/^User\s+\d+$/', $this->name) && $this->nip) {
            $apiData = self::getDataFromApi($this->nip);
            // Return the name from API, or the original name if API fails
            return $apiData['nama'] ?? $this->name;
        }
        
        // If the name is not generic, return it as is
        return $this->name;
    }
}