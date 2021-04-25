<?php

namespace App\Controllers;
use App\Models\modelsiswa;
use App\Models\modeluser;
class siswa extends BaseController

{
    function __construct()
    {
        helper(['form','url']);
        $this->cek_login();
        $this->user_model = new modeluser();
        $this->student_model = new modelsiswa();
        $this->form_validation = \Config\Services::validation();
    }
    function cek_role()
    {
        $result = false;
        if (session()->get('scorify.logged_in_as') == "siswa") {
            $result = true;
        }
        return $result;
    }
    function siswaupdateprofile()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $user_info = $this->user_model->getUserInfo();
        if ($user_info['izin_edit'] == 'false') {
            return redirect()->to(base_url('siswaprofile'));
        }
        $id_user = $user_info['id_user'];
        $name = $this->request->getPost('name_editprofile');
        $email = $this->request->getPost('email_editprofile');
        $password = $this->request->getPost('password_editprofile');
        $confirm_password = $this->request->getPost('confirm_password_editprofile');
        $birthdate = $this->request->getPost('birthdate_editprofile');
        if ($password != '') {
            if ($password != $confirm_password) {
                return redirect()->to(base_url('siswaprofile#user-settings'));
            }
        }
            if ($password != '') {
                $password = hash('sha256', $password);
                $this->student_model->editUserProfile($id_user, $name, $email, $password, $birthdate);
            } else {
                $this->student_model->editUserProfileNoPassword($id_user, $name, $email, $birthdate);
            }
            session()->set('scorify.email', $email);
            return redirect()->to(base_url('siswaprofile'));
    }
    function siswaizinedit(){
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user = $this->request->getVar('id_user');
        $checkIfAlreadyNotify = $this->user_model->checkNotifyUser($id_user);
        if($checkIfAlreadyNotify == false){
            $this->user_model->askEditProfilePermission($id_user);
            $data = [
                'success' => true,
                'msg' => "Request dikirim"
            ];
            return $this->response->setJSON($data);
        }else{
            $data = [
                'success' => false,
                'msg' => "Request sudah dikirim, harap tunggu"
            ];
            return $this->response->setJSON($data);
        }
    }
    function peninjauan(){
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_user_siswa = $this->request->getVar('id_user');
        $id_siswa = $this->request->getVar('id_siswa');
        $id_guru = $this->request->getVar('id_guru');
        $id_user_guru = $this->user_model->getIdUserGuruByIdGuru($id_guru);
        $id_kelas = $this->request->getVar('id_kelas');
        $name_kelas = $this->request->getVar('name_kelas');
        $checkIfAlreadyNotify = $this->user_model->checkNotifyUser($id_user_siswa);
        if($checkIfAlreadyNotify == false){
            $this->student_model->askReviewScore($id_user_siswa, $id_siswa, $id_user_guru, $id_kelas, $name_kelas);
            $data = [
                'success' => true,
                'msg' => "Request dikirim"
            ];
            return $this->response->setJSON($data);
        }else{
            $data = [
                'success' => false,
                'msg' => "Request sudah dikirim, harap tunggu"
            ];
            return $this->response->setJSON($data);
        }
    }
}
