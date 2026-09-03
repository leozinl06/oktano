<?php

require_once __DIR__ . "/../core/BaseController.php";

class DashboardPersonalController extends BaseController{

    public function index(){
        require_once __DIR__ . '/../views/pages/dashboard_personal.php';
    }
}