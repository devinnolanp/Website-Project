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
         <img class="app-header__logo" src="assets/images/Logo.png" href="siswadashboard"></img>
         <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
         <ul class="app-nav">
            <li class="dropdown">
               <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Profile"><?php echo $user_info['name'] ?>         <i class="fas fa-user"></i></a>
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
            <li><a class="app-menu__item" href="siswadashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
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
                  <li><a class="treeview-item <?php echo ($kelas['id_kelas'] == $id_kelas ? 'active' : ''); ?>" href="siswa?id=<?php echo $kelas['id_kelas'] ?>"><i class="icon <?php echo ($kelas['id_kelas'] == $id_kelas ? 'fas fa-greater-than' : 'fa fa-circle'); ?>"></i><?php echo $kelas['id_kelas'] . ' - ' . $kelas['name_kelas'] ?></a></li>
                  <?php } ?>
               </ul>
            </li>
         </ul>
      </aside>
      <main class="app-content">
         <div class="app-title">
            <div>
               <h1></i>(<?php echo $id_kelas . ' - ' . $name_kelas.' ) '.$manage_siswa['name_mata_pelajaran'] ?></h1>
               <p>Guru - <?php echo $manage_siswa['name_guru'] ?></p>
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
                     <div class="alert alert-danger">
                        <?php echo session()->getFlashdata('scorify.fail'); ?>
                     </div>
                     <?php } ?>
                     <div id="res_message_ajax_form_request_review" class="d-none alert alert-success">
                     </div>
                     <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="example">
                           <thead>
                              <tr>
                                 <th>Tugas 40%</th>
                                 <th>UTS 30%</th>
                                 <th>UAS 30%</th>
                                 <th>Nilai Akhir</th>
                                 <th>Opsi</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td><?php echo $manage_siswa['nilai_tugas'] ?></td>
                                 <td><?php echo $manage_siswa['nilai_uts'] ?></td>
                                 <td><?php echo $manage_siswa['nilai_uas'] ?></td>
                                 <td><?php echo $manage_siswa['nilai_akhir'] ?></td>
                                 <td>
                                    <form action="javascript:void(0)" id="ajax_form_request_review" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                       <input type="hidden" name="id_guru" value="<?php echo $manage_siswa['id_guru'] ?>">
                                       <input type="hidden" name="id_siswa" value="<?php echo $manage_siswa['id_siswa']; ?>">
                                       <input type="hidden" name="id_kelas" value="<?php echo $manage_siswa['id_kelas']; ?>">
                                       <input type="hidden" name="name_kelas" value="<?php echo $name_kelas ?>">
                                       <input type="hidden" name="id_user" value="<?php echo $user_info['id_user'] ?>">
                                       <button type="submit" id="send_form_request_review" class="btn btn-primary">Request Peninjauan Nilai</button>
                                    </form>
                                    <script>
                                       if ($('#ajax_form_request_review').length > 0) {
                                           $('#ajax_form_request_review').validate({
                                               submitHandler: function(form) {
                                                   $('#send_form_request_review').html('Sending...');
                                                   $.ajax({
                                                       url: "<?php echo base_url('peninjauan') ?>",
                                                       type: "POST",
                                                       data: $('#ajax_form_request_review').serialize(),
                                                       dataType: "json",
                                                       success: function(response) {
                                                           console.log(response);
                                                           $('#send_form_request_review').html('Request Peninjauan Nilai');
                                                           $('#res_message_ajax_form_request_review').html(response.msg+'<button type="button" class="close" data-dismiss="alert">&times;</button>');
                                                           $('#res_message_ajax_form_request_review').show();
                                                           $('#res_message_ajax_form_request_review').removeClass('d-none');
                                                           setTimeout(function() {
                                                               $('#res_message_ajax_form_request_review').hide();
                                                               $('#res_message_ajax_form_request_review').html('');
                                                           }, 10000);
                                                       }
                                                   });
                                               }
                                           });
                                       }
                                    </script>
                                 </td>
                                 <?php
                                    ?>
                              </tr>
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
      <script type="text/javascript" src="assets/js/plugins/chart.js"></script>
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