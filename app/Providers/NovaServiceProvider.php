<?php

namespace App\Providers;

use App\Models\Product;
use App\Nova\ChinaProcessing;
use App\Nova\ChinaReceipt;
use App\Nova\Client;
use App\Nova\Compnay;
use App\Nova\LayerFive;
use App\Nova\LayerFour;
use App\Nova\LayerOne;
use App\Nova\LayerThere;
use App\Nova\LayerTow;
use App\Nova\Order;
use App\Nova\Polica;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Pktharindu\NovaPermissions\Nova\Role;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::style('style',public_path('css/style.css'));
        Nova::withBreadcrumbs();
        Nova::mainMenu(function (Request $request)
        {
            return [

                MenuSection::make(Nova::__('Student'), [
                    MenuItem::resource(User::class),
                    MenuItem::resource(Role::class),

                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Customer'), [
                    MenuItem::resource(Client::class),
                    MenuItem::resource(Compnay::class)
                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Order'), [
                    MenuItem::resource(Order::class),
                    MenuItem::resource(\App\Nova\Product::class),
                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Polisa'), [
                    MenuItem::resource(Polica::class),
                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Roles and permissions'), [
                    MenuItem::resource(Role::class),
                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Layer One'), [
                    MenuItem::resource(LayerOne::class),
                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Layer Tow'), [
                    MenuItem::resource(LayerTow::class),
                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Layer There'), [
                    MenuItem::resource(LayerThere::class),
                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Layer Four'), [
//                    MenuItem::resource(LayerFour::class),
                    MenuItem::resource(ChinaReceipt::class),
                    MenuItem::resource(ChinaProcessing::class),
                ])->icon('user')->collapsable(),
                MenuSection::make(Nova::__('Layer Five'), [
//                    MenuItem::resource(LayerFive::class),
                    MenuItem::resource(Polica::class),
                ])->icon('user')->collapsable(),





            ];

        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Pktharindu\NovaPermissions\NovaPermissions(),
        ];
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
