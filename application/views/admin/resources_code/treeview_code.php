<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
ul, #myUL {
  list-style-type: none;

}

.treeview {
    font-family:  Arial;
    font-size: 10pt;
}

.brdown {
    margin-top: -4px;
    margin-left: 38px;
}

#myUL {
  margin: 10px;
  padding: 0;
}

.crt {
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.crt::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.crt-down::before {
  -ms-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
}

.nst {
  display: none;
}

.active {
  display: block;
}

.thin{
    font-weight: normal !important;
}
</style>
<section class="content-header">
    <h1>
        <?= ucwords($page) ?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><?= ucwords('Kode Sumber Daya') ?></li>
        <li class="active"><?= ucwords($page) ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-6">
            <form class="" action="<?php echo base_url('resources_treeview/status_ids') ?>" method="post">
                <div class="box box-default color-palette-box" style="min-height: 608px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Treeview</h3>
                        <button type="submit" class="btn btn-xs btn-primary pull-right" id="treeAdd"><i class='fa fa-plus'></i> Tambah</button>
                    </div>
                    <div style="margin-left: 5px; width: 98%; display: block; padding: 5px; border-radius: 5px;" class="bg-info">
                        <span><strong>Last Update: </strong> <?php echo $lastupdate['activity'] ?></span>
                    </div>
                    <ul id="myUL" class="p-5 treeview">
                            <?php for ($i=0; $i < count($data); $i++) { ?>
                                <li>
                                    <?php $in = $this->session->userdata('arr_in'); if (!empty($in['code'])) { ?>
                                        <span class="crt <?= in_array(substr($data[$i]['code'], 0, 1), $in['scode']) ? 'crt-down' : '' ?>">
                                            <input type="checkbox" id="<?= $data[$i]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['code'] ?>" <?= in_array($data[$i]['code'], $in['code']) ? 'checked' : '' ?>>
                                            <label for="<?= $data[$i]['_id'] ?>"> <?= $data[$i]['code'] ?> - </label>
                                            <label class="thin <?= strlen($data[$i]['name']) > 70 ? 'brdown' : '' ?>" for="<?= $data[$i]['_id'] ?>"> <?= $data[$i]['name'] ?> </label>
                                        </span>
                                        <ul class="nst <?= in_array(substr($data[$i]['code'], 0, 1), $in['scode']) ? 'active' : '' ?>">
                                    <?php } else { ?>
                                        <span class="crt">
                                            <input type="checkbox" id="<?= $data[$i]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['code'] ?>">
                                            <label for="<?= $data[$i]['_id'] ?>"> <?= $data[$i]['code'] ?> - </label>
                                            <label class="thin <?= strlen($data[$i]['name']) > 70 ? 'brdown' : '' ?>" for="<?= $data[$i]['_id'] ?>"> <?= $data[$i]['name'] ?> </label>
                                        </span>
                                        <ul class="nst">
                                    <?php } ?>

                                        <?php if (count($data[$i]['child']) > 0): ?>
                                            <?php for ($j=0; $j < count($data[$i]['child']); $j++) { ?>
                                                <li>
                                                    <?php $in = $this->session->userdata('arr_in'); if (!empty($in['code'])) { ?>
                                                        <span class="crt <?= in_array(substr($data[$i]['child'][$j]['code'], 0, 2), $in['scode']) ? 'crt-down' : '' ?>">
                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['code']?>" <?= in_array($data[$i]['child'][$j]['code'], $in['code']) ? 'checked' : '' ?>>
                                                            <label for="<?= $data[$i]['child'][$j]['_id'] ?>"> <?= $data[$i]['child'][$j]['code']?> - </label>
                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['name']) > 62 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['_id'] ?>"> <?= $data[$i]['child'][$j]['name'] ?> </label>
                                                        </span>
                                                        <ul class="nst <?= in_array(substr($data[$i]['child'][$j]['code'], 0, 2), $in['scode']) ? 'active' : '' ?>">
                                                    <?php } else { ?>
                                                        <span class="crt">
                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['code']?>">
                                                            <label for="<?= $data[$i]['child'][$j]['_id'] ?>"> <?= $data[$i]['child'][$j]['code']?> - </label>
                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['name']) > 62 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['_id'] ?>"> <?= $data[$i]['child'][$j]['name'] ?> </label>
                                                        </span>
                                                        <ul class="nst">
                                                    <?php } ?>

                                                        <?php if (count($data[$i]['child'][$j]['child']) > 0): ?>
                                                            <?php for ($k=0; $k < count($data[$i]['child'][$j]['child']); $k++) { ?>
                                                                <li>
                                                                    <?php $in = $this->session->userdata('arr_in'); if (!empty($in['code'])) { ?>
                                                                        <span class="crt <?= in_array(substr($data[$i]['child'][$j]['child'][$k]['code'], 0, 3), $in['scode']) ? 'crt-down' : '' ?>">
                                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['child'][$k]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['child'][$k]['code'] ?>" <?= in_array($data[$i]['child'][$j]['child'][$k]['code'], $in['code']) ? 'checked' : '' ?>>
                                                                            <label for="<?= $data[$i]['child'][$j]['child'][$k]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['code'] ?> - </label>
                                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['child'][$k]['name']) > 54 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['child'][$k]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['name'] ?> </label>
                                                                        </span>
                                                                            <ul class="nst <?= in_array(substr($data[$i]['child'][$j]['child'][$k]['code'], 0, 3), $in['scode']) ? 'active' : '' ?>">
                                                                    <?php } else { ?>
                                                                        <span class="crt">
                                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['child'][$k]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['child'][$k]['code'] ?>">
                                                                            <label for="<?= $data[$i]['child'][$j]['child'][$k]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['code'] ?> - </label>
                                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['child'][$k]['name']) > 54 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['child'][$k]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['name'] ?> </label>
                                                                        </span>
                                                                        <ul class="nst">
                                                                    <?php } ?>

                                                                        <?php if (count($data[$i]['child'][$j]['child'][$k]['child']) > 0): ?>
                                                                            <?php for ($l=0; $l < count($data[$i]['child'][$j]['child'][$k]['child']); $l++) { ?>
                                                                                <li>
                                                                                    <?php $in = $this->session->userdata('arr_in'); if (!empty($in['code'])) { ?>
                                                                                        <span class="crt <?= in_array(substr($data[$i]['child'][$j]['child'][$k]['child'][$l]['code'], 0, 4), $in['scode']) ? 'crt-down' : '' ?>">
                                                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['code']?>" <?= in_array($data[$i]['child'][$j]['child'][$k]['child'][$l]['code'], $in['code']) ? 'checked' : '' ?>>
                                                                                            <label for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['code']?> - </label>
                                                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['child'][$k]['child'][$l]['name']) > 46 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['name'] ?> </label>
                                                                                        </span>
                                                                                        <ul class="nst <?= in_array(substr($data[$i]['child'][$j]['child'][$k]['child'][$l]['code'], 0, 4), $in['scode']) ? 'active' : '' ?>">
                                                                                    <?php } else { ?>
                                                                                        <span class="crt">
                                                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['code']?>">
                                                                                            <label for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['code']?> - </label>
                                                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['child'][$k]['child'][$l]['name']) > 46 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['name'] ?> </label>
                                                                                        </span>
                                                                                        <ul class="nst">
                                                                                    <?php } ?>

                                                                                        <?php if (count($data[$i]['child'][$j]['child'][$k]['child'][$l]['child']) > 0): ?>
                                                                                            <?php for ($m=0; $m < count($data[$i]['child'][$j]['child'][$k]['child'][$l]['child']); $m++) { ?>
                                                                                                <li>
                                                                                                    <?php $in = $this->session->userdata('arr_in'); if (!empty($in['code'])) { ?>
                                                                                                        <span class="crt <?= in_array(substr($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['code'], 0, 5), $in['code']) ? 'crt-down' : '' ?>">
                                                                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['code']?>" <?= in_array($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['code'], $in['code']) ? 'checked' : '' ?>>
                                                                                                            <label for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['code']?> - </label>
                                                                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['name']) > 38 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['name'] ?> </label>
                                                                                                        </span>
                                                                                                        <ul class="nst <?= in_array(substr($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['code'], 0, 4), $in['scode']) ? 'active' : '' ?>">
                                                                                                    <?php } else { ?>
                                                                                                        <span class="crt">
                                                                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['code']?>">
                                                                                                            <label for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['code']?> - </label>
                                                                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['name']) > 38 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['name'] ?> </label>
                                                                                                        </span>
                                                                                                        <ul class="nst">
                                                                                                    <?php } ?>

                                                                                                        <?php if (count($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child']) > 0): ?>
                                                                                                            <?php for ($n=0; $n < count($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child']); $n++) { ?>
                                                                                                                <li>
                                                                                                                    <?php $in = $this->session->userdata('arr_in'); if (!empty($in['code'])) { ?>
                                                                                                                        <span class="crt <?= in_array(substr($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['code'], 0, 5), $in['code']) ? 'crt-down' : '' ?>">
                                                                                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['code']?>" <?= in_array($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['code'], $in['code']) ? 'checked' : '' ?>>
                                                                                                                            <label for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['code']?> - </label>
                                                                                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['name']) > 30 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['name'] ?> </label>
                                                                                                                        </span>
                                                                                                                    <?php } else { ?>
                                                                                                                        <span class="crt">
                                                                                                                            <input type="checkbox" id="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['_id'] ?>" name="idsData[]" value="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['code']?>">
                                                                                                                            <label for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['code']?> - </label>
                                                                                                                            <label class="thin <?= strlen($data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['name']) > 30 ? 'brdown' : '' ?>" for="<?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['_id'] ?>"> <?= $data[$i]['child'][$j]['child'][$k]['child'][$l]['child'][$m]['child'][$n]['name'] ?> </label>
                                                                                                                        </span>
                                                                                                                    <?php } ?>
                                                                                                                    <!-- <ul class="nst"> -->
                                                                                                                </li>
                                                                                                            <?php } ?>
                                                                                                        <?php endif; ?>
                                                                                                    </ul>
                                                                                                </li>
                                                                                            <?php } ?>
                                                                                        <?php endif; ?>
                                                                                    </ul>
                                                                                </li>
                                                                            <?php } ?>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                </li>
                                                            <?php } ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <div class="box box-default color-palette-box" style="min-height: 608px;">
                <form class="" action="<?php echo base_url('resources_treeview/ids_remove') ?>" method="post">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabel View</h3>
                    <button type="submit" class="btn btn-xs btn-danger pull-right" id="treeDel"><i class='fa fa-trash'></i> Hapus</button>
                    <div class="btn btn-xs btn-info pull-right" id="export_treeview"><i class='fa fa-download'></i> Download PDF</div>
                </div>
                <div class="tabel-side" style="padding: 12px;">
                    <table class="table" id="table">
                    <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" id="checkAll"></th>
                            <th>Kode</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($this->session->userdata('arr_tbl'))) {
                            foreach ($this->session->userdata('arr_tbl') as $var): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" class="check_delete" value="<?php echo $var['code'] ?>"/>
                                </td>
                                <td><?php echo $var['code'] ?></td>
                                <td><?php echo $var['name'] ?></td>
                            </tr>
                            <?php
                            endforeach;
                        }
                        ?>
                    </tbody>
                </table>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Log Activity</h3>
                </div>
                <div class="tabel-side" style="padding: 12px;">
                    <table class="table" id="table_log">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Activity</th>
                                <th>User</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($log_data as $var): ?>
                            <tr>
                                <td><?php echo $var['code'] ?></td>
                                <td><?php echo $var['activity'] ?></td>
                                <td><?php echo $var['first_name'] ?></td>
                                <td><?php echo $var['created_at'] ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>

<script>
var toggler = document.getElementsByClassName("crt");
var i;

for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nst").classList.toggle("active");
        this.classList.toggle("crt-down");
    });
}
</script>
<script data-main="<?= base_url() ?>assets/js/main/main-resources_treeview" src="<?= base_url() ?>assets/js/require.js"></script>
