var app = require('express')();
var http = require('http').Server(app);
var socket = require('socket.io')(http);

var port = 3421;


socket.on('connection', function(client){
    var user_id = false;
    var role = false;
    var nama = false;
    client.on('login', function(data) {
        user_id = data.user_id;
        role = data.role;
        nama = data.nama
    });


    client.on('subscribe', function(data) {
        client.join(data.room);
        socket.in(data.room).emit('message', {
            sender: user_id,
            message: nama + " bergabung chat.",
            send_at: get_waktu_sekarang(),
            nama : nama,
            is_join : true
        });
    });

    // note http://stackoverflow.com/questions/9418697/how-to-unsubscribe-from-a-socket-io-subscription

    client.on('unsubscribe', function(data) {

        socket.in(data.room).emit('message', {
            sender: user_id,
            message: nama + " meninggalkan chat.",
            send_at: get_waktu_sekarang(),
            nama : nama,
            is_join : true
        });
        client.leave(data.room);
    });

    client.on('send', function(data) {
        socket.in(data.room).emit('message', {
            sender: user_id,
            message: data.message,
            nama : data.nama,
            send_at: get_waktu_sekarang(),
            is_join : false
        });
    });
});

http.listen(port, function(){
    console.log('listening on *:'+port);
});

function get_waktu_sekarang()
{
    var waktu = '',
    date = new Date(),
    tahun = date.getFullYear(),
    bulan = date.getMonth(),
    tgl = date.getDate(),
    jam = date.getHours(),
    jam = jam > 9 ? jam : 0+jam,
    menit = date.getMinutes(),
    menit = menit > 9 ? menit : ('0'+menit),
    detik = date.getSeconds(),
    detik = detik > 9 ? detik : ('0'+detik);

    waktu = tgl + ' ' + nama_bulan(bulan) + ' ' + tahun + ' ' + jam + ':' + menit + ':'+ detik;
    return waktu;
}

function nama_bulan($index)
{
    $bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    return $bulan[$index];
}
