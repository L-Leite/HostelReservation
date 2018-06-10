<?php
namespace App\Controller;

use App\Controller\BaseController;

class CoverController extends BaseController
{
    public function shouldRender()
    {
        return true;
    }

    public function render()
    {
        echo $this->twigEnv->render(
            '@client/cover.twig',
            array('pageTitle' => 'Reserve hosteis')
        );
    }
}
