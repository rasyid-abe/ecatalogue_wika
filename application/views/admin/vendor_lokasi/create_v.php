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
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-tag"></i><?php echo ucwords($page) ?></h3>
    </div>
    <form id="form" method="post">
      <div class="box-body">

        <table class="table table-bordered table-responsive-md table-striped ">
          <thead>
            <tr>
              <td class="text-left" width="50%"><b>Vendor</b></td>
            </tr>
            <tr>
              <td class="aduh">
                <select class="select-td col-sm-12" name="vendor_id" required>
                  <?php if ($this->data['is_superadmin']) { ?>
                    <option value="" disabled selected>Pilih Vendor</option>
                  <?php } ?>
                  <?php
                  echo array_to_options($vendor);
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td class="text-left" width="50%"><b>Lokasi</b></td>
              <td class="text-center" width="6%"><button type="button" class="btn btn-info" id="btn-add-row"><i class="fa fa-plus"></i></button></td>
            </tr>
            </tr>
          </thead>
          <tbody id="tbody-row">
            <tr>
              <td class="aduh">
                <select class="select-td col-sm-12" name="location_id[0]" required>
                  <option value="" disabled selected>Pilih Lokasi</option>
                  <?php foreach ($location as $value) : ?>
                    <option value="<?php echo $value->location_id; ?>"><?php echo $value->full_name; ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="box-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                    <div class="col-sm-9">
                      <input type="name" class="form-control" placeholder="Alamat" name="alamat">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 control-label">Latitude</label>
                    <div class="col-sm-9">
                      <input type="name" class="form-control" placeholder="Latitude" name="latitude" id="latitude">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 control-label">Longitude</label>
                    <div class="col-sm-9">
                      <input type="name" class="form-control" placeholder="Longitude" name="longitude" id="longitude">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 control-label">Maps</label>
                    <div class="col-sm-9">
                      <button type="button" class="btn btn-xs btn-primary pull-left show_modal" data-toggle="modal" data-target="#form_maps"><i class='fa fa-plus'></i> Input Maps</button>
                    </div>
                  </div>
                </div>
              </td>
              <td class="aduh">

              </td>
            </tr>
          </tbody>
        </table>


      </div>

      <div class="box-footer">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo base_url(); ?>vendor_lokasi" class="btn btn-primary btn-danger">Batal</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<script type="template" id="template-row-product">
  <tr>
        <td class="aduh">
        <b>Lokasi</b>
          <select class="select-td required col-sm-12" name="location_id[countArraynyaDigantiNanti]" required>
              <option value="" disabled selected>Pilih Lokasi</option>
        <?php foreach ($location as $value) : ?>
          <option value="<?php echo $value->location_id; ?>"><?php echo $value->full_name; ?></option>
        <?php endforeach; ?>
          </select>
          <div class="box-body">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
              <div class="col-sm-9">
                <input type="name" class="form-control" placeholder="Alamat" name="alamat">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label">Latitude</label>
              <div class="col-sm-9">
                <input type="name" class="form-control" placeholder="Latitude" name="latitude" id="latitude">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label">Longitude</label>
              <div class="col-sm-9">
                <input type="name" class="form-control" placeholder="Longitude" name="longitude" id="longitude">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label">Maps</label>
              <div class="col-sm-9">
                <button type="button" class="btn btn-xs btn-primary pull-left show_modal" data-toggle="modal" data-target="#form_maps"><i class='fa fa-plus'></i> Input Maps</button>
              </div>
            </div>
          </div>
      </td>
      <td class="text-center">
          <!-- <button class="btn btn-danger btn-xs" type="button" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash-o"></i></button> -->
          <button class="btn btn-danger btn-xs" type="button" onclick="if($('#tbody-row tr').length > 1) { $(this).closest('tr').remove() }"><i class="fa fa-trash-o"></i></button>
      </td>
  </tr>
  </script>
<script data-main="<?php echo base_url() ?>assets/js/main/main-vendor-lokasi" src="<?php echo base_url() ?>assets/js/require.js"></script>