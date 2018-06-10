<?php
namespace App\Model\Admin;

use App\Model\BaseModel;

class LoginModel extends BaseModel
{
    public function isPost()
    {
        return isPostVarSet('doLogin') === true && getPostVar('doLogin') === '1';
    }

    public function isValidData()
    {
        return (isPostVarSet('username') === true
            || isPostVarSet('password') === true);
    }

    public function onPost()
    {
        if ($this->isValidData() === false) {
            $this->sendStatus('error', 'badData');
            return false;
        }

        $username = getPostVar('username');
        $password = getPostVar('password');

        $adminId = $this->db->loginAdmin(
            $username,
            $password
        );

        if ($adminId == null) {
            $this->sendStatus('error', 'badAdmin');
            return false;
        }

        setAdminSession($adminId);
        $this->sendStatus('ok');
        return true;
    }
}
