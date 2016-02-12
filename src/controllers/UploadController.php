<?php namespace Simexis\Filemanager\controllers;

use Lang;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * Class UploadController
 * @package Simexis\Filemanager\controllers
 */
class UploadController extends Controller {


    /**
     * Upload an image/file and (for images) create thumbnail
     *
     * @param UploadRequest $request
     * @return string
     */
    public function upload()
    {
        // sanity check
        if ( ! Input::hasFile('file_to_upload') && ! Input::hasFile('upload'))
        {
            // there ws no uploded file
            return Lang::get('filemanager::sfm.select_file');
            exit;
        }

        $file = Input::hasFile('file_to_upload') ? Input::file('file_to_upload') : Input::file('upload');
        $working_dir = Input::get('working_dir');
        $destinationPath = base_path() . "/" . Config::get('sfm.dir');

        if (strlen($working_dir) > 1)
        {
            $destinationPath .= $working_dir . "/";
        }

        $filename = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());

        if(is_array(Config::get('sfm.allow')) && count($allow = Config::get('sfm.allow'))) {
            if(!in_array($extension, $allow))
                return Lang::get('filemanager::sfm.file_not_allowed');
        }

        $new_filename = Str::slug(str_replace($extension, '', $filename)) . "." . $extension;

        if (!File::exists($destinationPath . "/.thumbs"))
        {
            File::makeDirectory($destinationPath . "/.thumbs");
        }

        $file->move($destinationPath, $new_filename);

        if(@getimagesize($destinationPath . $new_filename)) {
            $thumb_img = Image::make($destinationPath . $new_filename);
            $thumb_img->fit(200, 200)
                ->save($destinationPath . "/.thumbs/" . $new_filename);
            unset($thumb_img);
        }

        if(Input::hasFile('upload')) {
            $html = '<a href="javascript:void(0)" onclick="parent.CKEDITOR.tools.callFunction(0, \''.$working_dir.'/'.$new_filename.'\')">' . $filename . '</a>';
            exit($html);
        }

        return "OK";

    }

}
