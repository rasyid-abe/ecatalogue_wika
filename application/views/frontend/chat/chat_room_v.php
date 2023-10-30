<style media="screen">

</style>
<div class="modal fade" id="forecastexcel" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload File</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formimp" method="post" enctype="multipart/form-data" action="<?php echo base_url('chat/import_file') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" class="form-control" name="import_file" id="import_file" accept=".pdf" />
                        <input type="hidden" id="room_chat_id2" name="room_chat_id2" value='<?= $room_chat_id ?>'>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="container">
    <h3 class=" text-center pad-30"><?= $nama_vendor ?></h3>
    <div class="messaging">
        <div class="box-white inbox_msg">
            <div class="mesgs">
                <?php
                if(!(empty($history_chat)))
                {
                    $last_id = $history_chat[0]->id;
                    ?>
                    <div class="row pad-15">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-blue a-refresh" last-chat-id="<?= $last_id ?>">
                                <i class="fa fa-refresh"></i> Load More
                            </button>
                        </div>
                    </div>
                    <?php
                }
                 ?>
                <div class="msg_history">
                    <?php
                    foreach ($history_chat as $k => $v)
                    {
                        if ($k == 0)
                        {
                            ?>

                            <?php
                        }
                        if($v->sender == 'vendor')
                        {
                            ?>
                            <div class="incoming_msg">
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p class="isi_pesan white-bubble">
                                            <?php
                                            if($v->tipe==0)
                                                echo $v->chat_contenct; 
                                            else
                                            { ?>
                                                <a href="<?php echo base_url() ?>pdf/chat/<?= $v->chat_contenct ?>" download>
                                                <?= $v->chat_contenct ?>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                        <span class="time_date"><?= tgl_indo($v->created_at, TRUE) ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="outgoing_msg">
                                <div class="sent_msg">
                                    <p class="isi_pesan blue-bubble">
                                        <?php
                                        if($v->tipe==0)
                                            echo $v->chat_contenct; 
                                        else
                                        { ?>
                                            <a style="color: #000000" href="<?php echo base_url() ?>pdf/chat/<?= $v->chat_contenct ?>" download>
                                            <?= $v->chat_contenct ?>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </p>
                                    <span class="time_date right"><?= tgl_indo($v->created_at, TRUE) ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    }
                     ?>
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" class="write_msg" id="message" placeholder="Type a message" />
                        <button type="button" class="msg_file_btn" data-toggle="modal" aria-hidden="true" data-target="#forecastexcel"><i class='fa fa-file'></i></button>
                        <button class="msg_send_btn" type="button" id="btn-send"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="http_host" value='//<?php echo $_SERVER['HTTP_HOST']; ?>:3421'>
<input type="hidden" id="user_id" value='<?= $users->id ?>'>
<input type="hidden" id="nama" value='<?= $users->first_name ?>'>
<input type="hidden" id="room_chat_id" value='<?= $room_chat_id ?>'>

<script type="template" id="show-message-as-other">
    <div class="incoming_msg">
        <div class="received_msg">
            <div class="received_withd_msg">
                <p class="isi_pesan">We work directly with our designers and suppliers,
                    and sell direct to you, which means quality, exclusive
                    products, at a price anyone can afford.</p>
                <span class="time_date"> 11:01 AM    |    Today</span>
            </div>
        </div>
    </div>
</script>

<script type="template" id="show-message-as-sender">
    <div class="outgoing_msg">
        <div class="sent_msg">
            <p class="isi_pesan">Apollo University, Delhi, India Test</p>
            <span class="time_date"> 11:01 AM    |    Today</span>
        </div>
    </div>
</script>

<script src="//cdn.socket.io/socket.io-1.2.0.js"></script>
<script data-main="<?php echo base_url()?>assets/js/main/main-chat" src="<?php echo base_url()?>assets/js/require.js"></script>
<script>


</script>
