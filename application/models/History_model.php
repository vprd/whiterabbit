<?php
require_once(APPPATH."models/entity/History.php");
use \History;

class History_model extends CI_Model {
     
    public function __construct() {
        parent::__construct();
        $this->em = $this->doctrine->em;
    }
     
    function add_file($file_name)
    {    
        $his = new History();
        $his->setFileName($file_name);
        $his->setAction('Creation');
         
        try {
            //save to database
            $this->em->persist($his);
            $this->em->flush();
        }
        catch(Exception $err){
             
            die($err->getMessage());
        }
        return true;        
    }
}
