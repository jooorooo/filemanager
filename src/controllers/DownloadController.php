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
            . Config::get('sfm.dir')
            .  $dir
            . "/"
            . $file_to_download);
    }

}
