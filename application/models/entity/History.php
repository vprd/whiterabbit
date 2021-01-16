<?php
/**
 * @Table(name="history")
 * @Entity
 */
class History
{
    private $id;
 
    private $file_name;
 
    private $action;

    private $time;
 
    public function getId()
    {
        return $this->id;
    }
 
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }
 
    public function getFileName()
    {
        return $this->file_name;
    }
 
    public function setAction($action)
    {
        $this->action = $action;
    }
 
    public function getAction()
    {
        return $this->action;
    }
 
    public function setTime($time)
    {
        $this->time = $time;
    }
 
    public function getTime()
    {
        return $this->time;
    }
}