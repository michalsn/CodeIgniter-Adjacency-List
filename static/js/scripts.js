$(document).ready(function(){

    $(document).ajaxSend( function() {
        $("#loader").show();
    }).ajaxComplete( function(){
        $("#loader").hide();
    })

    if ($(".sortable").length > 0) {

        $('ol.sortable').nestedSortable({
            disableNesting: 'no-nest',
            forcePlaceholderSize: true,
            handle: '.icon-move',
            helper: 'clone',
            items: 'li',
            maxLevels: LIST_MAX_LEVELS,
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            update : function () {
                $.ajax({
                    type: 'post',
                    url: BASE_URL + 'index.php/al/reorder',
                    data: {
                        order : $(this).nestedSortable('serialize'),
                        csrf_test_name: $.cookie('csrf_cookie_name')
                        }
                });
            }
        });

        $(".delete").click(function(){
            var data_href = $(this).data('href');
            var data_name = $(this).data('name');
            var data_type = $(this).data('type');
            if (data_type == 'group') {
                $('.modal-body').html('<p>Do you really want to delete group: ' + data_name + '?</p>');
            } else {
                $('.modal-body').html('<p>Do you really want to delete item: ' + data_name + '?</p>');
            }
            $('.modal-footer').html('<a href="#" class="btn" data-dismiss="modal">Cancel</a><a href="' + data_href + '" class="btn btn-danger"><i class="icon-trash icon-white"></i> Delete</a>');
            $('#confirm-modal').modal('show')
            return false;
        });

        $('.sortable li div').on('mouseenter', function(){
            $('span', this).fadeIn(100);
        }).on('mouseleave', function(){
            $('span', this).fadeOut(100);
        });
    }

});
