<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Manager</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/filemanager/css/cropper.min.css">
    <link rel="stylesheet" href="/vendor/filemanager/css/sfm.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.css">
</head>
<body>
<div class="container">
    <div class="row fill">
        <div class="panel panel-primary fill">
            <div class="panel-heading">
                <h3 class="panel-title">{!! Lang::get('filemanager::sfm.title') !!}</h3>
            </div>
            <div class="panel-body fill">
                <div class="row fill">
                    <div class="wrapper fill">
                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 left-nav fill" id="sfm-leftcol">
                            <div id="tree1">
                            </div>
                            <a href="#!" id="add-folder" class="add-folder btn btn-default btn-xs"><i class="fa fa-plus"></i> {!! Lang::get('filemanager::sfm.new_folder') !!}</a>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 right-nav" id="right-nav">
                            <nav class="navbar navbar-default">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                                data-target="#bs-example-navbar-collapse-1">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div class="collapse navbar-collapse">
                                        <ul class="nav navbar-nav" id="nav-buttons">
                                            <li>
                                                <a href="#!" id="upload" data-toggle="modal" data-target="#uploadModal"><i
                                                            class="fa fa-upload"></i> {!! Lang::get('filemanager::sfm.upload') !!}</a>
                                            </li>
                                            <li>
                                                <a href="#!" class="thumbnail-display" id="thumbnail-display"><i
                                                            class="fa fa-picture-o"></i> {!! Lang::get('filemanager::sfm.thumbnails') !!}</a>
                                            </li>
                                            <li>
                                                <a href="#!" class="list-display" id="list-display"><i
                                                            class="fa fa-list"></i> {!! Lang::get('filemanager::sfm.list') !!}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>

                            @if ($errors->any())
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="{!! Lang::get('filemanager::sfm.close') !!}"><span aria-hidden="true">&times;</span></button>
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div id="content" class="row fill">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{!! Lang::get('filemanager::sfm.close') !!}"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{!! Lang::get('filemanager::sfm.upload_file') !!}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route' => 'filemanager.upload', 'role' => 'form', 'name' => 'uploadForm',
                'id' => 'uploadForm', 'method' => 'post', 'enctype' => 'multipart/form-data')) !!}
                <div class="form-group" id="attachment">
                    {!! Form::label('file_to_upload', Lang::get('filemanager::sfm.choose_file'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        <div class="input-group" style="width: 100%">
                            <input type="file" id="file_to_upload" name="file_to_upload">
                        </div>
                    </div>
                </div>
                {!! Form::hidden('working_dir', $working_dir, ['id' => 'working_dir']) !!}
                {!! Form::hidden('show_list', 0, ['id' => 'show_list']) !!}
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{!! Lang::get('filemanager::sfm.close') !!}</button>
                <button type="button" class="btn btn-primary" id="upload-btn">{!! Lang::get('filemanager::sfm.upload_file') !!}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fileViewModal" tabindex="-1" role="dialog" aria-labelledby="fileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{!! Lang::get('filemanager::sfm.close') !!}"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="fileLabel">{!! Lang::get('filemanager::sfm.view_file') !!}</h4>
            </div>
            <div class="modal-body" id="fileview_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{!! Lang::get('filemanager::sfm.close') !!}</button>
            </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="/vendor/filemanager/js/cropper.min.js"></script>
<script src="/vendor/filemanager/js/jquery.form.min.js"></script>
<script>
    $(document).ready(function () {
        // load folders
        $.ajax({
            type: "GET",
            dataType: "text",
            url: "{{ route('filemanager.folders') }}",
            data: "base={{ $working_dir }}",
            cache: false
        }).done(function (data) {
            $("#tree1").html(data);
        });
        loadImages();
        refreshFolders();
    });

    $("#upload-btn").click(function () {
        var options = {
            beforeSubmit:  showRequest,
            success:       showResponse
        };

        function showRequest(formData, jqForm, options) {
            $("#upload-btn").html('<i class="fa fa-refresh fa-spin"></i> {{ Lang::get('filemanager::sfm.uploading') }}');
            return true;
        }

        function showResponse(responseText, statusText, xhr, $form)  {
            $("#uploadModal").modal('hide');
            $("#upload-btn").html('{{ Lang::get('filemanager::sfm.upload_file') }}');
            if (responseText != "OK"){
                notify(responseText);
            }
            $("#file_to_upload").val('');
            loadImages();
        }

        $("#uploadForm").ajaxSubmit(options);
        return false;
    });

    function clickRoot() {
        $('.folder-item').removeClass('fa-folder-open').addClass('fa-folder');
        $("#working_dir").val('/');
        loadImages();
    }

    function clickFolder(x, y) {
        $('.folder-item').addClass('fa-folder');
        $('.folder-item').not("#folder_top > i").removeClass('fa-folder-open');
        if (y == 0) {
            if ($('#' + x + ' > i').hasClass('fa-folder')) {
                $('#' + x + ' > i').not("#folder_top > i").removeClass('fa-folder');
                $('#' + x + ' > i').not("#folder_top > i").addClass('fa-folder-open');
            } else {
                $('#' + x + ' > i').removeClass('fa-folder-open');
                $('#' + x + ' > i').addClass('fa-folder');
            }
        }
        $("#working_dir").val($('#' + x).data('id'));
        loadImages();
    }

    function download(x) {
        location.href = "{{ route('filemanager.download') }}?"
            + "dir="
            + $("#working_dir").val()
            + "&file="
            + x;
    }

    function loadImages() {
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "@if(request('filter')){{ route('filemanager.files', ['filter' => request('filter')]) }}@else{{ route('filemanager.files') }}@endif",
            data: {
                base: $("#working_dir").val(),
                show_list: $("#show_list").val()
            },
            cache: false
        }).done(function (data) {
            $("#content").html(data);
            $("#nav-buttons").removeClass("hidden");
            $(".dropdown-toggle").dropdown();
            refreshFolders();
        });
    }

    function trash(x) {
        bootbox.confirm("{{ Lang::get('filemanager::sfm.confirm_delete') }}", function (result) {
            if (result == true) {
                $.ajax({
                    type: "GET",
                    dataType: "text",
                    url: "{{ route('filemanager.delete') }}",
                    data: {
                        base: $("#working_dir").val(),
                        items: x
                    },
                    cache: false
                }).done(function (data) {
                    if (data != "OK") {
                        notify(data);
                    } else {
                        loadFiles();
                        loadImages();
                    }
                });
            }
        });
    }

    function loadFiles() {
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "{{ route('filemanager.folders') }}",
            data: {
                base: $("#working_dir").val(),
                show_list: $("#show_list").val()
            },
            cache: false
        }).done(function (data) {
            $("#tree1").html(data);
        });
    }

    function refreshFolders(){
        var wd = $("#working_dir").val();
        if (wd != "/") {
            $('#' + wd + '-folder').removeClass('fa-folder');
            $('#' + wd + '-folder').addClass('fa-folder-open');
        }
    }

    function cropImage(x) {
        $.ajax({
            type: "GET",
            dataType: "text",
            url: "{{ route('filemanager.crop') }}",
            data: "img="
            + x
            + "&dir=" + $("#working_dir").val(),
            cache: false
        }).done(function (data) {
            $("#nav-buttons").addClass('hidden');
            $("#content").html(data);
        });
    }

    function notImp() {
        bootbox.alert('Not yet implemented!');;
    }

    $("#add-folder").click(function () {
        bootbox.prompt("{{ Lang::get('filemanager::sfm.folder_name') }}", function (result) {
            if (result === null) {
            } else {
                $.ajax({
                    type: "GET",
                    dataType: "text",
                    url: "{{ route('filemanager.newfolder') }}",
                    data: {
                        name: result,
                        dir: $("#working_dir").val()
                    },
                    cache: false
                }).done(function (data) {
                    if (data == "OK") {
                        loadFiles();
                        loadImages();
                        refreshFolders();
                    } else {
                        notify(data);
                    }
                });
            }
        });
    });

    function useFile(file) {
        var path = $('#working_dir').val();

        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);
            return ( match && match.length > 1 ) ? match[1] : null;
        }

        var funcNum = getUrlParam('CKEditorFuncNum');
        if(funcNum) {
            if (path != '/') {
                window.opener.CKEDITOR.tools.callFunction(funcNum, '{{ \Config::get('sfm.url') }}' + path + "/" + file);
            } else {
                window.opener.CKEDITOR.tools.callFunction(funcNum, '{{ \Config::get('sfm.url') }}' + file);
            }
            window.close();
        } else if({{ (int)request('inline', 0) }}) {
            if (path != '/') {
                window.parent.useFile({{ (int)request('num', -1) }}, '{{ \Config::get('sfm.url') }}' + path + "/" + file);
            } else {
                window.parent.useFile({{ (int)request('num', -1) }}, '{{ \Config::get('sfm.url') }}' + file);
            }
        }
    }

    function rename(x) {
        bootbox.prompt({
            title: "{{ Lang::get('filemanager::sfm.rename_to') }}",
            value: x,
            callback: function (result) {
                if (result === null) {
                } else {
                    $.ajax({
                        type: "GET",
                        dataType: "text",
                        url: "{{ route('filemanager.rename') }}",
                        data: {
                            file: x,
                            dir: $("#working_dir").val(),
                            new_name: result
                        },
                        cache: false
                    }).done(function (data) {
                        if (data == "OK") {
                            loadImages();
                            loadFiles();
                        } else {
                            notify(data);
                        }
                    });
                }
            }
        });
    }

    function notify(x) {
        bootbox.alert(x);
    }

    function resizeImage(x) {
        $.ajax({
            type: "GET",
            dataType: "text",
            url: "{{ route('filemanager.resize') }}",
            data: "img="
            + x
            + "&dir=" + $("#working_dir").val(),
            cache: false
        }).done(function (data) {
            $("#nav-buttons").addClass('hidden');
            $("#content").html(data);
        });
    }

    $("#thumbnail-display").click(function () {
        $("#show_list").val(0);
        loadImages();
    });

    $("#list-display").click(function () {
        $("#show_list").val(1);
        loadImages();
    });

    function fileView(x){
        var rnd = makeRandom();
        $('#fileview_body').html(
                "<img class='img img-responsive center-block' src='{!! Config::get('sfm.url') !!}" + $("#working_dir").val() + "/" + x + "?id=" + rnd + "'>"
        );
        $('#fileViewModal').modal();
    }

    function makeRandom()
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 20; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }
</script>
</body>
</html>
