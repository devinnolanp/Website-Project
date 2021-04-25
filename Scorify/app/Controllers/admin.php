<?php

namespace App\Controllers;
use App\Models\modeluser;
class admin extends BaseController

{
    function __construct()
    {
        helper(['form']);
        $this->cek_login();
        $this->user_model = new modeluser();
        $this->form_validation = \Config\Services::validation();
    }
    function cek_role()
    {
        $result = false;
        if (session()->get('scorify.logged_in_as') == "admin") {
            $result = true;
        }
        return $result;
    }
    function adminadduser()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $email = $this->request->getPost('email_add');
        $email = esc($email);
        $password = $this->request->getPost('password_add');
        $password = esc($password);
        $name = $this->request->getPost('name_add');
        $name = esc($name);
        $birthdate = $this->request->getPost('birthdate_add');
        $role = $this->request->getPost('role_add');
        $addresult = $this->user_model->addUser($email, $password, $name, $birthdate, $role);
        if ($addresult) {
            session()->setFlashdata('scorify.success', 'User ditambah');
            return redirect()->to(base_url('adminuser'));
        } else {
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminuser'));
        }
    }
    function adminaddkelas()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $name = $this->request->getPost('name_add');
        $addresult = $this->user_model->addKelas($name);
        if ($addresult) {
            session()->setFlashdata('scorify.success', 'Kelas ditambah');
            return redirect()->to(base_url('adminkelas'));
        } else {
            session()->setFlashdata('scorify.fail', 'Kelas tidak bisa ditambah');
            return redirect()->to(base_url('adminaddkelas'));
        }
    }
    function adminaddmapel()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $name = $this->request->getPost('name_add');
        $addResult = $this->user_model->addMataPelajaran($name);
        if ($addResult) {
            session()->setFlashdata('scorify.success', 'Mata pelajaran ditambah');
            return redirect()->to(base_url('adminmapel'));
        } else {
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminmapel'));
        }
    }
    function manageadd(){
        if($this->cek_login() != true){
            return redirect()->to(base_url('login'));
        }
        if($this->cek_role() != true){
            return redirect()->to(base_url('login'));
        }
        $id_kelas = $this->request->getPost('id_kelas');
        $id_siswa = $this->request->getPost('id_siswa');
        $id_guru = $this->request->getPost('id_guru');
        $id_mata_pelajaran = $this->request->getPost('id_mata_pelajaran');
        $addResult = $this->user_model->addmanageKelas($id_kelas, $id_siswa, $id_guru, $id_mata_pelajaran);
        if($addResult){
            session()->setFlashdata('scorify.success', 'Berhasil diatur');
            return redirect()->to(base_url('adminmanage'));
        }else{
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminmanage'));
        }
    }
    function adminedituser()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user = $this->request->getPost('id_edit');
        $name = $this->request->getPost('name_edit');
        $name = esc($name);
        $id_role = $this->request->getPost('role_id');
        $editresult = $this->user_model->editUserName($id_user, $name, $id_role);
        if ($editresult) {
            session()->setFlashdata('scorify.success', 'Edit sukses');
            return redirect()->to(base_url('adminuser'));
        } else {
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminuser'));
        }
    }
    function admineditguru()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user = $this->request->getPost('id_edit');
        $name = $this->request->getPost('name_edit');
        $id_role = $this->request->getPost('role_id');
        $editresult = $this->user_model->editUserName($id_user, $name, $id_role);
        if ($editresult) {
            session()->setFlashdata('scorify.success', 'Edit sukses');
            return redirect()->to(base_url('adminguru'));
        } else {
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminguru'));
        }
    }
    function admineditsiswa()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user = $this->request->getPost('id_edit');
        $name = $this->request->getPost('name_edit');
        $id_role = $this->request->getPost('role_id');
        $editresult = $this->user_model->editUserName($id_user, $name, $id_role);
        if ($editresult) {
            session()->setFlashdata('scorify.success', 'Edit sukses');
            return redirect()->to(base_url('adminsiswa'));
        } else {
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminsiswa'));
        }
    }
    function admineditmapel()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_mata_pelajaran = $this->request->getPost('id_mata_pelajaran');
        $name = $this->request->getPost('name_edit');
        $editresult = $this->user_model->editMataPelajaran($id_mata_pelajaran, $name);
        if ($editresult) {
            session()->setFlashdata('scorify.success', 'Edit sukses');
            return redirect()->to(base_url('adminmapel'));
        } else {
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminmapel'));
        }
    }
    function admineditkelas()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_kelas = $this->request->getPost('id_kelas');
        $name = $this->request->getPost('name_edit');
        $editresult = $this->user_model->editKelas($id_kelas, $name);
        if ($editresult) {
            session()->setFlashdata('scorify.success', 'Edit sukses');
            return redirect()->to(base_url('adminkelas'));
        } else {
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminkelas'));
        }
    }
    function adminmanagehapus()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_manage = $this->request->getPost('id_manage');
        $deleteResult = $this->user_model->deletemanageKelas($id_manage);
        if ($deleteResult) {
            session()->setFlashdata('scorify.success', 'Terhapus');
            return redirect()->to(base_url('adminmanage'));
        } else {
            session()->setFlashdata('scorify.fail', '#');
            return redirect()->to(base_url('adminmanage'));
        }
    }
    function admindeleteuser()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user = $this->request->getGet('id');
        $id_role = $this->request->getGet('role');
        if ($id_user != null && $id_role != null) {
            $deleteResult = $this->user_model->deleteUser($id_user, $id_role);
            if ($deleteResult) {
                session()->setFlashdata('scorify.success', 'User dihapus');
                return redirect()->to(base_url('adminuser'));
            } else {
                session()->setFlashdata('scorify.fail', 'User tidak bisa dihapus');
                return redirect()->to(base_url('adminuser'));
            }
        } else {
            session()->setFlashdata('scorify.fail', 'User tidak bisa dihapus');
            return redirect()->to(base_url('adminuser'));
        }
    }
    function admindeleteuserguru()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user = $this->request->getGet('id');
        $id_role = $this->request->getGet('role');
        if ($id_user != null && $id_role != null) {
            $deleteResult = $this->user_model->deleteUser($id_user, $id_role);
            if ($deleteResult) {
                session()->setFlashdata('scorify.success', 'User dihapus');
                return redirect()->to(base_url('adminguru'));
            } else {
                session()->setFlashdata('scorify.fail', 'User tidak bisa dihapus');
                return redirect()->to(base_url('adminguru'));
            }
        } else {
            session()->setFlashdata('scorify.fail', 'User tidak bisa dihapus');
            return redirect()->to(base_url('adminguru'));
        }
    }
    function admindeleteusersiswa()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user = $this->request->getGet('id');
        $id_role = $this->request->getGet('role');
        if ($id_user != null && $id_role != null) {
            $deleteResult = $this->user_model->deleteUser($id_user, $id_role);
            if ($deleteResult) {
                session()->setFlashdata('scorify.success', 'User dihapus');
                return redirect()->to(base_url('adminsiswa'));
            } else {
                session()->setFlashdata('scorify.fail', 'error');
                return redirect()->to(base_url('adminsiswa'));
            }
        } else {
            session()->setFlashdata('scorify.fail', 'error');
            return redirect()->to(base_url('adminsiswa'));
        }
    }
    function adminhapuskelas()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id = $this->request->getGet('id');
        $deleteResult = $this->user_model->deleteKelas($id);
        if ($deleteResult) {
            session()->setFlashdata('scorify.success', 'Kelas berhasil dihapus');
            return redirect()->to(base_url('adminkelas'));
        } else {            
            session()->setFlashdata('scorify.fail', 'Kelas tidak bisa dihapus');
            return redirect()->to(base_url('adminkelas'));
        }
    }
    function adminhapusmapel()
    {        
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }        
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id = $this->request->getGet('id');
        $deleteResult = $this->user_model->deleteMataPelajaran($id);
        if ($deleteResult) {
            session()->setFlashdata('scorify.success', 'Mata pelajaran dihapus');
            return redirect()->to(base_url('adminmapel'));
        } else {
            session()->setFlashdata('scorify.fail', 'Mata pelajaran tidak bisa dihapus');
            return redirect()->to(base_url('adminmapel'));
        }
    }
    function adminupdateprofile()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $user_info = $this->user_model->getUserInfo();
        $id_user = $user_info['id_user'];
        $name = $this->request->getPost('name_editprofile');
        $email = $this->request->getPost('email_editprofile');
        $password = $this->request->getPost('password_editprofile');
        $confirm_password = $this->request->getPost('confirm_password_editprofile');
        $birthdate = $this->request->getPost('birthdate_editprofile');
        if ($password != '') {
            if ($password != $confirm_password) {
                return redirect()->to(base_url('adminprofile#user-settings'));
            }
        }
            if ($password != '') {
                $password = hash('sha256', $password);
                $this->user_model->editUserProfile($id_user, $name, $email, $password, $birthdate);
            } else {
                $this->user_model->editUserProfileNoPassword($id_user, $name, $email, $birthdate);
            }
            session()->set('scorify.email', $email);
            return redirect()->to(base_url('adminprofile'));
    }
    function izineditprofile()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user = $this->request->getGet('id');
        $grantResult = $this->user_model->grantEditProfilePermission($id_user);
        if ($grantResult) {
            session()->setFlashdata('scorify.success', 'Izin diterima');
            return redirect()->to(base_url('adminuser'));
        } else {
            session()->setFlashdata('scorify.fail', '#');
            return redirect()->to(base_url('adminuser'));
        }
    }
}
