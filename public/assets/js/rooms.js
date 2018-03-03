
$(function () {

    $('#field_draw').hide();

    $('.rooms').on("click", function (evt) {
        evt.preventDefault();

        if ($('#user_name').text() !== 'undefined user '){
            $('#field_draw').show();
            $('#title_room_panel').show();
            var link = $(evt.target);
            resetLinks();
            link.removeClass('no_active');
            link.addClass('active');
            $('#title_room').text(link.text());
            change_title_canvas(link.text());
            reload_iframe();
        }

    });

    $('#add_room').click(function (evt) {
        $(arguments).get(0).preventDefault();
        $('#create_form').show();
        $('#room_name').focus();
        $('#add_room').hide();
    });

    $('#delete_room_btn').click(function (evt) {
        $(arguments).get(0).preventDefault();

        var getUrl = 'http://drawingrooms.loc/rooms/delete';

        $.ajax({
            url: getUrl,
            type: "POST",
            dataType: "json",
            data: {
                "room_name": $('#title_room').text().trim()
            },
            async: false,
            success: function (data) {}
        });

        location.reload();
    });

    $('#create_form').submit(function (evt) {

        var getUrl = 'http://drawingrooms.loc/rooms/add';

        $.ajax({
            url: getUrl,
            type: "POST",
            dataType: "json",
            data: {
                "room_name": $('#room_name').val().trim()
            },
            async: false,
            success: function (data) {}
        });

        location.reload();
        return false;
    });

    function resetLinks() {
        var link = $('.rooms.active');
        link.removeClass('active');
        link.addClass('no_active');
    }

    function reload_iframe() {
        var ifr = $('#field_draw');
        ifr.attr('src', function (i,val) {return val});
    }

    function change_title_canvas(title) {
        var path = $('#iframe_canvas_title');
        var fullPath = path.text() + '?canvas_title=' + title.trim();
        var ifr = $('#field_draw');
        ifr.attr('src', fullPath);
    }
});
