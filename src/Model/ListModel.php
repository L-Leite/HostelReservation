<?php
namespace App\Model;

use App\Model\BaseModel;

class ListModel extends BaseModel
{
    public function getData()
    {
        $data = $this->_db->getAllHostelsInfo();

        foreach ($data as &$d) {
            $d['canReserve'] = $this->_db->canReserve($d['id'], getSessionUser());
        }

        return $data;
    }
}
