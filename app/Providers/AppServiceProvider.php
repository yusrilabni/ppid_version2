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
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;

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
        // Workaround: server hosting *.sinjaikab.go.id intercepts outbound SSL
        // causing Peer certificate CN mismatch. Disable peer verification.
        if (config('app.env') === 'production') {
            Mail::extend('smtp', function (array $config = []) {
                $transport = new EsmtpTransport(
                    $config['host'] ?? 'smtp.gmail.com',
                    (int) ($config['port'] ?? 465),
                    (bool) ($config['encryption'] === 'ssl' || $config['scheme'] === 'smtps'),
                );
                $transport->setUsername($config['username'] ?? '');
                $transport->setPassword($config['password'] ?? '');

                // Disable SSL peer verification to bypass server proxy cert mismatch
                $stream = $transport->getStream();
                $stream->setStreamOptions([
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true,
                    ],
                ]);

                return $transport;
            });
        }

        // Event Listeners
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Login::class, \App\Listeners\UpdateLastLogin::class);

        // Register Observers
        \App\Models\Berita::observe(\App\Observers\BeritaObserver::class);
        \App\Models\Informasi::observe(\App\Observers\InformasiObserver::class);

        // Paksa HTTPS jika di production
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Cache Invalidation untuk Endpoint Home
        $homeModels = [\App\Models\ProfilPpid::class, \App\Models\Slider::class, \App\Models\Informasi::class, \App\Models\Galeri::class, \App\Models\PermohonanInformasi::class, \App\Models\SurveyResponse::class];
        foreach ($homeModels as $model) {
            $model::saved(function() {
                \Illuminate\Support\Facades\Cache::forget('all_home');
                \Illuminate\Support\Facades\Cache::forget('profil_api_data');
            });
            $model::deleted(function() {
                \Illuminate\Support\Facades\Cache::forget('all_home');
                \Illuminate\Support\Facades\Cache::forget('profil_api_data');
            });
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
            $popularLinks = [];
            
            // Get top 3 most accessed links
            $topAccessedLinks = \App\Models\LinkAccessLog::orderByDesc('access_count')
                                                          ->orderByDesc('last_accessed_at')
                                                          ->take(3)
                                                          ->get();

            foreach ($topAccessedLinks as $linkLog) {
                $popularLinks[] = [
                    'title' => $linkLog->title,
                    'url' => $linkLog->url,
                ];
            }

            // If fewer than 3 dynamic links, supplement with important static links
            $staticLinks = [
                ['title' => 'Profil PPID', 'url' => route('frontend.profil-ppid.show')],
                ['title' => 'Galeri', 'url' => route('frontend.galeri.all')],
                ['title' => 'Permohonan Informasi', 'url' => route('laporan.permohonan.create')],
                ['title' => 'Kontak', 'url' => route('home') . '#kontak'],
            ];

            foreach ($staticLinks as $sLink) {
                if (count($popularLinks) >= 3) break;
                
                $exists = false;
                foreach ($popularLinks as $pLink) {
                    if ($pLink['url'] === $sLink['url']) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) $popularLinks[] = $sLink;
            }

            $view->with('navLinks', $popularLinks);
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
