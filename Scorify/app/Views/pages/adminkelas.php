<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Scorify</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="assets/css/main.css">
      <script src="https://kit.fontawesome.com/2ae0411939.js" crossorigin="anonymous"></script>
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
                          });
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
         <div class="app-title">
            <div>
               <h1>
                  </i>
                  <button type="button" class="btn btn-md btn-primary noUnderlineCustom text-white" data-toggle="modal" data-target="#addModal">
                     Tambah Kelas
               </h1>
               <p></p>
            </div>
         </div>
         <div class="row">
         <div class="col-md-12">
         <div class="tile">
         <div class="tile-body">
         <?php
            if (!empty(session()->getFlashdata('scorify.success'))) { ?>
         <div class="alert alert-success">
         <?php echo session()->getFlashdata('scorify.success'); ?>
         </div>
         <?php } ?>
         <?php
            if (!empty(session()->getFlashdata('scorify.fail'))) { ?>
         <div class="alert alert-warning">
         <?php echo session()->getFlashdata('scorify.fail'); ?>
         </div>
         <?php } ?>
         <div class="table-responsive">
         <table class="table table-hover table-bordered" id="example">
         <thead>
         <tr>
         <th>ID</th>
         <th>Class</th>
         <th>Option</th>
         </tr>
         </thead>
         <tbody>
         <?php foreach ($list_kelas as $kelas) { ?>
         <tr>
         <td><?php echo $kelas['id_kelas'] ?></td>
         <td><?php echo $kelas['name'] ?></td>
         <td><button type="button" class="btn btn-md btn-primary fas fa-pencil-alt noUnderlineCustom text-white" data-toggle="modal" data-target="#editModal<?php echo $kelas['id_kelas'] ?>"></button>
         <a href="<?php echo base_url('adminhapuskelas?id=' . $kelas['id_kelas']) ?>" type="button" class="btn btn-md btn-danger fas fa-trash noUnderlineCustom text-white"></a></td>
         </tr>
         <div class="modal fade" id="editModal<?php echo $kelas['id_kelas'] ?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
         <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="ModalLabel">Edit Kelas</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="modal-body">
         <form action="<?php echo base_url('admineditkelas') ?>" method="POST" enctype="multipart/form-data" method="POST" id="ModalForm">
         <input type="hidden" id="editId" value="terserah">
         <div class="form-group">
         <label for="editId">ID</label>
         <input type="text" class="form-control" id="editId" placeholder="ID" value="<?php echo $kelas['id_kelas']; ?>" disabled>
         <input type="hidden" name="id_kelas" value="<?php echo $kelas['id_kelas']; ?>">
         </div>
         <div class="form-group">
         <label for="editClass">Name</label>
         <input type="text" name="name_edit" class="form-control" id="editClass" placeholder="Name" value="<?php echo $kelas['name']; ?>" required>
         </div>
         <div class="modal-footer">
         <a class="btn btn-secondary" data-dismiss="modal">Close</a>
         <button type="submit" id="saveModalButton" class="btn btn-primary">Save</button>
         </div>
         </form>
         </div>
         </div>
         </div>
         </div>
         <?php } ?>
         </tbody>
         </table>
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
      <script type="text/javascript" src="assets/js/plugins/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="assets/js/plugins/dataTables.bootstrap.min.js"></script>
      <script type="text/javascript">
         $(document).ready(function() {
           // Setup - add a text input to each footer cell
           $('#example thead tr').clone(true).appendTo( '#example thead' );
           $('#example thead tr:eq(1) th').each( function (i) {
               var title = $(this).text();
               $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
         
               $( 'input', this ).on( 'keyup change', function () {
                   if ( table.column(i).search() !== this.value ) {
                       table
                           .column(i)
                           .search( this.value )
                           .draw();
                   }
               } );
           } );
         
           var table = $('#example').DataTable( {
               orderCellsTop: true,
               fixedHeader: true
           } );
         } );
      </script>
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Add New Class</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="<?php echo base_url('adminaddkelas') ?>" method="post" enctype="multipart/form-data" id="ModalForm">
                     <div class="form-group">
                        <label for="addname">Name</label>
                        <input type="text" name="name_add" class="form-control" id="name" placeholder="Name" required>
                     </div>
                     <div class="modal-footer">
                        <a class="btn btn-danger text-light" data-dismiss="modal">Close</a>
                        <button type="submit" id="saveModalButton" class="btn btn-primary">Add Class</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>