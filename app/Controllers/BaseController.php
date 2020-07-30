<?php

namespace App\Controllers;

use App\Models\BaseModel;
use App\Models\AuthModel;

class BaseController
{
    private $DBModel;
    private $auth;

    function __construct()
    {
        $this->DBModel = new BaseModel();
        $this->auth = new AuthModel();
    }

    public function index(){
        $taskList = $this->DBModel->getTAskList();
        $adminStatus = $this->auth->getAdminStatus();

        $successAlert = partialView('successAlert');
        $errorAlert = partialView('errorAlert');
        $addTaskModal = partialView('addTaskModal', [
            'adminStatus' => $adminStatus
        ]);
        $adminLoginModal = partialView('adminLoginModal');

        $taskListBody = partialView('taskListBody', [
            'taskList' => $taskList
        ]);

        $pagination = $this->getPagination();

        return view('home', [
            'successAlert' => $successAlert,
            'errorAlert' => $errorAlert,
            'addTaskModal' => $addTaskModal,
            'adminLoginModal' => $adminLoginModal,
            'taskListBody' => $taskListBody,
            'pagination' => $pagination,
            'adminStatus' => $adminStatus
        ]);
    }

    public function saveTaskForm(){
        $adminStatus = $this->auth->getAdminStatus();

        $page = $this->DBModel->saveTask($adminStatus);

        echo json_encode(['activePage'=>$page]);
    }

    public function updateTaskList(){
        $taskList = $this->DBModel->getSortedTaskList();

        $taskListBody = partialView('taskListBody', ['taskList' => $taskList]);

        $pagination = $this->getPagination($_POST['active']);

        echo json_encode([
            'taskListBody'=>$taskListBody,
            'pagination'=>$pagination
        ]);
    }

    private function getPagination($active = 1){
        $DBModel = $this->DBModel;
        $pages = $DBModel->getPagesCount();

        $pagination = partialView('pagination', [
            'active' => $active,
            'pages' => $pages,
            'limit' => $DBModel::LIMIT
        ]);

        return $pagination;
    }

    public function dropDb() {
        $this->DBModel->initTables();
    }
}