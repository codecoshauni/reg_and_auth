<?php

namespace App\Model;

class XmlGateway
{
    private $xml;

    public function __construct($users)
    {
        $this->xml = $users;
    }

    public function addUser(array $userData)
    {
        $salt = bin2hex(random_bytes(8));

        $user = $this->xml->addChild('user');
        $user->addChild('name', $userData['name']);
        $user->addChild('login', $userData['login']);
        $user->addChild('email', $userData['email']);
        $user->addChild('password', md5($userData['password'] . $salt));
        $user->addChild('salt', $salt);
        $user->addChild('token', ' ');
        $this->save();
    }

    private function save()
    {
        $this->xml->asXML ('../db/users.xml');
    }

    public function isLoginExist(string $login)
    {
        foreach ($this->xml->user as $user) {
            if ($login == $user->login) return true;
        }

        return false;
    }

    public function isEmailExist(string $email)
    {
        foreach ($this->xml->user as $user) {
            if ($email == $user->email) return true;
        }

        return false;
    }

    public function verifyPassword(string $login, string $password)
    {
        foreach ($this->xml->user as $user) {
            if ($login == $user->login) {
                return md5($password . $user->salt) == $user->password;
            }
        }
    }

    public function getNameByLogin(string $login)
    {
        foreach ($this->xml->user as $user) {
            if ($login == $user->login) {
                return $user->name;
            }
        }
    }

    public function getNameByLogToken(string $token)
    {
        foreach ($this->xml->user as $user) {
            if ($token == $user->token) {
                return $user->name;
            }
        }
    }

    public function isLogTokenExist(string $token)
    {
        foreach ($this->xml->user as $user) {
            if ($token == $user->token) return true;
        }

        return false;
    }

    public function addLogToken(string $logToken, string $login)
    {
        foreach ($this->xml->user as $user) {
            if ($login == $user->login) {
                $user->token = $logToken;
                $this->save();
            }
        }
    }
}