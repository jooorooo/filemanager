<?php namespace Simexis\Filemanager\controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

/**
 * Class LfmController
 * @package Simexis\Filemanager\controllers
 */
class SfmController extends Controller {

    /**
     * Show the filemanager
     *
     * @return mixed
     */
    public function show()
    {
        if (Input::has('base') && strpos(Input::has('base'), '..') === false)
        {
            $working_dir = Input::get('base');
            $base = Config::get('sfm.dir') . Input::get('base') . "/";
        } else
        {
            $working_dir = "/";
            $base = Config::get('sfm.dir');
        }

        return View::make('filemanager::index')
            ->with('base', $base)
            ->with('working_dir', $working_dir);
    }

}
