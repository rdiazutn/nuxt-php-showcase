<?php

namespace App\Providers;

use App\OpenApi\Annotations\OARequest;
use App\OpenApi\Security\SanctumSecuritySchemeFactory;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAnnotations();
    }

    protected function registerAnnotations()
    {
        $reflection = new \ReflectionClass(OARequest::class);
        AnnotationRegistry::registerFile($reflection->getFileName());
        $reflection = new \ReflectionClass(SanctumSecuritySchemeFactory::class);
        AnnotationRegistry::registerFile($reflection->getFileName());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
