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
         <img class="app-header__logo" src="assets/images/Logo.png" href="gurudashboard"></img>
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
                                url: "<?php echo base_url('clearnotificationguru') ?>",
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
                  <li><a class="dropdown-item" href="guruprofile"><i class="fa fa-user fa-lg"></i> Profile</a></li>
                  <li><a class="dropdown-item" href="logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
               </ul>
            </li>
         </ul>
      </header>
      <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <aside class="app-sidebar">
         </div>
         <ul class="app-menu">
            <li><a class="app-menu__item" href="gurudashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            </li>
            <li class="treeview is-expanded">
               <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Kelas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
               <ul class="treeview-menu">
                  <?php foreach ($list_kelas as $kelas) { ?>
                  <?php
                     if ($kelas['id_kelas'] == $id_kelas) { ?>
                  <?php
                     } else { ?>
                  <?php
                     } ?>
                  <li><a class="treeview-item <?php echo ($kelas['id_kelas'] == $id_kelas ? 'active' : ''); ?>" href="guru?id=<?php echo $kelas['id_kelas'] ?>&idmapel=<?php echo $kelas['id_mata_pelajaran'] ?>"><i class="icon <?php echo ($kelas['id_kelas'] == $id_kelas ? 'fas fa-greater-than' : 'fa fa-circle'); ?>"></i><?php echo $kelas['name_kelas'].' - '.$kelas['name_mata_pelajaran'] ?></a></li>
                  <?php } ?>
               </ul>
            </li>
         </ul>
      </aside>
      <main class="app-content">
         <div class="app-title">
            <div>
               <h1></i>(<?php echo $id_kelas . ' - ' . $name_kelas.' ) '.$list_manage[0]['name_mata_pelajaran'] ?></h1>
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
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                     </div>
                     <?php } ?>
                     <?php
                        if (!empty(session()->getFlashdata('scorify.fail'))) { ?>
                     <div class="alert alert-danger">
                        <?php echo session()->getFlashdata('scorify.fail'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                     </div>
                     <?php } ?>
                     <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="example">
                           <thead>
                              <tr>
                                 <th>Nama</th>
                                 <th>NIM</th>
                                 <th>Tugas 40%</th>
                                 <th>UTS 30%</th>
                                 <th>UAS 30%</th>
                                 <th>Nilai Akhir</th>
                                 <th>Option</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php foreach ($list_manage as $manage) { ?>
                              <tr>
                                 <td><?php echo $manage['name_siswa'] ?></td>
                                 <td><?php echo $manage['id_siswa'] ?></td>
                                 <td><?php echo $manage['nilai_tugas'] ?></td>
                                 <td><?php echo $manage['nilai_uts'] ?></td>
                                 <td><?php echo $manage['nilai_uas'] ?></td>
                                 <td><?php echo $manage['nilai_akhir'] ?></td>
                                 <td>
                                    <button type="button" class="btn btn-md btn-primary fas fa-pencil-alt noUnderlineCustom text-white" data-toggle="modal" data-target="#editModal<?php echo $manage['id_manage'] ?>"></button>
                                 </td>
                              </tr>
                              <div class="modal fade" id="editModal<?php echo $manage['id_manage'] ?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="ModalLabel">Edit Nilai</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                          <form action="inputnilai" method="POST" enctype="multipart/form-data" id="ModalForm">
                                             <input type="hidden" name="id_kelas_edit" value="<?php echo $id_kelas ?>">
                                             <input type="hidden" name="id_manage_edit" value="<?php echo $manage['id_manage'] ?>">
                                             <input type="hidden" name="id_mata_pelajaran_edit" value="<?php echo $manage['id_mata_pelajaran'] ?>">
                                             <div class="form-group">
                                                <label for="editClass">Nama</label>
                                                <input type="text" name="name_edit" class="form-control" id="editName" value="<?php echo $manage['name_siswa'] ?>" disabled>
                                             </div>
                                             <div class="form-group">
                                                <label for="editSurname">ID siswa</label>
                                                <input type="text" name="id_siswa_edit" class="form-control" id="editSurname" value="<?php echo $manage['id_siswa'] ?>" disabled>
                                             </div>
                                             <div class="form-group">
                                                <label for="editEmail">Nilai Tugas</label>
                                                <input type="text" name="tugas_edit" class="form-control" id="tugas_edit" placeholder="Masukkan angka" value="<?php echo $manage['nilai_tugas'] ?>">
                                             </div>
                                             <div class="form-group">
                                                <label for="editEmail">Nilai UTS</label>
                                                <input type="text" name="uts_edit" class="form-control" id="tugas_edit" placeholder="Masukkan angka" value="<?php echo $manage['nilai_uts'] ?>">
                                             </div>
                                             <div class="form-group">
                                                <label for="editEmail">Nilai UAS</label>
                                                <input type="text" name="uas_edit" class="form-control" id="tugas_edit" placeholder="Masukkan angka" value="<?php echo $manage['nilai_akhir'] ?>">
                                             </div>
                                             <div class="modal-footer">
                                                <a class="btn btn-secondary" data-dismiss="modal">Close</a>
                                                <button type="submit" id="saveModalButton" class="btn btn-primary">Save changes</button>
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
   </body>
</html>