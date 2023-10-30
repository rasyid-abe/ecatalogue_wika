<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo base_url()?>dashboard" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">EKATALOG</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <a class="navbar-brand" href="#">WIKA</a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Notifications: style can be found in dropdown.less -->
        <li class="dropdown notifications-menu">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" id="btn-notif">
            <i class="fa fa-bell-o"></i>
            <?php
            $jml_notif = ! $notification ? 0 : count($notification);
            if($notification)
            {
                ?>
                <span class="label label-warning" id="jml_notif"><?= $jml_notif ?></span>
                <?php
            }
            ?>
          </a>
          <ul class="dropdown-menu">
            <!-- <li class="header">You have <?= $jml_notif ?> notification</li> -->
            <li>
              <!-- inner menu: contains the actual data -->
              <?php
              if($notification)
              {
                  ?>
                  <ul class="menu">
                      <?php
                      $i = 0;
                      foreach($notification as $v)
                      {
                          ?>
                          <li>
                            <a href="javascript:;">
                              <?= $v->deskripsi ?>
                            </a>
                          </li>
                          <?php
                          $i++;
                          if($i == 5)
                          break;
                      }
                      ?>
                  </ul>
                  <?php
              }
              ?>
              <!-- <ul class="menu">
                <li>
                  <a href="#">
                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                    page and may cause design problems
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-users text-red"></i> 5 new members joined
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-user text-red"></i> You changed your username
                  </a>
                </li>
              </ul> -->
            </li>
            <li class="footer"><a href="<?= base_url()?>notifikasi">View all</a></li>
          </ul>
        </li>
        <?php
        if($users_groups->id != 3)
        {
            ?>
            <li class="dropdown notifications-menu">
                <a href="<?= base_url()?>home" title="Ke Front End">
                    <i class="fa fa-home"></i> Frontend
                </a>
            </li>
            <?php
        }
          ?>
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
            <span class="hidden-xs"><?php echo $this->data['users']->first_name?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo base_url('profile')?>" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo base_url('auth/logout')?>" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
