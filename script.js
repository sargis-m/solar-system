$(document).ready(function () {
    var data = [['mercury', 0], ['venera', 0], ['earth', 0], ['mars', 0], ['yupiter', 0], ['saturn', 0], ['uran', 0], ['neptun', 0], ['pluton', 0], ['moon', 0]];

    function send() {
        $.ajax({
            type: 'GET',
            url: "data.php",
            data: {data: data},
            success: function (d) {
                var a = JSON.parse(d);
                data=[];
                for (var i = 0; i < a.length; i++) {
                    $('#' + a[i].name).css({top: a[i].y - a[i].planet_radius});
                    $('#' + a[i].name).css({left: a[i].x - a[i].planet_radius});
                    data.push([a[i].name, a[i].angle]);
                }
            }
        });
    }

    setInterval(send, 50);
});
