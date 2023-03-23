<?php
/* example of another controller
class Dashboard extends Controller
{
  public function __construct()
  {
    if (!isset($_SESSION['user_id'])) {
      redirect('users/login');
    }
    $this->registrationModel = $this->model('Registration');
    $this->userModel = $this->model('User');
    $this->dashboardModel = $this->model('Dashboards');
    //$this->categoryModel = $this->model('Category');
  }

  public function index()
  {
    $user_id = $_SESSION['user_id'];
    $btc= $this->dashboardModel->getBtcBalance($user_id);
    $profit= $this->dashboardModel->getTotalProfit($user_id);
    $countTransactions = $this->dashboardModel->getCountTransactions($user_id);
    $eth= $this->dashboardModel->getEthBalance($user_id);
    $ltc= $this->dashboardModel->getLtcBalance($user_id);
    $xrp= $this->dashboardModel->getXrpBalance($user_id);
    $getTotalProfitBtc= $this->dashboardModel->getTotalProfitBtc($user_id);
    $getTotalProfitEth= $this->dashboardModel->getTotalProfitEth($user_id);
    $getTotalProfitLtc= $this->dashboardModel->getTotalProfitLtc($user_id);
    $getTotalProfitXrp= $this->dashboardModel->getTotalProfitXrp($user_id);
    $transactions = $this->dashboardModel->getTransaction($user_id);
    $withdrawal= $this->dashboardModel->getWithdrawal($user_id);
    $data = [ 
      'withdrawal'=> $withdrawal,
      'profit' => $profit,
      'transactions' => $transactions,
      'btcBalance' => $btc,
      'countTransactions' => $countTransactions,
      'ethBalance' => $eth,
      'ltcBalance' => $ltc,
      'xrpBalance' => $xrp,
      'getTotalProfitBtc' => $getTotalProfitBtc,
      'getTotalProfitEth' => $getTotalProfitEth,
      'getTotalProfitLtc' => $getTotalProfitLtc,
      'getTotalProfitXrp' => $getTotalProfitXrp,
    ]; 
    $this->view('dashboard/home', $data);
  }
  public function trade()
  {
    $user_id = $_SESSION['user_id'];
    $btc = $this->dashboardModel->getBtcBalance($user_id);
    $totalGain = $this->dashboardModel->getTotalProfit($user_id);
    $countTransactions = $this->dashboardModel->getCountTransactions($user_id);
   // $eth= $this->dashboardModel->getEthBalance($user_id);
   // $ltc= $this->dashboardModel->getLtcBalance($user_id);
   // $xrp= $this->dashboardModel->getXrpBalance($user_id);
    $data = [ 
      'btcBalance' => $btc,
      'countTransactions' => $countTransactions,
      'totalGain' => $totalGain,
     // 'ethBalance' => $eth,
     // 'ltcBalance' => $ltc,
     // 'xrpBalance' => $xrp,
    ]; 
    $this->view('dashboard/trade', $data);
  }
  public function depositStart()
  {
    $user_id = $_SESSION['user_id'];
    $transactions = $this->dashboardModel->getTransaction($user_id);
    $data = [ 
      'transactions' => $transactions,
      'invest' => 'Starter',
      'value' => 1,
      'amount' => 250,
      'max' => 1250
      
    ]; 
    $this->view('others/topup', $data);
  }
  public function depositPremium()
  {
    $user_id = $_SESSION['user_id'];
    $transactions = $this->dashboardModel->getTransaction($user_id);
    $data = [ 
      'transactions' => $transactions,
      'invest' => 'Premium',
      'value' => 2,
      'amount' => 3000,
      'max' => 5250
    ]; 
    $this->view('others/topup', $data);
  }
  public function depositGold()
  {
    $user_id = $_SESSION['user_id'];
    $transactions = $this->dashboardModel->getTransaction($user_id);
    $data = [ 
      'transactions' => $transactions,
      'invest' => 'Gold',
      'value' => 3,
      'amount' => 10000,
      'max' => 15250
    ]; 
    $this->view('others/topup', $data);
  }
  public function depositDiamond()
  {
    $user_id = $_SESSION['user_id'];
    $transactions = $this->dashboardModel->getTransaction($user_id);
    $data = [ 
      'transactions' => $transactions,
      'invest' => 'Diamond',
      'value' => 4,
      'amount' => 3000,
      'max' => 35250
    ]; 
    $this->view('others/topup', $data);
  }
  public function withdraw()
  {
    $user_id = $_SESSION['user_id'];
    $transactions = $this->dashboardModel->getTransaction($user_id);
    $profit= $this->dashboardModel->getTotalProfit($user_id);
    $btc= $this->dashboardModel->getBtcBalance($user_id);
    $withdrawal= $this->dashboardModel->getWithdrawal($user_id);
    $eth= $this->dashboardModel->getEthBalance($user_id);
    $ltc= $this->dashboardModel->getLtcBalance($user_id);
    $xrp= $this->dashboardModel->getXrpBalance($user_id);
    $data = [ 
      'transactions' => $transactions,
      'profit' => $profit,
      'btcBalance' => $btc,
      'withdrawal' => $withdrawal,
      'ethBalance' => $eth,
      'ltcBalance' => $ltc,
      'xrpBalance' => $xrp,

    ]; 
    $this->view('dashboard/withdrawal', $data);
  }
  public function profile($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $data = [ 
      'id' => $id,
      'oldpassword' => trim($_POST['oldpassword']),
      'newpassword' => trim($_POST['newpassword']),
      'confirm' => trim($_POST['confirm']),
      'oldpassword_err' => '',
      'newpassword_err' => '',
      'confirm_err' => '',

    ];



    if (empty($data['oldpassword'])) {
      $data['oldpassword_err'] = 'Please enter your old password';

      if (empty($data['newpassword'])) {
        $data['newpassword_err'] = 'Please enter new password';
      }

      if (empty($data['confirm'])) {
        $data['confirm_err'] = 'Please confirm new password';
      }
    }
    if (empty($data['newpassword'])) {
      $data['newpassword_err'] = 'Please enter new password';

      if (empty($data['oldpassword'])) {
        $data['oldpassword_err'] = 'Please enter your old password';
      }  
      if (empty($data['confirm'])) {
        $data['confirm_err'] = 'Please confirm new password';
      }
    }
    if (empty($data['confirm'])) {
      $data['confirm_err'] = 'Please confirm new password';

      if (empty($data['oldpassword'])) {
        $data['oldpassword_err'] = 'Please enter your old password';
      }  
    
    if (empty($data['newpassword'])) {
      $data['newpassword_err'] = 'Please enter new password';
    }
  }
  $holdemail = $_SESSION['user_name']; 
  if(!$this->userModel->checkpassword($_SESSION['user_name'], $data['oldpassword'])){
    $data['oldpassword_err'] = 'Please enter correct password';
  }

  if (empty($data['oldpassword_err']) && empty($data['newpassword_err']) && empty($data['confirm_err'])) {

    $data['newpassword'] = password_hash($data['newpassword'], PASSWORD_DEFAULT);
    if ($this->userModel->updateUser($data)) {
    //  move_uploaded_file($fileTmpName, $fileDestination);
  //    move_uploaded_file($fileTmpNameAudio, $fileDestinationAudio);
      flash('member_added', 'Password Updated Successful');
      redirect('dashboard/profile/'.$_SESSION['user_id']);
    } else {
      die('Something went wrong');
    }
  } else {
    // Load view with errors
    flash('member_added', 'Please Fix Errors', 'alert alert-danger');
    $this->view('others/profile', $data);
  }


  }else {
    //  $lgas = $this->registrationModel->getLga();
      $data = [
        'oldpassword' => '',
        'newpassword' => '',
        'confirm' => '',
        'oldpassword_err' => '',
        'newpassword_err' => '',
        'confirm_err' => '',
      
      ];
    $this->view('others/profile', $data);
  }
}


public function transaction()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
      'amountHold' => trim($_POST['amountHold']),
      'assetHold2' => trim($_POST['assetHold2']),
      'assetHold67' => trim($_POST['assetHold67']),
      'user_id' => $_SESSION['user_id'],
    ];

    if ($this->dashboardModel->addTrasaction($data)) {
      //  move_uploaded_file($fileTmpName, $fileDestination);
    //    move_uploaded_file($fileTmpNameAudio, $fileDestinationAudio);
        flash('transaction_added', 'Transaction Pending', 'alert alert-warning');
        redirect('dashboard/depositStart');
  }
}
}
public function withdrawalTransaction()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
      'amountHold' => trim($_POST['amountHold']),
      'assetHold2' => trim($_POST['assetHold2']),
     // 'assetHold67' => trim($_POST['assetHold67']),
      'user_id' => $_SESSION['user_id'],
      'status' => '0',
      'checks' => '1',
    ];

    if ($this->dashboardModel->addWithdrawal($data)) {
      //  move_uploaded_file($fileTmpName, $fileDestination);
    //    move_uploaded_file($fileTmpNameAudio, $fileDestinationAudio);
        flash('transaction_added', 'Transaction Pending', 'alert alert-warning');
        redirect('dashboard/withdraw');
  }
}
}

  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST
      $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'parastatal' => trim($_POST['parastatal']),
        'title' => trim($_POST['title']),
        'lga' => trim($_POST['lga']),
        'lat' => trim($_POST['lat']),
        'lng' => trim($_POST['lng']),
        'address' => trim($_POST['address']),
        'file_err' => '',
        'file1_err' => '',
        'f_img' => '',
        'lgas_err' => '',
        'lat_err' => '',
        'lng_err' => '',
        'parastatal_err' => '',
        'title_err' => '',
        'address_err' => ''
      ];


      //$ff = $_FILES['file'];

      $fileName = $_FILES['file']['name'];
      $fileTmpName = $_FILES['file']['tmp_name'];
      $fileExt = explode('.', $fileName);
      $fileActualExt = strtolower(end($fileExt));
      // $fileNameNewAudio = uniqid('', true) . "." . $fileActualExtAudio;
      $fileDestination = '../public/props/image1/' . basename($fileName);
      if (empty($fileActualExt)) {
          $data['file_err'] = 'You have to upload the image here';
      } else {
          $data['img'] = $fileName;
      }

      // Validate email
      if (empty($data['lat'])) {
        $lgas = $this->registrationModel->getLga();
        $data['lat_err'] = 'Please enter your Lattitude';
        $data['lgas'] = $lgas;

        if (empty($data['lng'])) {
          $data['lng_err'] = 'Please enter your Longitude';
        }

        if (empty($data['address'])) {
          $data['address_err'] = 'Please enter location address';
        }

        if ($data['lga'] == 'Select LGA') {
          $data['lga_err'] = 'Please Select LGA';
        }
        if ($data['ward'] == 'Select Ward') {
          $data['ward_err'] = 'Please Select LGA';
        }
        if ($data['punit'] == 'Select Polling Unit') {
          $data['punit_err'] = 'Please Select LGA';
        }
      }
      if (empty($data['lng'])) {
        $lgas = $this->registrationModel->getLga();
        $data['lgas'] = $lgas;
        $data['lng_err'] = 'Please enter your Last name';

        if (empty($data['lat'])) {
          $data['lat_err'] = 'Please enter your Latitude';
        }

        if (empty($data['address'])) {
          $data['address_err'] = 'Please enter location address';
        }

        if ($data['lga'] == 'Select LGA') {
          $data['lga_err'] = 'Please Select LGA';
        }
        if ($data['ward'] == 'Select Ward') {
          $data['ward_err'] = 'Please Select LGA';
        }
        if ($data['punit'] == 'Select Polling Unit') {
          $data['punit_err'] = 'Please Select LGA';
        }
      }


      if ($data['lga'] == 'Select LGA') {
        $lgas = $this->registrationModel->getLga();
        $data['lgas'] = $lgas;
        $data['lga_err'] = 'Please Select LGA';
        if (empty($data['lat'])) {
          $data['lat_err'] = 'Please enter your Latitude';
        }
        if (empty($data['lng'])) {
          $data['lng_err'] = 'Please enter your Longitude';
        }

        if (empty($data['address'])) {
          $data['address_err'] = 'Please enter location address';
        }
        if ($data['ward'] == 'Select Ward') {
          $data['ward_err'] = 'Please Select LGA';
        }
        if ($data['punit'] == 'Select Polling Unit') {
          $data['punit_err'] = 'Please Select LGA';
        }
      }

      if (empty($data['address'])) {
        $data['address_err'] = 'Please enter location address';

        $lgas = $this->registrationModel->getLga();
        $data['lgas'] = $lgas;
      

        if (empty($data['lat'])) {
          $data['lat_err'] = 'Please enter your Latitude';
        }

        if (empty($data['lng'])) {
          $data['lng_err'] = 'Please enter Longitde';
        }

        if ($data['lga'] == 'Select LGA') {
          $data['lga_err'] = 'Please Select LGA';
        }
        if ($data['ward'] == 'Select Ward') {
          $data['ward_err'] = 'Please Select LGA';
        }
        if ($data['punit'] == 'Select Polling Unit') {
          $data['punit_err'] = 'Please Select LGA';
        }
      }



  
      // Make sure there are no errors

      if (empty($data['lat_err']) && empty($data['lng_err']) && empty($data['parastatal_err']) && empty($data['lga_err']) && empty($data['title_err']) && empty($data['address_err'])) {
        $data['id'] = $data['punit'];
        if ($this->registrationModel->addParastatal($data)) {
          move_uploaded_file($fileTmpName, $fileDestination);
      //    move_uploaded_file($fileTmpNameAudio, $fileDestinationAudio);
          flash('member_added', 'Registration Successful');
          redirect('registrations/add');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        flash('member_added', 'Please Fix Errors', 'alert alert-danger');
        $this->view('registration/add', $data);
      }
    } else {
      $lgas = $this->registrationModel->getLga();
      $data = [
        'lgas' => $lgas,
        'address' => '',
        'f_img' => '',
        's_img' => '',
        'lat' => '',
        'lng' => '',
        'file_err' => '',
        'file1_err' => '',
        'lgas_err' => '',
        'address_' => '',
        'lat_err' => '',
        'lng_err' => '',
      ];

      $this->view('registration/add', $data);
    }
  }
}
*/