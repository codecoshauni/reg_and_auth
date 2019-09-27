<?php

namespace App\Model;

class Validator
{
    const EMPTY_FIELD_ERROR = 'You entered an empty field.';
    const EXISTED_LOGIN = 'This login is already exiist.';
    const EXISTED_EMAIL = 'This email is already exiist.';
    const PASS_MATCH = 'Passwords do not match.';

    private $users;

    public function __construct(XmlGateway $users)
    {
        $this->users = $users;
    }

    public function validate(array $user)
    {
        $error = '';

        foreach ($user as $e) {
            if (strlen($e) == 0) {
                $error .= self::EMPTY_FIELD_ERROR . ' ';
                break;
            }
        }

        if ($this->users->isLoginExist($user['login'])) $error .= self::EXISTED_LOGIN . ' ';
        if ($this->users->isEmailExist($user['email'])) $error .= self::EXISTED_EMAIL . ' ';
        if ($user['password'] != $user['confirm_password']) $error .= self::PASS_MATCH;

        return $error;
    }
}