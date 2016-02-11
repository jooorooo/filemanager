<?php
Route::group(array('middleware' => config('sfm.middleware'), 'namespace' => 'Simexis\Filemanager\controllers'), function () // make sure authenticated
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