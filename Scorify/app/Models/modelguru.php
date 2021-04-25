<?php

namespace App\Models;
use CodeIgniter\Model;
class modelguru extends Model

{
    public function __construct()
    {
        $this->db = \Config\Database::connect('default');
    }
    function test()
    {
        return 'success';
    }
    function getguruIdByUserId($id)
    {
        $sql = 'SELECT * from guru where id_user=?';
        $query = $this->db->query($sql, [$id]);
        $data = $query->getRowArray();
        return $data['id_guru'];
    }
    function getClassList($id_guru)
    {
        $sql = "SELECT distinct ak.id_kelas as 'id_kelas',
        k.name 'name_kelas',
        ak.id_mata_pelajaran as 'id_mata_pelajaran',
        p.name as 'name_mata_pelajaran'
        from manage_kelas as ak
        inner join kelas as k
        on ak.id_kelas=k.id_kelas
        inner join mata_pelajaran as p
        on p.id_mata_pelajaran=ak.id_mata_pelajaran
        where id_guru=?";
        $query = $this->db->query($sql, [$id_guru]);
        return $query->getResultArray();
    }
    function editNilaimanage($id_manage, $nilai_tugas, $nilai_uts, $nilai_uas, $nilai_akhir)
    {
        $db = \Config\Database::connect('default');
        $db->transBegin();
        $sql = 'UPDATE manage_kelas set nilai_tugas=?, nilai_uts=?, nilai_uas=?, nilai_akhir=? where id_manage=?';
        $db->query($sql, [$nilai_tugas, $nilai_uts, $nilai_uas, $nilai_akhir, $id_manage]);
        if ($db->transStatus() === FALSE) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }
    function getmanageKelas($id_guru, $id_kelas, $id_mata_pelajaran)
    {
        $sql = "SELECT 
        id_manage,
        m.id_siswa as 'id_siswa',
        m.name as 'name_siswa',
        k.id_kelas as 'id_kelas',
        k.name as 'name_kelas',
        g.id_guru as 'id_guru',
        g.name as 'name_guru',
        ak.id_mata_pelajaran as 'id_mata_pelajaran',
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
        where ak.id_guru=? and ak.id_kelas=? and ak.id_mata_pelajaran=?";
        $query = $this->db->query($sql, [$id_guru, $id_kelas, $id_mata_pelajaran]);
        return $query->getResultArray();
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
}
