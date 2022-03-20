<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
        $this->output->delete_cache();

        $this->load->model('Generic_model', '', TRUE); // load model
        $this->load->model('Admin_model', '', TRUE); // load model
        date_default_timezone_set('Asia/Colombo');

        if (!empty($_SESSION['userId'])) {
            if ($_SESSION['role'] != 1) {
                if ($_SESSION['role'] != 2) {
                    redirect('welcome/not_access');
                }
            }
        } else {
            redirect('/');
        }
    }

    public function index()
    {
        $this->load->view('modules/common/tmp_header');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $data);

        $this->load->view('modules/admin/dashboard');
        $this->load->view('modules/common/footer');

        //$this->load->view('modules/common/cus_script_full_width');
        // $this->load->view('modules/customer/includes/custom_scripts_customer');
        // $this->load->view('modules/common/custom_scripts_common');
    }

// COMMON DATA
    function chk_brnchName()
    {
        $brnm = $this->input->post('brnm');

        $result = $this->Generic_model->getData('brch_mas', array('brcd', 'brnm'), array('brnm' => $brnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function chk_brnchCode()
    {
        $brcd = $this->input->post('brcd');

        $result = $this->Generic_model->getData('brch_mas', array('brcd', 'brnm'), array('brcd' => $brcd));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }


    function chk_brnchName_edt()
    {
        $brnm = $this->input->post('brnm');
        $auid = $this->input->post('auid');

        $result = $this->Generic_model->getData('brch_mas', array('brid', 'brnm'), array('brnm' => $brnm, 'stat' => 1));
        if (count($result) > 0) {
            if ($result[0]->brid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function chk_brnchCode_edt()
    {
        $brcd = $this->input->post('brcd');
        $auid = $this->input->post('auid');

        $result = $this->Generic_model->getData('brch_mas', array('brid', 'brcd'), array('brcd' => $brcd, 'stat' => 1));
        if (count($result) > 0) {
            if ($result[0]->brid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function chk_usrnm()
    {
        $usnm = $this->input->post('usnm');

        $result = $this->Generic_model->getData('user_mas', array('usnm'), array('usnm' => $usnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function chk_usrnm_edt()
    {
        $usnm = $this->input->post('usnm');
        $auid = $this->input->post('auid');

        $result = $this->Generic_model->getData('user_mas', array('usnm'), array('usnm' => $usnm, 'stat' => 1));
        if (count($result) > 0) {
            if ($result[0]->brid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // Get user data
    public function getUser()
    {
        $bid = $this->input->post('brid');
        $uslv = $this->input->post('uslv');

        $this->db->select("auid,fnme,lnme,brch");
        $this->db->from("user_mas");
        $this->db->where('user_mas.usmd  != 1');
        $this->db->where('user_mas.stat', 1);
        if ($bid != 'all') {
            $this->db->where('user_mas.brch ', $bid);
        }
        if ($uslv != 'all') {
            $this->db->where('user_mas.usmd ', $uslv);
        }

        $query = $this->db->get();
        echo json_encode($query->result());
    }


// END COMMON DATA
//
// branch
    public function brnch_mng()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);
        $this->load->view('modules/admin/branch_managmnt');

        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/footer');
    }

    function srchBrnch()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('brnch_mng');
        $stat = $this->input->post('stat');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }

        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "hidden";
        }

        $this->db->select("brch_mas.*,aa.brcust");
        $this->db->from("brch_mas");
        $this->db->join("(SELECT aa.brco, COUNT(*)  AS brcust
        FROM `cus_mas` AS aa WHERE  stat IN(1,3,4) GROUP BY aa.brco )AS aa ",
            'aa.brco = brch_mas.brid ', 'left'); //customer count
        if ($stat != 'all') {
            $this->db->where('brch_mas.stat ', $stat);
        }
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;

        foreach ($result as $row) {
            $st = $row->stat;
            $auid = $row->brid;

            if ($row->brcust > 0) {
                $rej2 = "disabled";
            } else {
                $rej2 = "";
            }

            if ($st == '1') {  //active
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' $edt data-toggle='modal' data-target='#modalEdt' onclick='edtBrn($auid);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rej2 $rej onclick='rejecBrnc($auid);' class='btn btn-default btn-condensed' title='Inactive'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '0') {  // inactive
                $stat = " <span class='label label-danger'> Inactive </span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'   disabled onclick='rejecNmCust( );' class='btn btn-default btn-condensed $reac' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvBrnc($auid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->brad;
            $sub_arr[] = $row->brtp;

            $sub_arr[] = $row->brem;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }
        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    function addBranch()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $brcd = strtoupper($this->input->post('brcd'));
        $data_arr = array( //strtoupper()
            'brcd' => $brcd,
            'brnm' => ucwords(strtolower($this->input->post('brnm'))),
            'brad' => $this->input->post('brad'),
            'brtp' => $this->input->post('brtp'),
            'brem' => $this->input->post('breml'),
            'stat' => 1,
            'remk' => $this->input->post('remk'),
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('brch_mas', $data_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('brnch_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Branch (' . $brcd . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function rejBranch()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('brch_mas', array('stat' => 0), array('brid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('brnch_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Branch Inactive (' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function reactBranch()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('brch_mas', array('stat' => 1), array('brid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('brnch_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Branch Reactive (' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function vewBranch()
    {
        $this->db->select("brch_mas.*,aa.brcust");
        $this->db->from("brch_mas");
        $this->db->join("(SELECT aa.brco, COUNT(*)  AS brcust
        FROM `cus_mas` AS aa WHERE  stat IN(1,3,4) GROUP BY aa.brco )AS aa ",
            'aa.brco = brch_mas.brid ', 'left'); //customer count

        $this->db->where('brch_mas.brid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function edtBranch()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_arr = array(
            'brcd' => strtoupper($this->input->post('brcd_edt')),
            'brnm' => ucwords(strtolower($this->input->post('brnm_edt'))),
            'brad' => $this->input->post('brad_edt'),
            'brtp' => $this->input->post('brtp_edt'),
            'brem' => $this->input->post('breml_edt'),
            'brwb' => $this->input->post('brwb_edt'),
            'stat' => 1,
            'remk' => $this->input->post('remk_edt'),
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s'),
        );
        $where_arr = array(
            'brid' => $this->input->post('auid')
        );
        $result22 = $this->Generic_model->updateData('brch_mas', $data_arr, $where_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('brnch_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Update Branch ' . strtoupper($this->input->post('brcd_edt')));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//  End Branch
//
// FAQ
    public function faq()
    {
        $this->load->view('modules/common/tmp_header');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $data);

        $this->load->view('modules/admin/faq_support');
        $this->load->view('modules/common/footer');

        $this->load->view('modules/common/cus_script_full_width');
        // $this->load->view('modules/customer/includes/custom_scripts_customer');
        // $this->load->view('modules/common/custom_scripts_common');
    }
// END FAQ
//
// USER MANAGEMENT
    public function user_mng()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['userlvl'] = $this->Generic_model->getUserLvl();
        $data['cvlst'] = $this->Generic_model->getData('cvl_stst', '', '');

        $this->load->view('modules/admin/user_management', $data);
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
        $this->load->view('modules/common/footer');
    }

    function srchUser()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('user_mng');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "hidden";
        }

        $result = $this->Admin_model->get_userDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $img = "<img src='../uploads/userimg/" . $row->uimg . "'  class='sm-image' title='" . $row->usnm . "' style='width: 27px;height: 27px' />";

            if ($st == '1') {  // Approved

                if ($row->acst == 3) {      // USER LOCK
                    $stat = " <span class='label label-warning' title='Bad Loging'> Lock </span> ";
                    $option = "<button type='button' $viw  data-toggle='modal' data-target='#modalView' onclick='viewUser($row->auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtUser($row->auid ,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='rej' " . $rej . "  onclick='rejecUser($row->auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> " .
                        "<button type='button' id='rej' " . $rej . "  onclick='unlockUser($row->auid);' class='btn btn-default btn-condensed' title='Unlock User'><i class='fa fa-unlock' aria-hidden='true'></i></button> ";

                } else {
                    $stat = " <span class='label label-success'> Active </span> ";
                    $option = "<button type='button' $viw  data-toggle='modal' data-target='#modalView' onclick='viewUser($row->auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtUser($row->auid ,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='rej' " . $rej . "  onclick='rejecUser($row->auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> " .
                        "<button type='button' id='rej' " . $rej . "  onclick='keyResetUser($row->auid);' class='btn btn-default btn-condensed' title='Reset Password'><i class='fa fa-key' aria-hidden='true'></i></button> ";
                }

            } else if ($st == '0') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' disabled  data-toggle='modal' data-target='#modalView' onclick='viewPrdt($row->auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtUser(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvUser($row->auid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' disabled  onclick='rejecUser($row->auid);' class='btn btn-default btn-condensed' title='Reset Password'><i class='fa fa-key' aria-hidden='true'></i></button> ";
            }

            $lslg = " <span title='Login ip : $row->llip'> $row->lldt </span> ";
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            //$sub_arr[] = $img;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->fnme . ' ' . $row->lnme;
            $sub_arr[] = $row->almo;
            // $sub_arr[] = $row->unic;
            $sub_arr[] = $row->lvnm;

            // $sub_arr[] = $row->jidt;
            $sub_arr[] = $lslg;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->all_user(),
            "recordsFiltered" => $this->Admin_model->filtered_user(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // IMAGE UPLOADE
    function saveimage()
    {
        //set random name for the image, used time() for uniqueness

        $filename = time() . '.jpg';
        $filepath = 'uploads/userimg/';

        move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath . $filename);

        // echo base_url().$filepath.$filename;
        echo $filename;

    }

    // ADD NEW USER
    function add_user()
    {
        $usrImg = $this->input->post('camImg');
        // customer profile image
        if (!empty($_FILES['picture']['name'])) {
            $config['upload_path'] = 'uploads/userimg/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            // $config['max_width'] = '1024';
            // $config['max_height'] = '768';
            $config['file_name'] = $_FILES["picture"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('picture')) {
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else if (!empty($usrImg)) {
            $picture = $usrImg;
        } else {
            $picture = 'user_default.png';
            // $picture = $img;
        }

        if ($this->input->post('prtp') == '') {
            $prmd = 1;
        } else {
            $prmd = 0;
        }
        $funm = $this->input->post('funm');
        $innm = $this->input->post('innm');
        $email = $this->input->post('emil');
        $usnm = $this->input->post('usnm');
        $fnme = $this->input->post('fnme');
        $lnme = $this->input->post('lnme');

        // SEND MAIL CONFIGURATION
        /*$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://mail.northpony.com',
            'smtp_port' => 465,
            'smtp_user' => 'noreply@northpony.com', // change it to yours
            'smtp_pass' => '&8,SlFRE_D3y', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            // 'charset' => 'utf-8',
            'wordwrap' => TRUE
        );*/

        // The mail sending protocol.
        // LINK >>>  https://www.formget.com/codeigniter-gmail-smtp/

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'gemunu@gdcreations.com', // change it to yours
            'smtp_pass' => 'gemunu@gd2017', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            // 'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        $comdt = $this->Generic_model->getData('com_det', array('cmne', 'syln'), array('stat' => 1));
        $systnm = $comdt[0]->cmne;
        $sysLink = $comdt[0]->syln;
        // SEND MAIL MESSAGE
        $message = "<tbody>
        <tr><td bgcolor='#F6F8FA' style='background-color:#F6F8FA; padding:12px; border-bottom:1px solid #ECECEC'></td>
        </tr><tr><td style=''><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody>
        <tr><td style='padding:24px 0 48px'><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody>
        <tr><td align='center' style='padding:0 2.2% 32px; text-align:center'><h2 style='margin:0; word-wrap:break-word; color:#262626; word-break:; font-weight:700; font-size:20px; line-height:1.2'></h2><h2 style='margin:0; color:#262626; font-weight:200; font-size:20px; line-height:1.2'> Get Started On Your " . $systnm . " System Account Now. </h2></td></tr>
        <tr><td align='center' style=''><table border='0' class='x_face-grid x_small' cellspacing='0' cellpadding='0' width='100%' style='table-layout:fixed'><tbody>Thank you for join with us, " . $fnme . ' ' . $lnme . "<br><br>To get started, activate your account by setting up your username and password. .<br><br>Username: " . $usnm . "<br>Password: 123 <br>Digital Eye : 123456 <br><br></tbody></table></td></tr>
        <tr><td align='center' style='text-align:center'><h2 style='margin:0; color:#262626; font-weight:200; font-size:20px; line-height:1.2'> <a href=' " . $sysLink . "'  style='color:#008CC9; display:inline-block; text-decoration:none'>Login to System</a></h2></td></tr></tbody></table></td></tr></tbody></table></td></tr>
        <tr><td style=''><table border='0' cellspacing='0' cellpadding='0' width='100%' bgcolor='#EDF0F3' align='center' style='background-color:#EDF0F3; padding:0 24px; color:#999999; text-align:center'><tbody>
        <tr><td style=''><table align='center' border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody><tr><td valign='middle' align='center' style='padding:0 0 16px 0; vertical-align:middle; text-align:center'></td></tr></tbody></table><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody><tr><td align='center' style='padding:0 0 12px 0; text-align:center'><p style='margin:0; color:#737373; font-weight:400; font-size:12px; line-height:1.333'>This is a system generated email to help you to get Login Details.</p></td></tr>
        <tr><td align='center' style='padding:0 0 12px 0; text-align:center'><p style='margin:0; word-wrap:break-word; color:#737373; word-break:break-word; font-weight:400; font-size:12px; line-height:1.333'>If you have any questions or if you are encountering problems, our support team at support@gdcreations.com is happy to assist you. Alternatively, you can visit our Support Desk.</p></td></tr>
        <tr><td align='center' style='padding:0 0 8px 0; text-align:center'></td></tr>
        </tbody></table></td></tr></tbody></table></td></tr></tbody>";


        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('noreply@northpony.com', $systnm);   // change it to yours
        $this->email->to($email);                               // change it to yours    'gamunu@gdcreations.com'
        $this->email->subject('Get Started On Your ' . $systnm . ' Account.');
        $this->email->message($message);
        if ($this->email->send()) {
            //echo 'Email sent.';
            $data_arr = array(
                'brch' => $this->input->post('brch'),
                'usmd' => $this->input->post('uslv'),
                'usnm' => $usnm,
                //'funm' => ucwords(strtolower($funm)),
                //'innm' => ucwords(strtolower($innm)),
                'fnme' => ucwords(strtolower($fnme)),
                'lnme' => ucwords(strtolower($lnme)),
                'desg' => ucwords(strtolower($this->input->post('desg'))),
                'prmd' => $prmd,
                'emid' => $email,
                'tpno' => $this->input->post('tele'),
                'almo' => $this->input->post('mobi'),

                'unic' => strtoupper($this->input->post('nic')),
                'udob' => $this->input->post('dobi'),
                'gend' => $this->input->post('gend'),
                'civl' => $this->input->post('civl'),
                'lgps' => '$2y$10$BtGWzcCm1CK6ui/h8E6iVu824xPpRD72DOV.AZgHur4P0kIlm18hK',
                'lgcd' => '123456',

                'uimg' => $picture,
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('user_mas', $data_arr);
            if (count($result) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            show_error($this->email->print_debugger());
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('user_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New User : ' . $this->input->post('usnm'));
    }

    function userDtils()
    {
        $auid = $this->input->post('auid');
        $this->db->select("user_mas.*,brch_mas.brnm,user_level.lvnm,cus_gen.gndt,cvl_stst.cvdt ");
        $this->db->from("user_mas");
        $this->db->join('brch_mas', 'brch_mas.brid = user_mas.brch', 'left');
        $this->db->join('user_level', 'user_level.id = user_mas.usmd', 'left');
        $this->db->join('cus_gen', 'cus_gen.gnid = user_mas.gend', 'left');
        $this->db->join('cvl_stst', 'cvl_stst.cvid = user_mas.civl', 'left');

        $this->db->where('user_mas.auid', $auid);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // Update & approval User
    function user_update()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $usrImgEdt = $this->input->post('camImgEdt');
        if (!empty($_FILES['picture']['name'])) {
            // previous image delete
            $path = "uploads/userimg/";
            $imagename = $this->input->post('usrimg');
            // Default User image not delete
            if ($imagename != 'user_default.png') {
                unlink($path . $imagename);
            }
            // User profile image upload
            $config['upload_path'] = 'uploads/userimg/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '500'; //KB
            // $config['max_width'] = '1024';
            // $config['max_height'] = '768';
            $config['file_name'] = $_FILES["picture"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('picture')) {
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else if (!empty($usrImgEdt)) {
            $path = "uploads/userimg/";
            $imagename = $this->input->post('usrimg');
            if ($imagename != 'user_default.png') {
                unlink($path . $imagename);
            }
            $picture = $usrImgEdt;
        } else {
            $picture = $this->input->post('usrimg');
        }

        if ($this->input->post('prtp_edt') == '') {
            $prmd = 1;
        } else {
            $prmd = 0;
        }

        $data_ar1 = array(
            'brch' => $this->input->post('brch_edt'),
            'usmd' => $this->input->post('uslv_edt'),
            'usnm' => $this->input->post('usnm_edt'),
            'funm' => ucwords(strtolower($this->input->post('funm_edt'))),
            'innm' => ucwords(strtolower($this->input->post('innm_edt'))),
            'fnme' => ucwords(strtolower($this->input->post('fnme_edt'))),
            'lnme' => ucwords(strtolower($this->input->post('lnme_edt'))),
            'desg' => ucwords(strtolower($this->input->post('desg_edt'))),
            'prmd' => $prmd,
            'emid' => $this->input->post('emil_edt'),
            'tpno' => $this->input->post('tele_edt'),
            'almo' => $this->input->post('mobi_edt'),

            'unic' => strtoupper($this->input->post('nic_edt')),
            'udob' => $this->input->post('dobi_edt'),
            'gend' => $this->input->post('gend_edt'),
            'civl' => $this->input->post('civl_edt'),

            'uimg' => $picture,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        );

        $where_arr = array(
            'auid' => $this->input->post('auid')
        );

        $result22 = $this->Generic_model->updateData('user_mas', $data_ar1, $where_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('user_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'User Update : ' . $this->input->post('fnme_edt'));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function rejUser()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('user_mas', array('stat' => 0, 'tmby' => $_SESSION['userId'], 'tmdt' => date('Y-m-d H:i:s')), array('auid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('user_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'User Inactive (auid :' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // user reactive
    function reactUser()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('user_mas', array('stat' => 1, 'mdby' => $_SESSION['userId'], 'mddt' => date('Y-m-d H:i:s')), array('auid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('user_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'User Reactive (auid :' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }

    // user password reset
    function resetPass()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('id');
        $data_arr = array(
            'lgps' => '$2y$10$BtGWzcCm1CK6ui/h8E6iVu824xPpRD72DOV.AZgHur4P0kIlm18hK',
            'lgcd' => '123456',
            'upby' => $_SESSION['userId'],
            'updt' => date('Y-m-d H:i:s'),
        );

        $result = $this->Generic_model->updateData('user_mas', $data_arr, array('auid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('user_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'User Password Reset (auid :' . $id . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // user unlock
    function userUnlock()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('user_mas', array('acst' => 0), array('auid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('user_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'User Unlock (auid :' . $id . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

// END USER MANAGEMENT
//
//
// COMPANY INFO
    public function cmpny_info()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $data['compnyinfo'] = $this->Generic_model->getData('com_det', '', array('stat'=>1));

        $this->load->view('modules/admin/company_details', $data);
        //$this->load->view('modules/common/cus_script_full_width');
        //$this->load->view('modules/common/custom_js_common');
        $this->load->view('modules/common/footer');
    }

    function updateBranding()
    {
        // REPORT LOGO
        if (!empty($_FILES['picture']['name'])) {
            // previous image delete
            $path = "uploads/report_logo/";
            $rplg_old = $this->input->post('rplg');
            // Default User image not delete
            if ($rplg_old != 'default.jpg') {
                unlink($path . $rplg_old);
            }
            // User profile image upload
            $config['upload_path'] = 'uploads/report_logo/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '500'; //KB
            // $config['max_width'] = '1024';
            // $config['max_height'] = '768';
            $config['file_name'] = $_FILES["picture"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('picture')) {
                $uploadData = $this->upload->data();
                $rplg = $uploadData['file_name'];
            } else {
                $rplg = 'default.jpg';
            }
        } else {
            $rplg = $this->input->post('rplg');
        }
        // COMPANY LOGO
//        if (!empty($_FILES['picture2']['name'])) {
//            // previous image delete
//            $path = "uploads/compny_logo/";
//            $cplg_old = $this->input->post('cplg');
//            // Default User image not delete
//            if ($cplg_old != 'default.jpg') {
//                unlink($path . $cplg_old);
//            }
//            // User profile image upload
//            $config['upload_path'] = 'uploads/compny_logo/';
//            $config['allowed_types'] = 'jpg|jpeg|png|gif';
//            $config['encrypt_name'] = TRUE;
//            $config['max_size'] = '500'; //KB
//            // $config['max_width'] = '1024';
//            // $config['max_height'] = '768';
//            $config['file_name'] = $_FILES["picture2"]['name'];
//
//            //Load upload library and initialize configuration
//            $this->load->library('upload', $config);
//            $this->upload->initialize($config);
//
//            if ($this->upload->do_upload('picture2')) {
//                $uploadData = $this->upload->data();
//                $cplg = $uploadData['file_name'];
//            } else {
//                $cplg = 'default.jpg';
//            }
//        } else {
//            $cplg = $this->input->post('cplg');
//        }

        $data_ar1 = array(
            'cmne' => $this->input->post('cpnm'),  // ucwords(strtolower())
            'synm' => strtoupper($this->input->post('synm')),
            'cadd' => ucwords(strtolower($this->input->post('cpadd'))),
            'ctel' => $this->input->post('cpph'),
            'ceml' => $this->input->post('emil'),
            'chot' => $this->input->post('mobi'),
            'rplg' => $rplg,
            //'cplg' => $cplg,
            'regn' => strtoupper($this->input->post('rgno')),
            'regd' => $this->input->post('rgdt'),
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        );

        //$date=date_create("2013-03-15");
        echo date_format($this->input->post('rgdt'),"Y-m-d");
        var_dump(date_format($this->input->post('rgdt'),"Y-m-d"));

        $where_arr = array(
            'cmid' => $this->input->post('auid')
        );
        $result22 = $this->Generic_model->updateData('com_det', $data_ar1, $where_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('cmpny_info');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Company Details Update ');
        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

// END COMPANY INFO
//
// USER ACTIVITY LOG
    public function activty_log()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['userlvl'] = $this->Generic_model->getUserLvl();
        $data['uslvlinfo'] = $this->Generic_model->getData('user_level', '', "stat = 1 AND id != 1");
        $data['cvlst'] = $this->Generic_model->getData('cvl_stst', '', '');

        $this->load->view('modules/admin/activity_log', $data);
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
        $this->load->view('modules/common/footer');
    }

    // Recent activity search
    function srchActivit()
    {
        $result = $this->Admin_model->get_recntDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $img = "<img src='../uploads/userimg/" . $row->uimg . "'  class='sm-image' title='" . $row->usnm . "' style='width: 27px;height: 27px' />";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $img . $row->usnm;
            if ($row->pnm != '' && $row->func != '') {
                $sub_arr[] = $row->pnm . ' --> ' . $row->func;
            } else if ($row->pnm != '') {
                $sub_arr[] = $row->pnm;
            } else if ($row->func != '') {
                $sub_arr[] = $row->func;
            }
            $date = date_create($row->lgdt);
            $sub_arr[] = date_format($date, 'g:i:s A \o\n l j F Y ');
            //$sub_arr[] = date_format($date, 'g:ia \o\n l jS F Y');
            $sub_arr[] = $row->lgip;

            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->all_recnt(),
            "recordsFiltered" => $this->Admin_model->filtered_recnt(),
            "data" => $data,
        );
        echo json_encode($output);
        //$funcPerm = $this->Generic_model->getFuncPermision('recn_actv');
        //$this->Log_model->userFuncLog($funcPerm[0]->pgid, 'View Recent Activity');

    }

// END ACTIVITY
//
// system permision
    function permis()
    {
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['uslvlinfo'] = $this->Generic_model->getUserLvl();

        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $this->load->view('modules/admin/permision', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        // $this->load->view('modules/customer/includes/custom_scripts_customer');
        // $this->load->view('modules/common/custom_scripts_common');


//        $this->load->view('modules/admin/activity_log', $data);
//        $this->load->view('modules/common/cus_script_full_width');
//        $this->load->view('modules/common/custom_js_common');
//        $this->load->view('modules/common/footer');
    }

    // normal permission
    function srchPermis()
    {
        $prtp = $this->input->post('prtp');
        $uslv = $this->input->post('uslv');
        $user = $this->input->post('user');

        $this->db->select("user_prmis.prid,user_prmis.pgac,user_prmis.view,user_prmis.inst,user_prmis.edit,user_prmis.apvl,user_prmis.rejt,user_prmis.reac,  user_page.pgnm,user_page.aid ,user_page.mntp  ");
        $this->db->from("user_prmis");  // user_page    user_prmis
        $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
        $this->db->where('user_prmis.stat', 1);
        if ($prtp == '1') {     // default permission
            $this->db->where('user_prmis.prtp', 0);
            $this->db->where('user_prmis.ulid', $uslv);
        } else if ($prtp == '2') {  // manuel permission
            $this->db->where('user_prmis.prtp', 1);
            $this->db->where('user_prmis.usid', $user);
        }

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // advance permission
    function srchPermisAdvn()
    {
        $prtp = $this->input->post('prtp');
        $uslv = $this->input->post('uslv');
        $user = $this->input->post('user');

        $this->db->select("user_prmis.prid,user_prmis.prnt,user_prmis.rpnt,  user_page.pgnm,user_page.aid   ");
        $this->db->from("user_prmis");  // user_page    user_prmis
        $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
        $this->db->where('user_prmis.stat', 1);
        $this->db->where('user_page.adpr', 1);

        if ($prtp == '1') {         // default permission
            $this->db->where('user_prmis.prtp', 0);
            $this->db->where('user_prmis.ulid', $uslv);
        } else if ($prtp == '2') {      // manuel permission
            $this->db->where('user_prmis.prtp', 1);
            $this->db->where('user_prmis.usid', $user);
        }

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // normal permission add
    function edtPermin()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $len = $this->input->post('len');

        for ($a = 0; $a < $len; $a++) {
            $prid = $this->input->post("prid[" . $a . "]");
            $view = $this->input->post("view[" . $a . "]");
            $inst = $this->input->post("inst[" . $a . "]");
            $edit = $this->input->post("edit[" . $a . "]");
            $rejt = $this->input->post("rejt[" . $a . "]");
            $apvl = $this->input->post("apvl[" . $a . "]");
            $pgac = $this->input->post("pgac[" . $a . "]");
            $reac = $this->input->post("reac[" . $a . "]");

            $data_ar1 = array(
                'pgac' => $pgac,
                'view' => $view,
                'inst' => $inst,
                'edit' => $edit,
                'rejt' => $rejt,
                'apvl' => $apvl,
                'reac' => $reac
            );
            $result1 = $this->Generic_model->updateData('user_prmis', $data_ar1, array('prid' => $prid));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Normal Permission Update');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    // advance permission add
    function edtPerminAdvan()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $len = $this->input->post('lensp');

        for ($a = 0; $a < $len; $a++) {
            $prid = $this->input->post("prid[" . $a . "]");

            $prnt = $this->input->post("prnt[" . $a . "]");
            $rpnt = $this->input->post("rpnt[" . $a . "]");

            $data_ar1 = array(
                'prnt' => $prnt,
                'rpnt' => $rpnt
            );
            $result1 = $this->Generic_model->updateData('user_prmis', $data_ar1, array('prid' => $prid));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Advance permission Update');


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    // module search & add new module
    function srchModul()
    {
        $prtp = $this->input->post('prtp');
        $uslv = $this->input->post('uslv'); // user level id
        $brch = $this->input->post('brch');
        $user = $this->input->post('user'); // user id

        $this->db->select(" ");
        $this->db->from("user_page");
        $this->db->where('user_page.stst', 1);

        if ($prtp == 1) {
            $this->db->where("user_page.aid NOT IN (SELECT aid FROM `user_page` AS c 
            JOIN user_prmis AS d ON  c.aid = d.pgid WHERE d.ulid = '$uslv') ");
        } elseif ($prtp == 2) {
            $this->db->where("user_page.aid NOT IN (SELECT aid FROM `user_page` AS c 
            JOIN user_prmis AS d ON  c.aid = d.pgid WHERE d.usid = '$user') ");
        }


        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function addModul()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $len = $this->input->post('mdlen');
        $uslv = $this->input->post('uslvl');
        $usid = $this->input->post('usid');
        $ptp = $this->input->post('ptp');

        if ($ptp == 1) { // default
            $prtp = 0;
            $uslv2 = $uslv;
            $usid2 = 0;
        } else {          // manuel
            $prtp = 1;
            $uslv2 = 0;
            $usid2 = $usid;
        }

        for ($a = 0; $a < $len; $a++) {

            $addm = $this->input->post("addm[" . $a . "]");
            $aid = $this->input->post("aid[" . $a . "]");

            if (!empty($addm)) {
                $data_ar1 = array(
                    'pgid' => $aid,
                    'prtp' => $prtp,
                    'ulid' => $uslv2,
                    'usid' => $usid2,
                    //'pgac' => 1,
                    'stat' => 1
                );

                $result = $this->Generic_model->insertData('user_prmis', $data_ar1);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }
// END PERMISSION

// product
    public function product()
    {
        //$this->Log_model->userLog('product');  // user log
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['prdtypeinfo'] = $this->Generic_model->getData('prdt_typ', '', array('stat' => 1, 'prbs' => 1));
        $data['caltype'] = $this->Generic_model->getData('pnl_cal_type', '', '');           // penalty cal type
        $data['calbase'] = $this->Generic_model->getData('pnl_cal_base', '', '');           // penalty cal base on
        $data['chrgmode'] = $this->Generic_model->getData('prd_chrg_mode', '', array('stat' => 1));         // product charge mode
        $data['pnlcndit'] = $this->Generic_model->getData('pnl_cond', '', '');              // penalty condition
        $data['policyinfo'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2', 'pov3'), array('poid' => 14, 'stat' => 1));
        $data['samelninfo'] = $this->Generic_model->getData('sys_policy', array('post'), array('poid' => 18, 'stat' => 1));

        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('product');
        $this->load->view('modules/admin/product_management', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
    }

    function srchProduct()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('product');
        //$this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Product Search');
        // var_dump($funcPerm[0]->pgid);
        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }

        $result = $this->Admin_model->get_productDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $st = $row->stat;
            $auid = $row->auid;
            if ($st == '1') {  //active
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button'$viw  data-toggle='modal' data-target='#modalView' onclick='viewPrdt($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtPrdt($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPrdt($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecPrdt($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {  //pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' data-toggle='modal' data-target='#modalView' onclick='viewPrdt($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtPrdt($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    " <button type='button' id='app' " . $app . " data-toggle='modal' data-target='#modalEdt' onclick='edtPrdt($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' " . $rej . " onclick='rejecPrdt($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '0') {  // inactive
                $stat = " <span class='label label-danger'> Inactive </span> ";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modalView' onclick='viewPrdt();' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPrdt(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    " <button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPrdt(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' disabled onclick='rejecPrdt( );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }
            $indx = " <span class='label label-default'> $row->lcnt </span> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm; //brcd
            $sub_arr[] = $row->prna;
            $sub_arr[] = $row->prnm;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($row->lamt, 2);
            $sub_arr[] = number_format($row->rent, 2);
            $sub_arr[] = $row->nofr . ' ' . $row->pymd;
            $sub_arr[] = $indx;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->all_prduct(),
            "recordsFiltered" => $this->Admin_model->filtered_prduct(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function chk_prdcode()
    {
        $prcd = $this->input->post('prcd');
        $brco = $this->input->post('brco');

        $result = $this->Generic_model->getData('product', array('auid', 'brid', 'prcd'), array('prcd' => $prcd, 'brid' => $brco));
        $result2 = $this->Generic_model->getData('product', array('auid', 'brid', 'prcd'), array('prcd' => $prcd, 'prtp IN(6,7,8)'));

        if (count($result) > 0 || count($result2) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function chk_prdcode_edt()
    {
        $prcd = $this->input->post('prcd');
        $auid = $this->input->post('auid');

        $result = $this->Generic_model->getData('product', array('auid', 'prcd'), array('prcd' => $prcd));

        if (count($result) > 0) {
            if ($result[0]->auid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function chk_alrdyPrduct()
    {
        $lnamt = $this->input->post('lnamt');
        $noins = $this->input->post('noins');
        $brnc = $this->input->post('brnc');
        $prct = $this->input->post('prct');

        $result = $this->Generic_model->getData('product', array('auid', 'lamt', 'nofr'), array('brid' => $brnc, 'lamt' => $lnamt, 'nofr' => $noins, 'prtp' => $prct, 'stat' => 1));

        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function chk_alrdyPrduct_edt()
    {
        $lnamt = $this->input->post('lnamt');
        $noins = $this->input->post('noins');
        $auid = $this->input->post('auid');
        $brnc = $this->input->post('brnc');
        $prct = $this->input->post('prct');

        $result = $this->Generic_model->getData('product', array('auid', 'lamt', 'nofr'), array('brid' => $brnc, 'lamt' => $lnamt, 'nofr' => $noins, 'prtp' => $prct, 'stat' => 1));

        if (count($result) > 0) {
            if ($result[0]->auid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function addProduct()
    {
        $policyinfo = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2', 'pov3'), array('popg' => 'product', 'stat' => 1));

        $prct = $this->input->post('prd_cat');
        $dytp = $this->input->post('dytp');

        if ($prct == 3) {
            $nofr = $this->input->post('dyn_dura');

            $aa = ($nofr / 30);

            if ($dytp == 5) {
                $dts = $policyinfo[0]->pov1 * $aa;
            } else if ($dytp == 6) {
                $dts = $policyinfo[0]->pov2 * $aa;
            } else if ($dytp == 7) {
                $dts = $policyinfo[0]->pov3 * $aa;
            }

        } else {
            $nofr = $this->input->post('noins');
            $dts = $this->input->post('noins');
        }

        $data_arr = array(
            'brid' => $this->input->post('prd_brn'),
            'prtp' => $this->input->post('prd_cat'),
            'prnm' => ucwords(strtolower($this->input->post('prnm'))),
            'prcd' => strtoupper($this->input->post('prcd')),
            'lcnt' => $this->input->post('lnid'),

            'prmd' => $this->input->post('prd_md'),
            'cldw' => $this->input->post('dytp'),
            'infm' => $dts,

            'inra' => $this->input->post('inrt'),
            'nofr' => $nofr,
            'lamt' => $this->input->post('lnamt'),
            'inta' => $this->input->post('tint'),

            'rent' => $this->input->post('instDB'),
            'dcac' => $this->input->post('dofr'),
            'icac' => $this->input->post('infr'),
            'docc' => $this->input->post('damt'),
            'insc' => $this->input->post('iamt'),

            'pnst' => $this->input->post('pnty'),
            'pntp' => $this->input->post('pncl'),
            'pnbs' => $this->input->post('pnbs'),
            'stfm' => $this->input->post('pnl_stdt'),
            'clrt' => $this->input->post('pnlrt'),
            'prln' => $this->input->post('prln'),
            'rmks' => $this->input->post('remk'),
            'pncd' => $this->input->post('pncd'),

            'stat' => 2,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('product', $data_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('product');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Product (' . strtoupper($this->input->post('prcd')) . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function vewProduct()
    {
        $this->db->select("product.*,brch_mas.brnm,brch_mas.brcd,prdt_typ.prna,prdt_typ.prtp");
        $this->db->from("product");
        $this->db->join('brch_mas', 'brch_mas.brid = product.brid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = product.prtp ');
        //$this->db->join('cen_days', 'cen_days.dyid = product.cody ');

        $this->db->where('product.auid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function edtDataPrdt()
    {
        $this->db->select("product.*,brch_mas.brnm,brch_mas.brcd,prdt_typ.prna");
        $this->db->from("product");
        $this->db->join('brch_mas', 'brch_mas.brid = product.brid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = product.prtp ');
        //$this->db->join('cen_days', 'cen_days.dyid = product.cody ');

        $this->db->where('product.auid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function edtProduct()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');

        $prct = $this->input->post('prd_catEdt');
        $dytp = $this->input->post('dytpEdt');

        $policyinfo = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2', 'pov3'), array('popg' => 'product', 'stat' => 1));

        if ($prct == 3) {
            $nofr = $this->input->post('dyn_duraEdt');

            $aa = ($nofr / 30);

            if ($dytp == 5) {
                $dts = $policyinfo[0]->pov1 * $aa;
            } else if ($dytp == 6) {
                $dts = $policyinfo[0]->pov2 * $aa;
            } else if ($dytp == 7) {
                $dts = $policyinfo[0]->pov3 * $aa;
            }

        } else {
            $nofr = $this->input->post('noinsEdt');
            $dts = $this->input->post('noinsEdt');
        }


        if ($func == '1') {                  // update
            $funcPerm = $this->Generic_model->getFuncPermision('product');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Product Update id(' . $auid . ')');

            $data_arr = array(
                'brid' => $this->input->post('prd_brnEdt'),
                'prtp' => $this->input->post('prd_catEdt'),
                'prnm' => ucwords(strtolower($this->input->post('prnmEdt'))),
                'prcd' => strtoupper($this->input->post('prcdEdt')),
                'lcnt' => $this->input->post('lnidEdt'),

                'prmd' => $this->input->post('prd_mdEdt'),
                'cldw' => $this->input->post('dytpEdt'),
                'infm' => $dts,

                'inra' => $this->input->post('inrtEdt'),
                //'nofr' => $this->input->post('noinsEdt'),
                'nofr' => $nofr,
                'lamt' => $this->input->post('lnamtEdt'),
                'inta' => $this->input->post('tintEdt'),

                'rent' => $this->input->post('instDBEdt'),
                'dcac' => $this->input->post('dofrEdt'),
                'icac' => $this->input->post('infrEdt'),
                'docc' => $this->input->post('damtEdt'),
                'insc' => $this->input->post('iamtEdt'),

                'pnst' => $this->input->post('pntyEdt'),
                'pntp' => $this->input->post('pnclEdt'),
                'pnbs' => $this->input->post('pnbsEdt'),
                'stfm' => $this->input->post('pnl_stdtEdt'),
                'clrt' => $this->input->post('pnlrtEdt'),
                'prln' => $this->input->post('prlnEdt'),
                'rmks' => $this->input->post('remkEdt'),
                'pncd' => $this->input->post('pncdEdt'),

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );

        } elseif ($func == '2') {            // approvel

            $funcPerm = $this->Generic_model->getFuncPermision('product');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Product Approval id(' . $auid . ')');

            $data_arr = array(
                'brid' => $this->input->post('prd_brnEdt'),
                'prtp' => $this->input->post('prd_catEdt'),
                'prnm' => ucwords(strtolower($this->input->post('prnmEdt'))),
                'prcd' => strtoupper($this->input->post('prcdEdt')),
                'lcnt' => $this->input->post('lnidEdt'),

                'prmd' => $this->input->post('prd_mdEdt'),
                'cldw' => $this->input->post('dytpEdt'),
                'infm' => $dts,

                'inra' => $this->input->post('inrtEdt'),
                'nofr' => $nofr,
                'lamt' => $this->input->post('lnamtEdt'),
                'inta' => $this->input->post('tintEdt'),

                'rent' => $this->input->post('instDBEdt'),
                'dcac' => $this->input->post('dofrEdt'),
                'icac' => $this->input->post('infrEdt'),
                'docc' => $this->input->post('damtEdt'),
                'insc' => $this->input->post('iamtEdt'),

                'pnst' => $this->input->post('pntyEdt'),
                'pntp' => $this->input->post('pnclEdt'),
                'pnbs' => $this->input->post('pnbsEdt'),
                'stfm' => $this->input->post('pnl_stdtEdt'),
                'clrt' => $this->input->post('pnlrtEdt'),
                'prln' => $this->input->post('prlnEdt'),
                'rmks' => $this->input->post('remkEdt'),

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
        }
        $where_arr = array(
            'auid' => $auid
        );

        $result22 = $this->Generic_model->updateData('product', $data_arr, $where_arr);

        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    function rejPrduct()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('product', array('stat' => 0), array('auid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('product');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Product Cancel prid(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
// end product
//


// RECENT ACTIVITY


// SYSTEM POLICY
    public function policy()
    {
        $data['policyinfo'] = $this->Generic_model->getData('sys_policy', '', array('stat' => 1));
        $this->load->view('modules/common/tmp_header');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $data);

        $data['prdtypeinfo'] = $this->Generic_model->getData('prdt_typ', '', "stat = 1 AND prbs IN(2,3,4)");
        $data['caltype'] = $this->Generic_model->getData('pnl_cal_type', '', '');           // penalty cal type
        $data['calbase'] = $this->Generic_model->getData('pnl_cal_base', '', '');           // penalty cal base on
        //$data['chrgmode'] = $this->Generic_model->getData('prd_chrg_mode', '', array('stat' => 1));         // product charge mode
        $data['pnlcndit'] = $this->Generic_model->getData('pnl_cond', '', '');              // penalty condition

        $this->load->view('modules/admin/policy_management', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
    }

    function addPollicy()
    {
        $date = date('Y-m-d H:i:s');

        $cnmb_min = $this->input->post('cnmb_min');  // CENTER MEMBER MIN
        $cnmb_max = $this->input->post('cnmb_max');  // CENTER MEMBER MAX
        $gpmb_min = $this->input->post('gpmb_min');  // GROUP MEMBER MIN
        $gpmb_max = $this->input->post('gpmb_max');  // GROUP MEMBER MAX
        $prln = $this->input->post('prln');          // PARALLEL LOAN
        $prpd = $this->input->post('prpd');          // PARALLEL PRODUCT
        $ingi_min = $this->input->post('ingr_min');  // INTERNAL GUARANTOR MIN
        $ingi_max = $this->input->post('ingr_max');  // INTERNAL GUARANTOR MAX
        $exgi_min = $this->input->post('exgr_min');  // EXTERNAL GUARANTOR MIN
        $exgi_max = $this->input->post('exgr_max');  // EXTERNAL GUARANTOR MAX
        $rpvl = $this->input->post('rpvl');          // DEFAULT REPAYMENT TYPE
        $rptg = $this->input->post('rptg');          // REPAYMENT TAG
        $rctp = $this->input->post('rctp');          // RECOVERY TYPE

        $tpag = $this->input->post('tpag');          // TOPUP AGE
        $tpup_tenr = $this->input->post('tpup_tenr');// TOPUP TENNER
        $tpup_pymt = $this->input->post('tpup_pymt');// TOPUP PAYMENT
        $tpup_typ = $this->input->post('tpup_typ');  // TOPUP TYPE (Same category/ Any category)

        $lncl5 = $this->input->post('lncl5');          // DAILY LOAN DAY 5D
        $lncl6 = $this->input->post('lncl6');          // DAILY LOAN DAY 6D
        $lncl7 = $this->input->post('lncl7');          // DAILY LOAN DAY 7D

        $mxpt = $this->input->post('mxpt');            // PETTY CASH MAX AMOUNT
        $pidx = $this->input->post('prdindx');         // PRODUCT INDEX
        $tpix = $this->input->post('tprdindx');        // TOPUP LOAN INDEX
        $smln = $this->input->post('samln');           // SAME LOAN


        $_01 = array('pov1' => $cnmb_min, 'pov2' => $cnmb_max, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_02 = array('pov1' => $gpmb_min, 'pov2' => $gpmb_max, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_03 = array('post' => $prln, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_04 = array('post' => $prpd, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_05 = array('pov1' => $ingi_min, 'pov2' => $ingi_max, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_06 = array('pov1' => $exgi_min, 'pov2' => $exgi_max, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_07 = array('post' => $rpvl, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_08 = array('post' => $rptg, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_09 = array('post' => $rctp, 'mdby' => $_SESSION['userId'], 'mddt' => $date);

        $_10 = array('pov3' => $tpag, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_11 = array('pov3' => $tpup_tenr, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_12 = array('pov3' => $tpup_pymt, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_13 = array('post' => $tpup_typ, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_14 = array('pov1' => $lncl5, 'pov2' => $lncl6, 'pov3' => $lncl7, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_15 = array('pov2' => $mxpt, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_16 = array('post' => $pidx, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_17 = array('post' => $tpix, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_18 = array('post' => $smln, 'mdby' => $_SESSION['userId'], 'mddt' => $date);


        $this->Generic_model->updateData('sys_policy', $_01, array('poid' => 1));
        $this->Generic_model->updateData('sys_policy', $_02, array('poid' => 2));
        $this->Generic_model->updateData('sys_policy', $_03, array('poid' => 3));
        $this->Generic_model->updateData('sys_policy', $_04, array('poid' => 4));
        $this->Generic_model->updateData('sys_policy', $_05, array('poid' => 5));
        $this->Generic_model->updateData('sys_policy', $_06, array('poid' => 6));
        $this->Generic_model->updateData('sys_policy', $_07, array('poid' => 7));
        $this->Generic_model->updateData('sys_policy', $_08, array('poid' => 8));
        $this->Generic_model->updateData('sys_policy', $_09, array('poid' => 9));

        $this->Generic_model->updateData('sys_policy', $_10, array('poid' => 10));
        $this->Generic_model->updateData('sys_policy', $_11, array('poid' => 11));
        $this->Generic_model->updateData('sys_policy', $_12, array('poid' => 12));
        $this->Generic_model->updateData('sys_policy', $_13, array('poid' => 13));
        $this->Generic_model->updateData('sys_policy', $_14, array('poid' => 14));

        $this->Generic_model->updateData('sys_policy', $_15, array('poid' => 15));
        $this->Generic_model->updateData('sys_policy', $_16, array('poid' => 16));
        $this->Generic_model->updateData('sys_policy', $_17, array('poid' => 17));
        $this->Generic_model->updateData('sys_policy', $_18, array('poid' => 18));

        $funcPerm = $this->Generic_model->getFuncPermision('policy');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'System Policy Update');
        echo json_encode(true);
    }

    //RECOVERY DETAILS LOAD
    function loadRcverdata()
    {
        $tp = $this->input->post('tp');

        $this->db->select("prid, prna, fltr, sltr,tltr");
        $this->db->from("prdt_typ");
        $this->db->where('prdt_typ.stat', 1);

        $this->db->where('prdt_typ.rctp', $tp);
        //$this->db->or_where('prdt_typ.rctp', 0);

        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

    //RECOVERY DETAILS UPDATE
    function addRecverData()
    {
        $len = $this->input->post("lensp");
        $rctp = $this->input->post("rcvTp");
        $x = 0;

        for ($a = 0; $a < $len; $a++) {
            $prid = $this->input->post("prid[" . $a . "]");     // product type id
            $fslt = $this->input->post("fslt[" . $a . "]");     // first letter
            $sclt = $this->input->post("sclt[" . $a . "]");     // seconde letter
            $thlt = $this->input->post("thlt[" . $a . "]");     // thired letter

            if ($fslt != 0 || $sclt != 0 || $thlt != 0) {
                $data_arrrup = array(
                    'rctp' => $rctp,
                    'fltr' => $fslt,
                    'sltr' => $sclt,
                    'tltr' => $thlt,
                );
                $rest1 = $this->Generic_model->updateData('prdt_typ', $data_arrrup, array('prid' => $prid));

            } else {
                if ($rctp == 1) {
                    $y = 2;
                } else if ($rctp == 2) {
                    $y = 1;
                }

                $data_arrrup = array(
                    'rctp' => $y,
                    'fltr' => 0,
                    'sltr' => 0,
                    'tltr' => 0,
                );
                $rest1 = $this->Generic_model->updateData('prdt_typ', $data_arrrup, array('prid' => $prid));
            }

            $x = $x + 1;
        }
        if ($x == $len) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // GET DYNAMIC PENALTY DATA
    function getDynmicPnalty()
    {
        $prtp = $this->input->post("prtp");

        $this->db->select("pnst, pntp, pnbs, stfm, clrt, pncd, rmks ");
        $this->db->from("product");
        $this->db->where('product.stat', 1);
        $this->db->where('product.prtp', $prtp);
        $this->db->group_by("product.prtp");
        $query = $this->db->get();
        $data = $query->result();

        echo json_encode($data);
    }

    // ADD PENALTY IN A DYNAMIC PRODUCT
    function dynamicPenalty()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $prtp = $this->input->post('prtp');

        $data_arrrup = array(
            'pnst' => $this->input->post('pnty'),
            'pntp' => $this->input->post('pncl'),
            'pnbs' => $this->input->post('pnbs'),
            'stfm' => $this->input->post('pnl_stdt'),
            'clrt' => $this->input->post('pnlrt'),
            'prln' => $this->input->post('prln'),
            'rmks' => $this->input->post('remk'),
            'pncd' => $this->input->post('pncd'),
        );
        $rest1 = $this->Generic_model->updateData('product', $data_arrrup, array('prtp' => $prtp, 'stat' => 1));

        $funcPerm = $this->Generic_model->getFuncPermision('policy');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Dynamic Product Penalty Update prtp(' . $prtp . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

// END POLICY

// TARGET
    function target()
    {
        //$this->Log_model->userLog('target'); // user log
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('target');

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['targettype'] = $this->Generic_model->getData('target_typ', '', array('stat' => 1));
        $data['compinfo'] = $this->Generic_model->getData('com_det', '', array('stat' => 1));
        $data['targtdurat'] = $this->Generic_model->getData('target_dura', '', array('stat' => 1));

        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $this->load->view('modules/admin/target_management', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');

        // $this->load->view('modules/customer/includes/custom_scripts_customer');
    }

    // CHECK TARGET ALREADY EXISTS
    function chkTarget()
    {
        $trtp = $this->input->post('trtp');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $cmpn = $this->input->post('cmpn');
        $brch = $this->input->post('brch');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');

        $this->db->select(" ");
        $this->db->from("target");
        //$this->db->where('target.trtp', $trtp);

        if ($trtp == '1') {
            $this->db->where('target.cmid', $cmpn);
        } else if ($trtp == '2') {
            $this->db->where('target.brid', $brch);
        } else if ($trtp == '3') {
            $this->db->where('target.usid', $exc);
        } else if ($trtp == '4') {
            $this->db->where('target.cnnt', $cen);
        }
        $this->db->where("( `frdt` BETWEEN '$frdt' AND '$todt' OR `todt` BETWEEN '$frdt' AND '$todt') ");
        //$this->db->where("frdt BETWEEN '$frdt' AND '$todt' ");
        //$this->db->or_where("todt BETWEEN '$frdt' AND '$todt' ");
        $query = $this->db->get();
        $count = sizeof($query->result());

        echo json_encode($count);
    }

    function srchTarget()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('target');
        //$this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Search Target Details');
        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }

        $result = $this->Admin_model->get_targetDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;

            if ($row->trtp == 1) {
                $tppr = $row->cmne;
            } else if ($row->trtp == 2) {
                $tppr = $row->brnm;
            } else if ($row->trtp == 3) {
                $tppr = $row->brnm . ' | ' . $row->fnme;
            } else if ($row->trtp == 4) {
                $tppr = $row->brnm . ' | ' . $row->fnme . ' | ' . $row->cnnm;
            } else {
                $tppr = '';
            }

            if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Approval </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewTarg($row->auid );' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtTrgt($row->auid ,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtTrgt($row->auid ,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecTarget($row->auid);' class='btn btn-default btn-condensed' title='Cancel'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '0') {  // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewTarg($row->auid );' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtTrgt( $row->auid ,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' " . $app . " data-toggle='modal' data-target='#modalEdt' onclick='edtTrgt($row->auid ,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' " . $rej . " onclick='rejecTarget($row->auid);' class='btn btn-default btn-condensed' title='Cancel'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = " <span class='label label-danger'> Cancel</span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewTarg($row->auid );' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtTrgt(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtTrgt(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' disabled onclick='rejecTarget( );' class='btn btn-default btn-condensed' title='Cancel'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->tpnm;
            $sub_arr[] = $tppr;
            $sub_arr[] = $row->dunm;
            $sub_arr[] = $row->frdt;
            $sub_arr[] = $row->todt;
            $sub_arr[] = number_format($row->amut, 2, '.', ',');
            $sub_arr[] = $stat;
            $sub_arr[] = $row->crusr;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = '00';
            $sub_arr[] = '0%';
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->all_target(),
            "recordsFiltered" => $this->Admin_model->filtered_target(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // add target
    function addTarget()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('target');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Target');

        $data_arr = array(
            'trtp' => $this->input->post('trtp'),
            'cmid' => $this->input->post('cmpn'),
            'brid' => $this->input->post('brch'),
            'usid' => $this->input->post('exc'),
            'cnnt' => $this->input->post('cen'),
            'amut' => $this->input->post('tamt'),
            'dura' => $this->input->post('durt'),

            'frdt' => $this->input->post('frdt'),
            'todt' => $this->input->post('todt'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('target', $data_arr);
        //  echo json_encode($result);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function taretDtils()
    {
        $auid = $this->input->post('auid');
        //$this->db->select("target.* ");
        //$this->db->from("target");

        $this->db->select("target.*,target_dura.dunm,target_typ.tpnm,com_det.cmne,brch_mas.brnm,user_mas.fnme,cen_mas.cnnm ,aa.crusr  ");
        $this->db->from("target");
        $this->db->join('target_dura', 'target_dura.auid = target.dura');
        $this->db->join('target_typ', 'target_typ.auid = target.trtp');

        $this->db->join('com_det', 'com_det.cmid = target.cmid', 'left');
        $this->db->join('brch_mas', 'brch_mas.brid = target.brid', 'left');
        $this->db->join('user_mas', 'user_mas.auid = target.usid', 'left');
        $this->db->join('cen_mas', 'cen_mas.caid = target.cnnt', 'left');

        $this->db->join("(SELECT aa.auid,aa.usnm AS crusr
        FROM `user_mas` AS aa  )AS aa ", 'aa.auid = target.crby');

        $this->db->where('target.auid', $auid);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // Update & approval target
    function target_update()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');


        if ($func == '1') {                  // update

            $funcPerm = $this->Generic_model->getFuncPermision('target');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Target Update');

            $trgt = $this->Generic_model->getData('target', '', array('auid' => $auid));
            // update perveise recode
            $result22 = $this->Generic_model->updateData('target', array('stat' => 5), array('auid' => $this->input->post('auid')));


            if ($this->input->post('stat') == 0) {            // pending target update
                // add new update recode
                $data_arr = array(
                    'trtp' => $this->input->post('trtp_edt'),
                    'cmid' => $this->input->post('cmpn_edt'),
                    'brid' => $this->input->post('brch_edt'),
                    'usid' => $this->input->post('exc_edt'),
                    'cnnt' => $this->input->post('cen_edt'),
                    'amut' => $this->input->post('tamt_edt'),
                    'dura' => $this->input->post('durt_edt'),

                    'frdt' => $this->input->post('frdt_edt'),
                    'todt' => $this->input->post('todt_edt'),
                    'stat' => 0,
                    'remk' => 'previous recode id : ' . $auid,
                    'crby' => $trgt[0]->crby,
                    'crdt' => $trgt[0]->crdt,
                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('target', $data_arr);

            } elseif ($this->input->post('stat') == 1) {      // approval target update
                // add new update recode
                $data_arr = array(
                    'trtp' => $this->input->post('trtp_edt'),
                    'cmid' => $this->input->post('cmpn_edt'),
                    'brid' => $this->input->post('brch_edt'),
                    'usid' => $this->input->post('exc_edt'),
                    'cnnt' => $this->input->post('cen_edt'),
                    'amut' => $this->input->post('tamt_edt'),
                    'dura' => $this->input->post('durt_edt'),

                    'frdt' => $this->input->post('frdt_edt'),
                    'todt' => $this->input->post('todt_edt'),
                    'stat' => 1,
                    'remk' => 'previous recode id : ' . $auid,
                    'crby' => $trgt[0]->crby,
                    'crdt' => $trgt[0]->crdt,
                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),

                    'apby' => $trgt[0]->apby,
                    'apdt' => $trgt[0]->apdt,

                );
                $result = $this->Generic_model->insertData('target', $data_arr);
            }

            if (count($result) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else if ($func == '2') {            // approvel

            $funcPerm = $this->Generic_model->getFuncPermision('target');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Target Approval');

            $trgt = $this->Generic_model->getData('target', '', array('auid' => $auid));

            // update previous recode
            $result22 = $this->Generic_model->updateData('target', array('stat' => 5), array('auid' => $this->input->post('auid')));

            // approval target
            // add new update recode
            $data_arr = array(
                'trtp' => $this->input->post('trtp_edt'),
                'cmid' => $this->input->post('cmpn_edt'),
                'brid' => $this->input->post('brch_edt'),
                'usid' => $this->input->post('exc_edt'),
                'cnnt' => $this->input->post('cen_edt'),
                'amut' => $this->input->post('tamt_edt'),
                'dura' => $this->input->post('durt_edt'),

                'frdt' => $this->input->post('frdt_edt'),
                'todt' => $this->input->post('todt_edt'),
                'stat' => 1,
                'remk' => 'previous recode id : ' . $auid,
                'crby' => $trgt[0]->crby,
                'crdt' => $trgt[0]->crdt,
                'mdby' => $trgt[0]->mdby,
                'mddt' => $trgt[0]->mddt,

                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('target', $data_arr);


            if (count($result) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }
    }

    // reject target
    function rejTarget()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('target');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Target Reject');

        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('target', array('stat' => 2, 'trby' => $_SESSION['userId'], 'trdt' => date('Y-m-d H:i:s'),), array('auid' => $id));

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }
// END TARGET


// USER LEVEL
    function userLvl()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('userLvl');

        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $this->load->view('modules/admin/user_level', $data);
        $this->load->view('modules/common/footer');
        //$this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchUsrlevl()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('userLvl');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "hidden";
        }

        $this->db->select("user_level.*,CONCAT(user_mas.usnm) AS exe");
        $this->db->from("user_level");
        $this->db->join('user_mas', 'user_mas.auid = user_level.crby');
        $this->db->where("id != 1");

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt'  $edt disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtLvl($row->id);' class='btn  btn-default btn-condensed' title='Contact System Admin' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecUsrLv($row->id);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '0') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLvl(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvUsrLv($row->id);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->lvnm;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // user level name check
    function chk_lvnm()
    {
        $lvnm = $this->input->post('lvnm');
        $result = $this->Generic_model->getData('user_level', array('id', 'lvnm'), array('lvnm' => $lvnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // update user level name check
    function chk_lvnm_edt()
    {
        $lvnm = $this->input->post('lvnm_edt');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('user_level', array('id', 'lvnm'), array('lvnm' => $lvnm));
        if (count($result) > 0) {
            if ($result[0]->id == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function addUserlvl()
    {
        $data_arr = array(
            'lvnm' => $this->input->post('lvnm'),
            'remk' => $this->input->post('remk'),

            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('user_level', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('userLvl');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New User Level (' . $this->input->post('lvnm') . ')');
    }

    function vewUslvl()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('user_level', '', array('id' => $auid));
        echo json_encode($result);
    }

    // Update User Level
    function edtUselvel()
    {
        $data_ar1 = array(
            'lvnm' => $this->input->post('lvnm_edt'),
            'remk' => $this->input->post('remk_edt'),

            'mdby' => $_SESSION['userId'],
            'modt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'id' => $this->input->post('auid')
        );

        $result22 = $this->Generic_model->updateData('user_level', $data_ar1, $where_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('userLvl');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'User Level Update id(' . $this->input->post('auid'));

        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    function rejUserLvel()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('user_level', array('stat' => 0), array('id' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('userLvl');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'User Level Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // user reactive
    function reactUserLvel()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('user_level', array('stat' => 1), array('id' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('userLvl');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'User Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END USER LEVEL
//
// RELATIONSHIP
    function relation()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('relation');

        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $this->load->view('modules/admin/relationship_manage', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchRelatship()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('relation');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "hidden";
        }

        $this->db->select("cus_rel.*,CONCAT(user_mas.usnm) AS exe");
        $this->db->from("cus_rel");
        $this->db->join('user_mas', 'user_mas.auid = cus_rel.crby');
        //$this->db->where("id != 1");

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '0') {  // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat($row->reid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat($row->reid,this.id);' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecRelats($row->reid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat($row->reid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecRelats($row->reid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtRelat(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvRelats($row->reid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->redt;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // user level name check
    function chk_relnm()
    {
        $redt = $this->input->post('relnm');
        $result = $this->Generic_model->getData('cus_rel', array('reid', 'redt'), array('redt' => $redt));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // update user level name check
    function chk_relnm_edt()
    {
        $renm = $this->input->post('relnm_edt');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('cus_rel', array('reid', 'redt'), array('redt' => $renm));
        if (count($result) > 0) {
            if ($result[0]->reid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function addRelatshp()
    {
        $data_arr = array(
            'redt' => ucwords(strtolower($this->input->post('relnm'))),
            'remk' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('cus_rel', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('relation');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Relationship (' . $this->input->post('relnm') . ')');
    }

    function vewRelatishp()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('cus_rel', '', array('reid' => $auid));
        echo json_encode($result);
    }

    // Update
    function edtRelatshp()
    {
        $func = $this->input->post('func');

        // RELATIONSHIP UPDATE
        if ($func == 1) {
            $data_ar1 = array(
                'redt' => ucwords(strtolower($this->input->post('relnm_edt'))),
                'remk' => $this->input->post('remk_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'reid' => $this->input->post('auid')
            );
            $result22 = $this->Generic_model->updateData('cus_rel', $data_ar1, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('relation');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Relationship Update id(' . $this->input->post('auid') . ')');

            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }

            //    RELATIONSHIP APPROVAL
        } elseif ($func == 2) {

            $data_ar1 = array(
                'stat' => 1,
                'redt' => $this->input->post('relnm_edt'),
                'remk' => $this->input->post('remk_edt'),
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'reid' => $this->input->post('auid')
            );

            $result22 = $this->Generic_model->updateData('cus_rel', $data_ar1, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('relation');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Relationship Approval id(' . $this->input->post('auid') . ')');

            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }
    }

    function rejRelatshp()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('cus_rel', array('stat' => 2, 'reby' => $_SESSION['userId'], 'rjdt' => date('Y-m-d H:i:s')), array('reid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('relation');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Relationship Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //  reactive
    function reactRelatshp()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('cus_rel', array('stat' => 1), array('reid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('relation');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Relationship Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END RELATIONSHIP
//
// CHART OF ACCOUNT
    function chrt_acc()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('chrt_acc');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['mainacc'] = $this->Generic_model->getData('accu_main', '', array('stat' => 1));
        $this->load->view('modules/admin/chartof_account', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchChrtAcc()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('chrt_acc');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "hidden";
        }

        $macc = $this->input->post('macc');

        $this->db->select("accu_chrt.*,accu_main.name,CONCAT(user_mas.usnm) AS exe");
        $this->db->from("accu_chrt");
        $this->db->join('accu_main', 'accu_main.auid = accu_chrt.acid');
        $this->db->join('user_mas', 'user_mas.auid = accu_chrt.crby');

        if ($macc != 'all') {
            $this->db->where('accu_chrt.acid', $macc);
        }
        $this->db->order_by('accu_chrt.idfr', 'ASC'); //ASC  DESC

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == 0) {  // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtChrtacc($row->auid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtChrtacc($row->auid,this.id);' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecChrtAcc($row->auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == 1) {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtChrtacc($row->auid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtChrtacc();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecChrtAcc($row->auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == 2) {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtChrtacc(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtChrtacc();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvChrtacc($row->auid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            } else if ($st == 3) {  // Default
                $stat = " <span class='label label-info'> Default</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-default btn-condensed $reac2' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->name;
            $sub_arr[] = $row->hadr;
            $sub_arr[] = $row->idfr;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // account idfr check
    function chk_accidfr()
    {
        $acidf = $this->input->post('acidf');
        $result = $this->Generic_model->getData('accu_chrt', array('auid', 'idfr'), array('idfr' => $acidf));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    function chk_accname()
    {
        $acnm = $this->input->post('acnm');
        $result = $this->Generic_model->getData('accu_chrt', array('auid', 'hadr'), array('hadr' => $acnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // update  check
    function chk_accidfr_edt()
    {
        $acidf = $this->input->post('acidf');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('accu_chrt', array('auid', 'idfr'), array('idfr' => $acidf));
        if (count($result) > 0) {
            if ($result[0]->auid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function chk_accname_edt()
    {
        $acnm = $this->input->post('acnm');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('accu_chrt', array('auid', 'hadr'), array('hadr' => $acnm));
        if (count($result) > 0) {
            if ($result[0]->auid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function addChrtAccoun()
    {
        $data_arr = array(
            'acid' => $this->input->post('min_acc'),
            'hadr' => $this->input->post('acnm'),
            'idfr' => $this->input->post('acidf'),
            'remk' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('accu_chrt', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('chrt_acc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Chart of account (' . $this->input->post('acnm') . ')');
    }

    function vewChrtacc()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('accu_chrt', '', array('auid' => $auid));
        echo json_encode($result);
    }

    // Update
    function edtChrtaccunt()
    {
        $func = $this->input->post('func');

        // CHART OF ACCOUNT UPDATE
        if ($func == 1) {
            $data_ar1 = array(
                'acid' => $this->input->post('min_accEdt'),
                'hadr' => $this->input->post('acnmEdt'),
                'idfr' => $this->input->post('acidfEdt'),
                'remk' => $this->input->post('remk_edt'),

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'auid' => $this->input->post('auid')
            );
            $result22 = $this->Generic_model->updateData('accu_chrt', $data_ar1, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('chrt_acc');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Chart of account update id(' . $this->input->post('auid') . ')');

            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }

            //    CHART OF ACCOUNT APPROVAL
        } elseif ($func == 2) {

            $data_ar1 = array(
                'acid' => $this->input->post('min_accEdt'),
                'hadr' => $this->input->post('acnmEdt'),
                'idfr' => $this->input->post('acidfEdt'),
                'remk' => $this->input->post('remk_edt'),
                'stat' => 1,

                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'auid' => $this->input->post('auid')
            );
            $result22 = $this->Generic_model->updateData('accu_chrt', $data_ar1, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('chrt_acc');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Chart of account approval id(' . $this->input->post('auid') . ')');


            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }
    }

    function rejChtAcc()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('accu_chrt', array('stat' => 2, 'reby' => $_SESSION['userId'], 'rjdt' => date('Y-m-d H:i:s')), array('auid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('chrt_acc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Chart of account Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //  reactive
    function reactChrtacc()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('accu_chrt', array('stat' => 1), array('auid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('chrt_acc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Chart of account Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END CHART OF ACCOUNT
//
// SYSTEM HOLIDAYS
    function sysholy()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('sysholy');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $this->load->view('modules/admin/schedule_system', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchHolydys()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('sysholy');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "disabled";
        }

        $this->db->select("sys_holdys.*,CONCAT(user_mas.fnme,' ',user_mas.lnme) AS exe");
        $this->db->from("sys_holdys");
        $this->db->join('user_mas', 'user_mas.auid = sys_holdys.crby');
        $this->db->where("hdtp", 1);

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            /* if ($st == '0') {  // Pending
                 $stat = " <span class='label label-warning'> Pending </span> ";
                 $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat($row->hoid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                     "<button type='button' id='app' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat($row->hoid,this.id);' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                     "<button type='button' id='rej' " . $rej . "  onclick='rejecRelats($row->hoid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
             } else*/

            if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtHolydt($row->hoid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecHoly($row->hoid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '0') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtHolydt();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    //"<button type='button' onclick='reactvHolydy($row->hoid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
                    "<button type='button' id='rej'  $rej disabled  onclick='rejecHoly();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->date;
            $sub_arr[] = $row->hors;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // holiday check
    function chk_hldt()
    {
        $hldt = $this->input->post('hldt');
        $result = $this->Generic_model->getData('sys_holdys', array('hoid', 'date'), array('date' => $hldt, 'hdtp' => 1));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // update holiday check
    function chk_hldt_edt()
    {
        $dte = $this->input->post('hldt_edt');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('sys_holdys', array('hoid', 'date'), array('date' => $dte, 'hdtp' => 1));
        if (count($result) > 0) {
            if ($result[0]->hoid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    function addHolydy()
    {
        $data_arr = array(
            'date' => $this->input->post('hldt'),
            'hors' => ucwords(strtolower($this->input->post('remk'))),
            'stat' => 1,
            'hdtp' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('sys_holdys', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('sysholy');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Holiday (' . $this->input->post('hldt') . ')');
    }

    function vewHolydt()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('sys_holdys', '', array('hoid' => $auid));
        echo json_encode($result);
    }

    // Update
    function edtHolydays()
    {
        $func = $this->input->post('func');

        $data_ar1 = array(
            'date' => $this->input->post('hldt_edt'),
            'hors' => ucwords(strtolower($this->input->post('remk_edt'))),
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'hoid' => $this->input->post('auid')
        );
        $result22 = $this->Generic_model->updateData('sys_holdys', $data_ar1, $where_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('sysholy');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'System Holiday Update id(' . $this->input->post('auid') . ')');

        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function rejHoliday()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('sys_holdys', array('stat' => 0), array('hoid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('sysholy');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Holiday Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //  reactive
    function reactHolyday()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('sys_holdys', array('stat' => 1), array('hoid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('sysholy');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Holiday Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END SYSTEM HOLIDAYS
//
// BANK ACCOUNT
    function bank_acc()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('bank_acc');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['bankinfo'] = $this->Generic_model->getData('bnk_names', '', array('stat' => 1));
        $this->load->view('modules/admin/bank_account', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchBnkAcc()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('bank_acc');
        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "hidden";
        }

        $brch = $this->input->post('brch');
        $this->db->select("bnk_accunt.*,bnk_names.bknm,brch_mas.brnm,CONCAT(user_mas.usnm) AS usr");
        $this->db->from("bnk_accunt");
        $this->db->join('bnk_names', 'bnk_names.bkid = bnk_accunt.bkid');
        $this->db->join('brch_mas', 'brch_mas.brid = bnk_accunt.brco');
        $this->db->join('user_mas', 'user_mas.auid = bnk_accunt.crby');
        if ($brch != 'all') {
            $this->db->where('bnk_accunt.brco', $brch);
        }
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '0') {  // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtBnkacc($row->acid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtBnkacc($row->acid,this.id);' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecBnkAcc($row->acid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtBnkacc($row->acid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtBnkacc();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecBnkAcc($row->acid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtBnkacc(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtBnkacc();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvBankacc($row->acid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->bknm;
            $sub_arr[] = $row->acnm;
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->usr;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // bank acno check
    function chk_bnkacno()
    {
        $bnk = $this->input->post('bnk');
        $acno = $this->input->post('acno');
        $result = $this->Generic_model->getData('bnk_accunt', array('acid', 'bkid', 'acno'), array('acno' => $acno, 'bkid' => $bnk));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }


    // update  check
    function chk_bnkacno_edt()
    {
        $bnk = $this->input->post('bnk');
        $acno = $this->input->post('acno');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('bnk_accunt', array('acid', 'bkid', 'acno'), array('acno' => $acno, 'bkid' => $bnk));
        if (count($result) > 0) {
            if ($result[0]->acid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }


    function addBnkAccoun()
    {
        $data_arr = array(
            'brco' => $this->input->post('brn'),
            'bkid' => $this->input->post('bnk'),
            'acnm' => $this->input->post('acnm'),
            'acno' => $this->input->post('acno'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('bnk_accunt', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('bank_acc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New bank account (' . $this->input->post('acno') . ')');
    }

    function vewBnkacc()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('bnk_accunt', '', array('acid' => $auid));
        echo json_encode($result);
    }

    // Update
    function edtBankaccunt()
    {
        $func = $this->input->post('func');

        // CHART OF ACCOUNT UPDATE
        if ($func == 1) {
            $data_ar1 = array(
                'brco' => $this->input->post('brch_edt'),
                'bkid' => $this->input->post('bnk_edt'),
                'acnm' => $this->input->post('acnm_edt'),
                'acno' => $this->input->post('acno_edt'),

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'acid' => $this->input->post('auid')
            );
            $result22 = $this->Generic_model->updateData('bnk_accunt', $data_ar1, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('bank_acc');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Bank account update id(' . $this->input->post('auid') . ')');

            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }

            //    CHART OF ACCOUNT APPROVAL
        } elseif ($func == 2) {

            $data_ar1 = array(
                'brco' => $this->input->post('brch_edt'),
                'bkid' => $this->input->post('bnk_edt'),
                'acnm' => $this->input->post('acnm_edt'),
                'acno' => $this->input->post('acno_edt'),
                'stat' => 1,

                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'acid' => $this->input->post('auid')
            );
            $result22 = $this->Generic_model->updateData('bnk_accunt', $data_ar1, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('bank_acc');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Bank account approval id(' . $this->input->post('auid') . ')');


            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }
    }

    function rejbnkAcc()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('bnk_accunt', array('stat' => 2), array('acid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('bank_acc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Bank account Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //  reactive
    function reactBankacc()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('bnk_accunt', array('stat' => 1), array('acid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('bank_acc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Bank account Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END BANK ACCOUNT
//
// SYSTEM BRANDING
    public function brand()
    {
        $data['compnyinfo'] = $this->Generic_model->getData('com_det', '', array('stat' => 1));

        $this->load->view('modules/common/tmp_header');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $data);

        $this->load->view('modules/admin/company_branding', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
    }


// END SYSTEM BRANDING
//
// BRANCH SCHEDULE
    function brnc_shdu()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('brnc_shdu');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $this->load->view('modules/admin/schedule_branch', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BRANCH HOLIDAY
    function srchSchBrnc()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('brnc_shdu');

        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }

        $brn = $this->input->post('brch');
        $this->db->select("sys_holdys.*,CONCAT(user_mas.usnm) AS exe,brch_mas.brnm");
        $this->db->from("sys_holdys");
        $this->db->join('user_mas', 'user_mas.auid = sys_holdys.crby');
        $this->db->join('brch_mas', 'brch_mas.brid = sys_holdys.brcd');
        $this->db->where("hdtp", 2);
        if ($brn != 'all') {
            $this->db->where("sys_holdys.brcd", $brn);
        }
        $this->db->order_by('sys_holdys.date', 'asc');


        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            /* if ($st == '0') {  // Pending
                 $stat = " <span class='label label-warning'> Pending </span> ";
                 $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat($row->hoid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                     "<button type='button' id='app' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtRelat($row->hoid,this.id);' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                     "<button type='button' id='rej' " . $rej . "  onclick='rejecRelats($row->hoid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
             } else*/

            if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtHolyBrn($row->hoid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecHoly($row->hoid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '0') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtHolyBrn(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvHolydy($row->hoid);' class='btn btn-default btn-condensed' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->date;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->hors;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // holiday check
    function chk_brnSche()
    {
        $hldt = $this->input->post('hldt');
        $brn = $this->input->post('brn');
        $result = $this->Generic_model->getData('sys_holdys', array('hoid', 'date'), array('date' => $hldt, 'brcd' => $brn, 'hdtp' => 2));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // update holiday check
    function chk_brnSche_edt()
    {
        $hldt = $this->input->post('hldt_edt');
        $auid = $this->input->post('auid');
        $brn = $this->input->post('brn');

        $result = $this->Generic_model->getData('sys_holdys', array('hoid', 'date'), array('date' => $hldt, 'brcd' => $brn, 'hdtp' => 2));
        if (count($result) > 0) {
            if ($result[0]->hoid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // ADD BRANCH HOLIDAY
    function addScheBrnc()
    {
        $data_arr = array(
            'hdtp' => 2,
            'brcd' => $this->input->post('brn'),
            'date' => $this->input->post('hldt'),
            'hors' => ucwords(strtolower($this->input->post('remk'))),
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('sys_holdys', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('brnc_shdu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Branch Holiday (' . $this->input->post('hldt') . ')');
    }

    // VIEW BRANCH HOLIDAY
    function vewschdBrnc()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('sys_holdys', '', array('hoid' => $auid));
        echo json_encode($result);
    }

    // UPDATE BRANCH HOLIDAY
    function edtHolydaysBrn()
    {
        $func = $this->input->post('func');

        $data_ar1 = array(
            'brcd' => $this->input->post('brn_edt'),
            //'date' => $this->input->post('hldt_edt'),
            'hors' => ucwords(strtolower($this->input->post('remk_edt'))),
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'hoid' => $this->input->post('auid')
        );
        $result22 = $this->Generic_model->updateData('sys_holdys', $data_ar1, $where_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('brnc_shdu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Branch Holiday Update id(' . $this->input->post('auid') . ')');

        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // INACTIVE
    function rejHolidayBrn()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('sys_holdys', array('stat' => 0, 'rjby' => $_SESSION['userId'], 'rjdt' => date('Y-m-d H:i:s')), array('hoid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('brnc_shdu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Branch Holiday Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //  reactive
    function reactHolydayX()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('sys_holdys', array('stat' => 1), array('hoid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('brnc_shdu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Holiday Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END SYSTEM HOLIDAYS
//
// LOAN HOLIDAYS
    function loan_shdu()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('loan_shdu');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $this->load->view('modules/admin/schedule_loan', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchLonHolydy()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('loan_shdu');

        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }

        $brn = $this->input->post('brn');
        $this->db->select("sys_holdys.*,CONCAT(user_mas.usnm) AS exe,brch_mas.brnm,micr_crt.acno");
        $this->db->from("sys_holdys");
        $this->db->join('user_mas', 'user_mas.auid = sys_holdys.crby');
        $this->db->join('brch_mas', 'brch_mas.brid = sys_holdys.brcd');
        $this->db->join('micr_crt', 'micr_crt.lnid = sys_holdys.lnid', 'left');
        $this->db->where("hdtp", 3);
        if ($brn != 'all') {
            $this->db->where("sys_holdys.brcd", $brn);
        }
        //$this->db->where("micr_crt.acno", $lnno);
        $this->db->order_by('sys_holdys.date', 'asc');

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtHolydt($row->hoid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecHolyLoan($row->hoid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '0') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtHolydt(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rej disabled  onclick='rejecHolyLoan($row->hoid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->date;
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->hors;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // CHECK LOAN NO
    function chk_lnnoSche()
    {
        $lnno = $this->input->post('lnno');
        $this->db->select("sys_holdys.lnid,sys_holdys.stat,micr_crt.acno");
        $this->db->from("sys_holdys");
        $this->db->join('micr_crt', 'micr_crt.lnid = sys_holdys.lnid');
        $this->db->where("micr_crt.acno", $lnno);
        $this->db->where("sys_holdys.stat", 1);
        $query = $this->db->get();
        $result = $query->result();

        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }

    }

    // ADD LOAN HOLIDAYS
    function addLoanHolydy()
    {
        $data_arr = array(
            'brcd' => $this->input->post('brnc'),
            'lnid' => $this->input->post('lnid'),
            'date' => $this->input->post('hldt'),
            'hors' => ucwords(strtolower($this->input->post('remk'))),
            'stat' => 1,
            'hdtp' => 3,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('sys_holdys', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('loan_shdu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Loan Holiday (' . $this->input->post('hldt') . ')');
    }

    // EDIT DATA VIEW
    function vewHolydyLon()
    {
        $auid = $this->input->post('auid');
        $this->db->select("sys_holdys.*, cus_mas.init ,cus_mas.grno,cus_mas.cuno,cus_mas.anic,cus_mas.hoad,cus_mas.mobi,cus_mas.uimg ,
        cen_mas.cnno,cen_mas.cnnm, brch_mas.brnm,cus_sol.sode,cus_type.cutp,grup_mas.grno ,
         micr_crt.indt, micr_crt.mddt, micr_crt.loam, micr_crt.inam, micr_crt.boi, micr_crt.boc, micr_crt.aboc, micr_crt.aboi,micr_crt.avcr, 
         micr_crt.avpe, micr_crt.nxpn, micr_crt.noin,micr_crt.acno, product.prcd ,product.prnm ,prdt_typ.pymd  ");

        $this->db->from("sys_holdys");
        $this->db->join('micr_crt', 'micr_crt.lnid = sys_holdys.lnid');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco');
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno', 'left');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');

        $this->db->where('sys_holdys.hoid', $auid);
        $query = $this->db->get();
        echo json_encode($query->result());

    }

    // Update
    function edtHolydaysXX()
    {
        $func = $this->input->post('func');

        $data_ar1 = array(
            'date' => $this->input->post('hldt_edt'),
            'hors' => ucwords(strtolower($this->input->post('remk_edt'))),
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'hoid' => $this->input->post('auid')
        );
        $result22 = $this->Generic_model->updateData('sys_holdys', $data_ar1, $where_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('loan_shdu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'loan Holiday Update id(' . $this->input->post('auid') . ')');

        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REJECT LOAN HOLIDAY
    function rejLoanHolidy()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('sys_holdys', array('stat' => 0, 'rjby' => $_SESSION['userId'], 'rjdt' => date('Y-m-d H:i:s')), array('hoid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('loan_shdu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan Holiday Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //  reactive
    function reactHolydayXX()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('sys_holdys', array('stat' => 1), array('hoid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('loan_shdu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Holiday Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END SYSTEM HOLIDAYS
//
// BDAY GIFT STOCK MANAGEMENT
    public function gift_stck()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('gift_stck');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['giftinfo'] = $this->Generic_model->getData('bday_gift_type', '', array('stat' => 1));

        $this->load->view('modules/admin/gift_stock_management', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
    }

    function srchGifStock()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('gift_stck');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }

        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }

        $brn = $this->input->post('brn');
        $this->db->select("bday_gift_stock.*,brch_mas.brnm,CONCAT(user_mas.usnm) AS exc ,bday_gift_type.gfnm,
        IFNULL((SELECT SUM(gfcn) FROM `bday_gift` AS aa 
            WHERE  stat IN(0,1) AND  `aa`.`stid` = `bday_gift_stock`.`auid`),'-') AS gfcnt  ");
        $this->db->from("bday_gift_stock");
        $this->db->join('brch_mas', 'brch_mas.brid = bday_gift_stock.brco');
        $this->db->join('user_mas', 'user_mas.auid = bday_gift_stock.crby');
        $this->db->join('bday_gift_type', 'bday_gift_type.gfid = bday_gift_stock.gftp');
        if ($brn != 'all') {
            $this->db->where('bday_gift_stock.brco', $brn);
        }
        $query = $this->db->get();
        $result = $query->result();
        $data = array();
        $i = 0;

        foreach ($result as $row) {
            $st = $row->stat;
            $auid = $row->auid;

            if ($row->gfcnt > 0) {
                $edt = "disabled";
                $rej2 = "disabled";
            } else {
                $edt = "";
                $rej2 = "";
            }

            if ($st == 0) {  // pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' $edt data-toggle='modal' id='edt' data-target='#modalEdt' onclick='edtStck($auid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button'  data-toggle='modal' id='app' data-target='#modalEdt' onclick='edtStck($auid,this.id);' class='btn btn-default btn-condensed' title='Edit'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rej2 $rej onclick='rejecStck($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } elseif ($st == 1) {  // ACTIVE
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtStck($auid);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtStck($auid);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rej2 $rej onclick='rejecStck($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == 2) {  // INACTIVE
                $stat = " <span class='label label-danger'> Inactive </span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' disabled onclick='rejecStck($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->gfnm;
            $sub_arr[] = $row->stcd;
            $sub_arr[] = $row->cunt;
            $sub_arr[] = number_format($row->pric, 2);
            $sub_arr[] = $row->gfcnt;
            $sub_arr[] = $row->exc;
            $sub_arr[] = $row->crdt;

            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }
        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    // NEW GIFT STOCK ADD
    function addGftStock()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $brco = $this->input->post('brchGft');
        $data_arr = array(
            'brco' => $brco,
            'gftp' => $this->input->post('gftp'),
            'cunt' => $this->input->post('nfcn'),
            'pric' => $this->input->post('prce'),
            'ttvl' => $this->input->post('nfcn') * $this->input->post('prce'),
            'stcd' => $this->input->post('stcd'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s')
        );
        $result = $this->Generic_model->insertData('bday_gift_stock', $data_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('gift_stck');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add Gift Stock');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // REJECT GIFT STOCK
    function rejGiftStck()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('bday_gift_stock', array('stat' => 2), array('auid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('gift_stck');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Gift Stock reject(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // EDIT VIEW GIFT STOCK
    function vewGiftStck()
    {
        $this->db->select("");
        $this->db->from("bday_gift_stock");
        $this->db->where('bday_gift_stock.auid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // GIFT STOCK UPDATE
    function edtGiftStck()
    {
        $func = $this->input->post('func'); // if 1 - update/ 2 - approval

        if ($func == 1) { // UPDATE
            $this->db->trans_begin(); // SQL TRANSACTION START

            $data_arr = array(
                'brco' => $this->input->post('brchGftEdt'),
                'gftp' => $this->input->post('gftpEdt'),
                'cunt' => $this->input->post('nfcnEdt'),
                'pric' => $this->input->post('prceEdt'),
                'ttvl' => $this->input->post('nfcnEdt') * $this->input->post('prceEdt'),
                'stcd' => $this->input->post('stcdEdt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'auid' => $this->input->post('auid')
            );
            $result22 = $this->Generic_model->updateData('bday_gift_stock', $data_arr, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('gift_stck');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Update Gift Stock ');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }

        } else if ($func == 2) { // APPROVAL

            $this->db->trans_begin(); // SQL TRANSACTION START

            $ttvl = ($this->input->post('nfcnEdt') * $this->input->post('prceEdt'));
            $brco = $this->input->post('brchGftEdt');
            $data_arr = array(
                'brco' => $brco,
                'gftp' => $this->input->post('gftpEdt'),
                'cunt' => $this->input->post('nfcnEdt'),
                'pric' => $this->input->post('prceEdt'),
                'ttvl' => $ttvl,
                'stcd' => $this->input->post('stcdEdt'),
                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'auid' => $this->input->post('auid')
            );
            $result22 = $this->Generic_model->updateData('bday_gift_stock', $data_arr, $where_arr);

            // ACCOUNT LEDGE
            $data_aclg1 = array(
                'brno' => $brco, // BRANCH ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'OTHERS',
                'trid' => 6,
                //'rfna' => $voudt[0]->vuno,
                'dcrp' => 'Birthday gift  ',
                'acco' => 106,    // cross acc code
                'spcd' => 113,    // split acc code
                'acst' => '(113) Birthday Gift Stock',
                'dbam' => $ttvl,
                'cram' => 0,
                'stat' => 0
            );
            $re2 = $this->Generic_model->insertData('acc_leg', $data_aclg1);

            $data_aclg2 = array(
                'brno' => $brco, // BRANCH ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'OTHERS',
                'trid' => 6,
                //'rfna' => $voudt[0]->vuno,
                'dcrp' => 'Birthday gift ',
                'acco' => 113,    // cross acc code
                'spcd' => 106,    // split acc code
                'acst' => '(106) Cash Book',
                'dbam' => 0,
                'cram' => $ttvl,
                'stat' => 0
            );
            $re3 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
            // END ACCOUNT LEDGE

            $funcPerm = $this->Generic_model->getFuncPermision('gift_stck');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Approval Gift Stock ');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }

        }
    }
// END  GIFT STOCK MANAGEMENT
//
// ******************* Investor  ******
// ******************* Investor  ******

//INSVESTER MANAGEMENT
    public function invstor()
    {
        //User Access Page Log  $this->Log_model->userLog('cent_mng');
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('invstor');
        // $data['policy'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2'), array('popg' => 'cent_mng', 'stat' => 1));
        $this->load->view('modules/common/tmp_header');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $data);
        //titles details load
        $data['titlinfo1'] = $this->Generic_model->getData('cus_sol', '', '', '');
        //bnank details
        $this->db->select("bnk_names.bkid,bnk_names.bknm");
        $this->db->from("bnk_names");
        $this->db->order_by("bknm");
        $this->db->where('bkid != ', '1');
        $query = $this->db->get();
        $data['bankinfo'] = $query->result();
        $this->load->view('modules/admin/investor_management.php', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }
    //
    // investor nic duplicate start
    // add investor
    public function chk_nic_Inv()
    {
        $nic = $this->input->post('nic');
        $result = $this->Generic_model->getData('inve_mas', array('auid', 'inic'), array('inic' => $nic));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
    //
    // edit investor
    public function chk_nic_Inv_edit()
    {
        $nic = $this->input->post('nicc');
        $auid = $this->input->post('auidd');
        $result = $this->Generic_model->getData('inve_mas', array('auid', 'inic'), array('inic' => $nic));
        if (count($result) > 0) {       // 1 > 0
            if ($result[0]->auid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }
    // investor nic duplicate end
    //
    //investor serach table start
    function searchInvestor()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('invstor');
        $result = $this->Admin_model->get_investorDtils();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            if ($row->ivtp == 0) {
                $tr = "<span class='label label-default' title='introducer'>introducer</span>";
            } else if ($row->ivtp == 1) {
                $tr = "<span class='label label-info' title='investor'>investor</span>";
            }
            if ($row->stat == 0) {

                $tra = "<span class='label label-primary' title='pending'>pending</span>";
                $option = "<button type='button' id='view'  data-toggle='modal' data-target='#modalView' onclick='viewins($row->auid)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'   data-toggle='modal' data-target='#modalEdt' onclick='edtInves(" . $row->auid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  data-toggle='modal' data-target='#modalEdt' onclick='edtInves(" . $row->auid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'   onclick='rejecInves($row->auid);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
            } else if ($row->stat == 1) {
                $tra = "<span class='label label-success' title='active'>active</span>";
                $option = "<button type='button' id='view'  data-toggle='modal' data-target='#modalView' onclick='viewins($row->auid)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'   data-toggle='modal' data-target='#modalEdt' onclick='edtInves(" . $row->auid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtInves(" . $row->auid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'   onclick='rejecInves($row->auid);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
            } else {
                $tra = "<span class='label label-danger' title='inactive'>inactive</span>";
                $option = "<button type='button' id='view'  data-toggle='modal' data-target='#modalView' onclick='viewins($row->auid)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtInves(" . $row->auid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtInvesedtNmcust(1,id);(" . $row->auid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' disabled  onclick='rejecInves($row->auid);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
            }
            $st = $row->stat;
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->hoad;
            $sub_arr[] = $row->inic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->mail;
            $sub_arr[] = $tr;
            $sub_arr[] = $tra;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_investor(),
            "recordsFiltered" => $this->Admin_model->count_filtered_investor(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //investor serach table end

    //
    // investor view start
    function vewIns()
    {


        $funcPerm = $this->Generic_model->getFuncPermision('invstor');
        $this->db->select("*");
        $this->db->from("inve_mas");
        $this->db->where('auid', $this->input->post('auid'));
        $query = $this->db->get();
        $data['inst'] = $query->result();
        $this->db->select("inve_bank.*,bnk_names.*");
        $this->db->from("inve_bank");
        $this->db->join('bnk_names', 'bnk_names.bkid = inve_bank.bkid');
        $this->db->where('inve_bank.inid', $this->input->post('auid'));
        $this->db->where_in('inve_bank.stat', array('0', '1'));
        //$this->db->or_where('inve_bank.stat', '1');

        $query = $this->db->get();
        $data['bank'] = $query->result();

        echo json_encode($data);

    }


    // investor view end
    // investor add start
    function addinv()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $data_arr = array(
            'titl' => $this->input->post('titl'),
            'funm' => strtoupper($this->input->post('funm')),
            'innm' => strtoupper($this->input->post('innm')),
            'hoad' => $this->input->post('hoad'),
            'inic' => strtoupper($this->input->post('nic')),
            'idob' => $this->input->post('idob'),
            'tele' => $this->input->post('tele'),
            'mobi' => $this->input->post('mobi'),
            'mail' => $this->input->post('mail'),
            'city' => $this->input->post('city'),
            'ivtp' => $this->input->post('ivtp'),
            'remk' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('inve_mas', $data_arr);

        $nic = $this->input->post('nic');
        $result11 = $this->Generic_model->getData('inve_mas', array('auid', 'inic'), array('inic' => $nic));
        $lstid = $result11[0]->auid;
        $bkid = $this->input->post('bkid[]');
        $acno = $this->input->post('acno[]');
        $bunm = $this->input->post('bunm[]');
        $siz = sizeof($acno);
        for ($a = 0; $a < $siz; $a++) {
            if ($acno[$a] != '' || $acno[$a] != 0) {
                $data_arr1 = array(
                    'bkid' => $bkid[$a],
                    'acno' => $acno[$a],
                    'bunm' => $bunm[$a],
                    'inid' => $lstid,
                    'stat' => 0,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result1 = $this->Generic_model->insertData('inve_bank', $data_arr1);
            }
        }
        $funcPerm = $this->Generic_model->getFuncPermision('invstor');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Investor');


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }
    // investor add end
    //

    //
    //edit/approval investor start
    function edit_investor()
    {
        $func = $this->input->post('func');
        //edit
        if ($func == '1') {
            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr = array(
                'titl' => $this->input->post('edit_titl'),
                'funm' => strtoupper($this->input->post('edit_funm')),
                'innm' => strtoupper($this->input->post('edit_innm')),
                'hoad' => $this->input->post('edit_hoad'),
                'inic' => strtoupper($this->input->post('edit_nic')),
                'idob' => $this->input->post('edit_idob'),
                'tele' => $this->input->post('edit_tele'),
                'mobi' => $this->input->post('edit_mobi'),
                'mail' => $this->input->post('edit_mail'),
                'city' => $this->input->post('edit_city'),
                'ivtp' => $this->input->post('edit_ivtp'),
                'remk' => $this->input->post('edit_remk'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'auid' => $this->input->post('edit_auid')
            );
            $result22 = $this->Generic_model->updateData('inve_mas', $data_arr, $where_arr);


            $nic1 = $this->input->post('edit_auid');

            $bkid1 = $this->input->post('edit_bkid1[]');
            $acno1 = $this->input->post('edit_acno1[]');
            $bunm1 = $this->input->post('edit_bunm1[]');
            $siz = sizeof($acno1);
            for ($a = 0; $a < $siz; $a++) {
                if ($acno1[$a] != '' || $acno1[$a] != 0) {
                    $data_arr1 = array(
                        'bkid' => $bkid1[$a],
                        'acno' => $acno1[$a],
                        'bunm' => $bunm1[$a],
                        'inid' => $nic1,
                        'stat' => 0,
                        'mdby' => $_SESSION['userId'],
                        'mddt' => date('Y-m-d H:i:s'),
                    );
                    $result111 = $this->Generic_model->insertData('inve_bank', $data_arr1);
                }
            }


            $nic = $this->input->post('edit_nic');
            $result11 = $this->Generic_model->getData('inve_mas', array('auid', 'inic'), array('inic' => $nic));
            $lstid = $result11[0]->auid;
            $bkid = $this->input->post('edit_bkid[]');
            $acno = $this->input->post('edit_acno[]');
            $bunm = $this->input->post('edit_bunm[]');
            $bnid = $this->input->post('bnid[]');
            $siz = sizeof($bnid);


            for ($a = 0; $a < $siz; $a++) {
                if ($bkid[$a] != '' || $bkid[$a] != 0) {
                    $data_arr2 = array(
                        'bkid' => $bkid[$a],
                        'acno' => $acno[$a],
                        'bunm' => $bunm[$a],
                        'inid' => $lstid,

                        'mdby' => $_SESSION['userId'],
                        'mddt' => date('Y-m-d H:i:s'),
                    );
                    $where_arr1 = array(
                        'bnid' => $bnid[$a],
                    );
                    $result1 = $this->Generic_model->updateData('inve_bank', $data_arr2, $where_arr1);

                } else {
                    $data_arr3 = array(
                        'stat' => 2,
                        'rjby' => $_SESSION['userId'],
                        'rjdt' => date('Y-m-d H:i:s'),
                    );
                    $where_arr3 = array(
                        'bnid' => $bnid[$a],
                    );
                    $result1 = $this->Generic_model->updateData('inve_bank', $data_arr3, $where_arr3);
                }
                error_reporting(E_ALL ^ E_NOTICE);

            }


            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
        } //approval
        else if ($func == '2') {
            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr1 = array(
                'titl' => $this->input->post('edit_titl'),
                'funm' => strtoupper($this->input->post('edit_funm')),
                'innm' => strtoupper($this->input->post('edit_innm')),
                'hoad' => $this->input->post('edit_hoad'),
                'inic' => strtoupper($this->input->post('edit_nic')),
                'idob' => $this->input->post('edit_idob'),
                'tele' => $this->input->post('edit_tele'),
                'mobi' => $this->input->post('edit_mobi'),
                'mail' => $this->input->post('edit_mail'),
                'city' => $this->input->post('edit_city'),
                'ivtp' => $this->input->post('edit_ivtp'),
                'remk' => $this->input->post('edit_remk'),
                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr1 = array(
                'auid' => $this->input->post('edit_auid')
            );
            $result22 = $this->Generic_model->updateData('inve_mas', $data_arr1, $where_arr1);

            $nic = $this->input->post('edit_nic');
            $result11 = $this->Generic_model->getData('inve_mas', array('auid', 'inic'), array('inic' => $nic));
            $lstid = $result11[0]->auid;
            $bkid = $this->input->post('edit_bkid[]');
            $acno = $this->input->post('edit_acno[]');
            $bunm = $this->input->post('edit_bunm[]');
            $bnid = $this->input->post('bnid[]');

            $siz = sizeof($acno);
            for ($a = 0; $a < $siz; $a++) {
                if ($acno[$a] != '' || $acno[$a] != 0) {
                    $data_arr2 = array(
                        'bkid' => $bkid[$a],
                        'acno' => $acno[$a],
                        'bunm' => $bunm[$a],
                        'inid' => $lstid,
                        'stat' => 1,
                        'apby' => $_SESSION['userId'],
                        'apdt' => date('Y-m-d H:i:s'),
                    );
                    $where_arr1 = array(
                        'bnid' => $bnid[$a],
                    );
                    $result44 = $this->Generic_model->updateData('inve_bank', $data_arr2, $where_arr1);
                }
            }


            $nic = $this->input->post('edit_nic');
            $result11 = $this->Generic_model->getData('inve_mas', array('auid', 'inic'), array('inic' => $nic));
            $lstid = $result11[0]->auid;
            $bkid = $this->input->post('edit_bkid[]');
            $acno = $this->input->post('edit_acno[]');
            $bunm = $this->input->post('edit_bunm[]');
            $bnid = $this->input->post('bnid[]');
            $siz = sizeof($bnid);


            for ($a = 0; $a < $siz; $a++) {
                if ($bkid[$a] != '' || $bkid[$a] != 0) {
                    $data_arr2 = array(
                        'bkid' => $bkid[$a],
                        'acno' => $acno[$a],
                        'bunm' => $bunm[$a],
                        'inid' => $lstid,

                        'mdby' => $_SESSION['userId'],
                        'mddt' => date('Y-m-d H:i:s'),
                    );
                    $where_arr1 = array(
                        'bnid' => $bnid[$a],
                    );
                    $result1 = $this->Generic_model->updateData('inve_bank', $data_arr2, $where_arr1);

                } else {
                    $data_arr3 = array(
                        'stat' => 2,
                        'rjby' => $_SESSION['userId'],
                        'rjdt' => date('Y-m-d H:i:s'),
                    );
                    $where_arr3 = array(
                        'bnid' => $bnid[$a],
                    );
                    $result1 = $this->Generic_model->updateData('inve_bank', $data_arr3, $where_arr3);
                }
                error_reporting(E_ALL ^ E_NOTICE);

            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
        }

    }
    //edit/approval investor end
    //
    //reject investor start
    function rejInvestor()
    {
        $auid = $this->input->post('auid');

        $result = $this->Generic_model->updateData('inve_mas', array('stat' => 2, 'rjby' => $_SESSION['userId'],
            'rjdt' => date('Y-m-d H:i:s'),), array('auid' => $auid));
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
    //reject investor end
    //

//INSVEMENT MANAGEMENT
    public function invest()
    {
        //User Access Page Log  $this->Log_model->userLog('cent_mng');
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('invest');
        // $data['policy'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2'), array('popg' => 'cent_mng', 'stat' => 1));
        $this->load->view('modules/common/tmp_header');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $data);
        //titles details load
        // $data['titlinfo1'] = $this->Generic_model->getData('cus_sol', '', '', '');
        $this->load->view('modules/admin/insvement_management.php', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    //
    // add invest nic start
    function getInvest_Inv()
    {
        $inic = $this->input->post('inic');
        $this->db->select("inve_mas.*,inve_bank.*");
        $this->db->from("inve_mas");
        $this->db->join('inve_bank', 'inve_bank.inid = inve_mas.auid');
        $this->db->where('inic', $inic);
        // $this->db->where('ivtp', 1);

        $this->db->where('inve_mas.stat', 1);
        // $this->db->where('inve_bank.stat', 1);
        $query = $this->db->get();
        $data = $query->result();

        //var_dump($query->result());

        //$inicc = $this->input->post('auid');
        /*  $this->db->select("inve_bank.acno");
          $this->db->where('inid', $inic);
          $query = $this->db->get();
          $data['a2'] = $query->result();
  */

        echo json_encode($data);
    }

    //add invest nic end
    // edit invest nic start
    function getInvest_InvEdit()
    {
        $inic = $this->input->post('inic_edit');
        $this->db->select("inve_mas.*,inve_bank.*");
        $this->db->from("inve_mas");
        $this->db->join('inve_bank', 'inve_bank.inid = inve_mas.auid');
        $this->db->where('inic', $inic);
        // $this->db->where('ivtp', 1);

        $this->db->where('inve_mas.stat', 1);
        //$this->db->where('inve_bank.stat', 1);
        $query = $this->db->get();
        $data = $query->result();

        //var_dump($query->result());

        //$inicc = $this->input->post('auid');
        /*  $this->db->select("inve_bank.acno");
          $this->db->where('inid', $inic);
          $query = $this->db->get();
          $data['a2'] = $query->result();
  */

        echo json_encode($data);
    }

    public function nic_Accno()
    {
        $acno = $this->input->post('acno');
        $result = $this->Generic_model->getData('inve_bank', array('bnid', 'acno'), array('acno' => $acno));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function nic_Accno_edit()
    {
        $nic = $this->input->post('edit_Acno');
        $auid = $this->input->post('edit_Bnid');
        $result = $this->Generic_model->getData('inve_bank', array('bnid', 'acno'), array('acno' => $nic));
        if (count($result) > 0) {       // 1 > 0
            if ($result[0]->bnid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }
    // investor nic duplicate end


    // add invest nic start
    function getIntroduce()
    {
        $inic = $this->input->post('idnm');
        $this->db->select("inve_mas.*,inve_bank.*");
        $this->db->from("inve_mas");
        $this->db->join('inve_bank', 'inve_bank.inid = inve_mas.auid');

        $this->db->where('inic', $inic);
        // $this->db->where('ivtp', 0);
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }
    //add invest nic end
    // add invest nic start
    function getIntroduceedit()
    {
        $inic = $this->input->post('idnm_edit');

        $this->db->select("inve_mas.*,inve_bank.*");
        $this->db->from("inve_mas");
        $this->db->join('inve_bank', 'inve_bank.inid = inve_mas.auid');
        $this->db->where('inic', $inic);

        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }
    //add invest nic end

    //bank acc start
    function getBankAcc()
    {
        //var_dump($this->input->post('auid'));
        $inid = $this->input->post('auid');

        $this->db->select("inve_bank.*");
        $this->db->from("inve_bank");
        //$this->db->join('bnk_names', 'bnk_names.bkid = inve_bank.bkid', 'left');

        $this->db->where('inid', $inid);

        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

    //bank accnic end

    function getBankAccEdit()
    {
        $edit_auid = $this->input->post('auid_edit');
        // $bnid_edit = $this->input->post('bnid_edit');

        $this->db->select("*");
        $this->db->from("inve_bank");
        $this->db->where('inid', $edit_auid);
        //$this->db->where('bnid', $bnid_edit);

        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }
    //bank accnic end

    //intruducer acc start
    function getIndBankAcc()
    {
        //var_dump($this->input->post('auid'));
        $inid = $this->input->post('indauid');
        // $bnid = $this->input->post('indbnid');
        $this->db->select("*");
        $this->db->from("inve_bank");
        $this->db->where('inid', $inid);
        // $this->db->where('bnid', $bnid);
        //$this->db->where('stat', 1);
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

    //intruducer accnic end

    function getIndBankAccedit()
    {
        //var_dump($this->input->post('auid'));
        $indauidedit = $this->input->post('indauidedit');
        $indbnidedit = $this->input->post('indbnidedit');
        $this->db->select("*");
        $this->db->from("inve_bank");
        $this->db->where('inid', $indauidedit);
        $this->db->where('bnid', $indbnidedit);
        // $this->db->where('stat', 1);
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }
    //intruducer accnic end

    //bank acc start
    function getaccount()
    {
        //var_dump($this->input->post('auid'));
        $inid = $this->input->post('auid');

        $this->db->select("inve_bank.bnid,inve_bank.acno");
        $this->db->from("inve_bank");
        $this->db->where('inid', $inid);


        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }
    //bank accnic end


    // invest add start
    function addinvest()
    {
        // var_dump($this->input->post('acno'));
        $yert = $this->input->post('tort') * 12;
        $mnrt = $this->input->post('tort') / 30;

        // $perd = $this->input->post('perd') * 30;
        // $pamd = $this->input->post('pamd');
        //$inpc = $perd / $pamd;

        $this->db->trans_begin(); // SQL TRANSACTION START
        $data_arr = array(
            'ivid' => $this->input->post('auid'),
            'amnt' => $this->input->post('amnt'),
            'tort' => $this->input->post('tort'),
            'stdt' => $this->input->post('stdt'),
            'perd' => $this->input->post('perd'),
            'mtdt' => $this->input->post('mtdt'),
            'inrt' => $this->input->post('inrt'),
            'remk' => $this->input->post('remk'),
            'inpy' => $this->input->post('inpy'),
            'acno' => $this->input->post('acno'),
            'pamd' => $this->input->post('pamd'),
            'idpy' => $this->input->post('idpy'),
            'idnm' => $this->input->post('indauid'),
            'idcm' => $this->input->post('idcm'),
            'idac' => $this->input->post('idac'),
            'yert' => $yert,
            'mnrt' => $mnrt,
            // 'inpc' => $inpc,

            'inst' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('investment', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    // invest add end
    //invest start
    function searchInvestment()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('invest');
        $result = $this->Admin_model->get_InsvestDtils();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {

            if ($row->inst == 0) {
                $tra = "<span class='label label-primary' title='pending'>pending</span>";
                $option = "<button type='button' id='view'  data-toggle='modal' data-target='#modalView' onclick='vewInvest($row->invd)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'   data-toggle='modal' data-target='#modalEdt' onclick='editinsvest(" . $row->invd . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  data-toggle='modal' data-target='#modalEdt' onclick='editinsvest(" . $row->invd . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'   onclick='rejecInvesBank($row->invd);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                "<button type='button' id='rej'   onclick='rejInvest($row->invd);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
            } else if ($row->inst == 1) {
                $tra = "<span class='label label-success' title='active'>active</span>";
                $option = "<button type='button' id='view'  data-toggle='modal' data-target='#modalView' onclick='vewInvest($row->invd)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled   data-toggle='modal' data-target='#modalEdt'  onclick='editinsvest(" . $row->invd . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='editinsvest(" . $row->invd . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'   onclick='rejInvest($row->invd);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
            } else {
                $tra = "<span class='label label-danger' title='inactive'>inactive</span>";
                $option = "<button type='button' id='view'  data-toggle='modal' data-target='#modalView' onclick='vewInvest($row->invd)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled  data-toggle='modal' data-target='#modalEdt' onclick='editinsvest(" . $row->invd . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='editinsvest(1,id);(" . $row->invd . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' disabled  onclick='rejInvest($row->invd);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
            }
            $st = $row->inst;
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->inic;
            $sub_arr[] = $row->mobi;
            //$sub_arr[] = $row->bknm;
            $sub_arr[] = $row->acno;
            $sub_arr[] = number_format($row->amnt, 2);
            $sub_arr[] = $row->tort . "%";
            $sub_arr[] = $row->stdt;
            $sub_arr[] = $row->mtdt;
            $sub_arr[] = $tra;
            $sub_arr[] = $option;


            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_insvest(),
            "recordsFiltered" => $this->Admin_model->count_filtered_insvest(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //invest search table end
    // invest view start
    function vewinvest()
    {

        $funcPerm = $this->Generic_model->getFuncPermision('invest');
        // $this->db->select("investment.*,inve_mas.*,inve_bank.*,invest_dura.* ");
        $this->db->select("investment.*,inve_mas.*,inve_bank.*,b.full,invest_dura.*");
        $this->db->from("investment");

        $this->db->join("(SELECT vv.auid,vv.innm AS full FROM inve_mas AS vv) AS b", 'b.auid = investment.idnm', 'left');


        $this->db->join('inve_mas', 'inve_mas.auid = investment.ivid', 'left');
        $this->db->join('inve_bank', 'inve_bank.bnid = investment.acno', 'left');
        $this->db->join('invest_dura', 'invest_dura.auid = investment.pamd', 'left');
        $this->db->where('invd', $this->input->post('invd'));
        //$this->db->where('auid', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }
    // invest view end

    //edit/approval investor bank start
    function edit_Invest()
    {
        $yert = $this->input->post('tort_edit') * 12;
        $func_edit = $this->input->post('edit_func');
        //echo
        //var_dump($this->input->post('edit_inid'));


        //edit
        if ($func_edit == '1') {
            $this->db->trans_begin();
            // SQL TRANSACTION START
            $data_arr = array(
                // 'inic' => $this->input->post('edit_invd'),

                'ivid' => $this->input->post('auid_edit'),
                'amnt' => $this->input->post('amnt_edit'),
                'tort' => $this->input->post('tort_edit'),
                'stdt' => $this->input->post('stdt_edit'),
                'perd' => $this->input->post('perd_edit'),
                'mtdt' => $this->input->post('mtdt_edit'),
                'inrt' => $this->input->post('inrt_edit'),
                'inpy' => $this->input->post('inpy_edit'),
                'pamd' => $this->input->post('pamd_edit'),
                'acno' => $this->input->post('acno_edit'),
                'idpy' => $this->input->post('idpy_edit'),
                'idnm' => $this->input->post('indauidedit'),
                'idac' => $this->input->post('idac_edit'),
                'idcm' => $this->input->post('idcm_edit'),
                'remk' => $this->input->post('remk_edit'),
                'yert' => $yert,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),

            );
            $where_arr = array(
                'invd' => $this->input->post('edit_invd')
            );
            $result22 = $this->Generic_model->updateData('investment', $data_arr, $where_arr);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
        } //approval
        else if ($func_edit == '2') {
            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr1 = array(
                // 'inic' => $this->input->post('edit_invd'),
                'ivid' => $this->input->post('auid_edit'),
                'amnt' => $this->input->post('amnt_edit'),
                'tort' => $this->input->post('tort_edit'),
                'stdt' => $this->input->post('stdt_edit'),
                'perd' => $this->input->post('perd_edit'),
                'mtdt' => $this->input->post('mtdt_edit'),
                'inrt' => $this->input->post('inrt_edit'),
                'inpy' => $this->input->post('inpy_edit'),
                'pamd' => $this->input->post('pamd_edit'),
                'acno' => $this->input->post('acno_edit'),
                'idpy' => $this->input->post('idpy_edit'),
                'idnm' => $this->input->post('indauidedit'),
                'idac' => $this->input->post('idac_edit'),
                'idcm' => $this->input->post('idcm_edit'),
                'remk' => $this->input->post('remk_edit'),
                'inst' => 1,
                'yert' => $yert,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr1 = array(
                'invd' => $this->input->post('edit_invd')
            );
            $result22 = $this->Generic_model->updateData('investment', $data_arr1, $where_arr1);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
        }

    }
    //edit/approval end
    //reject investor start
    function rejInvest()
    {
        $invd = $this->input->post('invd');
        $result = $this->Generic_model->updateData('investment', array('inst' => 2, 'rjby' => $_SESSION['userId'],
            'rjdt' => date('Y-m-d H:i:s')), array('invd' => $invd));
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
    //reject investor end

////////////invest payment start ///////////////

    public function invst_pymt()
    {
        //User Access Page Log  $this->Log_model->userLog('cent_mng');
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('invst_pymt');
        // $data['policy'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2'), array('popg' => 'cent_mng', 'stat' => 1));
        $this->load->view('modules/common/tmp_header');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $data);
        //titles details load
        $data['durainfo'] = $this->Generic_model->getData('invest_dura', '', '');
        //bnank details
        $this->db->select("*");
        $this->db->from("bnk_names");
        $this->db->order_by("bknm");
        $this->db->where('bkid != ', '1');
        $query = $this->db->get();
        $data['bankinfo'] = $query->result();
        $this->load->view('modules/admin/invst_pymt.php', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // add invest nic start
    function getInvest_Inpy()
    {
        $inic = $this->input->post('inic');
        $this->db->select("inve_mas.*,inve_bank.*");
        $this->db->from("inve_mas");
        $this->db->join('inve_bank', 'inve_bank.inid = inve_mas.auid');
        $this->db->where('inic', $inic);
        // $this->db->where('ivtp', 1);

        $this->db->where('inve_mas.stat', 1);
        // $this->db->where('inve_bank.stat', 1);
        $query = $this->db->get();
        $data = $query->result();

        //var_dump($query->result());

        //$inicc = $this->input->post('auid');
        /*  $this->db->select("inve_bank.acno");
          $this->db->where('inid', $inic);
          $query = $this->db->get();
          $data['a2'] = $query->result();
  */

        echo json_encode($data);
    }


    //bank acc start
    function getamount()
    {
        //var_dump($this->input->post('auid'));
        $invd = $this->input->post('auid');
        $this->db->select("investment.invd,investment.amnt,investment.inpc");
        $this->db->from("investment");
        $this->db->where('ivid', $invd);
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }
    //bank accnic end

    //bank acc start
    function getToInst()
    {
        //var_getInstdump($this->input->post('auid'));
        $invd = $this->input->post('pyam');
        $this->db->select("investment.invd,investment.amnt,investment.tort,");
        $this->db->from("investment");
        $this->db->join('invest_perid', 'invest_perid.peid = investment.perd', 'left');
        $this->db->where('invd', $invd);

        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

    //get invest
    function getInst()
    {
        $invd = $this->input->post('invd');

        $this->db->select("invest_dura.dunm,investment.invd,investment.stdt,investment.mnrt,investment.pamd,investment.amnt,invest_perid.perd");
        $this->db->from("investment");
        $this->db->join('invest_perid', 'invest_perid.peid = investment.perd', 'left');
        $this->db->join('invest_dura', 'invest_dura.auid = investment.pamd', 'left');

        $this->db->where('invd', $invd);
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

    // paymnet view start
    function getInpy()
    {
        $pyam = $this->input->post('pyam');
        $acno = $this->input->post('acno');

        // var_dump($this->input->post('acno'));
        $this->db->select("SUM(invst_pymt.amnt) As amunt ,invst_pymt.pyid,invst_pymt.pyam");
        $this->db->from("invst_pymt");
        //  $this->db->join('inve_bank', 'inve_bank.inid = inve_mas.auid');
        $this->db->where('pyam', $pyam);
        $this->db->where('acno', $acno);

        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

    //searchInvestPyment serach table start
    function searchInvestPyment()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('invst_pymt');
        $result = $this->Admin_model->get_inspyDtils();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            //  var_dump($row->auid);
            if ($row->ivtp == 0) {
                $trac = "<span class='label label-primary' title='pending'>intruducer</span>";

            } else {
                $tra = "<span class='label label-info' title='inactive'>invester</span>";
            }
            if ($row->psat == 0) {
                $tra = "<span class='label label-primary' title='pending'>pending</span>";
                $option = "<button type='button' id='view'  data-toggle='modal' data-target='#modalView' onclick='vewPynt($row->pyid)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'   data-toggle='modal' data-target='#modaledit' onclick='editPaymt(" . $row->pyid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  data-toggle='modal' data-target='#modaledit' onclick='editPaymt(" . $row->pyid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'   onclick='rejecInvesBank($row->invd);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                "<button type='button' id='rej'   onclick='rejInvest($row->pyid);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";

            }
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->inic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->mail;
            $sub_arr[] = $trac;
            $sub_arr[] = $row->amnt;
            $sub_arr[] = $row->tort;
            $sub_arr[] = $row->amnt;
            $sub_arr[] = $tra;
            $sub_arr[] = $option;

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_inspy(),
            "recordsFiltered" => $this->Admin_model->count_filtered_inspy(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //searchInvestPyment table end
    //bank accnic end
    function vewpayment()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('invst_bnk');
        $this->db->select("inve_bank.*,inve_mas.innm,inve_mas.auid,inve_mas.inic,bnk_names.bknm");
        $this->db->from("inve_bank");
        $this->db->join('inve_mas', 'inve_mas.auid = inve_bank.inid');
        $this->db->join('bnk_names', 'bnk_names.bkid = inve_bank.bkid');
//select * from aaa whree bnid='1';

        $this->db->where('bnid', $this->input->post('bnid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }
    // investor view end

    // invest add start
    function addInPy()

    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $data_arr = array(

            'pnic' => $this->input->post('auid'),
            'pyam' => $this->input->post('pyam'),
            'acno' => $this->input->post('acno'),
            //'toin' => $this->input->post('toin'),
            'amnt' => $this->input->post('amnt'),
            'remk' => $this->input->post('remk'),

            'psat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('invst_pymt', $data_arr);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    // invest add end


//invest payment end

//invest payment end

}
