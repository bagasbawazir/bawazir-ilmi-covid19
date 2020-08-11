<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Covid extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $covid = $this->db->get('covid')->result();
        } else {
            $this->db->where('id', $id);
            $covid = $this->db->get('covid')->result();
        }
        $this->response($covid, 200);
    }

    //Mengirim atau menambah data kontak baru
    function index_post() {
        $data = array(
                    'id'                => $this->post('id'),
                    'kecamatan'         => $this->post('kecamatan'),
                    'jumlahPositif'     => $this->post('jumlahPositif'));
        $insert = $this->db->insert('covid', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Memperbarui data kontak yang telah ada
    function index_put() {
        $id = $this->put('id');
        $data = array(
            'id'                => $this->put('id'),
            'kecamatan'         => $this->put('kecamatan'),
            'jumlahPositif'     => $this->put('jumlahPositif'));
        $this->db->where('id', $id);
        $update = $this->db->update('covid', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Menghapus salah satu data kontak
    function index_delete() {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('covid');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>