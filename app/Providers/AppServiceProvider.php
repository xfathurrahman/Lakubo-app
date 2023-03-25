<?php

namespace App\Providers;

use App\View\Composers\NavbarComposer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $request;

    public function __construct()
    {
        $this->request = app('request');
    }

    public function boot(Request $request)
    {
        $this->setHttps($request);
        $this->setLocale();
        $this->setDatabase();
        View::composer('home.components.navbar', NavbarComposer::class);

        Blade::directive('currency', function ($expression) {
            return "Rp. <?php echo number_format($expression, 0, ',', '.'); ?>";
        });
    }

    protected function setHttps(Request $request)
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        } elseif (app()->environment('local')) {
            if ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
                $request->server->set('HTTPS', true);
            }
        }
    }

    protected function setLocale()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }

    protected function setDatabase()
    {
        Schema::defaultStringLength(191);
    }
}
