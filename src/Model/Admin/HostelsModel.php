<?php
namespace App\Model\Admin;

use App\Model\BaseModel;

class HostelsModel extends BaseModel
{
    public function isPost()
    {
        return isPostVarSet('doDelete') === true && getPostVar('doDelete') === '1';
    }

    public function isValidData()
    {
        return (isPostVarSet('hostelId') === true);
    }

    public function onPost()
    {
        if ($this->isValidData() === false) {
            $this->sendStatus('error', 'badData');
            return false;
        }

        $hostelId = getPostVar('hostelId');
        $hostelData = $this->db->getHostelInfo($hostelId);
        unlink('./public/images/hostel/'.$hostelData['image_url']);

        try {
            $this->db->removeReservationsByHostel($hostelId);
            $this->db->removeHostel($hostelId);
        } catch (\Exception $e) {
            $this->sendStatus('error', 'dbError');
            return false;
        }

        $this->sendStatus('ok');
        return true;
    }

    public function getData()
    {
        return $this->db->getAllHostelsInfo();
    }
}
