<section class="content-header">
 <h1>
   <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
   <small></small>
 </h1>
 <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">Chat
   </li>
 </ol>
</section>
<div class="modal fade" id="forecastexcel" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload File</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formimp" method="post" enctype="multipart/form-data" action="<?php echo base_url('chat_vendor/import_file') ?>">
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
<section class="content">
    <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $nama_user ?></h3>
        </div>
        <div class="box-body bg-chat">
            <?php
            if(!(empty($history_chat)))
            {
                $last_id = $history_chat[0]->id;
                ?>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-blue a-refresh" style="margin:15px 0" last-chat-id="<?= $last_id ?>">
                            <i class="fa fa-refresh"></i> Load More
                        </button>
                    </div>
                </div>
                <?php
            }
             ?>
            <div class="direct-chat-messages">
                <?php
                foreach ($history_chat as $k => $v)
                {
                    if($v->sender == 'vendor')
                    {
                        ?>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-text isi_pesan">
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
                            </div>
                             <div class="direct-chat-info clearfix">
                                <span class="direct-chat-timestamp pull-right time_date"><?= tgl_indo($v->created_at, TRUE) ?></span>
                            </div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="direct-chat-msg">
                            <div class="direct-chat-text isi_pesan">
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
                            </div>
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-timestamp pull-left time_date"><?= tgl_indo($v->created_at, TRUE) ?></span>
                            </div>
                        </div>
                        <?php
                    }
                }
                 ?>
            </div>
            <div class="box-footer">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Type Message ..." class="form-control no-border" id="message">
                  <span class="input-group-btn">
                        <button type="button" class="msg_file_btn" data-toggle="modal" data-target="#forecastexcel"><i class='fa fa-file'></i></button>
                        <button type="button" class="msg_send_btn" id="btn-send"><i class="fa fa-paper-plane-o"></i></button>
                  </span>
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="http_host" value='//<?php echo $_SERVER['HTTP_HOST']; ?>:3421'>
<input type="hidden" id="user_id" value='<?= $users->id ?>'>
<input type="hidden" id="nama" value='<?= $users->first_name ?>'>
<input type="hidden" id="room_chat_id" value='<?= $room_chat_id ?>'>

<script type="template" id="show-message-as-sender">
    <div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-timestamp pull-left time_date">23 Jan 2:05 pm</span>
        </div>
        <div class="direct-chat-text isi_pesan">
            You better believe it!
        </div>
    </div>
</script>

<script type="template" id="show-message-as-other">
    <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-timestamp pull-right time_date">23 Jan 5:37 pm</span>
        </div>
        <div class="direct-chat-text isi_pesan">
            Working  AdminLTE on a great Wanna join
        </div>
    </div>
</script>

<script src="//cdn.socket.io/socket.io-1.2.0.js"></script>
<script
 data-main="<?php echo base_url()?>assets/js/main/main-<?= $cont ?>"
 src="<?php echo base_url()?>assets/js/require.js">
</script>
