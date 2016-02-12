<?php namespace Simexis\Filemanager\controllers;

use Lang;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Class RenameController
 * @package Simexis\Filemanager\controllers
 */
class RenameController extends Controller {

    /**
     * @return string
     */
    function getRename(){

        $file_to_rename = Input::get('file');
        $dir = Input::get('dir');
        $new_name = Str::slug(Input::get('new_name'));

        if ($dir == "/")
        {
            if (File::exists(base_path() . "/". Config::get('sfm.dir') . $new_name))
            {
                return Lang::get('filemanager::sfm.file_exists');
            } else
            {
                if (File::isDirectory(base_path() . "/" . Config::get('sfm.dir') . $file_to_rename))
                {
                    File::move(base_path() . "/" . Config::get('sfm.dir') . $file_to_rename,
                        base_path() . "/" . Config::get('sfm.dir') . $new_name);

                    return "OK";
                } else
                {
                    $extension = File::extension(base_path() . "/" . Config::get('sfm.dir') . $file_to_rename);
                    $new_name = Str::slug(str_replace($extension, '', $new_name)) . "." . $extension;

                    if (@getimagesize(base_path() . "/" . Config::get('sfm.dir') . $file_to_rename))
                    {
                        // rename thumbnail
                        File::move(base_path() . "/" . Config::get('sfm.dir') . "/.thumbs/" . $file_to_rename,
                            base_path() . "/" . Config::get('sfm.dir') . "/.thumbs/" . $new_name);
                    }

                    File::move(base_path() . "/" . Config::get('sfm.dir') . $file_to_rename,
                        base_path() . "/" . Config::get('sfm.dir') . $new_name);

                    return "OK";
                }
            }
        } else
        {
            if (File::exists(base_path() . "/" . Config::get('sfm.dir') . $dir . "/" . $new_name))
            {
                return Lang::get('filemanager::sfm.file_exists');
            } else
            {
                if (File::isDirectory(base_path() . "/" . Config::get('sfm.dir') . $dir . "/" . $file_to_rename))
                {
                    File::move(base_path() . "/" . Config::get('sfm.dir') . $dir . "/" . $file_to_rename,
                        base_path() . "/" . Config::get('sfm.dir') . $dir . "/" . $new_name);
                } else
                {
                    $extension = File::extension(base_path() . "/" . Config::get('sfm.dir') . $dir . "/" . $file_to_rename);
                    $new_name = Str::slug(str_replace($extension, '', $new_name)) . "." . $extension;

                    if (@getimagesize(base_path() . "/" . Config::get('sfm.dir') . $dir . "/" . $file_to_rename))
                    {
                        File::move(base_path() . "/" . Config::get('sfm.dir') . $dir . "/.thumbs/" . $file_to_rename,
                            base_path() . "/" . Config::get('sfm.dir') . $dir . "/.thumbs/" . $new_name);
                    }

                    File::move(base_path() . "/" . Config::get('sfm.dir') . $dir . "/" . $file_to_rename,
                        base_path() . "/" . Config::get('sfm.dir') . $dir . "/" . $new_name);

                    return "OK";
                }
            }
        }

    }
}
