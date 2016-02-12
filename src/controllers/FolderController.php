<?php namespace Simexis\Filemanager\controllers;

use Lang;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * Class FolderController
 * @package Simexis\Filemanager\controllers
 */
class FolderController extends Controller {

    /**
     * Get list of folders as json to populate treeview
     *
     * @return mixed
     */
    public function getFolders()
    {
        $directories = File::directories(base_path(Config::get('sfm.dir')));
        $final_array = [];

        foreach ($directories as $directory)
        {
            if (basename($directory) != "thumbs")
            {
                $final_array[] = basename($directory);
            }
        }

        return View::make("filemanager::tree")
            ->with('dirs', $final_array);
    }


    /**
     * Add a new folder
     *
     * @return mixed
     */
    public function getAddfolder()
    {
        $folder_name = Str::slug(Input::get('name'));

        $path = base_path(Config::get('sfm.dir'));

        if (!File::exists($path . "/" . $folder_name))
        {
            File::makeDirectory($path . "/" . $folder_name, $mode = 0777, true, true);
            return "OK";
        } else
        {
            return Lang::get('filemanager::sfm.folder_exists');
        }

    }

}
