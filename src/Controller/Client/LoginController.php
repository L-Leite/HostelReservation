<?php
namespace App\Controller\Client;

use App\Controller\BaseController;
use App\Model\Client\LoginModel;

class LoginController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new LoginModel();
    }

    public function shouldRender()
    {
        return $this->model->isPost() === false;
    }
    
    public function render()
    {
        echo $this->twigEnv->render(
            '@client/login.twig',
            array('pageTitle' => 'Entrar')
        );
    }

    public function handlePost()
    {
        return $this->model->onPost();
    }
}
