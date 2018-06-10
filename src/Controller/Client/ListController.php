<?php
namespace App\Controller\Client;

use App\Controller\BaseController;
use App\Model\Client\ListModel;

class ListController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new ListModel();
    }

    public function shouldRender()
    {
        return true;
    }

    public function render()
    {
        $hostelData = $this->model->getData();
        echo $this->twigEnv->render(
            '@client/list.twig',
            array('pageTitle' => 'Lista de hosteis', 'hostels' => $hostelData)
        );
    }
}
