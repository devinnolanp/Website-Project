<?php
namespace App\Controllers;
use App\Models\modeluser;

class authentication extends BaseController{
    protected $helper = [];
    public function __construct()
    {
        helper(['form','cookie']);
        $this->cek_login();
        $this->user_model = new modeluser();
        $this->form_validation = \Config\Services::validation();
    }
    public function index(){
        if($this->cek_login() == true){
            return redirect()->to(base_url('dashboard'));
        }
        return view('pages/login');
    }
    public function login(){
        if($this->cek_login() == true){
            return redirect()->to(base_url('dashboard'));
        }
        $data['user_info'] = $this->user_model->getUserInfo();
        return view('pages/login', $data);
    }
    public function do_login(){
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $stay_signed_in = 'false';
        $inputs = [
            'email' => $email,
            'password' => $password
        ];
        if ($this->form_validation->run($inputs, 'login') == false) {
            session()->setFlashdata('scorify.errors_validation_login', $this->form_validation->getErrors());
            return redirect()->to(base_url('login'));
        }

        $password = hash('sha256', $password);
        $masuk = $this->user_model->login($email, $password);
        if($masuk){
            if($stay_signed_in == 'false'){
                session()->set('scorify.logged_in', "masuk");
                session()->set('scorify.email', $email);
            }
            $id_role = $this->user_model->getUserRoleByEmail($email);
            if($id_role == 'R0001'){
                if($stay_signed_in == 'false'){
                    session()->set('scorify.logged_in_as', "admin");
                }
                return redirect()->to(base_url());
            }else if($id_role == 'R0002'){
                if($stay_signed_in == 'false'){
                    session()->set('scorify.logged_in_as', "guru");
                }
                return redirect()->to(base_url());
            }else if($id_role == 'R0003'){
                if($stay_signed_in == 'false'){
                    session()->set('scorify.logged_in_as', "siswa");
                }
                return redirect()->to(base_url());
            }
        }else{
            session()->setFlashdata('scorify.errors_login', 'Email atau Password salah');
            return redirect()->to(base_url('login'));
        }
    }
    function do_logout(){
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}