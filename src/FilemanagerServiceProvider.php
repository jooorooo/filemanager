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
        $this->app['filemanager'] = $this->app->share(function ()
        {
            return true;
        });
    }
	
	public function getFilebrowser($key) {
		if(in_array($key, ['BrowseUrl', 'ImageBrowseUrl', 'FlashBrowseUrl', 'UploadUrl', 'ImageUploadUrl', 'FlashUploadUrl']) && is_callable([$this, '_' . $key]))
			return call_user_func([$this, '_' . $key]);
		return null;
	}
	
	private function _BrowseUrl() {
		return route('filemanager.show');
	}
	
	private function _ImageBrowseUrl() {
		return route('filemanager.show', ['type' => 'Images']);
	}
	
	private function _FlashBrowseUrl() {
		return route('filemanager.show', ['type' => 'Flash']);
	}
	
	private function _UploadUrl() {
		return route('filemanager.upload');
	}
	
	private function _ImageUploadUrl() {
		return route('filemanager.upload', ['type' => 'Images']);
	}
	
	private function _FlashUploadUrl() {
		return route('filemanager.upload', ['type' => 'Flash']);
	}

}
