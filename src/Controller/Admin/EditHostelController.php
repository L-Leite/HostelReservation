<?php
namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Model\Admin\EditHostelModel;

class EditHostelController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new EditHostelModel();
    }

    public function shouldRender()
    {
        return $this->model->isPost() === false;
    }

    public function render()
    {
        if ($this->model->hasData() === false) {
            \redirectTo('admin/hostels');
        }

        $data = $this->model->getData();
        $data['pageTitle'] = 'Editar hostel';

        echo $this->twigEnv->render(
            '@admin/edit_hostel.twig',
            $data
        );
    }

    public function handlePost()
    {
        return $this->model->onPost();
    }
}
