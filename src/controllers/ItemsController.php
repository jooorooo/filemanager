<?php namespace Simexis\Filemanager\controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Simexis\Filemanager\Icons;

/**
 * Class ItemsController
 * @package Simexis\Filemanager\controllers
 */
class ItemsController extends Controller {

    public function getFiles($img = true) {
        if (Input::has('base') && strpos(Input::has('base'), '..') === false)
        {
            $files = File::files(base_path(Config::get('sfm.dir') . Input::get('base')));
            $all_directories = File::directories(base_path(Config::get('sfm.dir') . Input::get('base')));
        } else
        {
            $files = File::files(base_path(Config::get('sfm.dir')));
            $all_directories = File::directories(base_path(Config::get('sfm.dir')));
        }

        $filter_images = Input::get('filter') == 'images';

        $directories = [];

        foreach ($all_directories as $directory)
        {
            if (basename($directory) != ".thumbs")
            {
                $directories[] = basename($directory);
            }
        }

        $file_info = [];

        $finfo = new \finfo(FILEINFO_MIME);
        foreach ($files as $file)
        {
            $file_name = $file;

            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $is_image = in_array($ext, ['jpeg','jpg','png','gif']);

            if($filter_images && !$is_image)
                continue;

            $file_created = filemtime($file);

            $file_type = explode(';', $finfo->file($file))[0];
            $file_info[] = [
                'basename'=> basename($file_name),
                'name'    => $file_name,
                'size'    => $this->formatSize(filesize($file)),
                'created' => $file_created,
                'type'    => $file_type,
                'ext'     => $ext,
                'icon'    => Icons::getIcon($ext),
                'image'   => $is_image
            ];
        }

        $dir_location = Config::get('sfm.url');

        if (Input::get('show_list') == 1)
        {
            return View::make('filemanager::images-list')
                ->with('directories', $directories)
                ->with('base', Input::get('base'))
                ->with('file_info', $file_info)
                ->with('dir_location', $dir_location);
        } else
        {
            return View::make('filemanager::images')
                ->with('files', $file_info)
                ->with('directories', $directories)
                ->with('base', Input::get('base'))
                ->with('dir_location', $dir_location);
        }
    }

    private function formatSize($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }

}
