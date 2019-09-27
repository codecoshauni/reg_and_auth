<?php

namespace App\Controllers;

class AuthorizationController extends FormController
{
    protected function getRequestHandler()
    {
        session_start();
        if (isset($_SESSION['loggedIn'])) {
            $this->helloUser('token', $_COOKIE['logToken']);
        } elseif (isset($_COOKIE['logToken'])) {
            if ($this->users->isLogTokenExist($_COOKIE['logToken'])) {
                session_start();
                $_SESSION['loggedIn'] = 1;
                $this->helloUser('token', $_COOKIE['logToken']);
            }
        } else {
            $xsrfToken =  bin2hex(random_bytes(32));
            setcookie(
                'xsrfToken',
                $xsrfToken,
                strtotime('+1 hour'),
                null,
                null,
                null,
                true
            );
            $xsrfToken = $this->makeXsrfProtection();
            require_once('../templates/authorization.php');
        }
    }


    protected function postRequestHandler()
    {
        $this->verifyXsrfToken();

        $user['password'] = htmlentities(strval($_POST['password'] ?? ''), ENT_QUOTES);
        $user['login'] = htmlentities(strval($_POST['login'] ?? ''), ENT_QUOTES);
        $this->verifyUser($user);

        $this->logInUser($user['login']);
    }

    private function logInUser(string $login)
    {
        $logToken = bin2hex(random_bytes(32));
        $this->users->addLogToken($logToken, $login);
        setcookie(
            'logToken',
            $logToken,
            strtotime('+24 hour'),
            null,
            null,
            null,
            true
        );
        session_start();
        $_SESSION['loggedIn'] = 1;

        $this->helloUser('login', $login);
    }

    private function helloUser(string $by, string $value)
    {
        if ($by == 'login') {
            $name = $this->users->getNameByLogin($value);
        } else {
            $name = $this->users->getNameByLogToken($value);
        }

        header("Content-Type: application/json");
        echo json_encode(['ok' => "Hello! " . $name]);
    }

    private function verifyUser(array $user)
    {
        if (!$this->users->isLoginExist($user['login'])) {
            header("Content-Type: application/json");
            echo json_encode(['failed' => 'Nonexistent user.']);
            die();
        }

        if (!$this->users->verifyPassword($user['login'], $user['password'])) {
            header("Content-Type: application/json");
            echo json_encode(['failed' => 'Wrong password.']);
            die();
        }
    }
}