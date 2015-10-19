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
class LfmController extends Controller {

    /**
     * @var
     */
    protected $file_location;

    /**
     * Constructor
     */
    public function __construct()
    {
        if ((Session::has('sfm_type')) && (Session::get('sfm_type') == 'Files'))
        {
            $this->file_location = Config::get('sfm.files_dir');
        } else
        {
            $this->file_location = Config::get('sfm.images_dir');
        }
    }


    /**
     * Show the filemanager
     *
     * @return mixed
     */
    public function show()
    {
        if ((Input::has('type')) && (Input::get('type') == "Files"))
        {
            Session::put('sfm_type', 'Files');
            $this->file_location = Config::get('sfm.files_dir');
        } else
        {
            Session::put('sfm_type', 'Images');
            $this->file_location = Config::get('sfm.images_dir');
        }

        if (Input::has('base'))
        {
            $working_dir = Input::get('base');
            $base = $this->file_location . Input::get('base') . "/";
        } else
        {
            $working_dir = "/";
            $base = $this->file_location;
        }

        return View::make('filemanager::index')
            ->with('base', $base)
            ->with('working_dir', $working_dir);
    }

}
