<?php

namespace shishao\laramodel;

use shishao\laramodel\Support\Classify;
use shishao\laramodel\Model\Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use shishao\laramodel\Model\ModelFactory;

class ModelsServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/models.php' => config_path('create-models.php'),
            ], 'shishao-models');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModelFactory();
    }

    /**
     * Register Model ModelFactory.
     *
     * @return void
     */
    protected function registerModelFactory()
    {
        $this->app->singleton(ModelFactory::class, function ($app) {
            return new ModelFactory(
                $app->make('db'),
                $app->make(Filesystem::class),
                new Classify(),
                new Config($app->make('config')->get('models'))
            );
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [ModelFactory::class];
    }
}
