<?php
namespace App\Model\Client;

use App\Model\BaseModel;

class ListModel extends BaseModel
{
    public function getData()
    {
        $data = $this->db->getAllHostelsInfo();

        foreach ($data as &$d) {
            $d['canReserve'] = $this->db->canReserve($d['id'], getSessionUser());
        }

        return $data;
    }
}
