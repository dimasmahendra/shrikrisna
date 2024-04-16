<?php

namespace App\Providers;

use App\Models\About;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // \URL::forceScheme('https');

        Paginator::defaultView('pagination::bootstrap-4');

        View::share('version', '1.8');

        // View::share('logocompany', '/cms/images/samples/no-image.svg' );
        // View::share('logolightcompany', '/cms/images/samples/no-image.svg' );
        // View::share('faviconcompany', '/auth/img/favicon.ico' );

        // if (Schema::hasTable('about')) {
        //     $checkdata = About::where("option", "setting-company")->get();
        //     if (count($checkdata) > 0) {
        //         $company = About::getCompany();
        //         View::share('logocompany', isset($company->company_logo) ? Storage::url($company->company_logo) : '/cms/images/samples/no-image.svg' );
        //         View::share('logolightcompany', isset($company->company_light_logo) ? Storage::url($company->company_light_logo) : '/cms/images/samples/no-image.svg' );
        //         View::share('faviconcompany', isset($company->company_favicon) ? Storage::url($company->company_favicon) : '/cms/images/samples/no-image.svg' );
        //     } else {
        //         View::share('logocompany', '/cms/images/samples/no-image.svg' );
        //         View::share('logolightcompany', '/cms/images/samples/no-image.svg' );
        //         View::share('faviconcompany', '/cms/images/samples/no-image.svg' );
        //     }
        // } else {
        //     View::share('logocompany', '/cms/images/samples/no-image.svg' );
        //     View::share('logolightcompany', '/cms/images/samples/no-image.svg' );
        //     View::share('faviconcompany', '/cms/images/samples/no-image.svg' );
        // }
    }
}
