<?php
namespace App\Model;

use App\Database;

class BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function isPost()
    {
        throw new \Exception('isPost: Implement me!');
    }

    public function isValidData()
    {
        throw new \Exception('isValidData: Implement me!');
    }
    
    public function onPost()
    {
        throw new \Exception('onData: Implement me!');
    }

    public function getData()
    {
        throw new \Exception('getData: Implement me!');
    }

    public function sendStatus($status, $message = null)
    {
        echo \json_encode(array('status' => $status, 'message' => $message));
    }
}
