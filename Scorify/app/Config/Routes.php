<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('authentication');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'authentication::index');
$routes->add('login', 'authentication::login');
$routes->add('do_login', 'authentication::do_login');
$routes->add('logout', 'authentication::do_logout');
$routes->add('dashboard', 'main::index');
$routes->add('siswadashboard', 'main::siswadashboard');
$routes->add('siswa', 'main::siswa');
$routes->add('siswaprofile', 'main::siswaprofile');
$routes->add('gurudashboard', 'main::gurudashboard');
$routes->add('guru', 'main::guru');
$routes->add('guruprofile', 'main::guruprofile');
$routes->add('clearnotificationadmin', 'main::clearnotificationadmin');
$routes->add('clearnotificationguru', 'main::clearnotificationguru');
$routes->add('checksession', 'main::checksession');
$routes->add('admindashboard', 'main::admindashboard');
$routes->add('adminkelas', 'main::adminkelas');
$routes->add('adminguru', 'main::adminguru');
$routes->add('adminsiswa', 'main::adminsiswa');
$routes->add('adminprofile', 'main::adminprofile');
$routes->add('adminuser', 'main::adminuser');
$routes->add('adminmanage', 'main::adminmanage');
$routes->add('adminmapel', 'main::adminmapel');
$routes->add('adminadduser', 'admin::adminadduser');
$routes->add('adminaddkelas', 'admin::adminaddkelas');
$routes->add('manageadd', 'admin::manageadd');
$routes->add('adminaddmapel', 'admin::adminaddmapel');
$routes->add('adminedituser', 'admin::adminedituser');
$routes->add('admineditsiswa', 'admin::admineditsiswa');
$routes->add('admineditguru', 'admin::admineditguru');
$routes->add('admineditkelas', 'admin::admineditkelas');
$routes->add('admineditmapel', 'admin::admineditmapel');
$routes->add('admindeleteuser', 'admin::admindeleteuser');
$routes->add('admindeleteusersiswa', 'admin::admindeleteusersiswa');
$routes->add('admindeleteuserguru', 'admin::admindeleteuserguru');
$routes->add('adminhapuskelas', 'admin::adminhapuskelas');
$routes->add('adminmanagehapus', 'admin::adminmanagehapus');
$routes->add('adminhapusmapel', 'admin::adminhapusmapel');
$routes->add('adminupdateprofile', 'admin::adminupdateprofile');
$routes->add('izineditprofile', 'admin::izineditprofile');
$routes->add('gurudashboard', 'main::gurudashboard');
$routes->add('inputnilai', 'guru::inputnilai');
$routes->add('guruupdateprofile', 'guru::guruupdateprofile');
$routes->add('guruizinedit', 'guru::guruizinedit');
$routes->add('siswaupdateprofile', 'siswa::siswaupdateprofile');
$routes->add('siswaizinedit', 'siswa::siswaizinedit');
$routes->add('peninjauan', 'siswa::peninjauan');
$routes->add('cropplugin', 'main::cropplugin');


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
