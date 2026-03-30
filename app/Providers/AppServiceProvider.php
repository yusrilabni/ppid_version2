<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\View; // Add this import
use App\Models\ProfilPpid; // Add this import
use App\Models\LinkAccessLog; // Add this import

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ImageManager::class, function () {
            return new ImageManager(new Driver());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa HTTPS jika di production
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Deteksi jika berjalan di sub-folder /v2
        if (strpos(request()->getRequestUri(), '/v2') === 0) {
            \Illuminate\Support\Facades\URL::forceRootUrl(env('APP_URL', 'https://ppidkab.sinjaikab.go.id/v2'));
        }

        // Removed the log entry from here
        $this->bootRoutes();

        Gate::define('manage-structure', function (User $user, Organization $organization) {
            if ($user->role === 'superadmin') {
                return true;
            }
            if ($user->role === 'admin') {
                return $user->unit_id == $organization->unit_id;
            }
            return false;
        });

        Paginator::useTailwind();

        // View Composer for footer contact info
        View::composer('frontend.layouts.footer', function ($view) {
            $profilPpid = ProfilPpid::where('status', true)->first();

            $contactInfo = [
                'address' => ($profilPpid ? $profilPpid->address : null) ?? config('ppid.contact_info.address') ?? 'Alamat belum diatur',
                'phone' => ($profilPpid ? $profilPpid->phone : null) ?? config('ppid.contact_info.phone') ?? 'Telepon belum diatur',
                'email' => ($profilPpid ? $profilPpid->email : null) ?? config('ppid.contact_info.email') ?? 'Email belum diatur',
                'service_hours_weekday' => config('ppid.contact_info.service_hours_weekday') ?? '08:00 - 16:00',
                'service_hours_friday' => config('ppid.contact_info.service_hours_friday') ?? '08:00 - 15:30',
                'service_hours_weekend' => config('ppid.contact_info.service_hours_weekend') ?? 'Libur',
            ];

            $view->with('contactInfo', $contactInfo);

            $socialMedia = [
                'instagram' => $profilPpid ? $profilPpid->instagram : null,
                'facebook' => $profilPpid ? $profilPpid->facebook : null,
                'twitter' => $profilPpid ? $profilPpid->twitter : null,
                'tiktok' => $profilPpid ? $profilPpid->tiktok : null,
                'youtube' => $profilPpid ? $profilPpid->youtube : null,
                'website' => $profilPpid ? $profilPpid->website : null,
            ];

            $view->with('socialMedia', $socialMedia);

            // New navigation links logic
            $navLinks = [];
            
            // Get top 5 most accessed links
            $topAccessedLinks = \App\Models\LinkAccessLog::orderByDesc('access_count')
                                                          ->orderByDesc('last_accessed_at')
                                                          ->take(5)
                                                          ->get();

            foreach ($topAccessedLinks as $linkLog) {
                $navLinks[] = [
                    'title' => $linkLog->title,
                    'url' => $linkLog->url,
                ];
            }

            // If fewer than 5 dynamic links, supplement with important static links
            $staticLinks = [
                ['title' => 'Profil PPID', 'url' => route('frontend.profil-ppid.show')],
                ['title' => 'Galeri', 'url' => route('frontend.galeri.all')],
                ['title' => 'Permohonan Informasi', 'url' => route('laporan.permohonan.create')],
                ['title' => 'Kontak', 'url' => route('home') . '#kontak'],
                ['title' => 'Informasi Berkala', 'url' => url('/informasi/berkala')],
                ['title' => 'Informasi Setiap Saat', 'url' => url('/informasi/setiap-saat')],
            ];

            // Add static links only if they are not already in navLinks and if we need more links
            foreach ($staticLinks as $sLink) {
                if (count($navLinks) >= 5) {
                    break;
                }
                $exists = false;
                foreach ($navLinks as $nLink) {
                    if ($nLink['url'] === $sLink['url']) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) {
                    $navLinks[] = $sLink;
                }
            }

            // Ensure only top 5 unique links
            $navLinks = collect($navLinks)->unique('url')->take(5)->values()->toArray();

            // Sort remaining links alphabetically by title
            usort($navLinks, function($a, $b) {
                return strcmp($a['title'], $b['title']);
            });
            // Ensure we only pass up to 5 links after sorting
            $navLinks = array_slice($navLinks, 0, 5);


            $view->with('navLinks', $navLinks);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function bootRoutes()
    {
        Route::middleware('web')
            ->group(base_path('routes/google.php'));
    }
}
