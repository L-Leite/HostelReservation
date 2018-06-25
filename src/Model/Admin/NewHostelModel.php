<?php
namespace App\Model\Admin;

use App\Model\BaseModel;

class NewHostelModel extends BaseModel
{
    public function isPost()
    {
        return isPostVarSet('doNewHostel') === true && getPostVar('doNewHostel') === '1';
    }

    public function isValidData()
    {
        return (isPostVarSet('address') === true
            && isPostVarSet('roomsAvailable') === true
            && isPostVarSet('roomPrice') === true
            && isPostVarSet('description') === true);
    }

    private function isImageValid()
    {
        return (isset($_FILES['image']) === true
            && isset($_FILES['image']['error']) === true
            && is_array($_FILES['image']['error']) === false
            && $_FILES['image']['error'] === UPLOAD_ERR_OK);
    }

    private function isImageTooLarge()
    {
        return ($_FILES['image']['size'] > 2097152); // 2 megabytes
    }

    private function getImageExtension()
    {
        $info = new \finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $info->file($_FILES['image']['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
            return false;
        }
        return $ext;
    }

    public function onPost()
    {
        if ($this->isValidData() === false) {
            $this->sendStatus('error', 'badData');
            return false;
        }

        if ($this->isImageValid() === false) {
            $this->sendStatus('error', 'badImage');
            return false;
        }

        if ($this->isImageTooLarge() === true) {
            $this->sendStatus('error', 'imageTooLarge');
            return false;
        }

        $imageExtension = $this->getImageExtension();

        if ($imageExtension == false) {
            $this->sendStatus('error', 'badImage');
            return false;
        }

        $imageFileName = sha1_file($_FILES['image']['tmp_name']).'.'.
                        $imageExtension;

        $imagePath = './public/images/hostel/'.
                    $imageFileName;

        if (move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $imagePath
        ) === false) {
            $this->sendStatus('error', 'moveFailed');
            return false;
        }

        $address = getPostVar('address');
        $roomsAvailable = getPostVar('roomsAvailable');
        $roomsPrice = getPostVar('roomPrice');
        $description = getPostVar('description');
        try {
            $this->db->newHostel(
                $address,
                $roomsPrice,
                $roomsAvailable,
                $description,
                $imageFileName
            );
        } catch (\Exception $e) {
            $this->sendStatus('error', 'dbError');
            return false;
        }

        $this->sendStatus('ok');
        return true;
    }
}
