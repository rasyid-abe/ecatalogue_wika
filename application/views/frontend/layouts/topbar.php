<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadowed">
  <div class="container">
    <a class="navbar-brand" href="<?php echo base_url() ?>home"><img src="<?php echo base_url() ?>assets/images/frontend/logo2.png" width="100" height="60"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url() ?>chat/vendor_list"><i class="fa fa-comments text-blue"></i> Riwayat Chat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:;" id="btn-need-help"><i class="fa fa-question-circle text-blue"></i> Need Help</a>
        </li>
        <li class="nav-item" style="position: relative;">
          <?php
          $cart_class = "";
          if ($cart_total == 0) {
            $cart_class = "hidden";
          }
          ?>
          <span class="float-notif <?= $cart_class ?>" id="cart_notif"><?= $cart_total ?></span>
          <a class="nav-link" href="<?php echo base_url() ?>mycart"><i class="fa fa-shopping-cart text-blue"></i> Keranjang Saya</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url() ?>orderhistory"><i class="fa fa-hourglass-2 text-blue"></i> Riwayat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url() ?>userprofile"><i class="fa fa-user text-blue"></i> Profile</a>
        </li>
        <?php
        if ($users_groups->id != 3) {
        ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url() ?>redirect/dashboard_target"><i class="fa fa-database text-blue"></i> Backend</a>
          </li>
        <?php
        }
        ?>
        <li class="nav-item">
          <a class="btn btn-blue btn-shadow" href="<?php echo base_url() ?>auth/logout">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>