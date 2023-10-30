<?php
//var_dump($user_pemantau_list);
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<style media="screen">
  #mapid {
    height: 480px;
  }
</style>
<!-- Modal Input-->
<div class="modal fade" id="form_maps" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" style="width: 665px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="judulModalLabel">Form Input kode Sumber Daya</h4>
      </div>

      <div id="mapid"></div>

      <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
      <script type="text/javascript">
        var mymap = L.map('mapid').setView([-0.7031073524364783, 117.46582031250001], 5);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
          attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
          maxZoom: 18,
          id: 'mapbox/streets-v11',
          tileSize: 512,
          zoomOffset: -1,
          accessToken: 'pk.eyJ1IjoicmF6eWlkNzIiLCJhIjoiY2s1Z2g1Z3NvMDc0YTNmcGVubmgzd2l5bCJ9.6jAMfgoFlE4HVP-BYqEFPw'
        }).addTo(mymap);

        mymap.on('click', function(e) {
          var r = confirm("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng);
          if (r == true) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            $('#latitude').val(lat);
            $('#longitude').val(lng);
            $('#form_maps').modal('hide');
          } else {
            $('#form_maps').modal('hide');
          }


        });
      </script>

    </div>
  </div>
</div>
<section class="content">
  <div class="full-width padding">
    <div class="padding-top">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-tag"></i> Berkas <?php echo ucwords($page) ?></h3>
            </div>
            <form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
              <div class="box-body">
                <?php if (!empty($this->session->flashdata('message_error'))) { ?>
                  <div class="alert alert-danger">
                    <?php
                    print_r($this->session->flashdata('message_error'));
                    ?>
                  </div>
                <?php } ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Nama</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" placeholder="Nama" name="name" value="<?= $name ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">No SPK</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" placeholder="No SPK" name="no_spk" value="<?= $no_spk ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Kategori</label>
                  <div class="col-sm-9">
                    <select id="kategori_id" name="kategori_id" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih Kategori</option>
                      <?php
                      foreach ($kategori as $kat) { ?>
                        <option value="<?php echo $kat->id; ?>" <?php echo $kat->id ==  $kategori_id ? 'selected' : '' ?>><?php echo $kat->name; ?></option>
                      <?php }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Jenis</label>
                  <div class="col-sm-9">
                    <select id="jenis_id" name="jenis_id" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih Jenis</option>
                      <?php
                      foreach ($jenis as $jen) { ?>
                        <option value="<?php echo $jen->id; ?>" <?php echo $jen->id ==  $jenis_id ? 'selected' : '' ?>><?php echo $jen->name; ?></option>
                      <?php }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Departemen</label>
                  <div class="col-sm-9">
                    <select id="departemen_id" name="departemen_id" class="form-control" data-selectjs="true">
                      <option value="" disabled>Pilih Departemen</option>
                      <?php
                      foreach ($groups as $group) { ?>
                        <option value="<?php echo $group->id; ?>" <?php echo $group->id ==  $departemen_id ? 'selected' : '' ?>><?php echo $group->name; ?></option>
                      <?php }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Provinsi</label>
                  <div class="col-sm-9">
                    <select id="provinsi" name="provinsi" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih Provinsi</option>
                      <?php
                      echo array_to_options($sel_provinsi, $provinsi)
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Kabupaten/Kota</label>
                  <div class="col-sm-9">
                    <select id="kabupaten" name="kabupaten" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                      <?php
                      echo array_to_options($sel_kabupaten, $kabupaten)
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Kecamatan</label>
                  <div class="col-sm-9">
                    <select id="kecamatan" name="kecamatan" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih Kecamatan</option>
                      <?php
                      echo array_to_options($sel_kecamatan, $kecamatan)
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 control-label">Kelurahan</label>
                  <div class="col-sm-9">
                    <select id="desa" name="desa" class="form-control" data-selectjs="true">
                      <option value="" disabled selected>Pilih Desa</option>
                      <?php
                      echo array_to_options($sel_desa, $desa)
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" placeholder="Alamat" name="alamat" value="<?php echo $alamat ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Latitude</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" placeholder="Latitude" name="latitude" id="latitude" value="<?php echo $latitude ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Longitude</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" placeholder="Longitude" name="longitude" id="longitude" value="<?php echo $longitude ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Maps</label>
                  <div class="col-sm-9">
                    <button type="button" class="btn btn-xs btn-primary pull-left show_modal" data-toggle="modal" data-target="#form_maps"><i class='fa fa-plus'></i> Input Maps</button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">Manager Proyek</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" placeholder="Contact Person" name="contact_person" value="<?php echo $contact_person ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 control-label">No HP</label>
                  <div class="col-sm-9">
                    <input type="name" class="form-control" placeholder="No HP" name="no_hp" value="<?php echo $no_hp ?>">
                  </div>
                </div>
                <div class="box-footer">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                      <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                      <a href="<?php echo base_url(); ?><?= $cont ?>" class="btn btn-primary btn-danger">Batal</a>
                    </div>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-project" src="<?php echo base_url() ?>assets/js/require.js"></script>