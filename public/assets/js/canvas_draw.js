$(function () {

    var canvas, conteadding;
    var savedImage;
    var interval = 10;
    var interval_value = 0;
    var canvas_path;
    var width_line;
    var color_line;
    var shape_line = 'round';

    $("#custom").spectrum({
        color: "#f00",
        showInput: true,
        change: function(color) {
            change_brush_color(color);
        }
    });

    change_canvas_path($('#canvas_path').text());
    change_brush_width($('#width_pencil_value').val());
    change_brush_color($('#custom').spectrum('get'));

    function init() {

        canvas = document.getElementById('conv');

        if (!canvas) {
            alert('Ошибка! Canvas элемент не найден!');
            return;
        }

        if (!canvas.getContext) {
            alert('Ошибка: canvas.getContext не существует!');
            return;
        }


        context = canvas.getContext('2d');
        if (!context) {
            alert('Ошибка: getContext! не существует');
            return;
        }

        tool = new Tool_pencil();
        canvas.addEventListener('mousedown', ev_canvas, false);
        canvas.addEventListener('mousemove', ev_canvas, false);
        canvas.addEventListener('mouseup', ev_canvas, false);
        canvas.addEventListener('mouseover', ev_canvas, false);
        canvas.addEventListener('click', ev_canvas, false);
    }

    function Tool_pencil() {
        var tool = this;
        this.started = false;

        this.click = function (ev) {
            send_message_socet_set();
        };

        this.mousedown = function (ev) {
            savedImage = canvas.toDataURL("image/png");
            tool.started = true;
            context.beginPath();
            context.moveTo(ev._x, ev._y);
            context.lineTo(ev._x, ev._y);
            context.lineCap = shape_line;
            context.strokeStyle = color_line;
            context.lineJoin = 'round';
            context.lineWidth = width_line;
            context.stroke();
        };

        this.mousemove = function (ev) {
            if (tool.started) {

                context.lineTo(ev._x, ev._y);
                // context.setLineDash([5, 15]);
                context.lineCap = shape_line;
                context.strokeStyle = color_line;
                context.lineJoin = 'round';
                context.lineWidth = width_line;
                context.stroke();

                if (interval_value === interval) {
                    send_message_socet_set();
                    interval_value = 0;
                } else {
                    interval_value++;
                }
            }
        };

        this.mouseup = function (ev) {
            if (tool.started) {
                tool.mousemove(ev);
                tool.started = false;
            }
        };

        this.mouseover = function (ev) {
            if (tool.started) {
                send_message_socet_set();
                tool.started = false;
            }
        };
    }

    function ev_canvas(ev) {
        if (ev.layerX || ev.layerX === 0) {
            ev._x = ev.layerX;
            ev._y = ev.layerY;
        } else if (ev.offsetX || ev.offsetX === 0) {
            ev._x = ev.offsetX;
            ev._y = ev.offsetY;
        }

        var func = tool[ev.type];
        if (func) {
            func(ev);
        }
    }

    setTimeout(function () {

    }, 1000);

    init();
    ws = new WebSocket("ws://127.0.0.1:2346");

    ws.onopen = function (event) {
        var message = '{"action": "get", "img": "' + canvas_path + '"}';
        ws.send(message);
    };

    ws.onmessage = function (e) {

        var image = new Image();

        if (e.data !== 'file_not_found') {
            var obj = $.parseJSON(e.data);
            var currentroom = 'public/image_room/' + document.title + '.txt';

            if (currentroom === obj.room)
                image.src = obj.img;
        } else {
            canvas.style.display = "none";
            $('#er404').show();
        }

        image.onload = function () {
            context.drawImage(image, 0, 0);
        };

    };

    function send_message_socet_set() {
        var d = canvas.toDataURL("image/png");
        var message = '{"action": "set","room":"' + canvas_path + '", "img": "' + d + '"}';
        ws.send(message);
    }

    $('body').keydown(function (eventObject) {
        if (eventObject.which === 90) {
            var image = new Image();
            image.src = savedImage;
            image.onload = function () {
                context.drawImage(image, 0, 0);
                send_message_socet_set();
            };
        }
    });

    function change_brush_color(color) {
        color_line = color.toHexString();
    }

    function change_canvas_path(path) {
        canvas_path = path;
    }

    function change_brush_width(wd) {
        width_line = wd;
    }

    $(document).on('click', '.number-spinner button', function () {
        var btn = $(this),
            oldValue = btn.closest('.number-spinner').find('input').val().trim(),
            newVal = 0;

        if (btn.attr('data-dir') === 'up') {
            newVal = parseInt(oldValue) + 1;
        } else {
            if (oldValue > 1) {
                newVal = parseInt(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        btn.closest('.number-spinner').find('input').val(newVal);
        change_brush_width(newVal);
    });

    $('#width_pencil_value').on("change", function () {
        change_brush_width($(this).val());
    });

    $('.change_brush_arc').on('click', function (evt) {
        evt.preventDefault();
        shape_line = 'round';
    });

    $('.change_brush_square').on('click', function (evt) {
        evt.preventDefault();
        shape_line = 'square';
    });
});