<?php

namespace App\Models;
use CodeIgniter\Model;
class modeluser extends Model

{
    public function __construct()
    {
        $this->db = \Config\Database::connect('default');
    }
    function test()
    {
        return 'success';
    }
    function login($email, $password)
    {
        if (preg_match("/^([a-f0-9]{64})$/", $password) != 1) {
            $password = hash('sha256', $password);
        }
        $query = $this->db->query('SELECT * from user where email=? and password=?', [$email, $password]);
        return $query->getRowArray();
    }
    function addUser($email, $password, $name, $birthdate, $id_role)
    {
        $db = \Config\Database::connect('default');
        if (preg_match("/^([a-f0-9]{64})$/", $password) != 1) {
            $password = hash('sha256', $password);
        }
        $lastId = $this->getLastUserId();
        $newId = $lastId + 1;
        $db->transBegin();
        $izin_edit = 'true';
        if ($id_role == 'R0002') {
            $izin_edit = 'false';
            $this->addGuru($newId, $name);
        } else if ($id_role == 'R0003') {
            $izin_edit = 'false';
            $this->addsiswa($newId, $name);
        }
        $db->query('INSERT into user(id_user, email, password, name, birthdate, id_role, izin_edit)
        values(?,?,?,?,?,?,?)', [$newId, $email, $password, $name, $birthdate, $id_role, $izin_edit]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function editUserName($id_user, $name, $id_role)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $db->query('UPDATE user set name=? where id_user=?', [$name, $id_user]);
        if ($id_role == 'R0002') {
            $db->query('UPDATE guru set name=? where id_user=?', [$name, $id_user]);
        } else if ($id_role == 'R0003') {
            $db->query('UPDATE siswa set name=? where id_user=?', [$name, $id_user]);
        }
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getLastUserId()
    {
        $query = $this->db->query('SELECT * from user order by 1 desc limit 1');
        $data = $query->getRowArray();
        return $data['id_user'];
    }
    function deleteUser($id, $id_role)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $sql = 'DELETE from user where id_user=?';
        $this->db->query($sql, [$id]);
        if ($id_role == 'R0002') {
            $this->deleteGuru($id);
        } else if ($id_role == 'R0003') {
            $this->deletesiswa($id);
        }
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function checkEmailExist($email)
    {
        $query = $this->db->query('SELECT email from user where email=?', [$email]);
        $status = $query->getRowArray();
        if ($status) {
            return true;
        } else {
            return false;
        }
    }
    function getUserInfo()
    {
        $email = session()->get('scorify.email');
        $query = $this->db->query('SELECT * from user where email=?', [$email]);
        return $query->getRowArray();
    }
    public function getUser($id = false)
    {
        if ($id === false) {
            $query = $this->db->query('SELECT u.*, r.name as `role_name` from user as u
            inner join role as r
            on r.id_role=u.id_role');
            return $query->getResultArray();
        } else {
            $query = $this->db->query('SELECT u.*, r.name as `role_name` from user as u
            inner join role as r
            on r.id_role=u.id_role where u.id_user=?', [$id]);
            return $query->getRowArray();
        }
    }
    function addRole($id_role, $name, $description)
    {
        $lastRoleId = $this->getLastRoleId();
        if (!$lastRoleId) {
            $id_role = 'R0001';
        } else {
            $number_role = substr($lastRoleId, 1);
            $int_role = intval($number_role) + 1;
            $int_length = strlen((string) $int_role);
            if ($int_length == 4) {
                $id_role = 'R' . $int_role;
            } else if ($int_length == 3) {
                $id_role = 'R0' . $int_role;
            } else if ($int_length == 2) {
                $id_role = 'R00' . $int_role;
            } else if ($int_length == 1) {
                $id_role = 'R000' . $int_role;
            }
        }
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $db->query('INSERT into role(id_role, name, description)
        values(?,?,?)', [$id_role, $name, $description]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getLastRoleId()
    {
        $query = $this->db->query('SELECT * from role order by desc limit 1');
        $data = $query->getRowArray();
        return $data['id_role'];
    }
    function getUserRoleByEmail($email)
    {
        $query = $this->db->query('SELECT * from user where email=?', [$email]);
        $data = $query->getRowArray();
        return $data['id_role'];
    }
    function addsiswa($id_user, $name)
    {
        $lastsiswaId = $this->getLastsiswaId();
        if (!$lastsiswaId) {
            $id_siswa = 'S0001';
        } else {
            $number_siswa = substr($lastsiswaId, 1);
            $int_siswa = intval($number_siswa) + 1;
            $int_length = strlen((string) $int_siswa);
            if ($int_length == 4) {
                $id_siswa = 'S' . $int_siswa;
            } else if ($int_length == 3) {
                $id_siswa = 'S0' . $int_siswa;
            } else if ($int_length == 2) {
                $id_siswa = 'S00' . $int_siswa;
            } else if ($int_length == 1) {
                $id_siswa = 'S000' . $int_siswa;
            }
        }
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $db->query('INSERT into siswa(id_siswa, id_user, name)
        values(?,?,?)', [$id_siswa, $id_user, $name]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getLastsiswaId()
    {
        $query = $this->db->query('SELECT * from siswa order by 1 desc limit 1');
        $data = $query->getRowArray();
        return $data['id_siswa'];
    }
    public function getsiswa($id = false)
    {
        if ($id === false) {
            $query = $this->db->query('SELECT u.*, m.id_siswa from user as u 
            inner join siswa as m
            on m.id_user=u.id_user');
            return $query->getResultArray();
        } else {
            $query = $this->db->query('SELECT u.*, m.id_siswa from user as u 
            inner join siswa as m
            on m.id_user=u.id_user where id_siswa=?', [$id]);
            return $query->getRowArray();
        }
    }
    function deletesiswa($id)
    {
        $sql = 'DELETE from siswa where id_user=?';
        $this->db->query($sql, [$id]);
    }
    function addGuru($id_user, $name)
    {
        $lastGuruId = $this->getLastGuruId();
        if (!$lastGuruId) {
            $id_guru = 'G0001';
        } else {
            $number_guru = substr($lastGuruId, 1);
            $int_guru = intval($number_guru) + 1;
            $int_length = strlen((string) $int_guru);
            if ($int_length == 4) {
                $id_guru = 'G' . $int_guru;
            } else if ($int_length == 3) {
                $id_guru = 'G0' . $int_guru;
            } else if ($int_length == 2) {
                $id_guru = 'G00' . $int_guru;
            } else if ($int_length == 1) {
                $id_guru = 'G000' . $int_guru;
            }
        }
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $db->query('INSERT into guru(id_guru, id_user, name)
        values(?,?,?)', [$id_guru, $id_user, $name]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getLastGuruId()
    {
        $query = $this->db->query('SELECT * from guru order by 1 desc limit 1');
        $data = $query->getRowArray();
        return $data['id_guru'];
    }
    public function getGuru($id = false)
    {
        if ($id === false) {
            $query = $this->db->query('SELECT u.*, g.id_guru from user as u 
            inner join guru as g
            on g.id_user=u.id_user');
            return $query->getResultArray();
        } else {
            $query = $this->db->query('SELECT u.*, g.id_guru from user as u 
            inner join guru as g
            on g.id_user=u.id_user where id_guru=?', [$id]);
            return $query->getRowArray();
        }
    }
    function deleteGuru($id)
    {
        $sql = 'DELETE from guru where id_user=?';
        $this->db->query($sql, [$id]);
    }
    function addKelas($name)
    {
        $db = \Config\Database::connect('default');
        $lastKelasId = $this->getLastKelasId();
        if (!$lastKelasId) {
            $id_kelas = 'IF0001';
        } else {
            $number_kelas = substr($lastKelasId, 2);
            $int_kelas = intval($number_kelas) + 1;
            $int_length = strlen((string) $int_kelas);
            if ($int_length == 4) {
                $id_kelas = 'IF' . $int_kelas;
            } else if ($int_length == 3) {
                $id_kelas = 'IF0' . $int_kelas;
            } else if ($int_length == 2) {
                $id_kelas = 'IF00' . $int_kelas;
            } else if ($int_length == 1) {
                $id_kelas = 'IF000' . $int_kelas;
            }
        }
        $db->transBegin();
        $db->query('INSERT into kelas(id_kelas, name)
        values(?,?)', [$id_kelas, $name]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getLastKelasId()
    {
        $query = $this->db->query('SELECT * from kelas order by 1 desc limit 1');
        $data = $query->getRowArray();
        return $data['id_kelas'];
    }
    public function getKelas($id = false)
    {
        if ($id === false) {
            $query = $this->db->query('SELECT * from kelas');
            return $query->getResultArray();
        } else {
            $query = $this->db->query('SELECT * from kelas where id_kelas=?', [$id]);
            return $query->getRowArray();
        }
    }
    function getNameKelasByIdKelas($id_kelas)
    {
        $query = $this->db->query('SELECT * from kelas where id_kelas=?', [$id_kelas]);
        $data = $query->getRowArray();
        return $data['name'];
    }
    function deleteKelas($id)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $this->db->query('DELETE from kelas where id_kelas=?', [$id]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function editKelas($id_kelas, $name)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $db->query('UPDATE kelas set name=? where id_kelas=?', [$name, $id_kelas]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getmanageKelas()
    {
        $sql = "SELECT 
        id_manage,
        m.id_siswa as 'id_siswa',
        m.name as 'name_siswa',
        k.id_kelas as 'id_kelas',
        k.name as 'name_kelas',
        g.id_guru as 'id_guru',
        g.name as 'name_guru',
        p.id_mata_pelajaran as 'id_mata_pelajaran',
        p.name as 'name_mata_pelajaran',
        nilai_tugas,
        nilai_uts,
        nilai_uas,
        nilai_akhir
        from manage_kelas as ak
        inner join siswa as m
        on m.id_siswa=ak.id_siswa 
        inner join kelas as k
        on k.id_kelas=ak.id_kelas
        inner join guru as g
        on g.id_guru=ak.id_guru
        inner join mata_pelajaran as p
        on p.id_mata_pelajaran=ak.id_mata_pelajaran";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    function getLastmanageKelasId()
    {
        $query = $this->db->query('SELECT * from manage_kelas order by id_manage desc limit 1');
        $data = $query->getRowArray();
        if($data == null){
            return 0;
        }
        return $data['id_manage'];
    }
    function addmanageKelas($id_kelas, $id_siswa, $id_guru, $id_mata_pelajaran)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $lastIdmanage = $this->getLastmanageKelasId();
        $newIdmanage = $lastIdmanage + 1;
        $db->query('INSERT into manage_kelas(id_manage, id_kelas, id_siswa, id_guru, id_mata_pelajaran)
        values(?,?,?,?,?)', [$newIdmanage, $id_kelas, $id_siswa, $id_guru, $id_mata_pelajaran]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function checkAddmanageKelas($id_kelas, $id_siswa, $id_guru, $id_mata_pelajaran){
        $sql = 'SELECT * from manage_kelas where id_kelas=? and id_siswa=? and id_guru=? and id_mata_pelajaran=?';
        $query = $this->db->query($sql, [$id_kelas, $id_siswa, $id_guru, $id_mata_pelajaran]);
        if($query->getFieldCount() == 0){
            return true;
        }else{
            return false;
        }
    }
    function deletemanageKelas($id)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $db->query('DELETE from manage_kelas where id_manage=?', [$id]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function editUserProfile1($id, $name, $email, $password, $birthdate)
    {
        if (preg_match("/^([a-f0-9]{64})$/", $password) != 1) {
            $password = hash('sha256', $password);
        }
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $sql = 'UPDATE user set name=?, email=?, password=?, birthdate=? where id_user=?';
        $db->query($sql, [$name, $email, $password, $birthdate, $id]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function editUserProfileNoPassword1($id, $name, $email, $birthdate)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $sql = 'UPDATE user set name=?, email=?, birthdate=? where id_user=?';
        $db->query($sql, [$name, $email, $birthdate, $id]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function editUserProfile($id, $name, $email, $password, $birthdate)
    {
        if (preg_match("/^([a-f0-9]{64})$/", $password) != 1) {
            $password = hash('sha256', $password);
        }
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $sql = 'UPDATE user set name=?, email=?, password=?, birthdate=? where id_user=?';
        $db->query($sql, [$name, $email, $password, $birthdate, $id]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function editUserProfileNoPassword($id, $name, $email, $birthdate)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $sql = 'UPDATE user set name=?, email=?, birthdate=? where id_user=?';
        $db->query($sql, [$name, $email, $birthdate, $id]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    public function getMataPelajaran($id = false)
    {
        if ($id === false) {
            $query = $this->db->query('SELECT * from mata_pelajaran');
            return $query->getResultArray();
        } else {
            $query = $this->db->query('SELECT * from mata_pelajaran where id_mata_pelajaran=?', [$id]);
            return $query->getRowArray();
        }
    }
    function getLastMataPelajaranId()
    {
        $query = $this->db->query('SELECT * from mata_pelajaran order by id_mata_pelajaran desc limit 1');
        $data = $query->getRowArray();
        return $data['id_mata_pelajaran'];
    }
    function addMataPelajaran($name)
    {
        $db = \Config\Database::connect('default');
        $lastMataPelajaranId = $this->getLastMataPelajaranId();
        if (!$lastMataPelajaranId) {
            $id_mata_pelajaran = 'P0001';
        } else {
            $number_mata_pelajaran = substr($lastMataPelajaranId, 2);
            $int_mata_pelajaran = intval($number_mata_pelajaran) + 1;
            $int_length = strlen((string) $int_mata_pelajaran);
            if ($int_length == 4) {
                $id_mata_pelajaran = 'P' . $int_mata_pelajaran;
            } else if ($int_length == 3) {
                $id_mata_pelajaran = 'P0' . $int_mata_pelajaran;
            } else if ($int_length == 2) {
                $id_mata_pelajaran = 'P00' . $int_mata_pelajaran;
            } else if ($int_length == 1) {
                $id_mata_pelajaran = 'P000' . $int_mata_pelajaran;
            }
        }
        $db->transBegin();
        $db->query('INSERT into mata_pelajaran(id_mata_pelajaran, name)
        values(?,?)', [$id_mata_pelajaran, $name]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function editMataPelajaran($id_mata_pelajaran, $name)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $db->query('UPDATE mata_pelajaran set name=? where id_mata_pelajaran=?', [$name, $id_mata_pelajaran]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function deleteMataPelajaran($id)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $this->db->query('DELETE from mata_pelajaran where id_mata_pelajaran=?', [$id]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function grantEditProfilePermission($id_user){
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $izin_edit = 'true';
        $this->db->query('UPDATE user set `izin_edit`=? where `id_user`=?', [$izin_edit, $id_user]);
        $this->makeNotificationReadForFromUserId($id_user);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function makeNotificationReadForFromUserId($from_id_user){
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $read = 'true';
        $this->db->query('UPDATE notification set `read`=? where from_id_user=?', [$read, $from_id_user]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getNotificationForUserId($id_user){
        $query = $this->db->query('SELECT * from notification where to_id_user=? order by id_notification desc', [$id_user]);
        return $query->getResultArray();
    }
    function askEditProfilePermission($id_user){
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $list_admin = $this->getAllAdminUser();
        $user_name = $this->getUserNameById($id_user);
        $message = $user_name.'['.$id_user.']'.' Meminta Izin Edit Profile';
        foreach($list_admin as $admin){
            $sql = 'INSERT into notification(from_id_user, to_id_user, message)
            values(?,?,?)';
            $db->query($sql, [$id_user, $admin['id_user'], $message]);
        }
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getAllAdminUser(){
        $id_role = 'R0001';
        $query = $this->db->query('SELECT * from user where id_role=? order by id_user', [$id_role]);
        return $query->getResultArray();
    }
    function getUserNameById($id_user){
        $query = $this->db->query('SELECT * from user where id_user=?', [$id_user]);
        $data = $query->getRowArray();
        return $data['name'];
    }
    function checkNotifyUser($id_user){
        $query = $this->db->query('SELECT * from notification where from_id_user=?', [$id_user]);
        $data_list = $query->getResultArray();
        if($data_list == []){
            return false;
        }
        foreach($data_list as $data){
            $read = $data['read'];
            if($read == 'true'){
                continue;
            }else{
                return true;
            }
        }
        return false;
    }
    function clearNotificationByIdNotificationAdmin($id_notification){
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $read = 'true';
        $admin_list = $this->getAllAdminUser();
        foreach($admin_list as $admin){
            $this->db->query('UPDATE notification set `read`=? where `id_notification`=? and `to_id_user`=?', [$read, $id_notification, $admin['id_user']]);
        }
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function clearNotificationByIdNotificationguru($id_notification){
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $read = 'true';
        $this->db->query('UPDATE notification set `read`=? where `id_notification`=?', [$read, $id_notification]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getIdUserGuruByIdGuru($id_guru){
        $query = $this->db->query('SELECT * from guru where id_guru=?',[$id_guru]);
        $data = $query->getRowArray();
        return $data['id_user'];
    }
}
