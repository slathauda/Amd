<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
        $this->output->delete_cache();

        $this->load->model('login_model');
        $this->load->model('Generic_model', '', TRUE);
        date_default_timezone_set('Asia/Colombo');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            $this->load->view('login');
        } else {
            redirect('/dashboard');
        }
    }


    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $username = $this->input->post('usname');
        $password = $this->input->post('paswrd');
        // $digeye = $this->input->post('digeye');


        $result = $this->login_model->loginMe($username, $password);

        $nowtime = date('H');
        // IF CHECK USER LOGIN TIME AND USER MODE
        if ($nowtime < 23 & 1 < $nowtime || $result[0]->usmd == 1) {
            if (count($result) > 0) {
                if ($result[0]->acst == '3') {
                    redirect('?message=userlock'); // User lock 3 times use wrong password
                } else {
                    //if ($result[0]->lgcd == $digeye) {
                    foreach ($result as $res) {
                        $sessionArray = array('userId' => $res->auid,
                            'username' => $res->usnm,
                            'role' => $res->usmd,
                            'roleText' => $res->desg,
                            'fname' => $res->fnme,
                            'lname' => $res->lnme,
                            'uimg' => $res->uimg,
                            'lsip' => $res->llip,
                            'lsdt' => $res->lldt,
                            'isLoggedIn' => TRUE
                        );
                        $ip = $_SERVER['REMOTE_ADDR'];
                        //MAC Accress Code for PHP
                        ob_start(); // Turn on output buffering
                        system('ipconfig /all'); //Execute external program to display output
                        $mycom = ob_get_contents(); // Capture the output into a variable
                        ob_clean(); // Clean (erase) the output buffer
                        $findme = "Physical";
                        $pmac = strpos($mycom, $findme); // Find the position of Physical text
                        $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
                        //echo $mac;

                        $this->Generic_model->updateDataWithoutlog('user_mas', array('acst' => 0, 'lgcd' => null, 'llip' => $ip, 'lldt' => date('Y-m-d H:i:s'), 'islg' => 1), array('auid' => $res->auid));
                        $logdata_arr = array(
                            'usid' => $res->auid,
                            'usnm' => $res->usnm,
                            'func' => 'User Login --> ' . $res->usnm,
                            'stat' => 1,
                            'lgdt' => date('Y-m-d H:i:s'),
                            'lgip' => $_SERVER['REMOTE_ADDR'],
                            'mcid' => $mac,
                        );
                        $this->db->insert('user_log', $logdata_arr);

//                    if ($res->usmd == 1) {
//                        $this->session->set_userdata($sessionArray);
//                        redirect('/admin?message=success');
//                    } elseif ($res->usmd == 5) {
//                        $this->session->set_userdata($sessionArray);
//                        redirect('/user');
//                    }  else {
//                        redirect('/');
//                    }
                        $this->session->set_userdata($sessionArray);
                        redirect('/user?message=success');
                    }
                    //} else {
                    //    redirect('?message=wrngLgcd'); // wrong login code
                    //}
                }
            } else {
            $result2 = $this->login_model->checkUserName($username, $password);
            if (count($result2) > 0) {
                if ($result2[0]->acst == '3') {
                    redirect('?message=userlock'); // User lock 3 times use wrong password
                } else {
                    $chnc = $result2[0]->acst + 1;
                    $this->Generic_model->updateDataWithoutlog('user_mas', array('acst' => $chnc), array('auid' => $result2[0]->auid));
                    redirect('?message=wrngTry' . $chnc);
                }
            } else {
                redirect('?message=fail');
            }
            // redirect('/');
        }
    } else
{
    //redirect('?message=wrongtime');
redirect('?message=sys_update');
}

}

/**
 * This function used to generate reset password request link
 */
function resetPasswordUser()
{
    $status = '';

    $this->load->library('form_validation');

    $this->form_validation->set_rules('login_email', 'Email', 'trim|required|valid_email|xss_clean');

    if ($this->form_validation->run() == FALSE) {
        $this->forgotPassword();
    } else {
        $email = $this->input->post('login_email');

        if ($this->login_model->checkEmailExist($email)) {
            $encoded_email = urlencode($email);

            $this->load->helper('string');
            $data['email'] = $email;
            $data['activation_id'] = random_string('alnum', 15);
            $data['createdDtm'] = date('Y-m-d H:i:s');
            $data['agent'] = getBrowserAgent();
            $data['client_ip'] = $this->input->ip_address();

            $save = $this->login_model->resetPasswordUser($data);

            if ($save) {
                $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                if (!empty($userInfo)) {
                    $data1["name"] = $userInfo[0]->name;
                    $data1["email"] = $userInfo[0]->email;
                    $data1["message"] = "Reset Your Password";
                }

                $sendStatus = resetPasswordEmail($data1);

                if ($sendStatus) {
                    $status = "send";
                    setFlashData($status, "Reset password link sent successfully, please check mails.");
                } else {
                    $status = "notsend";
                    setFlashData($status, "Email has been failed, try again.");
                }
            } else {
                $status = 'unable';
                setFlashData($status, "It seems an error while sending your details, try again.");
            }
        } else {
            $status = 'invalid';
            setFlashData($status, "This email is not registered with us.");
        }
        redirect('/forgotPassword');
    }
}

/**
 * This function used to load forgot password view
 */
public
function forgotPassword()
{
    $this->load->view('forgotPassword');
}

// This function used to reset the password

function createPasswordUser()
{
    $status = '';
    $message = '';
    $email = $this->input->post("email");
    $activation_id = $this->input->post("activation_code");

    $this->load->library('form_validation');

    $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
    $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');

    if ($this->form_validation->run() == FALSE) {
        $this->resetPasswordConfirmUser($activation_id, urlencode($email));
    } else {
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');

        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

        if ($is_correct == 1) {
            $this->login_model->createPasswordUser($email, $password);

            $status = 'success';
            $message = 'Password changed successfully';
        } else {
            $status = 'error';
            $message = 'Password changed failed';
        }

        setFlashData($status, $message);

        redirect("/login");
    }
}

// This function used to create new password

function resetPasswordConfirmUser($activation_id, $email)
{
    // Get email and activation code from URL values at index 3-4
    $email = urldecode($email);

    // Check activation id in database
    $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

    $data['email'] = $email;
    $data['activation_code'] = $activation_id;

    if ($is_correct == 1) {
        $this->load->view('newPassword', $data);
    } else {
        redirect('/login');
    }
}

}

?>
