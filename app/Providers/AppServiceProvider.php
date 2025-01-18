<?php

namespace App\Providers;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('currency', function ( $expression ) { return "Rp. <?php echo number_format($expression,0,',','.'); ?>"; });
        Blade::directive('encrypt', function ( $expression ) { return Helper::encryptUrl($expression); });
        Blade::if('jurusan', function (){
            $user = User::where('id', session('id_user'))->first();
            return $user->hasPermissionTo('jurusan');
        });
    }
}
