<?php
namespace App\Model\Admin;

use App\Model\BaseModel;

class ReservationsModel extends BaseModel
{
    public function getData()
    {
        return $this->db->getAllReservedHostelsInfo();
    }
}
