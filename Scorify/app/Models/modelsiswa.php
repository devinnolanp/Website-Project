<?php

namespace App\Models;
use CodeIgniter\Model;
class modelsiswa extends Model

{
    public function __construct()
    {
        $this->db = \Config\Database::connect('default');
        $this->user_model = new modeluser();
    }
    function test()
    {
        return 'success';
    }
    function getStudentIdByUserId($id_user)
    {
        $sql = 'SELECT * from siswa where id_user=?';
        $query = $this->db->query($sql, [$id_user]);
        $data = $query->getRowArray();
        return $data['id_siswa'];
    }
    function getClassList($id_siswa)
    {
        $sql = "SELECT distinct ak.id_kelas as 'id_kelas',
        k.name 'name_kelas' 
        from manage_kelas as ak
        inner join kelas as k
        on ak.id_kelas=k.id_kelas
        where id_siswa=?";
        $query = $this->db->query($sql, [$id_siswa]);
        return $query->getResultArray();
    }
    function getmanageKelasRow($id_siswa, $id_kelas)
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
        on p.id_mata_pelajaran=ak.id_mata_pelajaran
        where ak.id_siswa=? and ak.id_kelas=?";
        $query = $this->db->query($sql, [$id_siswa, $id_kelas]);
        return $query->getRowArray();
    }
    function editUserProfile1($id, $name, $email, $password, $birthdate)
    {
        if (preg_match("/^([a-f0-9]{64})$/", $password) != 1) {
            $password = hash('sha256', $password);
        }
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $izin_edit = 'false';
        $sql = 'UPDATE user set name=?, email=?, password=?, birthdate=?, izin_edit=? where id_user=?';
        $db->query($sql, [$name, $email, $password, $birthdate, $izin_edit, $id]);
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
        $izin_edit = 'false';
        $sql = 'UPDATE user set name=?, email=?, birthdate=?, izin_edit=? where id_user=?';
        $db->query($sql, [$name, $email, $birthdate, $izin_edit, $id]);
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
        $izin_edit = 'false';
        $sql = 'UPDATE user set name=?, email=?, password=?, birthdate=?, izin_edit=? where id_user=?';
        $db->query($sql, [$name, $email, $password, $birthdate, $izin_edit, $id]);
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
        $izin_edit = 'false';
        $sql = 'UPDATE user set name=?, email=?, birthdate=?, izin_edit=? where id_user=?';
        $db->query($sql, [$name, $email, $birthdate, $izin_edit, $id]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function askReviewScore($id_user_siswa, $id_siswa, $id_user_guru, $id_kelas, $name_kelas)
    {
        $db = \Config\Database::connect('default');
        $name_siswa = $this->user_model->getUserNameById($id_user_siswa);
        $db->transBegin();
        $message = $id_siswa.'-'.$name_siswa.' mengajukan peninjauan nilai kelas ['.$id_kelas.']'.$name_kelas;
        $sql = 'INSERT into notification(from_id_user, to_id_user, message)
            values(?,?,?)';
        $db->query($sql, [$id_user_siswa, $id_user_guru, $message]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
}
