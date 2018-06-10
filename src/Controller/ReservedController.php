<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Model\ReservedModel;

class ReservedController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new ReservedModel();
    }

    public function shouldRender()
    {
        return $this->model->isPost() === false;
    }

    public function render()
    {
        $reserveData = $this->model->getData();        
        echo $this->twigEnv->render(
            '@client/reserved.twig',
            array('pageTitle' => 'Hosteis reservados', 'reserveInfo' => $reserveData, 'disabled' => 0)
        );
    }

    public function handlePost()
    {
        $result = $this->model->onPost();

        if ($result === true) {
            header('Location: reserved');
        }

        return $result;
    }
}
