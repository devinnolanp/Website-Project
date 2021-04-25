<?php

namespace App\Controllers;
use App\Models\modelguru;
use App\Models\modeluser;
class guru extends BaseController

{
    function __construct()
    {
        helper(['form']);
        $this->cek_login();
        $this->user_model = new modeluser();
        $this->guru_model = new modelguru();
        $this->form_validation = \Config\Services::validation();
    }
    function cek_role()
    {
        $result = false;
        if (session()->get('scorify.logged_in_as') == "guru") {
            $result = true;
        }
        return $result;
    }
    function inputnilai()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $id_kelas = $this->request->getPost('id_kelas_edit');
        $id_mata_pelajaran = $this->request->getPost('id_mata_pelajaran_edit');
        $id_manage = $this->request->getPost('id_manage_edit');
        $nilai_tugas = $this->request->getPost('tugas_edit');
        $nilai_uts = $this->request->getPost('uts_edit');
        $nilai_uas = $this->request->getPost('uas_edit');
        $nilai_akhir = 0;
        if ($nilai_tugas != 0 && $nilai_uts != 0 && $nilai_uas != 0) {
            $nilai_akhir = (0.4 * $nilai_tugas) + (0.3 * $nilai_uts) + (0.3 * $nilai_uas);
        }
        $editResult = $this->guru_model->editNilaimanage($id_manage, $nilai_tugas, $nilai_uts, $nilai_uas, $nilai_akhir);
        if ($editResult) {
            session()->setFlashdata('scorify.success', 'Nilai berhasil diubah');
            return redirect()->to(base_url("guru?id=$id_kelas&idmapel=$id_mata_pelajaran"));
        } else {
            session()->setFlashdata('scorify.fail', 'Nilai gagal diubah');
            return redirect()->to(base_url("guru?id=$id_kelas&idmapel=$id_mata_pelajaran"));
        }
    }
    function guruupdateprofile()
    {
        if ($this->cek_login() != true) {
            return redirect()->to(base_url('login'));
        }
        if ($this->cek_role() != true) {
            return redirect()->to(base_url('login'));
        }
        $user_info = $this->user_model->getUserInfo();
        if($user_info['izin_edit'] == 'false'){
            return redirect()->to(base_url('guruprofile'));
        }
        $id_user = $user_info['id_user'];
        $name = $this->request->getPost('name_editprofile');
        $email = $this->request->getPost('email_editprofile');
        $password = $this->request->getPost('password_editprofile');
        $confirm_password = $this->request->getPost('confirm_password_editprofile');
        $birthdate = $this->request->getPost('birthdate_editprofile');
        if ($password != '') {
            if ($password != $confirm_password) {
                return redirect()->to(base_url('guruprofile#user-settings'));
            }
        }
            if ($password != '') {
                $password = hash('sha256', $password);
                $this->guru_model->editUserProfile($id_user, $name, $email, $password, $birthdate);
            } else {
                $this->guru_model->editUserProfileNoPassword($id_user, $name, $email, $birthdate);
            }
            session()->set('scorify.email', $email);
            return redirect()->to(base_url('guruprofile'));
    }
    function guruizinedit(){
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
}
