<?php

namespace App\Providers;

use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        // Log::info('AppServiceProvider boot() DIJALANKAN');

        // GLOBAL SHARE
        View::share('daily', Cache::remember('visitor_daily', 300, function () {
            $today = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');
            $count = Visitor::whereDate('visited_at', $today)
                ->distinct('ip_address')
                ->count('ip_address');

            Log::info('✅ Visitor Daily dihitung', ['daily' => $count, 'today' => $today]);
            return $count;
        }));

        View::share('total', Cache::remember('visitor_total', 300, function () {
            $count = Visitor::distinct('ip_address')->count('ip_address');

            Log::info('✅ Visitor Total dihitung', ['total' => $count]);
            return $count;
        }));
    }
}
