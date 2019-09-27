<?php

namespace App\Controllers;

class RegistrationController  extends FormController
{
    protected function getRequestHandler()
    {
        $xsrfToken = $this->makeXsrfProtection();
        require_once('../templates/registration.php');
    }

    protected function postRequestHandler()
    {
        $this->verifyXsrfToken();

        $user['name'] = htmlentities(strval($_POST['name'] ?? ''), ENT_QUOTES);
        $user['email'] = htmlentities(strval($_POST['email'] ?? ''), ENT_QUOTES);
        $user['password'] = htmlentities(strval($_POST['password'] ?? ''), ENT_QUOTES);
        $user['confirm_password'] = htmlentities(strval($_POST['confirm_password'] ?? ''), ENT_QUOTES);
        $user['login'] = htmlentities(strval($_POST['login'] ?? ''), ENT_QUOTES);

        $error = $this->validator->validate($user);
        if (strlen($error) == 0) {
            $this->users->addUser($user);
            header("Content-Type: application/json");
            echo json_encode(['ok' => 'User was created successfully.']);
        } else {
            header("Content-Type: application/json");
            echo json_encode(['failed' => $error]);
        }
    }
}