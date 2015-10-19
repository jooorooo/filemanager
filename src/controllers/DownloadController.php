<?php namespace Simexis\Filemanager\controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

/**
 * Class DownloadController
 * @package Simexis\Filemanager\controllers
 */
class DownloadController extends Controller {

    /**
     * @var
     */
    protected $file_location;


    /**
     * constructor
     */
    function __construct()
    {
        if (Session::get('sfm_type') == "Images")
            $this->file_location = Config::get('sfm.images_dir');
        else
            $this->file_location = Config::get('sfm.files_dir');
    }


    /**
     * Download a file
     *
     * @return mixed
     */
    public function getDownload()
    {
        $file_to_download = Input::get('file');
        $dir = Input::get('dir');
        return Response::download(base_path()
            .  "/"
            . $this->file_location
            .  $dir
            . "/"
            . $file_to_download);
    }

}
