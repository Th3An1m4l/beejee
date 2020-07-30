<?php

namespace App\Models;

use PDO;
use App\Models\AuthModel;

class BaseModel {

    const LIMIT = 3;
    public $DB;

    function __construct()
    {
        $this->DB = new PDO('sqlite:storage/taskList.sqlite3');
        $this->DB->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
    }

    public function getTaskList() {
        return $this->DB->query('SELECT * FROM tasks ORDER BY id ASC LIMIT ' . self::LIMIT);
    }

    public function getSortedTaskList() {
        $baseQry = 'SELECT * FROM tasks';
        $orderQry = '';
        $limitQry = ' limit ' . self::LIMIT;
        $offsetQry = ' OFFSET ';

        $offsetValue = (($_POST['active']-1) * self::LIMIT);

        foreach ($_POST as $sortKey => $sortValue) {
            if('active' == $sortKey) continue;
            $orderQry .= ($orderQry && $sortValue) ? ', ' : '';
            $orderQry .= ($sortValue) ? $sortKey . ' ' . $sortValue : '';
        }

        $orderQry = ($orderQry) ? ' ORDER BY ' . $orderQry : '';

        $finalQry = $baseQry . $orderQry . $limitQry;

        $finalQry .= ($offsetValue) ? $offsetQry . $offsetValue : '';

        return $this->DB->query($finalQry);
    }

    public function getPagesCount() {
        $result = $this->DB->query('SELECT count(id) as cnt FROM tasks');

        return ceil($result->fetchColumn()/self::LIMIT);
    }

    public function saveTask($adminStatus) {

        if(!$adminStatus) {
            $insert = "INSERT INTO tasks (username, email, description, status, created_at, updated_at) 
                VALUES (:username, :email, :description, 'new', :created_at, 0)";
            $stmt = $this->DB->prepare($insert);

            $created_at = time();

            if(!isset($_POST['username']) || !isset($_POST['email'])) return false;

            $username = $_POST['username'];
            $email = $_POST['email'];
            $description = $this->clearPostInput($_POST['description']);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':created_at', $created_at);
        } else {
            $id = $_POST['taskId'];
            $result = $this->DB->query('SELECT description, updated_at FROM tasks where id = ' . $id);

            $result = $result->fetchAll(PDO::FETCH_ASSOC);
            $descriptionOrig = $result[0]['description'];

            $insert = "UPDATE tasks set description = :description, status = :status, updated_at = :updated_at where id = :id";
            $stmt = $this->DB->prepare($insert);

            $description = $this->clearPostInput($_POST['description']);
            $updated_at = ($descriptionOrig != $description) ? time() : $result[0]['updated_at'] ;

            $status = (isset($_POST['status'])) ? 'completed' : 'new';

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':updated_at', $updated_at);
        }

        $stmt->execute();

        $result = $this->DB->query('SELECT count(id) as cnt FROM tasks');

        $result = ceil($result->fetchColumn()/self::LIMIT);

        return $result;
    }

    public function initTables() {
        // Drop table messages from file db
        $this->DB->exec("DROP TABLE IF EXISTS tasks");
        $this->DB->exec("DROP TABLE IF EXISTS admins");

        // Create table tasks
        $this->DB->exec("CREATE TABLE IF NOT EXISTS tasks (
                    id INTEGER PRIMARY KEY,
                    username TEXT,
                    email TEXT,
                    description TEXT,
                    status TEXT,
                    created_at INTEGER,
                    updated_at INTEGER)");

        // Create table admins
        $this->DB->exec("CREATE TABLE IF NOT EXISTS admins (
                    id INTEGER PRIMARY KEY,
                    username TEXT,
                    password TEXT,
                    status TEXT,
                    created_at INTEGER,
                    updated_at INTEGER)");

        // Prepare to create demo account admin:123
        $insert = "INSERT INTO admins (username, password, status, created_at, updated_at) 
                VALUES (:username, :password, 'loggedout', :created_at, 0)";
        $stmt = $this->DB->prepare($insert);

        $username = 'admin';
        $password = md5('123');
        $created_at = time();

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':created_at', $created_at);

        // Execute statement
        $stmt->execute();
    }

    private function clearPostInput($input) {
        $input = htmlspecialchars($input, ENT_QUOTES);
        $input = strip_tags($input);

        return $input;
    }
}