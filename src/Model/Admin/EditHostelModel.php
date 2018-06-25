<?php
namespace App\Model\Admin;

use App\Model\BaseModel;

class EditHostelModel extends BaseModel
{
    public function isPost()
    {
        return isPostVarSet('doEditHostel') === true && getPostVar('doEditHostel') === '1';
    }

    public function isValidData()
    {
        return (isPostVarSet('hostelId') === true
            && isPostVarSet('address') === true
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

    private function isImageEmpty()
    {
        return (isset($_FILES['image']) === true
            && isset($_FILES['image']['error']) === true
            && is_array($_FILES['image']['error']) === false
            && $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE);
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

        $id = getPostVar('hostelId');
        $address = getPostVar('address');
        $roomsAvailable = getPostVar('roomsAvailable');
        $roomsPrice = getPostVar('roomPrice');
        $description = getPostVar('description');

        $imageFileName = '';

        if ($this->isImageEmpty() === false) {
            $imageExtension = $this->getImageExtension();

            if ($this->isImageValid() === false
                || $imageExtension == false) {
                $this->sendStatus('error', 'badImage');
                return false;
            }

            if ($this->isImageTooLarge() === true) {
                $this->sendStatus('error', 'imageTooLarge');
                return false;
            }

            $imageFileName = sha1_file($_FILES['image']['tmp_name']) . '.' .
                $imageExtension;

            $imagePath = './public/images/hostel/' .
                $imageFileName;

            if (move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $imagePath
            ) === false) {
                $this->sendStatus('error', 'moveFailed');
                return false;
            }
        } else {
            $data = $this->db->getHostelInfo($id);
            $imageFileName = $data['image_url'];
        }

        try {
            $this->db->editHostel(
                $id,
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

    public function hasData()
    {
        return \isGetVarSet('id') === true;
    }

    public function getData()
    {
        return $this->db->getHostelById(\getGetVar('id'));
    }
}
