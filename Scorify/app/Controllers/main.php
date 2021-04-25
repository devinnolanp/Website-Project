<?php
namespace App\Controllers;
use App\Models\modelsiswa;
use App\Models\modelguru;
use App\Models\modeluser;
class main extends BaseController

{
    function __construct()
    {
        helper(['form']);
        $this->cek_login();
        $this->user_model = new modeluser();
        $this->guru_model = new modelguru();
        $this->student_model = new modelsiswa();
        $this->form_validation = \Config\Services::validation();
    }
    function cek_role($role){
        $result = true;
		if (session()->get('scorify.logged_in_as') != $role) {
			$result = false;
		}
		return $result;
    }
    function index(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        $role = session()->get('scorify.logged_in_as');
        if($role == 'admin'){
            return redirect()->to(base_url('admindashboard'));
        }else if($role == 'guru'){
            return redirect()->to(base_url('gurudashboard'));
        }else if($role == 'siswa'){
            return redirect()->to(base_url('siswadashboard'));
        }
    }
    function siswa(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('siswa') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $id_siswa = $this->student_model->getStudentIdByUserId($data['user_info']['id_user']);
        $data['id_siswa'] = $id_siswa;
        $data['list_kelas'] = $this->student_model->getClassList($id_siswa);
        $data['id_kelas'] = $this->request->getGet('id');
        $data['name_kelas'] = $this->user_model->getNameKelasByIdKelas($data['id_kelas']);
        $data['manage_siswa'] = $this->student_model->getmanageKelasRow($id_siswa, $data['id_kelas']);
        return view('pages/siswa', $data);
    }
    function siswadashboard(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('siswa') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $id_siswa = $this->student_model->getStudentIdByUserId($data['user_info']['id_user']);
        $data['id_siswa'] = $id_siswa;
        $data['list_kelas'] = $this->student_model->getClassList($id_siswa);
        return view('pages/siswadashboard', $data);
    }
    function siswaprofile(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('siswa') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $id_siswa = $this->student_model->getStudentIdByUserId($data['user_info']['id_user']);
        $data['id_siswa'] = $id_siswa;
        $data['list_kelas'] = $this->student_model->getClassList($id_siswa);
        return view('pages/siswaprofile', $data);
    }
    function admindashboard(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('admin') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/admindashboard', $data);
    }
    function adminkelas(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('admin') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $data['list_kelas'] = $this->user_model->getKelas();
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/adminkelas', $data);
    }
    function adminprofile(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('admin') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/adminprofile', $data);
    }
    function adminsiswa(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('admin') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $data['list_siswa'] = $this->user_model->getsiswa();
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/adminsiswa', $data);
    }
    function adminguru(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('admin') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $data['list_guru'] = $this->user_model->getGuru();
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/adminguru', $data);
    }
    function adminuser(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('admin') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $data['list_user'] = $this->user_model->getUser();
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/adminuser', $data);
    }
    function adminmapel(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('admin') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $data['list_mata_pelajaran'] = $this->user_model->getMataPelajaran();
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/adminmapel', $data);
    }
    function adminmanage(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('admin') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $data['list_manage'] = $this->user_model->getmanageKelas();
        $data['list_kelas'] = $this->user_model->getKelas();
        $data['list_siswa'] = $this->user_model->getsiswa();
        $data['list_guru'] = $this->user_model->getGuru();
        $data['list_mata_pelajaran'] = $this->user_model->getMataPelajaran();
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/adminmanage', $data);
    }
    function gurudashboard(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('guru') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $user_info = $this->user_model->getUserInfo();
        $id_guru = $this->guru_model->getguruIdByUserId($user_info['id_user']);
        $data['list_kelas'] = $this->guru_model->getClassList($id_guru);
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/gurudashboard', $data);
    }
    function guruprofile(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('guru') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $user_info = $this->user_model->getUserInfo();
        $id_guru = $this->guru_model->getguruIdByUserId($user_info['id_user']);
        $data['list_kelas'] = $this->guru_model->getClassList($id_guru);
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/guruprofile', $data);
    }
    function guru(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role('guru') != true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        $user_info = $data['user_info'];
        $id_guru = $this->guru_model->getguruIdByUserId($user_info['id_user']);
        $data['list_kelas'] = $this->guru_model->getClassList($id_guru);
        $data['id_kelas'] = $this->request->getGet('id');
        $data['id_mata_pelajaran'] = $this->request->getGet('idmapel');
        $data['name_kelas'] = $this->user_model->getNameKelasByIdKelas($data['id_kelas']);
        $data['list_manage'] = $this->guru_model->getmanageKelas($id_guru, $data['id_kelas'], $data['id_mata_pelajaran']);
        $data['notification_amount'] = 0;
        $belum_baca_notification_list = $this->user_model->getNotificationForUserId($data['user_info']['id_user']);
        $notification_amount = 0;
        $data['notification_list'] = null;
        foreach($belum_baca_notification_list as $notification){
            if($notification['read'] == 'false'){
                $notification_amount++;
                $data['notification_list'][] = $notification;
            }
        }
        $data['notification_amount'] = $notification_amount;
        return view('pages/guru', $data);
    }
    function clearnotificationadmin(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        $id_notification = $this->request->getVar('id_notification');
        $this->user_model->clearNotificationByIdNotificationAdmin($id_notification);
        $data = [
            'success' => true
        ];
        return $this->response->setJSON($data);
    }
    function clearnotificationguru(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        $id_notification = $this->request->getVar('id_notification');
        $this->user_model->clearNotificationByIdNotificationguru($id_notification);
        $data = [
            'success' => true
        ];
        return $this->response->setJSON($data);
    }
    function cropplugin(){
        return view('pages/cropplugin');
    }
    function checksession(){
        echo 'test<br>';
        echo session()->getSessionExpiration();
    }
}
