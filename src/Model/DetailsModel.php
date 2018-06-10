<?php
namespace App\Model;

use App\Model\BaseModel;

class DetailsModel extends BaseModel
{
    public function isPost()
    {
        return isPostVarSet('doReserve') === true && getPostVar('doReserve') === '1';
    }

    public function isValidData()
    {
        return (isPostVarSet('userId') === true
            || isPostVarSet('hostelId') === true
            || isPostVarSet('startDate') === true
            || isPostVarSet('endDate') === true);
    }

    public function onPost()
    {
        if ($this->isValidData() === false) {
            $this->sendStatus('error', 'badData');
            return false;
        }

        $userId = getPostVar('userId');
        $hostelId = getPostVar('hostelId');
        $startDate = getPostVar('startDate');
        $endDate = getPostVar('endDate');

        $todayDate = date('Y-m-d');
        $tomorrowDate = date('Y-m-d', strtotime('+1 day'));
        $maxDate = date('Y-m-d', strtotime('+14 day'));

        if ($startDate < $todayDate || $endDate > $maxDate) {
            $this->sendStatus('error', 'invalidDate');
            return false;
        }

        $this->_db->newReservation($userId, $hostelId, $startDate, $endDate );
        
        $this->sendStatus('ok');
        return true;
    }

    public function getData()
    {
        $data = $this->_db->getHostelInfo(getGetVar('id'));
        return $data;
    }
}
