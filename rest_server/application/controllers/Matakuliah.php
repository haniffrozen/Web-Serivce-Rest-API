<?php
header('Content-Type: application/json');
require APPPATH . '/libraries/REST_Controller.php';
class Matakuliah extends REST_Controller{
    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get() {
        $kode_mk = $this->get('kode_mk');
        if ($kode_mk == '') {
            $this->db->select('*');    
            $this->db->from('matakuliah');
            $this->db->join('dosen', 'dosen.nip = matakuliah.nip');
            $matakuliah = $this->db->get()->result();
        } else {
            $this->db->where('kode_mk', $kode_mk);
            $matakuliah = $this->db->get('matakuliah')->result();
        }
        $this->response($matakuliah, 200);
    }

    function index_post() {
        $data = array(
                    'kode_mk'  => $this->post('kode_mk'),
                    'nama_mk' => $this->post('nama_mk'),
                    'sks'        => $this->post('sks'),
                    'nip' => $this->post('nip'));
        $insert = $this->db->insert('matakuliah', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    function index_put() {
        $kode_mk = $this->put('kode_mk');
        $data = array(
                    'kode_mk'       => $this->put('kode_mk'),
                    'nama_mk'      => $this->put('nama_mk'),
                    'sks'    => $this->put('sks'),
                    'nip'    => $this->put('nip'));
        $this->db->where('kode_mk', $kode_mk);
        $update = $this->db->update('matakuliah', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

        // delete mahasiswa
        function index_delete() {
            $kode_mk = $this->delete('kode_mk');
            $this->db->where('kode_mk', $kode_mk);
            $delete = $this->db->delete('matakuliah');
            if ($delete) {
                $this->response(array('status' => 'success'), 201);
            } else {
                $this->response(array('status' => 'fail', 502));
            }
        }
 
}
?>