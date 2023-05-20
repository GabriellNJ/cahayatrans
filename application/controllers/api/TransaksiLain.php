<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class TransaksiLain extends REST_Controller
{



    function __construct()
    {
       // set header CORS
       header('Access-Control-Allow-Origin: *');
       header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
       header("Access-Control-Allow-Headers: *");
       header('Access-Control-Allow-Credentials: *');
       if ("OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {die();}
       // Construct the parent class
       parent::__construct();
        $this->load->model('M_transaksiLain', 'TransaksiLain');
        $this->load->model('M_post', 'Insert');
    }

    // public function index_get()
    // {
    //     $data = $this->supir->get();
    //     $this->set_response([
    //         'status' => true,
    //         'data' => $data,
    //     ], REST_Controller::HTTP_OK);
    // }
    public function index_get()
    {
      
        $id = $this->get('id_mutasi');

        if ( $id === null )
        {
            $data = $this->TransaksiLain->get();

            // Check if the users data store contains users
            if ( isset($data) )
            {
                // Set the response and exit
                $this->response( $data, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status'    => false,
                    'message'   => 'not found'
                ], 404 );
            }
        }
        else
        {
            $data = $this->TransaksiLain->getId($id);

            if ( isset( $data ) )
            {
                $this->response( $data, 200 );
            }
            else
            {
                $this->response( [
                    'status'    => false,
                    'message'   => ' not found'
                ], 404 );
            }
        }
    }
    public function index_post()
    {
        $data = [
            "id_mutasi" => $this->post('id_mutasi'),
            "pendapatan_mutasi" => $this->post('pendapatan_mutasi'),
             "nota" => $this->post('nota'),
            "tanggal_mutasi" => $this->post('tanggal_mutasi'),
        "keterangan_mutasi" => $this->post('keterangan_mutasi'),
            "total_mutasi" => $this->post('total_mutasi'),
        ];

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('tanggal_mutasi', 'tanggal_mutasi', 'required');
     
        $this->form_validation->set_rules('total_mutasi', 'total_mutasi', 'required');
        $this->form_validation->set_message('required', '{field} Tidak Boleh Kosong');

        if ($this->form_validation->run() == FALSE) {

            $message = [
                "status" => false,
                "message" => validation_errors(' ', ' '),
            ];
            $this->response($message, REST_Controller::HTTP_OK);
        } else {
            $respon = $this->Insert->insert('tb_transaksilain', $data);
            $data['TransaksiLain'] = $this->TransaksiLain->tampil();
            $this->response(array($data,'status' => 'insert success'), 201);
        }
    }
   
    public function index_put()
    {
        $id = $this->put('id_mutasi');
        $data = [
            'id_mutasi'       => $this->put('id_mutasi'),
            'pendapatan_mutasi'          => $this->put('pendapatan_mutasi'),
             'nota'          => $this->put('nota'),
            'tanggal_mutasi'    => $this->put('tanggal_mutasi'),
            'keterangan_mutasi'    => $this->put('keterangan_mutasi'),
            'total_mutasi'    => $this->put('total_mutasi'),

        ];

        if ($this->TransaksiLain->update($data, $id) ) {
            $this->response(array($data,'status' => 'update success'), 201);
        } else {
            $this->response(array('status' => 'update fail', 502));
        }
    }
  

    public function index_delete()
    {
        $id = $this->input->get('id_mutasi');

        $hapus = $this->TransaksiLain->delete($id);

        if ($hapus) {
                    $this->response(array('status' => 'delete success'), 201);
                } else {
                    $this->response(array('status' => 'delete fail', 502));
                }
    }
    

}