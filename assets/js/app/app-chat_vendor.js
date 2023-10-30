define([
     "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    sidebar,
    ) {
    return {
        table:null,
        init: function () {
            App.initEvent();
            $(".loadingpage").hide();
        },
        initEvent : function(){
            if($('#btn-send').length > 0 && $('#message').length >0)
            {
                App.initChat();
            }

            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang ditampilkan ",
                    "infoFiltered": "(pencarian dari _MAX_ total records)",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelum"
                    },
                },
                "processing": true,
                "serverSide": true,
                "searching": App.searchDatatable,
                "ajax":{
                    "url": App.baseUrl+"chat_vendor/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id", "class" : "text-center"  },
                    { "data": "user_name" },
                    { "data": "action" , "orderable"  : false },
                ]
            });
        },
        initChat : function()
        {
            var socket = io($('#http_host').val());
            var user_id = $('#user_id').val();
            var nama = $('#nama').val();
            var room = $('#room_chat_id').val();
            var role = 'vendor';

            socket.emit('login', {user_id: user_id, role: role, nama : nama});
            socket.emit('subscribe', {room: room, nama : nama, user_id : user_id});

            $( window ).on('unload',function() {
                socket.emit('unsubscribe', {room: room});
            });

            $('#btn-send').on('click', function(){
                if ($('#message').val() == '')
                {
                    return false
                }                

                $.ajax({
                    url : App.baseUrl + 'chat_vendor/insert_chat',
                    type : 'POST',
                    dataType : 'json',
                    data : {
                        room_chat_id : room,
                        sender : 'vendor',
                        chat_contenct : $('#message').val(),
                    },
                    success : function(result)
                    {
                        if (result.status == true)
                        {
                            if(socket.connected == true)
                            {
                                socket.emit('send', { room: room, message: $('#message').val(), nama:nama});
                            }
                            else
                            {
                                var html = $("#show-message-as-sender");

                                var $html = $(html.html());


                                $html.find(".time_date").removeClass('pull-left');
                                $html.find(".time_date").addClass('pull-right');
                                $html.find(".time_date").text(App.get_waktu_sekarang());
                                $html.find(".isi_pesan").html($('#message').val());

                                // console.log(msg);
                                $('.direct-chat-messages').append($html);

                                scrollToBottom($('.direct-chat-messages')[0]);
                            }
                            $('#message').val('');
                        }
                    }
                });
            });
            scrollToBottom($('.direct-chat-messages')[0]);
            $('#message').on('keydown', function(e){
                if(e.keyCode == 13)
                {
                    $('#btn-send').trigger('click');
                }
            });

            $('.a-refresh').on('click', function(){
                var last_chat_id = $(this).attr('last-chat-id');
                this_beneran = $(this);
                this_ele = $(this).parent().parent();
                $.ajax({
                    url : App.baseUrl + 'chat/get_chat_history',
                    type : 'POST',
                    dataType : 'json',
                    data : {
                        room_chat_id : room,
                        last_id : last_chat_id,
                    },
                    success : function(result)
                    {
                        if(result.data.length == 0)
                        {
                            //alert('ada?');
                            this_ele.remove();
                        }
                        else
                        {
                            var last_id = null;
                            $.each(result.data, function(k, v){
                                if(v.sender == 'vendor'){
                                    var html = $("#show-message-as-sender");
                                    var class_name_add = 'pull-right';
                                    var class_name_remove = 'pull-left';
                                }else{
                                    var class_name_add = 'pull-left';
                                    var class_name_remove = 'pull-right';
                                    var html = $("#show-message-as-other");
                                }
                                // var html = (v.sender == 'vendor') ? $("#show-message-as-sender") : $("#show-message-as-other");
                                var $html = $(html.html());


                                $html.find(".time_date").removeClass(class_name_remove);
                                $html.find(".time_date").addClass(class_name_add);
                                $html.find(".time_date").text(v.created_at);
                                $html.find(".isi_pesan").html(v.chat_contenct);


                                // console.log(msg);
                                $('.direct-chat-messages').prepend($html);
                                last_id = v.id;
                            });
                            this_beneran.attr('last-chat-id',last_id);
                            $('.direct-chat-messages').scrollTop(0);
                        }
                    }
                })


            });

            socket.on('message', function(data){
                // var html = (data.sender == user_id) ? $("#show-message-as-sender") : $("#show-message-as-other");
                if(data.sender == user_id){
                    var html = $("#show-message-as-sender");
                    var class_name_add = 'pull-right';
                    var class_name_remove = 'pull-left';
                }else{
                    var class_name_add = 'pull-left';
                    var class_name_remove = 'pull-right';
                    var html = $("#show-message-as-other");
                }
                var $html = $(html.html());


                $html.find(".time_date").removeClass(class_name_remove);
                $html.find(".time_date").addClass(class_name_add);
                $html.find(".time_date").text(data.send_at);
                $html.find(".isi_pesan").html(data.message);
                // console.log(data.is_join);
                if(data.is_join == true)
                {
                    $html.find(".isi_pesan").addClass('join');
                }

                $html.find(".nama_user").html(data.nama);

                // console.log(msg);
                $('.direct-chat-messages').append($html);

                scrollToBottom($('.direct-chat-messages')[0]);
            });

            function scrollToBottom($dom)
            {
                $dom.scrollTop = $dom.scrollHeight;
            }
        },
	}
});
