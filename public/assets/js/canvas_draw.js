$(function () {
    var canvas, context, tool;
    var width_line = $('#width_brush').text();
    var color_line = $('#color_brush').text();
    var interval = 10;
    var interval_value = 0;

    function init () {

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
        canvas.addEventListener('mouseup',   ev_canvas, false);
        canvas.addEventListener('mouseover',   ev_canvas, false);
        canvas.addEventListener('click',   ev_canvas, false);
    }

    function Tool_pencil () {
        var tool = this;
        this.started = false;

        this.click = function (ev) {
            send_message_socet_set();
        };

        this.mousedown = function (ev) {
            context.beginPath();
            context.moveTo(ev._x, ev._y);
            tool.started = true;
        };

        this.mousemove = function (ev) {
            if (tool.started) {
                if (interval_value == interval) {
                    send_message_socet_set();
                    interval_value = 0;
                }
                else
                    interval_value++;
                context.lineTo(ev._x, ev._y);
                context.strokeStyle = color_line;
                context.lineWidth = width_line;
                context.stroke();
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

    function ev_canvas (ev) {
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

    init();
    ws = new WebSocket("ws://127.0.0.1:2346");

    ws.onopen= function (event) {
        var link = 'public/image_room/' + document.title + '.txt';
        var message = '{"action": "get", "img": "' + link + '"}';
        ws.send(message);
    };

    ws.onmessage = function(e) {

        var image = new Image();
        image.onload = function () {
            context.drawImage(image, 0, 0);
        };

        if (e.data !== 'file_not_found')
        {
            var obj = $.parseJSON(e.data);

            var currentroom = 'public/image_room/' + document.title + '.txt';

            if (currentroom === obj.room)
                image.src = obj.img;
        } else {
            canvas.style.display="none";
            $('#er404').show();
        }

    };

    function send_message_socet_set() {
        var d = canvas.toDataURL("image/png");
        var currentroom = 'public/image_room/' + document.title + '.txt';
        var message = '{"action": "set","room":"' + currentroom + '", "img": "' + d + '"}';
        ws.send(message);
    }

    $('#color_brush').bind('DOMSubtreeModified',function () {
        color_line = $(this).text();
    });

    $('#width_brush').bind('DOMSubtreeModified',function () {
        width_line = $(this).text();
    });
});