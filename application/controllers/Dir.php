<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dir extends CI_Controller
{

    public function __construct()
	{
		parent::__construct();
        // $this->load->model('history_model');
    }
    public function index()
    {
        $this->load->view('dirList');
    }

    public function listing()
    {
        $config = &get_config();

        $ffs = scandir($config['directory']);

        foreach ($ffs as $ff) {
            if ($ff != '.' && $ff != '..') {
                if (!is_dir($ff)) {
                    $data[] = [
                        'id' => $ff,
                        'name' => $ff,
                        'type' => 'file'
                    ];
                } else {
                    $data[] = [
                        'id' => $ff,
                        'name' => $ff,
                        'type' => 'dir'
                    ];
                }
            }
        }
        header('Content-Type: application/json');

        // $data = [

        // [
        //     "Tiger Nixon",
        //     "System Architect",
        //     "Edinburgh",

        //   ],
        //   [
        //     "Garrett Winters",
        //     "Accountant",
        //     "Tokyo",

        //   ]

        //   ];

        echo json_encode(['status' => 'success', 'data' => $data, 'totalCount' => 0]);
    }
    public function delete()
    {

        $config = &get_config();
        $files = $_POST['files'];
        if (count($files)) {
            foreach ($files as $file) {
                echo $file;
                if (is_file($config['directory'] . '/' . $file)) {
                    unlink($config['directory'] . '/' . $file);
                }
            }
        }
    }

    public function upload()
    {

        foreach ($_FILES as $fileKey => $file) {


            $configData = &get_config();
            $config['upload_path']          =  $configData['directory'];
            $config['allowed_types']        = 'txt|doc|docx|pdf|png|jpeg|jpg|gif';
            $config['max_size']             =  20480; // 2 mb

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
                $dir_exist = false; // dir not exist
            }

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($fileKey)) {
                $error = array('msg' => $fileKey . $this->upload->display_errors());
                header('Content-Type: application/json');
                echo json_encode($error);
                exit;
            } else {
                $data = $this->upload->data();
                // $result  = $this->history_model->add_file($file);
                $data['status'] = 'Success';
                // header('Content-Type: application/json');
                // echo json_encode( $data);
                // exit;
                // $this->load->view('upload_success', $data);
            }
        }
        header('Content-Type: application/json');
		echo json_encode(array('status' => 'Success', 'msg' => 'New FIle Uploaded.'));
		exit;
    }
}
