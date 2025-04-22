<?php

use PHPMailer\PHPMailer\PHPMailer;
use Ramsey\Uuid\Uuid;

class Users extends Controller
{
  private $userModel;
  public function __construct()
  {
    $this->userModel = $this->model('User');
  }

  


  public function register()
  {
    // Redirect if already logged in
    if (isLoggedIn()) {
      redirect('registrations/add');
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      try {
        // Check CSRF Token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
          flash('flash_message', 'Invalid token. Please try again.', 'alert alert-danger');
          redirect('users/register');
          return;
        }

        // Regenerate CSRF Token after validation to prevent replay attacks
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        // Sanitize input
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
          'uuid' => Uuid::uuid4()->toString(),
          'username' => trim($_POST['username'] ?? ''),
          'email' => trim($_POST['email'] ?? ''),
          'password' => trim($_POST['password'] ?? ''),
          'confirm_password' => trim($_POST['confirm_password'] ?? ''),
          'csrf_token' => $_SESSION['csrf_token'], // Include new CSRF token for the next request
          'errors' => []
        ];

        // Validate Input
        $errors = validateRegistration($data, $this->userModel);
        if (!empty($errors)) {
          $data['errors'] = $errors;
          flash('flash_message', 'Please fix the errors below.', 'alert alert-danger');
          $this->view('users/register', $data);
          return;
        }

        // Hash password before storing it
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Register user
        if (!$this->userModel->register($data)) {
          throw new Exception('Database error: User registration failed.');
        }

        flash('flash_message', 'Registration successful! Please login.', 'alert alert-success');
        redirect('users/login');
      } catch (Exception $e) {
        throw $e; // Bootstrap handles logging
      }
    } else {
      // Generate a fresh CSRF token when displaying the form
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

      // Load empty form
      $this->view('users/register', [
        'username' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'csrf_token' => $_SESSION['csrf_token'], // Pass CSRF token to the form
        'errors' => []
      ]);
    }
  }



  public function login()
{
    // Redirect if already logged in
    if (isLoggedIn()) {
        redirect('pages/index');
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            flash('flash_message', 'Invalid token. Please try again.', 'alert alert-danger');
            redirect('users/login');
            return;
        }

        // Sanitize input
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
            'email' => trim($_POST['email'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'errors' => []
        ];

        // Validate input
        $data['errors'] = validateLogin($data);

        if (empty($data['errors'])) {
            // Attempt login
            $loggedInUser = $this->userModel->login($data['email'], $data['password']);

            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
                return;
            }

            flash('flash_message', 'Invalid Credentials', 'alert alert-danger');
        } else {
            flash('flash_message', 'Please fix the errors below.', 'alert alert-danger');
        }

        // Reload view with errors
        $this->view('users/login', $data);
        return;
    }

    // Generate a new CSRF token
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Load login form
    $this->view('users/login', [
        'email' => '',
        'password' => '',
        'csrf_token' => $_SESSION['csrf_token'], // Pass token to the view
        'errors' => []
    ]);
}

  // Create User Session
  private function createUserSession($user)
  {
    $_SESSION[SESSION_USER_KEY] = $user->uuid;
    $_SESSION[SESSION_NAMESPACE . 'email'] = $user->email;
    $_SESSION[SESSION_NAMESPACE . 'username'] = $user->username;
    redirect('pages/index');
  }

  // Logout & Destroy Session
  public function logout()
  {
    session_unset(); // Clears all session variables
    session_destroy(); // Destroys the session
    redirect('users/login');
  }


}