<?php
namespace App\Controller\Client;

use App\Controller\BaseController;
use App\Model\Client\DetailsModel;

class DetailsController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new DetailsModel();
    }

    public function shouldRender()
    {
        return $this->model->isPost() === false;
    }

    public function render()
    {
        $hostelData = $this->model->getData();

        if ($hostelData == null) {
            header('Location: list');
        }

        $clientId = getSessionUser();
        $hostelId = getGetVar('id');
        $todayDate = date('Y-m-d');
        $tomorrowDate = date('Y-m-d', strtotime('+1 day'));
        $maxDate = date('Y-m-d', strtotime('+14 day'));

        echo $this->twigEnv->render(
            '@client/details.twig',
            array(
                'pageTitle' => $hostelData['address'], 'hostel' => $hostelData,
                'clientId' => $clientId, 'hostelId' => $hostelId,
                'todayDate' => $todayDate, 'tomorrowDate' => $tomorrowDate,
                'maxDate' => $maxDate,
            )
        );
    }

    public function handlePost()
    {
        return $this->model->onPost();
    }
}
