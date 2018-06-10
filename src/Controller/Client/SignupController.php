<?php
namespace App\Controller\Client;

use App\Controller\BaseController;
use App\Model\Client\SignupModel;

class SignupController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new SignupModel();
    }

    public function shouldRender()
    {
        return $this->model->isPost() === false;
    }
    
    public function render()
    {
        echo $this->twigEnv->render(
            '@client/signup.twig',
            array('pageTitle' => 'Criar conta')
        );
    }

    public function handlePost()
    {
        return $this->model->onPost();
    }
}
