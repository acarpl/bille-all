<?php
// app/controllers/HomeController.php

class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'Home',
            'current_route' => 'home'
        ];
        
        $this->view('home/index', $data);
    }
    
    public function about() {
        $data = [
            'title' => 'About Us',
            'current_route' => 'about'
        ];
        
        $this->view('home/about', $data);
    }
}
?>