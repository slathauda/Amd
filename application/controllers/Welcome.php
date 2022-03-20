<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Generic_model', '', TRUE);
        date_default_timezone_set('Asia/Colombo');

        if (!empty($_SESSION['userId'])) {

        } else {
//             redirect('/');
//            $this->load->view('modules/common/login');
        }
    }

    public function index()
    {
        //$this->load->view('welcome_message');
        if (!empty($_SESSION['userId'])) {
            redirect('user');

//            if ($_SESSION['role'] == 1) {
//                redirect('admin');
//            } else {
//                redirect('user');
//            }
        } else {
            // redirect('/');
            $data['sysinfo'] = $this->Generic_model->getData('com_det', array('cmne', 'synm', 'cplg'), array('stat' => 1));
            $this->load->view('modules/common/login', $data);
        }
    }

    // USER LOGOUT
    function logout()
    {
        if (!empty($_SESSION['userId'])) {

            $username = $this->session->userdata('username');
            $userid = $this->session->userdata('userId');
            //MAC Accress Code for PHP
            ob_start(); // Turn on output buffering
            system('ipconfig /all'); //Execute external program to display output
            $mycom = ob_get_contents(); // Capture the output into a variable
            ob_clean(); // Clean (erase) the output buffer
            $findme = "Physical";
            $pmac = strpos($mycom, $findme); // Find the position of Physical text
            $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
            //echo $mac;

            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                //'pid' => 49,
                //'pcd' => 'Logout',
                //'pnm' => 'User Logout',
                'func' => 'User Logout --> ' .$username,
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
                'mcid' => $mac,
            );
            $this->db->insert('user_log', $logdata_arr);

            $this->Generic_model->updateDataWithoutlog('user_mas', array('islg' => 0), array('auid' => $_SESSION['userId'])); // user table

            $this->session->sess_destroy();
            $this->index();
        } else {
            //$this->load->view('modules/common/login');
            redirect('/');
        }
    }

    //AUTO LOGOUT
    function auto_lgout()
    {
        if (!empty($_SESSION['userId'])) {
            $username = $this->session->userdata('username');
            $userid = $this->session->userdata('userId');
            //MAC Accress Code for PHP
            ob_start(); // Turn on output buffering
            system('ipconfig /all'); //Execute external program to display output
            $mycom = ob_get_contents(); // Capture the output into a variable
            ob_clean(); // Clean (erase) the output buffer
            $findme = "Physical";
            $pmac = strpos($mycom, $findme); // Find the position of Physical text
            $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
            //echo $mac;

            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                'func' => 'Auto Logout --> ' .$username,
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
                'mcid' => $mac,
            );
            $this->db->insert('user_log', $logdata_arr);
            $this->Generic_model->updateDataWithoutlog('user_mas', array('islg' => 0), array('auid' => $_SESSION['userId'])); // user table

            $this->session->sess_destroy();
            $this->index();
        } else {
            redirect('/');
        }
    }

    // SCHEDULE TIME OUT
    function schedule_lgout()
    {
        if (!empty($_SESSION['userId'])) {
            $username = $this->session->userdata('username');
            $userid = $this->session->userdata('userId');
            //MAC Accress Code for PHP
            ob_start(); // Turn on output buffering
            system('ipconfig /all'); //Execute external program to display output
            $mycom = ob_get_contents(); // Capture the output into a variable
            ob_clean(); // Clean (erase) the output buffer
            $findme = "Physical";
            $pmac = strpos($mycom, $findme); // Find the position of Physical text
            $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
            //echo $mac;

            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                'func' => 'Schedule Time Logout --> ' .$username,
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
                'mcid' => $mac,
            );
            $this->db->insert('user_log', $logdata_arr);
            $this->Generic_model->updateDataWithoutlog('user_mas', array('islg' => 0), array('auid' => $_SESSION['userId'])); // user table

            $this->session->sess_destroy();
            $this->index();
        } else {
            redirect('/');
        }
    }

    public function not_access()
    {
        $this->load->view('errors/html/403_error');
    }

    public function profile()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $this->db->select("");
        $this->db->from("user_mas");
        $this->db->join('brch_mas', 'user_mas.brch = brch_mas.brid', 'left');
        $this->db->join('user_level', 'user_mas.usmd = user_level.id ');
        $this->db->where("user_mas.stat", 1);
        $this->db->where("user_mas.auid", $_SESSION['userId']);

        $query = $this->db->get();
        $data['usrinfo'] = $query->result();


        $this->load->view('modules/common/profile', $data);
        $this->load->view('modules/common/footer');
    }

    public function upd_pass()  // update password
    {
        $cur_usr = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']), '');
        $pass = $this->input->post('cur_pss');
        $nw_pswd = $this->input->post('nw_pswd');
        //MAC Accress Code for PHP
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom = ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer
        $findme = "Physical";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
        //echo $mac;

        $res = password_verify($pass, $cur_usr[0]->lgps);

        if ($res == 1) {
            $newpassword = password_hash($nw_pswd, PASSWORD_DEFAULT);
            $where_arr = array(
                'auid' => $_SESSION['userId']
            );
            $data_ar = array(
                'lgps' => $newpassword,
            );
            $result = $this->Generic_model->updateDataWithoutlog('user_mas', $data_ar, $where_arr);

            $username = $this->session->userdata('username');
            $userid = $this->session->userdata('userId');

            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                'func' => 'User Update Password --> ' .$username,
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
                'mcid' => $mac,
            );
            $this->db->insert('user_log', $logdata_arr);

            echo json_encode(true);

        } else {
            echo json_encode(false);
        }
    }

    public function usr_update() // update user details
    {
        $where_arr = array(
            'auid' => $this->input->post('uid')
        );
        $data_ar = array(
            'fnme' => $this->input->post('fnm'),
            'lnme' => $this->input->post('lsnm'),
            'emid' => $this->input->post('emil'),
            'tpno' => $this->input->post('mo_no'),
            'almo' => $this->input->post('al_no'),
            'unic' => $this->input->post('nic'),
        );
        $result = $this->Generic_model->updateDataWithoutlog('user_mas', $data_ar, $where_arr);

        $username = $this->session->userdata('username');
        $userid = $this->session->userdata('userId');
        //MAC Accress Code for PHP
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom = ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer
        $findme = "Physical";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
        //echo $mac;

        $logdata_arr = array(
            'usid' => $userid,
            'usnm' => $username,
            'func' => 'User Update Profile --> ' .$username,
            'stat' => 1,
            'lgdt' => date('Y-m-d H:i:s'),
            'lgip' => $_SERVER['REMOTE_ADDR'],
            'mcid' => $mac,
        );
        $this->db->insert('user_log', $logdata_arr);

        if ($result > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // USER SCREEN LOCK
    public function lockscrn()
    {
        $this->load->view('modules/common/lock_screen');
    }

}
