<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


    public function index()
	{
		$config = &get_config();
		$list = [];
        $ffs = scandir($config['directory']);
            foreach($ffs as $ff)
            {
                if($ff != '.' && $ff != '..' )
                {
                    if(!is_dir($ff)){
                    $list[] = [
                        'id' => $ff,
                        'name'=>$ff,
                        'type'=> 'file'
                    ];
                }else{
                    $list[] = [
                        'id' => $ff,
                        'name'=>$ff,
                        'type'=> 'dir'
                    ];
                }
                }
			}
			$data['list'] = $list;

		$this->load->view('dirList',$data);
	}

	public function listing()
	{
		$this->load->view('dirList');
	}
}