<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Scorify</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="assets/css/main.css">
      <script src="https://kit.fontawesome.com/2ae0411939.js" crossorigin="anonymous"></script>
   </head>
   <body class="app sidebar-mini">
      <header class="app-header">
         <img class="app-header__logo" src="assets/images/Logo.png" href="siswadashboard"></img>
         <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
         <ul class="app-nav">
            <li class="dropdown">
               <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Profile"><?php echo $user_info['name'] ?>        <i class="fas fa-user"></i> </a>
               <ul class="dropdown-menu settings-menu dropdown-menu-right">
                  <li><a class="dropdown-item" href="siswaprofile"><i class="fa fa-user fa-lg"></i> Profile</a></li>
                  <li><a class="dropdown-item" href="logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
               </ul>
            </li>
         </ul>
      </header>
      <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <aside class="app-sidebar">
         </div>
         <ul class="app-menu">
            <li><a class="app-menu__item active" href="siswadashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li class="treeview">
               <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Kelas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
               <ul class="treeview-menu">
                  <?php foreach ($list_kelas as $kelas) { ?>
                  <li><a class="treeview-item" href="siswa?id=<?php echo $kelas['id_kelas'] ?>"><i class="icon fas fa-greater-than"></i><?php echo $kelas['id_kelas'] . ' - ' . $kelas['name_kelas'] ?></a>
                  </li>
                  <?php } ?>
               </ul>
            </li>
         </ul>
      </aside>
      <main class="app-content">
         <div class="app-title">
            <div>
               <h1><i class="fas fa-user-graduate"></i>  Siswa -      <?php echo $user_info['name'] ?></h1>
               <p></p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
            </ul>
         </div>
         <div class="row">
               <?php if($list_kelas == null){ ?>
               <?php } ?>
               <?php foreach ($list_kelas as $kelas) { ?>
            <div class="col-md-12 col-lg-12">
               <div id="hoverclick" onclick="location.href='siswa?id=<?php echo $kelas['id_kelas'] ?>';" class="widget-small primary coloured-icon hoverclick">
                  <i class="icon fa fa-archive fa-3x"></i>
                  <div class="info">
                     <h4><a href="siswa?id=<?php echo $kelas['id_kelas'] ?>"><?php echo $kelas['id_kelas'] . ' - ' . $kelas['name_kelas'] ?></a></h4>
                     <p><b></b></p>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
      </main>
      <script src="assets/js/jquery-3.3.1.min.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="assets/js/main.js"></script>
      <script src="assets/js/plugins/pace.min.js"></script>
      <script type="text/javascript" src="assets/js/plugins/chart.js"></script>
   </body>
</html>