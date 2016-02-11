<script type="text/template" class="image-template-filemanager">
<div class="row">
    <div class="col-xs-12 col-md-3">
        <div class="thumbnail">
            <img data-src="holder.js/100px200?auto=yes&text=Тук ще се зареди \n снимката" class="holderjs">
            <div class="caption text-center">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary">@lang('filemanager::sfm.choose_file')</button>
                    <button type="button" class="btn btn-danger">@lang('filemanager::sfm.clear')</button>
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<script type="text/template" class="file-template-filemanager">
    <span class="input-group-btn">
        <button type="button" class="btn btn-primary">@lang('filemanager::sfm.choose_file')</button>
        <button type="button" class="btn btn-danger">@lang('filemanager::sfm.clear')</button>
    </span>
</script>
<script src="{{ asset('vendor/filemanager/js/holder.min.js') }}"></script>
<script type="text/javascript">
if(jQuery) {
    var image_browse = '{{ route('filemanager.show', ['type' => 'Images']) }}';
    var file_browse = '{{ route('filemanager.show', ['type' => 'File']) }}';
    $('.event-image-input').each(function() {
        var input = $(this),
            src = input.wrap('<div class="filemanager-image-selector"></div>')
                .addClass('hide hidden-image-input')
                .attr('readonly', true)
                .val();
            input.after($('.image-template-filemanager').html())
                    .append(function() {
                        Holder.run({
                            images: $('.holderjs').toArray()
                        });
                    });

    });
    $('.event-file-input').each(function() {
        var input = $(this),
            path = input.wrap('<div class="filemanager-file-selector"><div class="input-group col-xs-12"></div></div>')
                    .addClass('file-input')
                    .attr('readonly', true)
                    .after($('.file-template-filemanager').html())
                    .val();

    });
}
</script>