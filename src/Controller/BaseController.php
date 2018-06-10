<?php
namespace App\Controller;

class BaseController
{
    protected $twigEnv;
    protected $model;

    public function __construct($twigEnv)
    {
        $this->twigEnv = $twigEnv;
    }

    public function shouldRender()
    {
        throw new \Exception('shouldRender: Implement me!');
    }

    public function render()
    {
        throw new \Exception('render: Implement me!');
    }

    public function handlePost()
    {
        throw new \Exception('handlePost: Implement me!');
    }
}
