<?php

namespace App\Models;

use PDO;
use Josantonius\Session\Session;

class AuthModel extends BaseModel {

    public function loginUser() {
        $checkUser = 'SELECT id, status FROM admins where username = :username and password = :password';
        $stmt = $this->DB->prepare($checkUser);

        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($result['status'])) {
            $checkUser = "UPDATE admins set status ='loggedin' where id = :id";
            $stmt = $this->DB->prepare($checkUser);
            $stmt->bindParam(':id', $result['id']);
            $stmt->execute();

            Session::set('loggedin', $result['id']);
            $result['status'] = 'loggedin';
        }

        return $result;
    }

    public function logoutUser() {
        $loggedIn = Session::get('loggedin');

        if($loggedIn) {
            $checkUser = "UPDATE admins set status ='loggedout' where id = :id";
            $stmt = $this->DB->prepare($checkUser);
            $stmt->bindParam(':id', $loggedIn);
            $stmt->execute();

            Session::pull('loggedin');
            Session::regenerate();
        }
    }

    public function getAdminStatus() {
        $loggedIn = Session::get('loggedin');

        if($loggedIn) {
            $checkUser = 'SELECT status FROM admins where id = :id';
            $stmt = $this->DB->prepare($checkUser);

            $stmt->bindParam(':id', $loggedIn);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result) {
                if('loggedin' == $result['status']) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}