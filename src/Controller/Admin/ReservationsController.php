<?php
namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Model\Admin\ReservationsModel;

class ReservationsController extends BaseController
{
    public function __construct($twigEnv)
    {
        parent::__construct($twigEnv);
        $this->model = new ReservationsModel();
    }

    public function shouldRender()
    {
        return true;
    }

    public function render()
    {
        $reservations = $this->model->getData();
        echo $this->twigEnv->render(
            '@admin/reservations.twig',
            array('pageTitle' => 'Reservas', 'reservations' => $reservations)
        );
    }
}
