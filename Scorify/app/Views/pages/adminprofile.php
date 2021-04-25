<!DOCTYPE php>
<php lang="en">
   <head>
      <title>Scorify</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="assets/css/main.css">
      <script src="https://kit.fontawesome.com/2ae0411939.js" crossorigin="anonymous"></script>
      <link href="assets/css/fineCrop.css" rel="stylesheet">
      <link href="assets/css/layout.css" rel="stylesheet">
      <script src="assets/js/fineCrop.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
   </head>
   <body class="app sidebar-mini">
      <header class="app-header">
         <img class="app-header__logo" src="assets/images/Logo.png" href="admindashboard"></img>
         <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
         <ul class="app-nav">
            <li class="dropdown">
               <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fas fa-bell"> <span id="notification_amount" class="counter counter-lg"><?php echo $notification_amount; ?></span></i></a>
               <ul class="app-notification dropdown-menu dropdown-menu-right">
                  <li id="notification_amount_text" class="app-notification__title">Notifications</li>
                  <div class="app-notification__content">
                     <?php
                        if ($notification_list != null) {
                          foreach ($notification_list as $notification) { ?>
                     <li id="ajax_form_notification<?php echo $notification['id_notification']; ?>">
                        <a class="app-notification__item" href="javascript:;">
                           <span class="app-notification__icon"><span class="fa-stack fa-lg"><span class="fa-stack fa-lg"><i class="fas fa-envelope"></i></span></span></span></span>
                           <div>
                              <p class="app-notification__message" style="display:inline-block !important; width:70%;"><?php echo $notification['message']; ?></p>
                              <form action="javascript:void(0)" id="ajax_form_clear_notification<?php echo $notification['id_notification']; ?>" method="post" accept-charset="utf-8" style="display:inline-block !important;width:20%;">
                                 <input type="hidden" name="id_notification" value="<?php echo $notification['id_notification']; ?>">
                                 <button class="btn btn-warning" type="submit">Clear</button>
                              </form>
                           </div>
                        </a>
                     </li>
                     <script>
                        if ($("#ajax_form_clear_notification<?php echo $notification['id_notification']; ?>").length > 0) {
                          $("#ajax_form_clear_notification<?php echo $notification['id_notification']; ?>").validate({
                            submitHandler: function(form) {
                              $.ajax({
                                url: "<?php echo base_url('clearnotificationadmin') ?>",
                                type: "POST",
                                data: $('#ajax_form_clear_notification<?php echo $notification['id_notification']; ?>').serialize(),
                                dataType: "json",
                                success: function(response) {
                                  document.getElementById("ajax_form_notification<?php echo $notification['id_notification']; ?>").style.display = "none";
                                  var notification_amount = document.getElementById("notification_amount").innerHTML;
                                  notification_amount = parseInt(notification_amount);
                                  notification_amount = notification_amount - 1;
                                  document.getElementById("notification_amount").innerHTML = notification_amount;
                                }
                              });
                            }
                          })
                        }
                     </script>
                     <?php }
                        } ?>
                  </div>
               </ul>
            </li>
            <li class="dropdown">
               <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Profile"><?php echo $user_info['name'] ?>         <i class="fas fa-user"></i></a>
               <ul class="dropdown-menu settings-menu dropdown-menu-right">
                  <li><a class="dropdown-item" href="adminprofile"><i class="fa fa-users fa-lg"></i> Profile</a></li>
                  <li><a class="dropdown-item" href="logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
               </ul>
            </li>
         </ul>
      </header>
      <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <aside class="app-sidebar">
         </div>
         <ul class="app-menu">
            <li><a class="app-menu__item " href="admindashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li><a class="app-menu__item " href="adminkelas"><i class="app-menu__icon fas fa-university"></i><span class="app-menu__label">Kelas</span></a></li>
            <li><a class="app-menu__item " href="adminmanage"><i class="app-menu__icon fas fa-plus-square"></i><span class="app-menu__label">Manage Kelas</span></a></li>
            <li><a class="app-menu__item " href="adminguru"><i class="app-menu__icon fas fa-chalkboard-teacher"></i><span class="app-menu__label">Guru</span></a></li>
            <li><a class="app-menu__item " href="adminsiswa"><i class="app-menu__icon fas fa-user-graduate"></i><span class="app-menu__label">Siswa</span></a></li>
            <li><a class="app-menu__item " href="adminmapel"><i class="app-menu__icon fas fa-book"></i><span class="app-menu__label">Pelajaran</span></a></li>
            <li><a class="app-menu__item " href="adminuser"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Daftar User</span></a></li>
         </ul>
      </aside>
      <main class="app-content">
         <div class="row user">
         </div>
         </div>
         <div class="col-md-3">
            <div class="tile p-0">
               <ul class="nav flex-column nav-tabs user-tabs">
                  <li class="nav-item"><a class="nav-link"  href="#user-settings" data-toggle="tab">Settings</a></li>
               </ul>
            </div>
         </div>
         <div class="col-md-6">
         <div class="tab-content">
            <div class="tab-pane active" id="user-profile">
               <div class="tile user-settings">
                  <form>
                     <div class="row">
                        <div class="col-md-12 mb-4 text-center">
                        </div>
                        <div class="col-md-12 mb-4">
                           <label>Name</label>
                           <input value="<?php echo $user_info['name']; ?>" class="form-profile" type="text">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 mb-4">
                           <label>Birthdate</label>
                           <input value="<?php echo $user_info['birthdate']; ?>" class="form-profile" type="text">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 mb-4">
                           <label>Email</label>
                           <input value="<?php echo $user_info['email']; ?>" class="form-profile" type="text">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 mb-4">
                           <label>Password</label>
                           <input value="**********" class="form-profile" type="text">
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <div class="tab-pane fade" id="user-settings">
               <div class="tile user-settings">
                  <h4 class="line-head">Settings</h4>
                  <form action="adminupdateprofile" method="post" enctype="multipart/form-data">
                     <div class="row">
                        <div class="col-md-12 mb-4 text-center">
                        </div>
                        <div class="col-md-12 mb-4">
                           <label>Name</label>
                           <input value="<?php echo $user_info['name']; ?>" name="name_editprofile" class="form-control" type="text">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 mb-4">
                           <label>Birthdate</label>
                           <input value="<?php echo $user_info['birthdate']; ?>" name="birthdate_editprofile" class="form-control" type="date">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 mb-4">
                           <label>Email</label>
                           <input value="<?php echo $user_info['email']; ?>" name="email_editprofile" class="form-control" type="text">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 mb-4">
                           <label>Password</label>
                           <input class="form-control" type="password" name="password_editprofile" placeholder="">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 mb-4">
                           <label>Confirm Password</label>
                           <input class="form-control" type="password" name="confirm_password_editprofile" placeholder="">
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 mb-4">
                           <div class="row mb-10">
                              <div class="col-md-12">
                                 <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                              </div>
                           </div>
                  </form>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
      <script src="assets/js/popper.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/main.js"></script>
      <script src="assets/js/plugins/pace.min.js"></script>
      <script type="text/javascript" src="assets/js/plugins/chart.js"></script>
      <script type='text/javascript'>
      </script>
   </body>
</php>