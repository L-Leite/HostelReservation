<?php
namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Model\Admin\HostelsModel;

class HostelsController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new HostelsModel();
    }

    public function shouldRender()
    {
        return $this->model->isPost() === false;
    }

    public function render()
    {
        $hostelData = $this->model->getData();
        echo $this->twigEnv->render(
            '@admin/hostels.twig',
            array('pageTitle' => 'Lista de hosteis', 'hostels' => $hostelData)
        );
    }

    public function handlePost()
    {
        return $this->model->onPost();
    }
}
