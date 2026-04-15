<?php

namespace App\Providers;

use App\Models\Informasi;
use App\Models\StandarLayanan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('frontend.layouts.navbar', function ($view) {
            $menuConfig = config('menu');

            // --- Dynamic DIP Menu Logic ---
            $dipYears = Cache::remember('dip_years', 600, function () {
                return Informasi::whereNotNull('tahun')->select('tahun')->distinct()->orderBy('tahun', 'desc')->take(3)->pluck('tahun');
            });

            $dipSubMenu = [];
            
            // Add the last 3 years first
            foreach ($dipYears as $year) {
                $dipSubMenu[] = ['title' => "DIP Tahun $year", 'url' => route('dip.show', $year), 'icon' => 'calendar-alt'];
            }

            // Add DIP Unit as the last item
            $dipSubMenu[] = ['title' => 'DIP Unit', 'url' => url('/dipunit'), 'icon' => 'university'];

            // Find the DIP menu item and inject the children
            foreach ($menuConfig as &$menuItem) {
                if ($menuItem['title'] === 'DIP') {
                    $menuItem['children'] = $dipSubMenu;
                    break;
                }
            }
            // --- End of DIP Menu Logic ---
            
            // --- LHKPN Menu (Direct Link) ---
            foreach ($menuConfig as &$menuItem) {
                if ($menuItem['title'] === 'LHKPN') {
                    $menuItem['url'] = route('frontend.lhkpn.index');
                    unset($menuItem['children']);
                    break;
                }
            }
            // --- End of LHKPN Menu Logic ---
            
            $view->with('menus', $menuConfig);
        });
    }
}