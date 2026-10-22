<?php
require_once __DIR__ . '/../core/BaseController.php';

class DashboardPraticanteController extends BaseController{

    public function index() {
        $this->exigirAutenticacao('praticante');
        require_once __DIR__ . '/../views/pages/dashboard_praticante.php';
    }
}