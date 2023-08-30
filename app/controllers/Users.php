<?php
/*user controller for authentication*/
use PHPMailer\PHPMailer\PHPMailer;

class Users extends Controller
{
  private $userModel;
  public function __construct()
  {
    $this->userModel = $this->model('User');
  }
  /*
    public function index(){
      redirect('registrations/add');
    }
*/
  public function register()
  {
    // Check if logged in
    if ($this->isLoggedIn()) {
      redirect('registrations/add');
    }

    // Check if POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'phone' => trim($_POST['phone']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'phone_err' => '',
        'profileImage_err' => ''
      ];


      // Check if image file is a actual image or fake image


      // Check if file already exists


      // Validate email
      if (empty($data['name'])) {
        $data['name_err'] = 'Please enter Full Name';
      }
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter an email';
        // Validate name
        if (empty($data['name'])) {
          $data['name_err'] = 'Please enter Full Name';
        }
      } else {
        // Check Email
        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email is already taken.';
        }
      }

      // Validate password
      if (empty($data['password'])) {
        $password_err = 'Please enter a password.';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must have atleast 6 characters.';
      }

      // Validate confirm password
      if (empty($data['phone'])) {
        $data['phone_err'] = 'Please enter phone number.';
      }

      // Make sure errors are empty
      if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['phone_err']) && empty($data['profileImage_err'])) {
        // SUCCESS - Proceed to insert

        // Hash Password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        //Execute
        if ($this->userModel->register($data)) {
          // move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file);
          // Redirect to login
          flash('register_success', 'You are now registered, please log in');
          $email = $data['email'];
          $mail = new PHPMailer;
          $mail->isSMTP();
          $mail->SMTPDebug = 0;
          $mail->Host = 'smtp.hostinger.com';
          $mail->Port = 587;
          $mail->SMTPAuth = true;
          $mail->Username = 'info@whalewaver.net';
          $mail->Password = 'Muyi@1994';
          $mail->setFrom('info@whalewaver.net', 'Whalewavers.net');
          $mail->addReplyTo('info@whalewaver.net/', 'Whalewavers.net');
          $mail->addAddress("$email", "Successful Registration");
          $mail->Subject = 'Whalewavers.net Registration';
          $mail->msgHTML(file_get_contents('tt.html'), __DIR__);
          $mail->Body = '<h2>Whalewavers.net</h2><p> We are so happy to have you on board. Don\'t wait too long before you activate your first investment. </p>';
          if (!$mail->send()) {
          }
          redirect('users/login');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load View
        $this->view('users/registration', $data);
      }
    } else {
      // IF NOT A POST REQUEST

      // Init data
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'phone' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'phone_err' => '',
        'profileImage_err' => ''
      ];

      // Load View
      $this->view('users/registration', $data);
    }
  }

  public function login()
  {
    // Check if logged in
    if ($this->isLoggedIn()) {
      redirect('dashboard');
    }

    // Check if POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => '',
      ];

      // Check for email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter name.';
      }

      // Check for name
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password.';
      }

      // Check for user
      if ($this->userModel->findUserByEmail($data['email'])) {
        // User Found
      } else {
        // No User
        $data['email_err'] = 'This user is not registered.';
      }

      // Make sure errors are empty
      if (empty($data['email_err']) && empty($data['password_err'])) {

        // Check and set logged in user
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);

        if ($loggedInUser) {
          // User Authenticated!
          $this->createUserSession($loggedInUser);
        } else {
          $data['password_err'] = 'Password incorrect.';
          // Load View
          $this->view('users/login', $data);
        }
      } else {
        // Load View
        $this->view('users/login', $data);
      }
    } else {
      // If NOT a POST

      // Init data
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => '',
      ];

      // Load View
      $this->view('users/login', $data);
    }
  }
  public function pass_reset()
  {
    // Check if logged in
    if ($this->isLoggedIn()) {
      redirect('dashboard');
    }

    // Check if POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),
        'email_err' => ''
      ];

      // Check for email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter a valid email.';
      }

      if ($this->userModel->findUserByEmail($data['email'])) {
        // User Found
      } else {
        // No User
        $data['email_err'] = 'This user is not registered.';
      }

      // Make sure errors are empty
      if (empty($data['email_err'])) {

        // Check and set logged in user
        $email = $data['email'];
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'info@whalewaver.net';
        $mail->Password = 'Muyi@1994';
        $mail->setFrom('info@whalewaver.net', 'Whalewavers.net');
        $mail->addReplyTo('info@whalewaver.net/', 'Whalewavers.net');
        $mail->addAddress("$email", "Password Reset");
        $mail->Subject = 'Whalewavers.net Registration';
        $mail->msgHTML(file_get_contents('tt.html'), __DIR__);
        $mail->Body = '<h2>Whalewavers.net Password Reset</h2><p> <a href="'.URLROOT.'/">Click here to reset your password</a> </p>';
        if (!$mail->send()) {
        }
redirect('users/pass_reset');
    
      } else {
        // Load View
        $this->view('users/pass_reset', $data);
      }
    } else {
      // If NOT a POST

      // Init data
      $data = [
        'email' => '',
        'email_err' => ''
      ];

      // Load View
      $this->view('users/pass_reset', $data);
    }
  }

  // Create Session With User Info
  public function createUserSession($user)
  {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_name'] = $user->email;
    $_SESSION['fullname'] = $user->fullname;
    $_SESSION['phone'] = $user->phone;
    $_SESSION['image'] = $user->image;
   // session_start();
   // $_SESSION["email"] = $email;
    $nownow = date("l jS \of F Y h:i:s A");
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'info@whalewaver.net';
    $mail->Password = 'Muyi@1994';
    $mail->setFrom('info@whalewaver.net', 'Whalewavers.net');
    $mail->addReplyTo('info@whalewaver.net/', 'Whalewavers.net');
    $mail->addAddress("$user->email", "Login Alert");
    $mail->Subject = 'Whalewavers.net Login Notification';
    $mail->msgHTML(file_get_contents('tt.html'), __DIR__);
    $mail->Body = '<h2>Whalewavers.net</h2><p> Please be informed that your Whalewaver Account was accessed on <strong>' . $nownow . '</strong> </p>';
    if (!$mail->send()) {
    }
    redirect('dashboard');
  }

  // Logout & Destroy Session
  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['fullname']);
    unset($_SESSION['phone']);
    unset($_SESSION['image']);
    session_destroy();
    redirect('users/login');
  }

  // Check Logged In
  public function isLoggedIn()
  {
    if (isset($_SESSION['user_id'])) {
      return true;
    } else {
      return false;
    }
  }
}
