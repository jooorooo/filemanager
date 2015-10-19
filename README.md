# filemanager

### This package is functional, but is under active development.

A file upload/editor intended for use with [Laravel 5](http://www.laravel.com/ "Title") and [CKEditor](http://ckeditor.com/).

## Rationale

This package is written specifically for Laravel 5, and will integrate seamlessly.
The package is based on [tsawler/laravel-filemanager](https://github.com/tsawler/laravel-filemanager).

## Requirements

1. This package only supports Laravel 5.x
1. Requires `"intervention/image": "2.*"`
1. Requires PHP 5.5 or later

## Installation

1. Installation is done through composer and packagist. From within your project root directory, execute the 
following command:

    `composer require simexis/filemanager`

1. Next run composer update to install the package from packagist:

    `composer update`

1. Add the ServiceProvider to the providers array in config/app.php:

    `'Simexis\Filemanager\FilemanagerServiceProvider',`

1. Publish the package's config file:

    `php artisan vendor:publish --tag=sfm_config`

1. Publish the package's public folder assets:

    `php artisan vendor:publish --tag=sfm_public`
    
1. If you want to customize the look & feel, then publish the package's views:

    `php artisan vendor:publish --tag=sfm_views`
    
1. By default, the package will use its own routes. If you don't want to use those routes, change this entry in config/sfm.php to false:

    ```php
        'use_package_routes' => true,
    ```
    
    You will, of course, have to set up your own routes.
    
1. If you don't want to use the default image/file directory or url, update the appropriate lines in config/sfm.php:

    ```php
        'images_dir'         => 'public/vendor/filemanager/images/',
        'images_url'         => '/vendor/filemanager/images/',
        'files_dir'          => 'public/vendor/filemanager/files/',
        'files_url'          => '/vendor/filemanager/files/',
    ```
    
1. Ensure that the files & images directories are writable by your web serber

1. In the view where you are using a CKEditor instance, use the file uploader by initializing the
CKEditor instance as follows:

    ```javascript
        <script>
            CKEDITOR.replace( 'editor', {
                filebrowserImageBrowseUrl: '/filemanager?type=Images',
                filebrowserBrowseUrl: '/filemanager?type=Files'
            });
        </script>
    ```
    
    Here, "editor" is the id of the textarea you are transforming to a CKEditor instance. Note that if
    you are using a custom route you will have to change `/filemanager?type=Images` to correspond
    to whatever route you have chosen. Be sure to include the `?type=Images` parameter.
    
    
## Security

It is important to note that if you use your own routes __you must protect your routes to Laravel-Filemanager in order to prevent
unauthorized uploads to your server__. Fortunately, Laravel makes this very easy.

If, for example, you want to ensure that only logged in users have the ability to access the Laravel-Filemanager, 
simply wrap the routes in a group, perhaps like this:

    Route::group(array('middleware' => 'auth', 'namespace' => 'Simexis\Filemanager\controllers'), function () // make sure authenticated
	{

		// Show SFM
		Route::get('/filemanager', ['as' => 'filemanager.show', 'uses' => 'SfmController@show']);


		// upload
		Route::any('/filemanager/upload', ['as' => 'filemanager.upload', 'uses' => 'UploadController@upload']);

		// list images & files
		Route::get('/filemanager/jsonimages', ['as' => 'filemanager.images', 'uses' => 'ItemsController@getImages']);
		Route::get('/filemanager/jsonfiles', ['as' => 'filemanager.files', 'uses' => 'ItemsController@getFiles']);

		// folders
		Route::get('/filemanager/newfolder', ['as' => 'filemanager.newfolder', 'uses' => 'FolderController@getAddfolder']);
		Route::get('/filemanager/deletefolder', ['as' => 'filemanager.deletefolder', 'uses' => 'FolderController@getDeletefolder']);
		Route::get('/filemanager/folders', ['as' => 'filemanager.folders', 'uses' => 'FolderController@getFolders']);

		// crop
		Route::get('/filemanager/crop', ['as' => 'filemanager.crop', 'uses' => 'CropController@getCrop']);
		Route::get('/filemanager/cropimage', ['as' => 'filemanager.cropimage', 'uses' => 'CropController@getCropimage']);

		// rename
		Route::get('/filemanager/rename', ['as' => 'filemanager.rename', 'uses' => 'RenameController@getRename']);

		// scale/resize
		Route::get('/filemanager/resize', ['as' => 'filemanager.resize', 'uses' => 'ResizeController@getResize']);
		Route::get('/filemanager/doresize', ['as' => 'filemanager.doresize', 'uses' => 'ResizeController@performResize']);

		// download
		Route::get('/filemanager/download', ['as' => 'filemanager.download', 'uses' => 'DownloadController@getDownload']);

		// delete
		Route::get('/filemanager/delete', ['as' => 'filemanager.delete', 'uses' => 'DeleteController@getDelete']);

	});
    
This approach ensures that only authenticated users have access to the Laravel-Filemanager. If you are
using Middleware or some other approach to enforce security, modify as needed.
    
## License

This package is released under the terms of the [MIT License](http://opensource.org/licenses/MIT).

The MIT License (MIT)

Copyright (c) 2015 Trevor Sawler

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
