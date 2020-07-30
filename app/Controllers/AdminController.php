<?php

namespace App\Controllers;

use App\Models\AuthModel;

class AdminController
{
    private $auth;

    function __construct()
    {
        $this->auth = new AuthModel();
    }

    public function loginAttempt(){
        $result = $this->auth->loginUser();

        echo json_encode(['status'=>$result['status']]);
    }

    public function logoutAttempt(){
        $result = $this->auth->logoutUser();

        echo json_encode(['status'=>$result['status']]);
    }
}