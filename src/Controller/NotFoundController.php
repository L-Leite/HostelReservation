<?php
namespace App\Controller;

use App\Controller\BaseController;

class NotFoundController extends BaseController
{
    public function shouldRender()
    {
        true;
    }

    public function render()
    {
        echo $this->twigEnv->render('notfound.twig', array('pageTitle' => '404'));
    }
}
