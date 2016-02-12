<div class="container">
    @if((sizeof($file_info) > 0) || (sizeof($directories) > 0))
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>{!! Lang::get('filemanager::sfm.item') !!}</th>
                <th>{!! Lang::get('filemanager::sfm.size') !!}</th>
                <th>{!! Lang::get('filemanager::sfm.type') !!}</th>
                <th>{!! Lang::get('filemanager::sfm.modified') !!}</th>
                <th>{!! Lang::get('filemanager::sfm.action') !!}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($directories as $key => $dir)
                <tr>
                    <td>
                        <i class="fa fa-folder-o"></i>
                        <a id="large_folder_{{ $key }}" href="javascript:clickFolder('large_folder_{{ $key }}',1)"
                           data-id="{{ $dir }}">
                            {!! basename($dir) !!}
                        </a>
                    </td>
                    <td></td>
                    <td>{!! Lang::get('filemanager::sfm.folder') !!}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach

            @foreach($file_info as $file)
                <tr>
                    <td>
                        <i class="fa">
                            <img id="{!! $file['name'] !!}"
                                 src="{{ asset('vendor/filemanager/img/ext/16/' . $file['icon']) }}?r={{ str_random(40) }}"
                                 alt="">
                        </i>
                        <a href="javascript:useFile('{{ $file['basename'] }}')">
                            {!! basename($file['name']) !!}
                        </a>
                    </td>
                    <td>
                        {!! $file['size'] !!}
                    </td>
                    <td>
                        {!! $file['type'] !!}
                    </td>
                    <td>
                        {!! date("Y-m-d h:m", $file['created']) !!}
                    </td>
                    <td>
                        <a href="javascript:rename('{{ $file['basename'] }}')">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="javascript:trash('{{ $file['basename'] }}')">
                            <i class="fa fa-trash fa-fw"></i>
                        </a>
                        @if($file['image'])
                        <a href="javascript:cropImage('{{ $file['basename'] }}')">
                            <i class="fa fa-crop fa-fw"></i>
                        </a>
                        <a href="javascript:resizeImage('{{ $file['basename'] }}')">
                            <i class="fa fa-arrows fa-fw"></i>
                        </a>
                        @endif
                        {{--<a href="javascript:notImp()">--}}
                            {{--<i class="fa fa-rotate-left fa-fw"></i>--}}
                        {{--</a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @else
        <div class="col-md-12">
            <p>{!! Lang::get('filemanager::sfm.empty_folder') !!}</p>
        </div>
    @endif

</div>
