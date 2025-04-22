<?php
class Pages extends Controller
{

   
    public function __construct()
    {
       
    }

    public function index()
    {
        // Load View
        $this->view('home');
    }

    public function about()
    {
        // Load View
        $this->view('about');
    }
    public function contact()
    {
        // Load View
        $this->view('contact');
    }

    public function terms()
    {
        // Load View
        $this->view('terms');
    }
    public function privacy()
    {
        // Load View
        $this->view('privacy');
    }
}