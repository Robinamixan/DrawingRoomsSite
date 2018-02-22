
$(function () {

    $('#field_draw').hide();

    $('.rooms').click(function (evt) {
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
        alert($('#title_room').text().trim());

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
        $('#field_draw').load(function () {
            var d = $(this).contents().find('title');
            d.text(title);
            change_brush_color($("#custom").spectrum("get"));
        });
    }

    function change_brush_color(color) {
        var h = $('#field_draw').contents().find('#color_brush');
        h.text(color.toHexString());
    }

    function change_width_color(wd) {
        var h = $('#field_draw').contents().find('#width_brush');
        h.text(wd);
    }

    $("#custom").spectrum({
        color: "#f00",
        change: function(color) {
            change_brush_color(color);
        }
    });

    $(document).on('click', '.number-spinner button', function () {
        var btn = $(this),
            oldValue = btn.closest('.number-spinner').find('input').val().trim(),
            newVal = 0;

        if (btn.attr('data-dir') == 'up') {
            newVal = parseInt(oldValue) + 1;
        } else {
            if (oldValue > 1) {
                newVal = parseInt(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        btn.closest('.number-spinner').find('input').val(newVal);
        change_width_color(newVal);
    });
});
