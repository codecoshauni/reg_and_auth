<?php

namespace App\Controllers;

use App\Model\Validator;
use App\Model\XmlGateway;

abstract class FormController
{
    protected $users;
    protected $validator;

    abstract protected function postRequestHandler();

    public function __construct(XmlGateway $users, Validator $validator)
    {
        $this->users = $users;
        $this->validator = $validator;
    }

    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->getRequestHandler();
        } elseif($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->postRequestHandler();
        }
    }

    protected function verifyXsrfToken()
    {
        $xsrfTokenFromForm = strval($_POST['xsrfToken'] ?? '');
        $xsrfTokenFromCookie = $_COOKIE['xsrfToken'];
        if ($xsrfTokenFromForm != $xsrfTokenFromCookie) {
            header("HTTP/1.0 505");
            die();
        }
    }

    protected function makeXsrfProtection()
    {
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

        return $xsrfToken;
    }
}