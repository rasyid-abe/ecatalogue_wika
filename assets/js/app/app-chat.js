define([
     "jQuery",
     "bootstrap4",
    "datatables",
    "datatablesBootstrap",
    "sidebar",
    ], function (
    $,
    bootstrap4,
    datatables,
    datatablesBootstrap,
    sidebar,
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initEvent();
            $(".loadingpage").hide();
        },
        initChat : function()
        {
            var socket = io($('#http_host').val());
            var user_id = $('#user_id').val();
            var nama = $('#nama').val();
            var room = $('#room_chat_id').val();
            var role = 'user';

            //console.log(socket);
            socket.emit('login', {user_id: user_id, role: role, nama : nama});
            socket.emit('subscribe', {room: room, user_id : user_id, nama : nama});

            $( window ).on('unload',function() {
                socket.emit('unsubscribe', {room: room});
            });

            $('#btn-send').on('click', function(){
                if ($('#message').val() == '')
                {
                    return false
                }

                $.ajax({
                    url : App.baseUrl + 'chat/insert_chat',
                    type : 'POST',
                    dataType : 'json',
                    data : {
                        room_chat_id : room,
                        sender : 'user',
                        chat_contenct : $('#message').val(),
                    },
                    success : function(result)
                    {
                        if (result.status == true)
                        {   if(socket.connected == true)
                            {
                                socket.emit('send', { room: room, message: $('#message').val(), nama:nama});
                            }
                            else
                            {
                                var html = $("#show-message-as-sender");

                                var $html = $(html.html());


                                $html.find(".time_date").text(App.get_waktu_sekarang());
                                $html.find(".time_date").addClass('right')
                                $html.find(".isi_pesan").html($('#message').val());

                                // console.log(msg);
                                $('.msg_history').append($html);

                                scrollToBottom($('.msg_history')[0]);
                            }
                            $('#message').val('');
                        }
                    }
                });
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
                                if(v.sender == 'user'){
                                    var html = $("#show-message-as-sender");
                                    var class_name = 'right';
                                }else{
                                    var class_name = 'left';
                                    var html = $("#show-message-as-other");
                                }

                                var $html = $(html.html());


                                $html.find(".time_date").text(v.created_at);
                                $html.find(".isi_pesan").html(v.chat_contenct);
                                $html.find(".time_date").addClass(class_name)
                                // console.log(msg);
                                $('.msg_history').prepend($html);
                                last_id = v.id;
                            });
                            this_beneran.attr('last-chat-id',last_id);
                            $('.msg_history').scrollTop(0);
                        }
                    }
                })


            });

            $('#message').on('keydown', function(e){
                if(e.keyCode == 13)
                {
                    $('#btn-send').trigger('click');
                }
            });

            socket.on('message', function(data){
                if(data.sender == user_id){
                    var html = $("#show-message-as-sender");
                    var class_name = 'right';
                }else{
                    var html = $("#show-message-as-other");
                    var class_name = 'left';
                }

                var $html = $(html.html());


                $html.find(".time_date").addClass(class_name);
                $html.find(".time_date").text(data.send_at);
                $html.find(".isi_pesan").html(data.message);
                if(data.is_join == true)
                {
                    $html.find(".isi_pesan").addClass('join');
                }

                // console.log(msg);
                $('.msg_history').append($html);

                scrollToBottom($('.msg_history')[0]);
            });

            scrollToBottom($('.msg_history')[0]);

            function scrollToBottom($dom)
            {
                $dom.scrollTop = $dom.scrollHeight;
            }

        },
        initEvent : function(){
            if($('#btn-send').length > 0 && $('#message').length >0)
            {
                App.initChat();
            }
        },
	}
});
