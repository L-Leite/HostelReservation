<?php
namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Model\Admin\NewHostelModel;

class NewHostelController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new NewHostelModel();
    }

    public function shouldRender()
    {
        return $this->model->isPost() === false;
    }

    public function render()
    {
        echo $this->twigEnv->render(
            '@admin/new_hostel.twig',
            array('pageTitle' => 'Criar hostel')
        );
    }

    public function handlePost()
    {
        return $this->model->onPost();
    }
}
