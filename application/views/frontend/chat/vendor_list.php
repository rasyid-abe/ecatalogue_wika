<style media="screen">
.btn-app {
border-radius: 3px;
position: relative;
padding: 15px 5px;
margin: 0 0 10px 10px;
min-width: 80px;
height: 60px;
text-align: center;
color: #666;
border: 1px solid #ddd;
background-color: #f4f4f4;
font-size: 12px;
}

.btn-app>.badge {
    position: absolute;
    top: -3px;
    right: -10px;
    font-size: 10px;
    font-weight: 400;
}
</style>
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url()?>home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Chat</li>
          </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box-white pad-15 full mbot-30">
                <p class="mbot-15 font-18">Riwayat Chat</p>
                <div class="table-responsive">
                    <table class="table table-cart">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Vendor</th>
                                <!-- <th width="10%">Last Chat</th> -->
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($list_vendor) && empty($list_vendor_tambahan))
                            {
                                ?>
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada chat</td>
                                </tr>
                                <?php
                            }
                            $no = 1;
                            foreach ($list_vendor as $k => $v)
                            {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $v->name ?></td>
                                    <!-- <td>20 Mei 2019</td> -->
                                    <td>
                                        <a href="<?= base_url()?>chat/find_room/<?= $v->vendor_id?>" class="btn btn-info btn-xs" target="_blank">
                                            <i class="fa fa-comment"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }

                            foreach ($list_vendor_tambahan as $k => $v)
                            {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $v->name ?></td>
                                    <!-- <td>20 Mei 2019</td> -->
                                    <td>
                                        <a href="<?= base_url()?>chat/find_room/<?= $v->vendor_id?>" class="btn btn-info btn-xs" target="_blank">
                                            <i class="fa fa-comment"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                             ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script data-main="<?php echo base_url()?>assets/js/main/main-chat" src="<?php echo base_url()?>assets/js/require.js"></script>
