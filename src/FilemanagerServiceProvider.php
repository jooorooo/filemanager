<?php namespace Simexis\Filemanager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


/**
 * Class LaravelFilemanagerServiceProvider
 * @package Simexis\Filemanager
 */
class FilemanagerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Config::get('sfm.use_package_routes'))
            include __DIR__ . '/routes.php';

        $this->loadTranslationsFrom(__DIR__.'/lang', 'filemanager');

        $this->loadViewsFrom(__DIR__.'/views', 'filemanager');

        $this->publishes([
            __DIR__ . '/config/sfm.php' => config_path('sfm.php', 'config'),
        ], 'sfm_config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/filemanager'),
        ], 'sfm_public');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/filemanager'),
        ], 'sfm_views');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->singleton('filemanager', function ($app) {
			return new Filemanager($app);
		});
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('filemanager');
    }
	
	public function getFilebrowser($key) {
        return with(new Filemanager($this->app))->getFilebrowser($key);
	}

}
