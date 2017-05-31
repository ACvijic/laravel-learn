<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Model\Menu;
use App\Model\Language;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('*', function(){
            $menusHeader = Menu::withParent(0)->visible(1)->position('header')->orderBy('priority', 'asc')->get();
            view()->share('menusHeader', $menusHeader);
            $menusFooter = Menu::withParent(0)->visible(1)->position('footer')->orderBy('priority', 'asc')->get();
            view()->share('menusFooter', $menusFooter);
            $defaultLanguage = Language::orderBy('priority', 'asc')->first();
            view()->share('defaultLanguage', $defaultLanguage);
            $languageOptions = Language::orderBy('priority', 'asc')->get();
            view()->share('languageOptions', $languageOptions);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
