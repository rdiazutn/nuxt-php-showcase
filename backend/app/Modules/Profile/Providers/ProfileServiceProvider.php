<?php


namespace App\Modules\Profile\Providers;


use App\Modules\Profile\Contract\ProfileServiceInterface;
use App\Modules\Profile\Permission\ProfilePermission;
use App\Modules\Profile\ProfileService;
use App\Permission\AbstractPermission;
use Illuminate\Support\ServiceProvider;

/**
 * Class ProfileServiceProvider
 * @package App\Modules\Profile\Providers
 */
class ProfileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        AbstractPermission::register(ProfilePermission::class);
    }
}
