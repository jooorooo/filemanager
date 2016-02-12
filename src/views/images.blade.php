<div class="container">
    <div class="row">

        @if((sizeof($files) > 0) || (sizeof($directories) > 0))

            @foreach($directories as $key => $dir)
                <div class="col-sm-6 col-md-2">
                    <div class="thumbnail text-center" data-id="{{ basename($dir) }}">
                        <a id="large_folder_{{ $key }}" data-id="{{ $dir }}" onclick="clickFolder('large_folder_{{ $key }}',1)" class="folder-icon pointer">
                            <img src="{{ url('vendor/filemanager/img/folder.jpg') }}">
                        </a>
                    </div>
                    <div class="caption text-center">
                        <div class="btn-group">
                            <button type="button" onclick="clickFolder('large_folder_{{ $key }}',1)"
                                    class="btn btn-default btn-xs">
                                {!! str_limit(basename($dir), $limit = 10, $end = '...') !!}
                            </button>
                            <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown"
                                    aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:rename('{!! basename($dir) !!}')">{!! Lang::get('filemanager::sfm.rename') !!}</a></li>
                                <li><a href="javascript:trash('{!! basename($dir) !!}')">{!! Lang::get('filemanager::sfm.delete') !!}</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            @endforeach

            @foreach($files as $key => $file)

                <div class="col-sm-6 col-md-3 img-row">

                    <div class="thumbnail thumbnail-img" data-id="{{ $file['basename'] }}" id="img_thumbnail_{{ $key }}">
                        @if($file['image'])
                        <img id="{!! $file['name'] !!}"
                             src="{{ asset($dir_location . $base . '/.thumbs/' . $file['basename']) }}?r={{ str_random(40) }}"
                             alt="">
                        @else
                            <img id="{!! $file['name'] !!}"
                                 src="{{ asset('vendor/filemanager/img/ext/256/' . $file['icon']) }}?r={{ str_random(40) }}"
                                 alt="">
                        @endif
                    </div>

                    <div class="caption text-center">
                        <div class="btn-group ">
                            <button type="button" onclick="useFile('{!! $file['basename'] !!}')" class="btn btn-default btn-xs">
                                {!! str_limit($file['basename'], $limit = 10, $end = '...') !!}
                            </button>
                            <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown"
                                    aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:rename('{!! $file['basename'] !!}')">{!! Lang::get('filemanager::sfm.rename') !!}</a></li>
                                @if($file['image'])
                                <li><a href="javascript:fileView('{!! $file['basename'] !!}')">{!! Lang::get('filemanager::sfm.view') !!}</a></li>
                                @endif
                                <li><a href="javascript:download('{!! $file['basename'] !!}')">{!! Lang::get('filemanager::sfm.download') !!}</a></li>
                                @if($file['image'])
                                <li class="divider"></li>
                                {{--<li><a href="javascript:notImp()">Rotate</a></li>--}}
                                <li><a href="javascript:resizeImage('{!! $file['basename'] !!}')">{!! Lang::get('filemanager::sfm.resize') !!}</a></li>
                                <li><a href="javascript:cropImage('{!! $file['basename'] !!}')">{!! Lang::get('filemanager::sfm.crop') !!}</a></li>
                                @endif
                                <li class="divider"></li>
                                <li><a href="javascript:trash('{!! $file['basename'] !!}')">{!! Lang::get('filemanager::sfm.delete') !!}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            @endforeach

        @else
            <div class="col-md-12">
                <p>{!! Lang::get('filemanager::sfm.empty_folder') !!}</p>
            </div>
        @endif

    </div>
</div>
