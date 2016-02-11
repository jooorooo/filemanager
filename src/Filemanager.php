<?php namespace Simexis\Filemanager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


/**
 * Class Filemanager
 * @package Simexis\Filemanager
 */
class Filemanager
{

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function scripts() {
        return view('filemanager::scripts');
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

    private function _FileBrowseUrl() {
        return route('filemanager.show', ['type' => 'File']);
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

    private function _FileUploadUrl() {
        return route('filemanager.upload', ['type' => 'File']);
    }

}