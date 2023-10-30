<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Wika | Register Mandor</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/frontend/style.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/frontend/responsive.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap4/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/GothamNarrow.css">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/images/frontend/favicon.png" />


  <!-- Daterange picker -->
</head>

<body class="bg-login">
  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="box-white m-login pad-login">
          <div class="full-width">
            <div class="img-login pull-left">
              <img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60">
            </div>
            <p class="font-30 pull-right">Registrasi Mandor</p>
          </div>
          <?php if (!empty($this->session->flashdata('message_error'))) { ?>
            <div class="alert alert-danger">
              <?php
              print_r($this->session->flashdata('message_error'));
              ?>
            </div>
          <?php } ?>
          <?php if (!empty($this->session->flashdata('message'))) { ?>
            <div class="alert alert-success">
              <?php
              print_r($this->session->flashdata('message'));
              ?>
            </div>
          <?php } ?>

          <form method="post" id="form-login">
            <div class="form-group row">
              <div class="col-md-6">
                <label for="">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?= set_value('nama_lengkap') ?>">
                <?= form_error('nama_lengkap', '<label class="error">', '</label>') ?>
              </div>
              <div class="col-md-6">
                <label for="">Username</label>
                <input type="text" name="username" class="form-control" value="<?= set_value('username') ?>">
                <?= form_error('username', '<label class="error">', '</label>') ?>

              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label for="">Password</label>
                <input type="password" name="password" id="password" class="form-control" value="">
                <?= form_error('password', '<label class="error">', '</label>') ?>
              </div>
              <div class="col-md-6">
                <label for="">Password Confirm</label>
                <input type="password" name="password_confirm" class="form-control" value="">
                <?= form_error('password_confirm', '<label class="error">', '</label>') ?>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>">
                <?= form_error('email', '<label class="error">', '</label>') ?>
              </div>
              <div class="col-md-6">
                <label for="">No Identitas</label>
                <input type="text" name="no_identitas" class="form-control" value="<?= set_value('no_identitas') ?>">
                <?= form_error('no_identitas', '<label class="error">', '</label>') ?>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label for="">Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?= set_value('alamat') ?>">
                <?= form_error('alamat', '<label class="error">', '</label>') ?>
              </div>
              <div class="col-md-6">
                <label for="">Lokasi (Kota)</label>
                <input type="text" name="lokasi" class="form-control" value="<?= set_value('lokasi') ?>">
                <?= form_error('lokasi', '<label class="error">', '</label>') ?>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label for="">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" value="<?= set_value('pekerjaan') ?>">
                <?= form_error('pekerjaan', '<label class="error">', '</label>') ?>
              </div>
              <div class="col-md-6">
                <label for="">Harga</label>
                <div class="input-group">
                  <input type="text" name="harga" class="form-control" value="<?= set_value('harga') ?>" onkeyup="App.format(this)">
                  <div class="input-group-btn">
                    <select class="form-control" name="ket_harga">
                      <option value="Lumpsum">Lumpsum</option>
                      <option value="Harian">Harian</option>
                      <option value="Mingguan">Mingguan</option>
                      <option value="Bulanan">Bulanan</option>
                    </select>
                  </div>
                </div>
                <?= form_error('harga', '<label class="error">', '</label>') ?>
              </div>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-success" id="btn-tambah-pengalaman"><i class="fa fa-plus"></i> Pengalaman</button>
            </div>
            <div class="form-group row pengalaman">
              <div class="col-md-11">
                <label for="">Pengalaman</label>
                <input type="text" class="form-control" name="pengalaman[]">
              </div>
              <div class="col-md-1">
                <label for=""></label>
                <button type="button" class="btn btn-danger form-control" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash-o"></i></button>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-blue">Register</button>
              <a href="<?= base_url() ?>login" class="btn btn-danger">Login</a>
            </div>
            <!-- <div class="center-wrapper">
                  <button type="submit" class="btn btn-blue" style="width: 200px;">Login</button>
                </div> -->
          </form>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
</body>
<script data-main="<?php echo base_url() ?>assets/js/main/main-mandor" src="<?php echo base_url() ?>assets/js/require.js"></script>

</html>