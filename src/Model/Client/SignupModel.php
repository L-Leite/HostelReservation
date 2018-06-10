<?php
namespace App\Model\Client;

use App\Model\BaseModel;

class SignupModel extends BaseModel
{
    public function isPost()
    {
        return isPostVarSet('doSignup') === true && getPostVar('doSignup') === '1';
    }

    public function isValidData()
    {
        return (isPostVarSet('firstn') === true
            || isPostVarSet('lastn') === true
            || isPostVarSet('username') === true
            || isPostVarSet('password') === true);
    }

    public function onPost()
    {
        if ($this->isValidData() === false) {
            $this->sendStatus('error', 'badData');
            return false;
        }

        $firstName = getPostVar('firstn');
        $lastName = getPostVar('lastn');
        $username = getPostVar('username');
        $password = getPostVar('password');

        $address = isPostVarSet('address') ? getPostVar('address') : null;
        $phoneNumber = isPostVarSet('phone') ? getPostVar('phone') : null;
        $email = isPostVarSet('email') ? getPostVar('email') : null;

        $createdUser = $this->db->newClient(
            $firstName,
            $lastName,
            $address,
            $phoneNumber,
            $email,
            $username,
            $password
        );

        if ($createdUser === false) {
            $this->sendStatus('error', 'userAlreadyExists');
            return false;
        }
        
        setSession($this->db->getNewClientId());
        $this->sendStatus('ok');
        return true;
    }
}
