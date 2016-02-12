<?php namespace Simexis\Filemanager\controllers;

use Lang;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

/**
 * Class CropController
 * @package Simexis\Filemanager\controllers
 */
class DeleteController extends Controller {


    /**
     * Delete image and associated thumbnail
     *
     * @return mixed
     */
    public function getDelete()
    {
        $to_delete = Input::get('items');
        $base = Input::get("base");

        if ($base != "/")
        {
            if (File::isDirectory(base_path() . "/" . Config::get('sfm.dir') . $to_delete))
            {
                File::delete(base_path() . "/" . Config::get('sfm.dir') . $base . "/" . $to_delete);

                return "OK";
            } else
            {
                if (File::exists(base_path() . "/" . Config::get('sfm.dir') . $base . "/" . $to_delete))
                {
                    if (@getimagesize(base_path() . "/" . Config::get('sfm.dir') . $base . "/" . $to_delete))
                        File::delete(base_path() . "/" . Config::get('sfm.dir') . $base . "/.thumbs/" . $to_delete);
                    File::delete(base_path() . "/" . Config::get('sfm.dir') . $base . "/" . $to_delete);

                    return "OK";
                } else {
                    return Lang::get('filemanager::sfm.not_found', ['file' => Config::get('sfm.dir') . $base . "/" . $to_delete]);
                }
            }
        } else
        {
            $file_name = base_path() . "/" . Config::get('sfm.dir') . $to_delete;
            if (File::isDirectory($file_name))
            {
                // make sure the directory is empty
                if (sizeof(File::files($file_name)) == 0)
                {
                    File::deleteDirectory($file_name);

                    return "OK";
                } else
                {
                    return Lang::get('filemanager::sfm.not_empty');
                }
            } else
            {
                if (File::exists($file_name))
                {
                    if (@getimagesize($file_name))
                        File::delete(base_path() . "/" . Config::get('sfm.dir') . "/.thumbs/" . $to_delete);
                    File::delete($file_name);
                    return "OK";
                }
            }
        }
    }
    
}
