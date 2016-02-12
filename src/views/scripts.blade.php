<script type="text/template" class="image-template-filemanager">
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="thumbnail">
            <img data-src="holder.js/100px200?auto=yes" class="holderjs">
            <div class="caption text-center">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary button-upload">@lang('filemanager::sfm.choose_file')</button>
                    <button type="button" class="btn btn-danger button-clear">@lang('filemanager::sfm.clear')</button>
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<script type="text/template" class="file-template-filemanager">
    <span class="input-group-btn">
        <button type="button" class="btn btn-primary button-upload">@lang('filemanager::sfm.choose_file')</button>
        <button type="button" class="btn btn-danger button-clear">@lang('filemanager::sfm.clear')</button>
    </span>
</script>
<script src="{{ asset('vendor/filemanager/js/holder.min.js') }}"></script>
<script type="text/javascript">
window.useFile = function(num, file) {
    var holder = $('#filemanager-holder-' + num),
        input = holder.find('.file-input'),
        is_image = input.hasClass('event-image-input');
    input.val(file)
    console.log(holder, input, is_image)
    if(is_image) {
        holder.find('.holderjs').attr('src', file);
    }
    $('#modal-open-filemanager').modal('hide');
}
if(jQuery) {
    var last_opened = null;
    $('.event-image-input, .event-file-input').each(function(num) {
        var input = $(this),
            is_image = input.hasClass('event-image-input'),
            wrap = input.wrap(is_image ? '<div class="filemanager-selector filemanager-image-selector"></div>':'<div class="filemanager-selector filemanager-file-selector"><div class="input-group col-xs-12"></div></div>').closest('.filemanager-selector'),
            src = input.addClass(is_image ? 'hide hidden-image-input file-input' : 'file-input')
                .attr('readonly', true)
                .after($(is_image ? '.image-template-filemanager' : '.file-template-filemanager').html())
                .append(function() {
                    Holder.run({
                        images: wrap.find('.holderjs').toArray()
                    });
                })
                .val();
        wrap.attr('id', 'filemanager-holder-' + num).find('.button-upload').off('.file-upload').on('click.file-upload', function() {
            var modal = $('#modal-open-filemanager');
                modal.find('.modal-dialog, .modal-content').css({
                            width: window.innerWidth- parseInt(window.innerWidth/10),
                            height: window.innerHeight - parseInt(window.innerHeight/10)
                        });
            if(last_opened !== is_image) {
                modal.find('iframe').attr('src', (is_image ? '{!! route('filemanager.show', ['filter' => 'images','num' => 'NUMBER', 'inline' => 1]) !!}' : '{!! route('filemanager.show', ['num' => 'NUMBER', 'inline' => 1]) !!}').replace('NUMBER', num));
                last_opened = is_image;
            }
            modal.modal('show');
        });
        wrap.find('.button-clear').off('.file-clear').on('click.file-clear', function() {
            input.val('');
            if(is_image) {
                Holder.run({
                    images: wrap.find('.holderjs').data('holderRendered', null).attr('src', 'holder.js/100px200?auto=yes').toArray()
                });
            }
        });
    });
}
</script>

<div class="modal fade" id="modal-open-filemanager" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <iframe frameborder="0" style="width:100%;height:100%" scrolling="no"></iframe>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->