<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Wika</title>
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
      <div class="col-md-6 offset-md-3">
        <div class="box-white m-login pad-login">
          <div class="full-width">
            <div class="img-login pull-left">
              <img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="80" height="60">
            </div>
            <p class="font-30 pull-right">LOGIN</p>
          </div>
          <?php if (!empty($this->session->flashdata('message_error'))) { ?>
            <div class="alert alert-danger">
              <?php
              print_r($this->session->flashdata('message_error'));
              ?>
            </div>
          <?php } ?>
          <form action="<?php echo base_url(); ?>auth/login" method="post" id="form-login">
            <div class="form-group">
              <label for="email">Username/NIK</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="pwd">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <!-- <div class="form-group form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox"> Remember me
                  </label>
                </div> -->
            <div class="center-wrapper">
              <button type="submit" class="btn btn-blue" style="width: 200px;">Login</button>
              <!-- <a class="btn btn-default btn-block btn-flat" href="<?php echo base_url() ?>auth/forgot_password">Forgot Password</a> -->
              <!-- <a class="btn btn-default btn-block btn-flat" href="<?php echo base_url() ?>register/mandor">Register Mandor</a> -->
              <!-- <p class="font-12 text-center mtop-15">Have no account<a class="font-blue" href="register.html"> Register Now</a></p> -->
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
</body>
<script data-main="<?php echo base_url() ?>assets/js/main/main-login" src="<?php echo base_url() ?>assets/js/require.js"></script>

</html>