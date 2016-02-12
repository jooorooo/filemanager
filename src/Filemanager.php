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

    public function browseUrl() {
        return route('filemanager.show');
    }

    public function uploadUrl() {
        return route('filemanager.upload',['_token' => csrf_token() ]);
    }

}