<?php
namespace App\Model;

use App\Model\BaseModel;

class ReservedModel extends BaseModel
{
    public function isPost()
    {
        return isPostVarSet('doDelete') === true && getPostVar('doDelete') === '1';
    }

    public function isValidData()
    {
        return (isPostVarSet('id') === true);
    }

    public function onPost()
    {
        if ($this->isValidData() === false) {
            $this->sendStatus('error', 'badData');
            return false;
        }
       
        $id = getPostVar('id');
        
        $reserveInfo = $this->_db->getReservation($id);

        if ($reserveInfo['client_id'] != getSessionUser()) {
            $this->sendStatus('error', 'invalidClient');
            return false;
        }

        $this->_db->removeReservation($id);

        $this->sendStatus('ok');
        return true;
    }

    public function getData()
    {
        return $this->_db->getAllReservedHostelsInfo(getSessionUser());
    }
}
