<?php
class Pages extends Controller{
    public function __construct(){
        /*if login before load, uncomment this */
      /*  if(!isset($_SESSION['user_id'])){
            redirect('users/login');
        }*/
    }

    public function index(){
        $data = [
            'title' => 'Beulah Pikins MVC'
        ];
        $this->view('pages/index', $data);
        /* or  redirect('registrations/register');*/

    }
    
 
}