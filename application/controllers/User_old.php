<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
        $this->output->delete_cache();

        // Deletes cache for /foo/bar
        // $this->output->delete_cache('/foo/bar');

        $this->load->library('Pdf'); // Load library
        //$this->load->library('Fpdi');

        $this->pdf->fontpath = 'font/'; // Specify font folder

        $this->load->database(); // load database
        $this->load->model('Generic_model'); // load model
        $this->load->model('User_model'); // load model
        $this->load->model('Log_model'); // load model

        date_default_timezone_set('Asia/Colombo');

        if (!empty($_SESSION['userId'])) {

        } else {
            redirect('/');
        }
    }

    public function index()
    {
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');

        $usid = $_SESSION['userId'];
        $usdt = $this->Generic_model->getData('user_mas', array('brch', 'usmd'), array('auid' => $usid));
        $brch = $usdt[0]->brch;
        $usmd = $usdt[0]->usmd;

// SWEETY NOTIFICATION MESSAGE COUNT
        $tody = date('Y-m-d');
        $role = $_SESSION['role'];
        $usid = $_SESSION['userId'];
        $this->db->select("test.*, user_mas.desg, user_mas.auid , DATE_FORMAT(test.crdt, '%Y-%m-%d') AS crdt");
        $this->db->from("user_mas");
        $this->db->join("(SELECT * FROM syst_mesg WHERE cmtp=1 UNION SELECT * FROM syst_mesg WHERE cmtp=2 AND uslv='$role' UNION SELECT * FROM syst_mesg WHERE mgus='$usid') AS test ", "test.crby=user_mas.auid");
        $this->db->where(" DATE_ADD(DATE_FORMAT(test.crdt, '%Y-%m-%d'), INTERVAL +1 DAY) > '$tody'");
        $this->db->where("test.swnt", 1);
        $this->db->order_by("test.crdt", "desc");
        $query = $this->db->get();
        $data['notfymsg'] = $query->result();


        $this->load->view('modules/user/includes/user_header', $data);
        $this->load->view('modules/user/dash');
        $this->load->view('modules/common/footer');
    }


    function getSalesData()
    {
        echo json_encode(true);
    }

    public function xyz()
    {
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header');

        $this->load->view('modules/user/xyz');
        $this->load->view('modules/common/footer');

    }

// ************* Start common data   ***********
// ************* Start common data   ***********

    public function getCustNo()
    {
        //$result = $this->Generic_model->getData('cus_mas', 'cuno', array('cuid' => $this->input->post('id')),'');
        $result = $this->Generic_model->getData('cus_mas', array('cuno'), array('cuid' => $this->input->post('id')));
        echo json_encode($result);
    }

    function getExecutive()
    {
        $branch = $this->input->post('brch_id');
        if ($branch == 'all') {
            $this->db->select("auid,fnme,lnme");
            $this->db->from("user_mas");
            $this->db->where_in('usmd', array('4', '5')); // 4 - BM / 5 - officer
            // $this->db->or_where('user_level', '5');
            $this->db->where('stat', '1');
            $query = $this->db->get();
            $result = $query->result();
        } else {
            $this->db->select("auid,fnme,lnme");
            $this->db->from("user_mas");
            $this->db->where('brch', $branch);
            $this->db->where_in('usmd', array('4', '5')); // 4 - BM / 5 - officer
            $this->db->where('stat', '1');
            $this->db->order_by("fnme", "asc");
            $query = $this->db->get();
            $result = $query->result();
        }
        echo json_encode($result);
    }

    public function getCenter()
    {
        $branch = $this->input->post('branch_id');
        $exe = $this->input->post('exe_id');

        if ($exe == 'all' || $exe == '0') {
            if ($branch == 'all') {
                $result = $this->Generic_model->getSortData('cen_mas', array('caid', 'cnnm'), array('stat' => '1'), '', '', 'cnnm');
            } else {
                $result = $this->Generic_model->getSortData('cen_mas', array('caid', 'cnnm'), array('brco' => $branch, 'stat' => '1'), '', '', 'cnnm');
            }
        } else {
            $result = $this->Generic_model->getSortData('cen_mas', array('caid', 'cnnm'), array('usid' => $exe, 'stat' => '1'), '', '', 'cnnm');
        }

        echo json_encode($result);

    }

    public function getGrup()
    {
        $brn = $this->input->post('brn_id');
        $exe = $this->input->post('exe_id');
        $cen = $this->input->post('cen_id');

        $this->db->select("grup_mas.*,cen_mas.cnnm ");
        $this->db->from("grup_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = grup_mas.cnid ');
        // $this->db->join('user_mas', 'user_mas.auid = cen_mas.usid ');
        // $this->db->join('brch_mas', 'brch_mas.brid = cen_mas.brco ');

        $this->db->where('grup_mas.stat ', 1);

        if ($brn != 'all') {
            $this->db->where('cen_mas.brco ', $brn);
        }
        if ($exe != 'all') {
            $this->db->where('cen_mas.usid ', $exe);
        }
        if ($cen != 'all') {
            $this->db->where('grup_mas.cnid ', $cen);
        }

        $query = $this->db->get();
        echo json_encode($query->result());

    }

    public function chk_nic()
    {
        $nic = $this->input->post('nic');

        // $result = $this->Generic_model->getData('cen_mas', '', array('cnnm' => $_POST['cnnm'], 'brco' => $_POST['brnc'], 'stat IN (1,2,3)'));
        $result = $this->Generic_model->getData('cus_mas', array('cuid', 'anic'), array('anic' => $nic));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function chk_nic_edt() //strlen(aa)
    {
        $nic = $this->input->post('nic');
        $auid = $this->input->post('auid');

        //var_dump($auid);
        $result = $this->Generic_model->getData('cus_mas', array('cuid', 'anic'), array('anic' => $nic, 'stat IN(1,3)'));

        if (count($result) > 0) {
            if ($result[0]->cuid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    public function chk_mobile()
    {
        $mobi = $this->input->post('mobi');

        $result = $this->Generic_model->getData('cus_mas', array('cuid', 'mobi'), array('mobi' => $mobi));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function chk_mobile_edt()
    {
        $mobi = $this->input->post('mobi');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('cus_mas', array('cuid', 'mobi'), array('mobi' => $mobi));
        if (count($result) > 0) {
            var_dump($result);
            if ($result[0]->cuid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    public function grup_memb_count()
    {
        $cust = $this->Generic_model->getData('cus_mas', '', array('grno' => $this->input->post('grid'), 'stat IN(1,2,3,4)'), '');
        $cust_count = sizeof($cust);

        $grup = $this->Generic_model->getData('grup_mas', array('mxmb'), array('grpid' => $this->input->post('grid'), 'stat' => 1), '');

        if ($grup[0]->mxmb > $cust_count) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function chk_cust_count()
    {
        $cen = $this->input->post('cen');
        $grp = $this->input->post('grp');

        $this->db->select("grup_mas.mxmb,(SELECT COUNT(*) FROM `cus_mas` WHERE `ccnt` = '$cen' AND `grno` = '$grp' AND stat IN(1,2,3,4)) AS crcst  ");
        $this->db->from("grup_mas");

        $this->db->where('grup_mas.stat ', 1);
        $this->db->where('grup_mas.grpid ', $grp);
        $this->db->where('grup_mas.cnid ', $cen);
        $query = $this->db->get()->result();

        // var_dump($query[0]->crcst . '**'.$query[0]->mxmb );
        if ($query[0]->crcst < $query[0]->mxmb) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function chk_custEdt_count()
    {
        $cen = $this->input->post('cen');
        $grp = $this->input->post('grp');

        $this->db->select("grup_mas.mxmb,(SELECT COUNT(*) FROM `cus_mas` WHERE `ccnt` = '$cen' AND `grno` = '$grp' AND stat IN(1,2,3,4)) AS crcst  ");
        $this->db->from("grup_mas");

        $this->db->where('grup_mas.stat ', 1);
        $this->db->where('grup_mas.grpid ', $grp);
        $this->db->where('grup_mas.cnid ', $cen);
        $query = $this->db->get()->result();

        // var_dump($query[0]->crcst . '**'.$query[0]->mxmb );
        if (($query[0]->crcst - 1) < $query[0]->mxmb) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function chk_Centname()
    {
        $result = $this->Generic_model->getData('cen_mas', '', array('cnnm' => $_POST['cnnm'], 'brco' => $_POST['brnc'], 'stat IN (1,2,3)'));

        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    public function chk_Centname_edt()
    {
        $auid = $this->input->post('auid');

        $result = $this->Generic_model->getData('cen_mas', '', array('cnnm' => $_POST['cnnm'], 'brco' => $_POST['brnc'], 'stat IN (1,2,3)'));
        if (count($result) > 0) {
            if ($result[0]->caid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    public function checkCustLoan()
    {
        $result = $this->Generic_model->getData('micr_crt', '', array('apid' => $_POST['id'], 'stat IN (1,2,5)'));
        echo json_encode(count($result));
    }

    // LOAD BANK DETAILS
    public function getBankDtils()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->getData('bnk_accunt', array('acid', 'acnm', 'acno'), array('brco' => $id, 'stat' => 1));
        echo json_encode($result);
    }

    // LOAD BANK BRANCH
    public function getBankBrnc()
    {
        $id = $this->input->post('bkid');
        //$result = $this->Generic_model->getData('', array('auid','brcd', 'brnm'), array('bkid' => $id, 'stat' => 1));
        $result = $this->Generic_model->getSortData('bnk_branch', array('auid','brcd', 'brnm'), array('bkid' => $id, 'stat' => 1), '', '', 'brcd', 'ASE');
        echo json_encode($result);
    }

    // LOAD SHOP DETAILS
    public function getShopDtils()
    {
        $brnc = $this->input->post('brnc');
        $result = $this->Generic_model->getData('shop_mas', array('spid', 'spcd', 'spnm'), array('brid' => $brnc, 'stat' => 1));
        echo json_encode($result);
    }

    // LOAD CHQ DETAILS
    public function getChqDtils()
    {
        $bkid = $this->input->post('bkid');
        $this->db->select("chq_issu.cqno,chq_issu.cqid ");
        $this->db->from("chq_issu");
        $this->db->join('chq_book', 'chq_book.cqid = chq_issu.cqbk');
        $this->db->where('chq_book.stat ', 1);
        $this->db->where('chq_issu.stat ', 0);
        $this->db->where('chq_issu.cqam ', 0);
        $this->db->where('chq_issu.vuid ', 0);
        $this->db->where('chq_issu.accid ', $bkid);

        $query = $this->db->get()->result();
        echo json_encode($query);
    }

// LOAD BRANCH WISE BANK ACCOUNT
    function getBankAcc()
    {
        $user = $_SESSION["userId"];
        $this->db->select('usmd,auid,fnme,lnme,brch');
        $this->db->from('user_mas');
        $this->db->where('auid=' . $user);
        $query = $this->db->get();
        $user_data = $query->result();

        if ($user_data[0]->usmd == 1 || $user_data[0]->usmd == 2) {
            $result = $this->Generic_model->getData('bnk_accunt', array('acid', 'acnm', 'acno'), array('stat' => 1));
            return $result;
        } else {
            $result = $this->Generic_model->getData('bnk_accunt', array('acid', 'acnm', 'acno'), array('brco' => $user_data[0]->brch, 'stat' => 1));
            return $result;
        }
    }

    // LOAD BRANCH WISE BANK ACCOUNT
    function getBankAccount()
    {
        $id = $this->input->post('id');

        if ($id != 'all') {
            $result = $this->Generic_model->getData('bnk_accunt', array('acid', 'acnm', 'acno'), array('brco' => $id, 'stat' => 1));
        } else {
            $result = $this->Generic_model->getData('bnk_accunt', array('acid', 'acnm', 'acno'), array('stat' => 1));
        }
        echo json_encode($result);
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

// ************* end common data   ***********
// ************* end common data   ***********


    // center
    public function cent_mng()
    {
        // User Access Page Log  $this->Log_model->userLog('cent_mng');
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('cent_mng');
        $data['policy'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2'), array('popg' => 'cent_mng', 'stat' => 1));


        $this->load->view('modules/common/tmp_header');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        //  $data['centinfo'] = $this->Generic_model->getCen();
        $data['cendays'] = $this->Generic_model->getData('cen_days', '', '');
        $this->load->view('modules/user/center_managemnt', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function searchCenter()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cent_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Search Center');

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

        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "hidden";
        }


        $result = $this->User_model->get_centerDtils();
        $data = array();
        $i = $_POST['start'];


        foreach ($result as $row) {

            if ($row->cncust > 0) {  // count of center customer
                $rej2 = "disabled";
            } else {
                $rej2 = "";
            }
            $st = $row->stat;
            if ($st == '1') {  //active
                $stat = "<span class='label label-success'>" . $row->stnm . "</span> ";
                $option = "<button type='button' $viw  id='" . $row->caid . "' data-toggle='modal' data-target='#modalView' onclick='viewCnter(this.id)' class='btn btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtCnter(" . $row->caid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtCnter(" . $row->caid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' " . $rej . " $rej2 onclick='rejecCnter(" . $row->caid . " );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '3') {  //pending
                $stat = "<span class='label label-warning'>" . $row->stnm . "</span> ";
                $option = "<button type='button' $viw  id='" . $row->caid . "' data-toggle='modal' data-target='#modalView' onclick='viewCnter(this.id)' class='btn btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtCnter(" . $row->caid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' " . $app . " data-toggle='modal' data-target='#modalEdt' onclick='edtCnter(" . $row->caid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' " . $rej . " onclick='rejecCnter(" . $row->caid . " );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {  // inactive
                $stat = "<span class='label label-danger'>" . $row->stnm . "</span> ";
                $option = "<button type='button' $viw  id='" . $row->caid . "' data-toggle='modal' data-target='#modalView' onclick='viewCnter(this.id)' class='btn btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtCnter(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtCnter(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' onclick='reactCnter($row->caid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";

            }

            $cnld = "   <a  href='#' title='Mobile :  $row->mobi '> $row->init </a> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->cnno;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->cday;
            $sub_arr[] = $cnld;
            $sub_arr[] = $row->cncust; //  count of center customer
            $sub_arr[] = $row->lncnt;
            $sub_arr[] = $row->mcus;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_cnter(),
            "recordsFiltered" => $this->User_model->count_filtered_cnter(),
            "data" => $data,
        );
        echo json_encode($output);


    }

    function addCenter()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cent_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add Center');

        $brn = $this->input->post('brch_cnt');

        $this->db->select("cen_mas.brco,cen_mas.cnno,cen_mas.stat,cen_mas.usid");
        $this->db->from("cen_mas");
        $this->db->where('cen_mas.brco', $brn);
        $this->db->order_by('cen_mas.cnno', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $n_cnno = 1;
        } else {
            $n_cnno = $data[0]->cnno + 1;
        }

        $data_arr = array(
            'brco' => $this->input->post('brch_cnt'),
            'cnno' => $n_cnno,
            'cnnm' => ucwords(strtolower($this->input->post('cntnm'))),
            'usid' => $this->input->post('cnt_exc'),
            'cody' => $this->input->post('coldy'),
            'mimb' => $this->input->post('mimb'),
            'mcus' => $this->input->post('mxmbr'),
            'frtm' => $this->input->post('frotm'),
            'totm' => $this->input->post('totm'),
            'rmks' => $this->input->post('remk'),
            'gplg' => $this->input->post('gplg'),
            'gplt' => $this->input->post('gplt'),
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
            'stat' => 3
        );
        $result = $this->Generic_model->insertData('cen_mas', $data_arr);
        //  echo json_encode($result);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function rejCenter()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cent_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Reject Center');

        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('cen_mas', array('stat' => 2), array('caid' => $id));

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    function vewCenter()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cent_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'View Center');


        $this->db->select("cen_mas.*,brch_mas.brnm,user_mas.fnme,user_mas.lnme,cen_days.cday");
        $this->db->from("cen_mas");
        $this->db->join('brch_mas', 'brch_mas.brid = cen_mas.brco ');
        $this->db->join('user_mas', 'user_mas.auid = cen_mas.usid ');
        $this->db->join('cen_days', 'cen_days.dyid = cen_mas.cody ');

        $this->db->where('cen_mas.caid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function edtCenter()
    {
        $func = $this->input->post('func');
        $brn = $this->input->post('branch_edt');
        $auid = $this->input->post('auid');

        if ($func == '1') {                  // update
            $data_arr = array(
                'brco' => $this->input->post('brch_cnt_edt'),
                'cnnm' => ucwords(strtolower($this->input->post('cntnm_edt'))),
                'usid' => $this->input->post('cnt_exc_edt'),
                'cody' => $this->input->post('coldy_edt'),
                'mcus' => $this->input->post('mxmbr_edt'),
                'frtm' => $this->input->post('frotm_edt'),
                'totm' => $this->input->post('totm_edt'),
                'rmks' => $this->input->post('remk_edt'),
                'gplg' => $this->input->post('gplg_edt'),
                'gplt' => $this->input->post('gplt_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
                // 'stat' => 3
            );

            $funcPerm = $this->Generic_model->getFuncPermision('cent_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Edit Center (' . $auid . ')');
        } elseif ($func == '2') {            // approvel
            $data_arr = array(
                'brco' => $this->input->post('brch_cnt_edt'),
                'cnnm' => ucwords(strtolower($this->input->post('cntnm_edt'))),
                'usid' => $this->input->post('cnt_exc_edt'),
                'cody' => $this->input->post('coldy_edt'),

                'mcus' => $this->input->post('mxmbr_edt'),
                //'nogr' => $this->input->post('ngrp_edt'),
                'frtm' => $this->input->post('frotm_edt'),
                'totm' => $this->input->post('totm_edt'),

                'rmks' => $this->input->post('remk_edt'),
                'gplg' => $this->input->post('gplg_edt'),
                'gplt' => $this->input->post('gplt_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
                'stat' => 1
            );

            $funcPerm = $this->Generic_model->getFuncPermision('cent_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Approval Center (' . $auid . ')');
        }
        $where_arr = array(
            'caid' => $auid
        );

        $result22 = $this->Generic_model->updateData('cen_mas', $data_arr, $where_arr);

        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    function reatCenter()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cent_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Reactive Center');

        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('cen_mas', array('stat' => 1), array('caid' => $id));

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }
    // end center

    // center leader
    public function cent_ledr()
    {
        // User Access Page Log  $this->Log_model->userLog('cent_ledr');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        //$data['cendays'] = $this->Generic_model->getData('cen_days', '', '');

        $this->load->view('modules/user/center_leader', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function searchCnledr()
    {
        // $userlvl = $this->Generic_model->getData('user_mas', array('auid', 'usmd'), array('auid' => $_SESSION['userId']));

        $result = $this->User_model->get_cenLedrDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $option = " <button type='button' id='add'  onclick='addLedr(" . $row->cuid . ", " . $row->caid . " ,id);' class='btn btn-default btn-condensed' title='Add Leader'><i class='fa fa-plus' aria-hidden='true'></i></button>  " .
                "<button type='button' id='rmv'  onclick='remvLedr(" . $row->cuid . ", " . $row->caid . ",id );' class='btn btn-default btn-condensed' title='Remove Leader'><i class='fa fa-minus' aria-hidden='true'></i></button> ";

            $cutp = " <span class='label label-default'>" . $row->cutp . "</span> ";
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->grno;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $cutp;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_cnldr(),
            "recordsFiltered" => $this->User_model->count_filtered_cnldr(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function chkLeader()
    {
        $cntid = $this->input->post('cntid');
        $ledr = $this->Generic_model->getData('cen_mas', array('caid', 'cled'), array('caid' => $cntid));

        echo json_encode($ledr);
    }

    function addLeader()
    {
        $cusid = $this->input->post('csid');
        $cnid = $this->input->post('cnid');

        $result = $this->Generic_model->getData('cen_mas', '', $where = array('caid' => $cnid));
        $cnled = $result[0]->cled;
        $result1 = $this->Generic_model->updateData('cen_mas', array('cled' => $cusid), array('caid' => $cnid));
        $result22 = $this->Generic_model->updateData('cus_mas', array('metp' => 1), array('cuid' => $cnled));
        $result2 = $this->Generic_model->updateData('cus_mas', array('metp' => 3), array('cuid' => $cusid));

        if (count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function rmvLeader()
    {
        $cusid = $this->input->post('csid');
        $cnid = $this->input->post('cnid');

        $result1 = $this->Generic_model->updateData('cen_mas', array('cled' => 0), array('caid' => $cnid));
        $result2 = $this->Generic_model->updateData('cus_mas', array('metp' => 1), array('cuid' => $cusid));

        if (count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }


    }

    // end center leader

    // group
    public function grup_mng()
    {
        // User Access Page Log   $this->Log_model->userLog('grup_mng');
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('grup_mng');
        $data['policy'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2'), array('popg' => 'grup_mng', 'stat' => 1));

        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['cendays'] = $this->Generic_model->getData('cen_days', '', '');

        $this->load->view('modules/user/group_managemnt', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function searchGroup()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('grup_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Search Group');
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }

        $result = $this->User_model->get_grupDtils();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            if ($row->grcust > 0) {
                $rej = "disabled";
            } else {
                $rej = "";
            }
            $st = $row->stat;
            if ($st == '1') {  //active
                $stat = " <span class='label label-success'>" . $row->stnm . "</span> ";
                $option = "<button type='button' id='rej' $rej onclick='rejGrp($row->grpid);' class='btn btn-default btn-condensed' title='Reject'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                // "<button type='button' id='edt'   data-toggle='modal' data-target='#modalEdt' onclick='edtGrup( $row->grpid ,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
            } else if ($st == '2') {  // inactive
                $stat = " <span class='label label-danger'>" . $row->stnm . "</span> ";
                $option = "<button type='button' id='rej' disabled onclick='rejecCnter( );' class='btn btn-default btn-condensed' title='Reject'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                //"<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtCnter(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->grno;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->grcust; // cus count
            $sub_arr[] = $row->mxmb;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->all_grp(),
            "recordsFiltered" => $this->User_model->filtered_grp(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function vewGrup()
    {
        $this->db->select("grup_mas.*,cen_mas.brco,cen_mas.usid,cen_mas.cnnm,user_mas.fnme,user_mas.lnme,brch_mas.brnm ");
        $this->db->from("grup_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = grup_mas.cnid ');
        $this->db->join('user_mas', 'user_mas.auid = cen_mas.usid ');
        $this->db->join('brch_mas', 'brch_mas.brid = cen_mas.brco ');

        $this->db->where('grup_mas.grpid ', $this->input->post('auid'));
        $query = $this->db->get();
        $data['selectgrp'] = $query->result();

        echo json_encode($data);
    }

    function addGrup()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('grup_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Group GNO (' . $this->input->post('grnm') . ')');

        $data_arr = array(
            'cnid' => $this->input->post('cent'),
            'grno' => $this->input->post('grnm'),
            //'mebr' => $this->input->post('cnt_exc'),
            'mimb' => $this->input->post('mimb'),
            'mxmb' => $this->input->post('mxmbr'),
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
            'stat' => 1
        );
        $result = $this->Generic_model->insertData('grup_mas', $data_arr);

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function edtGroup()
    {
        $result22 = $this->Generic_model->updateData('grup_mas', array('mxmb' => $this->input->post('mxmbr_edt')), array('grpid' => $this->input->post('auid')));

        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function rejGroup()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('grup_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Group Inactive');


        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('grup_mas', array('stat' => 2), array('grpid' => $id));

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    public function chk_Grupname()
    {
        $result = $this->Generic_model->getData('grup_mas', '', array('grno' => $_POST['grnm'], 'cnid' => $_POST['cent'], 'stat IN (1,2)'));

        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
    // end group

    // group leader  //grup_ledr
    public function grup_ledr()
    {
        // User Access Page Log      $this->Log_model->userLog('grup_ledr');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $this->load->view('modules/user/group_leader', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function searchGrpledr()
    {
        $result = $this->User_model->get_grupLedrDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->metp == 3) {
                $disab = "disabled";
            } else {
                $disab = "";
            }
            $option = " <button type='button' id='add' $disab onclick='addGrpLedr(" . $row->cuid . ", " . $row->grpid . " ,id);' class='btn btn-default btn-condensed' title='Add Leader'><i class='fa fa-plus' aria-hidden='true'></i></button>  " .
                "<button type='button' id='rmv' $disab onclick='remvGrpLedr(" . $row->cuid . ", " . $row->grpid . ",id );' class='btn btn-default btn-condensed' title='Remove Leader'><i class='fa fa-minus' aria-hidden='true'></i></button> ";

            $cutp = " <span class='label label-default'>" . $row->cutp . "</span> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->grno;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $cutp;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_grpldr(),
            "recordsFiltered" => $this->User_model->count_filtered_grpldr(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function chkgrpLeader()
    {
        $grpid = $this->input->post('grpid');
        $ledr = $this->Generic_model->getData('grup_mas', array('grpid', 'grld'), array('grpid' => $grpid));

        echo json_encode($ledr);
    }

    function addgrpLeader()
    {
        $cusid = $this->input->post('csid');
        $grpid = $this->input->post('grpid');

        $result = $this->Generic_model->getData('grup_mas', '', $where = array('grpid' => $grpid));
        $grled = $result[0]->grld;
        $result1 = $this->Generic_model->updateData('grup_mas', array('grld' => $cusid), array('grpid' => $grpid));
        $result22 = $this->Generic_model->updateData('cus_mas', array('metp' => 1), array('cuid' => $grled));
        $result2 = $this->Generic_model->updateData('cus_mas', array('metp' => 2), array('cuid' => $cusid));

        if (count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function rmvgrpLeader()
    {
        $cusid = $this->input->post('csid');
        $grpid = $this->input->post('grpid');

        $result1 = $this->Generic_model->updateData('grup_mas', array('grld' => 0), array('grpid' => $grpid));
        $result2 = $this->Generic_model->updateData('cus_mas', array('metp' => 1), array('cuid' => $cusid));

        if (count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
    //end group leader

    // Customer
    public function cust_mng()
    {
        // User Access Page Log     $this->Log_model->userLog('cust_mng');
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('cust_mng');

        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['eduinfo'] = $this->Generic_model->getData('cus_edu', '', '');
        $data['geninfo'] = $this->Generic_model->getData('cus_gen', '', '', '');
        $data['titlinfo'] = $this->Generic_model->getData('cus_sol', '', '', '');
        $data['cvlinfo'] = $this->Generic_model->getData('cvl_stst', '', '', '');
        $data['relinfo'] = $this->Generic_model->getData('cus_rel', '', array('stat' => 1), '');

        $data['bnkinfo'] = $this->Generic_model->getData('bnk_names', '', 'bkid != 1', '');
        $data['stainfo'] = $this->Generic_model->getSortData('cust_stat', array('stid', 'stnm'), array('isac' => 1), '', '', 'stnm', 'ASE');

        $this->load->view('modules/user/customer_managemnt', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function searchCust()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
//        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Search');

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
        if ($funcPerm[0]->reac == 1) {
            $reac = "";
        } else {
            $reac = "disabled";
        }

        $result = $this->User_model->get_customerDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            if ($row->trst == 1) {
                $tr = "<span class='label label-primary' title='Transfer Customer'>T</span>";
            } else {
                $tr = '';
            }

            if ($row->rgtp == 0) {
                $tp = "<span class='label label-default' title=''>Guarantor</span>";
            } else {
                $tp = "<span class='label label-default' title=''>Customer</span>";
            }
            if ($row->cuty == '1') {
                $cuty = "<span class='label label-primary' title='Normal Customer'> N </span>";

                if ($st == '3' || $st == '4') {  // Approved
                    $stat = " <span class='label label-success'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(" . $row->cuid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(" . $row->cuid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' " . $rej . "  onclick='closeCust($row->cuid);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                } else if ($st == '1') {  // Pending
                    $stat = " <span class='label label-warning'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(" . $row->cuid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' " . $app . " data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(" . $row->cuid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' " . $rej . " onclick='rejecNmCust(" . $row->cuid . " );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
                } else if ($st == '5') {  // Rejected
                    $stat = " <span class='label label-danger'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' disabled onclick='rejecNmCust( );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
                } else if ($st == '11') {  // Close
                    $stat = " <span class='label label-indi'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' $reac onclick='reactvCust($row->cuid);' class='btn btn-default btn-condensed' title='Reactive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
                } else {  // Others
                    $stat = " <span class='label label-default'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' disabled onclick='rejecNmCust( );' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                }
            } else {
                $cuty = "<span class='label label-primary' title='Advance Customer'> A </span>";

                if ($st == '3' || $st == '4') {  // Approved
                    $stat = " <span class='label label-success'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#advCust_edt1' onclick='edtAdvncust(" . $row->cuid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtAdvncust(" . $row->cuid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' " . $rej . "  onclick='closeCust($row->cuid);' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                } else if ($st == '1') {  // Pending
                    $stat = " <span class='label label-warning'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#advCust_edt1' onclick='edtAdvncust(" . $row->cuid . ",id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' " . $app . " data-toggle='modal' data-target='#advCust_edt1' onclick='edtAdvncust(" . $row->cuid . ",id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' " . $rej . " onclick='rejecNmCust(" . $row->cuid . " );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
                } else if ($st == '5') {  // Rejected
                    $stat = " <span class='label label-danger'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtAdvncust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtAdvncust(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' disabled onclick='rejecNmCust( );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
                } else if ($st == '11') {  // Close
                    $stat = " <span class='label label-indi'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' $reac onclick='reactvCust($row->cuid);' class='btn btn-default btn-condensed' title='Reactive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
                } else {  // Others
                    $stat = " <span class='label label-default'>" . $row->stnm . "</span> ";
                    $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                        "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtAdvncust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                        "<button type='button' id='app' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtAdvncust(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                        "<button type='button' id='rej' disabled onclick='rejecNmCust( );' class='btn btn-default btn-condensed' title='Close'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                }
            }

            $nam = "<span title='$row->funm'> $row->init </span> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->exc;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->cuno . ' ' . $tr;
            $sub_arr[] = $nam;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $tp . ' ' . $cuty;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_cust(),
            "recordsFiltered" => $this->User_model->count_filtered_cust(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function addNmlCust()
    {
        // customer profile image
        if (!empty($_FILES['picture']['name'])) {
            $config['upload_path'] = 'uploads/cust_profile/';  //'uploads/images/'
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
        } else {
            $picture = 'default-image.jpg';
            // $picture = $img;
        }

        $cutp = $this->input->post('cutp');

        if ($cutp == null || $cutp == '') {
            $rgtp = 0;
        } else {
            $rgtp = 1;
        }

        $brco = $this->input->post('brch_adcust');
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $this->db->select("cus_mas.cuno,cus_mas.brco,cus_mas.stat");
        $this->db->from("cus_mas");
        $this->db->where('cus_mas.brco ', $brco);
        $this->db->where('cus_mas.stat ', 1);
        $this->db->order_by('cus_mas.cuno', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $cuno_n = $brcd . '/TMP/0001';
        } else {
            $cuno = $data[0]->cuno;
            $re = (explode("/", $cuno));

            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);

            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }

            $cuno_n = $re[0] . '/TMP/' . $xx;
        }

        $data_arr = array(  // $name_nic = ucwords($name_nic);      //ucwords($foo);
            'rgtp' => $rgtp,
            'brco' => $brco,
            'exec' => $this->input->post('exc_adcust'),
            'ccnt' => $this->input->post('cen_adcust'),
            'cuno' => $cuno_n, // cust no
            'grno' => $this->input->post('grup'),
            'metp' => 1,
            'gplg' => $this->input->post('gplg'),
            'gplt' => $this->input->post('gplt'),
            'funm' => strtoupper($this->input->post('funm')),
            'init' => strtoupper($this->input->post('init')),
            'hoad' => strtoupper($this->input->post('hoad')),
            'tele' => $this->input->post('tele'),
            'mobi' => $this->input->post('mobi'),
            'anic' => strtoupper($this->input->post('nic')),
            'dobi' => $this->input->post('dobi'),
            'gend' => $this->input->post('gend'),
            'titl' => $this->input->post('titl'),
            'edun' => $this->input->post('edun'),
            'cist' => $this->input->post('cist'),
            'gsaw' => $this->input->post('gsaw'),
            'uimg' => $picture,
            'smst' => $this->input->post('smst'),

            'stat' => 1,
            'cuty' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),

            'bkdt' => $this->input->post('bkdt'),
            'bkid' => $this->input->post('bknm'),
            'bkbr' => ucwords(strtolower($this->input->post('bkbr'))),
            'acno' => $this->input->post('acno'),
            'emil' => $this->input->post('emil'),

        );
        $result = $this->Generic_model->insertData('cus_mas', $data_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Normal Customer (' . $cuno_n . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function vewCustmer()
    {
        // $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
        // $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer View id(' . $this->input->post('auid') . ')');

        $this->db->select("cus_mas.*,cus_mas.cuid AS cuauid,cus_mas_advnc.*,grup_mas.grno AS grnm,brch_mas.brnm ,cen_mas.cnnm, cus_gen.gndt,cvl_stst.cvdt,
        cus_type.cutp ,cus_rel.redt,cus_edu.eddt,user_mas.fnme ,user_mas.lnme,bnk_names.bknm ");
        $this->db->from("cus_mas");
        $this->db->join('cus_mas_advnc', 'cus_mas_advnc.cuid = cus_mas.cuid ', 'left');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco ');

        $this->db->join('user_mas', 'user_mas.auid = cen_mas.usid ');
        $this->db->join('cus_gen', 'cus_gen.gnid = cus_mas.gend ');
        $this->db->join('cus_edu', 'cus_edu.edid = cus_mas.edun ');
        $this->db->join('cvl_stst', 'cvl_stst.cvid = cus_mas.cist ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->join('cus_rel', 'cus_rel.reid = cus_mas_advnc.apre ', 'left');
        $this->db->join('bnk_names', 'bnk_names.bkid = cus_mas.bkid ', 'left');

        $this->db->where('cus_mas.cuid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function normal_cust_edt()
    {
        $func = $this->input->post('func');

        // customer profile image
        if (!empty($_FILES['picture']['name'])) {
            // previous image delete
            $path = "uploads/cust_profile/";
            $imagename = $this->input->post('nmusrpict');
            //unlink($path . $imagename);
            // Default customer image not delete
            if ($imagename != 'default-image.jpg') {
                unlink($path . $imagename);
            }

            $config['upload_path'] = 'uploads/cust_profile/';  //'uploads/images/' cust_profile
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
        } else {
            $picture = $this->input->post('nmusrpict');
        }

        if ($func == '1') {                  // update
            $this->db->trans_begin(); // SQL TRANSACTION START

            $stst = $this->input->post('nm_stat');
            if ($stst == 1) { // pending
                $data_ar1 = array(
                    'brco' => $this->input->post('brch_edtcust'),
                    'exec' => $this->input->post('exc_edtcust'),
                    'ccnt' => $this->input->post('cen_edtcust'),
                    'grno' => $this->input->post('grup_edtcust'),
                    'gplg' => $this->input->post('gplg_edt'),
                    'gplt' => $this->input->post('gplt_edt'),
                    'funm' => strtoupper($this->input->post('funm_edt')),
                    'init' => strtoupper($this->input->post('init_edt')),
                    'hoad' => strtoupper($this->input->post('hoad_edt')),
                    'tele' => $this->input->post('tele_edt'),
                    'mobi' => $this->input->post('mobi_edt'),
                    'anic' => $this->input->post('nic_edt'),
                    'dobi' => $this->input->post('dobi_edt'),
                    'gend' => $this->input->post('gend_edt'),
                    'titl' => $this->input->post('titl_edt'),
                    'edun' => $this->input->post('edun_edt'),
                    'cist' => $this->input->post('cist_edt'),
                    'gsaw' => $this->input->post('gsaw_edt'),
                    'uimg' => $picture,
                    'smst' => $this->input->post('smst_edt'),

                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),

                    'bkdt' => $this->input->post('bkdt_edt'),
                    'bkid' => $this->input->post('bknm_edt'),
                    'bkbr' => ucwords(strtolower($this->input->post('bkbr_edt'))),
                    'acno' => $this->input->post('acno_edt'),
                    'emil' => $this->input->post('emil_edt'),
                );

                $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
                $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Normal Customer Edit (' . $this->input->post('init_edt') . ')');
            } else if ($stst == 3 || $stst == 4) { // approval
                $data_ar1 = array(
                    'gplg' => $this->input->post('gplg_edt'),
                    'gplt' => $this->input->post('gplt_edt'),
                    'funm' => strtoupper($this->input->post('funm_edt')),
                    'init' => strtoupper($this->input->post('init_edt')),
                    'hoad' => strtoupper($this->input->post('hoad_edt')),
                    'tele' => $this->input->post('tele_edt'),
                    'mobi' => $this->input->post('mobi_edt'),
                    'anic' => strtoupper($this->input->post('nic_edt')),
                    'dobi' => $this->input->post('dobi_edt'),
                    'gend' => $this->input->post('gend_edt'),
                    'titl' => $this->input->post('titl_edt'),
                    'edun' => $this->input->post('edun_edt'),
                    'cist' => $this->input->post('cist_edt'),
                    'gsaw' => $this->input->post('gsaw_edt'),
                    'uimg' => $picture,
                    'smst' => $this->input->post('smst_edt'),
                    'emil' => $this->input->post('emil_edt'),

                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),

                    //'bkdt' => $this->input->post('bkdt_edt'),
                    //'bkid' => $this->input->post('bknm_edt'),
                    //'bkbr' => $this->input->post('bkbr_edt'),
                    //'acno' => $this->input->post('acno_edt'),
                );

                $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
                $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Approval Customer Edit (' . $this->input->post('init_edt') . ')');
            }
            $where_arr = array(
                'cuid' => $this->input->post('auid')
            );

            $result22 = $this->Generic_model->updateData('cus_mas', $data_ar1, $where_arr);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }

        } else if ($func == '2') {            // approvel
            $this->db->trans_begin(); // SQL TRANSACTION START

            $brco = $this->input->post('brch_edtcust');
            $ccnt = $this->input->post('cen_edtcust');

            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
            $brcd = $brdt[0]->brcd;

            $cndt = $this->Generic_model->getData('cen_mas', array('caid', 'cnno', 'stat'), array('caid' => $ccnt, 'stat' => 1));
            $cn = $cndt[0]->cnno;
            $cc = strlen($cn);

            if ($cc == 1) {
                $cncd = '000' . $cn;
            } else if ($cc == 2) {
                $cncd = '00' . $cn;
            } else if ($cc == 3) {
                $cncd = '0' . $cn;
            } else if ($cc == 4) {
                $cncd = '' . $cn;
            }

            // Genarate customer next auto number
            $this->db->select("cuno,brid,ccnt");
            $this->db->from("cus_mas_base");
            $this->db->where('cus_mas_base.brid ', $brco);
            $this->db->where('cus_mas_base.ccnt ', $ccnt);
            // $this->db->where_in('cus_mas.stat', array('3','4')); // approval customer
            // $this->db->where('stat IN(3,4)');
            $this->db->order_by('cus_mas_base.cuno', 'desc');

            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            if (count($data) == '0') {
                $cuno_n = $brcd . '/' . $cncd . '/00001';

            } else {
                $cuno = $data[0]->cuno;
                $re = (explode("/", $cuno));

                $aa = intval($re[2]) + 1;
                $cc = strlen($aa);

                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '0' . $aa;
                }

                // $cuno_n = $re[0] . '/' . $re[1] . '/' . $xx;
                $cuno_n = $brcd . '/' . $cncd . '/' . $xx;
            }

            $data_arr = array(
                'brco' => $brco,
                'exec' => $this->input->post('exc_edtcust'),
                'ccnt' => $ccnt,
                'cuno' => $cuno_n, // cust no
                'grno' => $this->input->post('grup_edtcust'),
                'gplg' => $this->input->post('gplg_edt'),
                'gplt' => $this->input->post('gplt_edt'),
                'funm' => strtoupper($this->input->post('funm_edt')),
                'init' => strtoupper($this->input->post('init_edt')),
                'hoad' => strtoupper($this->input->post('hoad_edt')),
                'tele' => $this->input->post('tele_edt'),
                'mobi' => $this->input->post('mobi_edt'),
                'anic' => strtoupper($this->input->post('nic_edt')),
                'dobi' => $this->input->post('dobi_edt'),
                'gend' => $this->input->post('gend_edt'),
                'titl' => $this->input->post('titl_edt'),
                'edun' => $this->input->post('edun_edt'),
                'cist' => $this->input->post('cist_edt'),
                'gsaw' => $this->input->post('gsaw_edt'),
                'uimg' => $picture,
                'smst' => $this->input->post('smst_edt'),

                'stat' => 3, // approved
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),

                'bkdt' => $this->input->post('bkdt_edt'),
                'bkid' => $this->input->post('bknm_edt'),
                'bkbr' => ucwords(strtolower($this->input->post('bkbr_edt'))),
                'acno' => $this->input->post('acno_edt'),
                'emil' => $this->input->post('emil_edt'),
            );

            $where_arr = array(
                'cuid' => $this->input->post('auid')
            );

            $result22 = $this->Generic_model->updateData('cus_mas', $data_arr, $where_arr);

            // ***  Customer Branch details insert ****
            $data_arr33 = array(
                'cuid' => $this->input->post('auid'),
                'cuno' => $cuno_n, // cust no
                'brid' => $brco,
                'exec' => $this->input->post('exc_edtcust'),
                'ccnt' => $ccnt,
                'grno' => $this->input->post('grup_edtcust'),
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $this->Generic_model->insertData('cus_mas_base', $data_arr33);
            // *** end Customer Branch details ****

            $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Normal Customer Approval id(' . $this->input->post('auid') . ')');

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

    //customer reject
    function rejNormlCust()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('cus_mas', array('stat' => 5), array('cuid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Reject id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // customer close
    function closeCustmer()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('cus_mas', array('stat' => 11), array('cuid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Close id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // customer reactive
    function reactCustm()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('cus_mas', array('stat' => 4), array('cuid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // advance customer
    function addAdvnCust()
    {
//        var_dump($_FILES['adv_cust_pro']['name']);
//        var_dump($_FILES['img_nic']['name']);
//        var_dump($_FILES['img_gscr']['name']);
//        var_dump($_FILES['img_bslc']['name']);
//        var_dump($_FILES['img_othr']['name']);

        // user pic  -  adv_cust_pro
        // user nic  -  img_nic
        // GSC       -  img_gscr
        // bus loc   -  img_bslc
        // use other -  img_othr

        $this->db->trans_begin(); // SQL TRANSACTION START

        // customer profile image
        if (!empty($_FILES['adv_cust_pro']['name'])) {
            $config['upload_path'] = 'uploads/cust_profile/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            // $config['max_width'] = '1024';
            // $config['max_height'] = '768';
            $config['file_name'] = $_FILES["adv_cust_pro"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('adv_cust_pro')) {
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else {
            $picture = 'default-image.jpg';
        }
        // user_document
        if (!empty($_FILES['img_nic']['name'])) {
            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["img_nic"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_nic')) {
                $uploadData = $this->upload->data();
                $img_nic = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else {
            $img_nic = 'document-default.jpg';
        }
        if (!empty($_FILES['img_gscr']['name'])) {
            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["img_gscr"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_gscr')) {
                $uploadData = $this->upload->data();
                $img_gscr = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else {
            $img_gscr = 'document-default.jpg';
        }
        if (!empty($_FILES['img_bslc']['name'])) {
            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["img_bslc"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_bslc')) {
                $uploadData = $this->upload->data();
                $img_bslc = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else {
            $img_bslc = 'document-default.jpg';
        }
        if (!empty($_FILES['img_othr']['name'])) {
            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["img_othr"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_othr')) {
                $uploadData = $this->upload->data();
                $img_othr = $uploadData['file_name'];
            } else {
                $picture = '';
            }
        } else {
            $img_othr = 'document-default.jpg';
        }

        $brco = $this->input->post('adv_brch');

        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $this->db->select("cus_mas.cuno,cus_mas.brco,cus_mas.stat");
        $this->db->from("cus_mas");
        $this->db->where('cus_mas.brco ', $brco);
        $this->db->where('cus_mas.stat ', 1);
        $this->db->order_by('cus_mas.cuno', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') { // Genarate Nest Tmp No
            $cuno_n = $brcd . '/TMP/0001';
        } else {
            $cuno = $data[0]->cuno;
            $re = (explode("/", $cuno));
            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);

            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }
            $cuno_n = $re[0] . '/TMP/' . $xx;
        }

        $data_arr = array(  // $name_nic = ucwords($name_nic);      //ucwords($foo);
            'brco' => $brco,
            'exec' => $this->input->post('adv_exc'),
            'ccnt' => $this->input->post('adv_cen'),
            'cuno' => $cuno_n, // cust no
            'grno' => $this->input->post('adv_grup'),
            'metp' => 1,
            'gplg' => $this->input->post('adv_gplg'),
            'gplt' => $this->input->post('adv_gplt'),
            'funm' => strtoupper($this->input->post('adv_funm')),
            'init' => strtoupper($this->input->post('adv_init')),
            'hoad' => strtoupper($this->input->post('adv_hoad')),
            'tele' => $this->input->post('adv_tele'),
            'mobi' => $this->input->post('adv_mobi'),
            'anic' => strtoupper($this->input->post('adv_nic')),
            'dobi' => $this->input->post('adv_dobi'),
            'gend' => $this->input->post('adv_gend'),
            'titl' => $this->input->post('adv_titl'),
            'edun' => $this->input->post('adv_edun'),
            'cist' => $this->input->post('adv_cist'),
            'gsaw' => $this->input->post('adv_gsaw'),
            'uimg' => $picture,
            'smst' => $this->input->post('adv_smst'),

            'stat' => 1,
            'cuty' => 2,
            'rgtp' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),

            'bkdt' => $this->input->post('adv_bkdt'),
            'bkid' => $this->input->post('adv_bknm'),
            'bkbr' => ucwords(strtolower($this->input->post('adv_bkbr'))),
            'acno' => $this->input->post('adv_acno'),
            'emil' => $this->input->post('adv_emil'),
        );
        $last_id = $this->Generic_model->insertData('cus_mas', $data_arr);

        $data_arr2 = array(
            //'funm' => strtoupper($this->input->post('adv_funm')),

            'cuid' => $last_id, // customer auto id
            'sunm' => $this->input->post('sunm'),
            'snic' => strtoupper($this->input->post('spnic')),

            'fmem' => $this->input->post('fmem'),
            'mopr' => $this->input->post('mopr'),
            'apre' => $this->input->post('apre'),

            'occu' => $this->input->post('occu'),
            'impr' => $this->input->post('impr'),
            'bsad' => $this->input->post('bsad'),
            'buss' => $this->input->post('buss'),
            'rgno' => $this->input->post('rgno'),
            'dura' => $this->input->post('dura'),
            'bupl' => $this->input->post('bupl'),
            'butp' => $this->input->post('butp'),
            'beml' => $this->input->post('beml'),

            'bsin' => $this->input->post('bsin'),
            'obin' => $this->input->post('obin'),
            'diin' => $this->input->post('diin'),
            'odin' => $this->input->post('odin'),
            'spin' => $this->input->post('spin'),
            'osin' => $this->input->post('osin'),
            'food' => $this->input->post('food'),
            'clth' => $this->input->post('clth'),
            'wate' => $this->input->post('wate'),
            'elec' => $this->input->post('elec'),
            'medc' => $this->input->post('medc'),
            'educ' => $this->input->post('educ'),
            'tran' => $this->input->post('tran'),
            'otex' => $this->input->post('otex'),
            'lnin' => $this->input->post('lnin'),
            'otln' => $this->input->post('otln'),
            'inis' => $this->input->post('inis'),
            // 'fslm' => $this->input->post('fslm'),
            'ttib' => $this->input->post('ttib'),
            'ttid' => $this->input->post('ttid'),
            'ttis' => $this->input->post('ttis'),
            'ttex' => $this->input->post('ttex'),
            'ncih' => $this->input->post('ncih'),
            //'img_nic' => $this->input->post('adv_smst'),

            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),

            'img_nic' => $img_nic,
            'img_gscr' => $img_gscr,
            'img_bslc' => $img_bslc,
            'img_othr' => $img_othr,
        );
        $result2 = $this->Generic_model->insertData('cus_mas_advnc', $data_arr2);

        $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Advance Customer (' . $cuno_n . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    function vewAdvnCustmer()
    {
        //$funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
        //$this->Log_model->userFuncLog($funcPerm[0]->pgid, 'View Advance Customer id(' . $this->input->post('auid') . ')');

        $this->db->select("cus_mas.*,cus_mas_advnc.*,grup_mas.grno AS grnm");
        $this->db->from("cus_mas");
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('cus_mas_advnc', 'cus_mas_advnc.cuid = cus_mas.cuid');
        // $this->db->join('cen_days', 'cen_days.dyid = cen_mas.cody ');

        $this->db->where('cus_mas.cuid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function advnCust_edt()
    {
        $func = $this->input->post('func_advn');


        // user pic  -  advPicEdt   avt33
        // user nic  -  advNicEdt   avt44
        // GSC       -  advGscEdt   avt55
        // bus loc   -  advBulEdt   avt66
        // use other -  advOthEdt   avt77

        if (!empty($_FILES['advPicEdt']['name'])) {
            // previous image delete
            $path = "uploads/cust_profile/";
            $imagename = $this->input->post('avt33');
            //unlink($path . $imagename);
            // Default customer image not delete
            if ($imagename != 'default-image.jpg') {
                unlink($path . $imagename);
            }

            $config['upload_path'] = 'uploads/cust_profile/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["advPicEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advPicEdt')) {
                $uploadData = $this->upload->data();
                $pro = $uploadData['file_name'];
            } else {
                $pro = '';
            }
        } else {
            $pro = $this->input->post('avt33');
        }

        if (!empty($_FILES['advNicEdt']['name'])) {
            // previous image delete
            $path = "uploads/user_document/";
            $imagename = $this->input->post('avt44');
            //unlink($path . $imagename);
            // Default customer image not delete
            if ($imagename != 'document-default.jpg') {
                unlink($path . $imagename);
            }

            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["advNicEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advNicEdt')) {
                $uploadData = $this->upload->data();
                $nic = $uploadData['file_name'];
            } else {
                $nic = '';
            }
        } else {
            $nic = $this->input->post('avt44');
        }

        if (!empty($_FILES['advGscEdt']['name'])) {
            // previous image delete
            $path = "uploads/user_document/";
            $imagename = $this->input->post('avt55');
            //unlink($path . $imagename);
            // Default customer image not delete
            if ($imagename != 'document-default.jpg') {
                unlink($path . $imagename);
            }

            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["advGscEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advGscEdt')) {
                $uploadData = $this->upload->data();
                $gsc = $uploadData['file_name'];
            } else {
                $gsc = '';
            }
        } else {
            $gsc = $this->input->post('avt55');
        }

        if (!empty($_FILES['advBulEdt']['name'])) {
            // previous image delete
            $path = "uploads/user_document/";
            $imagename = $this->input->post('avt66');
            //unlink($path . $imagename);
            // Default customer image not delete
            if ($imagename != 'document-default.jpg') {
                unlink($path . $imagename);
            }

            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            // $config['max_width'] = '1024';
            // $config['max_height'] = '768';
            $config['file_name'] = $_FILES["advBulEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advBulEdt')) {
                $uploadData = $this->upload->data();
                $busl = $uploadData['file_name'];
            } else {
                $busl = '';
            }
        } else {
            $busl = $this->input->post('avt66');
        }

        if (!empty($_FILES['advOthEdt']['name'])) {
            // previous image delete
            $path = "uploads/user_document/";
            $imagename = $this->input->post('avt77');
            //unlink($path . $imagename);
            // Default customer image not delete
            if ($imagename != 'document-default.jpg') {
                unlink($path . $imagename);
            }

            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["advOthEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advOthEdt')) {
                $uploadData = $this->upload->data();
                $otr = $uploadData['file_name'];
            } else {
                $otr = '';
            }
        } else {
            $otr = $this->input->post('avt77');
        }


        if ($func == '1') {                  // update
            $stst = $this->input->post('stat_advn');
            $this->db->trans_begin(); // SQL TRANSACTION START

            if ($stst == 1) { // pending
                $data_arr1 = array(
                    'brco' => $this->input->post('adv_brch_edt'),
                    'exec' => $this->input->post('adv_exc_edt'),
                    'ccnt' => $this->input->post('adv_cen_edt'),
                    'grno' => $this->input->post('adv_grup_edt'),
                    'gplg' => $this->input->post('adv_gplg_edt'),
                    'gplt' => $this->input->post('adv_gplt_edt'),
                    'funm' => strtoupper($this->input->post('adv_funm_edt')),
                    'init' => strtoupper($this->input->post('adv_init_edt')),
                    'hoad' => strtoupper($this->input->post('adv_hoad_edt')),
                    'tele' => $this->input->post('adv_tele_edt'),
                    'mobi' => $this->input->post('adv_mobi_edt'),
                    'anic' => strtoupper($this->input->post('adv_nic_edt')),
                    'dobi' => $this->input->post('adv_dobi_edt'),
                    'gend' => $this->input->post('adv_gend_edt'),
                    'titl' => $this->input->post('adv_titl_edt'),
                    'edun' => $this->input->post('adv_edun_edt'),
                    'cist' => $this->input->post('adv_cist_edt'),
                    'gsaw' => $this->input->post('adv_gsaw_edt'),
                    'uimg' => $pro,
                    'smst' => $this->input->post('adv_smst_edt'),
                    'emil' => $this->input->post('adv_emil_edt'),

                    //'cutp' => 2,
                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),

                    'bkdt' => $this->input->post('adv_bkdt_edt'),
                    'bkid' => $this->input->post('adv_bknm_edt'),
                    'bkbr' => ucwords(strtolower($this->input->post('adv_bkbr_edt'))),
                    'acno' => $this->input->post('adv_acno_edt'),
                );

            } else if ($stst == 3 || $stst == 4) { // approval
                $data_arr1 = array(
                    'gplg' => $this->input->post('adv_gplg_edt'),
                    'gplt' => $this->input->post('adv_gplt_edt'),
                    'funm' => strtoupper($this->input->post('adv_funm_edt')),
                    'init' => strtoupper($this->input->post('adv_init_edt')),
                    'hoad' => strtoupper($this->input->post('adv_hoad_edt')),
                    'tele' => $this->input->post('adv_tele_edt'),
                    'mobi' => $this->input->post('adv_mobi_edt'),
                    //'anic' => strtoupper($this->input->post('adv_nic_edt')),
                    'dobi' => $this->input->post('adv_dobi_edt'),
                    'gend' => $this->input->post('adv_gend_edt'),
                    'titl' => $this->input->post('adv_titl_edt'),
                    'edun' => $this->input->post('adv_edun_edt'),
                    'cist' => $this->input->post('adv_cist_edt'),
                    'gsaw' => $this->input->post('adv_gsaw_edt'),
                    'uimg' => $pro,
                    'smst' => $this->input->post('adv_smst_edt'),
                    'emil' => $this->input->post('adv_emil_edt'),

                    //'cutp' => 2,
                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),

                    //'bkdt' => $this->input->post('adv_bkdt_edt'),
                    //'bkid' => $this->input->post('adv_bknm_edt'),
                    //'bkbr' => ucwords(strtolower($this->input->post('adv_bkbr_edt'))),
                    //'acno' => $this->input->post('adv_acno_edt'),
                );
            }

            $data_arr2 = array(
                'sunm' => $this->input->post('sunm_edt'),
                'snic' => strtoupper($this->input->post('spnic_edt')),
                'fmem' => $this->input->post('fmem_edt'),
                'mopr' => $this->input->post('mopr_edt'),
                'apre' => $this->input->post('apre_edt'),
                'occu' => $this->input->post('occu_edt'),
                'impr' => $this->input->post('impr_edt'),

                'bsad' => $this->input->post('bsad_edt'),
                'buss' => $this->input->post('buss_edt'),
                'rgno' => $this->input->post('rgno_edt'),
                'dura' => $this->input->post('dura_edt'),
                'bupl' => $this->input->post('bupl_edt'),
                'butp' => $this->input->post('butp_edt'),
                'beml' => $this->input->post('beml_edt'),
                'bsin' => $this->input->post('bsin_edt'),
                'obin' => $this->input->post('obin_edt'),
                'diin' => $this->input->post('diin_edt'),
                'odin' => $this->input->post('odin_edt'),

                'spin' => $this->input->post('spin_edt'),
                'osin' => $this->input->post('osin_edt'),
                'food' => $this->input->post('food_edt'),
                'clth' => $this->input->post('clth_edt'),
                'wate' => $this->input->post('wate_edt'),
                'elec' => $this->input->post('elec_edt'),
                'medc' => $this->input->post('medc_edt'),
                'educ' => $this->input->post('educ_edt'),
                'tran' => $this->input->post('tran_edt'),
                'otex' => $this->input->post('otex_edt'),

                'lnin' => $this->input->post('lnin_edt'),
                'otln' => $this->input->post('otln_edt'),
                'inis' => $this->input->post('inis_edt'),
                'ttib' => $this->input->post('ttib_edt'),
                'ttid' => $this->input->post('ttid_edt'),
                'ttis' => $this->input->post('ttis_edt'),
                'ttex' => $this->input->post('ttex_edt'),
                'ncih' => $this->input->post('ncih_edt'),

                'img_nic' => $nic,
                'img_gscr' => $busl,
                'img_bslc' => $gsc,
                'img_othr' => $otr,
            );

            $where_arr = array(
                'cuid' => $this->input->post('auid_advn')
            );

            $result1 = $this->Generic_model->updateData('cus_mas', $data_arr1, $where_arr);
            $result2 = $this->Generic_model->updateData('cus_mas_advnc', $data_arr2, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Advance Customer Edit id(' . $this->input->post('auid_advn') . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }


        } elseif ($func == '2') {            // approvel
            $this->db->trans_begin(); // SQL TRANSACTION START

            $brco = $this->input->post('adv_brch_edt');
            $ccnt = $this->input->post('adv_cen_edt');

            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
            $brcd = $brdt[0]->brcd;

            $cndt = $this->Generic_model->getData('cen_mas', array('caid', 'cnno', 'stat'), array('caid' => $ccnt, 'stat' => 1));
            $cn = $cndt[0]->cnno;

            $cc = strlen($cn);

            if ($cc == 1) {
                $cncd = '000' . $cn;
            } else if ($cc == 2) {
                $cncd = '00' . $cn;
            } else if ($cc == 3) {
                $cncd = '0' . $cn;
            } else if ($cc == 4) {
                $cncd = '' . $cn;
            }

            // Genarate customer auto number
            $this->db->select("cuno,brid,ccnt");
            $this->db->from("cus_mas_base");
            $this->db->where('cus_mas_base.brid ', $brco);
            $this->db->where('cus_mas_base.ccnt ', $ccnt);
            //  $this->db->where('cus_mas.stat ', 3); // approval customer
            $this->db->order_by('cus_mas_base.auid', 'desc');

            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            if (count($data) == '0') {
                $cuno_n = $brcd . '/' . $cncd . '/00001';

            } else {
                $cuno = $data[0]->cuno;
                $re = (explode("/", $cuno));

                $aa = intval($re[2]) + 1;
                $cc = strlen($aa);

                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '0' . $aa;
                }
                // $cuno_n = $re[0] . '/' . $re[1] . '/' . $xx;
                $cuno_n = $brcd . '/' . $cncd . '/' . $xx;
            }

            $data_arr1 = array(
                'brco' => $brco,
                'exec' => $this->input->post('adv_exc_edt'),
                'ccnt' => $ccnt,
                'grno' => $this->input->post('adv_grup_edt'),
                'cuno' => $cuno_n, // cust no
                'gplg' => $this->input->post('adv_gplg_edt'),
                'gplt' => $this->input->post('adv_gplt_edt'),
                'funm' => strtoupper($this->input->post('adv_funm_edt')),
                'init' => strtoupper($this->input->post('adv_init_edt')),
                'hoad' => strtoupper($this->input->post('adv_hoad_edt')),
                'tele' => $this->input->post('adv_tele_edt'),
                'mobi' => $this->input->post('adv_mobi_edt'),
                'anic' => strtoupper($this->input->post('adv_nic_edt')),
                'dobi' => $this->input->post('adv_dobi_edt'),
                'gend' => $this->input->post('adv_gend_edt'),
                'titl' => $this->input->post('adv_titl_edt'),
                'edun' => $this->input->post('adv_edun_edt'),
                'cist' => $this->input->post('adv_cist_edt'),
                'gsaw' => $this->input->post('adv_gsaw_edt'),
                'uimg' => $pro,
                'smst' => $this->input->post('adv_smst_edt'),
                'emil' => $this->input->post('adv_emil_edt'),

                'stat' => 3,
                //'cutp' => 2,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );

            $data_arr2 = array(
                'sunm' => $this->input->post('sunm_edt'),
                'snic' => strtoupper($this->input->post('spnic_edt')),
                'fmem' => $this->input->post('fmem_edt'),
                'mopr' => $this->input->post('mopr_edt'),
                'apre' => $this->input->post('apre_edt'),
                'occu' => $this->input->post('occu_edt'),
                'impr' => $this->input->post('impr_edt'),

                'bsad' => $this->input->post('bsad_edt'),
                'buss' => $this->input->post('buss_edt'),
                'rgno' => $this->input->post('rgno_edt'),
                'dura' => $this->input->post('dura_edt'),
                'bupl' => $this->input->post('bupl_edt'),
                'butp' => $this->input->post('butp_edt'),
                'beml' => $this->input->post('beml_edt'),
                'bsin' => $this->input->post('bsin_edt'),
                'obin' => $this->input->post('obin_edt'),
                'diin' => $this->input->post('diin_edt'),
                'odin' => $this->input->post('odin_edt'),

                'spin' => $this->input->post('spin_edt'),
                'osin' => $this->input->post('osin_edt'),
                'food' => $this->input->post('food_edt'),
                'clth' => $this->input->post('clth_edt'),
                'wate' => $this->input->post('wate_edt'),
                'elec' => $this->input->post('elec_edt'),
                'medc' => $this->input->post('medc_edt'),
                'educ' => $this->input->post('educ_edt'),
                'tran' => $this->input->post('tran_edt'),
                'otex' => $this->input->post('otex_edt'),

                'lnin' => $this->input->post('lnin_edt'),
                'otln' => $this->input->post('otln_edt'),
                'inis' => $this->input->post('inis_edt'),
                'ttib' => $this->input->post('ttib_edt'),
                'ttid' => $this->input->post('ttid_edt'),
                'ttis' => $this->input->post('ttis_edt'),
                'ttex' => $this->input->post('ttex_edt'),
                'ncih' => $this->input->post('ncih_edt'),

                'img_nic' => $nic,
                'img_gscr' => $busl,
                'img_bslc' => $gsc,
                'img_othr' => $otr,
            );

            $where_arr = array(
                'cuid' => $this->input->post('auid_advn')
            );

            $result1 = $this->Generic_model->updateData('cus_mas', $data_arr1, $where_arr);
            $result2 = $this->Generic_model->updateData('cus_mas_advnc', $data_arr2, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('cust_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Advance Customer Approval id(' . $this->input->post('auid_advn') . ')');

            // ***  Customer Branch details insert ****
            $data_arr33 = array(
                'cuid' => $this->input->post('auid_advn'),
                'cuno' => $cuno_n, // cust no
                'brid' => $brco,
                'exec' => $this->input->post('adv_exc_edt'),
                'ccnt' => $ccnt,
                'grno' => $this->input->post('adv_grup_edt'),
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $this->Generic_model->insertData('cus_mas_base', $data_arr33);

            // *** end Customer Branch details ****

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                $this->db->select("cus_mas.cuno");
                $this->db->from("cus_mas");
                $this->db->where('cus_mas.cuid ', $this->input->post('auid_advn'));
                $qu1 = $this->db->get();
                $aa = $qu1->result();
                $aa = $aa[0]->cuno;
                echo json_encode($aa);
            }

            /*if (count($result1) > 0 && count($result2) > 0) {
            } else {
                echo json_encode(false);
            }*/
        }
    }
// end Customer
//
// loan management
    function loan()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $data['policy'] = $this->Generic_model->getData('sys_policy', array('ponm,pov1,pov2,post'), array('popg' => 'loan', 'stat' => 1));
        $data['policyinfo'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2', 'pov3'), array('popg' => 'product', 'stat' => 1));

        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['stainfo'] = $this->Generic_model->getData('loan_stat', array('stid,stnm'), array('isac' => 1), '');
        $data['prductinfo'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 1), '');
        $data['dynamicprd'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 2), '');

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('loan');
        $this->load->view('modules/user/loan_managemnt', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // product base
    function getLoanProduct()
    {
        $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'loan', 'stat' => 1, 'poid' => 16));
        $lnct = $this->input->post('lnct');

        $this->db->select("auid,brid,prtp,nofr,lamt,rent,stat ");
        $this->db->from("product");
        $this->db->where('prtp ', $this->input->post('prdtp'));
        $this->db->where('brid ', $this->input->post('brnc'));
        if ($policy[0]->post == 1) {
            $lnct = $lnct + 1;
            $this->db->where("lcnt <= $lnct");  // LOAN INDEX CHECK & PRODUCT LOAD (PRD.INDX <= CURNT INDX + 1)
        }
        $this->db->where('stat ', 1);
        $this->db->group_by('lamt');
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function getLoanPeriod()
    {
        $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'loan', 'stat' => 1, 'poid' => 16));
        $lnct = $this->input->post('lnct');

        $this->db->select("auid,prtp,nofr,lamt,rent,stat, prcd ");
        $this->db->from("product");
        $this->db->where('prtp ', $this->input->post('pdtp'));
        $this->db->where('lamt ', $this->input->post('fcamt'));
        $this->db->where('brid ', $this->input->post('brnc'));
        if ($policy[0]->post == 1) {
            $lnct = $lnct + 1;
            $this->db->where("lcnt <= $lnct");  // LOAN INDEX CHECK & PRODUCT LOAD
        }
        $this->db->where('stat ', 1);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function getLoanInstal()
    {
        $this->db->select("rent,docc,insc,lamt,inta,infm,cldw ");
        $this->db->from("product");
        $this->db->where('auid ', $this->input->post('id'));
        $this->db->where('stat ', 1);
        $query = $this->db->get();
        $data['lndt'] = $query->result();

        $this->db->select("prid");
        $this->db->from("micr_crt");
        $this->db->where('apid ', $this->input->post('cuid'));
        $this->db->where('prid ', $this->input->post('id'));
        $this->db->where('stat IN(1,2,5)');
        $query = $this->db->get();
        $data['cudt'] = $query->result();

        echo json_encode($data);

    }

    // dynamic product
    function getDyType()
    {
        $this->db->select("auid,prtp,nofr,infm,cldw ");
        $this->db->from("product");
        $this->db->where('prtp ', $this->input->post('prtp'));
        $this->db->where('stat ', 1);
        $this->db->group_by('cldw');
        $query = $this->db->get();
        echo json_encode($query->result());

    }

    function getDynaPeriod()
    {
        $prtp = $this->input->post('prdtp');
        $this->db->select("auid,prtp,nofr,infm ");
        $this->db->from("product");
        $this->db->where('prtp ', $prtp);
        if ($prtp == 6 || $prtp == 9 || $prtp == 12) { // IF PRTP ( 6 - DYNAMIC DAILY | 9 INTEREST FREE DAILY | 12 DOWN PAYMENT DAILY )
            $this->db->where('cldw ', $this->input->post('daytp'));
        }
        $this->db->where('stat ', 1);
        $this->db->group_by('nofr');
        // $this->db->group_by('infm');
        $query = $this->db->get();
        $data['nofr'] = $query->result();

        $this->db->select("auid,prtp,inra ");
        $this->db->from("product");
        $this->db->where('prtp ', $this->input->post('prdtp'));
        $this->db->where('stat ', 1);
        $this->db->group_by('inra');
        $query = $this->db->get();
        $data['rate'] = $query->result();

        echo json_encode($data);
    }
    // end dynamic product

    // CUSTOMER DETAILS LOAD
    function getCustDetils()
    {
        $this->db->select("cus_mas.rgtp,cus_mas.cuid,cus_mas.cuno,cus_mas.init,cus_mas.brco,cus_mas.exec,cus_mas.ccnt,cus_mas.hoad,cus_mas.tele,cus_mas.mobi,cus_mas.anic,
        cus_mas.uimg,cus_sol.sode,cus_mas.stat, ( SELECT COUNT(*) AS pen FROM `micr_crt` WHERE stat = 1 AND apid = cuid) AS pen,
        (SELECT COUNT(*) AS pen FROM `micr_crt` WHERE stat IN(2,5) AND apid = cuid) AS act, 
        IFNULL((SELECT lcnt FROM micr_crt WHERE apid = `cus_mas`.`cuid` ORDER BY cvdt DESC LIMIT 1 ), 0) AS lcnt,
         cm.cmnt, cm.crdt, cm.usnm");

        $this->db->from("cus_mas");
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl ');
        //$this->db->join("(SELECT apid,lcnt FROM micr_crt ORDER BY cvdt DESC LIMIT 1 ) AS aa", 'aa.apid = cus_mas.cuid', 'left');
        // LOAN COMMENT
        $this->db->join("(SELECT cm.cmrf, cm.cmnt, cm.crdt, user_mas.usnm
         FROM comments AS cm
         JOIN user_mas ON user_mas.auid=cm.crby ORDER BY cmid DESC LIMIT 1) AS cm", 'cm.cmrf = cus_mas.cuid', 'left');

        $this->db->where('cus_mas.anic ', $this->input->post('id'));
        // $this->db->where('stat ', 3);

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // aplicant group other members details
    function getgrpMnbDtils()
    {
        $applic = $this->Generic_model->getData('cus_mas', array('cuid', 'brco', 'exec', 'ccnt', 'grno'), array('anic' => $this->input->post('apid')));

        $this->db->select("cus_mas.cuid,cus_mas.cuno,cus_mas.init,cus_mas.brco,cus_mas.exec,cus_mas.ccnt,cus_mas.hoad,cus_mas.tele,cus_mas.mobi,cus_mas.anic,
        cus_mas.uimg,cus_sol.sode,cus_mas.stat, ( SELECT COUNT(*) AS pen FROM `micr_crt` WHERE stat = 1 AND apid = cuid) AS pen,
        (SELECT COUNT(*) AS pen FROM `micr_crt` WHERE stat IN(2,5) AND apid = cuid) AS act ");
        $this->db->from("cus_mas");
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->where('cus_mas.brco ', $applic[0]->brco);
        $this->db->where('cus_mas.exec ', $applic[0]->exec);
        $this->db->where('cus_mas.ccnt ', $applic[0]->ccnt);
        $this->db->where('cus_mas.grno ', $applic[0]->grno);

        $this->db->where('cus_mas.stat IN(3,4) ');
        $this->db->where("cus_mas.cuid != ", $applic[0]->cuid);
        $this->db->order_by('act', 'desc');

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // CUSTOMER PERVIOS LOAN DETIALS LOAD
    function getPrvesloan()
    {
        $cuid = $this->input->post('cuid');

        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.cage,loan_stat.stnm");
        $this->db->from("micr_crt");
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat');
        $this->db->where('micr_crt.apid ', $cuid);
        $this->db->where("micr_crt.stat IN(3,5,7,10,12,18)");
        $this->db->order_by('stat', 'desc');
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function searchLoan()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('loan');

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
        $disabled = "disabled";


        $result = $this->User_model->get_loanDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->lnst;
            $auid = $row->lnid;

            // CHECK APPROVAL DATE > TODAY - 7 DAYS
            $apdt = $row->apdt;
            $cc = date('Y-m-d', strtotime('-7 days'));
            if ($apdt < $cc) {
                $dt = "disabled";
            } else {
                $dt = "";
            }
            // IF CHECK PRODUCT LOAN OR DYNAMIC LOAN
            if ($row->lntp == 1) {
                $lntp = "<span class='label label-success' title='Product Loan'>P</span>";
            } elseif ($row->lntp == 2) {
                $lntp = "<span class='label label-warning' title='Dynamic Loan'>D</span>";
            }
            // IF CHECK TOPUP LOAN OR
            if ($row->prva != 0) {
                $tpup = "<span class='label label-info' title='Topup Loan'>T</span>";
                $tpds = "disabled";
            } else {
                $tpup = "";
                $tpds = "";
            }

            if ($st == '1') {  // Pending
                $stat = "<span class='label label-warning'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  $tpds data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app $tpds data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $rej $tpds onclick='rejecLoan($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Approved
                $stat = "<span class='label label-success'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $dt $tpds onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '4') {  // Rejected
                $stat = "<span class='label label-danger'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLoan(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLoan(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $disabled onclick='rejecLoan();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '5') {  // Disbursed
                $stat = "<span class='label label-success' style='background-color: #66ff33'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $disabled  onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else {  // Others
                $stat = "<span class='label label-default'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $disabled  onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $lntp . ' ' . $row->acno . ' ' . $tpup;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = $row->lnpr . ' ' . $row->pymd;

            $sub_arr[] = $stat;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_loan(),
            "recordsFiltered" => $this->User_model->count_filtered_loan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function addLoan()
    {
        $lntp = $this->input->post('lntp');     // loan type (1 - product loan / )
        $grtp = $this->input->post('grnTyp');   // granter type (0 - Individual granter / 1 - Group granter )
        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($lntp == 1) { // product loan
            $prid = $this->input->post('dura');
            $prd_dtls = $this->Generic_model->getData('product', array('lamt', 'inta', 'rent', 'nofr', 'inra', 'prmd', 'clrt', 'pncd', 'cldw', 'infm'), array('auid' => $prid));

            $lntp = 1;
            $prdtp = $this->input->post('prdTyp');
            $loam = $this->input->post('fcamt');
            $inta = $prd_dtls[0]->inta;
            $inra = $prd_dtls[0]->inra;
            $lnpr = $prd_dtls[0]->nofr;
            $noin = $prd_dtls[0]->infm;
            $inam = $prd_dtls[0]->rent;
            $prmd = $prd_dtls[0]->prmd;
            $clrt = $prd_dtls[0]->clrt;
            $pncd = $prd_dtls[0]->pncd;
            $lcat = $prd_dtls[0]->cldw;
            //$lcat = 0;
        } else { // dynamic loan
            $lntp = 2;
            $prdtp = $this->input->post('prdtpDyn');
            $loam = $this->input->post('dyn_fcamt');
            $inta = $this->input->post('dyn_ttlint');
            $inra = $this->input->post('dyn_inrt');
            $lnpr = $this->input->post('dyn_dura');
            $lcat = $this->input->post('dytp');
            $inam = $this->input->post('lnprim');

            /* $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'prmd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $noin, 'cldw' => $lcat, 'stat' => 1));
             $prid = $prdid[0]->auid;
             $lnpr = $prdid[0]->infm;*/

            if ($prdtp == 6) {
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'prmd', 'clrt', 'pncd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'cldw' => $lcat, 'stat' => 1));
                $prmd = $prdid[0]->prmd;
                $clrt = $prdid[0]->clrt;
                $pncd = $prdid[0]->pncd;

                $noin = $prdid[0]->infm;
            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'prmd', 'clrt', 'pncd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'stat' => 1));
                $prmd = $prdid[0]->prmd;
                $clrt = $prdid[0]->clrt;
                $pncd = $prdid[0]->pncd;

                $noin = $this->input->post('dyn_dura');
            }
            $prid = $prdid[0]->auid;
        }

        if ($grtp == 0) { // Individual granter
            $fsgi = $this->input->post('fsgi');
            $segi = $this->input->post('segi');
            $thgi = $this->input->post('thgi');
            $fogi = $this->input->post('fogi');
            $figi = $this->input->post('figi');

            $sxgi = 0;
            $svgi = 0;
            $eggi = 0;
            $nigi = 0;
            $tngi = 0;

        } else {          // Group granter

            $len = $this->input->post('grntLen');
            $i = 0;
            for ($a = 0; $a < $len; $a++) {
                $grnid = $this->input->post("addm[" . $a . "]");      // granter id
                if ($grnid != '') {
                    $result[$i] = array(0 => $grnid);
                    $i++;
                    // array('brch_id' => '0');
                }
            }
            $xx = sizeof($result);
            if ($xx < 10) {
                for ($c = $xx; $c < 10; $c++) {
                    $result[$c] = array(0 => 0);
                }
            }

            // var_dump($result[0][0]);
            // var_dump($result[1][0]);
            // var_dump($result[2][0]);

            $fsgi = $result[0][0];
            $segi = $result[1][0];
            $thgi = $result[2][0];
            $fogi = $result[3][0];
            $figi = $result[4][0];
            $sxgi = $result[5][0];
            $svgi = $result[6][0];
            $eggi = $result[7][0];
            $nigi = $result[8][0];
            $tngi = $result[9][0];
        }

        $brco = $this->input->post('coll_brn');
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $this->db->select("brco,acno");
        $this->db->from("micr_crt");
        $this->db->where('micr_crt.brco ', $brco);
        $this->db->where('micr_crt.stat IN(1,4)');
        $this->db->order_by('micr_crt.lnid', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $acno = $brcd . '/TMP/0001';
        } else {
            $acno = $data[0]->acno;
            $re = (explode("/", $acno));
            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);

            // next loan no
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }
            $acno = $brcd . '/' . 'TMP' . '/' . $xx;
        }
        $data_arr = array(  // $name_nic = ucwords($name_nic);      //ucwords($foo);
            'brco' => $this->input->post('coll_brn'),
            'clct' => $this->input->post('coll_ofc'),
            'ccnt' => $this->input->post('coll_cen'),
            'acno' => $acno,
            'lntp' => $lntp,
            'grtp' => $grtp,
            'prdtp' => $prdtp,
            'prid' => $prid,

            'apid' => $this->input->post('appid'),

            'fsgi' => $fsgi,
            'segi' => $segi,
            'thgi' => $thgi,
            'fogi' => $fogi,
            'figi' => $figi,
            'sxgi' => $sxgi,
            'svgi' => $svgi,
            'eggi' => $eggi,
            'nigi' => $nigi,
            'tngi' => $tngi,

            'loam' => $loam,
            'inta' => $inta,
            'inra' => $inra,
            'lnpr' => $lnpr,
            'noin' => $noin,
            'lcat' => $lcat,
            'inam' => $inam,

            'docg' => $this->input->post('docu'),
            'incg' => $this->input->post('insu'),
            'chmd' => $this->input->post('crgmd'), // charge mode

            'indt' => $this->input->post('indt'),
            'acdt' => $this->input->post('dsdt'),
            'sydt' => date('Y-m-d'),
            //'madt' => $this->input->post('smst'),
            //'nxdd' => $this->input->post('smst'),

            'pnco' => $pncd,
            'prtp' => $prmd,
            'pnra' => $clrt,
            'stat' => 1, // pending Loan
            //'rmks' => $this->input->post('remk'),
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('micr_crt', $data_arr);

        // IF LOAN COMMENT ADD
        $cmt = $this->input->post('remk');
        if (!empty($cmt)) {
            $query = $this->Generic_model->getData('micr_crt', array('lnid'), array('acno' => $acno));
            $lnid = $query[0]->lnid;
            $data_arr = array(
                'cmtp' => 2,
                'cmmd' => 1,
                'cmrf' => $lnid,
                'cmnt' => $cmt,
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('comments', $data_arr);
        }
        // END LOAN COMMENT

        $funcPerm = $this->Generic_model->getFuncPermision('loan');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add new loan ' . $acno);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function vewLoan()
    {
        $this->db->select("micr_crt.*,cus_mas.cuno,cus_mas.init,cus_mas.anic,brch_mas.brnm ,cen_mas.cnnm,user_mas.fnme ,user_mas.lnme ,
        prdt_typ.prna,prdt_typ.pymd,loan_stat.stnm ,IF(micr_crt.chmd = 1,'Customer Payment','Debit From Loan') AS chrmd , loan_type.lntp AS lntpnm ");
        $this->db->from("micr_crt");

        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');

        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat ');
        $this->db->join('loan_type', 'loan_type.auid = micr_crt.lntp ');

        $this->db->where('micr_crt.lnid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function vewLoanEdt()
    {
        $this->db->select("micr_crt.*, brch_mas.brnm ,cen_mas.cnnm,user_mas.fnme ,user_mas.lnme , prdt_typ.prtp,loan_stat.stnm  ,
        a.acuno,a.ainit,a.ahoad,a.amobi,a.aanic,a.auimg ,
        b.bcuno,b.binit,b.bhoad,b.bmobi,b.banic,b.buimg ,
        c.ccuno,c.cinit,c.choad,c.cmobi,c.canic,c.cuimg ,
        d.dcuno,d.dinit,d.dhoad,d.dmobi,d.danic,d.duimg , 
              cm.cmnt, cm.crdt, cm.usnm, loan_type.lntp AS lntpnm 
        ");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join("(SELECT a.cuid,a.cuno AS acuno,a.init AS ainit,a.hoad AS ahoad,a.mobi AS amobi,a.anic AS aanic,a.uimg AS auimg
         FROM cus_mas AS a) AS a", 'a.cuid = micr_crt.apid ', 'left');
        // 1 granter
        $this->db->join("(SELECT b.cuid,b.cuno AS bcuno,b.init AS binit,b.hoad AS bhoad,b.mobi AS bmobi,b.anic AS banic,b.uimg AS buimg
         FROM cus_mas AS b) AS b", 'b.cuid = micr_crt.fsgi', 'left');
        // 2 granter
        $this->db->join("(SELECT c.cuid,c.cuno AS ccuno,c.init AS cinit,c.hoad AS choad,c.mobi AS cmobi,c.anic AS canic,c.uimg AS cuimg
         FROM cus_mas AS c) AS c", 'c.cuid = micr_crt.segi', 'left');
        // 3 granter
        $this->db->join("(SELECT d.cuid,d.cuno AS dcuno,d.init AS dinit,d.hoad AS dhoad,d.mobi AS dmobi,d.anic AS danic,d.uimg AS duimg
         FROM cus_mas AS d) AS d", 'd.cuid = micr_crt.thgi', 'left');

        // LOAN COMMENT
        $this->db->join("(SELECT cm.cmrf, cm.cmnt, cm.crdt, user_mas.usnm
         FROM comments AS cm
         JOIN user_mas ON user_mas.auid=cm.crby ORDER BY cmid DESC LIMIT 1) AS cm", 'cm.cmrf = micr_crt.lnid', 'left');

        //$this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.cuid ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat ');
        $this->db->join('loan_type', 'loan_type.auid = micr_crt.lntp ');

        $this->db->where('micr_crt.lnid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function loan_edt()
    {
        $func = $this->input->post('func');     // if update=1 or approval=2
        $lntp = $this->input->post('lontype');  // if 1 product loan 2 dynamic loan
        $auid = $this->input->post('lnauid');   // loan auto id

        if ($lntp == 1) { // product loan
            $prid = $this->input->post('duraEdt');
            $prd_dtls = $this->Generic_model->getData('product', array('lamt', 'inta', 'rent', 'nofr', 'inra', 'prmd', 'pncd'), array('auid' => $prid));

            $prdtp = $this->input->post('prdTypEdt');
            $loam = $this->input->post('fcamtEdt');
            $inta = $prd_dtls[0]->inta;
            $inra = $prd_dtls[0]->inra;
            $lnpr = $prd_dtls[0]->nofr;
            $noin = $prd_dtls[0]->nofr;
            $inam = $prd_dtls[0]->rent;
            $lcat = 0;
            $prmd = $prd_dtls[0]->prmd;
            $pncd = $prd_dtls[0]->pncd;

        } else { // dynamic loan
            $prdtp = $this->input->post('prdtpDynEdt');
            $inra = $this->input->post('dyn_inrtEdt');
            $lnpr = $this->input->post('dyn_duraEdt');
            $loam = $this->input->post('dyn_fcamtEdt');
            $inta = $this->input->post('dyn_ttlintEdt');

            $lcat = $this->input->post('dytpEdt');
            $inam = $this->input->post('lnprimEdt');

            $prmd = 1;

            if ($prdtp == 6) { // DYNAMIC DAILY
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'prmd', 'pncd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'cldw' => $lcat, 'stat' => 1));
                $prid = $prdid[0]->auid;
                $noin = $prdid[0]->infm;
                $pncd = $prdid[0]->pncd;

            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'pncd'),
                    array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'stat' => 1));
                $prid = $prdid[0]->auid;
                $pncd = $prdid[0]->pncd;

                $noin = $this->input->post('dyn_duraEdt');
                $inam = $this->input->post('lnprimEdt');
            }
        }

//MATURITY DATE AND NEXT RENTEL DATE
        /* http://snipplr.com/view/10958/ */

        $indt = $this->input->post('indtEdt');
        $date = date("Y-m-d");
        $nxdd = date("Y-m-d");

        if ($prdtp == 3 || $prdtp == 6) {         // DL

            $holidayDates = $this->Generic_model->getData('sys_holdys', array('date'), array('stat' => 1, 'hdtp' => 1));
            $holidayDates = array_column($holidayDates, 'date');
            $count5WD = 0;
            // $temp = strtotime("2018-04-18 00:00:00"); //example as today is 2016-03-25
            /* Example link  --> https://stackoverflow.com/questions/36196606/php-add-5-working-days-to-current-date-excluding-weekends-sat-sun-and-excludin  */
            $temp = strtotime(date("Y-m-d"));

            while ($count5WD < $lnpr) {
                $next1WD = strtotime('+1 weekday', $temp);
                $next1WDDate = date('Y-m-d', $next1WD);
                if (!in_array($next1WDDate, $holidayDates)) {
                    $count5WD++;
                }
                $temp = $next1WD;
            }
            $next5WD = date("Y-m-d", $temp);
            $madt = $next5WD;

            $count5WD2 = 0;
            $temp2 = strtotime(date("Y-m-d"));
            while ($count5WD2 < 1) {
                $next1WD2 = strtotime('+1 weekday', $temp2);
                $next1WDDate2 = date('Y-m-d', $next1WD2);
                if (!in_array($next1WDDate2, $holidayDates)) {
                    $count5WD2++;
                }
                $temp2 = $next1WD2;
            }
            $next5WD2 = date("Y-m-d", $temp2);
            $nxdd_n = $next5WD2;
            // var_dump($madt . '***'. $nxdd);
            // die();

        } else if ($prdtp == 4 || $prdtp == 7) {   //WK
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $lnpr . "week");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 week");
            $nxdd_n = date("Y-m-d", $nxdd);

        } else if ($prdtp == 5 || $prdtp == 8) {   //ML
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $lnpr . "month");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 month");
            $nxdd_n = date("Y-m-d", $nxdd);
        }
        //echo $madt . ' ** ' .  $nxdd_n;
// END MATURITY DATE

        // IF DUEL APPROVAL CHECK 
        $brco = $this->input->post('coll_brnEdt');
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat', 'duap', 'apmt'), array('brid' => $brco, 'stat' => 1));

        $duap = $brdt[0]->duap;
        $apmt = $brdt[0]->apmt;
        if ($func == 2 && $duap == 1 && $loam > $apmt) {
            $func = 3;
        } else {
            $func = $func;
        }

        if ($func == '1') {                  // update Loan
            $this->db->trans_begin(); // SQL TRANSACTION START

            $data_ar1 = array(
                'clct' => $this->input->post('coll_ofcEdt'),
                'ccnt' => $this->input->post('coll_cenEdt'),
                'prdtp' => $prdtp,
                'prid' => $prid,
                'apid' => $this->input->post('appidEdt'),
                'fsgi' => $this->input->post('fsgiEdt'),
                'segi' => $this->input->post('segiEdt'),
                'thgi' => $this->input->post('thgiEdt'),
                'fogi' => $this->input->post('fogiEdt'),
                'figi' => $this->input->post('figiEdt'),
                'loam' => $loam,
                'inta' => $inta,
                'inra' => $inra,
                'lnpr' => $lnpr,
                'noin' => $noin,
                'lcat' => $lcat,
                'inam' => $inam,
                'pnco' => $pncd,
                'docg' => $this->input->post('docuEdt'),
                'incg' => $this->input->post('insuEdt'),
                'chmd' => $this->input->post('crgmdEdt'), // charge mode
                'indt' => $this->input->post('indtEdt'),
                'acdt' => $this->input->post('dsdtEdt'),
                //'rmks' => $this->input->post('remkEdt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'lnid' => $auid
            );
            $result22 = $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);

            // IF NEW LOAN COMMENT ADD
            $cmt = $this->input->post('remkNew');
            if (!empty($cmt)) {
                $data_arr = array(
                    'cmtp' => 2,
                    'cmmd' => 1,
                    'cmrf' => $auid,
                    'cmnt' => $cmt,
                    'stat' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('comments', $data_arr);
            }
            // END LOAN COMMENT

            $funcPerm = $this->Generic_model->getFuncPermision('loan');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan update lnid(' . $auid . ')');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }


        } elseif ($func == '2') {            // approval loan

            $this->db->trans_begin(); // SQL TRANSACTION START
            $chk = 0;

            // GET BRANCH CODE GP/NT
            $brco = $this->input->post('coll_brnEdt');
            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat', 'duap', 'apmt'), array('brid' => $brco, 'stat' => 1));
            $brcd = $brdt[0]->brcd;

            $cent = $this->input->post('coll_cenEdt');
            $cnno = $this->Generic_model->getData('cen_mas', array('caid', 'cnno', 'stat'), array('caid' => $cent, 'stat' => 1));
            $cncd = $cnno[0]->cnno;

            // GET PRODUCT CODE
            $prt = $this->Generic_model->getData('product', array('prcd', 'pnst', 'clrt'), array('auid' => $prid, 'stat' => 1));
            $prcd = $prt[0]->prcd;
            $clrt = $prt[0]->clrt;

            // GET LAST LOAN NO
            $this->db->select("brco,acno,ccnt,prdtp,prid");
            $this->db->from("micr_crt");
            $this->db->where('micr_crt.brco ', $brco);
            $this->db->where('micr_crt.ccnt ', $cent);
            if ($lntp == 1) {       //1 product loan 2 dynamic loan
                $this->db->where('micr_crt.prid ', $prid);
            } else {
                $this->db->where('micr_crt.prdtp ', $prdtp);
            }
            //$this->db->where('micr_crt.stat IN(2,3,5) ');
            $this->db->where('micr_crt.stat NOT IN (1) ');
            $this->db->order_by('micr_crt.apdt', 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $data = $query->result();

            // GENARATE NEXT LOAN NO
            if (count($data) == '0') {
                $aa = '0001';
            } else {
                // IF VALIDE ACNO CHECK         *** CODE UPDATE 18/09/03 ***
                for ($a = 0; $a < 10; $a++) {
                    if (strlen($data[$a]->acno) == 19) {
                        $acno = $data[$a]->acno;
                        break;
                    } else {
                        $a = $a + 1;
                    }
                }
                $re = (explode("/", $acno));
                $aa = intval($re[4]) + 1;
            }

            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }

            // center no
            $mm = strlen($cncd);
            if ($mm == 1) {
                $gg = '000' . $cncd;
            } else if ($mm == 2) {
                $gg = '00' . $cncd;
            } else if ($mm == 3) {
                $gg = '0' . $cncd;
            } else if ($mm == 4) {
                $gg = '' . $cncd;
            }
            $yr = date('y');
            $acno = $brcd . '/' . $prcd . '/' . $yr . '/' . $gg . '/' . $xx;
            // END LOAN NO GENARATE

            // MICRO CART TB UPDATE
            $data_ar1 = array(
                'clct' => $this->input->post('coll_ofcEdt'),
                'ccnt' => $this->input->post('coll_cenEdt'),
                'acno' => $acno,
                'prdtp' => $prdtp,
                'prid' => $prid,
                'apid' => $this->input->post('appidEdt'),
                'fsgi' => $this->input->post('fsgiEdt'),
                'segi' => $this->input->post('segiEdt'),
                'thgi' => $this->input->post('thgiEdt'),
                'fogi' => $this->input->post('fogiEdt'),
                'figi' => $this->input->post('figiEdt'),
                'loam' => $loam,
                'inta' => $inta,
                'inra' => $inra,
                'lnpr' => $lnpr,
                'noin' => $noin,
                'lcat' => $lcat,
                'inam' => $inam,
                'docg' => $this->input->post('docuEdt'),
                'incg' => $this->input->post('insuEdt'),
                'chmd' => $this->input->post('crgmdEdt'), // charge mode
                'indt' => $this->input->post('indtEdt'),
                'acdt' => $this->input->post('dsdtEdt'),

                'pnco' => $pncd,
                'madt' => $madt,
                'nxdd' => $nxdd_n,
                'durg' => $noin,
                'boc' => $loam,
                'boi' => $inta,
                'nxpn' => 1,
                'prtp' => $prmd,
                'pnra' => $clrt, // PANALTY CAL RATE

                'stat' => 2,
                'pncs' => $prt[0]->pnst,
                'pcid' => 0,

                //'rmks' => $this->input->post('remkEdt'),

                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'lnid' => $auid
            );
            $result_micrt = $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);


            // IF NEW LOAN COMMENT ADD
            $cmt = $this->input->post('remkNew');
            if (!empty($cmt)) {

                $data_arr = array(
                    'cmtp' => 2,
                    'cmmd' => 1,
                    'cmrf' => $auid,
                    'cmnt' => $cmt,
                    'stat' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('comments', $data_arr);
            }
            // END LOAN COMMENT

            // LEDGER RECODE
            $cchmd = $this->input->post('crgmdEdt');
            $docg = $this->input->post('docuEdt');
            $incg = $this->input->post('insuEdt');

            // MICRO LEDGE @1
            $data_mclg1 = array(
                'acid' => $auid, // LOAN ID
                'acno' => $acno, // LOAN NO
                'ledt' => date('Y-m-d H:i:s'),
                'dsid' => 8,
                'dcrp' => 'ACNT DIFN',
                'avcp' => $loam,
                'avin' => $inta,

                'schg' => $docg + $incg,
                'duam' => $docg + $incg,
                'stat' => 1
            );
            $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

            // ACCOUNT LEDGE
            $data_aclg1 = array(
                'brno' => $brco, // BRANCH ID
                'lnid' => $auid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'ACNT DIFN',
                'trid' => 8,
                'rfna' => $acno,
                'dcrp' => 'ACNT DIFN',
                'acco' => '111',    // cross acc code
                'spcd' => '108',    // split acc code
                'acst' => '(108) Loan Stock',
                'dbam' => $loam,
                'cram' => 0,
                'stat' => 0
            );
            $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);

            $data_aclg2 = array(
                'brno' => $brco, // BRANCH ID
                'lnid' => $auid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'ACNT DIFN',
                'trid' => 8,
                'rfna' => $acno,
                'dcrp' => $acno,
                'acco' => '108',    // cross acc code
                'spcd' => '111',    // split acc code
                'acst' => '(111) Loan Controller',
                'dbam' => 0,
                'cram' => $loam,
                'stat' => 0
            );
            $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);

            if ($cchmd == 1) {        // CHARGE PAY BY CUSTOMER

                $chk = $chk + 4;

            } else if ($cchmd == 2) {  // CHARGE RECOVER FOR LOAN

                if ($docg > 0) {
                    $data_aclg23 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 111,    // cross acc code
                        'spcd' => 404,    // split acc code
                        'acst' => '(404) Document Charge',      //
                        'dbam' => 0,      // db amt
                        'cram' => $docg,  // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 404,    // cross acc code
                        'spcd' => 111,    // split acc code
                        'acst' => '(111) Loan Controller',
                        'dbam' => $docg,  // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result77 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                }

                if ($incg > 0) {
                    $data_aclg23 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 111,    // cross acc code
                        'spcd' => 403,    // split acc code
                        'acst' => '(403) Insurance Charge',      //
                        'dbam' => 0,      // db amt
                        'cram' => $incg,      // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 403,    // cross acc code
                        'spcd' => 111,    // split acc code
                        'acst' => '(111) Loan Controller',      //
                        'dbam' => $incg,      // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result88 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                }
            }
            // END ACCOUNT LEDGE

            // RECEIPTS PROCESS
            //$user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
            //$brn = $user[0]->brch;
            $brn = $brco;

            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn, 'stat' => 1));
            $brcd = $brdt[0]->brcd;

            $this->db->select("reno");
            $this->db->from("receipt");
            $this->db->where('receipt.brco ', $brn);
            $this->db->where('receipt.retp ', 1);
            $this->db->order_by('receipt.reid', 'desc');

            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            $yr = date('y');
            if (count($data) == '0') {
                $reno = $brcd . '/GR/' . $yr . '/00001';
            } else {
                $reno = $data[0]->reno;
                $re = (explode("/", $reno));
                $aa = intval($re[3]) + 1;

                $cc = strlen($aa);
                // next loan no
                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '' . $aa;
                }

                $reno = $brcd . '/GR/' . $yr . '/' . $xx;
            }

            // INSERT GENERAL RECEIPTS

            if ($cchmd == 1) {        // CHARGE PAY BY CUSTOMER
                $chk = $chk + 5;
                // customer payed process chang to edtPymnt() approval function
            } else if ($cchmd == 2) {  // CHARGE RECOVER FOR LOAN
                $data_arr = array(
                    'brco' => $brn,
                    'reno' => $reno,
                    'rfno' => $auid, // loan id
                    'retp' => 1,
                    'ramt' => $docg + $incg,
                    'pyac' => 111,
                    'pymd' => 9, // 8 -cash / 9 - inter account trnsfer
                    //'clid' => $this->input->post('appidEdt'), // cust id
                    'stat' => 1,
                    'remd' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('receipt', $data_arr);

                $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
                $reid = $recdt[0]->reid;

                if ($docg > 0) {

                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 404,
                        'rfdc' => 'Document Charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $docg
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                }

                if ($incg > 0) {
                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 403,
                        'rfdc' => 'Insurance Charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $incg
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                }

                // MICRO LEDGE @2
                if ($docg > 0) {
                    $data_mclg1 = array(
                        'acid' => $auid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 1,
                        'dcrp' => 'DOC CHG RECOV FOR ACC',
                        'schg' => -$docg,
                        'ream' => $docg,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

                }

                if ($incg > 0) {
                    $data_mclg1 = array(
                        'acid' => $auid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 1,
                        'dcrp' => 'INS CHG RECOV FOR ACC',
                        'schg' => -$incg,
                        'ream' => $incg,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

                }
                // END MICRO LEDGE @2
            }
            // END RECEIPTS

            $funcPerm = $this->Generic_model->getFuncPermision('loan');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan approval id(' . $auid . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit();
                echo json_encode('appr');   // APPROVAL
            }

        } elseif ($func == 3) {     // DUAL APPROVAL

            $this->db->trans_begin(); // SQL TRANSACTION START

            // LOAN TB UPDATE
            $data_ar1 = array(
                'clct' => $this->input->post('coll_ofcEdt'),
                'ccnt' => $this->input->post('coll_cenEdt'),
                'prdtp' => $prdtp,
                'prid' => $prid,
                'apid' => $this->input->post('appidEdt'),
                'fsgi' => $this->input->post('fsgiEdt'),
                'segi' => $this->input->post('segiEdt'),
                'thgi' => $this->input->post('thgiEdt'),
                'fogi' => $this->input->post('fogiEdt'),
                'figi' => $this->input->post('figiEdt'),
                'loam' => $loam,
                'inta' => $inta,
                'inra' => $inra,
                'lnpr' => $lnpr,
                'noin' => $noin,
                'lcat' => $lcat,
                'inam' => $inam,
                'pnco' => $pncd,
                'docg' => $this->input->post('docuEdt'),
                'incg' => $this->input->post('insuEdt'),
                'chmd' => $this->input->post('crgmdEdt'), // charge mode
                'indt' => $this->input->post('indtEdt'),
                'acdt' => $this->input->post('dsdtEdt'),
                //'rmks' => $this->input->post('remkEdt'),

                'stat' => 19,
                'duap' => 1,

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'lnid' => $auid
            );
            $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);

            // DUAL APPROVAL TB UPDATE
            $data_arr2 = array(
                'lnid' => $auid,
                'apmt' => $apmt,
                'rqmt' => $loam,
                'stat' => 0,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $this->Generic_model->insertData('dual_approval', $data_arr2);

            // IF NEW LOAN COMMENT ADD
            $cmt = $this->input->post('remkNew');
            if (!empty($cmt)) {
                $data_arr = array(
                    'cmtp' => 2,
                    'cmmd' => 1,
                    'cmrf' => $auid,
                    'cmnt' => $cmt,
                    'stat' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('comments', $data_arr);
            }
            // END LOAN COMMENT

            $funcPerm = $this->Generic_model->getFuncPermision('loan');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan Dual Approval lnid(' . $auid . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                //echo json_encode(true);
                echo json_encode('Dual');   // DUAL APPROVAL
            }
        }
    }

    function rejLoan()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('micr_crt', array('stat' => 4), array('lnid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('loan');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan reject id(' . $id . ')');


        // ACCOUNT LEDGER RECODE RETURN
        $acdt = $this->Generic_model->getData('acc_leg', '', array('lnid' => $id, 'trid' => 8));
        $len2 = sizeof($acdt);
        for ($n = 0; $n < $len2; $n++) {
            $data_aclg23 = array(
                'brno' => $acdt[$n]->brno, // BRANCH ID
                'lnid' => $id, // LOAN ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'ACNT DIFN - CAN',
                'trid' => 30,
                //'rfno' => $acdt[$n]->rfno,
                'rfna' => $acdt[$n]->rfna,
                'dcrp' => 'ACNT DIFN - CAN ',

                'acco' => $acdt[$n]->acco,    // cross acc code
                'spcd' => $acdt[$n]->spcd,    // split acc code
                'acst' => $acdt[$n]->acst,      //
                'dbam' => $acdt[$n]->cram,      // db amt
                'cram' => $acdt[$n]->dbam,      // cr amt
                'stat' => 0
            );
            $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);
        }

        $data_arr = array(
            'cmtp' => 2,
            'cmmd' => 2,
            'cmrf' => $id,
            'cmnt' => 'Loan Rejected By: ' . $_SESSION['username'],
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('comments', $data_arr);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
// End loan
//
// Customer Transfer In Same Branch
    public function cust_trnsf()
    {
        // User Access Page Log     $this->Log_model->userLog('cust_trnsf');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();


        $this->load->view('modules/user/customer_transfer', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function customer_list()
    {
        $userlvl = $this->Generic_model->getData('user_mas', array('auid', 'usmd'), array('auid' => $_SESSION['userId']));

        $result = $this->User_model->get_customerTransfList();
        $data = array();
        $i = $_POST['start'];


        foreach ($result as $row) {
            $st = $row->stat;

            if ($row->trst == 1) {
                $tr = "<span class='label label-default' title='Transfer Customer'>T</span>";
            } else {
                $tr = '';
            }

            $option = "<button type='button' data-toggle='modal' data-target='#modalView' onclick='viewCust($row->cuid );' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                "<button type='button' id='edt'  data-toggle='modal' data-target='#modalEdt' onclick='transferCust(" . $row->cuid . ",id);' class='btn  btn-default btn-condensed' title='Transfer'><i class='glyphicon glyphicon-transfer' aria-hidden='true'></i></button> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->exc;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->cuno . ' ' . $tr;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->hoad;
            //$sub_arr[] = $tr;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_custTransf(),
            "recordsFiltered" => $this->User_model->count_filtered_custTransf(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function CusttrzfHis()
    {
        $id = $this->input->post('cuid');

        $this->db->select("cus_mas_base.* ,DATE_FORMAT(cus_mas_base.crdt, '%Y-%m-%d') AS frdt ,DATE_FORMAT(cus_mas_base.trdt, '%Y-%m-%d') AS todt, user_mas.fnme,cen_mas.cnnm,brch_mas.brnm,grup_mas.grno,
        CONCAT(a.fnme,' ',a.lnme) AS trus");
        $this->db->from("cus_mas_base");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas_base.ccnt');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas_base.brid');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas_base.grno');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas_base.exec');

        $this->db->join("(SELECT fnme,lnme,auid FROM user_mas ) AS a ", 'a.auid = cus_mas_base.trby', 'left');

        $this->db->where('cus_mas_base.cuid', $id);
        $this->db->order_by("cus_mas_base.auid", "asc");
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

    // CUSTOMER RUNNING LOAN
    function getCustRnloan()
    {
        $auid = $_POST['auid'];
        $result = $this->Generic_model->getData('micr_crt', '', "apid = $auid AND stat IN (2,5)");
        echo json_encode(count($result));
    }

    function getCustmDtil()
    {
        $this->db->select("cus_mas.cuid,cus_mas.rgtp,cus_mas.cuno,cus_mas.init,cus_mas.brco,cus_mas.exec,cus_mas.ccnt,cus_mas.hoad,cus_mas.tele,cus_mas.mobi,cus_mas.anic,
        cus_mas.uimg,cus_sol.sode,cus_mas.stat, ( SELECT COUNT(*) AS pen FROM `micr_crt` WHERE stat = 1 AND apid = cuid) AS pen,
        (SELECT COUNT(*) AS pen FROM `micr_crt` WHERE stat IN(2,5) AND apid = cuid) AS act,brch_mas.brnm, cen_mas.cnnm,CONCAT(user_mas.fnme,' ',user_mas.lnme) AS exe,grup_mas.grno ");
        $this->db->from("cus_mas");
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl ');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco ');
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');

        $this->db->where('cus_mas.anic ', $this->input->post('id'));
        $query = $this->db->get();
        $data['custdtil'] = $query->result();

        $data['usrbrn'] = $this->Generic_model->getData('user_mas', array('auid', 'brch'), array('auid' => $_SESSION['userId']));

        echo json_encode($data);
    }

    function customer_transfer()
    {
        $cuid = $this->input->post('auid'); // customer auid

        // get last active recode data form customer transfer tb
        $this->db->select("auid");
        $this->db->from("cus_mas_base");
        $this->db->where('cus_mas_base.cuid ', $cuid);
        $this->db->where('cus_mas_base.stat IN(1,2)');
        $this->db->order_by('cus_mas_base.auid', 'desc');

        $this->db->limit(1);
        // $query = $this->db->get();
        $data = $this->db->get()->result();
        $lsid = $data[0]->auid;

        // customer transfer tb last recode update for transfer
        $data_ar1 = array(
            'stat' => 2,
            'trrs' => $this->input->post('trrs'),
            'trby' => $_SESSION['userId'],
            'trdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('cus_mas_base', $data_ar1, array('auid' => $lsid));

        // cus_mas tb current customer recode update new transfer details

        $brco = $this->input->post('brch_trnsf');
        $ccnt = $this->input->post('cen_trnsf');
        $exec = $this->input->post('exc_trnsf');
        $grup = $this->input->post('grup_trnsf');

        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $cndt = $this->Generic_model->getData('cen_mas', array('caid', 'cnno', 'stat'), array('caid' => $ccnt, 'stat' => 1));
        $cn = $cndt[0]->cnno;

        $cc = strlen($cn);

        if ($cc == 1) {
            $cncd = '000' . $cn;
        } else if ($cc == 2) {
            $cncd = '00' . $cn;
        } else if ($cc == 3) {
            $cncd = '0' . $cn;
        } else if ($cc == 4) {
            $cncd = '' . $cn;
        }

        $this->db->select("cuno,brid,ccnt");
        $this->db->from("cus_mas_base");
        $this->db->where('cus_mas_base.brid ', $brco);
        $this->db->where('cus_mas_base.ccnt ', $ccnt);
        //  $this->db->where('cus_mas.stat ', 3); // approval customer
        $this->db->order_by('cus_mas_base.auid', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $cuno_n = $brcd . '/' . $cncd . '/00001';

        } else {
            $cuno = $data[0]->cuno;
            $re = (explode("/", $cuno));

            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);

            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '0' . $aa;
            }

            // $cuno_n = $re[0] . '/' . $re[1] . '/' . $xx;
            $cuno_n = $brcd . '/' . $cncd . '/' . $xx;
        }

        $data_arr = array(
            'brco' => $brco,
            'exec' => $exec,
            'ccnt' => $ccnt,
            'cuno' => $cuno_n, // cust no
            'grno' => $grup,
            'trst' => 1
        );
        $where_arr = array(
            'cuid' => $cuid
        );
        $result2 = $this->Generic_model->updateData('cus_mas', $data_arr, $where_arr);

        // Customer Branch details insert  new transfer recode
        $data_arr33 = array(
            'cuid' => $cuid,
            'cuno' => $cuno_n, // cust no
            'brid' => $brco,
            'exec' => $exec,
            'ccnt' => $ccnt,
            'grno' => $grup,
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result3 = $this->Generic_model->insertData('cus_mas_base', $data_arr33);
        // var_dump($result3);


        if (count($result3) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // customer transfer other branch
    // cust_trnsf request
    public function trnsf_requst()
    {
        // User Access Page Log     $this->Log_model->userLog('trnsf_requst');
        $data['permission'] = $this->Generic_model->getPermision();
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('trnsf_requst');

        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();


        $this->load->view('modules/user/customer_transfer_request', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function RqstCustList()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('trnsf_requst');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Request List View');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }

        if ($funcPerm[0]->rejt == 1) {
            $rjt = "";
        } else {
            $rjt = "disabled";
        }

        $result = $this->User_model->get_customerRqustList();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '9') {  //Transfer Requested
                $stat = " <span class='label label-warning'> Pending </span> ";

                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust($row->cuid );' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled   data-toggle='modal' data-target='#modalAddTrfcust' onclick='addTransferCust();' class='btn  btn-default btn-condensed' title='Add customer '><i class='fa fa-plus' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rjt onclick='rejecRequst($row->cuid,$row->auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '10') {  // Pending Transfer
                $stat = " <span class='label label-success'> Approval Transfer </span> ";

                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust();' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $app  data-toggle='modal' data-target='#modalAddTrfcust' onclick='addTransferCust($row->cuid,$row->auid);' class='btn  btn-default btn-condensed' title='Add customer '><i class='fa fa-plus' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rjt onclick='rejecRequst($row->cuid,$row->auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->anic;
            // $sub_arr[] = $row->hoad;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->rqusr;
            $sub_arr[] = $row->rqrs;
            $sub_arr[] = $row->apusr;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_custRqust(),
            "recordsFiltered" => $this->User_model->count_filtered_custRqust(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function custm_rqust()
    {
        $cuid = $this->input->post('auid');

        $funcPerm = $this->Generic_model->getFuncPermision('trnsf_requst');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Request ' . $cuid);

        // get last active recode data form customer transfer tb
        $this->db->select("auid");
        $this->db->from("cus_mas_base");
        $this->db->where('cus_mas_base.cuid ', $cuid);
        $this->db->where('cus_mas_base.stat IN(1,2)');
        $this->db->order_by('cus_mas_base.auid', 'desc');

        $this->db->limit(1);
        $data = $this->db->get()->result();
        $lsid = $data[0]->auid;

        $data_ar1 = array(
            'stat' => 9, //Transfer Requested
            'rqrs' => $this->input->post('rqrs'),
            'rqbr' => $this->input->post('req_brn'),
            'rqby' => $_SESSION['userId'],
            'rqdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('cus_mas_base', $data_ar1, array('auid' => $lsid));

        $result2 = $this->Generic_model->updateData('cus_mas', array('stat' => 9,), array('cuid' => $cuid));

        if (count($result1) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // cust_trnsf responed
    public function trnsf_respond()
    {
        // User Access Page Log     $this->Log_model->userLog('trnsf_respond');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();


        $this->load->view('modules/user/customer_transfer_responed', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function vewTrcustdtils()
    {
        $auid = $this->input->post('auid');

        $this->db->select("cus_mas_base.rqdt,cus_mas.cuno,cus_mas.funm,cus_mas.hoad,cus_mas.anic, CONCAT(user_mas.fnme,' ',user_mas.lnme) AS rqus,brch_mas.brnm");
        $this->db->from("cus_mas_base");
        $this->db->join('cus_mas', 'cus_mas.cuid = cus_mas_base.cuid');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas_base.rqby');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas_base.rqbr');
        $this->db->where('cus_mas_base.auid ', $auid);

        $data = $this->db->get()->result();
        echo json_encode($data);
    }

    function responedCustList()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('trnsf_respond');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Transfer Received List View');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }

        if ($funcPerm[0]->rejt == 1) {
            $rjt = "";
        } else {
            $rjt = "disabled";
        }


        $result = $this->User_model->get_custRespndList();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '9') {  //Transfer Requested
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust($row->cuid );' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $app  data-toggle='modal' data-target='#modalEdt' onclick='transferCust(" . $row->cuid . "," . $row->auid . ");' class='btn  btn-default btn-condensed' title='Transfer'><i class='glyphicon glyphicon-transfer' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rjt onclick='rejecRequst($row->cuid,$row->auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '10') {  // Pending Transfer
                $stat = " <span class='label label-success'> Approval Transfer </span> ";

                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' disabled onclick='viewCust();' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $app  disabled  data-toggle='modal' data-target='#modalEdt' onclick='transferCust();' class='btn  btn-default btn-condensed' title='Transfer'><i class='glyphicon glyphicon-transfer' aria-hidden='true'></i></button> " .
                    "<button type='button' disabledjt onclick='' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->anic;
            // $sub_arr[] = $row->hoad;
            $sub_arr[] = $row->rqbrn;
            $sub_arr[] = $row->rqusr;
            $sub_arr[] = $row->rqrs;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_custResp(),
            "recordsFiltered" => $this->User_model->count_filtered_custResp(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function brnc_cust_trnsf()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('trnsf_respond');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Request Approval');

        $cuid = $this->input->post('cuid');
        $auid = $this->input->post('auid2');

        $rqbrn = $this->Generic_model->getData('cus_mas_base', array('rqbr'), array('auid' => $auid, 'stat' => 9, 'cuid' => $cuid));
        $rqbr = $rqbrn[0]->rqbr;

        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $rqbr, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $rnd = rand(100, 1000);
        $tmp_cuno = $brcd . '/TR/' . $rnd;

        //var_dump($tmp_cuno);
        // die();

        $data_ar1 = array(
            'stat' => 10,
            'aprs' => $this->input->post('remk'),
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('cus_mas_base', $data_ar1, array('auid' => $auid));

        $data_ar2 = array(
            'cuno' => $tmp_cuno,
            'brco' => $rqbr,
            'exec' => 0,
            'ccnt' => 0,
            'grno' => 0,
            'stat' => 10
        );

        $result2 = $this->Generic_model->updateData('cus_mas', $data_ar2, array('cuid' => $cuid));

        if (count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // Transfer Customer add
    function addTrnsfcust()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('trnsf_requst');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add Transfer Customer');

        $cuid = $this->input->post('cusid'); // customer auid
        $auid = $this->input->post('autid'); // customer base tb auid

        // cus_mas tb current customer recode update new transfer details

        $brco = $this->input->post('brch_trnsf');
        $ccnt = $this->input->post('cen_trnsf');
        $exec = $this->input->post('exc_trnsf');
        $grup = $this->input->post('grup_trnsf');

        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $cndt = $this->Generic_model->getData('cen_mas', array('caid', 'cnno', 'stat'), array('caid' => $ccnt, 'stat' => 1));
        $cn = $cndt[0]->cnno;

        $cc = strlen($cn);

        if ($cc == 1) {
            $cncd = '000' . $cn;
        } else if ($cc == 2) {
            $cncd = '00' . $cn;
        } else if ($cc == 3) {
            $cncd = '0' . $cn;
        } else if ($cc == 4) {
            $cncd = '' . $cn;
        }

        $this->db->select("cuno,brid,ccnt");
        $this->db->from("cus_mas_base");
        $this->db->where('cus_mas_base.brid ', $brco);
        $this->db->where('cus_mas_base.ccnt ', $ccnt);
        $this->db->where('cus_mas_base.stat  NOT IN (9,10) '); // with out requested & approval customer
        $this->db->order_by('cus_mas_base.auid', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $cuno_n = $brcd . '/' . $cncd . '/00001';

        } else {
            $cuno = $data[0]->cuno;
            $re = (explode("/", $cuno));

            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);

            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '0' . $aa;
            }

            // $cuno_n = $re[0] . '/' . $re[1] . '/' . $xx;
            $cuno_n = $brcd . '/' . $cncd . '/' . $xx;
        }

        $data_arr = array(
            'brco' => $brco,
            'exec' => $exec,
            'ccnt' => $ccnt,
            'cuno' => $cuno_n, // cust no
            'grno' => $grup,
            'stat' => 4,
            'trst' => 1
        );
        $where_arr = array(
            'cuid' => $cuid
        );
        $result2 = $this->Generic_model->updateData('cus_mas', $data_arr, $where_arr);

        // customer perviouse recode chang to transfer recode
        $data_ar2 = array(
            'stat' => 2,
            'trby' => $_SESSION['userId'],
            'trdt' => date('Y-m-d H:i:s'),
        );
        $result123 = $this->Generic_model->updateData('cus_mas_base', $data_ar2, array('auid' => $auid));

        // Customer Branch details insert  new transfer recode
        $data_arr33 = array(
            'cuid' => $cuid,
            'cuno' => $cuno_n, // cust no
            'brid' => $brco,
            'exec' => $exec,
            'ccnt' => $ccnt,
            'grno' => $grup,
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result3 = $this->Generic_model->insertData('cus_mas_base', $data_arr33);
        // var_dump($result3);


        if (count($result3) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // Transfer Reject
    function rejecRequst()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('trnsf_requst');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Request Reject');

        $cuid = $this->input->post('cuid'); // customer auid
        $auid = $this->input->post('auid'); // customer base tb auid

        $cubs = $this->Generic_model->getData('cus_mas_base', array('brid', 'exec', 'ccnt', 'grno', 'cuno', 'stat'), array('auid' => $auid, 'cuid' => $cuid));
        $cbst = $cubs[0]->stat;

        $result1 = $this->Generic_model->updateData('cus_mas_base', array('stat' => 1), array('auid' => $auid));


        $cums = $this->Generic_model->getData('cus_mas', array('stat'), array('cuid' => $cuid));
        $cust = $cums[0]->stat;

        if ($cust == 9) {
            $result2 = $this->Generic_model->updateData('cus_mas', array('stat' => 4), array('cuid' => $cuid));
        } elseif ($cust == 10) {
            $data_ar2 = array(
                'cuno' => $cubs[0]->cuno,
                'brco' => $cubs[0]->brid,
                'exec' => $cubs[0]->exec,
                'ccnt' => $cubs[0]->ccnt,
                'grno' => $cubs[0]->grno,
                'stat' => 4
            );

            $result2 = $this->Generic_model->updateData('cus_mas', $data_ar2, array('cuid' => $cuid));
        }

        if (count($result1) > 0 && count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
    // End Customer transfer
    //
    // loan repayment Group
    function rpymt()
    {
        // User Access Page Log     $this->Log_model->userLog('rpymt');
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prductinfo'] = $this->Generic_model->getData('prdt_typ', array('prid,prtp,stat'), 'stat = 1 AND prbs IN(1,2)', '');

        $this->load->view('modules/user/repayment', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function getLoanRepaymt()
    {
        $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'rpymt', 'stat' => 1));
        $plcy = $policy[0]->post;

        $result = $this->User_model->get_loanRpymtDtils();
        $data = array();
        $i = $_POST['start'];
        //$n = 0;
        foreach ($result as $row) {
            $n = $i + 1;
            if ($plcy == 1) {  // if policy 1 last payment
                $pymt = $row->inam;
            } else {
                $pymt = $row->lspa;
            }

            if ($pymt >= $row->baln) {
                $pymt = $row->baln;
                $clr = " style='color: red'";
            } else {
                $pymt = $pymt;
                $clr = '';
            }

            $img = "<img src='../uploads/cust_profile/" . $row->uimg . "'  class='sm-image' title='" . $row->cuno . " STD : " . $row->crdt . "'/>";
            $pymt = "<input size='7' type='text' tabindex='" . $n . "'  $clr class='TabOnEnter form-control pybx' name='amt[" . $i . "]' id='amt[" . $i . "]' onkeyup='kydown(" . $i . ",this.value,event);calTotal();' value='" . number_format($pymt, 2, '.', '') . "' style='text-align:right;'>";
            $hidden = "<input type='hidden'  name='lid[" . $i . "]' value='" . $row->lnid . "'>";
            $sms = "<label class=''><input type='checkbox' name='sms[" . $i . "]' value='1' id='checkbox-1'  class='icheckbox' checked='checked'/> </label>";
            $pby = "<select class='form-control select' name='payby[" . $i . "]' id='payby' required><option value='0'>--Select--</option><option selected value='1'>Customer</option><option value='2'>Member</option><option value='3'>Gurdian</option></select>";
            $pat = "<select class='form-control' name='payat[" . $i . "]' id='payat' required><option value='0'>--Select--</option><option selected value='1'>Center</option><option value='2'>At Home</option></select>";
            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";


            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->grno;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $img . $row->init; // cust name
            $sub_arr[] = $acno . $hidden;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->prtp;
            $sub_arr[] = number_format($row->arre, 2, '.', ',');
            //$sub_arr[] = number_format(($row->boc + $row->boi + $row->aboc + $row->aboi + $row->avpe + $row->avdb) - $row->avcr, 2, '.', ',');
            $sub_arr[] = number_format($row->baln, 2, '.', ',');
            $sub_arr[] = $row->tdpy;
            $sub_arr[] = $pymt;
            $sub_arr[] = $pby;
            $sub_arr[] = $pat;
            $sub_arr[] = $sms;

            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_Rpymt(),
            "recordsFiltered" => $this->User_model->count_filtered_Rpymt(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // group repayment add
    function repymtAdd()
    {
        $len = $this->input->post('len');
        $lpcount = 0; // looping count

        $this->db->trans_begin();   // SQL TRANSACTION START

        $user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
        $brn = $user[0]->brch;
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn));
        $brcd = $brdt[0]->brcd;

        $this->db->select("reno");
        $this->db->from("receipt");
        $this->db->where('receipt.brco ', $brn);
        $this->db->where('receipt.retp ', 2);
        $this->db->order_by('receipt.reid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $reno = $brcd . '/RP/' . $yr . '/00001';
        } else {
            $reno = $data[0]->reno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;
            $cc = strlen($aa);

            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }
            $reno = $brcd . '/RP/' . $yr . '/' . $xx;
        }

        for ($a = 0; $a < $len; $a++) {
            $lnid = $this->input->post("lid[" . $a . "]");      // loan id
            $ramt = $this->input->post("amt[" . $a . "]");      // payment amount
            $payby = $this->input->post("payby[" . $a . "]");   // pay by
            $payat = $this->input->post("payat[" . $a . "]");   // pay at
            $sms = $this->input->post("sms[" . $a . "]");       // sms send 0 - no 1 - send

            $lndt = $this->Generic_model->getData('micr_crt', array('apid', 'acno'), array('lnid' => $lnid));
            $cuid = $lndt[0]->apid;
            $acno = $lndt[0]->acno;

            //$num = "3.14";
            //$int = (int)$num;
            //$float = (float)$num;

            $ramt = (float)$ramt;
            if (!empty($ramt) || $ramt != '' || $ramt != '0' || $ramt != '0.00') {
                $pyac = 106; // CASH PAY
                $acst = '(106) Cash Book';
                $chk = 0;

// GET ACCOUNT BALANCE
                $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp, 
                        SUM(`schg`) AS avsc, SUM(`duam`) AS duam, SUM(`ream`) AS ream, SUM(`ovpm`) AS ovpm ,((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage ");
                $this->db->from("micr_crleg");
                $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
                $this->db->where('acid', $lnid);
                $this->db->where('stat IN(1,2) ');
                $acdt = $this->db->get()->result();

                $cboc = round($acdt[0]->avcp, 2); // CAPITAL
                $cboi = round($acdt[0]->avin, 2); // INTEREST
                $aboc = round($acdt[0]->arcp, 2); // ARR CAP
                $aboi = round($acdt[0]->arin, 2); // ARR INT
                $avdp = round($acdt[0]->avdp, 2); // PENALTY
                $avsc = round($acdt[0]->avsc, 2); // CHARGES

                $tdua = round($acdt[0]->duam, 2); // TTL DUE
                $trpa = round($acdt[0]->ream, 2); // TTL PYMT
                $ovpm = round($acdt[0]->ovpm, 2); // TTL OVPY
                $cage = round($acdt[0]->cage, 2); // CURN AGE
//Calculate Recovery Balances
                $rcsc = $rcpe = $rcin = $rccp = $rcod = 0;
                if ($ramt >= ($avsc + $avdp + $aboi + $aboc)) { //PAY AMT+CRDT >= SCHG+DFPN+ARINT+ARCAP
                    $rcsc = $avsc;
                    $rcpe = $avdp;
                    $rcin = $aboi;//-->
                    $rccp = $aboc;//-->
                    $rcod = (($ramt) - ($avsc + $avdp + $aboi + $aboc));
                } else if ($ramt >= ($avsc + $avdp + $aboi)) { //PAY AMT+CRDT >= SCHG+DFPN+ARINT
                    $rcsc = $avsc;
                    $rcpe = $avdp;
                    $rcin = $aboi;
                    $rccp = round(($ramt - ($avsc + $avdp + $aboi)), 2);
                } else if ($ramt >= ($avsc + $avdp)) { //PAY AMT+CRDT >= SCHG+DFPN
                    $rcsc = $avsc;
                    $rcpe = $avdp;
                    $rcin = round(($ramt - ($avsc + $avdp)), 2);
                } else if ($ramt >= ($avsc)) { //PAY AMT+CRDT >= SCHG
                    $rcsc = $avsc;
                    $rcpe = round(($ramt - $avsc), 2);
                } else { //PAY AMT+CRDT > 0
                    $rcsc = round($ramt, 2);
                }

// # RECEIPTS TB
                $data_arr = array(
                    'brco' => $brn,
                    'reno' => $reno,
                    'rfno' => $lnid, // loan id
                    'retp' => 2,
                    'ramt' => $ramt,
                    'pyac' => 106,
                    'pymd' => 8,
                    'remd' => 1,
                    'clid' => $cuid, // cust id
                    'stat' => 1,
                    'ssms' => $sms,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('receipt', $data_arr);

// # RECEIPTS DESC TB
                $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
                $reid = $recdt[0]->reid;
                $data_arr22 = array(
                    'reno' => $reno,
                    'reid' => $reid, // recpt id
                    'rfco' => 108,
                    'rfdc' => 'PYMNT for ' . $acno,
                    'rfdt' => date('Y-m-d'),
                    'amut' => $ramt
                );
                $result2 = $this->Generic_model->insertData('recp_des', $data_arr22);
// END RECEIPTS

                $usdt = $this->Generic_model->getData('user_mas', array('brch'), array('auid' => $_SESSION['userId']));
                $brco = $usdt[0]->brch;

// MICRO LEDGE @1
                $data_mclg1 = array(
                    'acid' => $lnid, // LOAN ID
                    'acno' => $acno, // LOAN NO
                    'ledt' => date('Y-m-d H:i:s'),
                    'reno' => $reno,
                    'reid' => $reid,
                    'dsid' => 2,
                    'dcrp' => 'PYMNT',

                    'avcp' => (-$rccp),
                    'avin' => (-$rcin),
                    'capt' => (-$rccp),
                    'inte' => (-$rcin),
                    'dpet' => (-$rcpe),
                    'schg' => (-$rcsc),
                    'duam' => 0,
                    'ream' => $ramt,
                    'ovpm' => $rcod,

                    'stat' => 1,
                    'paby' => $payby,
                    'paat' => $payat
                );
                $res11 = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
// END MICRO LEDGE @1

// ACCOUNT LEDGER
                $data_aclg23 = array(
                    'brno' => $brco, // BRANCH ID
                    'lnid' => $lnid, // LOAN NO
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'PYMNT',
                    'trid' => 2,
                    'rfno' => $reid, // recpt id
                    'rfna' => $reno,
                    'dcrp' => 'PYMNT ',

                    'acco' => 204,    // cross acc code
                    'spcd' => $pyac,    // split acc code
                    'acst' => $acst,      //
                    'dbam' => $ramt,      // db amt
                    'cram' => 0,      // cr amt
                    'stat' => 0
                );
                $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);

//Credit Penalty income @+1
                if ($rcpe > 0) {
                    $data_aclg45 = array(
                        'brno' => $brn, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'PYMNT',
                        'trid' => 2,
                        'rfno' => $reid, // recpt id
                        'rfna' => $reno,
                        'dcrp' => 'PYMNT ',

                        'acco' => $pyac,    // cross acc code
                        'spcd' => 402,    // split acc code
                        'acst' => '(402) Penalty Income Account',      //
                        'dbam' => 0,      // db amt
                        'cram' => $rcpe,      // cr amt
                        'stat' => 0
                    );
                    $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                }

//Credit Service income @+1
                if ($rcsc > 0) {
                    $data_aclg45 = array(
                        'brno' => $brn, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'PYMNT',
                        'trid' => 2,
                        'rfno' => $reid, // recpt id
                        'rfna' => $reno,
                        'dcrp' => 'PYMNT ',

                        'acco' => $pyac,    // cross acc code
                        'spcd' => 401,    // split acc code
                        'acst' => '(401) Service Charges',      //
                        'dbam' => 0,      // db amt
                        'cram' => $rcsc,      // cr amt
                        'stat' => 0
                    );
                    $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                }

//Credit Arrears @+1 with aboc + aboi
                if (($rcsc + $rcpe + $rcin + $rccp) > 0 && ($rcin + $rccp) > 0) {
                    $data_aclg45 = array(
                        'brno' => $brn, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'PYMNT',
                        'trid' => 2,
                        'rfno' => $reid, // recpt id
                        'rfna' => $reno,
                        'dcrp' => 'PYMNT ',

                        'acco' => $pyac,    // cross acc code
                        'spcd' => 110,    // split acc code
                        'acst' => '(110) Receivable Arrears',      //
                        'dbam' => 0,      // db amt
                        'cram' => ($rcin + $rccp),      // cr amt
                        'stat' => 0
                    );
                    $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                }

//Credit OD @+1  over payment
                if ($rcod > 0) {
                    $data_aclg45 = array(
                        'brno' => $brn, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'PYMNT',
                        'trid' => 2,
                        'rfno' => $reid, // recpt id
                        'rfna' => $reno,
                        'dcrp' => 'PYMNT ',

                        'acco' => $pyac,    // cross acc code
                        'spcd' => 204,    // split acc code
                        'acst' => '(204) Over Payments',      //
                        'dbam' => 0,      // db amt
                        'cram' => $rcod,      // cr amt
                        'stat' => 0
                    );
                    $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                }

//// CHK FINISHED
                $this->db->select(" mc.lnid, mc.inam, mc.loam, mc.inta, rc.ramt, IFNULL(ml.dpet,0) AS dpet, IFNULL(ml.schg,0) AS schg");
                $this->db->from("micr_crt mc");
                $this->db->join("(SELECT acid, SUM(`dpet`) AS dpet, SUM(`schg`) AS schg
                        FROM `micr_crleg` WHERE stat IN(1,2) AND  dsid IN(4,23,24,25) GROUP BY acid) AS ml", 'ml.acid = mc.lnid ', 'left');
                $this->db->join("(SELECT rfno,SUM(ramt) AS ramt FROM `receipt` WHERE retp = 2 AND stat IN(1,2) GROUP BY rfno) AS rc", 'rc.rfno = mc.lnid ', 'left');
                $this->db->where('lnid', $lnid);
                $bldt = $this->db->get()->result();

                $loam = round($bldt[0]->loam, 2); // TTL AMOUNT
                $inta = round($bldt[0]->inta, 2); // TTL INTEREST
                $dpet = round($bldt[0]->dpet, 2); // TTL PENALTY
                $schg = round($bldt[0]->schg, 2); // TTL CHARGES
                $ramt = round($bldt[0]->ramt, 2); // TTL REPAYMENT
                //$cage = round($bldt[0]->cage, 2); // CURRENT AGE
                $lnbal = $loam + $inta + $dpet + $schg;  // AMOUNT +  INTEREST + PENALTY + CHARGES

                // IF PAYMENT BALANCE > CURRENT LOAN BALANCE ( LOAN AUTO SETTLEMENT)
                if ($ramt >= $lnbal) {
                    $ovr_bal = round($ramt - $lnbal, 2); // OVER PAYMENT BALANCE
                    // DUE TO NEGATIVE OVER PAYMENT VALIDATION
                    if ($ovr_bal < 0) {
                        $ovr_bal = 0;
                    } else {
                        $ovr_bal = $ovr_bal;
                    }

                    $data_1 = array(
                        'avcp' => 0,
                        'avin' => 0,
                        'capt' => 0,
                        'inte' => 0,
                        'dpet' => 0,
                        'schg' => 0,
                    );
                    $result5 = $this->Generic_model->updateData('micr_crleg', $data_1, array('reid' => $reid));

                    $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp,
                    SUM(`schg`) AS avsc , SUM(`ovpm`) AS ovpm ,a.inam, ((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage, SUM(`duam`) AS duam, SUM(`ream`) AS ream ");
                    $this->db->from("micr_crleg");
                    $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
                    $this->db->where('acid', $lnid);
                    $this->db->where('stat IN(1,2) ');
                    $acdt = $this->db->get()->result();

                    $cboc = round($acdt[0]->avcp, 2); // CAPITAL
                    $cboi = round($acdt[0]->avin, 2); // INTEREST
                    $aboc = round($acdt[0]->arcp, 2); // ARR CAP
                    $aboi = round($acdt[0]->arin, 2); // ARR INT
                    $avdp = round($acdt[0]->avdp, 2); // PENALTY
                    $avsc = round($acdt[0]->avsc, 2); // CHRGES
                    $ovpm = round($acdt[0]->ovpm, 2); // OVER PYMNT
                    $cage = round($acdt[0]->cage, 2); // CURN AGE
                    $duam = round($acdt[0]->duam, 2); //Due Amount
                    $ream = round($acdt[0]->ream, 2); //Repayment Total

                    // MICRO LEDGE UPDATE
                    $data_m1 = array(
                        'dsid' => 9,
                        'dcrp' => 'SMNT',
                        'avcp' => (-$cboc),
                        'avin' => (-$cboi),
                        'capt' => (-$aboc),
                        'inte' => (-$aboi),
                        'dpet' => (-$avdp),
                        'schg' => (-$avsc),
                        'duam' => round($ream - $duam, 2),
                        'cage' => $cage,
                        'ovpm' => $ovr_bal,
                    );
                    $result5 = $this->Generic_model->updateData('micr_crleg', $data_m1, array('reid' => $reid));

                    // MICRO CART UPDATE
                    $data_arrrup = array(
                        'boc' => 0,
                        'boi' => 0,
                        'aboc' => 0,
                        'aboi' => 0,
                        'avpe' => 0,
                        'avdb' => 0,
                        'avcr' => $ovr_bal, //0
                        'stat' => 3, // CHANGE LOAN STATUS
                        'lspa' => $ramt,
                        'lspd' => date('Y-m-d H:i:s'),
                        'lstp' => 1,
                        'cage' => $cage
                    );
                    $rest1 = $this->Generic_model->updateData('micr_crt', $data_arrrup, array('lnid' => $lnid));

                    // SMNT ACCOUNT LEDGER
                    $data_aclg23 = array(
                        'brno' => $brn, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'SMNT',
                        'trid' => 9,
                        //'rfno' => $reid, // recpt id
                        //'rfna' => $reno,
                        'dcrp' => 'SMNT ',
                        'acco' => 111,    // cross acc code
                        'spcd' => 204,    // split acc code
                        'acst' => '(204) Over Payments',    //
                        'dbam' => $ovpm,    // db amt
                        'cram' => 0,        // cr amt
                        'stat' => 0,
                    );
                    $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $brn, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'SMNT',
                        'trid' => 9,
                        //'rfno' => $reid, // recpt id
                        //'rfna' => $reno,
                        'dcrp' => 'SMNT ',

                        'acco' => 204,    // cross acc code
                        'spcd' => 111,    // split acc code
                        'acst' => '(111) Loan Controller',      //
                        'dbam' => 0,      // db amt
                        'cram' => $ovpm,      // cr amt
                        'stat' => 0
                    );
                    $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);

                } else {

                    $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp,
                    SUM(`schg`) AS avsc , SUM(`ovpm`) AS ovpm ,a.inam,  ((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage , SUM(`duam`) AS duam, SUM(`ream`) AS ream");
                    $this->db->from("micr_crleg");
                    $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
                    $this->db->where('acid', $lnid);
                    $this->db->where('stat IN(1,2) ');
                    $acdt = $this->db->get()->result();

                    $cboc = round($acdt[0]->avcp, 2); // CAPITAL
                    $cboi = round($acdt[0]->avin, 2); // INTEREST
                    $aboc = round($acdt[0]->arcp, 2); // ARR CAP
                    $aboi = round($acdt[0]->arin, 2); // ARR INT
                    $avdp = round($acdt[0]->avdp, 2); // PENALTY
                    $avsc = round($acdt[0]->avsc, 2); // CHRGES
                    $ovpm = round($acdt[0]->ovpm, 2); // OVER PYMNT
                    $cage = round($acdt[0]->cage, 2); // CURN AGE
                    $duam = round($acdt[0]->duam, 2); //Due Amount
                    $ream = round($acdt[0]->ream, 2); //Repayment Total

                    //UPDATE micr_crt @1
                    $data_arrrup = array(
                        'boc' => $cboc,
                        'boi' => $cboi,
                        'aboc' => $aboc,
                        'aboi' => $aboi,
                        'avpe' => $avdp,
                        'avdb' => $avsc,
                        'avcr' => round($ream - $duam, 2), // $ovpm
                        'lspa' => $ramt,
                        'lspd' => date('Y-m-d H:i:s'),
                        'lstp' => 1,
                        'cage' => $cage
                    );
                    $rest1 = $this->Generic_model->updateData('micr_crt', $data_arrrup, array('lnid' => $lnid));
                }

// GENARATE NEXT RECEIPTS NO
                $re = (explode("/", $reno));
                $aa = intval($re[3]) + 1;
                $cc = strlen($aa);
                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '' . $aa;
                }
                $reno = $brcd . '/RP/' . $yr . '/' . $xx;
            }
            $lpcount = $lpcount + 1;
        }

        $funcPerm = $this->Generic_model->getFuncPermision('rpymt');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Group repayment add');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    // End group Repayment
    //
    // loan repayment individual
    function rpymt_indv()
    {
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['payinfo'] = $this->Generic_model->getSortData('pay_terms', '', "stat = 1 AND tmid IN(3,4,8,10)", '', '', 'tem_name', 'ASE');
        $data['pay_at'] = $this->Generic_model->getData('pay_at', '', '');
        $data['pay_by'] = $this->Generic_model->getData('pay_by', '', '');
        $data['bnkinfo'] = $this->Generic_model->getData('bnk_names', '', ''); //array('stat' => 1)

        $this->load->view('modules/user/repayment_indv', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // load customer details and loan details
    function getIndvLoan()
    {
        $lnno = $this->input->post('lnno');
        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.lnpr,micr_crt.crdt,micr_crt.docg,micr_crt.incg,micr_crt.chmd,micr_crt.apid,
            cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg,cus_mas.hoad,cus_mas.funm,cus_mas.dobi,cus_mas.smst,cen_mas.cnnm ,brch_mas.brnm,user_mas.fnme ,
            aa.uimg AS gr1img,aa.init AS gr1nm,aa.cuno AS gr1no,bb.uimg AS gr2img,bb.init AS gr2nm,bb.cuno AS gr2no,cc.uimg AS gr3img,cc.init AS gr3nm,cc.cuno AS gr3no,  
            (SELECT COUNT(*) AS acln FROM micr_crt AS xz WHERE stat IN(2,5) AND `xz`.`apid` =  micr_crt.apid)AS aaln 
             ");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join("(SELECT cuid,uimg,init,cuno FROM cus_mas )AS aa ", 'aa.cuid = micr_crt.fsgi', 'left');
        $this->db->join("(SELECT cuid,uimg,init,cuno FROM cus_mas )AS bb ", 'bb.cuid = micr_crt.segi', 'left');
        $this->db->join("(SELECT cuid,uimg,init,cuno FROM cus_mas )AS cc ", 'cc.cuid = micr_crt.thgi', 'left');
        // $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->where('micr_crt.stat', 5);
        $this->db->where('micr_crt.acno', $lnno);
        $query = $this->db->get();
        $data['cudt'] = $query->result();

        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.lnpr,micr_crt.acdt,micr_crt.boc,micr_crt.boi,micr_crt.aboc,micr_crt.aboi,micr_crt.nxdd,micr_crt.lntp,
              micr_crt.avdb, micr_crt.avpe ,micr_crt.avcr ,prdt_typ.pymd,prdt_typ.prna ,product.prcd ,cc.ramt,cc.crdt");
        $this->db->from("micr_crt");
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join("(SELECT rfno,reid,retp,ramt,stat,crdt  FROM `receipt` WHERE retp = 2 AND stat IN(1,2)  ORDER BY `receipt`.`reid` DESC LIMIT 1) AS cc ", 'cc.rfno = micr_crt.lnid', 'left');
        $this->db->where('micr_crt.stat IN(2,5)');
        $this->db->where('micr_crt.acno', $lnno);
        $query = $this->db->get();
        $data['lndt'] = $query->result();

        echo json_encode($data);
    }

    function addPyment()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $chk = 0; // insert count
        $user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
        $brn = $user[0]->brch;
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn));
        $brcd = $brdt[0]->brcd;

        $this->db->select("reno");
        $this->db->from("receipt");
        $this->db->where('receipt.brco ', $brn);
        $this->db->where('receipt.retp ', 2);
        $this->db->order_by('receipt.reid', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $reno = $brcd . '/RP/' . $yr . '/00001';
        } else {
            $reno = $data[0]->reno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;
            $cc = strlen($aa);

            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }
            $reno = $brcd . '/RP/' . $yr . '/' . $xx;
        }

        $lnid = $this->input->post("lnauid");       // loan id
        $ramt = $this->input->post("pyamt");        // repayment amount
        $payby = $this->input->post("pyby");        // pay by
        $payat = $this->input->post("pyat");        // pay at
        $sms = $this->input->post("smss");          // sms send 0 - no | 1 - yes
        $pymd = $this->input->post("pytp");         // payment mode

        if ($pymd == 8 || $pymd == 2) {    // IF 8 CASH / 2 CHQ
            $pyac = 106; // CASH PAY
            $acst = '(106) Cash Book';
        } else {
            $pyac = 107; // CHQ & BANK PAY
            $acst = '(107) Bank/Cash at Bank';
        }

// GET LOAN DETAILS
        $lndt = $this->Generic_model->getData('micr_crt', array('apid,acno,inam'), array('lnid' => $lnid));
        $cuid = $lndt[0]->apid; // CUSTOMER AID
        $acno = $lndt[0]->acno; // LOAN NO
        $inam = $lndt[0]->inam; // RENTAL

// GET ACCOUNT BALANCE
        $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp, 
        SUM(`schg`) AS avsc, SUM(`duam`) AS duam, SUM(`ream`) AS ream, SUM(`ovpm`) AS ovpm ");
        $this->db->from("micr_crleg");
        $this->db->where('acid', $lnid);
        $this->db->where('stat IN(1,2) ');
        $acdt = $this->db->get()->result();

        $cboc = round($acdt[0]->avcp, 2); // CAPITAL
        $cboi = round($acdt[0]->avin, 2); // INTEREST
        $aboc = round($acdt[0]->arcp, 2); // ARR CAP
        $aboi = round($acdt[0]->arin, 2); // ARR INT
        $avdp = round($acdt[0]->avdp, 2); // PENALTY
        $avsc = round($acdt[0]->avsc, 2); // CHRGES
        $tdua = round($acdt[0]->duam, 2); // TTL DUE
        $trpa = round($acdt[0]->ream, 2); // TTL PYMT
        $ovpm = round($acdt[0]->ovpm, 2); // TTL OVPY

//Calculate Recovery Balances
        $rcsc = $rcpe = $rcin = $rccp = $rcod = 0;
        if ($ramt >= ($avsc + $avdp + $aboi + $aboc)) { //PAY AMT+CRDT >= SCHG+DFPN+ARINT+ARCAP
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = $aboi;//-->
            $rccp = $aboc;//-->
            $rcod = (($ramt) - ($avsc + $avdp + $aboi + $aboc));
        } else if ($ramt >= ($avsc + $avdp + $aboi)) { //PAY AMT+CRDT >= SCHG+DFPN+ARINT
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = $aboi;
            $rccp = round(($ramt - ($avsc + $avdp + $aboi)), 2);
        } else if ($ramt >= ($avsc + $avdp)) { //PAY AMT+CRDT >= SCHG+DFPN
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = round(($ramt - ($avsc + $avdp)), 2);
        } else if ($ramt >= ($avsc)) { //PAY AMT+CRDT >= SCHG
            $rcsc = $avsc;
            $rcpe = round(($ramt - $avsc), 2);
        } else { //PAY AMT+CRDT > 0
            $rcsc = round($ramt, 2);
        }

// RECEIPTS AND RECEIPTS DIS TB RECODE
        $data_arr = array(
            'brco' => $brn,
            'reno' => $reno,
            'rfno' => $lnid, // loan id
            'retp' => 2,
            'ramt' => $ramt,
            'pyac' => $pyac,
            'pymd' => $pymd,
            'clid' => $cuid, // cust id
            'stat' => 1,
            'remd' => 1,
            'ssms' => $sms,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('receipt', $data_arr);

        $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
        $reid = $recdt[0]->reid;
        $data_arr22 = array(
            'reno' => $reno,
            'reid' => $reid, // recpt id
            'rfco' => 108,
            'rfdc' => 'PYMNT for ' . $acno,
            'rfdt' => date('Y-m-d'),
            'amut' => $ramt
        );
        $result2 = $this->Generic_model->insertData('recp_des', $data_arr22);
// END RECEIPTS

// MICRO LEDGE @1
        $data_mclg1 = array(
            'acid' => $lnid, // LOAN ID
            'acno' => $acno, // LOAN NO
            'ledt' => date('Y-m-d H:i:s'),
            'reno' => $reno,
            'reid' => $reid,
            'dsid' => 2,
            'dcrp' => 'PYMNT',

            'avcp' => (-$rccp),
            'avin' => (-$rcin),
            'capt' => (-$rccp),
            'inte' => (-$rcin),
            'dpet' => (-$rcpe),
            'schg' => (-$rcsc),
            'duam' => 0,
            'ream' => $ramt,
            'ovpm' => $rcod,

            'stat' => 1,
            'paby' => $payby,
            'paat' => $payat
        );
        $res11 = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
// END MICRO LEDGE @1

// IF CHQ PAYMENT
        if ($pymd == 10) {
            $data_arr3 = array(
                'brco' => $brn,
                'rcbk' => $this->input->post('chbk'),   // chq bnk
                'cqno' => $this->input->post('cqno'),   // chq no
                'cqdt' => $this->input->post('chdt'),   // chq date
                'cqam' => $this->input->post('pyamt'),  // chq amount
                'cqrm' => $this->input->post('chrk'),   // remarks
                'stat' => 0,
                'rcdt' => date('Y-m-d H:i:s'),   // create date
                'rcby' => $_SESSION['userId'],          // create by
                'rcid' => $reid,                        // voucher no
                'rfno' => $reno,                        // voucher id
            );
            $result33 = $this->Generic_model->insertData('chq_recv', $data_arr3);
            if ($result33) {
                $chk = $chk + 1;
            }
        } else {
            $chk = $chk + 1;
        }
// END CHQ PAYMENT

// ACCOUNT LEDGER
        $data_aclg23 = array(
            'brno' => $brn, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'PYMNT',
            'trid' => 2,
            'rfno' => $reid, // recpt id
            'rfna' => $reno,
            'dcrp' => 'PYMNT ',

            'acco' => 204,    // cross acc code
            'spcd' => $pyac,    // split acc code
            'acst' => $acst,    //
            'dbam' => $ramt,    // db amt
            'cram' => 0,        // cr amt
            'stat' => 0,
        );
        $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);

//Credit Penalty income @+1
        if ($rcpe > 0) {
            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'PYMNT',
                'trid' => 2,
                'rfno' => $reid, // recpt id
                'rfna' => $reno,
                'dcrp' => 'PYMNT ',

                'acco' => $pyac,    // cross acc code
                'spcd' => 402,    // split acc code
                'acst' => '(402) Penalty Income Account',      //
                'dbam' => 0,      // db amt
                'cram' => $rcpe,      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }

//Credit Service income @+1
        if ($rcsc > 0) {
            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'PYMNT',
                'trid' => 2,
                'rfna' => $reno,
                'dcrp' => 'PYMNT ',

                'acco' => $pyac,    // cross acc code
                'spcd' => 401,    // split acc code
                'acst' => '(401) Service Charges',      //
                'dbam' => 0,      // db amt
                'cram' => $rcsc,      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }

//Credit Arrears @+1 with aboc + aboi
        if (($rcsc + $rcpe + $rcin + $rccp) > 0 && ($rcin + $rccp) > 0) {
            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'PYMNT',
                'trid' => 2,
                'rfna' => $reno,
                'dcrp' => 'PYMNT ',

                'acco' => $pyac,    // cross acc code
                'spcd' => 110,    // split acc code
                'acst' => '(110) Receivable Arrears',      //
                'dbam' => 0,      // db amt
                'cram' => ($rcin + $rccp),      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }

//Credit OD @+1  over payment
        if ($rcod > 0) {
            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'PYMNT',
                'trid' => 2,
                'rfna' => $reno,
                'dcrp' => 'PYMNT ',

                'acco' => $pyac,    // cross acc code
                'spcd' => 204,    // split acc code
                'acst' => '(204) Over Payments',      //
                'dbam' => 0,      // db amt
                'cram' => $rcod,      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }

//// CHK FINISHED
        $this->db->select(" mc.lnid, mc.inam, mc.loam, mc.inta, rc.ramt, IFNULL(ml.dpet,0) AS dpet, IFNULL(ml.schg,0) AS schg");
        $this->db->from("micr_crt mc");
        $this->db->join("(SELECT acid, SUM(`dpet`) AS dpet, SUM(`schg`) AS schg
                        FROM `micr_crleg` WHERE stat IN(1,2) AND  dsid IN(4,23,24,25) GROUP BY acid) AS ml", 'ml.acid = mc.lnid ', 'left');
        $this->db->join("(SELECT rfno,SUM(ramt) AS ramt FROM `receipt` WHERE retp = 2 AND stat IN(1,2) GROUP BY rfno) AS rc", 'rc.rfno = mc.lnid ', 'left');
        $this->db->where('lnid', $lnid);
        $bldt = $this->db->get()->result();

        $loam = round($bldt[0]->loam, 2); // TTL AMOUNT
        $inta = round($bldt[0]->inta, 2); // TTL INTEREST
        $dpet = round($bldt[0]->dpet, 2); // TTL PENALTY
        $schg = round($bldt[0]->schg, 2); // TTL CHARGES
        $ramt = round($bldt[0]->ramt, 2); // TTL REPAYMENT
        //$cage = round($bldt[0]->cage, 2); // CURRENT AGE
        $lnbal = $loam + $inta + $dpet + $schg;  // AMOUNT +  INTEREST + PENALTY + CHARGES

        // IF PAYMENT BALANCE > CURRENT LOAN BALANCE ( LOAN AUTO SETTLEMENT)
        if ($ramt >= $lnbal) {
            $ovr_bal = round($ramt - $lnbal, 2); // OVER PAYMENT BALANCE
            // DUE TO NEGATIVE OVER PAYMENT VALIDATION
            if ($ovr_bal < 0) {
                $ovr_bal = 0;
            } else {
                $ovr_bal = $ovr_bal;
            }

            $data_1 = array(
                'avcp' => 0,
                'avin' => 0,
                'capt' => 0,
                'inte' => 0,
                'dpet' => 0,
                'schg' => 0,
            );
            $result5 = $this->Generic_model->updateData('micr_crleg', $data_1, array('reid' => $reid));

            $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp,
             SUM(`schg`) AS avsc , SUM(`ovpm`) AS ovpm ,a.inam, ((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage , SUM(`duam`) AS duam, SUM(`ream`) AS ream ");
            $this->db->from("micr_crleg");
            $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
            $this->db->where('acid', $lnid);
            $this->db->where('stat IN(1,2) ');
            $acdt = $this->db->get()->result();

            $cboc = round($acdt[0]->avcp, 2); // CAPITAL
            $cboi = round($acdt[0]->avin, 2); // INTEREST
            $aboc = round($acdt[0]->arcp, 2); // ARR CAP
            $aboi = round($acdt[0]->arin, 2); // ARR INT
            $avdp = round($acdt[0]->avdp, 2); // PENALTY
            $avsc = round($acdt[0]->avsc, 2); // CHRGES
            $ovpm = round($acdt[0]->ovpm, 2); // OVER PYMNT
            $duam = round($acdt[0]->duam, 2); //Due Amount
            $ream = round($acdt[0]->ream, 2); //Repayment Total
            $cage = round($acdt[0]->cage, 2); // CURN AGE

            // MICRO LEDGE UPDATE
            $data_m1 = array(
                'dsid' => 9,
                'dcrp' => 'SMNT',
                'avcp' => (-$cboc),
                'avin' => (-$cboi),
                'capt' => (-$aboc),
                'inte' => (-$aboi),
                'dpet' => (-$avdp),
                'schg' => (-$avsc),
                'duam' => round($ream - $duam, 2),
                'cage' => $cage,
                'ovpm' => $ovr_bal,
            );
            $result5 = $this->Generic_model->updateData('micr_crleg', $data_m1, array('reid' => $reid));

            // MICRO CART UPDATE
            $data_arrrup = array(
                'boc' => 0,
                'boi' => 0,
                'aboc' => 0,
                'aboi' => 0,
                'avpe' => 0,
                'avdb' => 0,
                'avcr' => $ovr_bal, //0
                'stat' => 3, // CHANGE LOAN STATUS
                'lspa' => $ramt,
                'lspd' => date('Y-m-d H:i:s'),
                'lstp' => 1,
                'cage' => $cage
            );
            $rest1 = $this->Generic_model->updateData('micr_crt', $data_arrrup, array('lnid' => $lnid));

            // SMNT ACCOUNT LEDGER
            $data_aclg23 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT',
                'trid' => 9,
                //'rfno' => $reid, // recpt id
                //'rfna' => $reno,
                'dcrp' => 'SMNT ',
                'acco' => 111,    // cross acc code
                'spcd' => 204,    // split acc code
                'acst' => '(204) Over Payments',    //
                'dbam' => $ovpm,    // db amt
                'cram' => 0,        // cr amt
                'stat' => 0,
            );
            $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);

            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT',
                'trid' => 9,
                //'rfno' => $reid, // recpt id
                //'rfna' => $reno,
                'dcrp' => 'SMNT ',

                'acco' => 204,    // cross acc code
                'spcd' => 111,    // split acc code
                'acst' => '(111) Loan Controller',      //
                'dbam' => 0,      // db amt
                'cram' => $ovpm,      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);

        } else {

            $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp,
            SUM(`schg`) AS avsc , SUM(`ovpm`) AS ovpm ,a.inam,  ((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage , SUM(`duam`) AS duam, SUM(`ream`) AS ream");
            $this->db->from("micr_crleg");
            $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
            $this->db->where('acid', $lnid);
            $this->db->where('stat IN(1,2) ');
            $acdt = $this->db->get()->result();

            $cboc = round($acdt[0]->avcp, 2); // CAPITAL
            $cboi = round($acdt[0]->avin, 2); // INTEREST
            $aboc = round($acdt[0]->arcp, 2); // ARR CAP
            $aboi = round($acdt[0]->arin, 2); // ARR INT
            $avdp = round($acdt[0]->avdp, 2); // PENALTY
            $avsc = round($acdt[0]->avsc, 2); // CHRGES
            $ovpm = round($acdt[0]->ovpm, 2); // OVER PYMNT
            $duam = round($acdt[0]->duam, 2); //Due Amount
            $ream = round($acdt[0]->ream, 2); //Repayment Total
            $cage = round($acdt[0]->cage, 2); // CURN AGE

            //UPDATE micr_crt @1
            $data_arrrup = array(
                'boc' => $cboc,
                'boi' => $cboi,
                'aboc' => $aboc,
                'aboi' => $aboi,
                'avpe' => $avdp,
                'avdb' => $avsc,
                'avcr' => round($ream - $duam, 2),
                'lspa' => $ramt,
                'lspd' => date('Y-m-d H:i:s'),
                'lstp' => 1,
                'cage' => $cage
            );
            $rest1 = $this->Generic_model->updateData('micr_crt', $data_arrrup, array('lnid' => $lnid));
        }

//LOAN CURRENT AGE UPDATE
        $restX = $this->Generic_model->updateData('micr_crleg', array('cage' => $cage), array('reid' => $reid,));

        $funcPerm = $this->Generic_model->getFuncPermision('rpymt_indv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Individual repayment add lid(' . $lnid . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }
    // End Repayment
    //
    // Credit voucher Print
    public function loan_dsbs()
    {
        // User Access Page Log         $this->Log_model->userLog('loan_dsbs');
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['stainfo'] = $this->Generic_model->getData('loan_stat', array('stid,stnm'), array('isac' => 1), '');

        $this->load->view('modules/user/loan_disbursement', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchCrdtVou()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('loan_dsbs');

        if ($funcPerm[0]->prnt == 1) {
            $prnt = "";
        } else {
            $prnt = "disabled";
        }
        if ($funcPerm[0]->rpnt == 1) {
            $rpnt = "";
        } else {
            $rpnt = "disabled";
        }
        $disabled = "disabled";

        $result = $this->User_model->get_crdvouDtils();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->lnid;
            $msg = '';
            if ($row->agno == '') {

                $vou_prnt = 'disabled';
            } else {

                if ($row->chmd == 1) {
                    if ($row->chpy == 0 && ($row->docg + $row->incg) > 0) {
                        $vou_prnt = 'disabled';
                        $msg = "Agreement printed,But document & insurance charges not paid ";
                    } else {
                        $vou_prnt = '';
                        $msg = "Voucher Print";
                    }
                } else {
                    $vou_prnt = '';
                    $msg = "Voucher Print";
                }
            }

            if ($row->cvpt == 1) {
                $md = " <span class='label label-success'> Paid </span> ";
                $option = "<button type='button' $rpnt  onclick='agReprint($auid)' class='btn  btn-default btn-condensed' title='Agreement Reprint' style='border-color: #00aaaa'><i class='fa fa-file-text' aria-hidden='true'></i></button> " .
                    "<button type='button' $disabled  $prnt   onclick='' class='btn  btn-default btn-condensed' title='Voucher Printed'><i class='fa fa-print' aria-hidden='true'></i></button> ";
                // "<button type='button' id='rej' $disabled " . $rej . " onclick='rejecLoan( );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else {
                $md = " <span class='label label-warning'> Pending </span> ";
                // AGREEMENT PRINTED
                if (!empty($row->agno)) {
                    $option = "<button type='button' $rpnt  onclick='agReprint($auid);' class='btn  btn-default btn-condensed ' title='Agreement Reprint' style='border-color: #00aaaa'><i class='fa fa-file-text' aria-hidden='true'></i></button> " .
                        "<button type='button'   $prnt  $vou_prnt  onclick='loanDisburs($auid);' class='btn  btn-default btn-condensed' title='$msg'><i class='fa fa-print' aria-hidden='true'></i></button> ";

                } else {  //AGREEMENT PENDING PRINT
                    $option = "<button type='button' $prnt onclick='agrmtprint($auid);' class='btn  btn-default btn-condensed ' title='Agreement Print'><i class='fa fa-file-text' aria-hidden='true'></i></button> " .
                        "<button type='button'   $prnt  $vou_prnt  onclick='loanDisburs($auid);' class='btn  btn-default btn-condensed' title='$msg'><i class='fa fa-print' aria-hidden='true'></i></button> ";
                }

                //$option = "<button type='button' $rpnt $agr_prnt onclick='agrmtprint($auid);' class='btn  btn-default btn-condensed ' title='Agreement Print'><i class='fa fa-file-text' aria-hidden='true'></i></button> " .
                //  "<button type='button'   $prnt  $vou_prnt  onclick='loanDisburs($auid);' class='btn  btn-default btn-condensed' title='$msg'><i class='fa fa-print' aria-hidden='true'></i></button> ";
                //  "<button type='button' id='rej' " . $rej . " onclick='rejecLoan($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $row->init; // cust name
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($row->loam, 2, '.', ',');
            $sub_arr[] = $row->noin . ' ' . $row->pymd;
            $sub_arr[] = $row->vuno;
            $sub_arr[] = $md;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_crdvou(),
            "recordsFiltered" => $this->User_model->count_filt_crdvou(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // Agrement print function
    function agrement_print()
    {
        $lnid = $this->input->post('lnid');

        // Genarate Agrement no ex -- AWDB1700001 -- BR,PR,YR,AGRNO
        $lndt = $this->Generic_model->getData('micr_crt', array('lnid', 'brco', 'prid'), array('lnid' => $lnid));

        $prdt = $this->Generic_model->getData('product', array('auid', 'prcd'), array('auid' => $lndt[0]->prid));

        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $lndt[0]->brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $this->db->select("agno");
        $this->db->from("micr_crt");
        $this->db->where('micr_crt.brco ', $lndt[0]->brco);
        $this->db->where('micr_crt.prid ', $lndt[0]->prid);

        $this->db->where('micr_crt.stat ', 5);
        $this->db->order_by('micr_crt.lnid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();


        $yr = date('y');
        if (count($data) == null) {
            $agno = $brcd . $prdt[0]->prcd . $yr . '00001';
        } else {
            $reno = $data[0]->agno;
            $aa1 = substr($reno, -5);

            //echo $aa1;
            $aa = (int)$aa1 + 1;
            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }
            $agno = $brcd . $prdt[0]->prcd . $yr . $xx;
        }

        // Agreement no update
        $result1 = $this->Generic_model->updateData('micr_crt', array('agno' => $agno), array('lnid' => $lnid));

        $funcPerm = $this->Generic_model->getFuncPermision('loan_dsbs');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Agreement print lid(' . $lnid . ')');

        if (count($result1) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // Agreement print PDF
    function agrmnt_print_pdf($lnid)
    {
        $lndt = $this->Generic_model->getData('micr_crt', array('apid', 'agno', 'prva'), array('lnid' => $lnid));
        $agno = $lndt[0]->agno;
        $prva = $lndt[0]->prva;
        $apid = $lndt[0]->apid;

        $cudt = $this->Generic_model->getData('cus_mas', array('funm', 'init', 'hoad', 'anic'), array('cuid' => $apid));

        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.lnpr,micr_crt.crdt,micr_crt.cvpt,micr_crt.agno, DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') AS cvdt,
        cus_mas.cuno,cus_mas.funm,cus_mas.init,cus_mas.anic,cus_mas.hoad,prdt_typ.pymd, b.binit,b.bhoad,b.banic,b.bmobi,b.bfunm, c.cinit,c.choad,c.canic,c.cmobi ,c.cfunm  ");
        $this->db->from("micr_crt");
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        // 1 granter
        $this->db->join("(SELECT b.cuid,b.cuno AS bcuno,b.init AS binit,b.hoad AS bhoad,b.mobi AS bmobi,b.anic AS banic,b.funm AS bfunm
         FROM cus_mas AS b) AS b", 'b.cuid = micr_crt.fsgi', 'left');
        // 2 granter
        $this->db->join("(SELECT c.cuid,c.cuno AS ccuno,c.init AS cinit,c.hoad AS choad,c.mobi AS cmobi,c.anic AS canic,c.funm AS cfunm
         FROM cus_mas AS c) AS c", 'c.cuid = micr_crt.segi', 'left');
        $this->db->where('micr_crt.lnid', $lnid);
        $query = $this->db->get();
        $data = $query->result();

        if ($data[0]->pymd == 'D') {
            $per = " Days";
        } elseif ($data[0]->pymd == 'W') {
            $per = " Weeks";
        } elseif ($data[0]->pymd == 'M') {
            $per = " Months";
        }

        // TOPUP LOAN
        if ($prva != 0) {

            $date = date('Y-m-d H:i:s');
            $dte = date('Y-m-d');
            if ($data[0]->cvdt == null) {
                $dte = $dte;
            } else {
                $dte = $data[0]->cvdt;
            }
            ob_start();
            $this->pdf->AddPage('P', 'A4');
            $this->pdf->Image('uploads/office_document/Agreement.jpg', 0, 0, 210, 297);

            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetFont('Helvetica', 'B', 9);
            $this->pdf->SetXY(-55, 8);
            $this->pdf->Cell(0, 0, 'Agreement No : ' . $agno);
            $this->pdf->SetFont('Helvetica', '', 9);

            // NO 1
            $this->pdf->SetXY(72, 28);
            $this->pdf->Cell(0, 0, $data[0]->hoad);
            $this->pdf->SetXY(63, 34);
            $this->pdf->Cell(0, 0, $data[0]->anic);
            $this->pdf->SetXY(110, 34);
            $this->pdf->Cell(0, 0, $data[0]->funm);
            $this->pdf->SetXY(98, 39.5);
            $this->pdf->Cell(0, 0, number_format($data[0]->loam, 2));
            $this->pdf->SetXY(40, 45.5);
            $this->pdf->Cell(0, 0, number_format($data[0]->inam, 2));
            $this->pdf->SetXY(115, 46);
            $this->pdf->Cell(0, 0, $data[0]->lnpr . ' ' . $per);
            $this->pdf->SetXY(40, 51.5);
            $this->pdf->Cell(0, 0, $dte);

            // NO 3
            $this->pdf->SetXY(65, 89);
            $this->pdf->Cell(0, 0, $data[0]->hoad);
            $this->pdf->SetXY(22, 95);
            $this->pdf->Cell(0, 0, $data[0]->funm);

            // GRANTER 01
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(25, 192);
            $this->pdf->Cell(0, 0, $data[0]->binit); /*binit bfunm */
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(30, 198);
            $this->pdf->Cell(0, 0, $data[0]->bhoad); /*$data[0]->bhoad*/
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(40, 204);
            $this->pdf->Cell(0, 0, $data[0]->banic);
            $this->pdf->SetXY(45, 210);
            $this->pdf->Cell(0, 0, $data[0]->bmobi);

            // GRANTER 02
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(115, 192);
            $this->pdf->Cell(0, 0, $data[0]->cinit); /*cinit  cfunm */
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(120, 198);
            $this->pdf->Cell(0, 0, $data[0]->choad); /*$data[0]->choad*/
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(130, 204);
            $this->pdf->Cell(0, 0, $data[0]->canic);
            $this->pdf->SetXY(135, 210);
            $this->pdf->Cell(0, 0, $data[0]->cmobi);

            // FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(10, 276);
            $this->pdf->Cell(0, 0, '(' . $agno . '|' . $date . '|' . $_SESSION['username'] . '|Topup)'); /* AGNO | DATE | USER */

            $this->pdf->SetTitle('Topup Agreement No  :' . $agno);
            $this->pdf->Output($agno . '.pdf', 'I');
            ob_end_flush();

        } else {

            $date = date('Y-m-d H:i:s');
            $dte = date('Y-m-d');
            if ($data[0]->cvdt == null) {
                $dte = $dte;
            } else {
                $dte = $data[0]->cvdt;
            }
            ob_start();
            $this->pdf->AddPage('P', 'A4');
            $this->pdf->SetMargins(10, 10, 10);
            $this->pdf->SetAuthor('www.gdcreations.com');
            $this->pdf->SetDisplayMode('default');

            $this->pdf->Image('uploads/office_document/Agreement.jpg', 0, 0, 210, 297);

            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetFont('Helvetica', 'B', 9);
            $this->pdf->SetXY(-55, 8);
            $this->pdf->Cell(0, 0, 'Agreement No : ' . $agno);
            $this->pdf->SetFont('Helvetica', '', 9);

            // NO 1
            $this->pdf->SetXY(72, 28);
            $this->pdf->Cell(0, 0, $data[0]->hoad);
            $this->pdf->SetXY(63, 34);
            $this->pdf->Cell(0, 0, $data[0]->anic);
            $this->pdf->SetXY(110, 34);
            $this->pdf->Cell(0, 0, $data[0]->funm);
            $this->pdf->SetXY(98, 39.5);
            $this->pdf->Cell(0, 0, number_format($data[0]->loam, 2));
            $this->pdf->SetXY(40, 45.5);
            $this->pdf->Cell(0, 0, number_format($data[0]->inam, 2));
            $this->pdf->SetXY(115, 46);
            $this->pdf->Cell(0, 0, $data[0]->lnpr . ' ' . $per);
            $this->pdf->SetXY(40, 51.5);
            $this->pdf->Cell(0, 0, $dte);

            // NO 3
            $this->pdf->SetXY(65, 89);
            $this->pdf->Cell(0, 0, $data[0]->hoad);
            $this->pdf->SetXY(22, 95);
            $this->pdf->Cell(0, 0, $data[0]->funm);

            // GRANTER 01
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(25, 192);
            $this->pdf->Cell(0, 0, $data[0]->binit); /*binit bfunm */
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(30, 198);
            $this->pdf->Cell(0, 0, $data[0]->bhoad); /*$data[0]->bhoad*/
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(40, 204);
            $this->pdf->Cell(0, 0, $data[0]->banic);
            $this->pdf->SetXY(45, 210);
            $this->pdf->Cell(0, 0, $data[0]->bmobi);

            // GRANTER 02
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(115, 192);
            $this->pdf->Cell(0, 0, $data[0]->cinit); /*cinit cfunm*/
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(120, 198);
            $this->pdf->Cell(0, 0, $data[0]->choad); /*$data[0]->choad*/
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(130, 204);
            $this->pdf->Cell(0, 0, $data[0]->canic);
            $this->pdf->SetXY(135, 210);
            $this->pdf->Cell(0, 0, $data[0]->cmobi);

            // FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(10, 276);
            $this->pdf->Cell(0, 0, '(' . $agno . '|' . $date . '|' . $_SESSION['username'] . ')'); /* AGNO | DATE | USER */


            $this->pdf->SetTitle('Agreement No  :' . $agno);
            $this->pdf->Output($agno . '.pdf', 'I');
            ob_end_flush();

        }
    }

    // CREDIT VOUCHER ISSUE  /  Loan Disbursement
    function vouch_issue()
    {
        $lnid = $this->input->post('lnid');
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->db->select("micr_crt.acno,micr_crt.brco,micr_crt.lnid,micr_crt.inam,micr_crt.loam,micr_crt.lntp,product.prcd,micr_crt.noin,cus_mas.cuid, brch_mas.brcd,brch_mas.brnm, 
        micr_crt.chmd,micr_crt.docg ,micr_crt.incg,micr_crt.prdtp,micr_crt.lnpr,
         cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.hoad,cus_mas.mobi,cen_mas.cnnm,prdt_typ.pymd,cus_sol.sode,aa.pmtp,
         micr_crt.prva, ( SELECT blam  FROM `topup_loans` WHERE stat = 1 AND tpnm = micr_crt.lnid) AS tpbal,");

        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        $this->db->join('product', 'product.auid = micr_crt.prid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->join("(SELECT a.lnid,b.pmtp
                FROM `micr_crt` AS a  
                JOIN voucher AS b ON b.void=a.vpno
                )AS aa ",
            'aa.lnid = micr_crt.lnid'); //customer pay type

        $this->db->where('micr_crt.lnid', $lnid);

        $query = $this->db->get();
        $lndt = $query->result();
        $tpbal = $lndt[0]->tpbal;

        // Genarate Voucher No
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $lndt[0]->brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;
        $this->db->select("vuno");
        $this->db->from("voucher");
        $this->db->where('voucher.brco ', $lndt[0]->brco);
        // $this->db->where('voucher.retp ', 2);
        $this->db->order_by('voucher.vuno', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $vuno = $brcd . '/VU/' . $yr . '/00001';
        } else {
            $reno = $data[0]->vuno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;

            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }
            $vuno = $brcd . '/VU/' . $yr . '/' . $xx;
        }
        // END Genarate Voucher No

        // CAL PYAEMENT AMOUNT
        if ($lndt[0]->prva != 0) {

            if ($lndt[0]->chmd == 2) {
                $pyamt = $lndt[0]->loam - ($tpbal + $lndt[0]->docg + $lndt[0]->incg);
            } else {
                $pyamt = $lndt[0]->loam - $tpbal;
            }
        } else {
            if ($lndt[0]->chmd == 2) {
                $pyamt = $lndt[0]->loam - ($lndt[0]->docg + $lndt[0]->incg);
            } else {
                $pyamt = $lndt[0]->loam;
            }
        }

        // PAYMENT MODE
        if ($lndt[0]->pmtp == 2 || $lndt[0]->pmtp == 8) {
            $pmtp = 8;
        } else {
            $pmtp = $lndt[0]->pmtp;
        }

        // insert data Voucher tb
        $data_arr = array(
            'brco' => $lndt[0]->brco,
            'vuno' => $vuno,
            'rfno' => $lndt[0]->acno, // loan id
            'rfid' => $lnid,
            'vuam' => $pyamt,
            'clid' => $lndt[0]->cuid, // cust id
            'pyac' => 111,
            'pynm' => $lndt[0]->sode . $lndt[0]->init,
            'pyad' => $lndt[0]->hoad,
            'pytp' => $lndt[0]->mobi,
            'stat' => 2,
            'mode' => 1,
            'pmtp' => $pmtp,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('voucher', $data_arr);

        // insert data vouc_des tb
        // get voucher last recode id
        $vudt = $this->Generic_model->getData('voucher', array('void'), array('vuno' => $vuno));
        $lstid = $vudt[0]->void;

        // total loan amount recode insert
        $data_arr2 = array(
            'vuno' => $vuno,
            'vuid' => $lstid, // voucher id
            'rfdc' => 'Payable Capital Consideration - ' . $lndt[0]->acno . ' (' . $lndt[0]->loam . ')',
            'rfdt' => date('Y-m-d'),
            'amut' => $lndt[0]->loam,
        );
        $result2 = $this->Generic_model->insertData('vouc_des', $data_arr2);
        if ($result2) {
            $chk = $chk + 1;
        }
        // check doc & insu debat form loan and it s insert recode
        if ($lndt[0]->chmd == 2) {
            $data_arr3 = array(
                'vuno' => $vuno,
                'vuid' => $lstid, // voucher id
                'rfdc' => 'Document Charges',
                'rfdt' => date('Y-m-d'),
                'amut' => '-' . $lndt[0]->docg,
            );
            $result3 = $this->Generic_model->insertData('vouc_des', $data_arr3);
            if ($result3) {
                $chk = $chk + 1;
            }
            $data_arr4 = array(
                'vuno' => $vuno,
                'vuid' => $lstid, // voucher id
                'rfdc' => 'Insurance Charges',
                'rfdt' => date('Y-m-d'),
                'amut' => '-' . $lndt[0]->incg,
            );
            $result4 = $this->Generic_model->insertData('vouc_des', $data_arr4);
            if ($result4) {
                $chk = $chk + 1;
            }
        } else {
            $chk = $chk + 2;
        }

// IF TOPUP LOAN RECODE
        if ($lndt[0]->prva != 0) {

            // OLD LOAN NO
            $lndtX = $this->Generic_model->getData('micr_crt', array('acno'), array('lnid' => $lndt[0]->prva));
            $acnoOld = $lndtX[0]->acno;

            $data_arr3 = array(
                'vuno' => $vuno,
                'vuid' => $lstid, // voucher id
                'rfdc' => 'Previous Loan Topup : ' . $acnoOld . ' | ' . date('Y-m-d'),
                'rfdt' => date('Y-m-d'),
                'amut' => '-' . $tpbal,
            );
            $result3 = $this->Generic_model->insertData('vouc_des', $data_arr3);
            if ($result3) {
                $chk = $chk + 1;
            }

        } else {
            $chk = $chk + 1;
        }


//MATURITY DATE AND NEXT RENTEL DATE
        /* http://snipplr.com/view/10958/ */
        $indt = $this->input->post('indtEdt');
        $date = date("Y-m-d");
        $nxdd = date("Y-m-d");
        $nxdd_dte = date("d");

        $prdtp = $lndt[0]->prdtp;
        $noin = $lndt[0]->noin;
        if ($prdtp == 3 || $prdtp == 6 || $prdtp == 9 || $prdtp == 12) {         // DL || DDL || IFD || DPD
            $holidayDates = $this->Generic_model->getData('sys_holdys', array('date'), array('stat' => 1, 'hdtp' => 1));
            $holidayDates = array_column($holidayDates, 'date');

            $count5WD = 0;
            // $temp = strtotime("2018-04-18 00:00:00"); //example as today is 2016-03-25
            /* Example link  --> https://stackoverflow.com/questions/36196606/php-add-5-working-days-to-current-date-excluding-weekends-sat-sun-and-excludin  */
            $temp = strtotime(date("Y-m-d"));

            while ($count5WD < $lndt[0]->lnpr) {
                $next1WD = strtotime('+1 weekday', $temp);
                $next1WDDate = date('Y-m-d', $next1WD);
                if (!in_array($next1WDDate, $holidayDates)) {
                    $count5WD++;
                }
                $temp = $next1WD;
            }
            $next5WD = date("Y-m-d", $temp);
            $madt = $next5WD;

            $count5WD2 = 0;
            $temp2 = strtotime(date("Y-m-d"));
            while ($count5WD2 < 1) {
                $next1WD2 = strtotime('+1 weekday', $temp2);
                $next1WDDate2 = date('Y-m-d', $next1WD2);
                if (!in_array($next1WDDate2, $holidayDates)) {
                    $count5WD2++;
                }
                $temp2 = $next1WD2;
            }
            $next5WD2 = date("Y-m-d", $temp2);
            $nxdd_n = $next5WD2;

            //var_dump($madt . '***'. $nxdd_n);
            //die();

        } else if ($prdtp == 4 || $prdtp == 7 || $prdtp == 10 || $prdtp == 13) {   // WK || DWK || IFW || DPW
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $noin . "week");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 week");
            $nxdd_n = date("Y-m-d", $nxdd);

        } else if ($prdtp == 5 || $prdtp == 8 || $prdtp == 11 || $prdtp == 14) {   // ML || DML || IFM || DPM
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $noin . "month");
            $madt = date("Y-m-d", $date);

            if ($nxdd_dte >= 29 && $nxdd_dte <= 31) {   // IF CHECK MONTH END DAY
                $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +2 month");
                $nxdd_n = date("Y-m", $nxdd) . '-01';
            } else {
                $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 month");
                $nxdd_n = date("Y-m-d", $nxdd);
            }
        }
        //echo $madt . ' ** ' .  $nxdd_n;
// END MATURITY DATE

// LOAN TB UPDATE
        // GET CUSTOMER LAST LOAN INDEX
        $vllndt = $this->Generic_model->getData('micr_crt', array('apid'), array('lnid' => $lnid));
        $lndx = $this->Generic_model->getSortData('micr_crt', array('lcnt'), array('apid' => $vllndt[0]->apid), 1, '', 'cvdt', 'desc');

        $data_ar1 = array(
            'stat' => 5,  // disbursment loan
            'cvpt' => 1,
            'cvdt' => date('Y-m-d H:i:s'),

            'madt' => $madt,
            'nxdd' => $nxdd_n,
            'lcnt' => $lndx[0]->lcnt + 1,
            //'pncs' => 1,
            'sydt' => date('Y-m-d H:i:s'),
        );
        $result1a = $this->Generic_model->updateData('micr_crt', $data_ar1, array('lnid' => $lnid));
        if ($result1a) {
            $chk = $chk + 1;
        }
        $ledt = date('Y-m-d H:i:s');
//MICRO LEG UPDATE
        // 1
        $result1b = $this->Generic_model->updateData('micr_crleg', array('ledt' => $ledt), "acid = '$lnid' AND dsid IN(1,8)");
        if ($result1b) {
            $chk = $chk + 1;
        }
        // 2 voucher no update
        $result2b = $this->Generic_model->updateData('micr_crleg', array('reno' => $vuno), "acid = '$lnid' AND dsid = 8");
        if ($result2b) {
            $chk = $chk + 1;
        }
//ACC LEG UPDATE
        //$result1 = $this->Generic_model->updateData('acc_leg', array('acdt' => $ledt), array('rfna' => $lndt[0]->acno, 'dcrp' => $lndt[0]->acno, 'trtp' => 'ACNT DIFN',));

// ACCOUNT LEDGE
// PAYMENT MODE
        if ($lndt[0]->pmtp == 2 || $lndt[0]->pmtp == 8) {   // GRUP CHQ/CASH/
            $spcd = 106;
            $acst = '(106) Cash Book';
        } else if ($lndt[0]->pmtp == 3 || $lndt[0]->pmtp == 4 || $lndt[0]->pmtp == 10) { // BANK TT/ONLINE PYMT/CUST CHQ
            $spcd = 107;
            $acst = '(107) Bank/Cash at Bank';
        } else {
            $spcd = 00;
            $acst = '(00) - -';
        }

        $data_aclg1 = array(
            'brno' => $lndt[0]->brco, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'LOAN DISB',
            'rfna' => $lndt[0]->acno,
            'dcrp' => 'LOAN DISB',
            'acco' => $spcd,    // cross acc code
            'spcd' => '111',    // split acc code
            'acst' => '(111) Loan Controller',
            'dbam' => $pyamt,
            'cram' => 0,
            'stat' => 0
        );
        $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);
        if ($result) {
            $chk = $chk + 1;
        }
        $data_aclg2 = array(
            'brno' => $lndt[0]->brco, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'LOAN DISB',
            'rfna' => $lndt[0]->acno,
            'dcrp' => 'LOAN DISB',
            'acco' => '111',    // cross acc code
            'spcd' => $spcd,    // split acc code
            'acst' => $acst,
            'dbam' => 0,
            'cram' => $pyamt,
            'stat' => 0
        );
        $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
        if ($re1) {
            $chk = $chk + 1;
        }

//RECEIPT UPDATE
        /* $result1 = $this->Generic_model->updateData('receipt', array('crdt' => $ledt), array('rfno' => $lnid, 'retp' => 1,));
         if ($result1) {
             $chk = $chk + 1;
         }
         $rcdt = $this->Generic_model->getData('receipt', array('reid'), array('rfno' => $lnid, 'retp' => 1));
         $reid = $rcdt[0]->reid;

         $result1 = $this->Generic_model->updateData('recp_des', array('rfdt' => $ledt), array('reid' => $reid));
         if ($result1) {
             $chk = $chk + 1;
         }*/

        $funcPerm = $this->Generic_model->getFuncPermision('loan_dsbs');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Voucher issuee lid (' . $lnid . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    // Credit Voucher PDF Print
    function credit_voucher($lnid)
    {
        $rcdt = $this->Generic_model->getData('voucher', array('pntc'), array('rfid' => $lnid));
        $pntc = $rcdt[0]->pntc;

        // IF CHECK VOUCHER TYPE SHOP VOUCHER OR NOT
        $this->db->select("voucher.vuno, voucher.mode, voucher.rfid");
        $this->db->from("micr_crt");
        $this->db->join('voucher', 'voucher.void = micr_crt.vpno ');
        $this->db->where('micr_crt.lnid', $lnid);
        $qur = $this->db->get();
        $rst = $qur->result();
        $mode = $rst[0]->mode;

        // UPDATE VOUCHER TB
        if ($pntc > 0) {
            $data_arr = array(
                'pntc' => $pntc + 1,
                'rpby' => $_SESSION['userId'],
                'rpdt' => date('Y-m-d H:i:s'),
            );
        } else {
            $data_arr = array(
                'pntc' => $pntc + 1,
                'prby' => $_SESSION['userId'],
                'prdt' => date('Y-m-d H:i:s'),
            );
        }
        $result1 = $this->Generic_model->updateData('voucher', $data_arr, array('rfid' => $lnid));

// GENARATE PDF
        $this->load->library('ciqrcode');
        $this->db->select("micr_crt.acno,micr_crt.brco,micr_crt.lnid,micr_crt.inam,micr_crt.loam,micr_crt.lntp,product.prcd,micr_crt.noin,micr_crt.stat AS lnst,cus_mas.cuid,cus_mas.grno, brch_mas.brnm,CONCAT(user_mas.fnme,' ' ,user_mas.lnme ) AS exc, 
            micr_crt.chmd,micr_crt.docg ,micr_crt.incg,micr_crt.agno, bnk_names.bknm, cus_mas.bkbr,cus_mas.acno AS bkacno,
            cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.hoad,cus_mas.mobi,cen_mas.cnnm,prdt_typ.pymd,cus_sol.sode ");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        $this->db->join('product', 'product.auid = micr_crt.prid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->join('bnk_names', 'bnk_names.bkid = cus_mas.bkid', 'left');
        $this->db->where('micr_crt.lnid', $lnid);
        $query = $this->db->get();
        $data = $query->result();

        $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
        $usr = $usedetails[0]->fnme;
        $comdt = $this->Generic_model->getData('com_det', array('cmne'), array('stat' => 1));
        $branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brco));
        $vudt = $this->Generic_model->getSortData('voucher', '', array('rfid' => $lnid, 'stat' => 2), '', '', 'rfid', 'desc');
        $vucr = $this->Generic_model->getData('user_mas', '', array('auid' => $vudt[0]->crby));
        $vuds_dt = $this->Generic_model->getData('vouc_des', '', array('vuid' => $vudt[0]->void));
        $pydt = $this->Generic_model->getData('pay_terms', '', array('tmid' => $vudt[0]->pmtp));

        //var_dump($vuds_dt);

        $_SESSION['hid'] = mt_rand(10000000, 999999999);
        $cy = date('Y');
        $date = date('Y-m-d H:i:s');

        if ($mode == 5) {     // SHOP VOUCHER PRINT
            $shpdt = $this->Generic_model->getData('shop_mas', array('spnm', 'addr', 'mobi', 'emil', 'tele'), array('spid' => $rst[0]->rfid));

            ob_start();
            $this->pdf->AddPage('L', 'A5');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, 'SHOP VOUCHER', 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $branc[0]->brad);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, "Tel : " . $branc[0]->brtp);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, "Fax : " . $branc[0]->brfx);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, "E-mail : " . $branc[0]->brem);
            $this->pdf->SetXY(5.5, 30);
            $this->pdf->Cell(0, 0, "Web : " . $branc[0]->brwb);

            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 8);

            $this->pdf->SetFont('Helvetica', 'B', 8);

            $this->pdf->SetXY(16, 41);
            $this->pdf->Cell(1, 0, 'SHOP NAME : ' . $shpdt[0]->spnm, 0, 1, 'L');

            $this->pdf->SetXY(16, 45);
            $this->pdf->Cell(1, 0, 'ADDRESS : ' . $shpdt[0]->addr, 0, 1, 'L');

            $this->pdf->SetXY(16.5, 49);
            $this->pdf->Cell(1, 0, 'EMAIL   : ' . $shpdt[0]->emil, 0, 1, 'L');

            $this->pdf->SetXY(16, 53);
            $this->pdf->Cell(1, 0, 'TELEPHONE : ' . $shpdt[0]->tele, 0, 1, 'L');


            /* $c1 = strlen($data[0]->hoad . ' - ' . $data[0]->mobi);
             if ($c1 > 60) {
                 $this->pdf->SetXY(34, 55);
                 $this->pdf->MultiCell(100, 3.5, $data[0]->hoad . ' - ' . $data[0]->mobi, '0', 'L', FALSE);
             } else {
                 $this->pdf->SetXY(34, 57);
                 $this->pdf->Cell(1, 0, $data[0]->hoad . ' - ' . $data[0]->mobi, 0, 1, 'L');
             }*/

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(135, 41);
            $this->pdf->Cell(1, 0, 'VOUCHER NO', 0, 1, 'L');
            $this->pdf->SetXY(135, 45);
            $this->pdf->Cell(1, 0, 'VOUCHER DATE : ' . $vudt[0]->crdt, 0, 1, 'L');
            $this->pdf->SetXY(135, 49);
            $this->pdf->Cell(1, 0, 'BRANCH', 0, 1, 'L');
            $this->pdf->SetXY(135, 53);
            $this->pdf->Cell(1, 0, 'CENTER', 0, 1, 'L');
            $this->pdf->SetXY(135, 57);
            $this->pdf->Cell(1, 0, 'PAY MODE', 0, 1, 'L');
            $this->pdf->SetXY(135, 61);
            $this->pdf->Cell(1, 0, 'AGREEMENT NO', 0, 1, 'L');

            $this->pdf->SetXY(158.5, 41);
            $this->pdf->Cell(1, 0, ': ' . $vudt[0]->vuno, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 49);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->brnm, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 53);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->cnnm, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 57);
            $this->pdf->Cell(1, 0, ': ' . $pydt[0]->tem_name, 0, 1, 'L');
            $this->pdf->SetXY(157.8, 61);
            $this->pdf->Cell(1, 0, ' : ' . $data[0]->agno, 0, 1, 'L');


            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(15, 37);
            $this->pdf->Cell(180, 35, '', '1');

            // Payment details table border
            $this->pdf->SetXY(15, 65);
            $this->pdf->Cell(15, 40, '', '1');
            $this->pdf->SetXY(30, 65);
            $this->pdf->Cell(130, 40, '', '1');
            $this->pdf->SetXY(160, 65);
            $this->pdf->Cell(35, 40, '', '1');

            // #0
            $this->pdf->SetXY(15, 65);
            $this->pdf->Cell(15, 7, 'NO', 1, 1, 'C');
            $this->pdf->SetXY(15, 65);
            $this->pdf->Cell(145, 7, 'CUSTOMER DETAILS', 1, 1, 'C');
            $this->pdf->SetXY(160, 65);
            $this->pdf->Cell(35, 7, 'AMOUNT', 1, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($vuds_dt);

            $y = 76;
            $pyamt = 0;
            $this->pdf->SetXY(15, 76);
            $this->pdf->Cell(15, 0, 1, '0', '', 'C');
            $this->pdf->SetXY(30, 76);
            $this->pdf->Cell(130, 0, 'Name : ' . $data[0]->init, '0');
            $this->pdf->SetXY(160, 76);
            $this->pdf->Cell(35, 0, number_format($vudt[0]->vuam, 2, '.', ','), '0', '', 'R');

            $this->pdf->SetXY(30, 81);
            $this->pdf->Cell(130, 0, 'Address : ' . $data[0]->hoad, '0');
            $this->pdf->SetXY(30, 86);
            $this->pdf->Cell(130, 0, 'Mobile : ' . $data[0]->mobi . ' | NIC ' . $data[0]->anic, '0');

            $y = $y + 5;
            $pyamt = $pyamt + $vudt[0]->vuam;

            /*for ($i = 0; $i < $len; $i++) {
                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(15, 0, $i + 1, '0', '', 'C');
                $this->pdf->SetXY(30, $y);
                $this->pdf->Cell(130, 0, $vuds_dt[$i]->rfdc, '0');
                $this->pdf->SetXY(160, $y);
                $this->pdf->Cell(35, 0, number_format($vuds_dt[$i]->amut, 2, '.', ','), '0', '', 'R');
                $y = $y + 5;
                $pyamt = $pyamt + $vuds_dt[$i]->amut;
            }*/

            // # BANK DETAILS
            // IF BANK TT & ONLINE TRANSFER
            if ($vudt[0]->pmtp == 3 || $vudt[0]->pmtp == 4) {
                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetDash(); //restores no dash
                $this->pdf->SetXY(30, -55);
                $this->pdf->Cell(130, 0, 'BANK DETAILS', '0');
                $this->pdf->Line(30, -55, 160, -55);

                $this->pdf->SetFont('Helvetica', '', 8);
                $this->pdf->SetXY(30, -52);
                $this->pdf->Cell(50, 0, 'Bank Name : ' . $data[0]->bknm, '0');
                $this->pdf->SetXY(80, -52);
                $this->pdf->Cell(50, 0, 'Branch : ' . $data[0]->bkbr, '0');
                $this->pdf->SetXY(30, -48);
                $this->pdf->Cell(50, 0, 'Account No : ' . $data[0]->bkacno, '0');

                $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
                $this->pdf->SetTextColor(0, 0, 0);

            } else if ($vudt[0]->pmtp == 10) {       // IF CUSTOMER CHQ

                $this->db->select("chq_issu.cqno ,bnk_names.bknm");
                $this->db->from("micr_crt");
                $this->db->join('chq_issu', 'chq_issu.vuid = micr_crt.vpno');
                $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid');
                $this->db->join('bnk_names', 'bnk_names.bkid = bnk_accunt.bkid');
                $this->db->where('micr_crt.lnid', $lnid);
                $query = $this->db->get();
                $cqdt = $query->result();

                $x = (-50);
                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetDash(); //restores no dash
                $this->pdf->SetXY(30, -52);
                $this->pdf->Cell(130, 0, 'BANK DETAILS', '0');
                $this->pdf->Line(30, $x, 160, $x);

                $this->pdf->SetFont('Helvetica', '', 8);
                $this->pdf->SetXY(30, -48);
                $this->pdf->Cell(50, 0, 'Chq Bank : ' . $cqdt[0]->bknm, '0');
                $this->pdf->SetXY(80, -48);
                $this->pdf->Cell(50, 0, 'Chq No : ' . $cqdt[0]->cqno, '0');

                $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
                $this->pdf->SetTextColor(0, 0, 0);
            }

            //-----TOTAL AMOUNT--------//
            $this->pdf->SetXY(160, 105);
            $this->pdf->Cell(35, 8, '', '1');
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(154, 105);
            $this->pdf->Cell(6, 10, 'TOTAL AMOUNT', 0, 1, 'R');
            $this->pdf->SetXY(160, 110);
            $this->pdf->Cell(35, 0, number_format($pyamt, 2, '.', ','), '0', '', 'R');


            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(5, 111);
            $this->pdf->Cell(0, 0, 'Prepared By : ' . $vucr[0]->fnme . ' | ' . $vudt[0]->crdt);
            $this->pdf->SetXY(5, 118);
            $this->pdf->Cell(0, 0, 'Approved By : .....................................');
            $this->pdf->SetXY(75, 111);
            $this->pdf->Cell(0, 0, 'NIC / Passport : ....................................');
            $this->pdf->SetXY(75, 118);
            $this->pdf->Cell(0, 0, 'Received By : .......................................');


            // FOOTER
            // REPRINT TAG
            $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
            if ($policy[0]->post == 1) {
                if ($rcdt[0]->pntc > 0) {
                    $this->pdf->SetFont('Helvetica', 'B', 7);
                    $this->pdf->SetXY(-15, 114);
                    $this->pdf->Cell(10, 6, 'RE-PRINTED (' . $pntc . ')', 0, 1, 'R');
                }
            }
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 118);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 122);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 122);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');


            //$pdf->SetXY(142,138);
            //$pdf->Cell(0,0,'Signature : .........................................');
            $this->pdf->SetFont('', 'B', '10');
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->SetXY(184, 105);

            $this->pdf->SetFont('Helvetica', '', 25);
            $this->pdf->SetXY(20, 132.5);
            $this->pdf->Cell(75, 14, $data[0]->cuno, 1, 1, 'C');

            $this->pdf->SetXY(120, 132.5);
            $this->pdf->Cell(70, 14, $data[0]->agno, 1, 1, 'C');

            //DOT LINE SEPARATE
            $this->pdf->SetLineWidth(0.1);
            $this->pdf->SetDash(3, 2); //5mm on, 5mm off
            $this->pdf->Line(0, 130, 210, 130);

            //QR CODE
            $cd = 'Vou No : ' . $vudt[0]->vuno . ' | GEN VOU NO : ' . $rst[0]->vuno . ' | Date : ' . $vudt[0]->crdt . ' | Customer : ' . $data[0]->sode . " " . $data[0]->init . ' | Branch : ' . $data[0]->brnm . ' | Center : ' . $data[0]->cnnm . ' | Pay Type : SHOP VOUCHER | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('Credit Voucher - ' . $vudt[0]->vuno);
            $this->pdf->Output('Credit_voucher_' . $vudt[0]->vuno . '.pdf', 'I');
            ob_end_flush();

        } else {

            ob_start();
            $this->pdf->AddPage('L', 'A5');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, 'CREDIT VOUCHER', 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $branc[0]->brad);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, "Tel : " . $branc[0]->brtp);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, "Fax : " . $branc[0]->brfx);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, "E-mail : " . $branc[0]->brem);
            $this->pdf->SetXY(5.5, 30);
            $this->pdf->Cell(0, 0, "Web : " . $branc[0]->brwb);

            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 8);


            $this->pdf->SetXY(16, 53);
            $this->pdf->Cell(1, 0, 'CUSTOMER : ' . $data[0]->sode . " " . $data[0]->init, 0, 1, 'L');

            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(16, 45);
            $this->pdf->Cell(1, 0, 'CUST NO : ' . $data[0]->cuno, 0, 1, 'L');

            $this->pdf->SetXY(16.5, 49);
            $this->pdf->Cell(1, 0, 'REF NO   : ' . $data[0]->anic, 0, 1, 'L');

            $c1 = strlen($data[0]->hoad . ' - ' . $data[0]->mobi);
            if ($c1 > 60) {
                $this->pdf->SetXY(34, 55);
                $this->pdf->MultiCell(100, 3.5, $data[0]->hoad . ' - ' . $data[0]->mobi, '0', 'L', FALSE);
            } else {
                $this->pdf->SetXY(34, 57);
                $this->pdf->Cell(1, 0, $data[0]->hoad . ' - ' . $data[0]->mobi, 0, 1, 'L');
            }

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(135, 41);
            $this->pdf->Cell(1, 0, 'VOUCHER NO', 0, 1, 'L');
            $this->pdf->SetXY(135, 45);
            $this->pdf->Cell(1, 0, 'VOUCHER DATE : ' . $vudt[0]->crdt, 0, 1, 'L');
            $this->pdf->SetXY(135, 49);
            $this->pdf->Cell(1, 0, 'BRANCH', 0, 1, 'L');
            $this->pdf->SetXY(135, 53);
            $this->pdf->Cell(1, 0, 'CENTER', 0, 1, 'L');
            $this->pdf->SetXY(135, 57);
            $this->pdf->Cell(1, 0, 'PAY MODE', 0, 1, 'L');
            $this->pdf->SetXY(135, 61);
            $this->pdf->Cell(1, 0, 'AGREEMENT NO', 0, 1, 'L');

            $this->pdf->SetXY(158.5, 41);
            $this->pdf->Cell(1, 0, ': ' . $vudt[0]->vuno, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 49);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->brnm, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 53);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->cnnm, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 57);
            $this->pdf->Cell(1, 0, ': ' . $pydt[0]->tem_name, 0, 1, 'L');
            $this->pdf->SetXY(157.8, 61);
            $this->pdf->Cell(1, 0, ' : ' . $data[0]->agno, 0, 1, 'L');


            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(15, 37);
            $this->pdf->Cell(180, 35, '', '1');

            // Payment details table border
            $this->pdf->SetXY(15, 65);
            $this->pdf->Cell(15, 40, '', '1');
            $this->pdf->SetXY(30, 65);
            $this->pdf->Cell(130, 40, '', '1');
            $this->pdf->SetXY(160, 65);
            $this->pdf->Cell(35, 40, '', '1');

            // #0
            $this->pdf->SetXY(15, 65);
            $this->pdf->Cell(15, 7, 'BILL NO', 1, 1, 'C');
            $this->pdf->SetXY(15, 65);
            $this->pdf->Cell(145, 7, 'PAYMENT DESCRIPTION', 1, 1, 'C');
            $this->pdf->SetXY(160, 65);
            $this->pdf->Cell(35, 7, 'AMOUNT', 1, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($vuds_dt);

            $y = 76;
            $pyamt = 0;
            for ($i = 0; $i < $len; $i++) {

                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(15, 0, $i + 1, '0', '', 'C');
                $this->pdf->SetXY(30, $y);
                $this->pdf->Cell(130, 0, $vuds_dt[$i]->rfdc, '0');
                $this->pdf->SetXY(160, $y);
                $this->pdf->Cell(35, 0, number_format($vuds_dt[$i]->amut, 2, '.', ','), '0', '', 'R');
                $y = $y + 5;
                $pyamt = $pyamt + $vuds_dt[$i]->amut;
            }

            // # BANK DETAILS
            // IF BANK TT & ONLINE TRANSFER
            if ($vudt[0]->pmtp == 3 || $vudt[0]->pmtp == 4) {
                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetDash(); //restores no dash
                $this->pdf->SetXY(30, -55);
                $this->pdf->Cell(130, 0, 'BANK DETAILS', '0');
                $this->pdf->Line(30, -55, 160, -55);

                $this->pdf->SetFont('Helvetica', '', 8);
                $this->pdf->SetXY(30, -52);
                $this->pdf->Cell(50, 0, 'Bank Name : ' . $data[0]->bknm, '0');
                $this->pdf->SetXY(80, -52);
                $this->pdf->Cell(50, 0, 'Branch : ' . $data[0]->bkbr, '0');
                $this->pdf->SetXY(30, -48);
                $this->pdf->Cell(50, 0, 'Account No : ' . $data[0]->bkacno, '0');

                $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
                $this->pdf->SetTextColor(0, 0, 0);

            } else if ($vudt[0]->pmtp == 10) {       // IF CUSTOMER CHQ

                $this->db->select("chq_issu.cqno ,bnk_names.bknm");
                $this->db->from("micr_crt");
                $this->db->join('chq_issu', 'chq_issu.vuid = micr_crt.vpno');
                $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid');
                $this->db->join('bnk_names', 'bnk_names.bkid = bnk_accunt.bkid');
                $this->db->where('micr_crt.lnid', $lnid);
                $query = $this->db->get();
                $cqdt = $query->result();

                $x = (-50);
                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->SetDash(); //restores no dash
                $this->pdf->SetXY(30, -52);
                $this->pdf->Cell(130, 0, 'BANK DETAILS', '0');
                $this->pdf->Line(30, $x, 160, $x);

                $this->pdf->SetFont('Helvetica', '', 8);
                $this->pdf->SetXY(30, -48);
                $this->pdf->Cell(50, 0, 'Chq Bank : ' . $cqdt[0]->bknm, '0');
                $this->pdf->SetXY(80, -48);
                $this->pdf->Cell(50, 0, 'Chq No : ' . $cqdt[0]->cqno, '0');

                $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
                $this->pdf->SetTextColor(0, 0, 0);
            }

            //-----TOTAL AMOUNT--------//
            $this->pdf->SetXY(160, 105);
            $this->pdf->Cell(35, 8, '', '1');
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(154, 105);
            $this->pdf->Cell(6, 10, 'TOTAL AMOUNT', 0, 1, 'R');
            $this->pdf->SetXY(160, 110);
            $this->pdf->Cell(35, 0, number_format($pyamt, 2, '.', ','), '0', '', 'R');


            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(5, 111);
            $this->pdf->Cell(0, 0, 'Prepared By : ' . $vucr[0]->fnme . ' | ' . $vudt[0]->crdt);
            $this->pdf->SetXY(5, 118);
            $this->pdf->Cell(0, 0, 'Approved By : .....................................');
            $this->pdf->SetXY(75, 111);
            $this->pdf->Cell(0, 0, 'NIC / Passport : ....................................');
            $this->pdf->SetXY(75, 118);
            $this->pdf->Cell(0, 0, 'Received By : .......................................');


            // FOOTER
            // REPRINT TAG
            $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
            if ($policy[0]->post == 1) {
                if ($rcdt[0]->pntc > 0) {
                    $this->pdf->SetFont('Helvetica', 'B', 7);
                    $this->pdf->SetXY(-15, 114);
                    $this->pdf->Cell(10, 6, 'RE-PRINTED (' . $pntc . ')', 0, 1, 'R');
                }
            }
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 118);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 122);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 122);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');


            //$pdf->SetXY(142,138);
            //$pdf->Cell(0,0,'Signature : .........................................');
            $this->pdf->SetFont('', 'B', '10');
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->SetXY(184, 105);

            $this->pdf->SetFont('Helvetica', '', 25);
            $this->pdf->SetXY(20, 132.5);
            $this->pdf->Cell(75, 14, $data[0]->cuno, 1, 1, 'C');

            $this->pdf->SetXY(120, 132.5);
            $this->pdf->Cell(70, 14, $data[0]->agno, 1, 1, 'C');

            //DOT LINE SEPARATE
            $this->pdf->SetLineWidth(0.1);
            $this->pdf->SetDash(3, 2); //5mm on, 5mm off
            $this->pdf->Line(0, 130, 210, 130);

            //QR CODE
            $cd = 'Vou No : ' . $vudt[0]->vuno . ' | Date : ' . $vudt[0]->crdt . ' | Customer : ' . $data[0]->sode . " " . $data[0]->init . ' | Branch : ' . $data[0]->brnm . ' | Center : ' . $data[0]->cnnm . ' | Pay Type : CASH | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('Credit Voucher - ' . $vudt[0]->vuno);
            $this->pdf->Output('Credit_voucher_' . $vudt[0]->vuno . '.pdf', 'I');
            ob_end_flush();

        }


        $funcPerm = $this->Generic_model->getFuncPermision('loan_dsbs');
        if ($pntc > 0) {    // PRINT COUNT > 0 = REPRINT
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Credit voucher Reprint lid (' . $lnid . ')');
        } else {
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Credit voucher Print lid (' . $lnid . ')');
        }

    }
    // End credit voucher PDF
    //
    // Group Voucher
    function vou_grup()
    {
        // User Access Page Log     $this->Log_model->userLog('vou_grup');
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        //$data['payinfo'] = $this->Generic_model->getData('pay_terms', '', array('stat' => 1, 'tmid != 4'));
        $data['bnkinfo'] = $this->Generic_model->getData('bnk_names', '', array('stat' => 1));

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('vou_grup');

        $this->load->view('modules/user/voucher_group', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function getGrupVouc()
    {
        //$userlvl = $this->Generic_model->getData('user_mas', array('auid', 'usmd'), array('auid' => $_SESSION['userId']));

        $result = $this->User_model->get_grupVou();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {

            // IF TOPUP LOAN
            if ($row->prva != 0) {

                $tp = "<span class='label label-info' title='Topup Loan'>T</span>";
                if ($row->chmd == 2) {
                    $pyd = $row->loam - ($row->tpbal + $row->docg + $row->incg);
                } else {
                    $pyd = $row->loam - $row->tpbal;
                }
            } else {
                $tp = '';
                if ($row->chmd == 2) {
                    $pyd = $row->loam - ($row->docg + $row->incg);
                } else {
                    $pyd = $row->loam;
                }
            }


            $opt = "<label class=''><input type='checkbox' name='amt[" . $i . "]' id='amt[" . $i . "]' value='" . $pyd . "'  onclick='calTotal($row->lnid,this.value);loadPytyp($row->cuid)' class='icheckbox' /> </label>";
            $lonid = "<input  type='hidden' value='$row->lnid'   name='lnid[" . $i . "]' id='lnid[" . $i . "]'>";
            $cuid = "<input  type='hidden' value='$row->cuid'   name='cuid[" . $i . "]' id='cuid[" . $i . "]'>";
            $bkdt = "<input  type='hidden' value='$row->bkdt'   name='bkdt[" . $i . "]' id='bkdt[" . $i . "]'>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $row->init; // cust name
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->acno . ' ' . $tp;

            $sub_arr[] = $row->prtp;
            $sub_arr[] = number_format($row->docg, 2, '.', ',');
            $sub_arr[] = number_format($row->incg, 2, '.', ',');
            $sub_arr[] = number_format($row->loam, 2, '.', ',');
            $sub_arr[] = number_format($pyd, 2, '.', ',');
            $sub_arr[] = $opt . $lonid . $cuid . $bkdt;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_grupvou(),
            "recordsFiltered" => $this->User_model->count_filt_grupvou(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // LOAD PAYMENT TYPE
    function getPayType()
    {
        $tcunt = $this->input->post('tcunt');
        $cuid = $this->input->post('cuid');
        $bkdt = $this->input->post('bkdt');

        $this->db->select("");
        $this->db->from("pay_terms");
        $this->db->where('pay_terms.stat', 1);
        if ($tcunt == 1) {
            if ($bkdt == 1) {
                $this->db->where('pay_terms.tmid IN(3,6,7,8,10,12)');
            } else {
                $this->db->where('pay_terms.tmid IN(6,7,8,10,12)');
            }
        } else if ($tcunt > 1) {
            $this->db->where('pay_terms.tmid IN(2,4,12)');
        } else {

        }
        $this->db->order_by('pay_terms.tem_name', 'ASC');
        $data['pytp'] = $this->db->get()->result();

        if ($tcunt == 1) {
            $data['cudt'] = $this->Generic_model->getData('cus_mas', array('init', 'mobi', 'anic', 'acno'), array('cuid' => $cuid));
        }

        echo json_encode($data);
    }

    // in cash group voucher
    function addGroupVou()
    {
        $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
        $brco = $this->input->post('brnch');

        // Genarate Voucher No
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;
        $this->db->select("vuno");
        $this->db->from("voucher");
        $this->db->where('voucher.brco ', $brco);
        $this->db->order_by('voucher.vuno', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $vuno = $brcd . '/VU/' . $yr . '/00001';
        } else {
            $reno = $data[0]->vuno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;

            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }

            $vuno = $brcd . '/VU/' . $yr . '/' . $xx;
        }
        // END Genarate Voucher No


        $pytp = $this->input->post('pytp');

        // SHOP VOUCHER
        if ($pytp == 12) {
            $rfid = $this->input->post('shpnm');
            $mode = 5;  // SHOP VOUCHER
        } else {
            $rfid = 0;  // SHOP ID
            $mode = 2;  // IN CASH VOUCHER
        }

        // insert data Voucher tb
        $data_arr = array(
            'brco' => $brco,
            'vuno' => $vuno,
            'rfid' => $rfid,
            'vuam' => $this->input->post('ttlamt'),
            'clid' => $this->input->post('cuid'), // cust id
            'pynm' => $this->input->post('pynm'),
            'pytp' => $this->input->post('pycn'),
            'stat' => 1,
            'mode' => $mode,
            'pmtp' => $pytp,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('voucher', $data_arr);

        // insert data vouc_des tb
        // get voucher last recode id
        $vudt = $this->Generic_model->getData('voucher', array('void'), array('vuno' => $vuno));
        $lstid = $vudt[0]->void;

        if ($pytp == 2 || $pytp == 10) {
            $cqno = $this->input->post('cqno');
        } else {
            $cqno = 0;
        }

        // total loan amount recode insert
        $data_arr2 = array(
            'vuno' => $vuno,
            'vuid' => $lstid, // voucher id
            //'mode' => $this->input->post('pytp'),
            'rfco' => $cqno,
            'rfdc' => 'Payable In cash Group',
            'rfdt' => date('Y-m-d'),
            'amut' => $this->input->post('ttlamt'),
        );
        $result2 = $this->Generic_model->insertData('vouc_des', $data_arr2);

        // IF payment mode cheq -> chq_issu tb data update
        $auid = $this->input->post('cqno');
        $pytp = $this->input->post('pytp');
        if ($pytp == 2 || $pytp == 10) {
            $data_arr3 = array(
                'brco' => $brco,
                //'cqno' => $this->input->post('cqno'),   // chq no
                //'accid' => $this->input->post('bkac'),   // bank account id
                'bkac' => 0,
                'cqdt' => $this->input->post('chdt'),   // chq date
                'cqam' => $this->input->post('ttlamt'), // chq amount
                'efdt' => $this->input->post('pydt'),   // pay date

                'isdt' => date('Y-m-d'),         // create date
                'isui' => $_SESSION['userId'],          // create by
                'vuid' => $lstid,                       // voucher no
                'rfno' => $lstid,                       // voucher id

                'cqst' => 2,
                'cqpn' => $this->input->post('chpynm'),
                'chmd' => 1,
                'stat' => 0,
            );
            $where_arr = array(
                'cqid' => $auid
            );
            //$result22 = $this->Generic_model->updateData('chq_book', $data_ar1, $where_arr);
            $result3 = $this->Generic_model->updateData('chq_issu', $data_arr3, $where_arr);

            // CHQ BOOK UPDATE
            $cqdt = $this->Generic_model->getData('chq_issu', array('cqbk'), array('cqid' => $auid));
            $cqbkdt = $this->Generic_model->getData('chq_book', array('nfis'), array('cqid' => $cqdt[0]->cqbk));

            $data_arr7 = array(
                'nfis' => $cqbkdt[0]->nfis + 1,         // no of issu chq
                'lsis' => $auid,                        // last isuu chq id
                'liby' => $_SESSION['userId'],          // last isuu by
                'lidt' => date('Y-m-d'),         // last isuu date
            );
            $where_arr7 = array(
                'cqid' => $cqdt[0]->cqbk
            );
            $result3 = $this->Generic_model->updateData('chq_book', $data_arr7, $where_arr7);

        } else if ($pytp == 3 || $pytp == 4) {     // BANK TRANSFER || ONLINE TRANSFER TYPE
            $data_ar3 = array(
                'brco' => $brco,
                'accid' => $this->input->post('bknm_onl'),   // bank account id
                'tuid' => $this->input->post('cuid'),   // trnsed user id
                'trac' => $this->input->post('pyac'),   //  transfer acc
                'trdt' => $this->input->post('pydt'),   //  date
                'tram' => $this->input->post('ttlamt'), //  amount

                'vuid' => $lstid,                       // voucher no
                'rfno' => $this->input->post('rfno'),   // referance no
                'chmd' => 1,
                'trtp' => $this->input->post('pytp'),
                'stat' => 0,
                'crby' => $_SESSION['userId'],          // create by
                'crdt' => date('Y-m-d H:i:s'),         // create date
            );
            $result2 = $this->Generic_model->insertData('onl_trns', $data_ar3);
        }

        $len = $this->input->post("len");
        $siz = sizeof($this->input->post("amt[]"));

        $lpcnt = 0;
        for ($a = 0; $a < $len; $a++) {
            if ($this->input->post("amt[" . $a . "]") == 0) {
            } else {
                // Incash group voucher id update loan table
                $data_ar1 = array(
                    'vpno' => $lstid,
                );
                $result1 = $this->Generic_model->updateData('micr_crt', $data_ar1, array('lnid' => $this->input->post("lnid[" . $a . "]")));
                $lpcnt = $lpcnt + 1;
            }
        }

        $funcPerm = $this->Generic_model->getFuncPermision('vou_grup');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Group voucher add vuno(' . $vuno . ')');

        if ($lpcnt == $siz) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // load bank account details
    function getBankaccnt()
    {
        $bkid = $this->input->post('bkid');
        $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
        $brco = $usedetails[0]->brch;

        $bkac = $this->Generic_model->getData('bnk_accunt', array('acno', 'acnm', 'acid'), array('bkid' => $bkid, 'brco' => $brco));

        echo json_encode($bkac);
    }

    // VOUCHER  (Genaral Voucher , Group in cash voucher AND Others)
    function vouc()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['payinfo'] = $this->Generic_model->getData('pay_terms', '', array('stat' => 1));

        $data['chrtaccinfo'] = $this->Generic_model->getData('accu_chrt', '', array('stat' => 1, 'acid' => 5));
        //$data['bkacinfo'] = $this->Generic_model->getData('bnk_accunt', '', array('stat' => 1));

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('vouc');

        $this->load->view('modules/user/voucher', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchVou()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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
        if ($funcPerm[0]->prnt == 1) {
            $prnt1 = "";
        } else {
            $prnt1 = "disabled";
        }
        $disabled = "disabled";

        $result = $this->User_model->get_vou();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->void;

            if ($row->mode == 1) {          // Credit voucher
                $md = "<span class='label label-default' title='Credit Voucher'>CREDIT</span>";
                $app = "disabled";
            } elseif ($row->mode == 2) {    // incash group voucher
                $md = "<span class='label label-default' title='Incash Voucher'>IN CASH</span>";
                $app = "";
            } else if ($row->mode == 3) {   // general voucher
                $md = "<span class='label label-default' title='General Voucher'>GENERAL</span>";
                $app = "";
            } else if ($row->mode == 4) {   // gift voucher
                $md = "<span class='label label-default' title='General Voucher'>GIFT</span>";
                $app = "disabled";
            } else if ($row->mode == 5) {   // shop voucher
                $md = "<span class='label label-default' title='Shop Voucher'>SHOP VOUCHER</span>";
                $app = "";
            }

            if ($row->pntc > 0) {
                $rp = "";
                $pr = "hidden";
            } else {
                $rp = "hidden";
                $pr = "";
            }

            if ($row->stat == 1) {
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app  id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' disabled $prnt1 data-toggle='modal'  onclick='vouPrint($auid,$row->mode);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' disabled $prnt1 data-toggle='modal'  onclick='vouReprint($auid,$row->mode,$row->rfid);' class='btn btn-default btn-condensed $rp' title='Reprint'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej  onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } elseif ($row->stat == 2) {  // if main statues approval
                $stat = "<span class='label label-success'> Approval</span> ";
                $app2 = "disabled";

                if ($row->prby == 0) {  // if credit voucher print or not
                    $prnt = "";
                } else {
                    $prnt = "disabled";
                }
                if ($row->chst == 1 && $row->cpnt == 0) {  // if cheq print or not
                    $rej2 = "";
                } else if ($row->chst == 2 && $row->cpnt == 1) {
                    $rej2 = "";
                } else {
                    $rej2 = "disabled";
                }

                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app $app2 id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' $prnt1 $prnt data-toggle='modal'  onclick='vouPrint($auid,$row->mode);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' $prnt1 data-toggle='modal'  onclick='vouReprint($auid,$row->mode,$row->rfid);' class='btn btn-default btn-condensed $rp' title='Reprint' style='border-color: #00aaaa'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej $rej2 onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 0) {
                $stat = "<span class='label label-danger'> Reject </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled id='app' data-toggle='modal' onclick='vouPrint($auid);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled id='app' data-toggle='modal' onclick='vouPrint($auid);' class='btn btn-default btn-condensed $rp' title='Reprint'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->vcrdt;
            $sub_arr[] = $row->vuno;
            $sub_arr[] = $row->pynm; // cust name
            $sub_arr[] = $md;
            $sub_arr[] = $row->tem_name;
            $sub_arr[] = number_format($row->vuam, 2, '.', ',');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_vou(),
            "recordsFiltered" => $this->User_model->count_filt_vou(),
            "data" => $data,
        );
        echo json_encode($output);

    }

    // voucher view
    function vewVou()
    {
        $vuid = $this->input->post('vuid');

        $this->db->select("voucher.*,DATE_FORMAT(voucher.crdt, '%Y-%m-%d') AS vcrdt,  brch_mas.brnm ,pay_terms.tem_name ,vouc_des.rfdc,vouc_des.amut ,
        vouc_des.rfco, bnk_accunt.acnm,bnk_accunt.acno,chq_issu.cqno ,accu_chrt.hadr, aa.acno AS cuac,aa.bknm,aa.bkbr");
        $this->db->from("voucher");
        $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void');
        $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp');
        $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco');
        $this->db->join('accu_chrt', 'accu_chrt.idfr = voucher.pyac');

        $this->db->join('chq_issu', 'chq_issu.vuid = voucher.void', 'left');
        $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid', 'left');
        $this->db->join("(SELECT aa.cuid,aa.bkbr,aa.acno, b.bknm
            FROM `cus_mas` AS aa  
            JOIN bnk_names AS b ON b.bkid=aa.bkid
            )AS aa ",
            'aa.cuid = voucher.clid', 'left'); //customer bank details

        $this->db->where('voucher.void', $vuid);
        //$this->db->group_by('vuno');
        $query = $this->db->get();
        $data['vudt'] = $query->result();


        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.lnpr,micr_crt.crdt,micr_crt.docg,micr_crt.incg,micr_crt.chmd,
        cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg, cen_mas.cnnm ,brch_mas.brcd,user_mas.fnme,prdt_typ.prtp  ,
        micr_crt.prva, ( SELECT blam  FROM `topup_loans` WHERE stat = 1 AND tpnm = lnid) AS tpbal,");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->where('micr_crt.stat IN(2,5)');
        $this->db->where('micr_crt.vpno', $vuid);

        $query = $this->db->get();
        $data['lndt'] = $query->result();


        echo json_encode($data);
    }

    // voucher approval
    function vouApprvl()
    {
        $vuid = $this->input->post('vuid');
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_ar1 = array(
            'stat' => 2,
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vuid));
        if ($result1) {
            $chk = $chk + 1;
        }

        $voudt = $this->Generic_model->getData('voucher', '', array('void' => $vuid));
        $accdt = $this->Generic_model->getData('accu_chrt', array('idfr', 'hadr'), array('idfr' => $voudt[0]->pyac));


        if ($voudt[0]->mode == 3) {         // IF GENERAL VOUCHER

            if ($voudt[0]->pmtp == 8) {     // CASH PAYMENT TYPE

                // ACCOUNT LEDGE
                $data_aclg1 = array(
                    'brno' => $voudt[0]->brco, // BRANCH ID
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'Voucher',
                    'trid' => 10,
                    'rfna' => $voudt[0]->vuno,
                    'dcrp' => 'Voucher payment ',
                    'acco' => 106,    // cross acc code
                    'spcd' => $voudt[0]->pyac,    // split acc code
                    'acst' => '(' . $voudt[0]->pyac . ') ' . $accdt[0]->hadr,
                    'dbam' => $voudt[0]->vuam,
                    'cram' => 0,
                    'stat' => 0
                );
                $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);
                if ($result) {
                    $chk = $chk + 1;
                }

                $data_aclg2 = array(
                    'brno' => $voudt[0]->brco, // BRANCH ID
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'Voucher',
                    'trid' => 10,
                    'rfna' => $voudt[0]->vuno,
                    'dcrp' => 'Voucher payment ',
                    'acco' => $voudt[0]->pyac,    // cross acc code
                    'spcd' => '106',    // split acc code
                    'acst' => '(106) Cash Book',
                    'dbam' => 0,
                    'cram' => $voudt[0]->vuam,
                    'stat' => 0
                );
                $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
                if ($re1) {
                    $chk = $chk + 1;
                }

            } else if ($voudt[0]->pmtp == 2 || $voudt[0]->pmtp == 3 || $voudt[0]->pmtp == 4) {  // BANK PAYMENT TYPE

                // ACCOUNT LEDGE
                $data_aclg1 = array(
                    'brno' => $voudt[0]->brco, // BRANCH ID
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'Voucher',
                    'trid' => 10,
                    'rfna' => $voudt[0]->vuno,
                    'dcrp' => 'vouc chk approval ',
                    'acco' => 209,    // cross acc code
                    'spcd' => $voudt[0]->pyac,    // split acc code
                    'acst' => '(' . $voudt[0]->pyac . ') ' . $accdt[0]->hadr,
                    'dbam' => $voudt[0]->vuam,
                    'cram' => 0,
                    'stat' => 0
                );
                $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);
                if ($result) {
                    $chk = $chk + 1;
                }

                $data_aclg2 = array(
                    'brno' => $voudt[0]->brco, // BRANCH ID
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'Voucher',
                    'trid' => 10,
                    'rfna' => $voudt[0]->vuno,
                    'dcrp' => 'vouc chk approval ',
                    'acco' => $voudt[0]->pyac,    // cross acc code
                    'spcd' => '209',    // split acc code
                    'acst' => '(209) payable payment',
                    'dbam' => 0,
                    'cram' => $voudt[0]->vuam,
                    'stat' => 0
                );
                $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
                if ($re1) {
                    $chk = $chk + 1;
                }

            } else {
            }
        } else {
            $chk = $chk + 2;
        }
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'voucher approval ');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    // IN CASH GROUP VOUCHER PRINT
    function vouPrint($vuid)
    {
        $rcdt = $this->Generic_model->getData('voucher', array('pntc'), array('void' => $vuid));
        $pntc = $rcdt[0]->pntc + 1;

        // PRINT COUNT UPDATE VOUCHER TB
        $data_ar1 = array(
            'prby' => $_SESSION['userId'],
            'prdt' => date('Y-m-d H:i:s'),
            'pntc' => $pntc,
        );
        $result1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vuid));

        $lndt = $this->Generic_model->getData('micr_crt', array('lnid', 'vpno', 'stat'), array('vpno' => $vuid));
        $siz = sizeof($lndt);
        $a = 0;

        // MICRO CART UPDATED GROUP VU NO
        if ($siz > 0) {
            for ($i = 0; $i < $siz; $i++) {
                $data_ar1 = array(
                    'vupd' => 1,
                    'vpdt' => date('Y-m-d H:i:s'),
                );
                $this->Generic_model->updateData('micr_crt', $data_ar1, array('lnid' => $lndt[$i]->lnid));
                $a = $a + 1;
            }
        }

        // VOUCHER PDF GENARATED
        if (count($result1) > 0 && $a == $siz) {

            $this->load->library('ciqrcode');
            $this->db->select("voucher.*,vouc_des.rfdc,brch_mas.brnm,user_mas.fnme,pay_terms.dsnm, CONCAT(accu_chrt.idfr,' (',accu_chrt.hadr,')') AS acc ,
                                bnk_accunt.acnm,bnk_accunt.acno,chq_issu.cqno ,aa.acno AS cuac,aa.bknm,aa.bkbr ");
            $this->db->from("voucher");
            $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco ');
            $this->db->join('user_mas', 'user_mas.auid = voucher.crby ');
            $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void ');
            $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp ');
            $this->db->join('accu_chrt', 'accu_chrt.idfr = voucher.pyac', 'left');

            $this->db->join('chq_issu', 'chq_issu.vuid = voucher.void', 'left');
            $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid', 'left');
            $this->db->join("(SELECT aa.cuid,aa.bkbr,aa.acno, b.bknm
            FROM `cus_mas` AS aa  
            JOIN bnk_names AS b ON b.bkid=aa.bkid
            )AS aa ",
                'aa.cuid = voucher.clid', 'left'); //customer bank details


            $this->db->where('voucher.void', $vuid);
            $this->db->group_by('vuno');

            $query = $this->db->get();
            $data = $query->result();

            $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
            $usr = $usedetails[0]->fnme;

            $comdt = $this->Generic_model->getData('com_det', array('cmne'), array('stat' => 1));
            $branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brco));

            $_SESSION['hid'] = mt_rand(10000000, 999999999);
            $cy = date('Y');
            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf->AddPage('L', 'A5');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, 'GROUP VOUCHER PAYMENT ', 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $branc[0]->brad);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, "Tel : " . $branc[0]->brtp);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, "Fax : " . $branc[0]->brfx);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, "E-mail : " . $branc[0]->brem);
            $this->pdf->SetXY(5.5, 30);
            $this->pdf->Cell(0, 0, "Web : " . $branc[0]->brwb);

            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 8);

            $this->pdf->SetXY(16, 45);
            $this->pdf->Cell(1, 0, 'PAYEE NAME : ' . $data[0]->pynm, 0, 1, 'L');
            /*$this->pdf->SetFont('Helvetica', '', 8);*/
            $this->pdf->SetXY(16, 49);
            $this->pdf->Cell(1, 0, 'PAY TYPE : ' . $data[0]->dsnm, 0, 1, 'L');
            $this->pdf->SetXY(16, 53);

            if ($data[0]->pmtp == 2 || $data[0]->pmtp == 10) {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . $data[0]->acnm . '(' . $data[0]->acno . ') Chq no ' . $data[0]->cqno, 0, 1, 'L');

            } else if ($data[0]->pmtp == 3 || $data[0]->pmtp == 4) {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . $data[0]->bknm . '(' . $data[0]->bkbr . ' Branch) Acc no ' . $data[0]->cuac, 0, 1, 'L');

            } else {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . '-', 0, 1, 'L');
            }

            /*if (response['vudt'][i]['pmtp'] == '2') {
                document.getElementById("bkdt").innerHTML = response['vudt'][i]['acnm'] + '  (' + response['vudt'][i]['acno'] + ')<br>'
                    + 'Chq No ' + response['vudt'][i]['cqno'];
            } else {
                document.getElementById("bkdt").innerHTML = '-';
            }*/

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(135, 45);
            $this->pdf->Cell(1, 0, 'VOUCHER NO', 0, 1, 'L');
            $this->pdf->SetXY(135, 49);
            $this->pdf->Cell(1, 0, 'VOUCHER DATE : ' . $data[0]->crdt, 0, 1, 'L');
            $this->pdf->SetXY(135, 53);
            $this->pdf->Cell(1, 0, 'BRANCH', 0, 1, 'L');
            $this->pdf->SetXY(158.5, 45);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->vuno, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 53);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->brnm, 0, 1, 'L');


            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(15, 37);
            $this->pdf->Cell(180, 30, '', '1');

            // Payment details table border
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(15, 50, '', '1');
            $this->pdf->SetXY(30, 60);
            $this->pdf->Cell(70, 50, '', '1');
            $this->pdf->SetXY(100, 60);
            $this->pdf->Cell(70, 50, '', '1');

            $this->pdf->SetXY(170, 60);
            $this->pdf->Cell(25, 50, '', '1');

            // #0
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(15, 7, 'BILL NO', 1, 1, 'C');
            $this->pdf->SetXY(30, 60);
            $this->pdf->Cell(70, 7, 'PAYMENT DESCRIPTION', 1, 1, 'C');
            $this->pdf->SetXY(100, 60);
            $this->pdf->Cell(70, 7, 'ACCOUNT NAME', 1, 1, 'C');
            $this->pdf->SetXY(170, 60);
            $this->pdf->Cell(25, 7, 'AMOUNT', 1, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($data);

            $y = 70;
            $pyamt = 0;
            for ($i = 0; $i < $len; $i++) {
                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(15, 0, $i + 1, '0', '', 'C');
                $this->pdf->SetXY(30, $y);
                $this->pdf->Cell(70, 0, $data[$i]->rfdc, '0');
                $this->pdf->SetXY(100, $y);
                $this->pdf->Cell(70, 0, $data[$i]->acc, 'C');
                $this->pdf->SetXY(170, $y);
                $this->pdf->Cell(25, 0, number_format($data[$i]->vuam, 2, '.', ','), '0', '', 'R');
                $y = $y + 5;
                $pyamt = $pyamt + $data[$i]->vuam;
            }


            //-----TOTAL AMOUNT--------//
            $this->pdf->SetXY(170, 110);
            $this->pdf->Cell(25, 8, '', '1');
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(154, 110);
            $this->pdf->Cell(6, 10, 'TOTAL AMOUNT', 0, 1, 'R');
            $this->pdf->SetXY(170, 114);
            $this->pdf->Cell(25, 0, number_format($pyamt, 2, '.', ','), '0', '', 'R');
            $this->pdf->SetAutoPageBreak(false);


            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(5, 121);
            $this->pdf->Cell(0, 0, 'Prepared By : ' . $data[0]->fnme . ' | ' . $data[0]->crdt);
            $this->pdf->SetXY(5, 128);
            $this->pdf->Cell(0, 0, 'Approved By      : .....................................');
            $this->pdf->SetXY(75, 121);
            $this->pdf->Cell(0, 0, 'NIC / Passport   : ....................................');
            $this->pdf->SetXY(75, 128);
            $this->pdf->Cell(0, 0, 'Received By      : .......................................');
            $this->pdf->SetXY(75, 135);
            $this->pdf->Cell(0, 0, 'Signature        : .......................................');

            //FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 135);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 140);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 140);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');

            // REPRINT TAG
            $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
            if ($policy[0]->post == 1) {
                if ($rcdt[0]->pntc > 1) {
                    $this->pdf->SetFont('Helvetica', 'B', 7);
                    $this->pdf->SetXY(4, 140);
                    $this->pdf->Cell(0, 0, 'REPRINTED (' . $pntc . ')');
                }
            }

            //QR CODE
            $cd = 'Vou No : ' . $data[0]->vuno . ' | Date : ' . $data[0]->crdt . ' | Payee Name : ' . $data[0]->pynm . ' | Branch : ' . $data[0]->brnm . ' | Pay Type : ' . $data[0]->dsnm . ' | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('Group Voucher - ' . $data[0]->vuno);
            $this->pdf->Output('Group_voucher _' . $data[0]->vuno . '.pdf', 'I');
            ob_end_flush();

        } else {
            echo json_encode(false);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Group voucher print vuno(' . $data[0]->vuno . ')');
    }

    // General Voucher Print
    function genVouPrint($vuid)
    {
        $rcdt = $this->Generic_model->getData('voucher', array('pntc'), array('void' => $vuid));
        $pntc = $rcdt[0]->pntc + 1;

        // PRINT COUNT UPDATE VOUCHER TB
        if (($pntc - 1) > 0) {
            $data_ar1 = array(
                'rpby' => $_SESSION['userId'],
                'rpdt' => date('Y-m-d H:i:s'),
                'pntc' => $pntc,
            );
        } else {
            $data_ar1 = array(
                'prby' => $_SESSION['userId'],
                'prdt' => date('Y-m-d H:i:s'),
                'pntc' => $pntc,
            );
        }

        $result1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vuid));

        $lndt = $this->Generic_model->getData('micr_crt', array('lnid', 'vpno', 'stat'), array('vpno' => $vuid));

        if (count($result1) > 0) {
            $this->load->library('ciqrcode');
            $this->db->select("voucher.*,vouc_des.amut,vouc_des.rfdc,brch_mas.brnm,user_mas.fnme,pay_terms.dsnm, CONCAT(accu_chrt.idfr,' (',accu_chrt.hadr,')') AS acc,
                        bnk_accunt.acnm,bnk_accunt.acno,chq_issu.cqno");
            $this->db->from("voucher");
            $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco ');
            $this->db->join('user_mas', 'user_mas.auid = voucher.crby ');
            $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void ');
            $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp ');
            $this->db->join('accu_chrt', 'accu_chrt.idfr = voucher.pyac', 'left');

            $this->db->join('chq_issu', 'chq_issu.vuid = voucher.void', 'left');
            $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid', 'left');

            $this->db->where('voucher.void', $vuid);
            $query = $this->db->get();
            $data = $query->result();

            $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
            $usr = $usedetails[0]->fnme;

            $comdt = $this->Generic_model->getData('com_det', array('cmne'), array('stat' => 1));
            $branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brco));

            $_SESSION['hid'] = mt_rand(10000000, 999999999);
            $cy = date('Y');
            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf->AddPage('L', 'A5');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, 'GENERAL VOUCHER', 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $branc[0]->brad);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, "Tel : " . $branc[0]->brtp);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, "Fax : " . $branc[0]->brfx);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, "E-mail : " . $branc[0]->brem);
            $this->pdf->SetXY(5.5, 30);
            $this->pdf->Cell(0, 0, "Web : " . $branc[0]->brwb);

            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 8);

            $this->pdf->SetXY(16, 45);
            $this->pdf->Cell(1, 0, 'PAYEE NAME : ' . $data[0]->pynm, 0, 1, 'L');
            /*$this->pdf->SetFont('Helvetica', '', 8);*/
            $this->pdf->SetXY(16, 49);
            $this->pdf->Cell(1, 0, 'PAY TYPE : ' . $data[0]->dsnm, 0, 1, 'L');
            $this->pdf->SetXY(16, 53);

            if ($data[0]->pmtp == 2) {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . $data[0]->acnm . ' (' . $data[0]->acno . ') Chq no ' . $data[0]->cqno, 0, 1, 'L');
            } else {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . '-', 0, 1, 'L');
            }

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(135, 45);
            $this->pdf->Cell(1, 0, 'VOUCHER NO', 0, 1, 'L');
            $this->pdf->SetXY(135, 49);
            $this->pdf->Cell(1, 0, 'VOUCHER DATE : ' . $data[0]->crdt, 0, 1, 'L');
            $this->pdf->SetXY(135, 53);
            $this->pdf->Cell(1, 0, 'BRANCH', 0, 1, 'L');
            $this->pdf->SetXY(158.5, 45);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->vuno, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 53);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->brnm, 0, 1, 'L');

            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(15, 37);
            $this->pdf->Cell(180, 30, '', '1');

            // Payment details table border
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(15, 50, '', '1');
            $this->pdf->SetXY(30, 60);
            $this->pdf->Cell(70, 50, '', '1');
            $this->pdf->SetXY(100, 60);
            $this->pdf->Cell(70, 50, '', '1');

            $this->pdf->SetXY(170, 60);
            $this->pdf->Cell(25, 50, '', '1');

            // #0
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(15, 7, 'BILL NO', 1, 1, 'C');
            $this->pdf->SetXY(30, 60);
            $this->pdf->Cell(70, 7, 'PAYMENT DESCRIPTION', 1, 1, 'C');
            $this->pdf->SetXY(100, 60);
            $this->pdf->Cell(70, 7, 'ACCOUNT NAME', 1, 1, 'C');
            $this->pdf->SetXY(170, 60);
            $this->pdf->Cell(25, 7, 'AMOUNT', 1, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($data);

            $y = 70;
            $pyamt = 0;
            for ($i = 0; $i < $len; $i++) {
                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(15, 0, $i + 1, '0', '', 'C');
                $this->pdf->SetXY(30, $y);
                $this->pdf->Cell(70, 0, $data[$i]->rfdc, '0');
                $this->pdf->SetXY(100, $y);
                $this->pdf->Cell(70, 0, $data[$i]->acc, 'C');
                $this->pdf->SetXY(170, $y);
                $this->pdf->Cell(25, 0, number_format($data[$i]->amut, 2, '.', ','), '0', '', 'R');
                $y = $y + 5;
                $pyamt = $pyamt + $data[$i]->amut;
            }


            //-----TOTAL AMOUNT--------//
            $this->pdf->SetXY(170, 110);
            $this->pdf->Cell(25, 8, '', '1');
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(154, 110);
            $this->pdf->Cell(6, 10, 'TOTAL AMOUNT', 0, 1, 'R');
            $this->pdf->SetXY(170, 114);
            $this->pdf->Cell(25, 0, number_format($pyamt, 2, '.', ','), '0', '', 'R');
            $this->pdf->SetAutoPageBreak(false);


            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(5, 121);
            $this->pdf->Cell(0, 0, 'Prepared By : ' . $data[0]->fnme . ' | ' . $data[0]->crdt);
            $this->pdf->SetXY(5, 128);
            $this->pdf->Cell(0, 0, 'Approved By      : .....................................');
            $this->pdf->SetXY(75, 121);
            $this->pdf->Cell(0, 0, 'NIC / Passport   : ....................................');
            $this->pdf->SetXY(75, 128);
            $this->pdf->Cell(0, 0, 'Received By      : .......................................');
            $this->pdf->SetXY(75, 135);
            $this->pdf->Cell(0, 0, 'Signature        : .......................................');

            //FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 135);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 140);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 140);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');

            // REPRINT TAG
            $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
            if ($policy[0]->post == 1) {
                if ($rcdt[0]->pntc > 1) {
                    $this->pdf->SetFont('Helvetica', 'B', 7);
                    $this->pdf->SetXY(4, 140);
                    $this->pdf->Cell(0, 0, 'REPRINTED (' . $pntc . ')');
                }
            }

            //QR CODE
            $cd = 'Vou No : ' . $data[0]->vuno . ' | Date : ' . $data[0]->crdt . ' | Payee Name : ' . $data[0]->pynm . ' | Branch : ' . $data[0]->brnm . ' | Pay Type : ' . $data[0]->dsnm . ' | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('General Voucher - ' . $data[0]->vuno);
            $this->pdf->Output('General_voucher_' . $data[0]->vuno . '.pdf', 'I');
            ob_end_flush();

        } else {
            echo json_encode(false);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'general voucher print (' . $data[0]->vuno . ')');

    }

    // Shop Voucher Print
    function shopVouPrint($vuid)
    {
        $rcdt = $this->Generic_model->getData('voucher', array('pntc'), array('void' => $vuid));
        $pntc = $rcdt[0]->pntc + 1;

        // PRINT COUNT UPDATE VOUCHER TB
        if (($pntc - 1) > 0) {
            $data_ar1 = array(
                'rpby' => $_SESSION['userId'],
                'rpdt' => date('Y-m-d H:i:s'),
                'pntc' => $pntc,
            );
        } else {
            $data_ar1 = array(
                'prby' => $_SESSION['userId'],
                'prdt' => date('Y-m-d H:i:s'),
                'pntc' => $pntc,
            );
        }

        $result1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vuid));

        $lndt = $this->Generic_model->getData('micr_crt', array('lnid', 'vpno', 'stat'), array('vpno' => $vuid));

        if (count($result1) > 0) {

            $this->load->library('ciqrcode');
            $this->db->select("voucher.*,vouc_des.amut,vouc_des.rfdc,brch_mas.brnm,user_mas.fnme,pay_terms.dsnm, CONCAT(accu_chrt.idfr,' (',accu_chrt.hadr,')') AS acc,
                        shop_mas.spcd, shop_mas.spnm, shop_mas.addr, shop_mas.mobi, shop_mas.emil, shop_mas.tele");
            $this->db->from("voucher");
            $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco ');
            $this->db->join('user_mas', 'user_mas.auid = voucher.crby ');
            $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void ');
            $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp ');
            $this->db->join('accu_chrt', 'accu_chrt.idfr = voucher.pyac', 'left');

            $this->db->join('shop_mas', 'shop_mas.spid = voucher.rfid', 'left');
            //$this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid', 'left');

            $this->db->where('voucher.void', $vuid);
            $query = $this->db->get();
            $data = $query->result();

            // VOUCHER CUSTOMER
            $this->db->select("cus_mas.init, cus_mas.hoad,cus_mas.mobi, cus_mas.anic, micr_crt.acno, micr_crt.loam, micr_crt.chmd, micr_crt.docg, micr_crt.incg  ");
            $this->db->from("micr_crt");
            $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
            $this->db->where('micr_crt.vpno', $vuid);
            $query = $this->db->get();
            $rest = $query->result();

            $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
            $usr = $usedetails[0]->fnme;

            $comdt = $this->Generic_model->getData('com_det', array('cmne'), array('stat' => 1));
            $branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brco));

            $_SESSION['hid'] = mt_rand(10000000, 999999999);
            $cy = date('Y');
            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf->AddPage('P', 'A4');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, 'SHOP GENERAL VOUCHER', 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $branc[0]->brad);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, "Tel : " . $branc[0]->brtp);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, "Fax : " . $branc[0]->brfx);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, "E-mail : " . $branc[0]->brem);
            $this->pdf->SetXY(5.5, 30);
            $this->pdf->Cell(0, 0, "Web : " . $branc[0]->brwb);

            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(16, 41);
            $this->pdf->Cell(1, 0, 'SHOP DETAILS ', 0, 1, 'L');
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(16, 45);
            $this->pdf->Cell(1, 0, $data[0]->spnm, 0, 1, 'L');
            $this->pdf->SetXY(16, 49);
            $this->pdf->Cell(1, 0, $data[0]->addr, 0, 1, 'L');
            $this->pdf->SetXY(16, 53);
            $this->pdf->Cell(1, 0, $data[0]->emil . ' | ' . $data[0]->tele, 0, 1, 'L');
            $this->pdf->SetXY(16, 53);


            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(145, 41);
            $this->pdf->Cell(1, 0, 'VOUCHER DETAILS', 0, 1, 'L');
            $this->pdf->SetXY(145, 45);
            $this->pdf->Cell(1, 0, 'NO', 0, 1, 'L');
            $this->pdf->SetXY(145, 49);
            $this->pdf->Cell(1, 0, 'DATE : ', 0, 1, 'L');
            $this->pdf->SetXY(145, 53);
            $this->pdf->Cell(1, 0, 'BRANCH', 0, 1, 'L');
            $this->pdf->SetXY(158.5, 45);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->vuno, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 49);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->crdt, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 53);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->brnm, 0, 1, 'L');

            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(5, 37);
            $this->pdf->Cell(200, 30, '', '1');

            // Payment details table border
            $this->pdf->SetXY(5, 60);
            $this->pdf->Cell(10, 180, '', '1');
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(40, 180, '', '1');
            $this->pdf->SetXY(55, 60);
            $this->pdf->Cell(60, 180, '', '1');
            $this->pdf->SetXY(115, 60);
            $this->pdf->Cell(20, 180, '', '1');
            $this->pdf->SetXY(135, 60);
            $this->pdf->Cell(20, 180, '', '1');
            $this->pdf->SetXY(155, 60);
            $this->pdf->Cell(20, 180, '', '1');
            $this->pdf->SetXY(175, 60);
            $this->pdf->Cell(30, 180, '', '1');

            // #0
            $this->pdf->SetXY(5, 60);
            $this->pdf->Cell(10, 7, 'NO', 1, 1, 'C');
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(40, 7, 'CUSTOMER NAME', 1, 1, 'C');
            $this->pdf->SetXY(55, 60);
            $this->pdf->Cell(60, 7, 'ADDRESS', 1, 1, 'C');
            $this->pdf->SetXY(115, 60);
            $this->pdf->Cell(20, 7, 'NIC', 1, 1, 'C');
            $this->pdf->SetXY(135, 60);
            $this->pdf->Cell(20, 7, 'PHONE', 1, 1, 'C');
            $this->pdf->SetXY(155, 60);
            $this->pdf->Cell(20, 7, 'AMOUNT', 1, 1, 'C');
            $this->pdf->SetXY(175, 60);
            $this->pdf->Cell(30, 7, 'SIGNATURE', 1, 1, 'C');


            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($rest);

            $y = 70;
            $pyamt = 0;
            for ($i = 0; $i < $len; $i++) {
                if ($rest[$i]->chmd == 2) {
                    $amt = $rest[$i]->loam - ($rest[$i]->docg + $rest[$i]->incg);
                } else {
                    $amt = $rest[$i]->loam;
                }
                $this->pdf->SetXY(5, $y);
                $this->pdf->Cell(10, 3, $i + 1, 0, 0, 'C');
                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(40, 3, $rest[$i]->init, 'L');

                $cc1 = strlen($rest[$i]->hoad);
                if ($cc1 > 38) {
                    $this->pdf->SetXY(55, $y - 0.5);
                    $this->pdf->MultiCell(60, 3, $rest[$i]->hoad, '0', 'L', FALSE);
                } else {
                    $this->pdf->SetXY(55, $y);
                    $this->pdf->Cell(60, 3, $rest[$i]->hoad, 0, 1, 'L');
                }
                $this->pdf->SetXY(115, $y);
                $this->pdf->Cell(20, 3, $rest[$i]->anic, 0, 0, 'C');
                $this->pdf->SetXY(135, $y);
                $this->pdf->Cell(20, 3, $rest[$i]->mobi, 0, '', 'C');
                $this->pdf->SetXY(155, $y);
                $this->pdf->Cell(20, 3, number_format($amt, 2, '.', ','), 0, 0, 'R');
                $this->pdf->SetXY(175, $y);
                $this->pdf->Cell(25, 3, '', 'C');

                $y = $y + 5;
                $pyamt = $pyamt + $amt;
            }


            //-----TOTAL AMOUNT--------//
            $this->pdf->SetXY(155, 240);
            $this->pdf->Cell(20, 8, '', '1');
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(148, 240);
            $this->pdf->Cell(6, 10, 'TOTAL AMOUNT', 0, 1, 'R');
            $this->pdf->SetXY(150, 245);
            $this->pdf->Cell(25, 0, number_format($pyamt, 2, '.', ','), '0', '', 'R');
            $this->pdf->SetAutoPageBreak(false);


            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(5, 258);
            $this->pdf->Cell(0, 0, 'Prepared By : ' . $data[0]->fnme . ' | ' . $data[0]->crdt);
            $this->pdf->SetXY(5, 264);
            $this->pdf->Cell(0, 0, 'Approved By      : .....................................');
            $this->pdf->SetXY(75, 258);
            $this->pdf->Cell(0, 0, 'NIC / Passport   : ....................................');
            $this->pdf->SetXY(75, 264);
            $this->pdf->Cell(0, 0, 'Received By      : .......................................');
            $this->pdf->SetXY(75, 270);
            $this->pdf->Cell(0, 0, 'Signature        : .......................................');

            //FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 270);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 280);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 280);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');

            // REPRINT TAG
            $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
            if ($policy[0]->post == 1) {
                if ($rcdt[0]->pntc > 1) {
                    $this->pdf->SetFont('Helvetica', 'B', 7);
                    $this->pdf->SetXY(4, 280);
                    $this->pdf->Cell(0, 0, 'REPRINTED (' . $pntc . ')');
                }
            }

            //QR CODE
            $cd = 'Vou No : ' . $data[0]->vuno . ' | Date : ' . $data[0]->crdt . ' | Payee Name : ' . $data[0]->spnm . ' | Branch : ' . $data[0]->brnm . ' | Pay Type : ' . $data[0]->dsnm . ' | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('General Voucher - ' . $data[0]->vuno);
            $this->pdf->Output('General_voucher_' . $data[0]->vuno . '.pdf', 'I');
            ob_end_flush();

        } else {
            echo json_encode(false);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'general voucher print (' . $data[0]->vuno . ')');

    }

    // voucher reject
    function rejVou()
    {
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        // data remove in voucher table
        $vuid = $this->input->post('id');
        $data_ar1 = array(
            'stat' => 0,
            'trby' => $_SESSION['userId'],
            'trdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vuid));
        if ($result1) {
            $chk = $chk + 1;
        }
        // data remove in loan tb
        $lndt = $this->Generic_model->getData('micr_crt', array('lnid', 'vpno', 'stat'), array('vpno' => $vuid));
        $siz = sizeof($lndt);
        $a = 0;
        if ($siz > 0) {
            for ($i = 0; $i < $siz; $i++) {
                $this->Generic_model->updateData('micr_crt', array('vpno' => '0'), array('lnid' => $lndt[$i]->lnid));
                $a = $a + 1;
            }
        }
        if ($a == $siz) {
            $chk = $chk + 1;
        }

        // CHQ & BANK TT CANCEL
        $vudt = $this->Generic_model->getData('voucher', array('pmtp'), array('void' => $vuid));
        $pmtp = $vudt[0]->pmtp;
        // CHQ
        if ($pmtp == 2 || $pmtp == 10) {
            $data_ar1 = array(
                'vuid' => 0,
                'cqam' => 0,
                'rfno' => 0,
            );
            $result1 = $this->Generic_model->updateData('chq_issu', $data_ar1, array('vuid' => $vuid));
            if ($result1) {
                $chk = $chk + 1;
            }
        } else if ($pmtp == 3 || $pmtp == 4) {        // BANK TT & ONLINE
            $data_ar1 = array(
                'stat' => 2,
                'cnby' => $_SESSION['userId'],
                'cndt' => date('Y-m-d H:i:s'),
                'rmks' => 'Voucher Cancel',
            );
            $result1 = $this->Generic_model->updateData('onl_trns', $data_ar1, array('vuid' => $vuid));
            if ($result1) {
                $chk = $chk + 1;
            }
        } else {
            $chk = $chk + 1;
        }

        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'voucher reject vid(' . $vuid . ')');

        /* if ($chk == 3) {
             echo json_encode(true);
         } else {
             echo json_encode(false);
         }*/
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // add general voucher
    function addVoucher()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
        //$brco = $usedetails[0]->brch;
        $brco = $this->input->post('vubrn');

        // Genarate Voucher No
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;
        $this->db->select("vuno");
        $this->db->from("voucher");
        $this->db->where('voucher.brco ', $brco);
        $this->db->order_by('voucher.vuno', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $vuno = $brcd . '/VU/' . $yr . '/00001';
        } else {
            $reno = $data[0]->vuno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;

            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }
            $vuno = $brcd . '/VU/' . $yr . '/' . $xx;
        }
        // END Genarate Voucher No


        // PAY ACCOUNT - 8 CASH IN HAND / 1 CASH IN BANK
        $pyac = $this->input->post('pyac');
        if ($pyac == 8) {
            $pytp = 8;
            $rfco = 0;
        } elseif ($pyac == 1) {
            $pytp = $this->input->post('pymo');

            if ($pytp == 2) {       // iIF PAY TYPE 2 - CHEQ
                $rfco = $this->input->post('cqno');
            } else {
                $rfco = 0;
            }
        }

        // insert data Voucher tb
        $data_arr = array(
            'brco' => $brco,
            'vuno' => $vuno,
            'vuam' => $this->input->post('pyam'),
            'clid' => $_SESSION['userId'], // user id
            'pyac' => $this->input->post('acna'),
            'pynm' => $this->input->post('pyna'),
            'pyad' => $this->input->post('pyad'),
            'pytp' => $this->input->post('pyct'),
            'stat' => 1,
            'mode' => 3,
            'pmtp' => $pytp,        // PAY MODE
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('voucher', $data_arr);

        // insert data vouc_des tb
        // get voucher last recode id
        $vudt = $this->Generic_model->getData('voucher', array('void'), array('vuno' => $vuno));
        $lstid = $vudt[0]->void;

        $subamt = $this->input->post("subamt[]");
        $stnr = $this->input->post('stnr[]');
        $siz = sizeof($subamt);


        $en = 0;        // loping count
        for ($a = 0; $a < $siz; $a++) {
            // VOUCHER DISCRUPTION INSERT
            if ($subamt[$a] != '' || $subamt[$a] != 0) {
                $data_arr2 = array(
                    'vuno' => $vuno,
                    'vuid' => $lstid, // voucher id
                    'rfco' => $rfco,
                    'rfdc' => $stnr[$a],
                    'rfdt' => date('Y-m-d'),
                    'amut' => $subamt[$a],
                );
                $result2 = $this->Generic_model->insertData('vouc_des', $data_arr2);
            }
            $en++;
        }


        // IF payment mode cheq -> chq_issu tb data update
        if ($this->input->post('pymo') == 2) {

            $data_arr3 = array(
                'brco' => $brco,
                //'accid' => $this->input->post('baco'), // bank account id
                //'cqno' => $this->input->post('cqno'),  // chq no
                'bkac' => 0,
                'cqdt' => $this->input->post('cqdt'),   // chq date
                'cqam' => $this->input->post('pyam'),   // chq amount
                'efdt' => $this->input->post('efdt'),   // pay date

                'isdt' => date('Y-m-d'),         // create date
                'isui' => $_SESSION['userId'],          // create by
                'vuid' => $lstid,                       // voucher no
                'rfno' => $lstid,                       // voucher id

                'cqst' => 2,
                'actg' => $this->input->post('ectp'),
                'cqpn' => $this->input->post('cqpn'),
                'chmd' => 2,
                'stat' => 0,
            );
            $where_arr = array(
                'cqid' => $this->input->post('cqno')
            );
            $result3 = $this->Generic_model->updateData('chq_issu', $data_arr3, $where_arr);

            // CHQ BOOK UPDATE
            $cqdt = $this->Generic_model->getData('chq_issu', array('cqbk'), array('cqid' => $this->input->post('cqno')));
            $cqbkdt = $this->Generic_model->getData('chq_book', array('nfis'), array('cqid' => $cqdt[0]->cqbk));

            $data_arr7 = array(
                'nfis' => $cqbkdt[0]->nfis + 1,         // no of issu chq
                'lsis' => $this->input->post('cqno'),   // last isuu chq id
                'liby' => $_SESSION['userId'],          // last isuu by
                'lidt' => date('Y-m-d'),         // last isuu date
            );
            $where_arr7 = array(
                'cqid' => $cqdt[0]->cqbk
            );
            $result3 = $this->Generic_model->updateData('chq_book', $data_arr7, $where_arr7);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'general voucher add (' . $vuno . ')');


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }
    // END VOUCHER
    //
    // All cheque approval and print
    function chqu()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['payinfo'] = $this->Generic_model->getData('pay_terms', '', array('stat' => 1));

        $this->load->view('modules/user/chequ', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // search chq
    function srchChq()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('chqu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque Search');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->prnt == 1) {
            $prnt = "";
        } else {
            $prnt = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rjt = "";
        } else {
            $rjt = "disabled";
        }
        if ($funcPerm[0]->rpnt == 1) {
            $repntB = "";
        } else {
            $repntB = "disabled";
        }

        $result = $this->User_model->get_chq();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->cqid;
            if ($row->stat == 0) {
                $stat = "<span class='label label-warning'> Pending </span> ";
                $prnt = "disabled";
                $app2 = "";
                $rej = "";
                $prnt2 = "";
                $repnt = "hidden";
            } elseif ($row->stat == 1) {  // if main statues approval
                $stat = "<span class='label label-success'> Approval</span> ";
                $app2 = "disabled";
                $rej = "";
                if ($row->cpnt == 0) {
                    $prnt = "";
                    $repnt = "hidden";
                    $prnt2 = "";
                } else {
                    $prnt = "hidden";
                    $repnt = "";
                    $prnt2 = "hidden";
                }

            } else if ($row->stat == 2) {
                $stat = "<span class='label label-danger'> Cancel </span> ";
                $prnt = "disabled";
                $app2 = "disabled";
                $rej = "disabled";
                $prnt2 = "";
                $repnt = "hidden";
            }

            if ($row->mode == 1) {
                $rej = "";
                $mode = "<span class='label label-default' title='Credit Voucher'> Credit </span> ";
            } else if ($row->mode == 2) {   // IN CASH GROUP VOUCHER
                $rej = "disabled"; /* Already cheque data insert */
                $mode = "<span class='label label-default' title='Incash Voucher'> Incash </span> ";
            } else if ($row->mode == 3) {
                $rej = "";
                $mode = "<span class='label label-default' title='General Voucher'> General </span> ";
            }

            $option = "<button type='button' $viw id='viw' data-toggle='modal' data-target='#modalView' onclick='viewChq($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                "<button type='button' $app $app2 id='app' data-toggle='modal' data-target='#modalView' onclick='viewChq($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                "<button type='button' $prnt  id='app'  data-toggle='modal'  onclick='chqPrint($row->void);' class='btn btn-default btn-condensed $prnt2' title='Chq Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                "<button type='button' $repntB data-toggle='modal' style='border-color: #00aaaa'  onclick='chqReprint($row->void);' class='btn btn-default btn-condensed $repnt' title='Chq RePrint'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                "<button type='button' $rjt $rej  onclick='rejecChq($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";


            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->vuno;
            $sub_arr[] = $mode;
            $sub_arr[] = $row->pynm; // cust name
            $sub_arr[] = $row->acnm . ' | ' . $row->cqno;
            $sub_arr[] = $row->cqdt;
            $sub_arr[] = number_format($row->cqam, 2, '.', ',');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_chq(),
            "recordsFiltered" => $this->User_model->count_filt_chq(),
            "data" => $data,
        );
        echo json_encode($output);

    }

    // view chequ detils
    function vewChq()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('chqu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'View Cheque');

        $this->db->select("chq_issu.*,  brch_mas.brnm ,voucher.vuno,voucher.pynm,bnk_accunt.acnm,bnk_accunt.acno ,user_mas.fnme ");
        $this->db->from("chq_issu");
        $this->db->join('voucher', 'voucher.void = chq_issu.vuid');
        $this->db->join('brch_mas', 'brch_mas.brid = chq_issu.brco');
        $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid');
        $this->db->join('user_mas', 'user_mas.auid = chq_issu.isui');

        $this->db->where('chq_issu.cqid', $brn = $this->input->post('chqid'));

        $query = $this->db->get();
        $cqdt = $query->result();

        echo json_encode($cqdt);
    }

    // voucher approval
    function chqApprvl()
    {
        $cqid = $this->input->post('cqid');
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_ar1 = array(
            'stat' => 1,
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('chq_issu', $data_ar1, array('cqid' => $cqid));
        if ($result1) {
            $chk = $chk + 1;
        }

        $chqdt = $this->Generic_model->getData('chq_issu', array('vuid', 'accid'), array('cqid' => $cqid));
        $voudt = $this->Generic_model->getData('voucher', '', array('void' => $chqdt[0]->vuid));
        // $accdt = $this->Generic_model->getData('accu_chrt', array('idfr', 'hadr'), array('idfr' => $voudt[0]->pyac));

        if ($voudt[0]->mode == 3) {     // IF GENERAL VOUCHER DOUBLE ENTRY ** OTHERS DOUBLE ENTRY ALLREDY INSERT

            // ACCOUNT LEDGE
            $data_aclg1 = array(
                'brno' => $voudt[0]->brco, // BRANCH ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'Bank Transactions',
                'trid' => 11,
                'rfno' => $chqdt[0]->accid,
                'rfna' => $voudt[0]->vuno,
                'dcrp' => 'Voucher chq payment ',
                'acco' => 107,    // cross acc code
                'spcd' => 209,    // split acc code
                'acst' => '(209) payable payment',
                'dbam' => $voudt[0]->vuam,
                'cram' => 0,
                'stat' => 0
            );
            $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);
            if ($result) {
                $chk = $chk + 1;
            }

            $data_aclg2 = array(
                'brno' => $voudt[0]->brco, // BRANCH ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'Bank Transactions',
                'trid' => 11,
                'rfno' => $chqdt[0]->accid,
                'rfna' => $voudt[0]->vuno,
                'dcrp' => 'Voucher chq payment ',
                'acco' => 209,    // cross acc code
                'spcd' => 107,    // split acc code
                'acst' => '(107) Bank/Cash at Bank',
                'dbam' => 0,
                'cram' => $voudt[0]->vuam,
                'stat' => 0
            );
            $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
            if ($re1) {
                $chk = $chk + 1;
            }
        } else {
            $chk = $chk + 2;
        }

        $funcPerm = $this->Generic_model->getFuncPermision('chqu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque approval ');

        /*if ($chk == 3) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }*/
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    // chq Print
    function cheqPrint($cqid, $opt, $ncqno)
    {
        // $cqid- chq id
        // $opt - option ( 0 - 1st print / 1- Reprint / 2 - Reprint with cheq No change )
        // $ncqno - new chq no
        $this->db->from("chq_issu");
        $this->db->join('voucher', 'voucher.void = chq_issu.vuid');
        $this->db->where('chq_issu.vuid', $cqid);
        $this->db->where('chq_issu.stat IN(0,1)');
        $query = $this->db->get();
        $chq = $query->result();

        ob_start();
        $this->load->library('numbertowordconvertsconver');

        if ($opt == 0) {    // CHQ PRINT
            if ($chq[0]->cpnt == 0) {
                $data_ar1 = array(
                    'cpnt' => 1,
                    'cpby' => $_SESSION['userId'],
                    'cqpd' => date('Y-m-d H:i:s'),
                );
                $result1 = $this->Generic_model->updateData('chq_issu', $data_ar1, array('vuid' => $cqid));

                $this->pdf->AddPage('L', array(87, 177));
                $this->pdf->SetFont('Courier', '', 8);

                //----TWO LINES----//
                if ($chq[0]->actg == 1) {
                    $this->pdf->SetLineWidth(0.1);
                    $this->pdf->Line(60, 3, 92, 3);
                    $this->pdf->Line(60, 7, 92, 7);
                    $this->pdf->SetXY(60, 5);
                    $this->pdf->Cell(0, 0, 'ACCOUNT PAYEE ONLY');
                }

                //----PAYEE NAME----//
                $this->pdf->SetFont('', '', 13);
                $this->pdf->SetXY(13, 17);//13,15
                $this->pdf->Cell(0, 0, $chq[0]->cqpn, 0, 1, 'L');
                //----AMOUNT WORD----
                $ss = $this->numbertowordconvertsconver->convert_number($chq[0]->cqam);
                $this->pdf->SetXY(13, 24); // 13,22
                $this->pdf->MultiCell(103, 8, $ss . ' Only', '0', 'L', FALSE);
                $this->pdf->Ln(6);

                //----AMOUNT----//
                $this->pdf->SetFont('', 'B', '13');
                $this->pdf->SetXY(-10, 33); //-15,28
                $this->pdf->Cell(10, 8, '**' . number_format($chq[0]->cqam, 2, '.', ','), 0, 1, 'R');


                $cqdt = $chq[0]->cqdt;
                $re = (explode("-", $cqdt));
                $dy = intval($re[0]);
                $dm = intval($re[1]);
                $dd = intval($re[2]);

                $this->pdf->SetFont('', '', '8');
                $dyt = str_split($dy);
                $dy1 = $dyt[2] . ' ' . $dyt[3];

                $dmt = str_split($dm);
                $cc = strlen($dm);
                if ($cc == 1) {
                    $dm1 = '0' . ' ' . $dmt[0];
                } else {
                    $dm1 = $dmt[0] . ' ' . $dmt[1];
                }
                $ddt = str_split($dd);
                $cc2 = strlen($dd);
                if ($cc2 == 1) {
                    $dd1 = '0' . ' ' . $ddt[0];
                } else {
                    $dd1 = $ddt[0] . ' ' . $ddt[1];
                }

                $this->pdf->SetFont('', 'B', '13');
                //YEAR
                /* $this->pdf->SetXY(-12, 2); //-12,2
                 $this->pdf->Cell(8, 0, $dy1, 0, 1, 'R');
                 //MONTH
                 $this->pdf->SetXY(-38, 2); //-38,2
                 $this->pdf->Cell(8, 0, $dm1, 0, 1, 'R');
                 //DATE
                 $this->pdf->SetXY(-52, 2); //-52,2
                 $this->pdf->Cell(8, 0, $dd1, 0, 1, 'R');*/

                // SPECIAL REQUEST BY MR.SANJAYA 2018/08/21
                //DATE
                $this->pdf->SetXY(-25, 3);
                $this->pdf->Cell(8, 0, date("d-m-Y", strtotime($cqdt)), 0, 1, 'R');

            } else {
                //$pdf = new FPDF('L', 'mm', array(87, 177));
                $this->pdf->AddPage('L', array(87, 177));
                $this->pdf->SetFont('Courier', '', 7);

                $this->pdf->SetFont('', '', '9');
                $this->pdf->SetXY(10, 20);
                $this->pdf->Cell(5, 6, 'Cheque Payment ' . $chq[0]->vuno . ' printed, Please get the admin approval for reprint...', 0, 1, 'L');
                $this->pdf->SetTitle('Cheque Reprint - ' . $chq[0]->vuno);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('chqu');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque Print ');

        } elseif ($opt == 1) {  // CHQ REPRINT

            $data_ar1 = array(
                'prct' => $chq[0]->prct + 1,
                'reby' => $_SESSION['userId'],
                'redt' => date('Y-m-d H:i:s'),
            );
            $result1 = $this->Generic_model->updateData('chq_issu', $data_ar1, array('cqid' => $chq[0]->cqid, 'stat' => 1));

            $this->pdf->AddPage('L', array(87, 177));
            $this->pdf->SetFont('Courier', '', 8);

            //----TWO LINES----//
            if ($chq[0]->actg == 1) {
                $this->pdf->SetLineWidth(0.1);
                $this->pdf->Line(60, 3, 92, 3);
                $this->pdf->Line(60, 7, 92, 7);
                $this->pdf->SetXY(60, 5);
                $this->pdf->Cell(0, 0, 'ACCOUNT PAYEE ONLY');
            }

            //----PAYEE NAME----//
            $this->pdf->SetFont('', '', 13);
            $this->pdf->SetXY(13, 17);//13,15
            $this->pdf->Cell(0, 0, $chq[0]->cqpn, 0, 1, 'L');
            //----AMOUNT WORD----
            $ss = $this->numbertowordconvertsconver->convert_number($chq[0]->cqam);
            $this->pdf->SetXY(13, 24); // 13,22
            $this->pdf->MultiCell(103, 8, $ss . ' Only', '0', 'L', FALSE);
            $this->pdf->Ln(6);

            //----AMOUNT----//
            $this->pdf->SetFont('', 'B', '13');
            $this->pdf->SetXY(-10, 33); //-15,28
            $this->pdf->Cell(10, 8, '**' . number_format($chq[0]->cqam, 2, '.', ','), 0, 1, 'R');


            $cqdt = $chq[0]->cqdt;  // $nxdd_n = date("Y-m-d", $nxdd);

            $re = (explode("-", $cqdt));
            $dy = intval($re[0]);
            $dm = intval($re[1]);
            $dd = intval($re[2]);

            $this->pdf->SetFont('', '', '8');
            $dyt = str_split($dy);
            $dy1 = $dyt[2] . ' ' . $dyt[3];

            $dmt = str_split($dm);
            $cc = strlen($dm);
            if ($cc == 1) {
                $dm1 = '0' . ' ' . $dmt[0];
            } else {
                $dm1 = $dmt[0] . ' ' . $dmt[1];
            }
            $ddt = str_split($dd);
            $cc2 = strlen($dd);
            if ($cc2 == 1) {
                $dd1 = '0' . ' ' . $ddt[0];
            } else {
                $dd1 = $ddt[0] . ' ' . $ddt[1];
            }

            $this->pdf->SetFont('', 'B', '13');
            //YEAR
            /* $this->pdf->SetXY(-12, 2); //-12,2
             $this->pdf->Cell(8, 0, $dy1, 0, 1, 'R');
             //MONTH
             $this->pdf->SetXY(-38, 2); //-38,2
             $this->pdf->Cell(8, 0, $dm1, 0, 1, 'R');
             //DATE
             $this->pdf->SetXY(-52, 2); //-52,2
             $this->pdf->Cell(8, 0, $dd1, 0, 1, 'R');*/

            // SPECIAL REQUEST BY MR.SANJAYA 2018/08/21
            //DATE
            $this->pdf->SetXY(-25, 3);
            $this->pdf->Cell(8, 0, date("d-m-Y", strtotime($cqdt)), 0, 1, 'R');

            $funcPerm = $this->Generic_model->getFuncPermision('chqu');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque Reprint CQ No ');

        } elseif ($opt == 2) {
            $funcPerm = $this->Generic_model->getFuncPermision('chqu');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque No Change & Print CQ No ');
        }

        if ($opt == 2) {
            $cqno = $ncqno;
        } else {
            $cqno = $chq[0]->cqno;
        }

        $this->pdf->SetTitle('Chq No - ' . $cqno);
        $this->pdf->Output('Chq_No_' . $cqno . '.pdf', 'I');
        ob_end_flush();

    }

    // CHQ NO CHANGE  GET PERVISI CHQ BANK BRNCH ACCOUNT
    function getOtherChqLeaf()
    {
        $id = $this->input->post('id'); // VOUCHER ID
        $aas = $this->Generic_model->getData('chq_issu', array('brco', 'accid', 'cqbk'), array('vuid' => $id));
        //$old = $aas[0]->clno;

        echo json_encode($aas);
    }

    // CHQ NO CHAGE & REPRINT
    function chqNochange($cqid, $ncqno)
    {
        //$cqid = $this->input->post('cqid2');    // CHQ VOUCHER ID
        //$ncqno = $this->input->post('cqno2');   // NEW CHQ ID
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->db->from("chq_issu");
        $this->db->join('voucher', 'voucher.void = chq_issu.vuid');
        $this->db->where('chq_issu.vuid', $cqid);
        $this->db->where('chq_issu.stat IN(0,1)');
        $query = $this->db->get();
        $chq = $query->result();

        ob_start();
        $this->load->library('numbertowordconvertsconver');

        // CHQ NO CHANG AND REPRINT
        $data_ar1 = array(
            'stat' => 2,
            'rmks' => 'Chq No Change & Chq Reprint ',
            'cnby' => $_SESSION['userId'],
            'cndt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('chq_issu', $data_ar1, array('cqid' => $chq[0]->cqid));

        $data_arr3 = array(
            'brco' => $chq[0]->brco,
            'accid' => $chq[0]->accid,      // bank account id
            'bkac' => 0,
            'cqdt' => $chq[0]->cqdt,        // chq date
            'cqam' => $chq[0]->cqam,        // chq amount
            'efdt' => $chq[0]->efdt,        // pay date

            'isdt' => $chq[0]->isdt,        // create date
            'isui' => $chq[0]->isui,        // create by
            'vuid' => $chq[0]->vuid,        // voucher no
            'rfno' => $chq[0]->rfno,        // voucher id

            'cqst' => $chq[0]->cqst,
            'actg' => $chq[0]->actg,
            'cqpn' => $chq[0]->cqpn,
            'cpnt' => 1,

            'apby' => $chq[0]->apby,
            'apdt' => $chq[0]->apdt,
            'cpby' => $chq[0]->cpby,
            'cqpd' => $chq[0]->cqpd,
            //'cqpn' => $chq[0]->cqpn,

            'chmd' => $chq[0]->chmd,
            'stat' => 1,
            'pvcn' => $chq[0]->cqno,
            'rmks' => 'Previous Tb id ' . $chq[0]->cqid,
        );
        $result3 = $this->Generic_model->updateData('chq_issu', $data_arr3, array('cqid' => $ncqno));

        $this->pdf->AddPage('L', array(87, 177));
        $this->pdf->SetFont('Courier', '', 8);

        //----TWO LINES----//
        if ($chq[0]->actg == 1) {
            $this->pdf->SetLineWidth(0.1);
            $this->pdf->Line(60, 3, 92, 3);
            $this->pdf->Line(60, 7, 92, 7);
            $this->pdf->SetXY(60, 5);
            $this->pdf->Cell(0, 0, 'ACCOUNT PAYEE ONLY');
        }

        //----PAYEE NAME----//
        $this->pdf->SetFont('', '', 13);
        $this->pdf->SetXY(13, 15);

        $this->pdf->Cell(0, 0, $chq[0]->cqpn, 0, 1, 'L');

        //----AMOUNT WORD----
        $ss = $this->numbertowordconvertsconver->convert_number($chq[0]->cqam);
        $this->pdf->SetXY(13, 22);
        $this->pdf->MultiCell(103, 8, $ss . ' Only', '0', 'L', FALSE);
        $this->pdf->Ln(6);

        //----AMOUNT----//
        $this->pdf->SetFont('', 'B', '13');
        $this->pdf->SetXY(-15, 28);
        $this->pdf->Cell(10, 8, '**' . number_format($chq[0]->cqam, 2, '.', ','), 0, 1, 'R');

        $cqdt = $chq[0]->cqdt;
        $re = (explode("-", $cqdt));
        $dy = intval($re[0]);
        $dm = intval($re[1]);
        $dd = intval($re[2]);

        $this->pdf->SetFont('', '', '8');
        $dyt = str_split($dy);
        $dy1 = $dyt[2] . ' ' . $dyt[3];

        $dmt = str_split($dm);
        $cc = strlen($dm);
        if ($cc == 1) {
            $dm1 = '0' . ' ' . $dmt[0];
        } else {
            $dm1 = $dmt[0] . ' ' . $dmt[1];
        }
        $ddt = str_split($dd);
        $cc2 = strlen($dd);
        if ($cc2 == 1) {
            $dd1 = '0' . ' ' . $ddt[0];
        } else {
            $dd1 = $ddt[0] . ' ' . $ddt[1];
        }

        $this->pdf->SetFont('', 'B', '14');
        //YEAR
        /* $this->pdf->SetXY(-12, 2);
         $this->pdf->Cell(8, 0, $dy1, 0, 1, 'R');
         //MONTH
         $this->pdf->SetXY(-38, 2);
         $this->pdf->Cell(8, 0, $dm1, 0, 1, 'R');
         //DATE
         $this->pdf->SetXY(-52, 2);
         $this->pdf->Cell(8, 0, $dd1, 0, 1, 'R');*/

        // SPECIAL REQUEST BY MR.SANJAYA 2018/08/21
        //DATE
        $this->pdf->SetXY(-25, 3);
        $this->pdf->Cell(8, 0, date("d-m-Y", strtotime($cqdt)), 0, 1, 'R');

        $this->pdf->SetTitle('Chq No - ' . $ncqno);
        $this->pdf->Output('Chq_No_' . $ncqno . '.pdf', 'I');
        ob_end_flush();

        $funcPerm = $this->Generic_model->getFuncPermision('chqu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque No Change & Print CHQ No ');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            //echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            // echo json_encode(true);
        }
    }

    // chq reject
    function rejChq()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('chqu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque Cancel');

        // data remove in chq_issu table
        $cqid = $this->input->post('id');
        $data_ar1 = array(
            'stat' => 2,
            'cnby' => $_SESSION['userId'],
            'cndt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('chq_issu', $data_ar1, array('cqid' => $cqid));

        // data remove in loan tb
        // $lndt = $this->Generic_model->getData('micr_crt', array('lnid', 'vpno', 'stat'), array('vpno' => $vuid));
        // $siz = sizeof($lndt);
        // $a = 0;
        // if ($siz > 0) {
        //     for ($i = 0; $i < $siz; $i++) {
        //         $this->Generic_model->updateData('micr_crt', array('vpno' => '0'), array('lnid' => $lndt[$i]->lnid));
        //         $a = $a + 1;
        //     }
        // }

        $funcPerm = $this->Generic_model->getFuncPermision('chqu');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque reject id(' . $cqid . ')');

        if (count($result1) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

// Guarantor Upgrade
    public function grnt_upgrd()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('grnt_upgrd');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $this->load->view('modules/user/guarantor_upgrade', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function searchGrnt()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('grnt_upgrd');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "";
        } else {
            $reac = "disabled";
        }

        $result = $this->User_model->get_gurnterDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->trst == 1) {
                $tr = "<span class='label label-primary' title='Transfer Customer'>T</span>";
            } else {
                $tr = '';
            }
            if ($row->cuty == '1') {
                $cuty = "<span class='label label-default' title='Normal Customer'>Normal</span>";
            } else if ($row->cuty == '2') {
                $cuty = "<span class='label label-primary' title='Advance Customer'>Advance</span>";
            }

            if ($row->rgtp == 0) {  // Guarantor
                $stat = " <span class='label label-success'> Guarantor </span> ";
                $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $reac . "  onclick='upgrdeGrnt($row->cuid);' class='btn btn-default btn-condensed' title='Upgrade'><i class='fa fa-expand' aria-hidden='true'></i></button> ";
            } else {  // Others
                $stat = " <span class='label label-default'> Customer </span> ";
                $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' disabled onclick='upgrdeGrnt();' class='btn btn-default btn-condensed' title='Upgrade'><i class='fa fa-expand' aria-hidden='true'></i></button> ";
            }


            $nam = "<span title='$row->funm'> $row->init </span> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->exc;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->cuno . ' ' . $tr;
            $sub_arr[] = $nam;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $cuty;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_grnt(),
            "recordsFiltered" => $this->User_model->count_filtered_grnt(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function upgrdeGrant()
    {
        $id = $this->input->post('id');
        $data_arr2 = array(
            'upid' => $id, // customer id
            'uptp' => 1,
            'upby' => $_SESSION['userId'],
            'updt' => date('Y-m-d H:i:s'),
        );
        $result2 = $this->Generic_model->insertData('upgrd_dtils', $data_arr2);

        $result = $this->Generic_model->updateData('cus_mas', array('rgtp' => 1), array('cuid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('grnt_upgrd');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Guarantor Upgrade id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }
// End Guarantor

// customer upgrade
    public function cust_upgrd()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('cust_upgrd');
        $data['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['eduinfo'] = $this->Generic_model->getData('cus_edu', '', '');
        $data['geninfo'] = $this->Generic_model->getData('cus_gen', '', '', '');
        $data['titlinfo'] = $this->Generic_model->getData('cus_sol', '', '', '');
        $data['cvlinfo'] = $this->Generic_model->getData('cvl_stst', '', '', '');
        $data['relinfo'] = $this->Generic_model->getData('cus_rel', '', array('stat' => 1), '');

        $this->load->view('modules/user/customer_upgrade', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function searchNmcust()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('grnt_upgrd');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "";
        } else {
            $reac = "disabled";
        }

        $result = $this->User_model->get_nmcustDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            if ($row->trst == 1) {
                $tr = "<span class='label label-primary' title='Transfer Customer'>T</span>";
            } else {
                $tr = '';
            }
            if ($row->cuty == '1') {
                $cuty = "<span class='label label-default' title='Normal Customer'>Normal</span>";
            } else if ($row->cuty == '2') {
                $cuty = "<span class='label label-primary' title='Advance Customer'>Advance</span>";
            }

            if ($st == '3' || $st == '4') {  // Approved
                $stat = " <span class='label label-success'>" . $row->stnm . "</span> ";
                $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button'  $reac data-toggle='modal' data-target='#advCust_edt1' onclick='upgrdCust($row->cuid);' class='btn btn-default btn-condensed' title='Upgrade'><i class='fa fa-expand' aria-hidden='true'></i></button>  ";
            } else {  // Others
                $stat = " <span class='label label-default'>" . $row->stnm . "</span> ";
                $option = "<button type='button' id='$row->cuid' $viw data-toggle='modal' data-target='#modalView' onclick='viewCust(this.id)' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' disabled onclick='upgrdeGrnt();' class='btn btn-default btn-condensed' title='Upgrade'><i class='fa fa-expand' aria-hidden='true'></i></button> ";
            }


            $nam = "<span title='$row->funm'> $row->init </span> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->exc;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->cuno . ' ' . $tr;
            $sub_arr[] = $nam;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $cuty;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_nmcust(),
            "recordsFiltered" => $this->User_model->count_filtered_nmcust(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function vewnmcustdtils()
    {
        $this->db->select("cus_mas.*,cus_mas_advnc.*,grup_mas.grno AS grnm,cus_mas.cuid AS ccuid");
        $this->db->from("cus_mas");
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('cus_mas_advnc', 'cus_mas_advnc.cuid = cus_mas.cuid', 'left');
        // $this->db->join('cen_days', 'cen_days.dyid = cen_mas.cody ');

        $this->db->where('cus_mas.cuid ', $this->input->post('auid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function upgrdeGrant2()
    {
        $id = $this->input->post('id');
        $data_arr2 = array(
            'upid' => $id, // customer id
            'uptp' => 1,
            'upby' => $_SESSION['userId'],
            'updt' => date('Y-m-d H:i:s'),
        );
        $result2 = $this->Generic_model->insertData('upgrd_dtils', $data_arr2);

        $result = $this->Generic_model->updateData('cus_mas', array('rgtp' => 1), array('cuid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('grnt_upgrd');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Guarantor Upgrade id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    function cust_upgrade()
    {
        $func = $this->input->post('func_advn');

        // user pic  -  advPicEdt   avt33
        // user nic  -  advNicEdt   avt44
        // GSC       -  advGscEdt   avt55
        // bus loc   -  advBulEdt   avt66
        // use other -  advOthEdt   avt77


        if (!empty($_FILES['advPicEdt']['name'])) {

            $config['upload_path'] = 'uploads/cust_profile/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["advPicEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advPicEdt')) {
                $uploadData = $this->upload->data();
                $pro = $uploadData['file_name'];
            } else {
                $pro = '';
            }
        } else {
            $pro = $this->input->post('avt33');
        }

        if (!empty($_FILES['advNicEdt']['name'])) {

            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["advNicEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advNicEdt')) {
                $uploadData = $this->upload->data();
                $nic = $uploadData['file_name'];
            } else {
                $nic = '';
            }
        } else {
            $nic = "document-default.jpg";
        }

        if (!empty($_FILES['advGscEdt']['name'])) {

            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["advGscEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advGscEdt')) {
                $uploadData = $this->upload->data();
                $gsc = $uploadData['file_name'];
            } else {
                $gsc = '';
            }
        } else {
            $gsc = "document-default.jpg";
        }

        if (!empty($_FILES['advBulEdt']['name'])) {

            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            // $config['max_width'] = '1024';
            // $config['max_height'] = '768';
            $config['file_name'] = $_FILES["advBulEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advBulEdt')) {
                $uploadData = $this->upload->data();
                $busl = $uploadData['file_name'];
            } else {
                $busl = '';
            }
        } else {
            $busl = "document-default.jpg";
        }

        if (!empty($_FILES['advOthEdt']['name'])) {

            $config['upload_path'] = 'uploads/user_document/';  //'uploads/images/'
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '2048'; //KB
            $config['file_name'] = $_FILES["advOthEdt"]['name'];

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('advOthEdt')) {
                $uploadData = $this->upload->data();
                $otr = $uploadData['file_name'];
            } else {
                $otr = '';
            }
        } else {
            $otr = "document-default.jpg";
        }


        // for cus_mas tb
        $data_arr1 = array(
            'gplg' => $this->input->post('adv_gplg_edt'),
            'gplt' => $this->input->post('adv_gplt_edt'),
            'funm' => strtoupper($this->input->post('adv_funm_edt')),
            'init' => strtoupper($this->input->post('adv_init_edt')),
            'hoad' => strtoupper($this->input->post('adv_hoad_edt')),
            'tele' => $this->input->post('adv_tele_edt'),
            'mobi' => $this->input->post('adv_mobi_edt'),
            //'anic' => strtoupper($this->input->post('adv_nic_edt')),
            'dobi' => $this->input->post('adv_dobi_edt'),
            'gend' => $this->input->post('adv_gend_edt'),
            'titl' => $this->input->post('adv_titl_edt'),
            'edun' => $this->input->post('adv_edun_edt'),
            'cist' => $this->input->post('adv_cist_edt'),
            'gsaw' => $this->input->post('adv_gsaw_edt'),
            'uimg' => $pro,
            'smst' => $this->input->post('adv_smst_edt'),

            'cuty' => 2,
            //'mdby' => $_SESSION['userId'],
            //'mddt' => date('Y-m-d H:i:s'),
        );

        // for cus_mas_advnc tb
        $data_arr2 = array(
            'cuid' => $this->input->post('auid_advn'),

            'sunm' => $this->input->post('sunm_edt'),
            'snic' => strtoupper($this->input->post('spnic_edt')),
            'fmem' => $this->input->post('fmem_edt'),
            'mopr' => $this->input->post('mopr_edt'),
            'apre' => $this->input->post('apre_edt'),
            'occu' => $this->input->post('occu_edt'),
            'impr' => $this->input->post('impr_edt'),

            'bsad' => $this->input->post('bsad_edt'),
            'buss' => $this->input->post('buss_edt'),
            'rgno' => $this->input->post('rgno_edt'),
            'dura' => $this->input->post('dura_edt'),
            'bupl' => $this->input->post('bupl_edt'),
            'butp' => $this->input->post('butp_edt'),
            'beml' => $this->input->post('beml_edt'),
            'bsin' => $this->input->post('bsin_edt'),
            'obin' => $this->input->post('obin_edt'),
            'diin' => $this->input->post('diin_edt'),
            'odin' => $this->input->post('odin_edt'),

            'spin' => $this->input->post('spin_edt'),
            'osin' => $this->input->post('osin_edt'),
            'food' => $this->input->post('food_edt'),
            'clth' => $this->input->post('clth_edt'),
            'wate' => $this->input->post('wate_edt'),
            'elec' => $this->input->post('elec_edt'),
            'medc' => $this->input->post('medc_edt'),
            'educ' => $this->input->post('educ_edt'),
            'tran' => $this->input->post('tran_edt'),
            'otex' => $this->input->post('otex_edt'),

            'lnin' => $this->input->post('lnin_edt'),
            'otln' => $this->input->post('otln_edt'),
            'inis' => $this->input->post('inis_edt'),
            'ttib' => $this->input->post('ttib_edt'),
            'ttid' => $this->input->post('ttid_edt'),
            'ttis' => $this->input->post('ttis_edt'),
            'ttex' => $this->input->post('ttex_edt'),
            'ncih' => $this->input->post('ncih_edt'),

            'img_nic' => $nic,
            'img_gscr' => $busl,
            'img_bslc' => $gsc,
            'img_othr' => $otr,
        );

        $where_arr = array(
            'cuid' => $this->input->post('auid_advn')
        );

        $result1 = $this->Generic_model->updateData('cus_mas', $data_arr1, $where_arr);
        $result2 = $this->Generic_model->insertData('cus_mas_advnc', $data_arr2);

        $id = $this->input->post('auid_advn');
        $data2 = array(
            'upid' => $id, // customer id
            'uptp' => 2,
            'upby' => $_SESSION['userId'],
            'updt' => date('Y-m-d H:i:s'),
        );
        $result3 = $this->Generic_model->insertData('upgrd_dtils', $data2);


        $funcPerm = $this->Generic_model->getFuncPermision('cust_upgrd');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Customer Upgrade id(' . $id . ')');

        if (count($result1) > 0 && count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
// End Guarantor
//
// NIC SEARCH  @@@@@@@@@
// NIC SEARCH
    function nicSrch()
    {
        $sid = $this->input->post('sid');
        $ln = strlen($sid);

        if ($ln == 10 || $ln == 12) { // GP/0001/00006
            $cubs = $this->Generic_model->getData('cus_mas', array('cuid', 'anic'), array('anic' => $sid));
            echo json_encode($cubs);
        } else if ($ln == 13) {
            $cubs = $this->Generic_model->getData('cus_mas_base', array('auid', 'cuno'), array('cuno' => $sid));
            echo json_encode($cubs);
        } else if ($ln == 19) {
            $cubs = $this->Generic_model->getData('micr_crt', array('lnid', 'acno'), array('acno' => $sid));
            echo json_encode($cubs);
        }
    }

// NIC search more details
    function nicSearchDtils()
    {
        $sid = $this->input->get('sid');
        $ln = strlen($sid);

        $this->db->select("cus_mas.*  ,cust_stat.stnm,cen_mas.cnno,cen_mas.cnnm, brch_mas.brnm,cus_gen.gndt,cus_sol.sode,cus_type.cutp,grup_mas.grno ,COUNT(micr_crt.acno) AS lncount,
        CONCAT(user_mas.fnme,' ',user_mas.lnme) AS fnme ,IF(cus_mas.cuty = '1' ,'Normal ','Advance') AS cumd,IF(cus_mas.rgtp = '0' ,'Guarantor ','Customer') AS rgmd ");
        $this->db->from("cus_mas");
        $this->db->join('cus_mas_base', 'cus_mas_base.cuid = cus_mas.cuid');

        $this->db->join('cust_stat', 'cust_stat.stid = cus_mas.stat');
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco');
        $this->db->join('cus_gen', 'cus_gen.gnid = cus_mas.gend');
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno', 'left');
        $this->db->join('micr_crt', 'micr_crt.apid = cus_mas.cuid', 'left');
        // $this->db->join("(SELECT auid,fnme FROM user_mas )AS aa ", 'aa.auid = cus_mas.crby');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.crby');

        if ($ln == 10 || $ln == 12) {
            $this->db->where('cus_mas.anic', $sid);
        } else if ($ln == 13) {
            $this->db->where('cus_mas_base.cuno', $sid);
        } else if ($ln == 19) {
            $this->db->where('micr_crt.acno', $sid);
        }
        $query = $this->db->get();
        $data['cust'] = $query->result();

        // Operative loan
        $this->db->select("micr_crt.* ,cen_mas.cnnm,product.prcd ,product.prnm ,prdt_typ.pymd ,loan_stat.stnm,
        re.reno, IFNULL(re.ramt,'0') AS ramt ,IFNULL(re.crdt,' - ') AS crdt ,IFNULL(re.crb,' - ') AS crb ,IFNULL(re.ssdt,' - ') AS ssdt , cm.cmnt ");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat');
        $this->db->join("(SELECT r.rfno,r.reno,r.ramt,r.crdt ,r.ssdt, CONCAT(u.fnme, ' ' , u.lnme) AS crb
                        FROM `receipt` AS r 
                        JOIN user_mas AS u ON u.auid = r.crby
                        WHERE  r.retp = 2 AND r.stat IN(1,2) 
                        ORDER BY `reid` DESC LIMIT 1) AS re", 're.rfno = micr_crt.lnid', 'left');
        $this->db->join("(SELECT cmrf,COUNT(*) AS cmnt
                        FROM `comments` AS c                        
                        WHERE  c.cmtp = 2 AND c.stat = 1  GROUP BY cmrf) AS cm", 'cm.cmrf = micr_crt.lnid', 'left');

        $this->db->where('micr_crt.apid', $data['cust'][0]->cuid);
        $this->db->where('micr_crt.stat IN(5,18)');  // DISBURS & TOPUP LOAN
        $this->db->order_by("micr_crt.acno", "desc");
        $query = $this->db->get();
        $data['lnar1'] = $query->result();

        // GET RUNNING LOAN AGE
        $cuid = $data['cust'][0]->cuid;
        $data['agdt'] = $this->Generic_model->getData('micr_crt', array('cage'), "stat IN(5,18) AND apid = $cuid AND cage > 2");

        // Closed loan
        $this->db->select("micr_crt.* ,cen_mas.cnnm,product.prcd ,product.prnm ,prdt_typ.pymd,loan_stat.stnm, cm.cmnt");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat');
        $this->db->join("(SELECT cmrf,COUNT(*) AS cmnt
                        FROM `comments` AS c                        
                        WHERE  c.cmtp = 2 AND c.stat = 1  GROUP BY cmrf) AS cm", 'cm.cmrf = micr_crt.lnid', 'left');
        $this->db->where('micr_crt.apid', $data['cust'][0]->cuid);
        $this->db->where('micr_crt.stat IN(3,7,8,13,14,15,16,17)');
        $this->db->order_by("micr_crt.acno", "desc");
        $query = $this->db->get();
        $data['lnar2'] = $query->result();

        // Inactive loan
        $this->db->select("micr_crt.* ,cen_mas.cnnm,product.prcd ,product.prnm ,prdt_typ.pymd ,loan_stat.stnm, cm.cmnt");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat');
        $this->db->join("(SELECT cmrf,COUNT(*) AS cmnt
                        FROM `comments` AS c                        
                        WHERE  c.cmtp = 2 AND c.stat = 1  GROUP BY cmrf) AS cm", 'cm.cmrf = micr_crt.lnid', 'left');
        $this->db->where('micr_crt.apid', $data['cust'][0]->cuid);
        $this->db->where('micr_crt.stat IN(1,2,4,9,19)');  // PENDING/APPROVED/REJECT/NON PERFOMED/DUAL APPROVAL REQUEST
        $this->db->order_by("micr_crt.acno", "desc");
        $query = $this->db->get();
        $data['lnar3'] = $query->result();

        // Terminate loan
        $this->db->select("micr_crt.* ,cen_mas.cnnm,product.prcd ,product.prnm ,prdt_typ.pymd ,loan_stat.stnm, cm.cmnt");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat');
        $this->db->join("(SELECT cmrf,COUNT(*) AS cmnt
                        FROM `comments` AS c                        
                        WHERE  c.cmtp = 2 AND c.stat = 1  GROUP BY cmrf) AS cm", 'cm.cmrf = micr_crt.lnid', 'left');
        $this->db->where('micr_crt.apid', $data['cust'][0]->cuid);
        $this->db->where('micr_crt.stat', 12);
        $this->db->order_by("micr_crt.acno", "desc");
        $query = $this->db->get();
        $data['lnar4'] = $query->result();

        // User Access Page Log     $this->Log_model->userLog('nicSearchDtils');
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $this->load->view('modules/user/nic_details', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        // $this->load->view('modules/user/includes/custom_js_user');

    }

    function getNicCusttrnsfer()
    {
        $id = $this->input->post('cuid');

        $this->db->select("cus_mas_base.* ,DATE_FORMAT(cus_mas_base.crdt, '%Y-%m-%d') AS frdt ,DATE_FORMAT(cus_mas_base.trdt, '%Y-%m-%d') AS todt, user_mas.usnm,cen_mas.cnnm,brch_mas.brnm,grup_mas.grno");
        $this->db->from("cus_mas_base");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas_base.ccnt');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas_base.brid');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas_base.grno');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas_base.exec');
        $this->db->where('cus_mas_base.cuid', $id);
        $this->db->order_by("cus_mas_base.auid", "asc");
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

// MICRO LEDGER
    public function getLoanLeg()
    {
        $lonid = $this->input->post('lnid');
        $tp = $this->input->post('typ'); // if 0-all/1-other/2-pymt/3-PRM/4-penty/5-cancel/

        $this->db->select("");
        $this->db->from("micr_crleg");
        $this->db->where('acid', $lonid);
        $this->db->where('stat', '1');
        if ($tp != 0) {
            if ($tp == 1) { //  OTHER CHARGES
                $this->db->where("micr_crleg.dsid IN(1,23,24,25)");
            } else {
                $this->db->where('micr_crleg.dsid', $tp);
            }
        }
        $this->db->order_by('micr_crleg.lgid', 'asc');
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 1;
        $blam = 0;
        foreach ($result as $row) {
            $blam = $blam + ($row->duam - $row->ream);
            // $dt = date("Y-m-d H:i:s", strtotime($row->ledt));

            $sub_arr = array();
            $sub_arr[] = $i;
            $sub_arr[] = date("Y-m-d H:i:s", strtotime($row->ledt));
            $sub_arr[] = $row->reno;
            $sub_arr[] = $row->dcrp;
            $sub_arr[] = number_format($row->avcp, 2);
            $sub_arr[] = number_format($row->avin, 2);
            $sub_arr[] = number_format($row->dpet, 2);
            $sub_arr[] = number_format($row->schg, 2);
            $sub_arr[] = number_format($row->duam, 2);
            $sub_arr[] = number_format($row->ream, 2);
            $sub_arr[] = number_format($blam, 2);
            $sub_arr[] = $row->cage;

            $data[] = $sub_arr;
            $i = $i + 1;
        }
        $len = $query->num_rows();
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $len,
            "recordsFiltered" => $len,
            "data" => $data,
        );

        echo json_encode($output);
    }

// LOAN SCHEDULE
    public function getLoanSch()
    {
        $lnid = $this->input->post('lnid');

        $this->db->select("micr_crt.noin ,micr_crt.loam ,micr_crt.inra ,micr_crt.inam ,micr_crt.sydt ,micr_crt.madt ,micr_crt.prtp, micr_crt.prdtp, micr_crt.noin, micr_crt.inta ");
        $this->db->from("micr_crt");
        //$this->db->join('product', 'product.auid = micr_crt.prid ');
        $this->db->where('micr_crt.lnid', $lnid);
        $query = $this->db->get();
        $data['lndt'] = $query->result();

        $this->db->select("DATE_FORMAT(micr_crleg.ledt, '%Y-%m-%d') AS ledt, SUM(avcp) AS avcp, SUM(avin) AS avin, (SUM(avcp + avin) *-1) AS ttl ");
        $this->db->from("micr_crleg");
        $this->db->where('micr_crleg.acid', $lnid);
        $this->db->where('micr_crleg.dsid IN(2,11)');
        $this->db->where("micr_crleg.stat IN(1,2) AND ((avcp + avin) *-1) > 0");
        $this->db->group_by("DATE_FORMAT(micr_crleg.ledt, '%Y-%m-%d')");
        $query = $this->db->get();
        $data['lgdt'] = $query->result();

        echo json_encode($data);
    }

    //FORMULA
    public function calc_rate()
    {
        $this->load->helper('html');
        $pv = $this->input->post('pv');
        $payno = $this->input->post('payno');
        $pmt = $this->input->post('pmt');

        $gh = ( float )100; // maximum value
        $gm = ( float )2.5; // first guess
        $gl = ( float )0; // minimum value
        $gp = ( float )0; // result of test calculation

        do {
            $gp = (float)$this->calc_payment3($pv, $payno, $gm, 6);
            if ($gp > $pmt) { // guess is too high
                $gh = $gm;
                $gm = $gm + $gl;
                $gm = $gm / 2;
            }
            if ($gp < $pmt) { // guess is too low
                $gl = $gm;
                $gm = $gm + $gh;
                $gm = $gm / 2;
            }
            if ($gm == $gh) break;
            if ($gm == $gl) break;
            $int = number_format($gm, 9, ".", ""); // round it to 9 decimal places

        } while ($gp !== $pmt);

        // var_dump($int);
        echo json_encode($int);

    }

    public function calc_payment3($pv, $payno, $int, $accuracy)
    {
        // check that required values have been supplied
        $int = $int / 100;
        $value1 = $int * pow((1 + $int), $payno);
        $value2 = pow((1 + $int), $payno) - 1;
        $pmt = $pv * ($value1 / $value2);
        $pmt = number_format($pmt, $accuracy, ".", "");
        return $pmt;
    }


// LOAN PAYMENT
    public function getLoanPymnt()
    {
        $lnid = $this->input->post('lnid');

        $this->db->select("receipt.*,CONCAT(user_mas.usnm,' ') AS exc");
        $this->db->from("receipt");
        $this->db->join('user_mas', 'user_mas.auid = receipt.crby ');

        $this->db->where('receipt.rfno', $lnid);
        $this->db->where('receipt.retp', '2');
        $this->db->where('receipt.stat IN (1,2)');


        $this->db->order_by('receipt.reid', 'asc');
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 1;
        foreach ($result as $row) {
            $sub_arr = array();
            $sub_arr[] = $i;
            $sub_arr[] = $row->reno;
            $sub_arr[] = number_format($row->ramt, 2);
            $sub_arr[] = date("Y-m-d H:i:s", strtotime($row->crdt));
            $sub_arr[] = $row->exc;

            $data[] = $sub_arr;
            $i = $i + 1;
        }
        $len = $query->num_rows();
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $len,
            "recordsFiltered" => $len,
            "data" => $data,
        );

        echo json_encode($output);
    }

// GET LOAN MORE DETAILS
    function vewMoreDetails()
    {
        $lnid = $this->input->post('lnid');

        $this->db->select("micr_crt.*, loan_type.lntp AS lntpnm,cus_mas.cuno,cus_mas.init,cus_mas.anic,brch_mas.brnm ,cen_mas.cnnm,user_mas.fnme ,user_mas.lnme ,
        prdt_typ.prna,prdt_typ.pymd,loan_stat.stnm ,IF(micr_crt.chmd = 1,'Customer Payment','Debit From Loan') AS chrmd");
        $this->db->from("micr_crt");

        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat ');
        $this->db->join('loan_type', 'loan_type.auid = micr_crt.lntp ');

        $this->db->where('micr_crt.lnid ', $lnid);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

// ACCOUNT LEDGER
    public function getLnaccEnty()
    {
        $lonid = $this->input->post('lnid');

        $this->db->select("");
        $this->db->from("acc_leg");
        $this->db->where('lnid', $lonid);
        $this->db->where("stat IN(0,1)");
        $this->db->order_by('acc_leg.acid', 'asc');
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 1;
        $blam = 0;
        foreach ($result as $row) {
            $sub_arr = array();
            $sub_arr[] = $i;
            $sub_arr[] = date("Y-m-d H:i:s", strtotime($row->acdt));
            $sub_arr[] = $row->trtp;
            $sub_arr[] = $row->rfna;
            $sub_arr[] = $row->acst;

            $sub_arr[] = number_format($row->dbam, 2);
            $sub_arr[] = number_format($row->cram, 2);

            $data[] = $sub_arr;
            $i = $i + 1;
        }
        $len = $query->num_rows();
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $len,
            "recordsFiltered" => $len,
            "data" => $data,
        );

        echo json_encode($output);
    }

// GET LOAN COMMENT
    function getLoanCommnt()
    {
        $lnid = $this->input->post('lnid');
        $this->db->select("comments.cmnt,comments.crdt,comments.crby,comments.cmmd, IFNULL(CONCAT(user_mas.fnme,' ' ,user_mas.lnme ),'System Comment') AS usr");
        $this->db->from("comments");
        $this->db->join('user_mas', 'user_mas.auid = comments.crby', 'left');
        $this->db->where('comments.cmrf', $lnid);
        $this->db->where('comments.cmtp', 2);
        $this->db->where('comments.stat', '1');
        $this->db->order_by('comments.crdt', 'asc');
        $query = $this->db->get();
        $result = $query->result();
        echo json_encode($result);
    }

// ADD LOAN COMMENT
    function addLncmnt()
    {
        $lnid = $this->input->post('lnid');
        $cmnt = ucwords(strtolower($this->input->post('cmnt')));
        $data_arr = array(
            'cmtp' => 2,
            'cmmd' => 1,
            'cmrf' => $lnid,
            'cmnt' => $cmnt,
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('comments', $data_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('nicSearchDtils');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add Loan comment (' . $cmnt . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

// GET CUSTOMER COMMENT
    function getCustCommnt()
    {
        $cuid = $this->input->post('cuid');
        $this->db->select("comments.cmid,comments.cmnt,comments.crdt,comments.crby,comments.cmmd, IFNULL(CONCAT(user_mas.fnme,' ' ,user_mas.lnme ),'System Comment') AS usr");
        $this->db->from("comments");
        $this->db->join('user_mas', 'user_mas.auid = comments.crby', 'left');
        $this->db->where('comments.cmrf', $cuid);
        $this->db->where('comments.cmtp', 1);
        $this->db->where('comments.stat', '1');
        $this->db->order_by('comments.crdt', 'asc');
        $query = $this->db->get();
        $result = $query->result();
        echo json_encode($result);

    }

// GET UNSEEN CUSTOMER COMMENT
    function getUnseenCustCommnt()
    {
        $cuid = $this->input->post('cuid');
        $query = $this->Generic_model->getData('comments', '', array('cmrf' => $cuid, 'cmtp' => 1)); //, 'seen' => 0

        echo json_encode($query);
    }

    // UNSEEN COMMENT CHANGE TO SEEN COMMENT MODE
    function custCommntSeen()
    {
        $cuid = $this->input->post('cuid');
        $query = $this->Generic_model->getData('comments', '', array('cmrf' => $cuid, 'cmtp' => 1, 'seen' => 0));

        $len = sizeof($query);
        $cun = 0;
        for ($a = 0; $a < $len; $a++) {
            $data_arr1 = array(
                'seen' => 1,
                'snby' => $_SESSION['userId'],
                'sndt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'cmid' => $query[$a]->cmid
            );
            $result1 = $this->Generic_model->updateData('comments', $data_arr1, $where_arr);
            $cun = $cun + 1;
        }

        if ($len == $cun) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

// ADD CUSTOMER COMMENT
    function addCustcmnt()
    {
        $ccuid = $this->input->post('ccuid');
        $cmnt = ucwords(strtolower($this->input->post('cust_cmnt')));

        $data_arr = array(
            'cmtp' => 1,
            'cmmd' => 1,
            'cmrf' => $ccuid,
            'cmnt' => $cmnt,
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );

        $funcPerm = $this->Generic_model->getFuncPermision('nicSearchDtils');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add Customer comment (' . $cmnt . ')');

        $result = $this->Generic_model->insertData('comments', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }
// END NIC SEARCH
//
// CHEQUE BOOK
    function cheq_book()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('cheq_book');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['bnkaccinfo'] = $this->getBankAcc();

        $this->load->view('modules/user/cheque_book', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchChqbook()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cheq_book');
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
        $bkid = $this->input->post('bkid');

        $this->db->select("chq_book.*,bnk_accunt.acnm,bnk_accunt.acno,  brch_mas.brnm,CONCAT(user_mas.fnme) AS usr ,
        DATE_FORMAT(chq_book.crdt, '%Y-%m-%d') AS ccrdt, IF(DATE_FORMAT(chq_book.lidt, '%Y-%m-%d') = '0000-00-00' ,' - ',DATE_FORMAT(chq_book.lidt, '%Y-%m-%d')) AS lsdt ,IFNULL(chq_issu.cqno,'-') AS cqno ,
         IFNULL(CONCAT(aa.fnme),' - ') AS lsu    ");
        $this->db->from("chq_book");
        $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_book.bkac');
        $this->db->join('brch_mas', 'brch_mas.brid = chq_book.brid');
        $this->db->join('user_mas', 'user_mas.auid = chq_book.crby');

        $this->db->join('chq_issu', 'chq_issu.cqid = chq_book.nfis', 'left');
        $this->db->join('user_mas aa', 'aa.auid = chq_book.liby', 'left');

        if ($brch != 'all') {
            $this->db->where('chq_book.brid', $brch);
        }
        if ($bkid != 'all') {
            $this->db->where('chq_book.bkac', $bkid);
        }

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '0') {  // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtChqbk($row->cqid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtChqbk($row->cqid,this.id);' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecChqbk($row->cqid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt' " . $edt . "  data-toggle='modal' data-target='#modalEdt' onclick='edtChqbk($row->cqid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtChqbk();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecChqbk($row->cqid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtChqbk(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtChqbk();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvChqbk($row->cqid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;        //brnc
            $sub_arr[] = " <span title='$row->acnm '> $row->acno </span> ";       //acc nm
            $sub_arr[] = $row->pgst;
            $sub_arr[] = $row->nfis . ' of ' . $row->nfpg;         //no of pg
            $sub_arr[] = $row->cqno;
            $sub_arr[] = $row->lsu;         //lst iss by
            $sub_arr[] = $row->lsdt;         //lst iss dt
            $sub_arr[] = $row->usr;
            $sub_arr[] = $row->ccrdt;        //cr dt
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    function addCheqbook()
    {
        $brid = $this->input->post('brch');
        $bkac = $this->input->post('bkac');
        $pgst = $this->input->post('stpg');
        $nfpg = $this->input->post('nfpg');
        $pgnd = $pgst + $nfpg - 1;

        // CHQ BOOK ADD
        $data_arr = array(
            'brid' => $brid,
            'bkac' => $bkac,
            'pgst' => $pgst,
            'nfpg' => $nfpg,
            'pgnd' => $pgnd,

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('chq_book', $data_arr);

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('cheq_book');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Cheque book ()');
    }

    function vewChqbk()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('chq_book', '', array('cqid' => $auid));
        echo json_encode($result);
    }

    // Update
    function edtChqbook()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        $brid = $this->input->post('brch_edt');
        $bkac = $this->input->post('bkac_edt');
        $pgst = $this->input->post('stpg_edt');
        $nfpg = $this->input->post('nfpg_edt');
        $pgnd = $pgst + $nfpg - 1;

        // CHEQUE BOOK UPDATE
        if ($func == 1) {
            $data_ar1 = array(
                'brid' => $brid,
                'bkac' => $bkac,
                'pgst' => $pgst,
                'nfpg' => $nfpg,
                'pgnd' => $pgnd,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'cqid' => $auid
            );
            $result22 = $this->Generic_model->updateData('chq_book', $data_ar1, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('cheq_book');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque book update id(' . $auid . ')');

            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }

            //    CHEQUE BOOK APPROVAL
        } elseif ($func == 2) {
            $data_ar1 = array(
                'brid' => $brid,
                'bkac' => $bkac,
                'pgst' => $pgst,
                'nfpg' => $nfpg,
                'pgnd' => $pgnd,

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'cqid' => $auid
            );
            $result22 = $this->Generic_model->updateData('chq_book', $data_ar1, $where_arr);
            if ($result22) {
                $chk = $chk + 1;
            }

            // CHQ LEAF ADD
            for ($a = 0; $a < $nfpg; $a++) {

                $cc = strlen($pgst);
                if ($cc == 1) {
                    $xx = '00000' . $pgst;
                } else if ($cc == 2) {
                    $xx = '0000' . $pgst;
                } else if ($cc == 3) {
                    $xx = '000' . $pgst;
                } else if ($cc == 4) {
                    $xx = '00' . $pgst;
                } else if ($cc == 5) {
                    $xx = '0' . $pgst;
                } else if ($cc == 6) {
                    $xx = $pgst;
                }

                $data_arr = array(
                    'brco' => $brid,
                    'accid' => $bkac,
                    'cqbk' => $auid,
                    'cqno' => $xx
                );
                $result = $this->Generic_model->insertData('chq_issu', $data_arr);

                $pgst = $pgst + 1;
            }
            if ($nfpg == $a) {
                $chk = $chk + 1;
            }

            $funcPerm = $this->Generic_model->getFuncPermision('cheq_book');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque book approval id(' . $auid . ')');

            /*if ($chk == 2) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }*/

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

    function rejChqbk()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('chq_book', array('stat' => 2), array('cqid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('cheq_book');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque book Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //  reactive
    function reactChqbk()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('chq_book', array('stat' => 1), array('cqid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('cheq_book');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque book Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END CHEQUE BOOK
//
//
// LOAN DISBURSEMENT CHECK
    public function dsbs_chck()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        //$data['stainfo'] = $this->Generic_model->getData('loan_stat', array('stid,stnm'), array('isac' => 1), '');
        $data['stainfo'] = $this->Generic_model->getData('loan_stat', array('stid,stnm'), "isac = 1 AND stid IN(5,6)", '');

        $this->load->view('modules/user/loan_disbursement_check', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchDisbursLoan()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('dsbs_chck');

        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }

        $result = $this->User_model->get_disbursLoan();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {

            if ($row->ckby == 0) {
                $md = " <span class='label label-warning'> Uncheck</span> ";
                $option = "<label class=''><input type='checkbox' name='chck[" . $i . "]' value='1' id='checkbox-1' $app class='icheckbox' /> </label>";
            } else {
                $md = " <span class='label label-success'> Check </span> ";
                $option = "<label class=''><input type='checkbox' name='chck[" . $i . "]' value='1' id='checkbox-1' disabled class='icheckbox' checked='checked'/> </label>";
            }

            $hidden = "<input type='hidden'  name='lnid[" . $i . "]' value='" . $row->lnid . "'>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $row->init; // cust name
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($row->loam, 2, '.', ',');
            $sub_arr[] = $row->noin . ' ' . $row->pymd;
            $sub_arr[] = $md;
            $sub_arr[] = $row->dsdt;
            $sub_arr[] = $row->chkby;
            $sub_arr[] = $row->ckdt;
            $sub_arr[] = $option . $hidden;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_disbursLoan(),
            "recordsFiltered" => $this->User_model->count_filt_disbursLoan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // Disbursement Check add
    function dsbsAdd()
    {
        $len = $this->input->post('len');
        $lpcount = 0; // looping count

        for ($a = 0; $a < $len; $a++) {
            $lnid = $this->input->post("lnid[" . $a . "]");      // loan id
            $chck = $this->input->post("chck[" . $a . "]");      // if check  0 - no 1 - chck

            if ($chck == 1) {
                $data_arr = array(
                    'ckby' => $_SESSION['userId'],
                    'ckdt' => date('Y-m-d H:i:s'),
                );
                $rest1 = $this->Generic_model->updateData('micr_crt', $data_arr, array('lnid' => $lnid));
            } else {
            }
            $lpcount = $lpcount + 1;
        }

        $funcPerm = $this->Generic_model->getFuncPermision('dsbs_chck');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan Disbursement Check');

        if ($lpcount == $len) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
    // End Disbursement Check

// END LOAN DISBURSEMENT CHECK
//
// LOAN REPAYMENT CHECK
    function rpmt_chck()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['recptrtn'] = $this->Generic_model->getData('recpt_rtn_det', '', array('stat' => 1));

        $this->load->view('modules/user/repayment_check', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function getRepaymt()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpmt_chck');
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }

        $todt = $this->input->post('todt');
        $today = date("Y-m-d");
        if ($todt == $today) {
            $disb = "";
        } else {
            $disb = "disabled";
        }

        $result = $this->User_model->get_rpymtDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $reid = $row->reid;
            $ramt = $row->ramt;
            if ($row->stat != 3) {
                if ($row->dnst == 1 || $row->dnst == 2) {
                    $cbx = "<button type='button' id='rej' disabled data-toggle='modal' data-target='#modalReject' onclick='recptReject(  );' class='btn btn-default btn-condensed' title='Denomination Added'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                } else {
                    $cbx = "<button type='button' id='rej' $rej data-toggle='modal' data-target='#modalReject' onclick='recptReject( $reid , $ramt );' class='btn btn-default btn-condensed' title='Reject'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
                }
            } else {
                $cbx = "<button type='button' id='rej' $rej disabled data-toggle='modal' data-target='#modalReject' onclick='recptReject('');' class='btn btn-default btn-condensed' title='Settlement Receipts' ><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button> ";
            }

            if ($row->lnbr == $row->rcbr) {
                $lnno = $row->acno;
            } else {
                $lnno = " <label style='color: red' title='Other Branch Loan'> " . $row->acno . "</label> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->init; // cust name
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $lnno;
            $sub_arr[] = $row->reno;
            $sub_arr[] = number_format($row->ramt, 2, '.', ',');
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $cbx;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_recpt(),
            "recordsFiltered" => $this->User_model->count_filtered_recpt(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // repayment cancellation
    function repymtCancel()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $user = $this->Generic_model->getData('user_mas', array('auid', 'usnm', 'brch'), array('auid' => $_SESSION['userId']));
        $rid = $this->input->post("reid");      // recipt id

// GET ACCOUNT BALANCE
        /*$this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp,
                SUM(`schg`) AS avsc, SUM(`duam`) AS tdua, SUM(`ream`) AS trpa, SUM(`ovpm`) AS ovpm  ");
        $this->db->from("micr_crleg");
        $this->db->where('acid', $lnid);
        $this->db->where('stat IN(1,2) ');
        $acdt = $this->db->get()->result();

        $cboc = round($acdt[0]->avcp, 2); // CAPITAL
        $cboi = round($acdt[0]->avin, 2); // INTEREST
        $aboc = round($acdt[0]->arcp, 2); // ARR CAP
        $aboi = round($acdt[0]->arin, 2); // ARR INT
        $avdp = round($acdt[0]->avdp, 2); // PENALTY
        $avsc = round($acdt[0]->avsc, 2); // CHARGES

        $tdua = round($acdt[0]->tdua, 2); // TTL DUE
        $trpa = round($acdt[0]->trpa, 2); // TTL PYMT
        $ovpm = round($acdt[0]->ovpm, 2); // TTL OVPY*/

//Calculate Recovery Balances
        /*$rcsc = $rcpe = $rcin = $rccp = $rcod = 0;
        if ($ramt >= ($avsc + $avdp + $aboi + $aboc)) { //PAY AMT+CRDT >= SCHG+DFPN+ARINT+ARCAP
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = $aboi;//-->
            $rccp = $aboc;//-->
            $rcod = (($ramt) - ($avsc + $avdp + $aboi + $aboc));
        } else if ($ramt >= ($avsc + $avdp + $aboi)) { //PAY AMT+CRDT >= SCHG+DFPN+ARINT
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = $aboi;
            $rccp = round(($ramt - ($avsc + $avdp + $aboi)), 2);
        } else if ($ramt >= ($avsc + $avdp)) { //PAY AMT+CRDT >= SCHG+DFPN
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = round(($ramt - ($avsc + $avdp)), 2);
        } else if ($ramt >= ($avsc)) { //PAY AMT+CRDT >= SCHG
            $rcsc = $avsc;
            $rcpe = round(($ramt - $avsc), 2);
        } else { //PAY AMT+CRDT > 0
            $rcsc = round($ramt, 2);
        }*/

// # RECEIPTS TB UPDATE
        $data_arrrup = array(
            'stat' => 0,
            'trdt' => date('Y-m-d H:i:s'),
            'trby' => $_SESSION['userId'],
            'trmk' => $this->input->post("resn")
        );
        $rest1 = $this->Generic_model->updateData('receipt', $data_arrrup, array('reid' => $rid));

// MICRO LEDGE @1
        $rcdt = $this->Generic_model->getData('micr_crleg', '', array('reid' => $rid, 'dsid' => 2));
        $data_mclg1 = array(
            'acid' => $rcdt[0]->acid, // LOAN ID
            'acno' => $rcdt[0]->acno, // LOAN NO
            'ledt' => date('Y-m-d H:i:s'),
            'reno' => $rcdt[0]->reno,
            'reid' => $rid,
            'dsid' => 5,        // PAYMENT RETURN
            'dcrp' => 'PYMT RTN By : ' . $user[0]->usnm,

            'avcp' => -($rcdt[0]->avcp),
            'avin' => -($rcdt[0]->avin),
            'capt' => -($rcdt[0]->capt),
            'inte' => -($rcdt[0]->inte),
            'dpet' => -($rcdt[0]->dpet),
            'schg' => -($rcdt[0]->schg),
            'duam' => -($rcdt[0]->duam),
            'ream' => -($rcdt[0]->ream),
            'ovpm' => -($rcdt[0]->ovpm),

            'stat' => 1,
        );
        $result5 = $this->Generic_model->insertData('micr_crleg', $data_mclg1);


// ACCOUNT LEDGER RECODE RETURN
        $acdt = $this->Generic_model->getData('acc_leg', '', array('rfno' => $rid, 'trid' => 2));
        $lnid = $rcdt[0]->acid;
        $len2 = sizeof($acdt);
        for ($n = 0; $n < $len2; $n++) {
            $data_aclg23 = array(
                'brno' => $acdt[$n]->brno, // BRANCH ID
                'lnid' => $acdt[$n]->lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'Receipt Return',
                'trid' => 5,
                'rfno' => $acdt[$n]->rfno,
                'rfna' => $acdt[$n]->rfna,
                'dcrp' => 'PYMT RTN By : ' . $user[0]->usnm,

                'acco' => $acdt[$n]->acco,    // cross acc code
                'spcd' => $acdt[$n]->spcd,    // split acc code
                'acst' => $acdt[$n]->acst,      //
                'dbam' => $acdt[$n]->cram,      // db amt
                'cram' => $acdt[$n]->dbam,      // cr amt
                'stat' => 0
            );
            $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);
        }

// GET NEW ACCOUNT BALANCE
        $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp,
                        SUM(`schg`) AS avsc, SUM(`ovpm`) AS ovpm , SUM(`duam`) AS duam, SUM(`ream`) AS ream");
        $this->db->from("micr_crleg");
        $this->db->where('acid', $lnid);
        $this->db->where('stat IN(1,2) ');
        $acdt = $this->db->get()->result();

        $cboc = round($acdt[0]->avcp, 2); // CAPITAL
        $cboi = round($acdt[0]->avin, 2); // INTEREST
        $aboc = round($acdt[0]->arcp, 2); // ARR CAP
        $aboi = round($acdt[0]->arin, 2); // ARR INT
        $avpe = round($acdt[0]->avdp, 2); // PENALTY
        $avdb = round($acdt[0]->avsc, 2); // CHRGES
        $ovpm = round($acdt[0]->ovpm, 2); // OVER PYMNT
        $duam = round($acdt[0]->duam, 2); //Due Amount
        $ream = round($acdt[0]->ream, 2); //Repayment Total

//loan balance update @+1
//UPDATE micr_crt @1
        $data_arrrup = array(
            'boc' => $cboc,
            'boi' => $cboi,
            'aboc' => $aboc,
            'aboi' => $aboi,
            'avpe' => $avpe,
            'avdb' => $avdb,
            'avcr' => round($ream - $duam, 2), // $ovpm

            //'lspa' => $ramt,
            //'lspd' => date('Y-m-d H:i:s'),
            //'lstp' => 1,
        );
        $rest1 = $this->Generic_model->updateData('micr_crt', $data_arrrup, array('lnid' => $lnid));


        $funcPerm = $this->Generic_model->getFuncPermision('rpmt_chck');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Repayment cancellation');


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }
// END  REPAYMENT CHECK
//
// OTHER PAYMENT  (DOC,INSU,SERVICE CHARGE AND Others)
    function otpymt()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['chginfo'] = $this->Generic_model->getData('chg_type', '', array('stat' => 1));
        $data['pay_at'] = $this->Generic_model->getData('pay_at', '', '');
        $data['pay_by'] = $this->Generic_model->getData('pay_by', '', '');
        $data['payinfo'] = $this->Generic_model->getData('pay_terms', '', array('stat' => 1));

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('otpymt');
        $this->load->view('modules/user/other_payment', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchPymt()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('otpymt');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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

        $disabled = "disabled";

        $result = $this->User_model->get_othrPymnt();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->auid;

            if ($row->stat == 0) {
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt' $viw data-toggle='modal' data-target='#modalEdit' onclick='edtPymt($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' $app  id='app' data-toggle='modal' data-target='#modalEdit' onclick='edtPymt($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej  onclick='rejecPymt($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } elseif ($row->stat == 1) {  // if main statues approval
                $stat = "<span class='label label-success'> Approval</span> ";
                $app2 = "disabled";

                $option = "<button type='button' id='edt' $app2 data-toggle='modal' data-target='#modalEdit' onclick='edtPymt($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' $app $app2 id='app' data-toggle='modal' data-target='#modalEdit' onclick='edtPymt($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej $app2 onclick='rejecPymt($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 2) {
                $stat = "<span class='label label-danger'> Reject </span> ";
                $option = "<button type='button' id='edt' $viw data-toggle='modal' data-target='#modalEdit' onclick='edtPymt($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='app' data-toggle='modal' data-target='#modalEdit' onclick='edtPymt($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled onclick='rejecPymt($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->init; // cust name
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->modt;
            $sub_arr[] = number_format($row->pymt, 2, '.', ',');
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_otpymt(),
            "recordsFiltered" => $this->User_model->count_filtered_otpymt(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // GET LOAN DETILS
    function getLndtils()
    {
        $lnno = $this->input->post('lnno');
        $chtp = $this->input->post('chtp');

        $this->db->select("cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,micr_crt.lnid,micr_crt.docg,micr_crt.incg");
        $this->db->from("micr_crt");

        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->where('micr_crt.acno', $lnno);
        if ($chtp == 1) {
            $this->db->where('micr_crt.stat', 2);
        } else if ($chtp == 3) {
            $this->db->where('micr_crt.stat', 5);
        }

        $query = $this->db->get();
        $data = $query->result();

        echo json_encode($data);
    }

    // add other payment
    function addPaymnt()
    {
        $lnid = $this->input->post('lnid');
        $chtp = $this->input->post('chtp');

        $acdt = $this->Generic_model->getData('oter_payment', '', "lnid = $lnid AND pytp = $chtp AND stat IN(0,1) ");


        if ($chtp == 1 && count($acdt) > 0) {
            echo json_encode("alredy");
        } else {
            $data_arr = array(
                'pybr' => $this->input->post('pybrn'),
                'pytp' => $chtp,
                'lnid' => $lnid,
                'pymt' => $this->input->post('pyam'),
                'pymd' => $this->input->post('pymd'),
                'pyby' => $this->input->post('pyby'),
                'pyat' => $this->input->post('pyat'),
                'stat' => 0,

                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('oter_payment', $data_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('otpymt');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Other payment add (' . $lnid . ')');

            if (count($result) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }
    }

    function vewPymnt()
    {
        $auid = $this->input->post('auid');
        $this->db->select("oter_payment.*,cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,micr_crt.acno, micr_crt.docg,micr_crt.incg");
        $this->db->from("oter_payment");
        $this->db->join('micr_crt', 'micr_crt.lnid = oter_payment.lnid');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->where('oter_payment.auid', $auid);

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // payment edit and approval
    function edtPymnt()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');
        $lnid = $this->input->post('lnid_edt');
        $pymt = $this->input->post('pyam_edt');
        $pybr = $this->input->post('pybrn_edt');

        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($func == '1') {                  // update
            $data_arr = array(
                'pybr' => $pybr,
                'pytp' => $this->input->post('chtp_edt'),
                'lnid' => $lnid,
                'pymt' => $pymt,
                'pymd' => $this->input->post('pymd_edt'),
                'pyby' => $this->input->post('pyby_edt'),
                'pyat' => $this->input->post('pyat_edt'),

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );

            $where_arr = array(
                'auid' => $auid
            );

            $result22 = $this->Generic_model->updateData('oter_payment', $data_arr, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('otpymt');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Edit Payment (' . $auid . ')');

            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }

        } elseif ($func == '2') {            // approval

            $data_arr = array(
                'pybr' => $pybr,
                'pytp' => $this->input->post('chtp_edt'),
                'lnid' => $lnid,
                'pymt' => $pymt,
                'pymd' => $this->input->post('pymd_edt'),
                'pyby' => $this->input->post('pyby_edt'),
                'pyat' => $this->input->post('pyat_edt'),

                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
                'stat' => 1
            );

            $where_arr = array(
                'auid' => $auid
            );

            $result22 = $this->Generic_model->updateData('oter_payment', $data_arr, $where_arr);

// RECEIPTS PROCESS
            $user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
            $brn = $user[0]->brch;

            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn));
            $brcd = $brdt[0]->brcd;

            $lndt = $this->Generic_model->getData('micr_crt', array('apid', 'acno', 'docg', 'incg'), array('lnid' => $lnid));
            $apid = $lndt[0]->apid; // cust id
            $acno = $lndt[0]->acno; // loan no

            $this->db->select("reno");
            $this->db->from("receipt");
            $this->db->where('receipt.brco ', $brn);
            $this->db->where('receipt.retp ', 1);
            $this->db->order_by('receipt.reid', 'desc');

            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            $yr = date('y');
            if (count($data) == '0') {
                $reno = $brcd . '/GR/' . $yr . '/00001';
            } else {
                $reno = $data[0]->reno;
                $re = (explode("/", $reno));
                $aa = intval($re[3]) + 1;

                $cc = strlen($aa);
                // next loan no
                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '' . $aa;
                }

                $reno = $brcd . '/GR/' . $yr . '/' . $xx;
            }
// END RECEIPTS PROCESS

// DETAILS ENTER RECIPET TABLE
            $data_arr = array(
                'brco' => $brn,
                'reno' => $reno,
                'rfno' => $lnid, // loan id
                'retp' => 1,
                'ramt' => $pymt,
                'pyac' => 106,
                'pymd' => 8, // 8 -cash / 9 - inter account trnsfer
                'clid' => $apid, // cust id
                'stat' => 1,
                'remd' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('receipt', $data_arr);
            if ($result) {
                $chk = $chk + 1;
            }
            $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
            $reid = $recdt[0]->reid;


// END MICRO LEDGE @1

            $chrgtp = $this->input->post('chtp_edt');  // IF 1-DOC & INS /2-OTHER DOC/3-RCVER LETR/4-SERVICE CHRG

            if ($chrgtp == 1) {        //  DOCUMENT & INSURES CHARGE PAY BY CUSTOMER
                $result1a = $this->Generic_model->updateData('micr_crt', array('chpy' => 1), array('lnid' => $this->input->post('lnid_edt')));

                if ($pymt > 0) {
                    // DOCUMENT CHARGe PAY BY CUSTOMER
                    if ($lndt[0]->docg > 0) {

                        // RECIEPET DESCRPTION @1
                        $data_arr22 = array(
                            'reno' => $reno,
                            'reid' => $reid, // recpt id
                            'rfco' => 404,
                            'rfdc' => 'Document Charges',
                            'rfdt' => date('Y-m-d'),
                            'amut' => $lndt[0]->docg
                        );
                        $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                        if ($result22) {
                            $chk = $chk + 1;
                        }

                        // MICRO LEDGE @1
                        $data_mclg1 = array(
                            'acid' => $lnid, // LOAN ID
                            'acno' => $acno, // LOAN NO
                            'ledt' => date('Y-m-d H:i:s'),
                            'reno' => $reno,
                            'reid' => $reid,
                            'dsid' => 1,
                            'dcrp' => 'DOC CHG PAY BY CUST',
                            'schg' => -$lndt[0]->docg,
                            'ream' => $lndt[0]->docg,
                            'stat' => 1
                        );
                        $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
                        if ($result) {
                            $chk = $chk + 1;
                        }

                        // ACCOUNT LEDGE @1
                        $data_aclg23 = array(
                            'brno' => $pybr, // BRANCH ID
                            'lnid' => $lnid, // LOAN NO
                            'acdt' => date('Y-m-d H:i:s'),
                            'trtp' => 'ACNT DIFN - CHARGES',
                            'trid' => 1,
                            'rfna' => $acno,
                            'dcrp' => 'ACNT DIFN - CHARGES',

                            'acco' => 404,    // cross acc code
                            'spcd' => 106,    // split acc code
                            'acst' => '(106) Cash Book',      //
                            'dbam' => $lndt[0]->docg,      // db amt
                            'cram' => 0,      // cr amt
                            'stat' => 0
                        );
                        $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);
                        if ($result) {
                            $chk = $chk + 1;
                        }
                        $data_aclg45 = array(
                            'brno' => $pybr, // BRANCH ID
                            'lnid' => $lnid, // LOAN NO
                            'acdt' => date('Y-m-d H:i:s'),
                            'trtp' => 'ACNT DIFN - CHARGES',
                            'trid' => 1,
                            'rfna' => $acno,
                            'dcrp' => 'ACNT DIFN - CHARGES',

                            'acco' => 106,    // cross acc code
                            'spcd' => 404,    // split acc code
                            'acst' => '(404) Document Charge',      //
                            'dbam' => 0,      // db amt
                            'cram' => $lndt[0]->docg,      // cr amt
                            'stat' => 0
                        );
                        $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                        if ($result66) {
                            $chk = $chk + 1;
                        }

                        // END ACCOUNT LEDGE @1

                    } else {
                        $chk = $chk + 4;
                    }
                    // INSURES CHARGe PAY BY CUSTOMER
                    if ($lndt[0]->incg > 0) {
                        // RECEIPET DESCRPTION @2
                        $data_arr22 = array(
                            'reno' => $reno,
                            'reid' => $reid, // recpt id
                            'rfco' => 403,
                            'rfdc' => 'Insurance Charges',
                            'rfdt' => date('Y-m-d'),
                            'amut' => $lndt[0]->incg
                        );
                        $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                        if ($result22) {
                            $chk = $chk + 1;
                        }

                        // MICRO LEDGE @2
                        $data_mclg1 = array(
                            'acid' => $lnid, // LOAN ID
                            'acno' => $acno, // LOAN NO
                            'ledt' => date('Y-m-d H:i:s'),
                            'reno' => $reno,
                            'reid' => $reid,
                            'dsid' => 1,
                            'dcrp' => 'INS CHG PAY BY CUST',
                            'schg' => -$lndt[0]->incg,
                            'ream' => $lndt[0]->incg,
                            'stat' => 1
                        );
                        $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
                        if ($result) {
                            $chk = $chk + 1;
                        }

                        // ACCOUNT LEDGE @2
                        $data_aclg23 = array(
                            'brno' => $pybr, // BRANCH ID
                            'lnid' => $lnid, // LOAN ID
                            'acdt' => date('Y-m-d H:i:s'),
                            'trtp' => 'ACNT DIFN',
                            'trid' => 8,
                            'rfna' => $acno,
                            'dcrp' => 'ACNT DIFN',

                            'acco' => 403,    // cross acc code
                            'spcd' => 106,    // split acc code
                            'acst' => '(106) Cash Book',      //
                            'dbam' => $lndt[0]->incg,  // db amt
                            'cram' => 0,      // cr amt
                            'stat' => 0
                        );
                        $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);
                        if ($result) {
                            $chk = $chk + 1;
                        }
                        $data_aclg45 = array(
                            'brno' => $pybr, // BRANCH ID
                            'lnid' => $lnid, // LOAN ID
                            'acdt' => date('Y-m-d H:i:s'),
                            'trtp' => 'ACNT DIFN',
                            'trid' => 8,
                            'rfna' => $acno,
                            'dcrp' => 'ACNT DIFN',

                            'acco' => 106,    // cross acc code
                            'spcd' => 403,    // split acc code
                            'acst' => '(403) Insurance Charge',      //
                            'dbam' => 0,      // db amt
                            'cram' => $lndt[0]->incg,  // cr amt
                            'stat' => 0
                        );
                        $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                        if ($result66) {
                            $chk = $chk + 1;
                        }
                        // END ACCOUNT LEDGE @2
                    } else {
                        $chk = $chk + 4;
                    }
                }
            } else if ($chrgtp == 2) { // OTHER DOCUMENT CHRG

                if ($pymt > 0) {

                    // RECIEPET DESCRPTION @1
                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 408,
                        'rfdc' => 'Other Document Charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $pymt
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                    if ($result22) {
                        $chk = $chk + 1;
                    }

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 23,
                        'dcrp' => 'ODC CHR',
                        'schg' => -$pymt,
                        'ream' => $pymt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
                    if ($result) {
                        $chk = $chk + 1;
                    }

                    // ACCOUNT LEDGE @1
                    $data_aclg23 = array(
                        'brno' => $pybr, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ODC CHR',
                        'trid' => 27,
                        'rfna' => $reno,
                        'dcrp' => 'OTHER DOCUMENT CHARGES',

                        'acco' => 408,    // cross acc code
                        'spcd' => 106,    // split acc code
                        'acst' => '(106) Cash Book',      //
                        'dbam' => $pymt,      // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);
                    if ($result) {
                        $chk = $chk + 1;
                    }
                    $data_aclg45 = array(
                        'brno' => $pybr, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ODC CHRG',
                        'trid' => 27,
                        'rfna' => $reno,
                        'dcrp' => 'OTHER DOCUMENT CHARGES',

                        'acco' => 106,    // cross acc code
                        'spcd' => 408,    // split acc code
                        'acst' => '(408) Other Document Income',      //
                        'dbam' => 0,      // db amt
                        'cram' => $pymt,      // cr amt
                        'stat' => 0
                    );
                    $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                    if ($result66) {
                        $chk = $chk + 1;
                    }

                    // END ACCOUNT LEDGE @1

                } else {
                    $chk = $chk + 4;
                }

            } else if ($chrgtp == 3) { // RECOVER LETTER CHRG

                if ($pymt > 0) {

                    // RECIEPET DESCRPTION @1
                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 409,
                        'rfdc' => 'Recovery letter charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $pymt
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                    if ($result22) {
                        $chk = $chk + 1;
                    }

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 24,
                        'dcrp' => 'RLC CHRG',
                        'schg' => -$pymt,
                        'ream' => $pymt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
                    if ($result) {
                        $chk = $chk + 1;
                    }

                    // ACCOUNT LEDGE @1
                    $data_aclg23 = array(
                        'brno' => $pybr, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'RLC CHRG',
                        'trid' => 28,
                        'rfna' => $reno,
                        'dcrp' => 'RECOVERY LETTER CHARGES',

                        'acco' => 409,    // cross acc code
                        'spcd' => 106,    // split acc code
                        'acst' => '(106) Cash Book',      //
                        'dbam' => $pymt,      // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);
                    if ($result) {
                        $chk = $chk + 1;
                    }
                    $data_aclg45 = array(
                        'brno' => $pybr, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'RLC CHRG',
                        'trid' => 28,
                        'rfna' => $reno,
                        'dcrp' => 'RECOVERY LETTER CHARGES',

                        'acco' => 106,    // cross acc code
                        'spcd' => 409,    // split acc code
                        'acst' => '(409) Recovery Charges',      //
                        'dbam' => 0,      // db amt
                        'cram' => $pymt,      // cr amt
                        'stat' => 0
                    );
                    $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                    if ($result66) {
                        $chk = $chk + 1;
                    }

                    // END ACCOUNT LEDGE @1

                } else {
                    $chk = $chk + 4;
                }

            } else if ($chrgtp == 4) { // SERVICE CHRG

                if ($pymt > 0) {

                    // RECIEPET DESCRPTION @1
                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 401,
                        'rfdc' => 'Service Charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $pymt
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                    if ($result22) {
                        $chk = $chk + 1;
                    }

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 25,
                        'dcrp' => 'SRV CHRG',
                        'schg' => -$pymt,
                        'ream' => $pymt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
                    if ($result) {
                        $chk = $chk + 1;
                    }

                    // ACCOUNT LEDGE @1
                    $data_aclg23 = array(
                        'brno' => $pybr, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'SRV CHRG',
                        'trid' => 29,
                        'rfna' => $reno,
                        'dcrp' => 'SERVICE CHARGES',

                        'acco' => 401,    // cross acc code
                        'spcd' => 106,    // split acc code
                        'acst' => '(106) Cash Book',      //
                        'dbam' => $pymt,      // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);
                    if ($result) {
                        $chk = $chk + 1;
                    }
                    $data_aclg45 = array(
                        'brno' => $pybr, // BRANCH ID
                        'lnid' => $lnid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'SRV CHRG',
                        'trid' => 29,
                        'rfna' => $reno,
                        'dcrp' => 'SERVICE CHARGES',

                        'acco' => 106,    // cross acc code
                        'spcd' => 401,    // split acc code
                        'acst' => '(401) Service Charges',      //
                        'dbam' => 0,      // db amt
                        'cram' => $pymt,      // cr amt
                        'stat' => 0
                    );
                    $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                    if ($result66) {
                        $chk = $chk + 1;
                    }

                    // END ACCOUNT LEDGE @1

                } else {
                    $chk = $chk + 4;
                }

            } else {

            }

            $funcPerm = $this->Generic_model->getFuncPermision('otpymt');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Approval Payment (' . $auid . ')');

            /*if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }*/
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

    // payment reject
    function rejPymt()
    {
        // data remove in voucher table
        $auid = $this->input->post('id');
        $data_ar1 = array(
            'stat' => 2,
            'tmby' => $_SESSION['userId'],
            'tmdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('oter_payment', $data_ar1, array('auid' => $auid));

        $funcPerm = $this->Generic_model->getFuncPermision('otpymt');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Other payment reject auid(' . $auid . ')');

        if (count($result1) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
// END OTHER PAYMENT
//
// ISSUE CHEQUE
    function isue_cheq()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['bnkaccinfo'] = $this->getBankAcc();

        $this->load->view('modules/user/cheque_issue', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // search chq
    function srchIsuuChq()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('isue_cheq');
        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }

        $result = $this->User_model->get_isueeChq();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->cqid;

            if ($row->stat == 0) {
                if ($row->cqam == 0) {
                    $stat = "<span class='label label-info'> NOT ISSUE </span> ";
                    $viw = "disabled";
                } else {
                    $stat = "<span class='label label-warning'> Pending </span> ";
                    $viw = "";
                }
            } elseif ($row->stat == 1) {
                $stat = "<span class='label label-success'> Approval</span> ";
            } else if ($row->stat == 2) {
                $stat = "<span class='label label-danger'> Cancel </span> ";
            }

            $option = "<button type='button' $viw id='viw' data-toggle='modal' data-target='#modalView' onclick='viewChq($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->bknm;
            $sub_arr[] = $row->acnm;
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->cqno;
            $sub_arr[] = $row->ncqdt;
            $sub_arr[] = number_format($row->cqam, 2, '.', ',');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_isueeChq(),
            "recordsFiltered" => $this->User_model->count_filt_isueeChq(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // view issue cheque
    function vewIssueChq()
    {
        $this->db->select("chq_issu.*,  brch_mas.brnm ,voucher.vuno,voucher.pynm,bnk_accunt.acnm,bnk_accunt.acno ,user_mas.fnme ");
        $this->db->from("chq_issu");
        $this->db->join('voucher', 'voucher.void = chq_issu.vuid');
        $this->db->join('brch_mas', 'brch_mas.brid = chq_issu.brco');
        $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid');
        $this->db->join('user_mas', 'user_mas.auid = chq_issu.isui');
        $this->db->where('chq_issu.cqid', $brn = $this->input->post('chqid'));

        $query = $this->db->get();
        $cqdt = $query->result();
        echo json_encode($cqdt);
    }

// END ISSUE CHEQUE
//
// RECEIVE CHEQUE
    function recv_cheq()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('recv_cheq');
        $data['branchinfo'] = $this->Generic_model->getBranch();

        $this->load->view('modules/user/cheque_recive', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchRecvChq()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('recv_cheq');
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


        $brch = $this->input->post('brch');
        //$bkid = $this->input->post('bkid');

        $this->db->select("chq_recv.*,bnk_names.bknm, brch_mas.brnm,CONCAT(user_mas.usnm) AS usr    ");
        $this->db->from("chq_recv");
        $this->db->join('bnk_names', 'bnk_names.bkid = chq_recv.rcbk');
        $this->db->join('brch_mas', 'brch_mas.brid = chq_recv.brco');
        $this->db->join('user_mas', 'user_mas.auid = chq_recv.rcby');
        if ($brch != 'all') {
            $this->db->where('chq_recv.brco', $brch);
        }

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
//        $i = $_POST['start'];
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '0') {  // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt' onclick='deposChq($row->cqid,this.id);' class='btn  btn-default btn-condensed' title='Deposit Cheque'><i class='fa fa-plus' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  disabled onclick='rejecChqbk($row->cqid);' class='btn btn-default btn-condensed' title='Reject Cheque'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Deposit </span> ";
                $option = "<button type='button' id='edt' disabled  $edt  data-toggle='modal' data-target='#modalEdt' onclick='deposChq($row->cqid,this.id);' class='btn  btn-default btn-condensed' title='Deposit Cheque'><i class='fa fa-plus' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  disabled onclick='rejecChqbk($row->cqid);' class='btn btn-default btn-condensed' title='Reject Cheque'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = " <span class='label label-danger'> Cancel</span> ";
                $option = "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt' onclick='deposChq($row->cqid,this.id);' class='btn  btn-default btn-condensed' title='Deposit Cheque'><i class='fa fa-plus' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  disabled onclick='rejecChqbk($row->cqid);' class='btn btn-default btn-condensed' title='Reject Cheque'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;        //brnc
            $sub_arr[] = $row->rfno;        //refrence
            $sub_arr[] = $row->bknm;        //acc nm
            $sub_arr[] = $row->cqno;
            $sub_arr[] = $row->cqdt;       //
            $sub_arr[] = number_format($row->cqam, 2, '.', ',');
            $sub_arr[] = $row->usr;
            $sub_arr[] = $row->rcdt;        //cr dt
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    function vewRecvChq()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('chq_recv', '', array('cqid' => $auid));
        echo json_encode($result);
    }

    // DEPOSIT RECIVE CHQ
    function addRecvChq()
    {
        $brid = $this->input->post('brch_edt');
        $bkac = $this->input->post('bkac_edt');
        $auid = $this->input->post('auid');
        $amnt = $this->input->post('dpamt_edt');
        $remk = $this->input->post('remk_edt');
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        //  CHQ RECIVE UPDATE
        $data_ar1 = array(
            'stat' => 1,
            'reby' => $_SESSION['userId'],
            'redt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'cqid' => $auid
        );
        $result22 = $this->Generic_model->updateData('chq_recv', $data_ar1, $where_arr);
        if ($result22) {
            $chk = $chk + 1;
        }

        // BANK transaction ADD
        $data_arr = array(
            'brid' => $brid,
            'acid' => $bkac,
            'pytp' => 2,
            'dbam' => $amnt,
            'remk' => $remk,

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('bnk_trans', $data_arr);
        if ($result) {
            $chk = $chk + 1;
        }

        /*if ($chk == 2) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }*/
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('recv_cheq');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Receiving cheque deposit');
    }

    function rejChqbkXX()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('chq_book', array('stat' => 2), array('cqid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('recv_cheq');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque book Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

// END RECEIVE CHEQUE
//
// BANK CASH
    function bnk_cash()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('bnk_cash');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['bnkaccinfo'] = $this->getBankAcc();

        $this->load->view('modules/user/bank_cash', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function srchBankcash()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('bnk_cash');
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

        $result = $this->User_model->get_bankCash();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;

            // IF CHQ
            if ($row->pytp == 2) {
                $disb = "disabled";
                $md = " <span class='label label-primary'> CHQ </span> ";
            } else {
                $disb = "";
                $md = " <span class='label label-default'> CASH </span> ";
            }

            if ($st == '0') {  // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt'  $edt $disb  data-toggle='modal' data-target='#modalEdt' onclick='edtCshDep($row->trid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $edt   data-toggle='modal' data-target='#modalEdt' onclick='edtCshDep($row->trid,this.id);' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej   onclick='rejecCshDep($row->trid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Approval </span> ";
                $option = "<button type='button' id='edt'  $edt disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtCshDep($row->trid,this.id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtCshDep();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rej disabled  onclick='rejecCshDep($row->trid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = " <span class='label label-danger'> Cancel</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtCshDep(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled  data-toggle='modal' data-target='#modalEdt' onclick='edtCshDep();' class='btn  btn-default btn-condensed' title='Approval'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rej disabled  onclick='rejecCshDep($row->trid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;        //brnc
            $sub_arr[] = $row->bknm;
            $sub_arr[] = $row->acnm;
            $sub_arr[] = $row->acno;
            $sub_arr[] = number_format($row->dbam, 2, '.', ',');
            $sub_arr[] = number_format($row->cram, 2, '.', ',');
            $sub_arr[] = $md;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->crdt;

            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_bankCash(),
            "recordsFiltered" => $this->User_model->count_filtered_bankCash(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function addNewDeposit()
    {
        $data_arr = array(
            'brid' => $this->input->post('bkbr'),
            'acid' => $this->input->post('bkac'),
            'pytp' => 1,
            'dbam' => $this->input->post('dpamt'),
            'remk' => $this->input->post('remk'),

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('bnk_trans', $data_arr);

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('bnk_cash');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'New Cash Deposit ');
    }

    function vewDepstAmt()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('bnk_trans', '', array('trid' => $auid));
        echo json_encode($result);
    }

    // Update
    function edtDepstAmt()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        $brid = $this->input->post('brch_edt');
        $bkac = $this->input->post('bkac_edt');
        $dbam = $this->input->post('dpamt_edt');
        $remk = $this->input->post('remk_edt');

        // CASH DEPOSIT UPDATE
        if ($func == 1) {
            $data_ar1 = array(
                'brid' => $brid,
                'acid' => $bkac,
                'dbam' => $dbam,
                'remk' => $remk,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'trid' => $auid
            );
            $result22 = $this->Generic_model->updateData('bnk_trans', $data_ar1, $where_arr);


            $funcPerm = $this->Generic_model->getFuncPermision('bnk_cash');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cash deposit update id(' . $auid . ')');

            if (count($result22) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }

            //    CASH DEPOSIT APPROVAL
        } elseif ($func == 2) {
            $data_ar1 = array(
                'brid' => $brid,
                'acid' => $bkac,
                'dbam' => $dbam,
                'remk' => $remk,

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'trid' => $auid
            );
            $result22 = $this->Generic_model->updateData('bnk_trans', $data_ar1, $where_arr);
            if ($result22) {
                $chk = $chk + 1;
            }

            // ACCOUNT LEDGE @1
            $data_aclg23 = array(
                'brno' => $brid, // BRANCH ID
                //'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'Bank Transactions',
                //'rfna' => $acno,
                'trid' => 11,
                'rfno' => $bkac,
                'dcrp' => 'Bank Account Deposit',

                'acco' => 106,    // cross acc code
                'spcd' => 107,    // split acc code
                'acst' => '(107) Bank/Cash at Bank',      //
                'dbam' => $dbam,      // db amt
                'cram' => 0,      // cr amt
                'stat' => 0
            );
            $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);
            if ($result) {
                $chk = $chk + 1;
            }
            $data_aclg45 = array(
                'brno' => $brid, // BRANCH ID
                //'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'Bank Transactions',
                //'rfna' => $acno,
                'trid' => 11,
                'rfno' => $bkac,
                'dcrp' => 'Bank Account Deposit',

                'acco' => 107,    // cross acc code
                'spcd' => 106,    // split acc code
                'acst' => '(106) Cash Book',      //
                'dbam' => 0,      // db amt
                'cram' => $dbam,      // cr amt
                'stat' => 0
            );
            $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
            if ($result66) {
                $chk = $chk + 1;
            }

            // END ACCOUNT LEDGE @1

            $funcPerm = $this->Generic_model->getFuncPermision('bnk_cash');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cash deposit approval id(' . $auid . ')');

            /*if ($chk == 4) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }*/
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

    function rejecCshDep()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('bnk_trans', array('stat' => 2), array('trid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('bnk_cash');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cash Deposit Reject id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    //  reactive
    function reactChqbkXX2()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('chq_book', array('stat' => 1), array('cqid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('bnk_cash');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cheque book Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END BANK CASH
//
// LOAN SETTLEMENT
    function loan_setl()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('loan_setl');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['payinfo'] = $this->Generic_model->getData('pay_terms', '', array('stat' => 1));
        $data['bnkinfo'] = $this->Generic_model->getData('bnk_names', '', ''); //array('stat' => 1)

        $this->load->view('modules/user/loan_settlement', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // THIS FUNCTION CALL ON PENALTY REMOVE / EARLY SETTLEMENT / LOAN TERMINATION
    function vewCustStlDtils()
    {
        $lnno = $this->input->post('lnno');

        $this->db->select("cus_mas.*  ,cen_mas.cnno,cen_mas.cnnm, brch_mas.brnm,cus_sol.sode,cus_type.cutp,grup_mas.grno ,
         micr_crt.* ,product.prcd ,product.prnm ,prdt_typ.pymd , IFNULL(ml.dpet,0) AS dpet, IFNULL(ml.schg,0) AS schg , IFNULL(rc.ramt,0) AS ramt ");
        $this->db->from("cus_mas");
        $this->db->join('cus_mas_base', 'cus_mas_base.cuid = cus_mas.cuid');
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco');
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno', 'left');
        $this->db->join('micr_crt', 'micr_crt.apid = cus_mas.cuid', 'left');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        // SETTLEMENT BALANCE
        $this->db->join("(SELECT acid, SUM(`dpet`) AS dpet, SUM(`schg`) AS schg
                        FROM `micr_crleg` WHERE stat IN(1,2) AND  dsid IN(4,23,24,25) GROUP BY acid) AS ml", 'ml.acid = micr_crt.lnid ', 'left');
        $this->db->join("(SELECT rfno,SUM(ramt) AS ramt FROM `receipt` WHERE retp = 2 AND stat IN(1,2) GROUP BY rfno) AS rc", 'rc.rfno = micr_crt.lnid ', 'left');


        /*$this->db->select(" mc.lnid, mc.inam, mc.loam, mc.inta, rc.ramt, IFNULL(ml.dpet,0) AS dpet, IFNULL(ml.schg,0) AS schg");
        $this->db->from("micr_crt mc");
        $this->db->join("(SELECT acid, SUM(`dpet`) AS dpet, SUM(`schg`) AS schg
                        FROM `micr_crleg` WHERE stat IN(1,2) AND  dsid IN(4,23,24,25) GROUP BY acid) AS ml", 'ml.acid = mc.lnid ', 'left');
        $this->db->join("(SELECT rfno,SUM(ramt) AS ramt FROM `receipt` WHERE retp = 2 AND stat IN(1,2) GROUP BY rfno) AS rc", 'rc.rfno = mc.lnid ', 'left');
        $this->db->where('lnid', $lnid);*/

        $this->db->where('micr_crt.acno', $lnno);
        $this->db->where('micr_crt.stat', 5);
        $query = $this->db->get();

        echo json_encode($query->result());
    }

    function addLnSettlment()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $brch = $this->input->post('brch');
        $pydt = $this->input->post('pydt');
        $rbmt = $this->input->post('rbmt');     // Rebate value
        $pytp = $this->input->post('pytp');     // payment type
        $rbt = $this->input->post('rbt');      // Rebate  (if 1 - yes/ 0 - no )
        $rbtp = $this->input->post('rbtp');     // Rebate type ()
        $pymt = $this->input->post('pyamt');    // payment amount
        $lnid = $this->input->post('lnid');     // loan id
        $amut = $this->input->post('amut');     // originel amount

        $chk = 0;
        $pyac = 106; // CASH PAY

        // RECEIPTS PROCESS
        $user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
        $brn = $user[0]->brch;

        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn));
        $brcd = $brdt[0]->brcd;

        $lndt = $this->Generic_model->getData('micr_crt', array('apid', 'acno', 'docg', 'incg'), array('lnid' => $lnid));
        $apid = $lndt[0]->apid; // cust id
        $acno = $lndt[0]->acno; // loan no

        $this->db->select("reno");
        $this->db->from("receipt");
        $this->db->where('receipt.brco ', $brn);
        $this->db->where('receipt.retp ', 2);
        $this->db->order_by('receipt.reid', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $reno = $brcd . '/RP/' . $yr . '/00001';
        } else {
            $reno = $data[0]->reno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;

            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }
            $reno = $brcd . '/RP/' . $yr . '/' . $xx;
        }
// END RECEIPTS PROCESS

// RECEIPTS AND RECEIPTS DIS TB RECODE
        $data_arr = array(
            'brco' => $brn,
            'reno' => $reno,
            'rfno' => $lnid, // loan id
            'retp' => 2,
            'ramt' => $pymt,
            'pyac' => 106,
            'pymd' => $pytp,
            'clid' => $apid, // cust id
            'stat' => 1,
            'remd' => 1,
            // 'ssms' => $sms,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('receipt', $data_arr);

        $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
        $reid = $recdt[0]->reid;
        $data_arr22 = array(
            'reno' => $reno,
            'reid' => $reid, // recpt id
            'rfco' => 106,
            'rfdc' => 'SMNT FOR ' . $acno,
            'rfdt' => date('Y-m-d'),
            'amut' => $pymt
        );
        $result2 = $this->Generic_model->insertData('recp_des', $data_arr22);

// END RECEIPTS

// Rebate Payments @+1
        if ($rbt == 1) {

            $data_mclg1 = array(
                'acid' => $lnid, // LOAN ID
                'acno' => $acno, // LOAN NO
                'ledt' => date('Y-m-d H:i:s'),
                //'reno' => $reno,
                //'reid' => $reid,
                'dsid' => 14,
                'dcrp' => 'SMNT - ERLY RBT',

                'avcp' => 0,
                'avin' => 0,
                'capt' => 0,
                'inte' => 0,
                'dpet' => 0,
                'schg' => 0,
                'duam' => 0,
                'ream' => $rbmt,
                'stat' => 1,
            );
            $res11 = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

            $data_aclg23 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT - ERLY',
                'trid' => 16,
                'rfno' => $reid, // recpt id
                'rfna' => $reno,
                'dcrp' => 'SMNT - ERLY REBATE ',

                'acco' => 108,    // cross acc code
                'spcd' => 514,    // split acc code
                'acst' => '(514) Capital Lose',    //
                'dbam' => $amut - $pymt,    // db amt
                'cram' => 0,        // cr amt
                'stat' => 0
            );
            $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);

            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT - ERLY',
                'trid' => 16,
                'rfno' => $reid, // recpt id
                'rfna' => $reno,
                'dcrp' => 'SMNT - ERLY REBATE ',

                'acco' => 514,    // cross acc code
                'spcd' => 108,    // split acc code
                'acst' => '(108) Loan Stock',      //
                'dbam' => 0,      // db amt
                'cram' => $amut - $pymt,  // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }
//END REBET PAYMENT

// GET ACCOUNT BALANCE
        $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp,
                    SUM(`schg`) AS avsc , SUM(`ovpm`) AS ovpm ,a.inam, ((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage, SUM(`duam`) AS duam, SUM(`ream`) AS ream ");
        $this->db->from("micr_crleg");
        $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
        $this->db->where('acid', $lnid);
        $this->db->where('stat IN(1,2) ');
        $acdt = $this->db->get()->result();

        $cboc = round($acdt[0]->avcp, 2); // CAPITAL
        $cboi = round($acdt[0]->avin, 2); // INTEREST
        $aboc = round($acdt[0]->arcp, 2); // ARR CAP
        $aboi = round($acdt[0]->arin, 2); // ARR INT
        $avdp = round($acdt[0]->avdp, 2); // PENALTY
        $avsc = round($acdt[0]->avsc, 2); // CHARGES

        $tdua = round($acdt[0]->duam, 2); // TTL DUE
        $trpa = round($acdt[0]->ream, 2); // TTL PYMT
        $ovpm = round($acdt[0]->ovpm, 2); // TTL OVPY
        $cage = round($acdt[0]->cage, 2); // CURN AGE

//Calculate Recovery Balances
        $rcsc = $rcpe = $rcin = $rccp = $rcod = 0;
        if ($pymt >= ($avsc + $avdp + $aboi + $aboc)) { //PAY AMT+CRDT >= SCHG+DFPN+ARINT+ARCAP
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = $aboi;//-->
            $rccp = $aboc;//-->
            $rcod = (($pymt) - ($avsc + $avdp + $aboi + $aboc));
            //var_dump('A'.'***'.$rcod . '***'.$rccp);
        } else if ($pymt >= ($avsc + $avdp + $aboi)) { //PAY AMT+CRDT >= SCHG+DFPN+ARINT
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = $aboi;
            $rccp = round(($pymt - ($avsc + $avdp + $aboi)), 2);
            //var_dump('B');
        } else if ($pymt >= ($avsc + $avdp)) { //PAY AMT+CRDT >= SCHG+DFPN
            $rcsc = $avsc;
            $rcpe = $avdp;
            $rcin = round(($pymt - ($avsc + $avdp)), 2);
            //var_dump('C');
        } else if ($pymt >= ($avsc)) { //PAY AMT+CRDT >= SCHG
            $rcsc = $avsc;
            $rcpe = round(($pymt - $avsc), 2);
            //var_dump('D');
        } else { //PAY AMT+CRDT > 0
            $rcsc = round($pymt, 2);
            //var_dump('E');
        }

// MICRO LEDGE @1
        $data_mclg1 = array(
            'acid' => $lnid, // LOAN ID
            'acno' => $acno, // LOAN NO
            'ledt' => date('Y-m-d H:i:s'),
            'reno' => $reno,
            'reid' => $reid,
            'dsid' => 2,
            'dcrp' => 'PYMNT',

            'avcp' => (-$rccp),
            'avin' => (-$rcin),
            'capt' => (-$rccp),
            'inte' => (-$rcin),
            'dpet' => (-$rcpe),
            'schg' => (-$rcsc),
            'duam' => 0,
            'ream' => $pymt,
            'ovpm' => $rcod,

            'stat' => 1,
        );
        $res11 = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

// END MICRO LEDGE @1

// ACCOUNT LEDGER
        // settlement payment
        $data_aclg23 = array(
            'brno' => $brn, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'SMNT - ERLY',
            'trid' => 16,
            'rfno' => $reid, // recpt id
            'rfna' => $reno,
            'dcrp' => 'SMNT - ERLY ',

            'acco' => 108,    // cross acc code
            'spcd' => 106,    // split acc code
            'acst' => '(106) Cash Book',    //
            'dbam' => $pymt,    // db amt
            'cram' => 0,        // cr amt
            'stat' => 0
        );
        $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);

        $data_aclg45 = array(
            'brno' => $brn, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'SMNT - ERLY',
            'trid' => 16,
            'rfno' => $reid, // recpt id
            'rfna' => $reno,
            'dcrp' => 'SMNT - ERLY ',

            'acco' => 106,    // cross acc code
            'spcd' => 108,    // split acc code
            'acst' => '(108) Loan Stock',      //
            'dbam' => 0,      // db amt
            'cram' => $pymt,  // cr amt
            'stat' => 0
        );
        $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);

//Credit Penalty income @+1
        if ($rcpe > 0) {
            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT - ERLY',
                'trid' => 16,
                'rfno' => $reid, // recpt id
                'rfna' => $reno,
                'dcrp' => 'SMNT - ERLY ',

                'acco' => $pyac,    // cross acc code
                'spcd' => 402,    // split acc code
                'acst' => '(402) Penalty Income Account',      //
                'dbam' => 0,      // db amt
                'cram' => $rcpe,      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }

//Credit Service income @+1
        if ($rcsc > 0) {
            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT - ERLY',
                'trid' => 16,
                'rfno' => $reid, // recpt id
                'rfna' => $reno,
                'dcrp' => 'SMNT - ERLY ',

                'acco' => $pyac,    // cross acc code
                'spcd' => 401,    // split acc code
                'acst' => '(401) Service Charges',      //
                'dbam' => 0,      // db amt
                'cram' => $rcsc,      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }

//Credit Arrears @+1 with aboc + aboi
        if (($rcsc + $rcpe + $rcin + $rccp) > 0 && ($rcin + $rccp) > 0) {
            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'PYMNT',
                'trid' => 2,
                'rfno' => $reid, // recpt id
                'rfna' => $reno,
                'dcrp' => 'PYMNT ',

                'acco' => $pyac,    // cross acc code
                'spcd' => 110,    // split acc code
                'acst' => '(110) Receivable Arrears',      //
                'dbam' => 0,      // db amt
                'cram' => ($rcin + $rccp),      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }

//Credit OD @+1  over payment
        /*if ($rcod > 0) {
            $data_aclg45 = array(
                'brno' => $brn, // BRANCH ID
                'lnid' => $lnid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT - ERLY',
                'trid' => 16,
                'rfno' => $reid, // recpt id
                'rfna' => $reno,
                'dcrp' => 'SMNT - ERLY ',

                'acco' => $pyac,    // cross acc code
                'spcd' => 204,    // split acc code
                'acst' => '(204) Over Payments',      //
                'dbam' => 0,      // db amt
                'cram' => $rcod,      // cr amt
                'stat' => 0
            );
            $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        }*/

// MICRO LEDGE @1
        /* $data_mclg1 = array(
             'acid' => $lnid, // LOAN ID
             'acno' => $acno, // LOAN NO
             'ledt' => date('Y-m-d H:i:s'),
             'reno' => $reno,
             'reid' => $reid,
             'dsid' => 16,
             'dcrp' => 'SMNT - ERLY',

             'avcp' => (-$rccp),
             'avin' => (-$rcin),
             'ream' => $pymt,
             'ovpm' => $rcod,

             'stat' => 1,
             'paby' => 0,
             'paat' => 0,
         );
         $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);*/


// GET NEW ACCOUNT BALANCE
        $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp, 
                SUM(`schg`) AS avsc , SUM(`ovpm`) AS ovpm ,a.inam, ((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage , SUM(`duam`) AS duam, SUM(`ream`) AS ream,");
        $this->db->from("micr_crleg");
        $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
        $this->db->where('acid', $lnid);
        $this->db->where('stat IN(1,2) ');
        $acdt = $this->db->get()->result();

        $cboc = round($acdt[0]->avcp, 2); // CAPITAL
        $cboi = round($acdt[0]->avin, 2); // INTEREST
        $aboc = round($acdt[0]->arcp, 2); // ARR CAP
        $aboi = round($acdt[0]->arin, 2); // ARR INT
        $avdp = round($acdt[0]->avdp, 2); // PENALTY
        $avsc = round($acdt[0]->avsc, 2); // CHRGES
        $ovpm = round($acdt[0]->ovpm, 2); // OVER PYMNT
        $cage = round($acdt[0]->cage, 2); // CURN AGE
        $duam = round($acdt[0]->duam, 2); //Due Amount
        $ream = round($acdt[0]->ream, 2); //Repayment Total

        $ttl_lnbal = $cboc + $cboi + $avdp + $avsc;  // CAPITAL +  INTEREST + ARR CAP+ARR INT+PENALTY+CHARGES
        //$ttl_pybal = $ramt + $ovpm;                                  // TTL OVPY + REPAYMENT

//loan balance update @+1
//UPDATE micr_crt @1

        $ovr_bal = round($ream - $duam - $ttl_lnbal, 2); // OVER PAYMENT BALANCE
        // DUE TO NEGATIVE OVER PAYMENT VALIDATION
        if ($ovr_bal < 0) {
            $ovr_bal = 0;
        } else {
            $ovr_bal = $ovr_bal;
        }

        $data_1 = array(
            'avcp' => 0,
            'avin' => 0,
            'capt' => 0,
            'inte' => 0,
            'dpet' => 0,
            'schg' => 0,
        );
        $result5 = $this->Generic_model->updateData('micr_crleg', $data_1, array('reid' => $reid));

        $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp,
                    SUM(`schg`) AS avsc , SUM(`ovpm`) AS ovpm ,a.inam, ((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage, SUM(`duam`) AS duam, SUM(`ream`) AS ream ");
        $this->db->from("micr_crleg");
        $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
        $this->db->where('acid', $lnid);
        $this->db->where('stat IN(1,2) ');
        $acdt = $this->db->get()->result();

        $cboc = round($acdt[0]->avcp, 2); // CAPITAL
        $cboi = round($acdt[0]->avin, 2); // INTEREST
        $aboc = round($acdt[0]->arcp, 2); // ARR CAP
        $aboi = round($acdt[0]->arin, 2); // ARR INT
        $avdp = round($acdt[0]->avdp, 2); // PENALTY
        $avsc = round($acdt[0]->avsc, 2); // CHRGES
        $ovpm = round($acdt[0]->ovpm, 2); // OVER PYMNT
        $cage = round($acdt[0]->cage, 2); // CURN AGE
        $duam = round($acdt[0]->duam, 2); //Due Amount
        $ream = round($acdt[0]->ream, 2); //Repayment Total

        // MICRO LEDGE UPDATE
        $data_m1 = array(
            'dsid' => 16,
            'dcrp' => 'SMNT - ERLY',
            'avcp' => (-$cboc),
            'avin' => (-$cboi),
            'capt' => (-$aboc),
            'inte' => (-$aboi),
            'dpet' => (-$avdp),
            'schg' => (-$avsc),
            'duam' => round($ream - $duam, 2),
            'cage' => $cage,
            'ovpm' => $ovr_bal,
        );
        $result5 = $this->Generic_model->updateData('micr_crleg', $data_m1, array('reid' => $reid));

        // MICRO CART UPDATE
        $data_arrrup = array(
            'boc' => 0,
            'boi' => 0,
            'aboc' => 0,
            'aboi' => 0,
            'avpe' => 0,
            'avdb' => 0,
            'avcr' => $ovr_bal, //0
            'stat' => 3, // CHANGE LOAN STATUS
            'lspa' => $pymt,
            'lspd' => date('Y-m-d H:i:s'),
            'lstp' => 1,
            'stat' => 7,
            'cage' => $cage
        );
        $rest1 = $this->Generic_model->updateData('micr_crt', $data_arrrup, array('lnid' => $lnid));


        $funcPerm = $this->Generic_model->getFuncPermision('loan_setl');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan Early Settlement ' . $acno);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

// END LOAN SETTLEMENT
//
// LOAN PENALTY REMOVE
    function pnlt_remv()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('pnlt_remv');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['payinfo'] = $this->Generic_model->getData('pay_terms', '', array('stat' => 1));
        $data['bnkinfo'] = $this->Generic_model->getData('bnk_names', '', ''); //array('stat' => 1)

        $this->load->view('modules/user/loan_penalty_remove', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // CUSTOMER VIEW

    function removePenalty()
    {
        $brch = $this->input->post('brch');
        $pydt = $this->input->post('pydt');
        $rbmt = $this->input->post('rbmt');     // Rebate value
        $rbt = $this->input->post('rbt');      // Rebate  (if 1 - yes/ 0 - no )
        $rbtp = $this->input->post('rbtp');     // Rebate type ()
        $pymt = $this->input->post('pyamt');    // payment amount
        $lnid = $this->input->post('lnid');     // loan id
        $amut = $this->input->post('amut');     // originel amount

        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START
        //$pyac = 106; // CASH PAY

        // PROCESS
        $user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
        $brn = $user[0]->brch;

        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn));
        $brcd = $brdt[0]->brcd;

        $lndt = $this->Generic_model->getData('micr_crt', array('apid', 'acno', 'avpe', 'incg'), array('lnid' => $lnid));
        $apid = $lndt[0]->apid; // cust id
        $acno = $lndt[0]->acno; // loan no

        $yr = date('y');


// ACCOUNT LEDGER
        // settlement payment
        $data_aclg45 = array(
            'brno' => $brn, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'PENALTY',
            'trid' => 4,
            //'rfno' => $reid, // recpt id
            //'rfna' => $reno,
            'dcrp' => 'PENALTY REMOVE ',

            'acco' => 113,    // cross acc code
            'spcd' => 515,    // split acc code
            'acst' => '(515) Penalty Lose',      //
            'dbam' => $pymt,  // db amt
            'cram' => 0,  // cr amt
            'stat' => 0
        );
        $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        if ($result4) {
            $chk = $chk + 1;
        }

        $data_aclg23 = array(
            'brno' => $brn, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'PENALTY',
            'trid' => 4,
            //'rfno' => $reid, // recpt id
            //'rfna' => $reno,
            'dcrp' => 'PENALTY REMOVE',

            'acco' => 515,    // cross acc code
            'spcd' => 113,    // split acc code
            'acst' => '(113) Receivable Penalty',    //
            'dbam' => 0,     // db amt
            'cram' => $pymt, // cr amt
            'stat' => 0
        );
        $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);
        if ($result3) {
            $chk = $chk + 1;
        }

// MICRO LEDGE @1
        $data_mclg1 = array(
            'acid' => $lnid, // LOAN ID
            'acno' => $acno, // LOAN NO
            'ledt' => date('Y-m-d H:i:s'),
            //'reno' => $reno,
            //'reid' => $reid,
            'dsid' => 4,
            'dcrp' => 'PENALTY REMOVE',

            //'avcp' => (-$rccp),
            //'avin' => (-$rcin),
            //'capt' => (-$rccp),
            //'inte' => (-$rcin),
            'dpet' => (-$pymt),
            //'schg' => (-$rcsc),
            //'duam' => 0,
            //'ream' => $pymt,
            //'ovpm' => $rcod,

            'stat' => 1,
            'paby' => 0,
            'paat' => 0,
        );
        $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
        if ($result) {
            $chk = $chk + 1;
        }


//UPDATE micr_crt @1
        $data_arrrup = array(
            'avpe' => $lndt[0]->avpe - $pymt,
        );
        $rest1 = $this->Generic_model->updateData('micr_crt', $data_arrrup, array('lnid' => $lnid));
        if ($rest1) {
            $chk = $chk + 1;
        }


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('pnlt_remv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Penalty Remove Loan ' . $acno);
    }

// END PENALTY REMOVE
//
// LOAN TERMINATION
    function loan_trmi()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('loan_trmi');
        $this->load->view('modules/user/loan_termination', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    function getTrmiLn()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('loan_trmi');
        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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

        $result = $this->User_model->get_TrmiLn();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;


            if ($st == '0') {  // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='appViwTermiLon($row->trid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app  id='app' data-toggle='modal' data-target='#modalView' onclick='appViwTermiLon($row->trid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej  onclick='rejecVou($row->trid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Approval </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='appViwTermiLon($row->trid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled  id='app' data-toggle='modal' data-target='#modalView' onclick='appViwTermiLon($row->trid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej disabled onclick='rejecVou($row->trid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {  // Rejected
                $stat = " <span class='label label-danger'> Cancel</span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($row->trid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled  id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($row->trid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  disabled  onclick='rejecVou($row->trid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm . ' / ' . $row->cnnm;        //brnc
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->acno;
            $sub_arr[] = number_format($row->loam, 2, '.', ',');
            $sub_arr[] = number_format(($row->boc + $row->boi + $row->aboc + $row->aboi + $row->avpe), 2, '.', ',');
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->rqqdt;

            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_TrmiLn(),
            "recordsFiltered" => $this->User_model->count_filt_TrmiLn(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function addTermiLoan()
    {
        $data_arr = array(
            //'brco' => $this->input->post('rqbrch'),
            'lnid' => $this->input->post('lnid'),
            'rqby' => $_SESSION['userId'],
            'rqdt' => date('Y-m-d H:i:s'),
            'rqmk' => $this->input->post('remk'),
            'stat' => 0,
        );
        $result = $this->Generic_model->insertData('loan_trmi', $data_arr);

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('loan_trmi');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'New Loan Termination Requested ');
    }

    function vewTrmiLoanDtils()
    {
        $auid = $this->input->post('auid');

        $this->db->select("loan_trmi.*, cus_mas.init ,cus_mas.grno,cus_mas.cuno,cus_mas.anic,cus_mas.hoad,cus_mas.mobi,cus_mas.uimg ,
        cen_mas.cnno,cen_mas.cnnm, brch_mas.brnm,cus_sol.sode,cus_type.cutp,grup_mas.grno ,
         micr_crt.indt, micr_crt.mddt, micr_crt.loam, micr_crt.inam, micr_crt.boi, micr_crt.boc, micr_crt.aboc, micr_crt.aboi,micr_crt.avcr, 
         micr_crt.avpe, micr_crt.nxpn, micr_crt.noin,micr_crt.acno, product.prcd ,product.prnm ,prdt_typ.pymd  ");

        $this->db->from("loan_trmi");
        $this->db->join('micr_crt', 'micr_crt.lnid = loan_trmi.lnid');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco');
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno', 'left');

        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');

        $this->db->where('loan_trmi.trid', $auid);
        $query = $this->db->get();

        echo json_encode($query->result());
    }

    // Update
    function loanTerminApp()
    {
        $auid = $this->input->post('auid_app');
        $lnid = $this->input->post('lnid_app');
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

// LOAN TERMINATION TABLE UPDATE
        $data_ar1 = array(
            'stat' => 1,
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
            'apmk' => $this->input->post('remk_app'),
        );
        $where_arr = array(
            'trid' => $auid
        );
        $result11 = $this->Generic_model->updateData('loan_trmi', $data_ar1, $where_arr);
        if ($result11) {
            $chk = $chk + 1;
        }
// ACCOUNT LEDGER UPDATE
        $user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
        $brn = $user[0]->brch;

        $lndt = $this->Generic_model->getData('micr_crt', array('apid', 'acno', 'boc', 'boi', 'aboc', 'aboi', 'avcr', 'avdb', 'avpe'), array('lnid' => $lnid));
        $apid = $lndt[0]->apid; // cust id
        $acno = $lndt[0]->acno; // loan no

        $bal = ($lndt[0]->boc + $lndt[0]->boi + $lndt[0]->aboc + $lndt[0]->aboi + $lndt[0]->avdb + $lndt[0]->avpe) - $lndt[0]->avcr;

        $data_aclg23 = array(
            'brno' => $brn, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'TEMR',
            'trid' => 12,
            //'rfno' => $reid, // recpt id
            //'rfna' => $reno,
            'dcrp' => 'LOAN TERMINATION',

            'acco' => 108,    // cross acc code
            'spcd' => 514,    // split acc code
            'acst' => '(514) Capital Lose',    //
            'dbam' => $bal,   // db amt
            'cram' => 0,        // cr amt
            'stat' => 0
        );
        $result3 = $this->Generic_model->insertData('acc_leg', $data_aclg23);
        if ($result3) {
            $chk = $chk + 1;
        }

        $data_aclg45 = array(
            'brno' => $brn, // BRANCH ID
            'lnid' => $lnid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'TEMR',
            'trid' => 12,
            //'rfno' => $reid, // recpt id
            //'rfna' => $reno,
            'dcrp' => 'LOAN TERMINATION',

            'acco' => 514,    // cross acc code
            'spcd' => 108,    // split acc code
            'acst' => '(108) Loan Stock',      //
            'dbam' => 0,      // db amt
            'cram' => $bal,  // cr amt
            'stat' => 0
        );
        $result4 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
        if ($result4) {
            $chk = $chk + 1;
        }

// LOAN TABLE UPDATE
        $data_ar2 = array(
            'stat' => 12,
        );
        $where_arr2 = array(
            'lnid' => $lnid
        );
        $result22 = $this->Generic_model->updateData('micr_crt', $data_ar2, $where_arr2);
        if ($result22) {
            $chk = $chk + 1;
        }

        $funcPerm = $this->Generic_model->getFuncPermision('loan_trmi');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan Termination LNO:(' . $acno . ')');


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function rejecCshDepXX()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('bnk_trans', array('stat' => 2), array('trid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('loan_trmi');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Cash Deposit Reject id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

// END LOAN TERMINATION
//
// LOAN TOPUP
    function loan_tpup()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['stainfo'] = $this->Generic_model->getData('loan_stat', array('stid,stnm'), 'isac = 1 AND stid IN(1,4)', '');
        $data['prductinfo'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 1), '');
        $data['dynamicprd'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 2), '');

        $data['policyTpup'] = $this->Generic_model->getData('sys_policy', array('ponm,pov3,post'), array('popg' => 'loan_tpup', 'stat' => 1));
        $data['policyLoan'] = $this->Generic_model->getData('sys_policy', array('ponm,pov1,pov2,post'), array('popg' => 'loan', 'stat' => 1));
        $data['policyinfo'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2', 'pov3'), array('popg' => 'product', 'stat' => 1));
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('loan_tpup');

        $this->load->view('modules/user/loan_topup', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

// VIEW TOPUP USER DETAILS WITH LOAN
    function vewTpupCustDtils()
    {
        $lnno = $this->input->post('lnno');
        $this->db->select("cus_mas.init ,cus_mas.grno,cus_mas.cuno,cus_mas.anic,cus_mas.hoad,cus_mas.mobi,cus_mas.uimg ,
         cen_mas.cnno,cen_mas.cnnm, brch_mas.brnm,cus_sol.sode,cus_type.cutp,grup_mas.grno , micr_crt.lnid, micr_crt.brco,micr_crt.ccnt,micr_crt.clct,micr_crt.apid,micr_crt.prdtp,
         micr_crt.indt, micr_crt.mddt, micr_crt.loam, micr_crt.inam, micr_crt.boi, micr_crt.boc, micr_crt.aboc, micr_crt.aboi, micr_crt.avcr, 
         micr_crt.avpe, micr_crt.nxpn, micr_crt.noin,micr_crt.acno, product.prcd ,product.prnm ,prdt_typ.pymd ,bb.ttl ,
         IFNULL((SELECT lcnt FROM micr_crt WHERE apid = `cus_mas`.`cuid` ORDER BY cvdt DESC LIMIT 1 ), 0) AS lcnt");

        $this->db->from("cus_mas");
        $this->db->join('cus_mas_base', 'cus_mas_base.cuid = cus_mas.cuid');
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco');
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno', 'left');
        $this->db->join('micr_crt', 'micr_crt.apid = cus_mas.cuid', 'left');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');

        //$this->db->join('topup_loans', 'topup_loans.clno = micr_crt.lnid', 'left');
        $this->db->join("(SELECT b. clno , COUNT(*) AS ttl
                        FROM topup_loans b 
                        WHERE b.stat IN ('0','1')
						)AS bb ", 'bb.clno = micr_crt.lnid', 'left');

        $this->db->where('micr_crt.acno', $lnno);
        $this->db->where('micr_crt.stat', 5);

        $query = $this->db->get();
        $data['cudt'] = $query->result();

        // LOAN PAYMENT DETAILS
        $this->db->select("a.lnid, a.inam, a.noin, a.aboc, a.aboi, IFNULL(cc.ttl,0) AS ttl ");
        $this->db->from("micr_crt AS a");
        $this->db->join("(SELECT c.rfno, SUM(c.ramt) AS ttl
                        FROM receipt c 
                        WHERE c.retp='2' AND c.stat IN ('1','2')
						GROUP BY c.rfno)AS cc ", 'cc.rfno = a.lnid', 'left');

        //$this->db->where('a.lnid', $data['cudt'][0]->lnid);
        $this->db->where('a.acno', $lnno);
        $this->db->where('a.stat', 5);
        //$this->db->where('micr_crt.stat', 5);
        $query2 = $this->db->get();
        $data['pydt'] = $query2->result();

        echo json_encode($data);
    }

// APPLICATIN GROUP MEMBERS
    function getgrpMnbDtilsTpup()
    {
        $applic = $this->Generic_model->getData('cus_mas', array('cuid', 'brco', 'exec', 'ccnt', 'grno'), array('anic' => $this->input->post('apid')));

        $this->db->select("cus_mas.cuid,cus_mas.cuno,cus_mas.init,cus_mas.brco,cus_mas.exec,cus_mas.ccnt,cus_mas.hoad,cus_mas.tele,cus_mas.mobi,cus_mas.anic,
        cus_mas.uimg,cus_sol.sode,cus_mas.stat, ( SELECT COUNT(*) AS pen FROM `micr_crt` WHERE stat = 1 AND apid = cuid) AS pen,
        (SELECT COUNT(*) AS pen FROM `micr_crt` WHERE stat IN(2,5) AND apid = cuid) AS act ,
        (SELECT COUNT(*) AS grcnt FROM `micr_crt` WHERE cuid IN (`fsgi`,`segi`,`thgi`,`fogi`,`figi`,`sxgi`,`svgi`,`eggi`,`nigi`,`tngi`) ) AS grcnt ");
        $this->db->from("cus_mas");
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->where('cus_mas.brco ', $applic[0]->brco);
        $this->db->where('cus_mas.exec ', $applic[0]->exec);
        $this->db->where('cus_mas.ccnt ', $applic[0]->ccnt);
        $this->db->where('cus_mas.grno ', $applic[0]->grno);
        $this->db->where('cus_mas.stat IN(3,4) ');
        $this->db->where("cus_mas.cuid != ", $applic[0]->cuid);
        $this->db->order_by('grcnt', 'desc');
        $query = $this->db->get();
        $data['mnber'] = $query->result();

        $grnte = $this->Generic_model->getData('micr_crt', array('fsgi', 'segi', 'thgi', 'fogi', 'figi', 'sxgi', 'svgi', 'eggi', 'nigi', 'tngi'), array('apid' => $applic[0]->cuid, 'stat' => 5));
        //$data['grnte'] = $this->Generic_model->getData('micr_crt', array('fsgi', 'segi', 'thgi', 'fogi', 'figi', 'sxgi', 'svgi', 'eggi', 'nigi', 'tngi'), array('apid' => $applic[0]->cuid, 'stat' => 5));

        $data['grnte'] = array($grnte[0]->fsgi, $grnte[0]->segi, $grnte[0]->thgi, $grnte[0]->fogi, $grnte[0]->figi, $grnte[0]->sxgi, $grnte[0]->svgi, $grnte[0]->eggi, $grnte[0]->nigi, $grnte[0]->tngi,);
        echo json_encode($data);
    }

    function getLoanProductTpup()
    {
        $policy = $this->Generic_model->getData('sys_policy', array('post'), array('stat' => 1, 'poid' => 17));
        $lnct = $this->input->post('lnct');

        $this->db->select("auid,brid,prtp,nofr,lamt,rent,stat ");
        $this->db->from("product");
        $this->db->where('prtp ', $this->input->post('prdtp'));
        $this->db->where('brid ', $this->input->post('brnc'));
        if ($policy[0]->post == 1) {
            $lnct = $lnct + 1;
            $this->db->where("lcnt <= $lnct");  // LOAN INDEX CHECK & PRODUCT LOAD (PRD.INDX <= CURNT INDX + 1)
        }
        $this->db->where('stat ', 1);
        $this->db->group_by('lamt');
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function getLoanPeriodTpup()
    {
        $policy = $this->Generic_model->getData('sys_policy', array('post'), array('stat' => 1, 'poid' => 17));
        $lnct = $this->input->post('lnct');

        $this->db->select("auid,prtp,nofr,lamt,rent,stat, prcd ");
        $this->db->from("product");
        $this->db->where('prtp ', $this->input->post('pdtp'));
        $this->db->where('lamt ', $this->input->post('fcamt'));
        $this->db->where('brid ', $this->input->post('brnc'));
        if ($policy[0]->post == 1) {
            $lnct = $lnct + 1;
            $this->db->where("lcnt <= $lnct");  // LOAN INDEX CHECK & PRODUCT LOAD
        }
        $this->db->where('stat ', 1);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function getLoanInstalTpup()
    {
        $this->db->select("rent,docc,insc,lamt,inta,infm,cldw ");
        $this->db->from("product");
        $this->db->where('auid ', $this->input->post('id'));
        $this->db->where('stat ', 1);
        $query = $this->db->get();
        $data['lndt'] = $query->result();

        $this->db->select("prid");
        $this->db->from("micr_crt");
        $this->db->where('apid ', $this->input->post('cuid'));
        $this->db->where('prid ', $this->input->post('id'));
        $this->db->where('stat IN(1,2,5)');
        $query = $this->db->get();
        $data['cudt'] = $query->result();

        echo json_encode($data);

    }

// SEARCH TOPUP LOAN
    function searchTpupLoan()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('loan_tpup');

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

        $disabled = "disabled";


        $result = $this->User_model->get_TpuploanDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->lnst;
            $auid = $row->lnid;

            // CHECK APPROVAL DATE > TODAY - 7 DAYS
            $apdt = $row->apdt;
            $cc = date('Y-m-d', strtotime('-7 days'));
            if ($apdt < $cc) {
                $dt = "disabled";
            } else {
                $dt = "";
            }
            // IF CHECK PRODUCT LOAN OR DYNAMIC LOAN
            if ($row->lntp == 1) {
                $lntp = "<span class='label label-success' title='Product Loan'>P</span>";
            } elseif ($row->lntp == 2) {
                $lntp = "<span class='label label-warning' title='Dynamic Loan'>D</span>";
            }
            // IF CHECK TOPUP LOAN OR
            if ($row->prva != 0) {
                $tpup = "<span class='label label-info' title='Topup Loan'>T</span>";
            } else {
                $tpup = "";
            }

            if ($st == '1') {  // Pending
                $stat = "<span class='label label-warning'> $row->stnm </span> ";
                $option = "<button type='button'  id='viw'  $viw  data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $edt data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $app data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $rej onclick='rejecLoan($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // approval
                $stat = "<span class='label label-success'> $row->stnm </span> ";
                $option = "<button type='button'  id='viw'  $viw  data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled $edt data-toggle='modal' data-target='#modalEdt' onclick='' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled $app data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $rej onclick='rejecLoan($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '4') {  // Rejected
                $stat = "<span class='label label-danger'> $row->stnm </span> ";
                $option = "<button type='button' id='viw'  $viw  data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLoan(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLoan(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $disabled onclick='rejecLoan();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else {  // Others
                $stat = "<span class='label label-default'> $row->stnm </span> ";
                $option = "<button type='button' id='viw'  $viw  data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' " . $disabled . "  data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $disabled  onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $lntp . ' ' . $row->acno . ' ' . $tpup;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = $row->lnpr . ' ' . $row->pymd;

            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_loanTpup(),
            "recordsFiltered" => $this->User_model->count_filtered_loanTpup(),
            "data" => $data,
        );
        echo json_encode($output);
    }

// ADD TOPUP LOAN
    function addLntopup()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $crln = $this->input->post('lnid');     // CURRENT LOAN ID / PREVIOUS LOAN ID
        //$lndt = $this->Generic_model->getData('micr_crt', '', array('lnid' => $crln));

        $lntp = $this->input->post('lntp');     // loan type (1 - product loan / )
        $grtp = $this->input->post('grnTyp');   // granter type (0 - Individual granter / 1 - Group granter )

        if ($lntp == 1) { // product loan
            $prid = $this->input->post('dura');
            $prd_dtls = $this->Generic_model->getData('product', array('lamt', 'inta', 'rent', 'nofr', 'inra', 'prmd', 'clrt', 'pncd', 'cldw', 'infm'), array('auid' => $prid));

            $lntp = 1;
            $prdtp = $this->input->post('prdTyp');
            $loam = $this->input->post('fcamt');
            $inta = $prd_dtls[0]->inta;
            $inra = $prd_dtls[0]->inra;
            $lnpr = $prd_dtls[0]->nofr;
            $noin = $prd_dtls[0]->infm;
            $inam = $prd_dtls[0]->rent;
            $prmd = $prd_dtls[0]->prmd;
            $clrt = $prd_dtls[0]->clrt;
            $pncd = $prd_dtls[0]->pncd;
            $lcat = $prd_dtls[0]->cldw;

            $blam = $this->input->post('blamtPrd');  // LOAN BALANCE AMOUNT
        } else { // dynamic loan
            //$prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'prmd', 'clrt', 'pncd', 'cldw', 'infm'), array('prtp' => $this->input->post('prdtpDyn'), 'inra' => $this->input->post('dyn_inrt'), 'nofr' => $this->input->post('dyn_dura'), 'stat' => 1));

            $lntp = 2;
            $prdtp = $this->input->post('prdtpDyn');
            $loam = $this->input->post('dyn_fcamt');
            $inta = $this->input->post('dyn_ttlint');
            $inra = $this->input->post('dyn_inrt');

            $lnpr = $this->input->post('dyn_dura');
            $blam = $this->input->post('blamtDyn');   // LOAN BALANCE AMOUNT

            $lcat = $this->input->post('dytp');
            $inam = $this->input->post('lnprim');


            if ($prdtp == 6) {
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'prmd', 'clrt', 'pncd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'cldw' => $lcat, 'stat' => 1));
                $prmd = $prdid[0]->prmd;
                $clrt = $prdid[0]->clrt;
                $pncd = $prdid[0]->pncd;

                $noin = $prdid[0]->infm;
            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'prmd', 'clrt', 'pncd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'stat' => 1));
                $prmd = $prdid[0]->prmd;
                $clrt = $prdid[0]->clrt;
                $pncd = $prdid[0]->pncd;

                $noin = $this->input->post('dyn_dura');
            }
            $prid = $prdid[0]->auid;
        }

        // Individual granter
        if ($grtp == 0) {
            $fsgi = $this->input->post('fsgi');
            $segi = $this->input->post('segi');
            $thgi = $this->input->post('thgi');
            $fogi = $this->input->post('fogi');
            $figi = $this->input->post('figi');

            $sxgi = 0;
            $svgi = 0;
            $eggi = 0;
            $nigi = 0;
            $tngi = 0;

        } else {          // Group granter

            $len = $this->input->post('grntLen');
            $i = 0;
            for ($a = 0; $a < $len; $a++) {
                $grnid = $this->input->post("addm[" . $a . "]");      // granter id
                if ($grnid != '') {
                    $result[$i] = array(0 => $grnid);
                    $i++;
                }
            }
            $xx = sizeof($result);
            if ($xx < 10) {
                for ($c = $xx; $c < 10; $c++) {
                    $result[$c] = array(0 => 0);
                }
            }
            // var_dump($result[0][0]);
            // var_dump($result[1][0]);
            // var_dump($result[2][0]);
            $fsgi = $result[0][0];
            $segi = $result[1][0];
            $thgi = $result[2][0];
            $fogi = $result[3][0];
            $figi = $result[4][0];
            $sxgi = $result[5][0];
            $svgi = $result[6][0];
            $eggi = $result[7][0];
            $nigi = $result[8][0];
            $tngi = $result[9][0];
        }

        $brco = $this->input->post('coll_brn');
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $this->db->select("brco,acno");
        $this->db->from("micr_crt");
        $this->db->where('micr_crt.brco ', $brco);
        $this->db->where('micr_crt.stat IN(1,4)');
        $this->db->order_by('micr_crt.lnid', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $acno = $brcd . '/TMP/0001';
        } else {
            $acno = $data[0]->acno;
            $re = (explode("/", $acno));
            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);

            // next loan no
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }
            $acno = $brcd . '/' . 'TMP' . '/' . $xx;
        }

        // NEW TOPUP LOAN ADED
        $data_arr = array(  // $name_nic = ucwords($name_nic);      //ucwords($foo);
            'brco' => $this->input->post('coll_brn'),
            'clct' => $this->input->post('coll_ofc'),
            'ccnt' => $this->input->post('coll_cen'),
            'acno' => $acno,
            'lntp' => $lntp,
            'grtp' => $grtp,
            'prdtp' => $prdtp,
            'prid' => $prid,

            'apid' => $this->input->post('appid'),
            'fsgi' => $fsgi,
            'segi' => $segi,
            'thgi' => $thgi,
            'fogi' => $fogi,
            'figi' => $figi,
            'sxgi' => $sxgi,
            'svgi' => $svgi,
            'eggi' => $eggi,
            'nigi' => $nigi,
            'tngi' => $tngi,

            'loam' => $loam,
            'inta' => $inta,
            'inra' => $inra,
            'lnpr' => $lnpr,
            'noin' => $noin,
            'lcat' => $lcat,
            'inam' => $inam,

            'prva' => $crln,

            'docg' => $this->input->post('docu'),
            'incg' => $this->input->post('insu'),
            'chmd' => $this->input->post('crgmd'), // charge mode

            'indt' => $this->input->post('indt'),
            'acdt' => $this->input->post('dsdt'),
            'sydt' => date('Y-m-d'),

            'stat' => 1, // pending Loan
            'rmks' => $this->input->post('smst'),
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('micr_crt', $data_arr);

        // GET NEW LOAN ID
        $nwlndt = $this->Generic_model->getData('micr_crt', array('lnid'), array('acno' => $acno, 'stat' => 1));

        // OLD LOAN STATUES CHANGE
        $updln = $this->Generic_model->updateData('micr_crt', array('stat' => 18), array('lnid' => $crln));

        // TOPUP TB UPDATE
        $data_arr = array(  // $name_nic = ucwords($name_nic);      //ucwords($foo);
            'clno' => $crln,                        // CURRENT LOAN ID
            'tpnm' => $nwlndt[0]->lnid,             // NEW LOAN ID
            'blam' => $this->input->post('setBal'), // BALANCE AMOUNT
            'nlam' => $this->input->post('fcamt'),  // NEW LOAN AMOUNT

            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('topup_loans', $data_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('loan_tpup');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan topup ' . $acno);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

// EDIT TOPUP VIEW
    function vewTpupLoanEdt()
    {
        $lnid = $this->input->post('auid');

        $this->db->select("micr_crt.*,IF(micr_crt.lntp = 1,'Product Loan','Dynamic Loan') AS lntpnm,brch_mas.brnm ,cen_mas.cnnm,user_mas.fnme ,user_mas.lnme , prdt_typ.prtp,loan_stat.stnm  ,
        a.acuno,a.ainit,a.ahoad,a.amobi,a.aanic,a.auimg ,
        b.bcuno,b.binit,b.bhoad,b.bmobi,b.banic,b.buimg ,
        c.ccuno,c.cinit,c.choad,c.cmobi,c.canic,c.cuimg ,
        d.dcuno,d.dinit,d.dhoad,d.dmobi,d.danic,d.duimg ,       
        ");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        // APPLICANR DETAILS
        $this->db->join("(SELECT a.cuid,a.cuno AS acuno,a.init AS ainit,a.hoad AS ahoad,a.mobi AS amobi,a.anic AS aanic,a.uimg AS auimg
         FROM cus_mas AS a) AS a", 'a.cuid = micr_crt.apid ', 'left');
        // 1 granter
        $this->db->join("(SELECT b.cuid,b.cuno AS bcuno,b.init AS binit,b.hoad AS bhoad,b.mobi AS bmobi,b.anic AS banic,b.uimg AS buimg
         FROM cus_mas AS b) AS b", 'b.cuid = micr_crt.fsgi', 'left');
        // 2 granter
        $this->db->join("(SELECT c.cuid,c.cuno AS ccuno,c.init AS cinit,c.hoad AS choad,c.mobi AS cmobi,c.anic AS canic,c.uimg AS cuimg
         FROM cus_mas AS c) AS c", 'c.cuid = micr_crt.segi', 'left');
        // 3 granter
        $this->db->join("(SELECT d.cuid,d.cuno AS dcuno,d.init AS dinit,d.hoad AS dhoad,d.mobi AS dmobi,d.anic AS danic,d.uimg AS duimg
         FROM cus_mas AS d) AS d", 'd.cuid = micr_crt.thgi', 'left');

        //$this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.cuid ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat ');

        $this->db->where('micr_crt.lnid ', $lnid);
        $query = $this->db->get();
        $data['lndt'] = $query->result();

//  applictin details
        $this->db->select("cus_mas.init ,cus_mas.grno,cus_mas.cuno,cus_mas.anic,cus_mas.hoad,cus_mas.mobi,cus_mas.uimg ,
         cen_mas.cnno,cen_mas.cnnm, brch_mas.brnm,cus_sol.sode,cus_type.cutp,grup_mas.grno , micr_crt.lnid, micr_crt.brco,micr_crt.ccnt,micr_crt.clct,micr_crt.apid,micr_crt.prdtp,
         micr_crt.indt, micr_crt.mddt, micr_crt.loam, micr_crt.inam, micr_crt.boi, micr_crt.boc, micr_crt.aboc, micr_crt.aboi, micr_crt.avcr, 
         micr_crt.avpe, micr_crt.nxpn, micr_crt.noin,micr_crt.acno, product.prcd ,product.prnm ,prdt_typ.pymd ,topup_loans.clno, topup_loans.blam ");

        $this->db->from("cus_mas");
        $this->db->join('cus_mas_base', 'cus_mas_base.cuid = cus_mas.cuid');
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco');
        $this->db->join('cus_sol', 'cus_sol.soid = cus_mas.titl');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno', 'left');
        $this->db->join('micr_crt', 'micr_crt.apid = cus_mas.cuid', 'left');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('topup_loans', 'topup_loans.clno = micr_crt.lnid');

        $this->db->where('topup_loans.tpnm', $lnid);
        //$this->db->where('micr_crt.stat', 5);
        $query = $this->db->get();
        $data['cudt'] = $query->result();

        echo json_encode($data);
    }

// TOPUP EDIT
    function topupLoan_edt()
    {
        $func = $this->input->post('func');     // if update=1 or approval=2
        $lntp = $this->input->post('lontype');  // if 1 product loan 2 dynamic loan
        $auid = $this->input->post('lnauid');   // loan auto id

        if ($lntp == 1) { // product loan
            $prid = $this->input->post('duraEdt');
            $prd_dtls = $this->Generic_model->getData('product', array('lamt', 'inta', 'rent', 'nofr', 'inra', 'prmd'), array('auid' => $prid));

            $prdtp = $this->input->post('prdTypEdt');
            $loam = $this->input->post('fcamtEdt');
            $inta = $prd_dtls[0]->inta;
            $inra = $prd_dtls[0]->inra;
            $lnpr = $prd_dtls[0]->nofr;
            $noin = $prd_dtls[0]->nofr;
            $inam = $prd_dtls[0]->rent;
            $lcat = 0;
            $prmd = $prd_dtls[0]->prmd;
            // $blam = $this->input->post('blamtPrdEdt');

        } else { // dynamic loan
            $prdtp = $this->input->post('prdtpDynEdt');
            $inra = $this->input->post('dyn_inrtEdt');
            $lnpr = $this->input->post('dyn_duraEdt');
            $loam = $this->input->post('dyn_fcamtEdt');
            $inta = $this->input->post('dyn_ttlintEdt');

            $lcat = $this->input->post('dytpEdt');
            $inam = $this->input->post('lnprimEdt');

            $prmd = 1;
            // $blam = $this->input->post('blamtDynEdt');

            if ($prdtp == 6) { // DYNAMIC DAILY
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'prmd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'cldw' => $lcat, 'stat' => 1));
                $prid = $prdid[0]->auid;
                $noin = $prdid[0]->infm;

            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm'),
                    array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'stat' => 1));
                $prid = $prdid[0]->auid;

                $noin = $this->input->post('dyn_duraEdt');
                $inam = $this->input->post('lnprimEdt');
            }
        }


        //MATURITY DATE AND NEXT RENTEL DATE
        $indt = $this->input->post('indtEdt');

        $date = date("Y-m-d");
        $nxdd = date("Y-m-d");
        if ($prdtp == 3 || $prdtp == 6) {         // DL

            $holidayDates = $this->Generic_model->getData('sys_holdys', array('date'), array('stat' => 1, 'hdtp' => 1));
            $holidayDates = array_column($holidayDates, 'date');
            $count5WD = 0;
            // $temp = strtotime("2018-04-18 00:00:00"); //example as today is 2016-03-25
            /* Example link  --> https://stackoverflow.com/questions/36196606/php-add-5-working-days-to-current-date-excluding-weekends-sat-sun-and-excludin  */
            $temp = strtotime(date("Y-m-d"));

            while ($count5WD < $lnpr) {
                $next1WD = strtotime('+1 weekday', $temp);
                $next1WDDate = date('Y-m-d', $next1WD);
                if (!in_array($next1WDDate, $holidayDates)) {
                    $count5WD++;
                }
                $temp = $next1WD;
            }
            $next5WD = date("Y-m-d", $temp);
            $madt = $next5WD;

            $count5WD2 = 0;
            $temp2 = strtotime(date("Y-m-d"));
            while ($count5WD2 < 1) {
                $next1WD2 = strtotime('+1 weekday', $temp2);
                $next1WDDate2 = date('Y-m-d', $next1WD2);
                if (!in_array($next1WDDate2, $holidayDates)) {
                    $count5WD2++;
                }
                $temp2 = $next1WD2;
            }
            $next5WD2 = date("Y-m-d", $temp2);
            $nxdd_n = $next5WD2;
            // var_dump($madt . '***'. $nxdd);
            // die();

        } else if ($prdtp == 4 || $prdtp == 7) {   //WK
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $lnpr . "week");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 week");
            $nxdd_n = date("Y-m-d", $nxdd);

        } else if ($prdtp == 5 || $prdtp == 8) {   //ML
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $lnpr . "month");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 month");
            $nxdd_n = date("Y-m-d", $nxdd);

        }
// END MATURITY DATE
        // ******************************  update topup loan  ***********************************
        // ******************************  update topup loan  ***********************************
        if ($func == '1') {
            $chk = 0;
            $this->db->trans_begin(); // SQL TRANSACTION START

            $data_ar1 = array(
                'clct' => $this->input->post('coll_ofcEdt'),
                'ccnt' => $this->input->post('coll_cenEdt'),
                'prdtp' => $prdtp,
                'prid' => $prid,

                'loam' => $loam,
                'inta' => $inta,
                'inra' => $inra,
                'lnpr' => $lnpr,
                'noin' => $noin,
                'lcat' => $lcat,
                'inam' => $inam,
                'docg' => $this->input->post('docuEdt'),
                'incg' => $this->input->post('insuEdt'),
                'chmd' => $this->input->post('crgmdEdt'), // charge mode
                'indt' => $this->input->post('indtEdt'),
                'acdt' => $this->input->post('dsdtEdt'),
                'rmks' => $this->input->post('remkEdt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'lnid' => $auid
            );

            $rs1 = $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);
            if ($rs1) {
                $chk = $chk + 1;
            } else {
                $this->Log_model->ErrorLog('loan_tpup', 'Topup Loan update', 2, $chk);
            }

            // TOPUP TB UPDATE
            $data_arr = array(  // $name_nic = ucwords($name_nic);      //ucwords($foo);
                'blam' => $this->input->post('setBalEdt'),                            // BALANCE AMOUNT
                'nlam' => $this->input->post('fcamtEdt'),   // BALANCE AMOUNT
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $rs2 = $this->Generic_model->updateData('topup_loans', $data_arr, array('tpnm' => $auid));
            if ($rs2) {
                $chk = $chk + 1;
            } else {
                $this->Log_model->ErrorLog('loan_tpup', 'Topup Loan update', 2, $chk);
            }

            $funcPerm = $this->Generic_model->getFuncPermision('loan_tpup');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Topup Loan update id(' . $auid . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }

        } elseif ($func == '2') {
            // ******************************  approval topup loan  ***********************************
            // ******************************  approval topup loan  ***********************************

            $auid = $this->input->post('lnauid');   // new loan auto id
            $chk = 0;
            $this->db->trans_begin(); // SQL TRANSACTION START

            $prlnBal = $this->input->post('setBalEdt'); // PERVISION LOAN BALANCE

            // GET OLD LOAN ID
            $aas = $this->Generic_model->getData('topup_loans', array('clno', 'tpnm'), array('stat' => 0, 'tpnm' => $auid));
            $oldid = $aas[0]->clno;

            // OLD LOAN DETAILS
            $lndt = $this->Generic_model->getData('micr_crt', array('acno', 'brco', 'lnpr', 'inam', 'docg', 'incg', 'cage', 'boc', 'boi', 'nxpn', 'loam', 'inta'), array('lnid' => $oldid));
            $acnoOld = $lndt[0]->acno;

            // RECEIPTS PROCESS
            $user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
            $brn = $user[0]->brch;
            //$brn = ;

            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn));
            $brcd = $brdt[0]->brcd;

            $this->db->select("reno");
            $this->db->from("receipt");
            $this->db->where('receipt.brco ', $brn);
            $this->db->where('receipt.retp ', 4); // TOPUP RECEIPTS
            $this->db->order_by('receipt.reid', 'desc');

            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            $yr = date('y');
            if (count($data) == '0') {
                $reno = $brcd . '/RT/' . $yr . '/00001';
            } else {
                $reno = $data[0]->reno;
                $re = (explode("/", $reno));
                $aa = intval($re[3]) + 1;
                $cc = strlen($aa);

                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '' . $aa;
                }
                $reno = $brcd . '/RT/' . $yr . '/' . $xx;
            }

            $data_arr = array(
                'brco' => $brn,
                'reno' => $reno,
                'rfno' => $oldid, // loan id
                'retp' => 4,
                'ramt' => $prlnBal,
                'pyac' => 106,
                'pymd' => 9, // 8 -cash / 9 - inter account trnsfer
                'stat' => 1,
                'remd' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $re1 = $this->Generic_model->insertData('receipt', $data_arr);

            $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
            $reid = $recdt[0]->reid;

            $data_arr22 = array(
                'reno' => $reno,
                'reid' => $reid, // recpt id
                'rfco' => 108,
                'rfdc' => 'PYMNT for ' . $acnoOld,
                'rfdt' => date('Y-m-d'),
                'amut' => $prlnBal
            );
            $re2 = $this->Generic_model->insertData('recp_des', $data_arr22);

// OLD LOAN SMNT - TOPUP ACCOUNT LEDGE @1
            $data_aclg1 = array(
                'brno' => $lndt[0]->brco, // BRANCH ID
                'lnid' => $oldid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT - TOPUP',
                'trid' => 12,
                'rfna' => $reno,
                'dcrp' => $reno,
                'acco' => 108,    // cross acc code
                'spcd' => 108,    // split acc code
                'acst' => '(108) Loan Stock', // (108) Loan Stock
                'dbam' => $prlnBal,
                'cram' => 0,
                'stat' => 0
            );
            $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);

            $data_aclg2 = array(
                'brno' => $lndt[0]->brco, // BRANCH ID
                'lnid' => $oldid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'SMNT - TOPUP',
                'trid' => 12,
                'rfna' => $reno,
                'dcrp' => $reno,
                'acco' => 108,    // cross acc code
                'spcd' => 108,    // split acc code
                'acst' => '(108) Loan Stock',
                'dbam' => 0,
                'cram' => $prlnBal,
                'stat' => 0
            );
            $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);

// END OLD LOAN SMNT - TOPUP ACCOUNT LEDGE @1

// GET ACCOUNT BALANCE
            $this->db->select("SUM(`avcp`) AS avcp, SUM(`avin`) AS avin, SUM(`capt`) AS arcp, SUM(`inte`) AS arin, SUM(`dpet`) AS avdp, 
                        SUM(`schg`) AS avsc, SUM(`duam`) AS duam, SUM(`ream`) AS ream, SUM(`ovpm`) AS ovpm ,
                        ((SUM(`duam`) - SUM(`ream`))/a.inam) AS cage ");
            $this->db->from("micr_crleg");
            $this->db->join("(SELECT lnid,inam FROM `micr_crt` ) AS a", 'a.lnid = micr_crleg.acid ', 'left');
            $this->db->where('acid', $oldid);
            $this->db->where('stat IN(1,2) ');
            $acdt = $this->db->get()->result();

            $avcp = round($acdt[0]->avcp, 2); // CAPITAL
            $avin = round($acdt[0]->avin, 2); // INTEREST
            $arcp = round($acdt[0]->arcp, 2); // ARR CAP
            $arin = round($acdt[0]->arin, 2); // ARR INT
            $avdp = round($acdt[0]->avdp, 2); // PENALTY
            $avsc = round($acdt[0]->avsc, 2); // CHARGES

            $duam = round($acdt[0]->duam, 2); // TTL DUE
            $trpa = round($acdt[0]->ream, 2); // TTL PYMT
            $ovpm = round($acdt[0]->ovpm, 2); // TTL OVPY
            $cage = round($acdt[0]->cage, 2); // CURN AGE

            //$duamN = round((($lndt[0]->lnpr * $lndt[0]->inam) + $lndt[0]->docg + $lndt[0]->incg) - $duam, 2);
            $duamN = round(($lndt[0]->loam + $lndt[0]->inta + $lndt[0]->docg + $lndt[0]->incg) - $duam, 2);

// OLD LOAN SMNT MICRO LEDGE @1
            $data_mclg1 = array(
                'acid' => $oldid, // LOAN ID
                'acno' => $acnoOld, // LOAN NO
                'ledt' => date('Y-m-d H:i:s'),
                'reno' => $reno,
                'reid' => $reid,
                'dsid' => 10,
                'dcrp' => 'SMNT - TOPUP',

                'avcp' => (-$avcp),
                'avin' => (-$avin),
                'capt' => (-$arcp),
                'inte' => (-$arin),

                'duam' => $duamN,
                //'ream' => $prlnBal + $this->input->post('docuEdt') + $this->input->post('insuEdt'),
                'ream' => $prlnBal,
                'stat' => 1,
                'cage' => $cage
            );
            $res3 = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

// OLD LOAN STATUES CHANGE
            $dtar = array(
                'tpag' => $lndt[0]->cage,
                'tptn' => $lndt[0]->nxpn,
                'tpcp' => $lndt[0]->boc,
                'tpin' => $lndt[0]->boi,
                'stat' => 3,
            );
            $rs2 = $this->Generic_model->updateData('micr_crt', $dtar, array('lnid' => $oldid));

            // GET BRANCH CODE GP/NT
            $brco = $this->input->post('coll_brnEdt');
            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
            $brcd = $brdt[0]->brcd;

            $cent = $this->input->post('coll_cenEdt');
            $cnno = $this->Generic_model->getData('cen_mas', array('caid', 'cnno', 'stat'), array('caid' => $cent, 'stat' => 1));
            $cncd = $cnno[0]->cnno;

            // GET PRODUCT CODE
            $prt = $this->Generic_model->getData('product', array('prcd', 'pnst', 'clrt'), array('auid' => $prid, 'stat' => 1));
            $prcd = $prt[0]->prcd;
            $clrt = $prt[0]->clrt;

            // GET LAST LOAN NO
            $this->db->select("brco,acno,ccnt,prdtp,prid");
            $this->db->from("micr_crt");
            $this->db->where('micr_crt.brco ', $brco);
            $this->db->where('micr_crt.ccnt ', $cent);
            //$this->db->where('micr_crt.prid ', $prid);
            //$this->db->where('micr_crt.stat ', 2);

            if ($lntp == 1) {         //1 product loan 2 dynamic loan
                $this->db->where('micr_crt.prid ', $prid);
            } else {
                $this->db->where('micr_crt.prdtp ', $prdtp);
            }

            $this->db->where('micr_crt.stat IN(2,3,5,18) ');
            $this->db->order_by('micr_crt.acno', 'desc');

            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            // GENARATE NEXT LOAN NO
            if (count($data) == '0') {
                $aa = '0001';
            } else {
                $acno = $data[0]->acno;
                $re = (explode("/", $acno));
                $aa = intval($re[4]) + 1;
            }

            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }

            // center no
            $mm = strlen($cncd);
            if ($mm == 1) {
                $gg = '000' . $cncd;
            } else if ($mm == 2) {
                $gg = '00' . $cncd;
            } else if ($mm == 3) {
                $gg = '0' . $cncd;
            } else if ($mm == 4) {
                $gg = '' . $cncd;
            }
            $yr = date('y');
            $acno = $brcd . '/' . $prcd . '/' . $yr . '/' . $gg . '/' . $xx;
            // END LOAN NO GENARATE

// micr_crt TB UPDATE
            $data_ar1 = array(
                'clct' => $this->input->post('coll_ofcEdt'),
                'ccnt' => $this->input->post('coll_cenEdt'),
                'acno' => $acno,
                'prdtp' => $prdtp,
                'prid' => $prid,

                'loam' => $loam,
                'inta' => $inta,
                'inra' => $inra,
                'lnpr' => $lnpr,
                'noin' => $noin,
                'lcat' => $lcat,
                'inam' => $inam,
                'docg' => $this->input->post('docuEdt'),
                'incg' => $this->input->post('insuEdt'),
                'chmd' => $this->input->post('crgmdEdt'), // charge mode
                'indt' => $this->input->post('indtEdt'),
                'acdt' => $this->input->post('dsdtEdt'),

                'madt' => $madt,
                'nxdd' => $nxdd_n,
                'durg' => $noin,
                'boc' => $loam,
                'boi' => $inta,
                'nxpn' => 1,
                'prtp' => $prmd,
                'pnra' => $clrt, // PANALTY CAL RATE

                'stat' => 2,
                'pncs' => $prt[0]->pnst,
                'pcid' => 0,
                //'prva' => $crln,

                'rmks' => $this->input->post('remkEdt'),
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'lnid' => $auid
            );
            $result_micrt = $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);

// NEW LOAN LEDGER RECODE
            $cchmd = $this->input->post('crgmdEdt');
            $docg = $this->input->post('docuEdt');
            $incg = $this->input->post('insuEdt');

            // MICRO LEDGE @1
            $data_mclg1 = array(
                'acid' => $auid, // LOAN ID
                'acno' => $acno, // LOAN NO
                'ledt' => date('Y-m-d H:i:s'),
                'dsid' => 8,
                'dcrp' => 'ACNT DIFN',
                'avcp' => $loam,
                'avin' => $inta,

                'schg' => $docg + $incg,
                'duam' => $docg + $incg,
                'stat' => 1
            );
            $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

// NEW LAON ACCOUNT LEDGE
            $data_aclg1 = array(
                'brno' => $brco, // BRANCH ID
                'lnid' => $auid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'ACNT DIFN',
                'trid' => 8,
                'rfna' => $acno,
                'dcrp' => 'ACNT DIFN',
                'acco' => '111',    // cross acc code
                'spcd' => '108',    // split acc code
                'acst' => '(108) Loan Stock',
                'dbam' => $loam,
                'cram' => 0,
                'stat' => 0
            );
            $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);
            if ($result) {
                $chk = $chk + 1;
            }

            $data_aclg2 = array(
                'brno' => $brco, // BRANCH ID
                'lnid' => $auid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'ACNT DIFN',
                'trid' => 8,
                'rfna' => $acno,
                'dcrp' => 'ACNT DIFN',
                'acco' => '108',    // cross acc code
                'spcd' => '111',    // split acc code
                'acst' => '(111) Loan Controller',
                'dbam' => 0,
                'cram' => $loam,
                'stat' => 0
            );
            $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
            if ($re1) {
                $chk = $chk + 1;
            }

            if ($cchmd == 1) {        // CHARGE PAY BY CUSTOMER
                $chk = $chk + 4;

            } else if ($cchmd == 2) {  // CHARGE RECOVER FOR LOAN

                if ($docg > 0) {
                    $data_aclg23 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 111,    // cross acc code
                        'spcd' => 404,    // split acc code
                        'acst' => '(404) Document Charge',      //
                        'dbam' => 0,      // db amt
                        'cram' => $docg,      // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);
                    if ($result) {
                        $chk = $chk + 1;
                    }
                    $data_aclg45 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 404,    // cross acc code
                        'spcd' => 111,    // split acc code
                        'acst' => '(111) Loan Controller',      //
                        'dbam' => $docg,      // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result77 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                    if ($result77) {
                        $chk = $chk + 1;
                    }
                } else {
                    $chk = $chk + 2;
                }

                if ($incg > 0) {
                    $data_aclg23 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 111,    // cross acc code
                        'spcd' => 403,    // split acc code
                        'acst' => '(403) Insurance Charge',      //
                        'dbam' => 0,      // db amt
                        'cram' => $incg,      // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);
                    if ($result) {
                        $chk = $chk + 1;
                    }
                    $data_aclg45 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 403,    // cross acc code
                        'spcd' => 111,    // split acc code
                        'acst' => '(111) Loan Controller',      //
                        'dbam' => $incg,      // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result88 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                    if ($result88) {
                        $chk = $chk + 1;
                    }
                } else {
                    $chk = $chk + 2;
                }
            }
// END ACCOUNT LEDGE


// RECEIPTS PROCESS
            $user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
            $brn = $user[0]->brch;

            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn));
            $brcd = $brdt[0]->brcd;

            $this->db->select("reno");
            $this->db->from("receipt");
            $this->db->where('receipt.brco ', $brn);
            $this->db->where('receipt.retp ', 1);
            $this->db->order_by('receipt.reid', 'desc');

            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            $yr = date('y');
            if (count($data) == '0') {
                $reno = $brcd . '/GR/' . $yr . '/00001';
            } else {
                $reno = $data[0]->reno;
                $re = (explode("/", $reno));
                $aa = intval($re[3]) + 1;

                $cc = strlen($aa);
                // next loan no
                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '' . $aa;
                }

                $reno = $brcd . '/GR/' . $yr . '/' . $xx;
            }

// INSERT GENERAL RECEIPTS

            if ($cchmd == 1) {        // CHARGE PAY BY CUSTOMER
                $chk = $chk + 5;

                // customer payed process chang to edtPymnt() approval function

            } else if ($cchmd == 2) {  // CHARGE RECOVER FOR LOAN
                $data_arr = array(
                    'brco' => $brn,
                    'reno' => $reno,
                    'rfno' => $auid, // loan id
                    'retp' => 1,
                    'ramt' => $docg + $incg,
                    'pyac' => 111,
                    'pymd' => 9, // 8 -cash / 9 - inter account trnsfer
                    //'clid' => $this->input->post('appidEdt'), // cust id
                    'stat' => 1,
                    'remd' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('receipt', $data_arr);
                if ($result) {
                    $chk = $chk + 1;
                }
                $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
                $reid = $recdt[0]->reid;

                if ($docg > 0) {

                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 404,
                        'rfdc' => 'Document Charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $docg
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                    if ($result22) {
                        $chk = $chk + 1;
                    }
                } else {
                    $chk = $chk + 1;
                }
                if ($incg > 0) {

                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 403,
                        'rfdc' => 'Insurance Charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $incg
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                    if ($result22) {
                        $chk = $chk + 1;
                    }
                } else {
                    $chk = $chk + 1;
                }

                // MICRO LEDGE @2
                if ($docg > 0) {
                    $data_mclg1 = array(
                        'acid' => $auid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 1,
                        'dcrp' => 'DOC CHG RECOV FOR ACC',
                        'schg' => -$docg,
                        'ream' => $docg,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
                    if ($result) {
                        $chk = $chk + 1;
                    }
                } else {
                    $chk = $chk + 1;
                }

                if ($incg > 0) {
                    $data_mclg1 = array(
                        'acid' => $auid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 1,
                        'dcrp' => 'INS CHG RECOV FOR ACC',
                        'schg' => -$incg,
                        'ream' => $incg,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);
                    if ($result) {
                        $chk = $chk + 1;
                    }
                } else {
                    $chk = $chk + 1;
                }
                // END MICRO LEDGE @2
            }
            // END RECEIPTS

            // TOPUP TB UPDATE
            $data_arr = array(  // $name_nic = ucwords($name_nic);      //ucwords($foo);
                //'blam' => $blam,                          // BALANCE AMOUNT
                'nlam' => $this->input->post('fcamtEdt'),   // BALANCE AMOUNT
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
                'stat' => 1
            );
            $rs2 = $this->Generic_model->updateData('topup_loans', $data_arr, array('tpnm' => $auid));


            $funcPerm = $this->Generic_model->getFuncPermision('loan_tpup');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Topup Loan approval id(' . $auid . ')');

            /*if ($chk == 19) {
                echo json_encode(true);
            } else {
                $this->Log_model->ErrorLog('loan_tpup', 'Topup Loan approval', 19, $chk);
                echo json_encode(false);
            }*/
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

// TOPUP REJECT
    function rejTopLoan()
    {
        $id = $this->input->post('id'); // NEW LOAN ID
        $this->db->trans_begin(); // SQL TRANSACTION START

        // NEW LOAN REJECT
        $re1 = $this->Generic_model->updateData('micr_crt', array('stat' => 4), array('lnid' => $id));

        // GET OLD LOAN SOME DETAILS
        $oldLn = $this->Generic_model->getData('topup_loans', array('clno', 'tpnm'), array('stat' => 0, 'tpnm' => $id));
        $oldid = $oldLn[0]->clno; // OLD LAON ID

        // OLD LOAN CHANGE RUNNING STATUES
        $re2 = $this->Generic_model->updateData('micr_crt', array('stat' => 5), array('lnid' => $oldid));

        // TOPUP LOANS TB STATUES CHANGE
        $re3 = $this->Generic_model->updateData('topup_loans', array('stat' => 2, 'cnby' => $_SESSION['userId'], 'cndt' => date('Y-m-d H:i:s')), array('tpnm' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('loan_tpup');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Topup Loan reject id(' . $id . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

// END LOAN TOPUP
//
//  OTHER TRANSACTION
    function othr_trns()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['payinfo'] = $this->Generic_model->getData('pay_terms', '', "stat = 1 AND tmid NOT IN(2,8,10)");
        $data['chrtaccinfo'] = $this->Generic_model->getData('accu_chrt', '', array('stat' => 1, 'acid' => 5));
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('othr_trns');

        $this->load->view('modules/user/other_transaction', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchOthrTrans()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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

        $result = $this->User_model->get_othrTrans();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->trid;

            if ($row->chmd == 1) {          // Credit voucher
                $md = "<span class='label label-default' title='Credit Voucher'>CREDIT</span>";
                $app = "disabled";
            } elseif ($row->chmd == 2) {    // incash group voucher
                $md = "<span class='label label-default' title='Incash Voucher'>IN CASH</span>";
                $app = "";
            } else if ($row->chmd == 3) {   // general voucher
                $md = "<span class='label label-default' title='General Voucher'>GENERAL</span>";
                $app = "";
            }

            if ($row->stat == 0) {
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($row->void,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app  id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej disabled onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } elseif ($row->stat == 1) {  // if main statues approval
                $stat = "<span class='label label-success'> Approval</span> ";

                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($row->void,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app  id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej  onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 0) {
                $stat = "<span class='label label-danger'> Reject </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($row->void,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->acnm;
            $sub_arr[] = $row->vuno;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->pynm; // cust name
            $sub_arr[] = $md;
            $sub_arr[] = $row->tem_name;
            $sub_arr[] = number_format($row->tram, 2, '.', ',');
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_otrTrn(),
            "recordsFiltered" => $this->User_model->count_filt_otrTrn(),
            "data" => $data,
        );
        echo json_encode($output);
    }

// END LOAN TOPUP
//
// BIRTHDAY GIFT
    function bday_gift()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('bday_gift');
        $this->load->view('modules/user/gift_management', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // LOAD THIS WEEK BIRTHDAY CUSTOMER LIST
    function getBdyCustList()
    {
        $result = $this->User_model->get_BadyCust();
        $data = array();
        $i = $_POST['start'];
        $brn = $this->input->post('brn');
        $gftyp = $this->Generic_model->getData('bday_gift_stock', array('auid', 'stcd'), array('brco' => $brn, 'stat' => 1));

        foreach ($result as $row) {
            /*if ($row->cuid == $row->bdgfid) {
                $ds = "disabled";
            } else {
                $ds = '';
            }*/
            /* https://forum.codeigniter.com/archive/index.php?thread-54008.html */
            $options = "";
            $options .= "<select class='form-control select' name='gftyp[" . $i . "]' id='payby' required>";
            foreach ($gftyp as $dansetype):
                $options .= "<option value='" . $dansetype->auid . "' > " . $dansetype->stcd . "</option>, ";
            endforeach;
            $options .= "</select>";

            $auid = $row->cuid;
            $hidden = "<input type='hidden'  name='cuid[" . $i . "]' value='" . $row->cuid . "'>";
            $gfcn = "<input type='text' class='form-control' name='gftcunt[" . $i . "]' id='gftcunt[" . $auid . "]' value='1' />";
            $rqs = "<label class=''><input type='checkbox'  name='rqs[" . $i . "]' value='1' id='checkbox-1'  class='icheckbox'/> </label>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' / ' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->dobi;
            $sub_arr[] = date_diff(date_create($row->dobi), date_create('today'))->y + 1 . " Years  ";

            $sub_arr[] = $options;
            $sub_arr[] = $gfcn;
            $sub_arr[] = $rqs . $hidden;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_BadyCust(),
            "recordsFiltered" => $this->User_model->count_filt_BadyCust(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // REQUEST GIFT ADD TABLE
    function addRqustGift()
    {
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
        $brco = $this->input->post('brchUsr');

        // Genarate Voucher No
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;
        $this->db->select("vuno");
        $this->db->from("voucher");
        $this->db->where('voucher.brco ', $brco);
        $this->db->order_by('voucher.vuno', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $vuno = $brcd . '/VU/' . $yr . '/00001';
        } else {
            $reno = $data[0]->vuno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;

            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }
            $vuno = $brcd . '/VU/' . $yr . '/' . $xx;
        }
        // END Genarate Voucher No

        $len = $this->input->post('len');
        for ($a = 0; $a < $len; $a++) {

            $rqs = $this->input->post("rqs[" . $a . "]");      // loan id
            $cuid = $this->input->post("cuid[" . $a . "]");
            $cunt = $this->input->post("gftcunt[" . $a . "]");
            $gftyp = $this->input->post("gftyp[" . $a . "]");

            $cudt = $this->Generic_model->getData('cus_mas', array('brco', 'exec', 'ccnt', 'cuno', 'dobi', 'init'), array('cuid' => $cuid));
            $gfdt = $this->Generic_model->getData('bday_gift_stock', array('pric'), array('auid' => $gftyp));

            $gfvlu = $gfdt[0]->pric * $cunt;

            if (!empty($rqs)) {

                // insert data Voucher tb
                $data_arr = array(
                    'brco' => $brco,
                    'vuno' => $vuno,
                    'vuam' => $gfvlu,
                    'clid' => $cuid, // user id
                    'pyac' => 113,      // gift account
                    'pynm' => $cudt[0]->init,
                    //'pyad' => $this->input->post('pyad'),
                    //'pytp' => $this->input->post('pyct'),
                    'stat' => 1,
                    'mode' => 4, // gift voucher
                    'pmtp' => 11,// gift
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $re1 = $this->Generic_model->insertData('voucher', $data_arr);

                // insert data vouc_des tb
                // get voucher last recode id
                $vudt = $this->Generic_model->getData('voucher', array('void'), array('vuno' => $vuno));
                $lstid = $vudt[0]->void;

                // VOUCHER DISCRUPTION INSERT
                $data_arr2 = array(
                    'vuno' => $vuno,
                    'vuid' => $lstid, // voucher id
                    //'rfco' => $this->input->post('cqno'),
                    'rfdc' => 'Birthday gift for customer',
                    'rfdt' => date('Y-m-d'),
                    'amut' => $gfvlu,
                );
                $re2 = $this->Generic_model->insertData('vouc_des', $data_arr2);

                //  BIRTHDAY GIFT TABLE ADD DATA
                $data_arr = array(
                    'brco' => $cudt[0]->brco,
                    'exec' => $cudt[0]->exec,
                    'ccnt' => $cudt[0]->ccnt,
                    'stid' => $gftyp,
                    'vuid' => $lstid,
                    'cuid' => $cuid,
                    'cuno' => $cudt[0]->cuno,
                    'dobi' => $cudt[0]->dobi,
                    'gfcn' => $cunt,
                    'rqby' => $_SESSION['userId'],
                    'rqdt' => date('Y-m-d H:i:s'),
                    'stat' => 0,
                );
                $res3 = $this->Generic_model->insertData('bday_gift', $data_arr);

                // NEXRT VUNO
                $re = (explode("/", $vuno));
                $aa = intval($re[3]) + 1;

                $cc = strlen($aa);
                // next loan no
                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '' . $aa;
                }
                $vuno = $brcd . '/VU/' . $yr . '/' . $xx;
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

    // SEARCH GIFT VOUCHER
    function srchGift()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('bday_gift');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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
        if ($funcPerm[0]->prnt == 1) {
            $prnt1 = "";
        } else {
            $prnt1 = "disabled";
        }

        $result = $this->User_model->get_gift();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->auid;

            $pr = $rp = '';

            if ($row->stat == 0) {
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewGifVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app  id='app' data-toggle='modal' data-target='#modalView' onclick='viewGifVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' disabled $prnt1 data-toggle='modal'  onclick='vouGifPrint($auid);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej  onclick='rejecGifVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } elseif ($row->stat == 1) {  // if main statues approval
                $stat = "<span class='label label-success'> Approval</span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewGifVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app disabled id='app' data-toggle='modal' data-target='#modalView' onclick='viewGifVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' $prnt1  data-toggle='modal'  onclick='vouGifPrint($auid);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button'  disabled  onclick='rejecGifVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 2) {
                $stat = "<span class='label label-danger'> Reject </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewGifVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled id='app' data-toggle='modal' onclick='vouPrint($auid);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled onclick='rejecGifVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->gfnm;
            $sub_arr[] = $row->gfcn;
            $sub_arr[] = $row->exc;
            $sub_arr[] = $row->rqsdt;

            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_gift(),
            "recordsFiltered" => $this->User_model->count_filt_gift(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // VIEW GIFT VOUCHER
    function vewGiftVou()
    {
        $gfid = $this->input->post('gfid');

        $this->db->select("voucher.*,DATE_FORMAT(voucher.crdt, '%Y-%m-%d') AS vcrdt,  brch_mas.brnm ,pay_terms.tem_name ,vouc_des.rfdc,vouc_des.amut ,
        vouc_des.rfco,accu_chrt.hadr,bday_gift.auid ,bday_gift.gfcn ");
        $this->db->from("voucher");
        $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void');
        $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp');
        $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco');
        $this->db->join('accu_chrt', 'accu_chrt.idfr = voucher.pyac');
        $this->db->join('bday_gift', 'bday_gift.vuid = voucher.void');

        $this->db->where('bday_gift.auid', $gfid);
        $query = $this->db->get();
        $data['vudt'] = $query->result();

        echo json_encode($data);
    }

    // APPROVAL GIFT & VOUCHER
    function giftVouApprvl()
    {
        $vuid = $this->input->post('vuid'); // VOUCHER ID
        $auid = $this->input->post('gfid'); // GIFT TB AUID
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START
        $data_ar1 = array(
            'stat' => 2,
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        );
        $re1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vuid));


        $voudt = $this->Generic_model->getData('voucher', '', array('void' => $vuid));

        // ACCOUNT LEDGE
        $data_aclg1 = array(
            'brno' => $voudt[0]->brco, // BRANCH ID
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'OTHERS',
            'trid' => 6,
            'rfna' => $voudt[0]->vuno,
            'dcrp' => 'Birthday gift  ',
            'acco' => 113,    // cross acc code
            'spcd' => 514,    // split acc code
            'acst' => '(514) Gift Expense',
            'dbam' => $voudt[0]->vuam,
            'cram' => 0,
            'stat' => 0
        );
        $re2 = $this->Generic_model->insertData('acc_leg', $data_aclg1);

        $data_aclg2 = array(
            'brno' => $voudt[0]->brco, // BRANCH ID
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'OTHERS',
            'trid' => 6,
            'rfna' => $voudt[0]->vuno,
            'dcrp' => 'Birthday gift ',
            'acco' => 514,    // cross acc code
            'spcd' => 113,    // split acc code
            'acst' => '(113) Birthday Gift Stock',
            'dbam' => 0,
            'cram' => $voudt[0]->vuam,
            'stat' => 0
        );
        $re3 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
        // END ACCOUNT LEDGE

        $cudt = $this->Generic_model->getData('bday_gift', array('cuid'), array('vuid' => $vuid));
        //$lnid = $this->input->post('lnid');
        //$cmnt = ucwords(strtolower($this->input->post('cmnt')));
        $data_arr = array(
            'cmtp' => 1,
            'cmmd' => 0,
            'cmrf' => $cudt[0]->cuid,
            'cmnt' => 'Received the Birthday Gift',
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('comments', $data_arr);

        //  bday_gift TB UPDATE
        $data_ar2 = array(
            'stat' => 1,
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        );
        $re4 = $this->Generic_model->updateData('bday_gift', $data_ar2, array('auid' => $auid));

        $funcPerm = $this->Generic_model->getFuncPermision('bday_gift');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'birthday gift request approval ');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // GIFT VOUCHER PRINT
    function gifVouPrint($gfid)
    {
        $gfdt = $this->Generic_model->getData('bday_gift', array('vuid', 'gfcn'), array('auid' => $gfid));
        $rcdt = $this->Generic_model->getData('voucher', array('pntc'), array('void' => $gfdt[0]->vuid));
        $pntc = $rcdt[0]->pntc;

        // PRINT COUNT UPDATE VOUCHER TB
        if ($pntc > 0) {
            $data_ar1 = array(
                'rpby' => $_SESSION['userId'],
                'rpdt' => date('Y-m-d H:i:s'),
                'pntc' => $pntc + 1,
            );
        } else {
            $data_ar1 = array(
                'prby' => $_SESSION['userId'],
                'prdt' => date('Y-m-d H:i:s'),
                'pntc' => $pntc + 1,
            );
        }
        $result1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $gfdt[0]->vuid));
        // END PRINT COUNT UPDATE VOUCHER TB


        if (count($result1) > 0) {
            $this->load->library('ciqrcode');
            $this->db->select("voucher.*,vouc_des.amut,vouc_des.rfdc,brch_mas.brnm,user_mas.fnme,pay_terms.dsnm, CONCAT(accu_chrt.HADR,' (',accu_chrt.idfr,')') AS acc,
                       bday_gift.gfcn ");
            $this->db->from("voucher");
            $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco ');
            $this->db->join('user_mas', 'user_mas.auid = voucher.crby ');
            $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void ');
            $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp ');
            $this->db->join('accu_chrt', 'accu_chrt.idfr = voucher.pyac', 'left');
            $this->db->join('bday_gift', 'bday_gift.vuid = voucher.void', 'left');
            $this->db->where('voucher.void', $gfdt[0]->vuid);
            $query = $this->db->get();
            $data = $query->result();

            $this->db->select("c.cuid, c.init, c.cuno, c.dobi ,c.mobi, c.anic,cen_mas.cnnm");
            $this->db->from("cus_mas c");
            $this->db->join('cen_mas', 'cen_mas.caid = c.ccnt');
            $this->db->where("c.cuid", $data[0]->clid);
            $query = $this->db->get();
            $cudt = $query->result();

            $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
            $usr = $usedetails[0]->fnme;
            $comdt = $this->Generic_model->getData('com_det', array('cmne'), array('stat' => 1));
            $branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brco));

            $_SESSION['hid'] = mt_rand(10000000, 999999999);
            $cy = date('Y');
            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf->AddPage('L', 'A5');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, 'GIFT VOUCHER', 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $branc[0]->brad);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, "Tel : " . $branc[0]->brtp);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, "Fax : " . $branc[0]->brfx);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, "E-mail : " . $branc[0]->brem);
            $this->pdf->SetXY(5.5, 30);
            $this->pdf->Cell(0, 0, "Web : " . $branc[0]->brwb);

            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 8);

            $this->pdf->SetXY(16, 45);
            $this->pdf->Cell(1, 0, 'CUSTOMER NAME : ' . $data[0]->pynm, 0, 1, 'L');
            /*$this->pdf->SetFont('Helvetica', '', 8);*/
            $this->pdf->SetXY(16, 49);
            $this->pdf->Cell(1, 0, 'PAY TYPE : ' . $data[0]->dsnm, 0, 1, 'L');
            $this->pdf->SetXY(16, 53);

            /*if ($data[0]->pmtp == 2) {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . $data[0]->acnm . ' (' . $data[0]->acno . ') Chq no ' . $data[0]->cqno, 0, 1, 'L');
            } else {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . '-', 0, 1, 'L');
            }*/

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(135, 45);
            $this->pdf->Cell(1, 0, 'VOUCHER NO', 0, 1, 'L');
            $this->pdf->SetXY(135, 49);
            $this->pdf->Cell(1, 0, 'VOUCHER DATE : ' . $data[0]->crdt, 0, 1, 'L');
            $this->pdf->SetXY(135, 53);
            $this->pdf->Cell(1, 0, 'BRANCH', 0, 1, 'L');
            $this->pdf->SetXY(158.5, 45);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->vuno, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 53);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->brnm, 0, 1, 'L');

            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(15, 37);
            $this->pdf->Cell(180, 30, '', '1');

            // Payment details table border
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(15, 40, '', '1');
            $this->pdf->SetXY(30, 60);
            $this->pdf->Cell(70, 40, '', '1');
            $this->pdf->SetXY(100, 60);
            $this->pdf->Cell(70, 40, '', '1');
            $this->pdf->SetXY(170, 60);
            $this->pdf->Cell(25, 40, '', '1');

            // #0
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(15, 7, 'BILL NO', 1, 1, 'C');
            $this->pdf->SetXY(30, 60);
            $this->pdf->Cell(70, 7, 'VOUCHER DESCRIPTION', 1, 1, 'C');
            $this->pdf->SetXY(100, 60);
            $this->pdf->Cell(70, 7, 'ACCOUNT NAME', 1, 1, 'C');
            $this->pdf->SetXY(170, 60);
            $this->pdf->Cell(25, 7, 'QUANTITY', 1, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($data);

            $y = 70;
            $pyamt = 0;
            for ($i = 0; $i < $len; $i++) {
                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(15, 0, $i + 1, '0', '', 'C');
                $this->pdf->SetXY(30, $y);
                $this->pdf->Cell(70, 0, $data[$i]->rfdc, '0');
                $this->pdf->SetXY(100, $y);
                $this->pdf->Cell(70, 0, $data[$i]->acc, 'C');
                $this->pdf->SetXY(170, $y);
                //$this->pdf->Cell(25, 0, $data[$i]->amut, '0', '', 'C');
                $this->pdf->Cell(25, 0, $data[$i]->gfcn, '0', '', 'C');
                $y = $y + 5;
                $pyamt = $pyamt + $data[$i]->gfcn;
            }

            //-----TOTAL AMOUNT--------//
            $this->pdf->SetXY(170, 100);
            $this->pdf->Cell(25, 8, '', '1');
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(154, 100);
            $this->pdf->Cell(6, 10, 'TOTAL QUANTITY', 0, 1, 'R');
            $this->pdf->SetXY(170, 104);
            $this->pdf->Cell(25, 0, $pyamt, '0', '', 'C');
            $this->pdf->SetAutoPageBreak(false);

            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(5, 111);
            $this->pdf->Cell(0, 0, 'Prepared By : ' . $data[0]->fnme . ' | ' . $data[0]->crdt);
            $this->pdf->SetXY(5, 118);
            $this->pdf->Cell(0, 0, 'Approved By      : .....................................');
            $this->pdf->SetXY(75, 111);
            $this->pdf->Cell(0, 0, 'NIC / Passport   : ....................................');
            $this->pdf->SetXY(75, 118);
            $this->pdf->Cell(0, 0, 'Received By      : .......................................');
            /*$this->pdf->SetXY(75, 135);
            $this->pdf->Cell(0, 0, 'Signature        : .......................................');*/

            //FOOTER
            // REPRINT TAG
            $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
            if ($policy[0]->post == 1) {
                if ($rcdt[0]->pntc > 0) {
                    $this->pdf->SetFont('Helvetica', 'B', 7);
                    $this->pdf->SetXY(-15, 114);
                    $this->pdf->Cell(10, 6, 'RE-PRINTED (' . $pntc . ')', 0, 1, 'R');
                }
            }
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 118);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 122);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 122);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');

            //
            $this->pdf->SetFont('', 'B', '10');
            $this->pdf->SetAutoPageBreak(false);
            $this->pdf->SetXY(184, 105);
            // BOX
            $this->pdf->SetXY(50, 132.5);
            $this->pdf->Cell(100, 14, '', 1, 1, 'C');
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(55, 137);
            $this->pdf->Cell(0, 0, 'Name : ' . $cudt[0]->init, 0, 1, 'L');
            $this->pdf->SetXY(55, 143);
            $this->pdf->Cell(0, 0, $cudt[0]->cuno . ' | ' . $cudt[0]->mobi . ' | ' . $cudt[0]->cnnm, 0, 1, 'L');

            /*$this->pdf->SetXY(120, 132.5);
            $this->pdf->Cell(70, 14, 'BB', 1, 1, 'C');*/
            //DOT LINE SEPARATE
            $this->pdf->SetLineWidth(0.1);
            $this->pdf->SetDash(3, 2); //5mm on, 5mm off
            $this->pdf->Line(0, 130, 210, 130);

            //QR CODE
            $cd = 'Vou No : ' . $data[0]->vuno . ' | Date : ' . $data[0]->crdt . ' | Payee Name : ' . $data[0]->pynm . ' | Branch : ' . $data[0]->brnm . ' | Pay Type : ' . $data[0]->dsnm . ' | Total : ' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('Gift Voucher - ' . $data[0]->vuno);
            $this->pdf->Output('Gift_voucher_' . $data[0]->vuno . '.pdf', 'I');
            ob_end_flush();

        } else {
            echo json_encode(false);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('bday_gift');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Gift voucher print (' . $data[0]->vuno . ')');

    }

    // GIFT VOUCHER REJECT
    function rejGifVou()
    {
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START
        $auid = $this->input->post('id');
        $vudt = $this->Generic_model->getData('bday_gift', array('vuid'), array('auid' => $auid));

        // data remove in voucher table
        $data_ar1 = array(
            'stat' => 0,
            'trby' => $_SESSION['userId'],
            'trdt' => date('Y-m-d H:i:s'),
        );
        $re1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vudt[0]->vuid));
        ($re1) ? $chk = $chk + 1 : $this->Log_model->ErrorLog('bday_gift', 'Gift voucher Reject', '', $chk);

        // STATUES CHANGE bday_gift TB
        $data_ar2 = array(
            'stat' => 2,
            'rjby' => $_SESSION['userId'],
            'rjdt' => date('Y-m-d H:i:s'),
        );
        $re2 = $this->Generic_model->updateData('bday_gift', $data_ar2, array('auid' => $auid));
        ($re2) ? $chk = $chk + 1 : $this->Log_model->ErrorLog('bday_gift', 'Gift voucher Reject', '', $chk);


        $funcPerm = $this->Generic_model->getFuncPermision('bday_gift');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Gift voucher reject auid(' . $auid . ')');

        /*if ($chk == 2) {
            echo json_encode(true);
        } else {
            $this->Log_model->ErrorLog('bday_gift', 'Gift voucher Reject', '', $chk);
            echo json_encode(false);
        }*/
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

// END BIRTHDAY GIFT
//
// DEVELOPER COMMENT
    function dvlp_msg()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $this->db->select("usmd");
        $this->db->from("user_mas");
        $this->db->where('user_mas.auid', $_SESSION['userId']);
        $query = $this->db->get();
        $data['userlvl'] = $query->result();

        $this->load->view('modules/user/developer_comment', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchCmment()
    {
        $this->db->select("dvlp_cmnt.chid,dvlp_cmnt.mdle,dvlp_cmnt.crdt,dvlp_cmnt.chng,user_mas.desg, CONCAT(user_mas.fnme,' ',user_mas.lnme) AS ofc");
        $this->db->from("dvlp_cmnt");
        $this->db->join('user_mas', 'user_mas.auid = dvlp_cmnt.crby');
        $this->db->where('dvlp_cmnt.stat', 1);
        $this->db->order_by("dvlp_cmnt.crdt", "desc");
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $chid = $row->chid;
            if ($_SESSION['role'] == 1) {
                $option = "<button type='button' id='edt' data-toggle='modal' data-target='#modaledit' onclick='edtcomt($chid);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> ";
            } else {
                $option = "- ";
            }
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->mdle;
            $sub_arr[] = $row->chng;
            $sub_arr[] = $row->ofc;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    function addDvlpCommnt()
    {
        $data_arr = array(
            'mdle' => ucwords(strtolower($this->input->post('mdle'))),
            'chng' => ucwords(strtolower($this->input->post('remk'))),
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('dvlp_cmnt', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function vewCmment()
    {
        $this->db->select("*");
        $this->db->from("dvlp_cmnt");

        $this->db->where('chid', $this->input->post('chid'));
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    /*start update comment*/
    function edtCmment()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $data_arr = array(
            'mdle' => $this->input->post('mmdle'),
            'chng' => $this->input->post('cchng'),
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s'),
        );
        $where_arr = array(
            'chid' => $this->input->post('chid')
        );
        $result22 = $this->Generic_model->updateData('dvlp_cmnt', $data_arr, $where_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    /*end update comment*/
// END DEVELOPER COMMENT
//
// PETTY CASH ACCOUNT
    function ptycsh_acc()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['policyPetty'] = $this->Generic_model->getData('sys_policy', array('pov2'), array('stat' => 1, 'poid' => 15));

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('ptycsh_acc');
        $this->load->view('modules/user/ptycash_account', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');

    }

    // SEARCH PETTY CASH
    function srchPtycash()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_acc');

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

        $disabled = "disabled";

        $result = $this->User_model->get_ptycashDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $auid = $row->ptid;

            if ($st == '0') {  // Pending
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt' $edt data-toggle='modal' data-target='#modalEdt' onclick='edtPtycash($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $app data-toggle='modal' data-target='#modalEdt' onclick='edtPtycash($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $rej onclick='rejecPtycash($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '1') {  // approval
                $stat = "<span class='label label-success'> Approval </span> ";
                $option = "<button type='button' id='edt' disabled $edt data-toggle='modal' data-target='#modalEdt' onclick='' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled $app data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $rej onclick='rejecPtycash($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = "<span class='label label-danger'> Rejected </span> ";
                $option = "<button type='button' id='edt' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPtycash(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPtycash(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $disabled onclick='rejecPtycash();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '3') {  // settle
                $stat = "<span class='label label-danger'> Settle </span> ";
                $option = "<button type='button' id='edt' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPtycash(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPtycash(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $disabled onclick='rejecPtycash();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else {

            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = number_format($row->ptamt, 2);
            $sub_arr[] = number_format($row->rqamt, 2);
            $sub_arr[] = number_format($row->crbal, 2);
            $sub_arr[] = $row->dscr;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->rqdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_ptycash(),
            "recordsFiltered" => $this->User_model->count_filtered_ptycash(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // PETTY CASH ADD
    function addPettycash()
    {
        $data_arr = array(
            'rqbrn' => $this->input->post('brch'),
            'rqamt' => $this->input->post('rqamt'),
            'dscr' => ucwords(strtolower($this->input->post('dscp'))),
            'stat' => 0,
            'rqur' => $_SESSION['userId'],
            'rqdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('pettycash_acc', $data_arr);

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // VIEW PETTY CASH
    function vewPtycsh()
    {
        $auid = $this->input->post('auid');
        $data = $this->Generic_model->getData('pettycash_acc', '', array('ptid' => $auid));

        echo json_encode($data);
    }

    // EDIT PETTY CASH
    function edtPtycash()
    {

        $func = $this->input->post('func');
        $auid = $this->input->post('auid');

        if ($func == 1) {     //UPDATE
            $data_arr = array(
                'rqbrn' => $this->input->post('brchEdt'),
                'rqamt' => $this->input->post('rqamtEdt'),
                'dscr' => ucwords(strtolower($this->input->post('dscpEdt'))),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $re1 = $this->Generic_model->updateData('pettycash_acc', $data_arr, array('ptid' => $auid));

            $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_acc');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Petty cash account update id(' . $auid . ')');

            if (count($re1) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }

        } else if ($func == 2) {        // APPROVAL

            $this->db->trans_begin();   // SQL TRANSACTION START

            $rqamt = $this->input->post('rqamtEdt');
            $oldvou = $this->Generic_model->getData('pettycash_acc', array('ptid,ptamt,crbal'), array('rqbrn' => $this->input->post('brchEdt'), 'stat' => 1));
            if (count($oldvou) > 0) {
                $this->Generic_model->updateData('pettycash_acc', array('stat' => 3), array('ptid' => $oldvou[0]->ptid));
                $ptamt = $oldvou[0]->ptamt + $rqamt;
                $crbal = $oldvou[0]->crbal + $rqamt;
            } else {
                $ptamt = $rqamt;
                $crbal = $rqamt;
            }

            $ptid = $this->input->post('auid');

            $data_arr = array(
                'rqbrn' => $this->input->post('brchEdt'),
                'rqamt' => $this->input->post('rqamtEdt'),
                'ptamt' => $ptamt,
                'crbal' => $crbal,

                'dscr' => ucwords(strtolower($this->input->post('dscpEdt'))),
                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $re1 = $this->Generic_model->updateData('pettycash_acc', $data_arr, array('ptid' => $ptid));

            // ACCOUNT LEDGE
            $data_aclg1 = array(
                'brno' => $this->input->post('brchEdt'), // BRANCH ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'INTR',
                'trid' => 31,
                'rfno' => $ptid,
                'dcrp' => 'petty cash reservation ',
                'acco' => 106,    // cross acc code
                'spcd' => 112,    // split acc code
                'acst' => '(112) Petty Cash Book',
                'dbam' => $this->input->post('rqamtEdt'),
                'cram' => 0,
                'stat' => 0
            );
            $re2 = $this->Generic_model->insertData('acc_leg', $data_aclg1);

            $data_aclg2 = array(
                'brno' => $this->input->post('brchEdt'), // BRANCH ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'INTR',
                'trid' => 31,
                'rfno' => $ptid,
                'dcrp' => 'petty cash reservation',
                'acco' => 112,    // cross acc code
                'spcd' => 106,    // split acc code
                'acst' => '(106) Cash Book',
                'dbam' => 0,
                'cram' => $this->input->post('rqamtEdt'),
                'stat' => 0
            );
            $re3 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
            // END ACCOUNT LEDGE

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_acc');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Petty cash request Approval id(' . $auid . ')');

        }
    }

    // REJECT PETTY CASH
    function rejPtycash()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('pettycash_acc', array('stat' => 2), array('ptid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_acc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Pettycash reject id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

// END PETTY CASH ACCOUNT
//
// PETTY CASH MANAGEMENT
    function ptycsh_mng()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('ptycsh_mng');
        $data['accountinfo'] = $this->Generic_model->getData('accu_chrt', array('auid,idfr,hadr'), array('acid' => 5, 'stat' => 1));

        $this->load->view('modules/user/ptycash_voucher', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // CHECK PETTY CASH VALUE
    public function chk_pty_value()
    {
        $result = $this->Generic_model->getData('pettycash_acc', '', array('rqbrn' => $this->input->post('brn'), 'stat' => 1));

        if (count($result) > 0) {
            if ($result[0]->crbal > 0 && $result[0]->crbal >= $this->input->post('amt')) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode("No Petty Cash Balance");
        }
    }

    // SEARCH PETTY CASH
    function srchPtyvouc()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_mng');

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
        if ($funcPerm[0]->prnt == 1) {
            $prnt1 = "";
        } else {
            $prnt1 = "disabled";
        }
        $disabled = "disabled";

        $result = $this->User_model->get_ptycashVouc();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $auid = $row->ptid;

            if ($st == '0') {           // Pending
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt' $edt data-toggle='modal' data-target='#modalEdt' onclick='edtPtyVouc($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $app data-toggle='modal' data-target='#modalEdt' onclick='edtPtyVouc($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' disabled $prnt1 data-toggle='modal'  onclick='ptyvoucPrint($auid);' class='btn btn-default btn-condensed ' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $rej onclick='rejecPtyvouc($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {    // approval
                $stat = "<span class='label label-success'> Approval </span> ";
                $option = "<button type='button' id='edt' disabled $edt data-toggle='modal' data-target='#modalEdt' onclick='' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled $app data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app'  $prnt1 data-toggle='modal'  onclick='ptyvoucPrint($auid);' class='btn btn-default btn-condensed' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' disabled onclick='rejecPtyvouc($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {    // Rejected
                $stat = "<span class='label label-danger'> Rejected </span> ";
                $option = "<button type='button' id='edt' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPtyVouc(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPtyVouc(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' disabled $prnt1 data-toggle='modal'  onclick='ptyvoucPrint();' class='btn btn-default btn-condensed ' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $disabled onclick='rejecPtyvouc();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '3') {    // settle
                $stat = "<span class='label label-danger'> Settle </span> ";
                $option = "<button type='button' id='edt' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPtyVouc(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtPtyVouc(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' disabled $prnt1 data-toggle='modal'  onclick='ptyvoucPrint();' class='btn btn-default btn-condensed' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $disabled onclick='rejecPtyvouc();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else {
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->rqusr;
            $sub_arr[] = $row->vuno;
            $sub_arr[] = $row->hadr;
            $sub_arr[] = $row->bref;
            $sub_arr[] = $row->pydt;
            $sub_arr[] = number_format($row->amut, 2);
            $sub_arr[] = $row->crusr;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_ptycashVouc(),
            "recordsFiltered" => $this->User_model->count_filtered_ptycashVouc(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // PETTY CASH ADD
    function addPtycashVouc()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $brco = $this->input->post('brchRq');

        // Genarate Voucher No
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $this->db->select("vuno");
        $this->db->from("pettycash_vou");
        $this->db->where('pettycash_vou.brid ', $brco);
        $this->db->order_by('pettycash_vou.ptid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $vuno = $brcd . '/PV/' . $yr . '/00001';
        } else {
            $reno = $data[0]->vuno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;
            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }
            $vuno = $brcd . '/PV/' . $yr . '/' . $xx;
        }
        // END Genarate Voucher No

        $data_arr = array(
            'brid' => $brco,
            'vuno' => $vuno,
            'usrid' => $this->input->post('user'),
            'pyac' => $this->input->post('rfac'),
            'bref' => ucwords(strtolower($this->input->post('rfnc'))),
            'amut' => $this->input->post('rqamt'),
            'pydt' => $this->input->post('pydt'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('pettycash_vou', $data_arr);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    // VIEW PETTY CASH
    function vewPtyVouc()
    {
        $auid = $this->input->post('auid');
        $data = $this->Generic_model->getData('pettycash_vou', '', array('ptid' => $auid));

        echo json_encode($data);
    }

    // EDIT PETTY CASH
    function edtPtyvouc()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');

        if ($func == 1) {           //UPDATE
            $data_arr = array(
                'brid' => $this->input->post('brchRqEdt'),
                'usrid' => $this->input->post('userEdt'),
                'pyac' => $this->input->post('rfacEdt'),
                'bref' => ucwords(strtolower($this->input->post('rfncEdt'))),
                'amut' => $this->input->post('rqamtEdt'),
                'pydt' => $this->input->post('pydtEdt'),

                'stat' => 0,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $re1 = $this->Generic_model->updateData('pettycash_vou', $data_arr, array('ptid' => $auid));

            $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Petty cash voucher update id(' . $auid . ')');

            if (count($re1) > 0) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }

        } else if ($func == 2) {        // APPROVAL

            $this->db->trans_begin(); // SQL TRANSACTION START

            $data_arr = array(
                'brid' => $this->input->post('brchRqEdt'),
                'usrid' => $this->input->post('userEdt'),
                'pyac' => $this->input->post('rfacEdt'),
                'bref' => ucwords(strtolower($this->input->post('rfncEdt'))),
                'amut' => $this->input->post('rqamtEdt'),
                'pydt' => $this->input->post('pydtEdt'),

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $re1 = $this->Generic_model->updateData('pettycash_vou', $data_arr, array('ptid' => $auid));


            $pyac = $this->input->post('rfacEdt');
            $acdt = $this->Generic_model->getData('accu_chrt', array('idfr', 'hadr'), array('auid' => $pyac));
            $vudt = $this->Generic_model->getData('pettycash_vou', array('vuno'), array('ptid' => $auid));

            // ACCOUNT LEDGE
            $data_aclg1 = array(
                'brno' => $this->input->post('brchRqEdt'), // BRANCH ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'PET CASH',
                'trid' => 32,
                'rfno' => $auid,
                'rfna' => $vudt[0]->vuno,
                'dcrp' => 'petty cash payment ',
                'acco' => 112,              // cross acc code
                'spcd' => $acdt[0]->idfr,   // split acc code
                'acst' => "(" . $acdt[0]->idfr . ") " . $acdt[0]->hadr,
                'dbam' => $this->input->post('rqamtEdt'),
                'cram' => 0,
                'stat' => 0
            );
            $re2 = $this->Generic_model->insertData('acc_leg', $data_aclg1);

            $data_aclg2 = array(
                'brno' => $this->input->post('brchRqEdt'), // BRANCH ID
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'PET CASH',
                'trid' => 32,
                'rfno' => $auid,
                'rfna' => $vudt[0]->vuno,
                'dcrp' => 'petty cash payment',
                'acco' => $acdt[0]->idfr,       // cross acc code
                'spcd' => 112,                  // split acc code
                'acst' => '(112) Petty Cash Book',
                'dbam' => 0,
                'cram' => $this->input->post('rqamtEdt'),
                'stat' => 0
            );
            $re3 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
            // END ACCOUNT LEDGE

            $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Petty cash voucher Approval id(' . $auid . ')');

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

    // REJECT PETTY CASH
    function rejPtyvouc()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('pettycash_vou', array('stat' => 2), array('ptid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Petty Cash voucher reject id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // PRINT PETTYCASH VOUCHER
    function ptyVoucPrint($id)
    {
        $data_ar1 = array(
            'prby' => $_SESSION['userId'],
            'prdt' => date('Y-m-d H:i:s'),
        );
        $this->Generic_model->updateData('pettycash_vou', $data_ar1, array('ptid' => $id));


        $this->load->library('ciqrcode');
        $this->db->select("pettycash_vou.*, brch_mas.brnm, CONCAT(user_mas.fnme,' ',user_mas.lnme) AS pynm, cc.fnme AS crusr, CONCAT(accu_chrt.idfr,' (',accu_chrt.hadr,')') AS acc,
                        ");
        $this->db->from("pettycash_vou");
        $this->db->join('brch_mas', 'brch_mas.brid = pettycash_vou.brid ');
        $this->db->join('user_mas', 'user_mas.auid = pettycash_vou.usrid ');
        $this->db->join('user_mas cc', 'cc.auid = pettycash_vou.crby ');
        $this->db->join('accu_chrt', 'accu_chrt.auid = pettycash_vou.pyac', 'left');
        $this->db->where('pettycash_vou.ptid', $id);
        $query = $this->db->get();
        $data = $query->result();

        $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
        $usr = $usedetails[0]->fnme;

        $comdt = $this->Generic_model->getData('com_det', array('cmne'), array('stat' => 1));
        $branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brid));

        $_SESSION['hid'] = mt_rand(10000000, 999999999);
        $cy = date('Y');
        $date = date('Y-m-d H:i:s');
        ob_start();
        $this->pdf->AddPage('L', 'A5');
        $this->pdf->SetFont('Helvetica', 'B', 15);
        $this->pdf->SetTextColor(50, 50, 50);
        $this->pdf->SetXY(10, 32);
        $this->pdf->Cell(0, 0, 'PETTYCASH VOUCHER', 0, 1, 'C');
        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(188, 37);

        // Top left company details
        $this->pdf->SetFont('Helvetica', 'B', 15);
        $this->pdf->SetXY(5, 9);
        $this->pdf->Cell(0, 0, $comdt[0]->cmne);
        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(5.5, 14);
        $this->pdf->Cell(0, 0, $branc[0]->brad);
        $this->pdf->SetXY(5.5, 18);
        $this->pdf->Cell(0, 0, "Tel : " . $branc[0]->brtp);
        $this->pdf->SetXY(5.5, 22);
        $this->pdf->Cell(0, 0, "Fax : " . $branc[0]->brfx);
        $this->pdf->SetXY(5.5, 26);
        $this->pdf->Cell(0, 0, "E-mail : " . $branc[0]->brem);
        $this->pdf->SetXY(5.5, 30);
        $this->pdf->Cell(0, 0, "Web : " . $branc[0]->brwb);

        $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
        $this->pdf->SetFont('Helvetica', 'B', 8);

        $this->pdf->SetXY(16, 45);
        $this->pdf->Cell(1, 0, 'PAYEE NAME : ' . $data[0]->pynm, 0, 1, 'L');
        /*$this->pdf->SetFont('Helvetica', '', 8);*/
        $this->pdf->SetXY(16, 49);
        $this->pdf->Cell(1, 0, 'PAY TYPE : CASH', 0, 1, 'L');
        $this->pdf->SetXY(16, 53);

        /* if ($data[0]->pmtp == 2) {
             $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . $data[0]->acnm . ' (' . $data[0]->acno . ') Chq no ' . $data[0]->cqno, 0, 1, 'L');
         } else {
             $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . '-', 0, 1, 'L');
         }*/

        $this->pdf->SetFont('Helvetica', 'B', 8);
        $this->pdf->SetXY(135, 45);
        $this->pdf->Cell(1, 0, 'VOUCHER NO', 0, 1, 'L');
        $this->pdf->SetXY(135, 49);
        $this->pdf->Cell(1, 0, 'VOUCHER DATE : ' . $data[0]->crdt, 0, 1, 'L');
        $this->pdf->SetXY(135, 53);
        $this->pdf->Cell(1, 0, 'BRANCH', 0, 1, 'L');
        $this->pdf->SetXY(158.5, 45);
        $this->pdf->Cell(1, 0, ': ' . $data[0]->vuno, 0, 1, 'L');
        $this->pdf->SetXY(158.5, 53);
        $this->pdf->Cell(1, 0, ': ' . $data[0]->brnm, 0, 1, 'L');

        //----- TABLE -------//
        $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetXY(15, 37);
        $this->pdf->Cell(180, 30, '', '1');

        // Payment details table border
        $this->pdf->SetXY(15, 60);
        $this->pdf->Cell(15, 50, '', '1');
        $this->pdf->SetXY(30, 60);
        $this->pdf->Cell(70, 50, '', '1');
        $this->pdf->SetXY(100, 60);
        $this->pdf->Cell(70, 50, '', '1');

        $this->pdf->SetXY(170, 60);
        $this->pdf->Cell(25, 50, '', '1');

        // #0
        $this->pdf->SetXY(15, 60);
        $this->pdf->Cell(15, 7, 'BILL NO', 1, 1, 'C');
        $this->pdf->SetXY(30, 60);
        $this->pdf->Cell(70, 7, 'PAYMENT DESCRIPTION', 1, 1, 'C');
        $this->pdf->SetXY(100, 60);
        $this->pdf->Cell(70, 7, 'ACCOUNT NAME', 1, 1, 'C');
        $this->pdf->SetXY(170, 60);
        $this->pdf->Cell(25, 7, 'AMOUNT', 1, 1, 'C');
        $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
        $this->pdf->SetTextColor(0, 0, 0);

        // #1 - n recode
        $len = sizeof($data);

        $y = 70;
        $pyamt = 0;
        for ($i = 0; $i < $len; $i++) {
            $this->pdf->SetXY(15, $y);
            $this->pdf->Cell(15, 0, $i + 1, '0', '', 'C');
            $this->pdf->SetXY(30, $y);
            $this->pdf->Cell(70, 0, $data[$i]->bref, '0');
            $this->pdf->SetXY(100, $y);
            $this->pdf->Cell(70, 0, $data[$i]->acc, 'C');
            $this->pdf->SetXY(170, $y);
            $this->pdf->Cell(25, 0, number_format($data[$i]->amut, 2, '.', ','), '0', '', 'R');
            $y = $y + 5;
            $pyamt = $pyamt + $data[$i]->amut;
        }

        //-----TOTAL AMOUNT--------//
        $this->pdf->SetXY(170, 110);
        $this->pdf->Cell(25, 8, '', '1');
        $this->pdf->SetFont('Helvetica', 'B', 8);
        $this->pdf->SetXY(154, 110);
        $this->pdf->Cell(6, 10, 'TOTAL AMOUNT', 0, 1, 'R');
        $this->pdf->SetXY(170, 114);
        $this->pdf->Cell(25, 0, number_format($pyamt, 2, '.', ','), '0', '', 'R');
        $this->pdf->SetAutoPageBreak(false);

        $this->pdf->SetFont('Helvetica', '', 8);
        $this->pdf->SetXY(5, 121);
        $this->pdf->Cell(0, 0, 'Prepared By : ' . $data[0]->crusr . ' | ' . $data[0]->crdt);
        $this->pdf->SetXY(5, 128);
        $this->pdf->Cell(0, 0, 'Approved By      : .....................................');
        $this->pdf->SetXY(75, 121);
        $this->pdf->Cell(0, 0, 'NIC / Passport   : ....................................');
        $this->pdf->SetXY(75, 128);
        $this->pdf->Cell(0, 0, 'Received By      : .......................................');
        $this->pdf->SetXY(75, 135);
        $this->pdf->Cell(0, 0, 'Signature        : .......................................');

        //FOOTER
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->SetXY(-15, 135);
        $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
        $this->pdf->SetFont('Helvetica', 'I', 7);
        $this->pdf->SetXY(-15, 140);
        $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
        $this->pdf->SetXY(4, 140);
        $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');

        //QR CODE
        $cd = 'Vou No : ' . $data[0]->vuno . ' | Date : ' . $data[0]->crdt . ' | Payee Name : ' . $data[0]->pynm . ' | Branch : ' . $data[0]->brnm . ' | Pay Type : CASH | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
        $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

        $this->pdf->SetTitle('Pettycash Voucher - ' . $data[0]->vuno);
        $this->pdf->Output('Pettycash_voucher_' . $data[0]->vuno . '.pdf', 'I');
        ob_end_flush();

        $funcPerm = $this->Generic_model->getFuncPermision('ptycsh_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'pettycash voucher print (' . $data[0]->vuno . ')');

    }

// END PETTY CASH MANAGEMENT
//
// OTHER LOAN CHARGES ADD
    function loan_chrg()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['chginfo'] = $this->Generic_model->getData('chg_type', '', array('stat' => 1));
        $data['pay_at'] = $this->Generic_model->getData('pay_at', '', '');
        $data['pay_by'] = $this->Generic_model->getData('pay_by', '', '');
        $data['payinfo'] = $this->Generic_model->getData('pay_terms', '', array('stat' => 1));

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('loan_chrg');
        $this->load->view('modules/user/other_charges', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchLnchrgs()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('loan_chrg');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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

        $disabled = "disabled";

        $result = $this->User_model->get_loanChargs();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->auid;

            if ($row->stat == 0) {
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='edt' $viw data-toggle='modal' data-target='#modalEdit' onclick='edtChrgs($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' $app  id='app' data-toggle='modal' data-target='#modalEdit' onclick='edtChrgs($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej  onclick='rejecChrg($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } elseif ($row->stat == 1) {  // if main statues approval
                $stat = "<span class='label label-success'> Approval</span> ";
                $app2 = "disabled";

                $option = "<button type='button' id='edt' $app2 data-toggle='modal' data-target='#modalEdit' onclick='edtChrgs($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' $app $app2 id='app' data-toggle='modal' data-target='#modalEdit' onclick='edtChrgs($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej $app2 onclick='rejecChrg($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 2) {
                $stat = "<span class='label label-danger'> Reject </span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdit' onclick='edtChrgs($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='app' data-toggle='modal' data-target='#modalEdit' onclick='edtChrgs($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled onclick='rejecChrg($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->init; // cust name
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->modt;
            $sub_arr[] = number_format($row->camt, 2, '.', ',');
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_loanChargs(),
            "recordsFiltered" => $this->User_model->count_filtered_loanChargs(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // GET LOAN DETILS
    function getaddLndtils()
    {
        $lnno = $this->input->post('lnno');
        $chtp = $this->input->post('chtp');

        $this->db->select("cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,micr_crt.lnid,micr_crt.docg,micr_crt.incg");
        $this->db->from("micr_crt");

        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->where('micr_crt.acno', $lnno);
        if ($chtp == 1) {
            $this->db->where('micr_crt.stat', 2);
        } else if ($chtp == 3) {
            $this->db->where('micr_crt.stat', 5);
        }

        $query = $this->db->get();
        $data = $query->result();

        echo json_encode($data);
    }

    // add other payment
    function addCharge()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $lnno = $this->input->post('lnno');
        $lndt = $this->Generic_model->getData('micr_crt', array('brco', 'clct', 'ccnt'), array('lnid' => $this->input->post('lnid')));

        $data_arr = array(
            'brco' => $lndt[0]->brco,
            'clct' => $lndt[0]->clct,
            'ccnt' => $lndt[0]->ccnt,

            'lnid' => $this->input->post('lnid'),
            'chtp' => $this->input->post('chtp'),
            'camt' => $this->input->post('cham'),
            'remk' => $this->input->post('remk'),

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('oter_charges', $data_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('loan_chrg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add Loan Charges (' . $lnno . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    function vewChrge()
    {
        $auid = $this->input->post('auid');
        $this->db->select("oter_charges.*,cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,micr_crt.acno, micr_crt.docg,micr_crt.incg");
        $this->db->from("oter_charges");
        $this->db->join('micr_crt', 'micr_crt.lnid = oter_charges.lnid');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->where('oter_charges.auid', $auid);

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // payment edit and approval
    function edtCharge()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');
        $chtp = $this->input->post('chtpEdt');
        $camt = $this->input->post('chamEdt');
        $remk = $this->input->post('remkEdt');

        $lnno = $this->input->post('lnnoEdt');

        $lnid = $this->input->post('lnidEdt');
        $lndt = $this->Generic_model->getData('micr_crt', array('brco', 'clct', 'ccnt', 'acno'), array('lnid' => $lnid));

        $chk = 0;

        if ($func == '1') {                  // update
            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr = array(
                'brco' => $lndt[0]->brco,
                'clct' => $lndt[0]->clct,
                'ccnt' => $lndt[0]->ccnt,
                'lnid' => $lnid,
                'chtp' => $chtp,
                'camt' => $camt,
                'remk' => $remk,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'auid' => $auid
            );
            $result22 = $this->Generic_model->updateData('oter_charges', $data_arr, $where_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('loan_chrg');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Edit Loan Charges (' . $auid . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }

        } elseif ($func == '2') {            // approval

            $this->db->trans_begin(); // SQL TRANSACTION START

            $data_arr = array(
                'brco' => $lndt[0]->brco,
                'clct' => $lndt[0]->clct,
                'ccnt' => $lndt[0]->ccnt,

                'lnid' => $lnid,
                'chtp' => $chtp,
                'camt' => $camt,
                'remk' => $remk,
                'stat' => 1,

                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );

            $where_arr = array(
                'auid' => $auid
            );

            $result22 = $this->Generic_model->updateData('oter_charges', $data_arr, $where_arr);

// UPDATE MICRO LOAN TB CHARGES
            $lndt2 = $this->Generic_model->getData('micr_crt', array('avdb', 'avcr'), array('lnid' => $lnid));

            if ($lndt2[0]->avcr > 0) {            // OVER PTMY > CHARGE --> (OVPYMT - CHRGS)

                if ($camt > $lndt2[0]->avcr) {    // CHARG > OVER PYMNT (20 > 10 )

                    $this->Generic_model->updateData('micr_crt', array('avcr' => 0, 'avdb' => $lndt2[0]->avdb + ($camt - $lndt2[0]->avcr)), array('lnid' => $lnid));
                } else {

                    $this->Generic_model->updateData('micr_crt', array('avcr' => $lndt2[0]->avcr - $camt), array('lnid' => $lnid));
                }

            } else {      // CHARGS + CHRG
                $this->Generic_model->updateData('micr_crt', array('avdb' => $lndt2[0]->avdb + $camt), array('lnid' => $lnid));
            }


            //  MICRO & ACCOUNT LEDGE @1
            $chrgtp = $this->input->post('chtpEdt');  // IF 1-DOC & INS /2-OTHER DOC/3-RCVER LETR/4-SERVICE CHRG  ( chg_type tb)

            $acno = $lndt[0]->acno;
            if ($camt > 0) {

                if ($chrgtp == 1) {
                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'dsid' => 1,
                        'dcrp' => 'NEW DOC & INSU CHRG',
                        'schg' => $camt,
                        'duam' => $camt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

                    // ACCOUNT LEDGE @1
                    $data_aclg23 = array(
                        'brno' => $lndt[0]->brco,   // BRANCH ID
                        'lnid' => $lnid,            // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'CHRG',
                        'trid' => 1,
                        'rfna' => $acno,
                        'dcrp' => 'NEW CHARGES ADD ',

                        'acco' => 104,    // cross acc code
                        'spcd' => 108,    // split acc code
                        'acst' => '(108) Loan Stock',      //
                        'dbam' => $camt,    // db amt
                        'cram' => 0,        // cr amt
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $lndt[0]->brco,   // BRANCH ID
                        'lnid' => $lnid,            // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'CHRG',
                        'trid' => 1,
                        'rfna' => $acno,
                        'dcrp' => 'NEW CHARGES ADD',

                        'acco' => 108,    // cross acc code
                        'spcd' => 104,    // split acc code
                        'acst' => '(104) Accounts Receivable',      //
                        'dbam' => 0,            // db amt
                        'cram' => $camt,        // cr amt
                        'stat' => 1
                    );
                    $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);


                } else if ($chrgtp == 2) { // OTHER DOCUMENT CHRG

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'dsid' => 23,
                        'dcrp' => 'NEW ODC CHRG',
                        'schg' => $camt,
                        'duam' => $camt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);


                    // ACCOUNT LEDGE @1
                    $data_aclg23 = array(
                        'brno' => $lndt[0]->brco,   // BRANCH ID
                        'lnid' => $lnid,            // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ODC CHRG',
                        'trid' => 27,
                        'rfna' => $acno,
                        'dcrp' => 'ODC CHRG ADD ',

                        'acco' => 104,    // cross acc code
                        'spcd' => 108,    // split acc code
                        'acst' => '(108) Loan Stock',      //
                        'dbam' => $camt,    // db amt
                        'cram' => 0,        // cr amt
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $lndt[0]->brco,   // BRANCH ID
                        'lnid' => $lnid,            // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ODC CHRG',
                        'trid' => 27,
                        'rfna' => $acno,
                        'dcrp' => 'ODC CHRG ADD',

                        'acco' => 108,    // cross acc code
                        'spcd' => 104,    // split acc code
                        'acst' => '(104) Accounts Receivable',      //
                        'dbam' => 0,            // db amt
                        'cram' => $camt,        // cr amt
                        'stat' => 1
                    );
                    $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);


                } else if ($chrgtp == 3) { // RECOVER LETTER CHRG

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'dsid' => 24,
                        'dcrp' => 'NEW RLC CHRG',
                        'schg' => $camt,
                        'duam' => $camt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);


                    // ACCOUNT LEDGE @1
                    $data_aclg23 = array(
                        'brno' => $lndt[0]->brco,   // BRANCH ID
                        'lnid' => $lnid,            // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'RLC CHRG',
                        'trid' => 28,
                        'rfna' => $acno,
                        'dcrp' => 'RLC CHRG ADD ',

                        'acco' => 104,    // cross acc code
                        'spcd' => 108,    // split acc code
                        'acst' => '(108) Loan Stock',      //
                        'dbam' => $camt,    // db amt
                        'cram' => 0,        // cr amt
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $lndt[0]->brco,   // BRANCH ID
                        'lnid' => $lnid,            // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'RLC CHRG',
                        'trid' => 28,
                        'rfna' => $acno,
                        'dcrp' => 'RLC CHRG ADD',

                        'acco' => 108,    // cross acc code
                        'spcd' => 104,    // split acc code
                        'acst' => '(104) Accounts Receivable',      //
                        'dbam' => 0,            // db amt
                        'cram' => $camt,        // cr amt
                        'stat' => 1
                    );
                    $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);


                } else if ($chrgtp == 4) { // SERVICE CHRG

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'dsid' => 25,
                        'dcrp' => 'NEW SRV CHRG',
                        'schg' => $camt,
                        'duam' => $camt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);


                    // ACCOUNT LEDGE @1
                    $data_aclg23 = array(
                        'brno' => $lndt[0]->brco,   // BRANCH ID
                        'lnid' => $lnid,            // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'SRV CHRG',
                        'trid' => 29,
                        'rfna' => $acno,
                        'dcrp' => 'SRV CHRG ADD ',

                        'acco' => 104,    // cross acc code
                        'spcd' => 108,    // split acc code
                        'acst' => '(108) Loan Stock',      //
                        'dbam' => $camt,    // db amt
                        'cram' => 0,        // cr amt
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $lndt[0]->brco,   // BRANCH ID
                        'lnid' => $lnid,            // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'SRV CHRG',
                        'trid' => 29,
                        'rfna' => $acno,
                        'dcrp' => 'SRV CHRG ADD',

                        'acco' => 108,    // cross acc code
                        'spcd' => 104,    // split acc code
                        'acst' => '(104) Accounts Receivable',      //
                        'dbam' => 0,            // db amt
                        'cram' => $camt,        // cr amt
                        'stat' => 1
                    );
                    $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);

                } else {

                }
            } else {

            }

            // CHARGES RECOVER FOR OVER PAYMENT
            if ($lndt2[0]->avcr > 0) {              // OVER PTMY > CHARGE --> (OVPYMT - CHRGS)

                if ($camt > $lndt2[0]->avcr) {      // CHARG > OVER PYMNT (20 > 10 )

                    $rcamt = $lndt2[0]->avcr;         // 100 > 10  100 - 10 = 90

                } else {
                    $rcamt = $camt;

                }

                if ($chrgtp == 1) {
                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'dsid' => 1,
                        'dcrp' => 'RECOV FOR DOC & INSU CHRG',
                        'schg' => -$rcamt,
                        'ream' => $rcamt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

                    // ACCOUNT LEDGE @1
                    /* $data_aclg23 = array(
                         'brno' => $lndt[0]->brco,   // BRANCH ID
                         'lnid' => $lnid,            // LOAN NO
                         'acdt' => date('Y-m-d H:i:s'),
                         'trtp' => 'CHRG',
                         'trid' => 1,
                         'rfna' => $acno,
                         'dcrp' => 'NEW CHARGES ADD ',

                         'acco' => 104,    // cross acc code
                         'spcd' => 108,    // split acc code
                         'acst' => '(108) Loan Stock',      //
                         'dbam' => $camt,    // db amt
                         'cram' => 0,        // cr amt
                         'stat' => 1
                     );
                     $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                     $data_aclg45 = array(
                         'brno' => $lndt[0]->brco,   // BRANCH ID
                         'lnid' => $lnid,            // LOAN NO
                         'acdt' => date('Y-m-d H:i:s'),
                         'trtp' => 'CHRG',
                         'trid' => 1,
                         'rfna' => $acno,
                         'dcrp' => 'NEW CHARGES ADD',

                         'acco' => 108,    // cross acc code
                         'spcd' => 104,    // split acc code
                         'acst' => '(104) Accounts Receivable',      //
                         'dbam' => 0,            // db amt
                         'cram' => $camt,        // cr amt
                         'stat' => 1
                     );
                     $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);*/


                } else if ($chrgtp == 2) { // OTHER DOCUMENT CHRG

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'dsid' => 23,
                        'dcrp' => 'RECOV FOR ODC CHRG',
                        'schg' => -$rcamt,
                        'ream' => $rcamt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);


                    /* // ACCOUNT LEDGE @1
                     $data_aclg23 = array(
                         'brno' => $lndt[0]->brco,   // BRANCH ID
                         'lnid' => $lnid,            // LOAN NO
                         'acdt' => date('Y-m-d H:i:s'),
                         'trtp' => 'ODC CHRG',
                         'trid' => 27,
                         'rfna' => $acno,
                         'dcrp' => 'ODC CHRG ADD ',

                         'acco' => 104,    // cross acc code
                         'spcd' => 108,    // split acc code
                         'acst' => '(108) Loan Stock',      //
                         'dbam' => $camt,    // db amt
                         'cram' => 0,        // cr amt
                         'stat' => 1
                     );
                     $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                     $data_aclg45 = array(
                         'brno' => $lndt[0]->brco,   // BRANCH ID
                         'lnid' => $lnid,            // LOAN NO
                         'acdt' => date('Y-m-d H:i:s'),
                         'trtp' => 'ODC CHRG',
                         'trid' => 27,
                         'rfna' => $acno,
                         'dcrp' => 'ODC CHRG ADD',

                         'acco' => 108,    // cross acc code
                         'spcd' => 104,    // split acc code
                         'acst' => '(104) Accounts Receivable',      //
                         'dbam' => 0,            // db amt
                         'cram' => $camt,        // cr amt
                         'stat' => 1
                     );
                     $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);*/


                } else if ($chrgtp == 3) { // RECOVER LETTER CHRG

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'dsid' => 24,
                        'dcrp' => 'RECOV FOR RLC CHRG',
                        'schg' => -$rcamt,
                        'ream' => $rcamt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);


                    /* // ACCOUNT LEDGE @1
                     $data_aclg23 = array(
                         'brno' => $lndt[0]->brco,   // BRANCH ID
                         'lnid' => $lnid,            // LOAN NO
                         'acdt' => date('Y-m-d H:i:s'),
                         'trtp' => 'RLC CHRG',
                         'trid' => 28,
                         'rfna' => $acno,
                         'dcrp' => 'RLC CHRG ADD ',

                         'acco' => 104,    // cross acc code
                         'spcd' => 108,    // split acc code
                         'acst' => '(108) Loan Stock',      //
                         'dbam' => $camt,    // db amt
                         'cram' => 0,        // cr amt
                         'stat' => 1
                     );
                     $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                     $data_aclg45 = array(
                         'brno' => $lndt[0]->brco,   // BRANCH ID
                         'lnid' => $lnid,            // LOAN NO
                         'acdt' => date('Y-m-d H:i:s'),
                         'trtp' => 'RLC CHRG',
                         'trid' => 28,
                         'rfna' => $acno,
                         'dcrp' => 'RLC CHRG ADD',

                         'acco' => 108,    // cross acc code
                         'spcd' => 104,    // split acc code
                         'acst' => '(104) Accounts Receivable',      //
                         'dbam' => 0,            // db amt
                         'cram' => $camt,        // cr amt
                         'stat' => 1
                     );
                     $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);*/


                } else if ($chrgtp == 4) { // SERVICE CHRG

                    // MICRO LEDGE @1
                    $data_mclg1 = array(
                        'acid' => $lnid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'dsid' => 25,
                        'dcrp' => 'RECOV FOR SRV CHRG',
                        'schg' => -$rcamt,
                        'ream' => $rcamt,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);


                    /* // ACCOUNT LEDGE @1
                     $data_aclg23 = array(
                         'brno' => $lndt[0]->brco,   // BRANCH ID
                         'lnid' => $lnid,            // LOAN NO
                         'acdt' => date('Y-m-d H:i:s'),
                         'trtp' => 'SRV CHRG',
                         'trid' => 29,
                         'rfna' => $acno,
                         'dcrp' => 'SRV CHRG ADD ',

                         'acco' => 104,    // cross acc code
                         'spcd' => 108,    // split acc code
                         'acst' => '(108) Loan Stock',      //
                         'dbam' => $camt,    // db amt
                         'cram' => 0,        // cr amt
                         'stat' => 1
                     );
                     $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                     $data_aclg45 = array(
                         'brno' => $lndt[0]->brco,   // BRANCH ID
                         'lnid' => $lnid,            // LOAN NO
                         'acdt' => date('Y-m-d H:i:s'),
                         'trtp' => 'SRV CHRG',
                         'trid' => 29,
                         'rfna' => $acno,
                         'dcrp' => 'SRV CHRG ADD',

                         'acco' => 108,    // cross acc code
                         'spcd' => 104,    // split acc code
                         'acst' => '(104) Accounts Receivable',      //
                         'dbam' => 0,            // db amt
                         'cram' => $camt,        // cr amt
                         'stat' => 1
                     );
                     $result66 = $this->Generic_model->insertData('acc_leg', $data_aclg45);*/

                } else {

                }
            }
            // ADD CHARGE COMMENT
            $data_arr = array(
                'cmtp' => 2,
                'cmmd' => 1,
                'cmrf' => $lnid,
                'cmnt' => 'Add New Loan Charge : ' . $acno,
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('comments', $data_arr);


            $funcPerm = $this->Generic_model->getFuncPermision('loan_chrg');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Approval Charges (' . $auid . ')');

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

    // payment reject
    function rejCharg()
    {
        // data remove in voucher table
        $auid = $this->input->post('id');
        $data_ar1 = array(
            'stat' => 2,
            'tmby' => $_SESSION['userId'],
            'tmdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('oter_charges', $data_ar1, array('auid' => $auid));

        $funcPerm = $this->Generic_model->getFuncPermision('loan_chrg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Charges reject auid(' . $auid . ')');

        if (count($result1) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
// END OTHER PAYMENT
//
// DENOMINATION
    function denomi()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('denomi');
        $this->load->view('modules/user/denomination', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // CHECK TODAY ALREDY DENOMINATION
    function chkAlrdyDenomi()
    {
        $brn = $this->input->post('brn');
        $usr = $this->input->post('usr');
        $dndt = $this->input->post('dndt');

        $result = $this->Generic_model->getData('denm_details', '', "brco = '$brn' AND dnsr = '$usr' AND dndt = '$dndt' AND stat IN(0)  ");
        if (sizeof($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // TODAY COLLECTION
    function getTdyColl()
    {
        $brn = $this->input->post('brn');
        $usr = $this->input->post('usr');
        $dndt = $this->input->post('dndt');
        //$dndt = date('Y-m-d');
        //$dndt = '2018-08-01';

        $this->db->select("SUM(receipt.ramt) AS ttl, COUNT(*) AS nrp, micr_crt.ccnt, cen_mas.cnnm");
        $this->db->from("receipt");
        $this->db->join('micr_crt', 'micr_crt.lnid = receipt.rfno');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->where('receipt.retp', 2);
        $this->db->where("receipt.stat IN(1,2)");
        $this->db->where('receipt.brco', $brn);
        $this->db->where('receipt.crby', $usr);
        $this->db->where('receipt.dnid', 0);

        $this->db->where(" DATE_FORMAT(receipt.crdt, '%Y-%m-%d') = '$dndt' ");
        $this->db->group_by('micr_crt.ccnt');
        $query = $this->db->get();
        $data = $query->result();

        echo json_encode($data);
    }

    function srchDenomi()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('denomi');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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

        $disabled = "disabled";

        $result = $this->User_model->get_denomi();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->dnid;

            if ($row->stat == 0) {
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button'  onclick='printDenomi($auid);' class='btn btn-default btn-condensed'><i class='fa fa-print' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $viw data-toggle='modal' data-target='#modalEdit' onclick='edtDenomi($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button'  $rej  onclick='rejecDenomi($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } elseif ($row->stat == 1) {
                $stat = "<span class='label label-success'> Approval</span> ";
                $option = "<button type='button'  onclick='printDenomi($auid);' class='btn btn-default btn-condensed'><i class='fa fa-print' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled  data-toggle='modal' data-target='#modalEdit' onclick='edtDenomi($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled $rej onclick='rejecDenomi($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 2) {
                $stat = "<span class='label label-danger'> Reconsilation </span> ";
                $option = "<button type='button'  onclick='printDenomi($auid);' class='btn btn-default btn-condensed'><i class='fa fa-print' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdit' onclick='edtDenomi($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejecDenomi($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 3) {
                $stat = "<span class='label label-danger'> Reject </span> ";
                $option = "<button type='button' disabled onclick='printDenomi($auid);' class='btn btn-default btn-condensed'><i class='fa fa-print' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdit' onclick='edtDenomi($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejecDenomi($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->dnur; // name
            $sub_arr[] = $row->dndt;
            $sub_arr[] = $row->rfcd;
            $sub_arr[] = $row->nocn;
            $sub_arr[] = $row->norp;
            $sub_arr[] = number_format($row->dntt, 2, '.', ',');
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_denomi(),
            "recordsFiltered" => $this->User_model->count_filtered_denomi(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // ADD DENOMINATION
    function addDenomi()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $brn = $this->input->post('dnmBrn');
        $usr = $this->input->post('dnusr');
        $dndt = $this->input->post('dndt');
        //$dndt = date('Y-m-d');

        // GENERATE REFERENCE NO
        $date2 = date_create($dndt);
        $y = date_format($date2, "y"); // date('y');
        $m = date_format($date2, "m"); // date('m');
        $d = date_format($date2, "d"); // date('d');
        $u = strlen($usr);
        if ($u == 1) {
            $ur = '0' . $usr;
        } else if ($u == 2) {
            $ur = $usr;
        }
        $this->db->select("rfcd");
        $this->db->from("denm_details");
        $this->db->where('brco ', $brn);
        $this->db->where('dnsr ', $usr);
        $this->db->where('dndt ', $dndt);
        $this->db->order_by('dnid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();
        if (count($data) == '0') {
            $refno = $y . $m . $d . '-' . $ur . '-01';  // Ex 180824-03-01 --> (YY MM DD - USERID - DENOMINATION COUNT)

        } else {
            $ref = $data[0]->rfcd;
            $re = (explode("-", $ref));
            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '0' . $aa;
            } else if ($cc == 2) {
                $xx = $aa;
            }
            $refno = $y . $m . $d . '-' . $ur . '-' . $xx;
        }

        $data_arr = array(
            'brco' => $this->input->post('dnmBrn'),
            'dndt' => $this->input->post('dndt'),
            'rfcd' => $refno,
            'dnsr' => $this->input->post('dnusr'),
            'x5000' => $this->input->post('x5000'),
            'x2000' => $this->input->post('x2000'),
            'x1000' => $this->input->post('x1000'),
            'x500' => $this->input->post('x500'),
            'x100' => $this->input->post('x100'),
            'x50' => $this->input->post('x50'),
            'x20' => $this->input->post('x20'),
            'x10' => $this->input->post('x10'),
            'coin' => $this->input->post('coin'),
            'cott' => $this->input->post('coinTtl'),

            'dntt' => $this->input->post('ttldnm'),
            'nocn' => $this->input->post('nocn'),
            'norp' => $this->input->post('norp'),
            'cntt' => $this->input->post('ctl1'),

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('denm_details', $data_arr);

        // GET DENOMINATION ID
        $dendta = $this->Generic_model->getData('denm_details', array('dnid'), array('rfcd' => $refno));
        $dnid = $dendta[0]->dnid;

        // GET RECEIPTS ID
        $this->db->select("receipt.reid");
        $this->db->from("receipt");
        $this->db->where('receipt.retp', 2);
        $this->db->where("receipt.stat IN(1,2)");
        $this->db->where('receipt.brco', $brn);
        $this->db->where('receipt.crby', $usr);
        $this->db->where('receipt.dnid', 0);
        $this->db->where(" DATE_FORMAT(receipt.crdt, '%Y-%m-%d') = '$dndt' ");
        $query = $this->db->get();
        $data = $query->result();

        // UPDATE RECEIPTS
        $siz = sizeof($data);
        for ($a = 0; $a < $siz; $a++) {
            $result1 = $this->Generic_model->updateData('receipt', array('dnid' => $dnid), array('reid' => $data[$a]->reid));

        }

        $funcPerm = $this->Generic_model->getFuncPermision('denomi');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add Denomination');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function vewDnomin()
    {
        $auid = $this->input->post('auid');
        $this->db->select("denm_details.* ");
        $this->db->from("denm_details");
        $this->db->where('denm_details.dnid', $auid);

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function getTdyCollEdt()
    {
        $brn = $this->input->post('brn');
        $usr = $this->input->post('usr');
        $dndt = $this->input->post('dndt');
        $auid = $this->input->post('auid');
        //$dndt = date('Y-m-d');
        //$dndt = '2018-08-01';

        $this->db->select("SUM(receipt.ramt) AS ttl, COUNT(*) AS nrp, micr_crt.ccnt, cen_mas.cnnm");
        $this->db->from("receipt");
        $this->db->join('micr_crt', 'micr_crt.lnid = receipt.rfno');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->where('receipt.retp', 2);
        $this->db->where("receipt.stat IN(1,2)");
        $this->db->where('receipt.brco', $brn);
        $this->db->where('receipt.crby', $usr);
        $this->db->where("receipt.dnid IN(0,'$auid')");

        $this->db->where(" DATE_FORMAT(receipt.crdt, '%Y-%m-%d') = '$dndt' ");
        $this->db->group_by('micr_crt.ccnt');
        $query = $this->db->get();
        $data = $query->result();

        echo json_encode($data);
    }

    // edit denomination
    function edtDenomin()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $auid = $this->input->post('auid');
        $brn = $this->input->post('dnmBrnEdt');
        $usr = $this->input->post('dnusrEdt');
        $dndt = $this->input->post('dndtEdt');

        $data_arr = array(
            'brco' => $this->input->post('dnmBrnEdt'),
            'dndt' => $this->input->post('dndtEdt'),
            'dnsr' => $this->input->post('dnusrEdt'),
            'x5000' => $this->input->post('x5000Edt'),
            'x2000' => $this->input->post('x2000Edt'),
            'x1000' => $this->input->post('x1000Edt'),
            'x500' => $this->input->post('x500Edt'),
            'x100' => $this->input->post('x100Edt'),
            'x50' => $this->input->post('x50Edt'),
            'x20' => $this->input->post('x20Edt'),
            'x10' => $this->input->post('x10Edt'),
            'coin' => $this->input->post('coinEdt'),
            'cott' => $this->input->post('coinTtlEdt'),

            'dntt' => $this->input->post('ttldnmEdt'),
            'nocn' => $this->input->post('nocnEdt'),
            'norp' => $this->input->post('norpEdt'),
            'cntt' => $this->input->post('ctl1Edt'),

            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s'),
        );

        $where_arr = array(
            'dnid' => $auid
        );
        $result22 = $this->Generic_model->updateData('denm_details', $data_arr, $where_arr);


        // UPDATE RECEIPTS
        $this->db->select("receipt.reid");
        $this->db->from("receipt");
        $this->db->where('receipt.retp', 2);
        $this->db->where("receipt.stat IN(1,2)");
        $this->db->where('receipt.brco', $brn);
        $this->db->where('receipt.crby', $usr);
        $this->db->where("receipt.dnid IN(0,'$auid')");
        $this->db->where(" DATE_FORMAT(receipt.crdt, '%Y-%m-%d') = '$dndt' ");
        $query = $this->db->get();
        $data = $query->result();
        // UPDATE RECEIPTS
        $siz = sizeof($data);
        for ($a = 0; $a < $siz; $a++) {
            $result1 = $this->Generic_model->updateData('receipt', array('dnid' => $auid), array('reid' => $data[$a]->reid));

        }
        // END UPDATE RECEIPTS

        $funcPerm = $this->Generic_model->getFuncPermision('denomi');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Edit Denomination (' . $auid . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // denomination reject
    function rejDenomi()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $auid = $this->input->post('id');
        $data_ar1 = array(
            'stat' => 3,
        );
        $result1 = $this->Generic_model->updateData('denm_details', $data_ar1, array('dnid' => $auid));

        // UPDATE RECEIPTS
        $rcpdta = $this->Generic_model->getData('receipt', array('reid'), array('dnid' => $auid));
        $siz = sizeof($rcpdta);
        for ($a = 0; $a < $siz; $a++) {
            $this->Generic_model->updateData('receipt', array('dnid' => 0), array('reid' => $rcpdta[$a]->reid));
        }
        // END UPDATE RECEIPTS

        $funcPerm = $this->Generic_model->getFuncPermision('denomi');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Reject Denomination auid(' . $auid . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
// END DENOMINATION
//
// OFFICER DAYEND DENOMINATION
    function ofcr_dyend()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('ofcr_dyend');
        $this->load->view('modules/user/dayend_officer', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // TODAY COLLECTION
    function srchOfcrDenomi()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('ofcr_dyend');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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

        $disabled = "disabled";

        $result = $this->User_model->get_ofcrdyend();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {

            $dntt = number_format($row->dntt, 2, '.', '');
            $ttl = number_format($row->ttl, 2, '.', '');
            $stat = $row->stat;

            if ($stat == 0) {
                $hidden = "<input type='hidden'  name='auid[" . $i . "]' value='" . $row->dnid . "'>";
                if ($dntt == $ttl) { // IF CHECK DENOMINATION VALUE = SYSTEM TTL
                    $opt = "<label class=''><input type='checkbox' name='amt[" . $i . "]' id='amt[" . $i . "]'  class='icheckbox' /> </label>";
                } else {
                    $opt = "<label class=''><input type='checkbox' disabled name='amt[" . $i . "]' id='amt[" . $i . "]'  class='icheckbox' title='Value Not Match' /> </label>";
                }
            } elseif ($stat == 1 || $stat == 2) {
                $hidden = "<input type='hidden'  name='auid[" . $i . "]' value='" . $row->dnid . "'>";
                $opt = "<label class=''><input disabled type='checkbox' name='amt[" . $i . "]' id='amt[" . $i . "]'  class='icheckbox' checked='checked'/> </label>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->dnur; // name

            $sub_arr[] = $row->x5000;
            $sub_arr[] = $row->x2000;
            $sub_arr[] = $row->x1000;
            $sub_arr[] = $row->x500;
            $sub_arr[] = $row->x100;
            $sub_arr[] = $row->x50;
            $sub_arr[] = $row->x20;
            $sub_arr[] = $row->x10;

            $sub_arr[] = $row->nocn;
            $sub_arr[] = $row->norp;
            $sub_arr[] = $row->exe;
            $sub_arr[] = number_format($row->dntt, 2, '.', ',');
            $sub_arr[] = number_format($row->ttl, 2, '.', ','); // LIVE SYSTEM BALANCE

            $sub_arr[] = $opt . $hidden;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_ofcrdyend(),
            "recordsFiltered" => $this->User_model->count_filtered_ofcrdyend(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // ADD OFFICER DAY END
    function addOfcrDyend()
    {
        $len = $this->input->post("len");
        $siz = sizeof($this->input->post("amt[]"));
        $this->db->trans_begin(); // SQL TRANSACTION START
        $lpcnt = 0;
        for ($a = 0; $a < $len; $a++) {
            $amt = $this->input->post("amt[" . $a . "]");
            if ($amt == 'on') {
                $data_ar1 = array(
                    'stat' => 1,
                    'ckby' => $_SESSION['userId'],
                    'ckdt' => date('Y-m-d H:i:s'),
                );
                $result1 = $this->Generic_model->updateData('denm_details', $data_ar1, array('dnid' => $this->input->post("auid[" . $a . "]")));
                $lpcnt = $lpcnt + 1;
            } else {
            }
        }

        $funcPerm = $this->Generic_model->getFuncPermision('ofcr_dyend');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Officer denomination check');

        /*if ($lpcnt == $siz) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }*/
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

// END OFFICER DAYEND DENOMINATION
//
// DAY END RECONSILATION
    function end_recnci()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('end_recnci');
        $this->load->view('modules/user/dayend_reconsilation', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    // TODAY DATA   - STEP 0
    function getRcnciData()
    {
        $brn = $this->input->post('brn');
        $rcdt = $this->input->post('rcdt');

        $this->db->select("b.brnm, IFNULL(mc.dsln,0) AS dsln, IFNULL(mc2.dsntln,0) AS dsntln, IFNULL(p.ptmt,0) AS ptmt, gv.gvam ,
         IFNULL((SELECT SUM(d.cntt) AS dnmt FROM denm_details AS d WHERE  stat =1 AND d.rest = 0 AND DATE_FORMAT(d.dndt, '%Y-%m-%d') = '$rcdt' AND brco = b.brid),0) AS dnmt ");

        $this->db->from("brch_mas b");
        // DISBURSEMENT CHECK LOAN
        $this->db->join("(SELECT mc.brco, SUM(v.vuam) AS dsln 
         FROM micr_crt AS mc 
         JOIN voucher  v ON v.rfid = mc.lnid
         WHERE mc.cvpt=1 AND mc.ckby != 0 AND v.rest = 0 AND DATE_FORMAT(mc.cvdt, '%Y-%m-%d') = '$rcdt' AND v.stat = 2 AND v.mode= 1 ) AS mc", 'mc.brco = b.brid ', 'left');
        // DISBURESEMENT UNCHECK LOAN
        $this->db->join("(SELECT mc.brco, SUM(v.vuam) AS dsntln 
         FROM micr_crt AS mc 
         JOIN voucher  v ON v.rfid = mc.lnid
         WHERE mc.cvpt=1 AND mc.ckby = 0 AND v.rest = 0 AND DATE_FORMAT(mc.cvdt, '%Y-%m-%d') = '$rcdt' AND v.stat = 2 AND v.mode= 1 ) AS mc2", 'mc2.brco = b.brid ', 'left');

        $this->db->join("(SELECT brid, SUM(p.amut) AS ptmt 
         FROM pettycash_vou AS p WHERE stat IN(1) AND p.rest = 0 AND DATE_FORMAT(p.crdt, '%Y-%m-%d') = '$rcdt') AS p", 'p.brid = b.brid ', 'left');

        $this->db->join("(SELECT brco, SUM(gv.vuam) AS gvam 
         FROM voucher AS gv WHERE  stat =2 AND mode = 3 AND gv.rest = 0 AND DATE_FORMAT(gv.crdt, '%Y-%m-%d') = '$rcdt') AS gv", 'gv.brco = b.brid ', 'left');

        $this->db->where('b.brid', $brn);
        $query = $this->db->get();
        $data = $query->result();

        echo json_encode($data);
    }

    // GET DISBURS CHECK DETAILS - STEP 1
    function getPaidln()
    {
        $brn = $this->input->post('brn');
        $todt = $this->input->post('todt');

        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.noin,micr_crt.crdt,micr_crt.cvpt,micr_crt.agno,micr_crt.ckby, DATE_FORMAT(micr_crt.ckdt, '%Y-%m-%d') AS ckdt, DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') AS dsdt,
        cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg, cen_mas.cnnm ,brch_mas.brcd,prdt_typ.prtp,prdt_typ.pymd, product.prcd, IFNULL(CONCAT(user_mas.usnm),' - ') AS chkby ,
        voucher.vuam AS thnd, voucher.void "); /* IF(micr_crt.chmd = 2, (micr_crt.loam - micr_crt.docg - micr_crt.incg) , micr_crt.loam) AS thnd*/

        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.ckby', 'left');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('voucher', 'voucher.rfid = micr_crt.lnid');

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        $this->db->where('voucher.rest', 0);
        $this->db->where("micr_crt.ckby != 0");
        $this->db->where('micr_crt.stat', 5);
        $this->db->where("DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') = ", $todt);

        $query = $this->db->get();
        $result = $query->result();
        $row = $query->num_rows();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $hidden = "<input type='hidden'  name='ckid[" . $i . "]' value='" . $row->void . "'>";
            $option = "<label class=''><input type='checkbox' name='chck[" . $i . "]' value='1' id='checkbox-1'  class='icheckbox' /> </label>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' | ' . $row->cnnm;
            $sub_arr[] = $row->init; // cust name
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($row->loam, 2, '.', ',');
            $sub_arr[] = number_format($row->thnd, 2, '.', ',');
            $sub_arr[] = $row->chkby;
            $sub_arr[] = $row->ckdt;
            $sub_arr[] = $option . $hidden;
            $data[] = $sub_arr;
        }

        $output = array(
            //"draw" => $_POST['draw'],
            "recordsTotal" => $row,
            "recordsFiltered" => $row,
            "data" => $data,
        );
        echo json_encode($output);
    }

    // GET DISBURS UNCHECK DETAILS - STEP 2
    function getUnpaidln()
    {
        $brn = $this->input->post('brn');
        $todt = $this->input->post('todt');

        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.noin,micr_crt.crdt,micr_crt.cvpt,micr_crt.agno,micr_crt.ckby, DATE_FORMAT(micr_crt.ckdt, '%Y-%m-%d') AS ckdt, DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') AS dsdt,
        cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg, cen_mas.cnnm, product.prcd ,brch_mas.brcd,prdt_typ.prtp,prdt_typ.pymd, IFNULL(CONCAT(user_mas.usnm),' - ') AS dsby,
        voucher.vuam AS thnd, voucher.void");

        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('voucher', 'voucher.rfid = micr_crt.lnid');
        $this->db->join('user_mas', 'user_mas.auid = voucher.crby', 'left');
        $this->db->join('product', 'product.auid = micr_crt.prid');

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        $this->db->where('voucher.rest', 0);
        $this->db->where("micr_crt.ckby", 0);
        $this->db->where('micr_crt.stat', 5);
        $this->db->where("DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') = '$todt'");

        $query = $this->db->get();
        $result = $query->result();
        $row = $query->num_rows();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $hidden = "<input type='hidden'  name='uckid[" . $i . "]' value='" . $row->void . "'>";
            $option = "<label class=''><input type='checkbox' name='unchck[" . $i . "]' value='1' id='checkbox-1' class='icheckbox' /> </label>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' | ' . $row->cnnm;
            $sub_arr[] = $row->init; // cust name
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($row->loam, 2, '.', ',');
            $sub_arr[] = number_format($row->thnd, 2, '.', ',');
            $sub_arr[] = $row->dsby;
            $sub_arr[] = $row->dsdt;
            $sub_arr[] = $option . $hidden;
            $data[] = $sub_arr;
        }

        $output = array(
            "recordsTotal" => $row,
            "recordsFiltered" => $row,
            "data" => $data,
        );
        echo json_encode($output);
    }

    // SEARCH DENOMINATION SUMMERY - STEP 3
    function srchOfzerdnmi()
    {
        $brn = $this->input->post('brn');
        $dte = $this->input->post('dte');

        $this->db->select("denm_details.*, brch_mas.brnm, (SELECT usnm FROM user_mas WHERE auid = dnsr) AS dnur ,   CONCAT(user_mas.usnm) AS exe ");
        $this->db->from("denm_details");
        $this->db->join('brch_mas', 'brch_mas.brid = denm_details.brco');
        $this->db->join('user_mas', 'user_mas.auid = denm_details.crby');

        $this->db->where('denm_details.dndt', $dte);
        $this->db->where('denm_details.rest', 0);
        $this->db->where("denm_details.stat != 3");
        if ($brn != 'all') {
            $this->db->where('denm_details.brco', $brn);
        }
        $query = $this->db->get();
        $result = $query->result();
        $row = $query->num_rows();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $hidden = "<input type='hidden'  name='dnid[" . $i . "]' value='" . $row->dnid . "'>";
            $opt = "<label class=''><input type='checkbox' name='dnmck[" . $i . "]' id='dnmck[" . $i . "]' value='1' class='icheckbox' /> </label>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->dnur;
            $sub_arr[] = $row->nocn;
            $sub_arr[] = $row->norp;
            $sub_arr[] = $row->exe;
            $sub_arr[] = number_format($row->dntt, 2, '.', ',');
            $sub_arr[] = number_format($row->cntt, 2, '.', ',');

            $sub_arr[] = $opt . $hidden;
            $data[] = $sub_arr;
        }

        $output = array(
            "recordsTotal" => $row,
            "recordsFiltered" => $row,
            "data" => $data,
        );
        echo json_encode($output);
    }

    // SEARCH GENERAL VOUCHER - STEP 4
    function getGenvouc()
    {
        $brn = $this->input->post('brn');
        $todt = $this->input->post('todt');

        $this->db->select("voucher.*,DATE_FORMAT(voucher.crdt, '%Y-%m-%d') AS vcrdt,  brch_mas.brnm ,pay_terms.tem_name,chq_issu.cpnt,chq_issu.stat AS chst   ");
        $this->db->from("voucher");
        $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void');
        $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp');
        $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco');
        $this->db->join('chq_issu', 'chq_issu.vuid = voucher.void', 'left');
        $this->db->group_by('vuno');
        $this->db->where("DATE_FORMAT(voucher.crdt, '%Y-%m-%d') = '$todt'");

        if ($brn != 'all') {
            $this->db->where('voucher.brco', $brn);
        }
        $this->db->where('voucher.mode', 3);
        $this->db->where('voucher.rest', 0);
        $this->db->where('voucher.pmtp', 8);
        $this->db->where('voucher.mode != 4');
        $this->db->where('voucher.stat IN(0,1,2)');
        $query = $this->db->get();
        $result = $query->result();
        $row = $query->num_rows();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            if ($row->mode == 1) {          // Credit voucher
                $md = "<span class='label label-default' title='Credit Voucher'>CREDIT</span>";

            } elseif ($row->mode == 2) {    // incash group voucher
                $md = "<span class='label label-default' title='Incash Voucher'>IN CASH</span>";

            } else if ($row->mode == 3) {   // general voucher
                $md = "<span class='label label-default' title='General Voucher'>GENERAL</span>";

            } else if ($row->mode == 4) {   // gift voucher
                $md = "<span class='label label-default' title='General Voucher'>GIFT</span>";
            }
            $hidden = "<input type='hidden'  name='gvid[" . $i . "]' value='" . $row->void . "'>";
            $opt = "<label class=''><input type='checkbox' name='gnvu[" . $i . "]' id='gnvu[" . $i . "]' value='1' class='icheckbox' /> </label>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->vcrdt;
            $sub_arr[] = $row->vuno;
            $sub_arr[] = $row->pynm; // cust name
            $sub_arr[] = $md;
            $sub_arr[] = $row->tem_name;
            $sub_arr[] = number_format($row->vuam, 2, '.', ',');
            $sub_arr[] = $opt . $hidden;
            $data[] = $sub_arr;
        }

        $output = array(
            "recordsTotal" => $row,
            "recordsFiltered" => $row,
            "data" => $data,
        );
        echo json_encode($output);

    }

    // TODAY PETTY CASH  - STEP 5
    function getPtycshtoday()
    {
        $brn = $this->input->post('brn');
        $todt = $this->input->post('todt');

        $this->db->select("pettycash_vou.*,brch_mas.brcd,  aa.rqusr, bb.crusr, accu_chrt.hadr");
        $this->db->from("pettycash_vou");
        $this->db->join('brch_mas', 'brch_mas.brid = pettycash_vou.brid ');
        $this->db->join('accu_chrt', 'accu_chrt.auid = pettycash_vou.pyac', 'left');
        $this->db->join("(SELECT auid,usnm  AS rqusr FROM `user_mas` )AS aa ", 'aa.auid = pettycash_vou.usrid', 'left'); // request user
        $this->db->join("(SELECT auid,usnm  AS crusr FROM `user_mas` )AS bb ", 'bb.auid = pettycash_vou.crby', 'left'); // crete user

        if ($brn != 'all') {
            $this->db->where('pettycash_vou.brid', $brn);
        }
        $this->db->where('pettycash_vou.stat', 1);
        $this->db->where('pettycash_vou.rest', 0);
        $this->db->where("DATE_FORMAT(pettycash_vou.apdt, '%Y-%m-%d') = '$todt'");

        $query = $this->db->get();
        $result = $query->result();
        $row = $query->num_rows();
        $data = array();
        $i = 0;

        foreach ($result as $row) {
            $hid = "<input type='hidden'  name='ptid[" . $i . "]' value='" . $row->ptid . "'>";
            $opt = "<label class=''><input type='checkbox' name='ptvu[" . $i . "]' id='ptvu[" . $i . "]' value='1' class='icheckbox' /> </label>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->rqusr;
            $sub_arr[] = $row->hadr;

            $sub_arr[] = $row->pydt;
            $sub_arr[] = number_format($row->amut, 2);
            $sub_arr[] = $row->crusr;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $opt . $hid;
            $data[] = $sub_arr;
        }
        $output = array(
            "recordsTotal" => $row,
            "recordsFiltered" => $row,
            "data" => $data,
        );
        echo json_encode($output);
    }

    // ADD BRANCH RECONCILIATION
    function addBrnchReconsi()
    {
        $func = $this->input->post('func'); // IF 1 update
        $id = $this->input->post('auid');

        $this->db->trans_begin();
        $data_arr = array(
            'brid' => $this->input->post('rncBrn'),
            'date' => $this->input->post('rcdt'),
            'dsln' => $this->input->post('dsln'),
            'drln' => $this->input->post('drln'),
            'tdnm' => $this->input->post('tdnm'),
            'gnvu' => $this->input->post('ttgv'),
            'ptch' => $this->input->post('ptch'),

            /*'x5000' => $this->input->post('x5000'),
            'x2000' => $this->input->post('x2000'),
            'x1000' => $this->input->post('x1000'),
            'x500' => $this->input->post('x500'),
            'x100' => $this->input->post('x100'),
            'x50' => $this->input->post('x50'),
            'x20' => $this->input->post('x20'),
            'x10' => $this->input->post('x10'),
            'coin' => $this->input->post('coin'),
            'covl' => $this->input->post('coinTtl'),*/

            'rttl' => $this->input->post('cttl'),
            'remk' => $this->input->post('remk'),

            'stat' => 1,
            'prby' => $_SESSION['userId'],
            'prdt' => date('Y-m-d H:i:s'),
        );
        if ($func != 1) {     // INSERT
            $result = $this->Generic_model->insertData('dayend_process', $data_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('end_recnci');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Today Reconciliations Add');
        } else {              // UPDATE
            $result = $this->Generic_model->updateData('dayend_process', $data_arr, array('rcid' => $id));

            $funcPerm = $this->Generic_model->getFuncPermision('end_recnci');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, $this->input->post('rcdt') . ' Reconciliations Update');
        }

        //DISBURS LOAN RECONSI
        $len1 = $this->input->post("len_pln");
        $siz1 = sizeof($this->input->post("chck[]"));
        $lct1 = 0;
        for ($a = 0; $a < $len1; $a++) {
            $amt = $this->input->post("chck[" . $a . "]");
            if ($amt == 1) {
                $this->Generic_model->updateData('voucher', array('rest' => 1), array('void' => $this->input->post("ckid[" . $a . "]")));
                $lct1 = $lct1 + 1;
            }
        }
        //DISBURS RTN LOAN RECONSI
        $len2 = $this->input->post("len_upln");
        $siz2 = sizeof($this->input->post("unchck[]"));
        $lct2 = 0;
        for ($a = 0; $a < $len2; $a++) {
            $amt = $this->input->post("unchck[" . $a . "]");
            if ($amt == 1) {
                $this->Generic_model->updateData('voucher', array('rest' => 1), array('void' => $this->input->post("uckid[" . $a . "]")));
                $lct2 = $lct2 + 1;
            }
        }

        // DENOMILATION RECANSI
        $len3 = $this->input->post("len_dnm");
        $siz3 = sizeof($this->input->post("dnmck[]"));
        $lcnt3 = 0;
        for ($a = 0; $a < $len3; $a++) {
            $amt = $this->input->post("dnmck[" . $a . "]");
            if ($amt == 1) {
                $this->Generic_model->updateData('denm_details', array('rest' => 1), array('dnid' => $this->input->post("dnid[" . $a . "]")));
                $lcnt3 = $lcnt3 + 1;
            }
        }
        // GENERAL VOUCHER RECANSI
        $len4 = $this->input->post("len_gnv");
        $siz4 = sizeof($this->input->post("gnvu[]"));
        $lcnt4 = 0;
        for ($a = 0; $a < $len3; $a++) {
            $amt = $this->input->post("gnvu[" . $a . "]");
            if ($amt == 1) {
                $this->Generic_model->updateData('voucher', array('rest' => 1), array('void' => $this->input->post("gvid[" . $a . "]")));
                $lcnt4 = $lcnt4 + 1;
            }
        }

        // PETTYCASH RECANSI
        $len5 = $this->input->post("len_ptc");
        $siz5 = sizeof($this->input->post("ptvu[]"));
        $lcnt5 = 0;
        for ($a = 0; $a < $len5; $a++) {
            $amt = $this->input->post("ptvu[" . $a . "]");
            if ($amt == 1) {
                $this->Generic_model->updateData('pettycash_vou', array('rest' => 1), array('ptid' => $this->input->post("ptid[" . $a . "]")));
                $lcnt5 = $lcnt5 + 1;
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit();
            echo json_encode(true);
        }
    }

    // SEARCH RECONSILITATION
    function srchReconsiltion()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('end_recnci');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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

        $disabled = "disabled";

        $result = $this->User_model->get_reconsilation();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->rcid;

            if ($row->stat == 0) {
                $stat = "<span class='label label-warning'> Not Process </span> ";
                $option = "<button type='button' id='edt' $viw data-toggle='modal' onclick='oldReconsi($auid);' class='btn btn-default btn-condensed' title='Edit'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button> ";

            } elseif ($row->stat == 1) {
                $stat = "<span class='label label-success'> Process</span> ";
                $option = "<button type='button' id='edt' data-toggle='modal' data-target='#modalEdit' onclick='viewReconsi($auid);' class='btn btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->date;
            $sub_arr[] = number_format($row->rttl, 2, '.', ',');
            $sub_arr[] = $stat;
            $sub_arr[] = $row->prdt;
            $sub_arr[] = $row->exe;
            //$sub_arr[] = number_format($row->rttl, 2, '.', ',');
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_reconsi(),
            "recordsFiltered" => $this->User_model->count_filtered_reconsi(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // OLD RECONSILATION LOAD
    function getReconsidata()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('dayend_process', array('rcid', 'brid', 'date'), array('rcid' => $auid));
        echo json_encode($result);
    }

    // CHECK TODAY RECONCILATION
    function chkAlrdyReconsi()
    {
        $brn = $this->input->post('brn');
        $todt = $this->input->post('todt');

        $result = $this->Generic_model->getData('dayend_process', '', array('brid' => $brn, 'date' => $todt, 'stat' => 1));
        if (sizeof($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
// END DAY END RECONSILATION
//
// LOAN DUAL APPROVAL
    function dual_apprv()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $data['policy'] = $this->Generic_model->getData('sys_policy', array('ponm,pov1,pov2,post'), array('popg' => 'loan', 'stat' => 1));
        $data['policyinfo'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2', 'pov3'), array('popg' => 'product', 'stat' => 1));

        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['stainfo'] = $this->Generic_model->getData('loan_stat', array('stid,stnm'), array('isac' => 1), '');
        $data['prductinfo'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 1), '');
        $data['dynamicprd'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 2), '');

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('dual_apprv');
        $this->load->view('modules/user/loan_dual_approval', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function getDualApprvl()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('dual_apprv');

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
        $disabled = "disabled";


        $result = $this->User_model->get_dualLoan();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->apst;
            $auid = $row->lnid;

            // CHECK APPROVAL DATE > TODAY - 7 DAYS
            $apdt = $row->apdt;
            $cc = date('Y-m-d', strtotime('-7 days'));
            if ($apdt < $cc) {
                $dt = "disabled";
            } else {
                $dt = "";
            }
            // IF CHECK PRODUCT LOAN OR DYNAMIC LOAN
            if ($row->lntp == 1) {
                $lntp = "<span class='label label-success' title='Product Loan'>PRD</span>";
            } elseif ($row->lntp == 2) {
                $lntp = "<span class='label label-warning' title='Dynamic Loan'>DYN</span>";
            } elseif ($row->lntp == 3) {
                $lntp = "<span class='label label-success' title='INT Free Loan'>INF</span>";
            } elseif ($row->lntp == 4) {
                $lntp = "<span class='label label-warning' title='DP Loan'>DWP</span>";
            } else {
                $lntp = "<span class='label label-warning' title='--'>-</span>";
            }
            // IF CHECK TOPUP LOAN OR
            if ($row->prva != 0) {
                $tpup = "<span class='label label-info' title='Topup Loan'>T</span>";
                $tpds = "disabled";
            } else {
                $tpup = "";
                $tpds = "";
            }

            if ($st == '0') {  // Pending
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app $tpds data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $rej $tpds onclick='rejecLoan($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '1') {  // Approved
                $stat = "<span class='label label-success'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $dt $tpds onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = "<span class='label label-danger'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLoan(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLoan(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $disabled onclick='rejecLoan();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '5') {  // Disbursed
                $stat = "<span class='label label-success' style='background-color: #66ff33'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $disabled  onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else {  // Others
                $stat = "<span class='label label-default'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $disabled  onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $lntp . ' ' . $row->acno . ' ' . $tpup;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = $row->lnpr . ' ' . $row->pymd;

            $sub_arr[] = $stat;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_filtered_dualLoan(),
            "recordsFiltered" => $this->User_model->count_filtered_dualLoan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // DUAL APPROVAL LOAN REJECT
    function rejDualAppLoan()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('micr_crt', array('stat' => 4), array('lnid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('loan');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan reject id(' . $id . ')');

        $data_arr = array(
            'cmtp' => 2,
            'cmmd' => 1,
            'cmrf' => $id,
            'cmnt' => 'Dual Approval Loan Rejected By: ' . $_SESSION['username'],
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('comments', $data_arr);


        // DUAL APPROVEL TB UPDATE
        $data_ar2 = array(
            'stat' => 2,
            'trby' => $_SESSION['userId'],
            'trdt' => date('Y-m-d H:i:s'),
        );
        $where_arr2 = array(
            'lnid' => $id,
            'stat' => 0,
        );
        $this->Generic_model->updateData('dual_approval', $data_ar2, $where_arr2);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function apprvlDual()
    {
        $func = $this->input->post('func');     // if update=1 or approval=2
        $lntp = $this->input->post('lontype');  // if 1 product loan 2 dynamic loan
        $auid = $this->input->post('lnauid');   // loan auto id
        $chk = 0;

        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($lntp == 1) { // product loan
            $prid = $this->input->post('duraEdt');
            $prd_dtls = $this->Generic_model->getData('product', array('lamt', 'inta', 'rent', 'nofr', 'inra', 'prmd', 'pncd'), array('auid' => $prid));

            $prdtp = $this->input->post('prdTypEdt');
            $loam = $this->input->post('fcamtEdt');
            $inta = $prd_dtls[0]->inta;
            $inra = $prd_dtls[0]->inra;
            $lnpr = $prd_dtls[0]->nofr;
            $noin = $prd_dtls[0]->nofr;
            $inam = $prd_dtls[0]->rent;
            $lcat = 0;
            $prmd = $prd_dtls[0]->prmd;
            $pncd = $prd_dtls[0]->pncd;

        } else { // dynamic loan
            $prdtp = $this->input->post('prdtpDynEdt');
            $inra = $this->input->post('dyn_inrtEdt');
            $lnpr = $this->input->post('dyn_duraEdt');
            $loam = $this->input->post('dyn_fcamtEdt');
            $inta = $this->input->post('dyn_ttlintEdt');

            $lcat = $this->input->post('dytpEdt');
            $inam = $this->input->post('lnprimEdt');

            $prmd = 1;

            if ($prdtp == 6) { // DYNAMIC DAILY
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'prmd', 'pncd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'cldw' => $lcat, 'stat' => 1));
                $prid = $prdid[0]->auid;
                $noin = $prdid[0]->infm;
                $pncd = $prdid[0]->pncd;

            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'prtp', 'inra', 'nofr', 'infm', 'pncd'),
                    array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $lnpr, 'stat' => 1));
                $prid = $prdid[0]->auid;
                $pncd = $prdid[0]->pncd;

                $noin = $this->input->post('dyn_duraEdt');
                $inam = $this->input->post('lnprimEdt');
            }
        }

        //MATURITY DATE AND NEXT RENTEL DATE
        /* http://snipplr.com/view/10958/ */
        $indt = $this->input->post('indtEdt');
        $date = date("Y-m-d");
        $nxdd = date("Y-m-d");

        if ($prdtp == 3 || $prdtp == 6) {         // DL

            $holidayDates = $this->Generic_model->getData('sys_holdys', array('date'), array('stat' => 1, 'hdtp' => 1));
            $holidayDates = array_column($holidayDates, 'date');
            $count5WD = 0;
            // $temp = strtotime("2018-04-18 00:00:00"); //example as today is 2016-03-25
            /* Example link  --> https://stackoverflow.com/questions/36196606/php-add-5-working-days-to-current-date-excluding-weekends-sat-sun-and-excludin  */
            $temp = strtotime(date("Y-m-d"));

            while ($count5WD < $lnpr) {
                $next1WD = strtotime('+1 weekday', $temp);
                $next1WDDate = date('Y-m-d', $next1WD);
                if (!in_array($next1WDDate, $holidayDates)) {
                    $count5WD++;
                }
                $temp = $next1WD;
            }
            $next5WD = date("Y-m-d", $temp);
            $madt = $next5WD;

            $count5WD2 = 0;
            $temp2 = strtotime(date("Y-m-d"));
            while ($count5WD2 < 1) {
                $next1WD2 = strtotime('+1 weekday', $temp2);
                $next1WDDate2 = date('Y-m-d', $next1WD2);
                if (!in_array($next1WDDate2, $holidayDates)) {
                    $count5WD2++;
                }
                $temp2 = $next1WD2;
            }
            $next5WD2 = date("Y-m-d", $temp2);
            $nxdd_n = $next5WD2;
            // var_dump($madt . '***'. $nxdd);
            // die();

        } else if ($prdtp == 4 || $prdtp == 7) {   //WK
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $lnpr . "week");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 week");
            $nxdd_n = date("Y-m-d", $nxdd);

        } else if ($prdtp == 5 || $prdtp == 8) {   //ML
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $lnpr . "month");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 month");
            $nxdd_n = date("Y-m-d", $nxdd);
        }
        // END MATURITY DATE

        // GET BRANCH CODE GP/NT
        $brco = $this->input->post('coll_brnEdt');
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat', 'duap', 'apmt'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $cent = $this->input->post('coll_cenEdt');
        $cnno = $this->Generic_model->getData('cen_mas', array('caid', 'cnno', 'stat'), array('caid' => $cent, 'stat' => 1));
        $cncd = $cnno[0]->cnno;

        // GET PRODUCT CODE
        $prt = $this->Generic_model->getData('product', array('prcd', 'pnst', 'clrt'), array('auid' => $prid, 'stat' => 1));
        $prcd = $prt[0]->prcd;
        $clrt = $prt[0]->clrt;

        // GET LAST LOAN NO
        $this->db->select("brco,acno,ccnt,prdtp,prid");
        $this->db->from("micr_crt");
        $this->db->where('micr_crt.brco ', $brco);
        $this->db->where('micr_crt.ccnt ', $cent);
        //$this->db->where('micr_crt.stat ', 2);

        if ($lntp == 1) {  //1 product loan 2 dynamic loan
            $this->db->where('micr_crt.prid ', $prid);
        } else {
            $this->db->where('micr_crt.prdtp ', $prdtp);
        }
        //$this->db->where('micr_crt.stat IN(2,3,5) ');
        $this->db->where('micr_crt.stat NOT IN (1) ');
        $this->db->order_by('micr_crt.apdt', 'desc');

        $this->db->limit(10);
        $query = $this->db->get();
        $data = $query->result();

        // GENARATE NEXT LOAN NO
        if (count($data) == '0') {
            $aa = '0001';
        } else {
            // IF VALIDE ACNO CHECK         *** CODE UPDATE 18/09/03 ***
            for ($a = 0; $a < 10; $a++) {
                if (strlen($data[$a]->acno) == 19) {
                    $acno = $data[$a]->acno;
                    break;
                } else {
                    $a = $a + 1;
                }
            }
            //$acno = $data[0]->acno;
            $re = (explode("/", $acno));
            $aa = intval($re[4]) + 1;
        }

        $cc = strlen($aa);
        // next loan no
        if ($cc == 1) {
            $xx = '000' . $aa;
        } else if ($cc == 2) {
            $xx = '00' . $aa;
        } else if ($cc == 3) {
            $xx = '0' . $aa;
        } else if ($cc == 4) {
            $xx = '' . $aa;
        }

        // center no
        $mm = strlen($cncd);
        if ($mm == 1) {
            $gg = '000' . $cncd;
        } else if ($mm == 2) {
            $gg = '00' . $cncd;
        } else if ($mm == 3) {
            $gg = '0' . $cncd;
        } else if ($mm == 4) {
            $gg = '' . $cncd;
        }
        $yr = date('y');
        $acno = $brcd . '/' . $prcd . '/' . $yr . '/' . $gg . '/' . $xx;
        // END LOAN NO GENARATE

        // MICRO CART TB UPDATE
        $data_ar1 = array(
            'clct' => $this->input->post('coll_ofcEdt'),
            'ccnt' => $this->input->post('coll_cenEdt'),
            'acno' => $acno,
            'prdtp' => $prdtp,
            'prid' => $prid,
            'apid' => $this->input->post('appidEdt'),
            'fsgi' => $this->input->post('fsgiEdt'),
            'segi' => $this->input->post('segiEdt'),
            'thgi' => $this->input->post('thgiEdt'),
            'fogi' => $this->input->post('fogiEdt'),
            'figi' => $this->input->post('figiEdt'),
            'loam' => $loam,
            'inta' => $inta,
            'inra' => $inra,
            'lnpr' => $lnpr,
            'noin' => $noin,
            'lcat' => $lcat,
            'inam' => $inam,
            'docg' => $this->input->post('docuEdt'),
            'incg' => $this->input->post('insuEdt'),
            'chmd' => $this->input->post('crgmdEdt'), // charge mode
            'indt' => $this->input->post('indtEdt'),
            'acdt' => $this->input->post('dsdtEdt'),

            'pnco' => $pncd,
            'madt' => $madt,
            'nxdd' => $nxdd_n,
            'durg' => $noin,
            'boc' => $loam,
            'boi' => $inta,
            'nxpn' => 1,
            'prtp' => $prmd,
            'pnra' => $clrt, // PANALTY CAL RATE

            'stat' => 2,
            'pncs' => $prt[0]->pnst,
            'pcid' => 0,

            //'rmks' => $this->input->post('remkEdt'),
            //'apby' => $_SESSION['userId'],
            //'apdt' => date('Y-m-d H:i:s'),
        );
        $where_arr = array(
            'lnid' => $auid
        );
        $result_micrt = $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);

        // IF NEW LOAN COMMENT ADD
        $cmt = $this->input->post('remkNew');
        if (!empty($cmt)) {
            $data_arr = array(
                'cmtp' => 2,
                'cmmd' => 1,
                'cmrf' => $auid,
                'cmnt' => $cmt,
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('comments', $data_arr);
        }
        // END LOAN COMMENT

        // LEDGER RECODE
        $cchmd = $this->input->post('crgmdEdt');
        $docg = $this->input->post('docuEdt');
        $incg = $this->input->post('insuEdt');

        // MICRO LEDGE @1
        $data_mclg1 = array(
            'acid' => $auid, // LOAN ID
            'acno' => $acno, // LOAN NO
            'ledt' => date('Y-m-d H:i:s'),
            'dsid' => 8,
            'dcrp' => 'ACNT DIFN',
            'avcp' => $loam,
            'avin' => $inta,

            'schg' => $docg + $incg,
            'duam' => $docg + $incg,
            'stat' => 1
        );
        $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

        // ACCOUNT LEDGE
        $data_aclg1 = array(
            'brno' => $brco, // BRANCH ID
            'lnid' => $auid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'ACNT DIFN',
            'trid' => 8,
            'rfna' => $acno,
            'dcrp' => 'ACNT DIFN',
            'acco' => '111',    // cross acc code
            'spcd' => '108',    // split acc code
            'acst' => '(108) Loan Stock',
            'dbam' => $loam,
            'cram' => 0,
            'stat' => 0
        );
        $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);

        $data_aclg2 = array(
            'brno' => $brco, // BRANCH ID
            'lnid' => $auid, // LOAN NO
            'acdt' => date('Y-m-d H:i:s'),
            'trtp' => 'ACNT DIFN',
            'trid' => 8,
            'rfna' => $acno,
            'dcrp' => $acno,
            'acco' => '108',    // cross acc code
            'spcd' => '111',    // split acc code
            'acst' => '(111) Loan Controller',
            'dbam' => 0,
            'cram' => $loam,
            'stat' => 0
        );
        $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);

        if ($cchmd == 1) {        // CHARGE PAY BY CUSTOMER
            $chk = $chk + 4;

        } else if ($cchmd == 2) {  // CHARGE RECOVER FOR LOAN

            if ($docg > 0) {
                $data_aclg23 = array(
                    'brno' => $brco, // BRANCH ID
                    'lnid' => $auid, // LOAN NO
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'ACNT DIFN',
                    'trid' => 8,
                    'rfna' => $acno,
                    'dcrp' => 'ACNT DIFN',

                    'acco' => 111,    // cross acc code
                    'spcd' => 404,    // split acc code
                    'acst' => '(404) Document Charge',      //
                    'dbam' => 0,      // db amt
                    'cram' => $docg,      // cr amt
                    'stat' => 0
                );
                $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                $data_aclg45 = array(
                    'brno' => $brco, // BRANCH ID
                    'lnid' => $auid, // LOAN NO
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'ACNT DIFN',
                    'trid' => 8,
                    'rfna' => $acno,
                    'dcrp' => 'ACNT DIFN',

                    'acco' => 404,    // cross acc code
                    'spcd' => 111,    // split acc code
                    'acst' => '(111) Loan Controller',      //
                    'dbam' => $docg,      // db amt
                    'cram' => 0,      // cr amt
                    'stat' => 0
                );
                $result77 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
            }

            if ($incg > 0) {
                $data_aclg23 = array(
                    'brno' => $brco, // BRANCH ID
                    'lnid' => $auid, // LOAN NO
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'ACNT DIFN',
                    'trid' => 8,
                    'rfna' => $acno,
                    'dcrp' => 'ACNT DIFN',

                    'acco' => 111,    // cross acc code
                    'spcd' => 403,    // split acc code
                    'acst' => '(403) Insurance Charge',      //
                    'dbam' => 0,      // db amt
                    'cram' => $incg,      // cr amt
                    'stat' => 0
                );
                $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                $data_aclg45 = array(
                    'brno' => $brco, // BRANCH ID
                    'lnid' => $auid, // LOAN NO
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'ACNT DIFN',
                    'trid' => 8,
                    'rfna' => $acno,
                    'dcrp' => 'ACNT DIFN',

                    'acco' => 403,    // cross acc code
                    'spcd' => 111,    // split acc code
                    'acst' => '(111) Loan Controller',      //
                    'dbam' => $incg,      // db amt
                    'cram' => 0,      // cr amt
                    'stat' => 0
                );
                $result88 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
            }
        }
        // END ACCOUNT LEDGE

        // RECEIPTS PROCESS
        $brn = $brco;
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $this->db->select("reno");
        $this->db->from("receipt");
        $this->db->where('receipt.brco ', $brn);
        $this->db->where('receipt.retp ', 1);
        $this->db->order_by('receipt.reid', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $reno = $brcd . '/GR/' . $yr . '/00001';
        } else {
            $reno = $data[0]->reno;
            $re = (explode("/", $reno));
            $aa = intval($re[3]) + 1;

            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '' . $aa;
            }

            $reno = $brcd . '/GR/' . $yr . '/' . $xx;
        }

        // INSERT GENERAL RECEIPTS
        if ($cchmd == 1) {        // CHARGE PAY BY CUSTOMER
            $chk = $chk + 5;
            // customer payed process chang to edtPymnt() approval function
        } else if ($cchmd == 2) {  // CHARGE RECOVER FOR LOAN
            $data_arr = array(
                'brco' => $brn,
                'reno' => $reno,
                'rfno' => $auid, // loan id
                'retp' => 1,
                'ramt' => $docg + $incg,
                'pyac' => 111,
                'pymd' => 9, // 8 -cash / 9 - inter account trnsfer
                //'clid' => $this->input->post('appidEdt'), // cust id
                'stat' => 1,
                'remd' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('receipt', $data_arr);

            $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
            $reid = $recdt[0]->reid;

            if ($docg > 0) {

                $data_arr22 = array(
                    'reno' => $reno,
                    'reid' => $reid, // recpt id
                    'rfco' => 404,
                    'rfdc' => 'Document Charges',
                    'rfdt' => date('Y-m-d'),
                    'amut' => $docg
                );
                $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
            }

            if ($incg > 0) {
                $data_arr22 = array(
                    'reno' => $reno,
                    'reid' => $reid, // recpt id
                    'rfco' => 403,
                    'rfdc' => 'Insurance Charges',
                    'rfdt' => date('Y-m-d'),
                    'amut' => $incg
                );
                $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
            }

            // MICRO LEDGE @2
            if ($docg > 0) {
                $data_mclg1 = array(
                    'acid' => $auid, // LOAN ID
                    'acno' => $acno, // LOAN NO
                    'ledt' => date('Y-m-d H:i:s'),
                    'reno' => $reno,
                    'reid' => $reid,
                    'dsid' => 1,
                    'dcrp' => 'DOC CHG RECOV FOR ACC',
                    'schg' => -$docg,
                    'ream' => $docg,
                    'stat' => 1
                );
                $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

            }

            if ($incg > 0) {
                $data_mclg1 = array(
                    'acid' => $auid, // LOAN ID
                    'acno' => $acno, // LOAN NO
                    'ledt' => date('Y-m-d H:i:s'),
                    'reno' => $reno,
                    'reid' => $reid,
                    'dsid' => 1,
                    'dcrp' => 'INS CHG RECOV FOR ACC',
                    'schg' => -$incg,
                    'ream' => $incg,
                    'stat' => 1
                );
                $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

            }
            // END MICRO LEDGE @2
        }
        // END RECEIPTS
        // DUAL APPROVEL TB UPDATE
        $data_ar2 = array(
            'stat' => 1,
            'almt' => $loam,
            'remk' => $cmt,
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        );
        $where_arr2 = array(
            'lnid' => $auid,
            'stat' => 0
        );
        $this->Generic_model->updateData('dual_approval', $data_ar2, $where_arr2);

        $funcPerm = $this->Generic_model->getFuncPermision('dual_apprv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Approved, Dual Approval lnid(' . $auid . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
// END DUAL APPROVAL
//
// PRINT RECEIPTS
    function reciptPrint($auid)
    {
        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf->AddPage('L', 'A4');
        $this->pdf->SetMargins(10, 10, 10);
        $this->pdf->SetAuthor('www.gdcreations.com');
        $this->pdf->SetTitle('Receipts');
        $this->pdf->SetDisplayMode('default');


        $this->pdf->SetXY(10, 9);
        $this->pdf->SetFont('Helvetica', 'B', 20);
        $this->pdf->Cell(0, 6, "RECEIPTS ", 0, 1, 'L');
        $this->pdf->SetFont('Helvetica', 'B', 15);
        $this->pdf->Cell(0, 6, 'DATE : ' . $dt1, 0, 1, 'L');

        $this->pdf->Cell(10, 6, "Id : " . $auid, 0, 1, 'L');

        $this->pdf->SetTitle('Receipts ');
        $this->pdf->Output('Receipts_' . $auid . '.pdf', 'I');
        ob_end_flush();

    }

// END PRINT RECEIPTS
//
// ADVANCE LOAN MANAGEMENT
    function advnc_loan()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['intprdinfo'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 3), '');     // INTEREST FREE
        $data['dwnprdinfo'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 4), '');     // DOWNPYMT LOAN

        $data['policy'] = $this->Generic_model->getData('sys_policy', array('ponm,pov1,pov2,post'), array('popg' => 'loan', 'stat' => 1));
        $data['policyinfo'] = $this->Generic_model->getData('sys_policy', array('pov1', 'pov2', 'pov3'), array('popg' => 'product', 'stat' => 1));
        $data['stainfo'] = $this->Generic_model->getData('loan_stat', array('stid,stnm'), array('isac' => 1), '');
        $data['dynamicprd'] = $this->Generic_model->getData('prdt_typ', array('prid,prna,prtp,stat'), array('stat' => 1, 'prbs' => 2), '');

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('advnc_loan');
        $this->load->view('modules/user/loan_advance', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchAdvncLoan()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('advnc_loan');

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
        $disabled = "disabled";


        $result = $this->User_model->get_advnceLoanDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->lnst;
            $auid = $row->lnid;

            // CHECK APPROVAL DATE > TODAY - 7 DAYS
            $apdt = $row->apdt;
            $cc = date('Y-m-d', strtotime('-7 days'));
            if ($apdt < $cc) {
                $dt = "disabled";
            } else {
                $dt = "";
            }
            // IF CHECK PRODUCT LOAN OR DYNAMIC LOAN
            if ($row->lntp == 3) {
                $loam = $row->loam + $row->inta;
                $lntp = "<span class='label label-success' title='INT FREE LOAN'>IFL</span>";

            } elseif ($row->lntp == 4) {
                $loam = $row->loam + $row->pyam;
                $lntp = "<span class='label label-warning' title='DWN PYMT LOAN '>DPL</span>";
            }
            // IF CHECK TOPUP LOAN OR
            if ($row->prva != 0) {
                $tpup = "<span class='label label-info' title='Topup Loan'>T</span>";
                $tpds = "disabled";
            } else {
                $tpup = "";
                $tpds = "";
            }

            if ($st == '1') {  // Pending
                $stat = "<span class='label label-warning'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  $tpds data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app $tpds data-toggle='modal' data-target='#modalEdt' onclick='edtLoan($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $rej $tpds onclick='rejecLoan($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Approved
                $stat = "<span class='label label-success'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $dt $tpds onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '4') {  // Rejected
                $stat = "<span class='label label-danger'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLoan(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLoan(id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej' $disabled onclick='rejecLoan();' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '5') {  // Disbursed
                $stat = "<span class='label label-success' style='background-color: #66ff33'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $disabled  onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else {  // Others
                $stat = "<span class='label label-default'> $row->stnm </span> ";
                $option = "<button type='button' $viw data-toggle='modal' data-target='#modalView' onclick='viewLoan($auid);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $disabled   data-toggle='modal' data-target='#modalEdt' onclick='edtLoan();' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $disabled data-toggle='modal' data-target='#modalEdt' onclick='' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='rej'  $rej $disabled  onclick='rejecLoan($auid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' /' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $lntp . ' ' . $row->acno . ' ' . $tpup;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = number_format($loam, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = $row->lnpr . ' ' . $row->pymd;

            $sub_arr[] = $stat;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_advncLoan(),
            "recordsFiltered" => $this->User_model->count_filtered_advncLoan(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function addAdvnceLoan()
    {
        $lntp = $this->input->post('lntp');     // loan type (1 - INTEREST FREE LOAN / )
        $grtp = $this->input->post('grnTyp');   // granter type (0 - Individual granter / 1 - Group granter )
        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($lntp == 1) {       // INTEREST FREE LOAN

            $lntp = 3;
            $prtp = 2;      // RENTAL CAL TYPE (FLAT RATE)
            $inra = 0;

            $prdtp = $this->input->post('prdTyp');      //
            $loam = $this->input->post('fcamt');        // LOAN AMOUNT
            $inta = $this->input->post('ttlint');       // TOTAL INTEREST

            $lcat = $this->input->post('dytp');
            $noin = $this->input->post('inpr');         // NO OF INSTALMENT
            $inam = $this->input->post('lnprim');       // PRIEUM

            $hdpy = $this->input->post('hid');          // HIDE PAYMENT ENABLE / DISABLE
            $pyam = $this->input->post('hdvl');         // HIDE PAYMENT

            $loam = $loam - $inta;                      // ACTIVIAL LOAN AMOUNT

            if ($prdtp == 9) {
                $prdid = $this->Generic_model->getData('product', array('auid', 'nofr', 'infm', 'clrt', 'pncd', 'cldw'), array('prtp' => $prdtp, 'nofr' => $noin, 'cldw' => $lcat, 'stat' => 1));

                $prid = $prdid[0]->auid;
                $lcat = $prdid[0]->cldw;
                $lnpr = $prdid[0]->infm;

                $clrt = $prdid[0]->clrt;
                $pnco = $prdid[0]->pncd;

            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'nofr', 'infm', 'clrt', 'pncd'), array('prtp' => $prdtp, 'nofr' => $noin, 'stat' => 1));

                $prid = $prdid[0]->auid;
                $lcat = 0;
                $lnpr = $prdid[0]->nofr;

                $clrt = $prdid[0]->clrt;
                $pnco = $prdid[0]->pncd;
            }

        } else {            // DOWN PAYMENT LOAN

            $lntp = 4;
            $prtp = $this->input->post('cltp');     // RENTAL CAL TYPE (FLAT RATE)

            $prdtp = $this->input->post('prdTyp_dp');   // DL/WK/ML
            $loam = $this->input->post('fcamt_dp');     // LOAN AMOUNT
            $inta = $this->input->post('ttlint_dp');    // TOTAL INTEREST

            $hdpy = $this->input->post('dwp');          // DOWN PAYMENT ENABLE / DISABLE
            $pyam = $this->input->post('dwpy');         // DOWN PAYMENT

            $lcat = $this->input->post('dytp_dp');      // DL SUB CAT 5,6,7
            $noin = $this->input->post('inpr_dp');      // NO OF INSTALMENT
            $inam = $this->input->post('lnprim_dp');    // PRIEUM
            $inra = $this->input->post('inrt_dp');      // RATE

            $loam = $loam - $pyam;                      // ACTIVIAL LOAN AMOUNT (LOAN - DOWN PAYMENT )

            if ($prdtp == 12) {
                $prdid = $this->Generic_model->getData('product', array('auid', 'nofr', 'infm', 'clrt', 'pncd', 'cldw'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $noin, 'cldw' => $lcat, 'stat' => 1));

                $prid = $prdid[0]->auid;
                $lcat = $prdid[0]->cldw;
                $lnpr = $prdid[0]->infm;

                $clrt = $prdid[0]->clrt;
                $pnco = $prdid[0]->pncd;

            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'nofr', 'infm', 'clrt', 'pncd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $noin, 'stat' => 1));

                $prid = $prdid[0]->auid;
                $lcat = 0;
                $lnpr = $prdid[0]->nofr;

                $clrt = $prdid[0]->clrt;
                $pnco = $prdid[0]->pncd;
            }
        }

        if ($grtp == 0) {            // Individual granter
            $fsgi = $this->input->post('fsgi');
            $segi = $this->input->post('segi');
            $thgi = $this->input->post('thgi');
            $fogi = $this->input->post('fogi');
            $figi = $this->input->post('figi');

            $sxgi = 0;
            $svgi = 0;
            $eggi = 0;
            $nigi = 0;
            $tngi = 0;

        } else {                // Group granter

            $len = $this->input->post('grntLen');
            $i = 0;
            for ($a = 0; $a < $len; $a++) {
                $grnid = $this->input->post("addm[" . $a . "]");      // granter id
                if ($grnid != '') {
                    $result[$i] = array(0 => $grnid);
                    $i++;
                    // array('brch_id' => '0');
                }
            }
            $xx = sizeof($result);
            if ($xx < 10) {
                for ($c = $xx; $c < 10; $c++) {
                    $result[$c] = array(0 => 0);
                }
            }
            $fsgi = $result[0][0];
            $segi = $result[1][0];
            $thgi = $result[2][0];
            $fogi = $result[3][0];
            $figi = $result[4][0];
            $sxgi = $result[5][0];
            $svgi = $result[6][0];
            $eggi = $result[7][0];
            $nigi = $result[8][0];
            $tngi = $result[9][0];
        }

        $brco = $this->input->post('coll_brn');
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brco, 'stat' => 1));
        $brcd = $brdt[0]->brcd;

        $this->db->select("brco,acno");
        $this->db->from("micr_crt");
        $this->db->where('micr_crt.brco ', $brco);
        $this->db->where('micr_crt.stat IN(1,4)');
        $this->db->order_by('micr_crt.lnid', 'desc');

        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $acno = $brcd . '/TMP/0001';
        } else {
            $acno = $data[0]->acno;
            $re = (explode("/", $acno));
            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }
            $acno = $brcd . '/' . 'TMP' . '/' . $xx;
        }

        $data_arr = array(  // $name_nic = ucwords($name_nic);      //ucwords($foo);
            'brco' => $this->input->post('coll_brn'),
            'clct' => $this->input->post('coll_ofc'),
            'ccnt' => $this->input->post('coll_cen'),
            'acno' => $acno,
            'lntp' => $lntp,
            'grtp' => $grtp,
            'prdtp' => $prdtp,
            'prid' => $prid,

            'apid' => $this->input->post('appid'),
            'fsgi' => $fsgi,
            'segi' => $segi,
            'thgi' => $thgi,
            'fogi' => $fogi,
            'figi' => $figi,
            'sxgi' => $sxgi,
            'svgi' => $svgi,
            'eggi' => $eggi,
            'nigi' => $nigi,
            'tngi' => $tngi,

            'loam' => $loam,
            'inta' => $inta,
            'inra' => $inra,
            'lnpr' => $lnpr,
            'noin' => $noin,
            'lcat' => $lcat,
            'inam' => $inam,

            'docg' => $this->input->post('docu'),
            'incg' => $this->input->post('insu'),
            'chmd' => $this->input->post('crgmd'), // charge mode
            'indt' => $this->input->post('indt'),
            'acdt' => $this->input->post('dsdt'),
            'sydt' => date('Y-m-d'),

            'pnco' => $pnco,
            'prtp' => $prtp,
            'pnra' => $clrt,
            'stat' => 1,        // pending Loan
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),

            'hdpy' => $hdpy,        // HIDE OR DOWN PAYMENT ENABLE / DISABLE
            'pyam' => $pyam,       // HIDE OR DOWN PAYMENT AMOUNT
        );
        $result = $this->Generic_model->insertData('micr_crt', $data_arr);

        // IF LOAN COMMENT ADD
        $cmt = $this->input->post('remk');
        if (!empty($cmt)) {
            $query = $this->Generic_model->getData('micr_crt', array('lnid'), array('acno' => $acno));
            $lnid = $query[0]->lnid;
            $data_arr = array(
                'cmtp' => 2,
                'cmmd' => 1,
                'cmrf' => $lnid,
                'cmnt' => $cmt,
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('comments', $data_arr);
        }
        // END LOAN COMMENT

        $funcPerm = $this->Generic_model->getFuncPermision('advnc_loan');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Advance Loan ' . $acno);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // EDIT ADVANCE LOAN
    function advncLoan_edit()
    {
        $func = $this->input->post('func');     // if update=1 or approval=2
        $auid = $this->input->post('lnauid');   // loan auto id
        $lntp = $this->input->post('lontype');  // // loan type (3 - INTEREST FREE LOAN / 4 - DOWN PAYMENT LOAN )

        if ($lntp == 3) {       // INTEREST FREE LOAN

            $lntp = 3;
            $prtp = 2;      // RENTAL CAL TYPE (FLAT RATE)
            $inra = 0;

            $prdtp = $this->input->post('prdTypEdt');      //
            $loam = $this->input->post('fcamtEdt');        // LOAN AMOUNT
            $inta = $this->input->post('ttlintEdt');       // TOTAL INTEREST

            $lcat = $this->input->post('dytpEdt');
            $noin = $this->input->post('inprEdt');         // NO OF INSTALMENT
            $inam = $this->input->post('lnprimEdt');       // PRIEUM

            $hdpy = $this->input->post('hidEdt');          // HIDE PAYMENT ENABLE / DISABLE
            $pyam = $this->input->post('hdvlEdt');         // HIDE PAYMENT

            $loam = $loam - $inta;                      // ACTIVIAL LOAN AMOUNT

            if ($prdtp == 9) {
                $prdid = $this->Generic_model->getData('product', array('auid', 'nofr', 'infm', 'clrt', 'pncd', 'cldw'), array('prtp' => $prdtp, 'nofr' => $noin, 'cldw' => $lcat, 'stat' => 1));

                $prid = $prdid[0]->auid;
                $lcat = $prdid[0]->cldw;
                $lnpr = $prdid[0]->infm;

                $clrt = $prdid[0]->clrt;
                $pnco = $prdid[0]->pncd;

            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'nofr', 'infm', 'clrt', 'pncd'), array('prtp' => $prdtp, 'nofr' => $noin, 'stat' => 1));

                $prid = $prdid[0]->auid;
                $lcat = 0;
                $lnpr = $prdid[0]->nofr;

                $clrt = $prdid[0]->clrt;
                $pnco = $prdid[0]->pncd;
            }

        } else {            // DOWN PAYMENT LOAN

            $lntp = 4;
            $prtp = $this->input->post('cltpEdt');     // RENTAL CAL TYPE (FLAT RATE)

            $prdtp = $this->input->post('prdTyp_dpEdt');   // DL/WK/ML
            $lnam = $this->input->post('fcamt_dpEdt');     // LOAN AMOUNT
            $inta = $this->input->post('ttlint_dpEdt');    // TOTAL INTEREST

            $hdpy = $this->input->post('dwpEdt');          // DOWN PAYMENT ENABLE / DISABLE
            $pyam = $this->input->post('dwpyEdt');         // DOWN PAYMENT

            $lcat = $this->input->post('dytp_dpEdt');      // DL SUB CAT 5,6,7
            $noin = $this->input->post('inpr_dpEdt');      // NO OF INSTALMENT
            $inam = $this->input->post('lnprim_dpEdt');    // PRIEUM
            $inra = $this->input->post('inrt_dpEdt');      // RATE

            $loam = $lnam - $pyam;                      // ACTIVIAL LOAN AMOUNT (LOAN - DOWN PAYMENT )

            if ($prdtp == 12) {
                $prdid = $this->Generic_model->getData('product', array('auid', 'nofr', 'infm', 'clrt', 'pncd', 'cldw'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $noin, 'cldw' => $lcat, 'stat' => 1));

                $prid = $prdid[0]->auid;
                $lcat = $prdid[0]->cldw;
                $lnpr = $prdid[0]->infm;

                $clrt = $prdid[0]->clrt;
                $pnco = $prdid[0]->pncd;

            } else {
                $prdid = $this->Generic_model->getData('product', array('auid', 'nofr', 'infm', 'clrt', 'pncd'), array('prtp' => $prdtp, 'inra' => $inra, 'nofr' => $noin, 'stat' => 1));

                $prid = $prdid[0]->auid;
                $lcat = 0;
                $lnpr = $prdid[0]->nofr;

                $clrt = $prdid[0]->clrt;
                $pnco = $prdid[0]->pncd;
            }
        }

//MATURITY DATE AND NEXT RENTEL DATE

        $indt = $this->input->post('indtEdt');
        $date = date("Y-m-d");
        $nxdd = date("Y-m-d");

        if ($prdtp == 9 || $prdtp == 12) {         // IFD || DPD

            $holidayDates = $this->Generic_model->getData('sys_holdys', array('date'), array('stat' => 1, 'hdtp' => 1));
            $holidayDates = array_column($holidayDates, 'date');
            $count5WD = 0;
            $temp = strtotime(date("Y-m-d"));

            while ($count5WD < $lnpr) {
                $next1WD = strtotime('+1 weekday', $temp);
                $next1WDDate = date('Y-m-d', $next1WD);
                if (!in_array($next1WDDate, $holidayDates)) {
                    $count5WD++;
                }
                $temp = $next1WD;
            }
            $next5WD = date("Y-m-d", $temp);
            $madt = $next5WD;

            $count5WD2 = 0;
            $temp2 = strtotime(date("Y-m-d"));
            while ($count5WD2 < 1) {
                $next1WD2 = strtotime('+1 weekday', $temp2);
                $next1WDDate2 = date('Y-m-d', $next1WD2);
                if (!in_array($next1WDDate2, $holidayDates)) {
                    $count5WD2++;
                }
                $temp2 = $next1WD2;
            }
            $next5WD2 = date("Y-m-d", $temp2);
            $nxdd_n = $next5WD2;

        } else if ($prdtp == 10 || $prdtp == 13) {   // IFW || DPW
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $lnpr . "week");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 week");
            $nxdd_n = date("Y-m-d", $nxdd);

        } else if ($prdtp == 11 || $prdtp == 14) {   // IFM || DPM
            $date = strtotime(date("Y-m-d", strtotime($date)) . " +" . $lnpr . "month");
            $madt = date("Y-m-d", $date);
            $nxdd = strtotime(date("Y-m-d", strtotime($nxdd)) . " +1 month");
            $nxdd_n = date("Y-m-d", $nxdd);
        }

// END MATURITY DATE

        // IF DUEL APPROVAL CHECK
        $brco = $this->input->post('coll_brnEdt');
        $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat', 'duap', 'apmt'), array('brid' => $brco, 'stat' => 1));
        /*$duap = $brdt[0]->duap;
        $apmt = $brdt[0]->apmt;
        if ($func == 2 && $duap == 1 && $loam > $apmt) {
            $func = 3;
        } else {
            $func = $func;
        }*/
        // END DUEL APPROVAL CHECK

        if ($func == '1') {                     // update Loan
            $this->db->trans_begin();           // SQL TRANSACTION START

            $data_ar1 = array(
                'clct' => $this->input->post('coll_ofcEdt'),
                'ccnt' => $this->input->post('coll_cenEdt'),
                'prdtp' => $prdtp,
                'prid' => $prid,
                //'apid' => $this->input->post('appidEdt'),
                //'fsgi' => $this->input->post('fsgiEdt'),
                //'segi' => $this->input->post('segiEdt'),
                //'thgi' => $this->input->post('thgiEdt'),
                //'fogi' => $this->input->post('fogiEdt'),
                //'figi' => $this->input->post('figiEdt'),

                'loam' => $loam,
                'inta' => $inta,
                'inra' => $inra,
                'lnpr' => $lnpr,
                'noin' => $noin,
                'lcat' => $lcat,
                'inam' => $inam,

                'docg' => $this->input->post('docuEdt'),
                'incg' => $this->input->post('insuEdt'),
                'chmd' => $this->input->post('crgmdEdt'), // charge mode
                'indt' => $this->input->post('indtEdt'),
                'acdt' => $this->input->post('dsdtEdt'),

                'pnco' => $pnco,
                'prtp' => $prtp,
                'pnra' => $clrt,

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'lnid' => $auid
            );
            $result22 = $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);

            // IF NEW LOAN COMMENT ADD
            $cmt = $this->input->post('remkNew');
            if (!empty($cmt)) {
                $data_arr = array(
                    'cmtp' => 2,
                    'cmmd' => 1,
                    'cmrf' => $auid,
                    'cmnt' => $cmt,
                    'stat' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('comments', $data_arr);
            }
            // END LOAN COMMENT

            $funcPerm = $this->Generic_model->getFuncPermision('advnc_loan');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Advance Loan lnid(' . $auid . ')');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }

        } elseif ($func == '2') {            // approval loan

            $this->db->trans_begin(); // SQL TRANSACTION START

            // GET BRANCH CODE GP/NT
            $brco = $this->input->post('coll_brnEdt');
            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat', 'duap', 'apmt'), array('brid' => $brco, 'stat' => 1));
            $brcd = $brdt[0]->brcd;

            $cent = $this->input->post('coll_cenEdt');
            $cnno = $this->Generic_model->getData('cen_mas', array('caid', 'cnno', 'stat'), array('caid' => $cent, 'stat' => 1));
            $cncd = $cnno[0]->cnno;

            // GET PRODUCT CODE
            $prt = $this->Generic_model->getData('product', array('prcd', 'pnst', 'clrt'), array('auid' => $prid, 'stat' => 1));
            $prcd = $prt[0]->prcd;
            $clrt = $prt[0]->clrt;

            // GET LAST LOAN NO
            $this->db->select("brco,acno,ccnt,prdtp,prid");
            $this->db->from("micr_crt");
            $this->db->where('micr_crt.brco ', $brco);
            $this->db->where('micr_crt.ccnt ', $cent);

            if ($lntp == 1) {           //1 product loan 2 dynamic loan
                $this->db->where('micr_crt.prid ', $prid);
            } else {
                $this->db->where('micr_crt.prdtp ', $prdtp);
            }
            //$this->db->where('micr_crt.stat IN(2,3,5) ');
            $this->db->where('micr_crt.stat NOT IN (1) ');
            $this->db->order_by('micr_crt.apdt', 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $data = $query->result();

            // GENARATE NEXT LOAN NO
            if (count($data) == '0') {
                $aa = '0001';
            } else {
                // IF VALIDE ACNO CHECK         *** CODE UPDATE 18/09/03 ***
                for ($a = 0; $a < 10; $a++) {
                    if (strlen($data[$a]->acno) == 19) {

                        $acno = $data[$a]->acno;
                        break;
                    } else {
                        $a = $a + 1;
                    }
                }
                //$acno = $data[0]->acno;
                $re = (explode("/", $acno));
                $aa = intval($re[4]) + 1;
            }

            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }

            // center no
            $mm = strlen($cncd);
            if ($mm == 1) {
                $gg = '000' . $cncd;
            } else if ($mm == 2) {
                $gg = '00' . $cncd;
            } else if ($mm == 3) {
                $gg = '0' . $cncd;
            } else if ($mm == 4) {
                $gg = '' . $cncd;
            }
            $yr = date('y');
            $acno = $brcd . '/' . $prcd . '/' . $yr . '/' . $gg . '/' . $xx;
            // END LOAN NO GENARATE

            // MICRO CART TB UPDATE
            $data_ar1 = array(
                'clct' => $this->input->post('coll_ofcEdt'),
                'ccnt' => $this->input->post('coll_cenEdt'),
                'acno' => $acno,
                'prdtp' => $prdtp,
                'prid' => $prid,
                'apid' => $this->input->post('appidEdt'),
                'fsgi' => $this->input->post('fsgiEdt'),
                'segi' => $this->input->post('segiEdt'),
                'thgi' => $this->input->post('thgiEdt'),
                'fogi' => $this->input->post('fogiEdt'),
                'figi' => $this->input->post('figiEdt'),
                'loam' => $loam,
                'inta' => $inta,
                'inra' => $inra,
                'lnpr' => $lnpr,
                'noin' => $noin,
                'lcat' => $lcat,
                'inam' => $inam,
                'docg' => $this->input->post('docuEdt'),
                'incg' => $this->input->post('insuEdt'),
                'chmd' => $this->input->post('crgmdEdt'), // charge mode
                'indt' => $this->input->post('indtEdt'),
                'acdt' => $this->input->post('dsdtEdt'),

                'madt' => $madt,
                'nxdd' => $nxdd_n,
                'durg' => $noin,
                'boc' => $loam,
                'boi' => $inta,
                'nxpn' => 1,
                'stat' => 2,

                'pnco' => $pnco,
                'prtp' => $prtp,
                'pnra' => $clrt, // PANALTY CAL RATE
                'pncs' => $prt[0]->pnst,
                'pcid' => 0,

                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'lnid' => $auid
            );
            $result_micrt = $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);


            // IF NEW LOAN COMMENT ADD
            $cmt = $this->input->post('remkNew');
            if (!empty($cmt)) {
                $data_arr = array(
                    'cmtp' => 2,
                    'cmmd' => 1,
                    'cmrf' => $auid,
                    'cmnt' => $cmt,
                    'stat' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $this->Generic_model->insertData('comments', $data_arr);
            }
            // END LOAN COMMENT

            // LEDGER RECODE
            $cchmd = $this->input->post('crgmdEdt');
            $docg = $this->input->post('docuEdt');
            $incg = $this->input->post('insuEdt');
            $dwpy = $this->input->post('dwpyEdt');      // DOWN PAYMENT

            // MICRO LEDGE @1
            if ($lntp == 4) {   // DOWN PAYMNT LOAN
                $dwpy = $dwpy;
            } else {
                $dwpy = 0;
            }

            $data_mclg1 = array(
                'acid' => $auid, // LOAN ID
                'acno' => $acno, // LOAN NO
                'ledt' => date('Y-m-d H:i:s'),
                'dsid' => 8,
                'dcrp' => 'ACNT DIFN',
                'avcp' => $loam,
                'avin' => $inta,

                'schg' => $docg + $incg + $dwpy,
                'duam' => $docg + $incg + $dwpy,
                'stat' => 1
            );
            $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

            // IF CUSTOMER PAYED DOWN PAYMENT
            if ($dwpy > 0) {

                $data_mclg1 = array(
                    'acid' => $auid, // LOAN ID
                    'acno' => $acno, // LOAN NO
                    'ledt' => date('Y-m-d H:i:s'),
                    'dsid' => 26,
                    'dcrp' => 'DWN PYMT',

                    'schg' => -$dwpy,
                    'ream' => $dwpy,
                    'stat' => 1
                );
                $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

            }

            // ACCOUNT LEDGE
            $data_aclg1 = array(
                'brno' => $brco, // BRANCH ID
                'lnid' => $auid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'ACNT DIFN',
                'trid' => 8,
                'rfna' => $acno,
                'dcrp' => 'ACNT DIFN',
                'acco' => '111',    // cross acc code
                'spcd' => '108',    // split acc code
                'acst' => '(108) Loan Stock',
                'dbam' => $loam,
                'cram' => 0,
                'stat' => 0
            );
            $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);

            $data_aclg2 = array(
                'brno' => $brco, // BRANCH ID
                'lnid' => $auid, // LOAN NO
                'acdt' => date('Y-m-d H:i:s'),
                'trtp' => 'ACNT DIFN',
                'trid' => 8,
                'rfna' => $acno,
                'dcrp' => $acno,
                'acco' => '108',    // cross acc code
                'spcd' => '111',    // split acc code
                'acst' => '(111) Loan Controller',
                'dbam' => 0,
                'cram' => $loam,
                'stat' => 0
            );
            $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);

            if ($cchmd == 1) {        // CHARGE PAY BY CUSTOMER

            } else if ($cchmd == 2) {  // CHARGE RECOVER FOR LOAN

                if ($docg > 0) {
                    $data_aclg23 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 111,    // cross acc code
                        'spcd' => 404,    // split acc code
                        'acst' => '(404) Document Charge',      //
                        'dbam' => 0,      // db amt
                        'cram' => $docg,  // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 404,    // cross acc code
                        'spcd' => 111,    // split acc code
                        'acst' => '(111) Loan Controller',
                        'dbam' => $docg,  // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result77 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                }

                if ($incg > 0) {
                    $data_aclg23 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 111,    // cross acc code
                        'spcd' => 403,    // split acc code
                        'acst' => '(403) Insurance Charge',      //
                        'dbam' => 0,      // db amt
                        'cram' => $incg,      // cr amt
                        'stat' => 0
                    );
                    $result = $this->Generic_model->insertData('acc_leg', $data_aclg23);

                    $data_aclg45 = array(
                        'brno' => $brco, // BRANCH ID
                        'lnid' => $auid, // LOAN NO
                        'acdt' => date('Y-m-d H:i:s'),
                        'trtp' => 'ACNT DIFN',
                        'trid' => 8,
                        'rfna' => $acno,
                        'dcrp' => 'ACNT DIFN',

                        'acco' => 403,    // cross acc code
                        'spcd' => 111,    // split acc code
                        'acst' => '(111) Loan Controller',      //
                        'dbam' => $incg,      // db amt
                        'cram' => 0,      // cr amt
                        'stat' => 0
                    );
                    $result88 = $this->Generic_model->insertData('acc_leg', $data_aclg45);
                }
            }
            // END ACCOUNT LEDGE

            // RECEIPTS PROCESS
            //$user = $this->Generic_model->getData('user_mas', array('auid', 'usmd', 'brch'), array('auid' => $_SESSION['userId']));
            //$brn = $user[0]->brch;
            $brn = $brco;

            $brdt = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'stat'), array('brid' => $brn, 'stat' => 1));
            $brcd = $brdt[0]->brcd;

            $this->db->select("reno");
            $this->db->from("receipt");
            $this->db->where('receipt.brco ', $brn);
            $this->db->where('receipt.retp ', 1);
            $this->db->order_by('receipt.reid', 'desc');

            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            $yr = date('y');
            if (count($data) == '0') {
                $reno = $brcd . '/GR/' . $yr . '/00001';
            } else {
                $reno = $data[0]->reno;
                $re = (explode("/", $reno));
                $aa = intval($re[3]) + 1;

                $cc = strlen($aa);
                // next loan no
                if ($cc == 1) {
                    $xx = '0000' . $aa;
                } else if ($cc == 2) {
                    $xx = '000' . $aa;
                } else if ($cc == 3) {
                    $xx = '00' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                } else if ($cc == 5) {
                    $xx = '' . $aa;
                }

                $reno = $brcd . '/GR/' . $yr . '/' . $xx;
            }

            // INSERT GENERAL RECEIPTS

            if ($cchmd == 1) {        // CHARGE PAY BY CUSTOMER

                // customer payed process chang to edtPymnt() approval function
            } else if ($cchmd == 2) {  // CHARGE RECOVER FOR LOAN
                $data_arr = array(
                    'brco' => $brn,
                    'reno' => $reno,
                    'rfno' => $auid, // loan id
                    'retp' => 1,
                    'ramt' => $docg + $incg,
                    'pyac' => 111,
                    'pymd' => 9, // 8 -cash / 9 - inter account trnsfer
                    //'clid' => $this->input->post('appidEdt'), // cust id
                    'stat' => 1,
                    'remd' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('receipt', $data_arr);

                $recdt = $this->Generic_model->getData('receipt', array('reid', 'reno'), array('reno' => $reno));
                $reid = $recdt[0]->reid;

                if ($docg > 0) {

                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 404,
                        'rfdc' => 'Document Charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $docg
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                }

                if ($incg > 0) {
                    $data_arr22 = array(
                        'reno' => $reno,
                        'reid' => $reid, // recpt id
                        'rfco' => 403,
                        'rfdc' => 'Insurance Charges',
                        'rfdt' => date('Y-m-d'),
                        'amut' => $incg
                    );
                    $result22 = $this->Generic_model->insertData('recp_des', $data_arr22);
                }

                // MICRO LEDGE @2
                if ($docg > 0) {
                    $data_mclg1 = array(
                        'acid' => $auid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 1,
                        'dcrp' => 'DOC CHG RECOV FOR ACC',
                        'schg' => -$docg,
                        'ream' => $docg,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

                }

                if ($incg > 0) {
                    $data_mclg1 = array(
                        'acid' => $auid, // LOAN ID
                        'acno' => $acno, // LOAN NO
                        'ledt' => date('Y-m-d H:i:s'),
                        'reno' => $reno,
                        'reid' => $reid,
                        'dsid' => 1,
                        'dcrp' => 'INS CHG RECOV FOR ACC',
                        'schg' => -$incg,
                        'ream' => $incg,
                        'stat' => 1
                    );
                    $result = $this->Generic_model->insertData('micr_crleg', $data_mclg1);

                }
                // END MICRO LEDGE @2
            }
            // END RECEIPTS

            $funcPerm = $this->Generic_model->getFuncPermision('loan');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan approval id(' . $auid . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit();
                echo json_encode('appr');   // APPROVAL
            }

        } elseif ($func == 3) {     // DUAL APPROVAL

            $this->db->trans_begin(); // SQL TRANSACTION START

            // LOAN TB UPDATE
            $data_ar1 = array(
                'clct' => $this->input->post('coll_ofcEdt'),
                'ccnt' => $this->input->post('coll_cenEdt'),
                'prdtp' => $prdtp,
                'prid' => $prid,
                'apid' => $this->input->post('appidEdt'),
                'fsgi' => $this->input->post('fsgiEdt'),
                'segi' => $this->input->post('segiEdt'),
                'thgi' => $this->input->post('thgiEdt'),
                'fogi' => $this->input->post('fogiEdt'),
                'figi' => $this->input->post('figiEdt'),
                'loam' => $loam,
                'inta' => $inta,
                'inra' => $inra,
                'lnpr' => $lnpr,
                'noin' => $noin,
                'lcat' => $lcat,
                'inam' => $inam,

                'docg' => $this->input->post('docuEdt'),
                'incg' => $this->input->post('insuEdt'),
                'chmd' => $this->input->post('crgmdEdt'), // charge mode
                'indt' => $this->input->post('indtEdt'),
                'acdt' => $this->input->post('dsdtEdt'),

                'pnco' => $pnco,
                'prtp' => $prtp,
                'pnra' => $clrt,

                'stat' => 19,
                'duap' => 1,

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'lnid' => $auid
            );
            $this->Generic_model->updateData('micr_crt', $data_ar1, $where_arr);

            // DUAL APPROVAL TB UPDATE
            $data_arr2 = array(
                'lnid' => $auid,
                'apmt' => $apmt,
                'rqmt' => $loam,
                'stat' => 0,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $this->Generic_model->insertData('dual_approval', $data_arr2);

            // IF NEW LOAN COMMENT ADD
            $cmt = $this->input->post('remkNew');
            if (!empty($cmt)) {
                $data_arr = array(
                    'cmtp' => 2,
                    'cmmd' => 1,
                    'cmrf' => $auid,
                    'cmnt' => $cmt,
                    'stat' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('comments', $data_arr);
            }
            // END LOAN COMMENT

            $funcPerm = $this->Generic_model->getFuncPermision('loan');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Loan Dual Approval lnid(' . $auid . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                //echo json_encode(true);
                echo json_encode('Dual');   // DUAL APPROVAL
            }
        }
    }

// END ADVANCE LOAN
//
// PROMOTION MODULE SHOP MANAGEMENT //
// SHOP MANAGEMENT
    function shop_mng()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $data['branchinfo'] = $this->Generic_model->getBranch();

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('shop_mng');
        $this->load->view('modules/user/shop_manag', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchShop()
    {
        //$ctgr = $this->input->post('ctgr');
        //$stat = $this->input->post('stat');

        $funcPerm = $this->Generic_model->getFuncPermision('shop_mng');

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
        if ($funcPerm[0]->reac == 1) {
            $reac = "hidden";
            $reac2 = "";
        } else {
            $reac = "";
            $reac2 = "hidden";
        }


        $result = $this->User_model->get_shoplist();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $itid = $row->spid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewShop($itid);' class='btn btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtShop($itid,this.id);' class='btn  btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app  data-toggle='modal' data-target='#modalEdt'  onclick='edtShop($itid,this.id);' class='btn  btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  onclick='rejecShop($itid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewShop($itid);' class='btn btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtShop();' class='btn  btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtShop();' class='btn  btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecShop($itid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {            // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='edtMdel($itid);' class='btn btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtShop();' class='btn  btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtShop();' class='btn  btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvShop($itid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->spcd;
            $sub_arr[] = $row->spnm;
            $sub_arr[] = $row->addr;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_shoplist(),
            "recordsFiltered" => $this->User_model->count_filtered_shoplist(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // ALREADY NAME CHECK
    function chk_shop()
    {
        $spnm = $this->input->post('spnm');
        $brch = $this->input->post('brch');
        $result = $this->Generic_model->getData('shop_mas', array('spid', 'spnm'), array('spnm' => $spnm, 'brid' => $brch));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY NAME CHECK
    function chk_shop_edit()
    {
        $auid = $this->input->post('auid');
        $spnm = $this->input->post('spnm');
        $brch = $this->input->post('brch');
        $result = $this->Generic_model->getData('shop_mas', array('spid', 'spnm'), array('spnm' => $spnm, 'brid' => $brch));

        if (count($result) > 0) {
            if ($result[0]->spid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // MODEL ADD
    function addShop()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->db->select("spcd");
        $this->db->from("shop_mas");
        $this->db->order_by('spid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $spcd = 'SH-001';  // Ex SH-001

        } else {
            $spc = $data[0]->spcd;
            $re = (explode("-", $spc));

            $aa = intval($re[1]) + 1;
            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '00' . $aa;
            } else if ($cc == 2) {
                $xx = '0' . $aa;
            } else if ($cc == 3) {
                $xx = '' . $aa;
            }
            $spcd = 'SH-' . $xx;
        }

        $data_arr = array(
            'brid' => $this->input->post('brch'),
            'spcd' => $spcd,
            'spnm' => strtoupper($this->input->post('spnm')),
            'addr' => ucwords(strtolower($this->input->post('addr'))),
            'mobi' => $this->input->post('mobi'),
            'tele' => $this->input->post('tele'),
            'emil' => $this->input->post('emil'),

            'cnpr' => $this->input->post('cntnm'),
            'cnph' => $this->input->post('cntph'),
            'dscr' => $this->input->post('remk'),

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('shop_mas', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('shop_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Shop (' . $spcd . ')');
    }

    function vewShop()
    {
        $auid = $this->input->post('auid');

        $this->db->select("shop_mas.*,CONCAT(user_mas.usnm) AS exe, brch_mas.brcd, brch_mas.brnm");
        $this->db->from("shop_mas");
        $this->db->join('user_mas', 'user_mas.auid = shop_mas.crby');
        $this->db->join('brch_mas', 'brch_mas.brid = shop_mas.brid');
        $this->db->where('shop_mas.spid', $auid);

        $query = $this->db->get();
        $result = $query->result();
        echo json_encode($result);
    }

    // UPDATE MODEL
    function edtShop()
    {
        $auid = $this->input->post('auid');
        $func = $this->input->post('func');

        // EDIT
        if ($func == 1) {

            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr = array(

                'brid' => $this->input->post('brchEdt'),
                'spnm' => strtoupper($this->input->post('spnmEdt')),
                'addr' => ucwords(strtolower($this->input->post('addrEdt'))),
                'mobi' => $this->input->post('mobiEdt'),
                'tele' => $this->input->post('teleEdt'),
                'emil' => $this->input->post('emilEdt'),

                'cnpr' => $this->input->post('cntnmEdt'),
                'cnph' => $this->input->post('cntphEdt'),
                'dscr' => $this->input->post('remkEdt'),

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'spid' => $auid
            );
            $result22 = $this->Generic_model->updateData('shop_mas', $data_arr, $where_arr);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('shop_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Shop Update id(' . $auid . ')');

        } else {       // APPROVAL

            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr = array(

                'brid' => $this->input->post('brchEdt'),
                'spnm' => strtoupper($this->input->post('spnmEdt')),
                'addr' => ucwords(strtolower($this->input->post('addrEdt'))),
                'mobi' => $this->input->post('mobiEdt'),
                'tele' => $this->input->post('teleEdt'),
                'emil' => $this->input->post('emilEdt'),

                'cnpr' => $this->input->post('cntnmEdt'),
                'cnph' => $this->input->post('cntphEdt'),
                'dscr' => $this->input->post('remkEdt'),

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'spid' => $auid
            );
            $result22 = $this->Generic_model->updateData('shop_mas', $data_arr, $where_arr);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('shop_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Shop Approval id(' . $auid . ')');

        }
    }

    // REJECT MODEL
    function rejShop()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('shop_mas', array('stat' => 2), array('spid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('shop_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Shop Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE MODEL
    function reactShop()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('shop_mas', array('stat' => 1), array('spid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('shop_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Shop Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END SUPPLY
//
// SHOP VOUCHER
    function shop_vouc()
    {
        $perm['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $perm);

        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('shop_vouc');

        $this->load->view('modules/user/voucher_shop', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/user/includes/custom_js_user');
    }

    function srchShopVou()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('shop_vouc');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
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
        if ($funcPerm[0]->prnt == 1) {
            $prnt1 = "";
        } else {
            $prnt1 = "disabled";
        }
        $disabled = "disabled";

        $result = $this->User_model->get_shopVou();
        $data = array();
        $i = $_POST['start'];
        foreach ($result as $row) {
            $auid = $row->void;

            if ($row->mode == 1) {          // Credit voucher
                $md = "<span class='label label-default' title='Credit Voucher'>CREDIT</span>";
                $app = "disabled";
            } elseif ($row->mode == 2) {    // incash group voucher
                $md = "<span class='label label-default' title='Incash Voucher'>IN CASH</span>";
                $app = "";
            } else if ($row->mode == 3) {   // general voucher
                $md = "<span class='label label-default' title='General Voucher'>GENERAL</span>";
                $app = "";
            } else if ($row->mode == 4) {   // gift voucher
                $md = "<span class='label label-default' title='General Voucher'>GIFT</span>";
                $app = "disabled";
            } else if ($row->mode == 5) {   // shop voucher
                $md = "<span class='label label-default' title='Shop Voucher'>SHOP VOUCHER</span>";
                $app = "";
            }

            if ($row->pntc > 0) {
                $rp = "";
                $pr = "hidden";
            } else {
                $rp = "hidden";
                $pr = "";
            }

            if ($row->stat == 1) {
                $stat = "<span class='label label-warning'> Pending </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app  id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' disabled $prnt1 data-toggle='modal'  onclick='vouPrint($auid,$row->mode);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' disabled $prnt1 data-toggle='modal'  onclick='vouReprint($auid,$row->mode,$row->rfid);' class='btn btn-default btn-condensed $rp' title='Reprint'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej  onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } elseif ($row->stat == 2) {  // if main statues approval
                $stat = "<span class='label label-success'> Approval</span> ";
                $app2 = "disabled";

                if ($row->prby == 0) {  // if credit voucher print or not
                    $prnt = "";
                } else {
                    $prnt = "disabled";
                }
                if ($row->chst == 1 && $row->cpnt == 0) {  // if cheq print or not
                    $rej2 = "";
                } else if ($row->chst == 2 && $row->cpnt == 1) {
                    $rej2 = "";
                } else {
                    $rej2 = "disabled";
                }

                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $app $app2 id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' $prnt1 $prnt data-toggle='modal'  onclick='vouPrint($auid,$row->mode);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' id='app' $prnt1 data-toggle='modal'  onclick='vouReprint($auid,$row->mode,$row->rfid);' class='btn btn-default btn-condensed $rp' title='Reprint' style='border-color: #00aaaa'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button'  $rej $rej2 onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 0) {
                $stat = "<span class='label label-danger'> Reject </span> ";
                $option = "<button type='button' id='viw' $viw data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn  btn-default btn-condensed' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='app' data-toggle='modal' data-target='#modalView' onclick='viewVou($auid,id);' class='btn btn-default btn-condensed' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled id='app' data-toggle='modal' onclick='vouPrint($auid);' class='btn btn-default btn-condensed $pr' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled id='app' data-toggle='modal' onclick='vouPrint($auid);' class='btn btn-default btn-condensed $rp' title='Reprint'><i class='fa fa-print' aria-hidden='true'></i></button>  " .
                    "<button type='button' disabled onclick='rejecVou($auid );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-close' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->vcrdt;
            $sub_arr[] = $row->vuno;
            $sub_arr[] = $row->pynm; // cust name
            $sub_arr[] = $md;
            $sub_arr[] = $row->tem_name;
            $sub_arr[] = number_format($row->vuam, 2, '.', ',');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_vou(),
            "recordsFiltered" => $this->User_model->count_filt_vou(),
            "data" => $data,
        );
        echo json_encode($output);

    }

    // voucher view
    function vewShopVou()
    {
        $vuid = $this->input->post('vuid');

        $this->db->select("voucher.*,DATE_FORMAT(voucher.crdt, '%Y-%m-%d') AS vcrdt,  brch_mas.brnm ,pay_terms.tem_name ,vouc_des.rfdc,vouc_des.amut ,
        vouc_des.rfco, bnk_accunt.acnm,bnk_accunt.acno,chq_issu.cqno ,accu_chrt.hadr, aa.acno AS cuac,aa.bknm,aa.bkbr");
        $this->db->from("voucher");
        $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void');
        $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp');
        $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco');
        $this->db->join('accu_chrt', 'accu_chrt.idfr = voucher.pyac');
        $this->db->join('chq_issu', 'chq_issu.vuid = voucher.void', 'left');
        $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid', 'left');
        $this->db->join("(SELECT aa.cuid,aa.bkbr,aa.acno, b.bknm
            FROM `cus_mas` AS aa  
            JOIN bnk_names AS b ON b.bkid=aa.bkid
            )AS aa ",
            'aa.cuid = voucher.clid', 'left'); //customer bank details

        $this->db->where('voucher.void', $vuid);
        //$this->db->group_by('vuno');
        $query = $this->db->get();
        $data['vudt'] = $query->result();


        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.lnpr,micr_crt.crdt,micr_crt.docg,micr_crt.incg,micr_crt.chmd,
        cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg, cen_mas.cnnm ,brch_mas.brcd,user_mas.fnme,prdt_typ.prtp  ,
        micr_crt.prva, ( SELECT blam  FROM `topup_loans` WHERE stat = 1 AND tpnm = lnid) AS tpbal,");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->where('micr_crt.stat IN(2,5)');
        $this->db->where('micr_crt.vpno', $vuid);
        $query = $this->db->get();
        $data['lndt'] = $query->result();

        $data['shpdt'] = $this->Generic_model->getData('shop_mas', '', array('spid' => $data['vudt'][0]->rfid, 'stat' => 1));


        echo json_encode($data);
    }

    // voucher approval
    function vouApprvlx()
    {
        $vuid = $this->input->post('vuid');
        $chk = 0;
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_ar1 = array(
            'stat' => 2,
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vuid));
        if ($result1) {
            $chk = $chk + 1;
        }

        $voudt = $this->Generic_model->getData('voucher', '', array('void' => $vuid));
        $accdt = $this->Generic_model->getData('accu_chrt', array('idfr', 'hadr'), array('idfr' => $voudt[0]->pyac));


        if ($voudt[0]->mode == 3) {         // IF GENERAL VOUCHER

            if ($voudt[0]->pmtp == 8) {     // CASH PAYMENT TYPE

                // ACCOUNT LEDGE
                $data_aclg1 = array(
                    'brno' => $voudt[0]->brco, // BRANCH ID
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'Voucher',
                    'trid' => 10,
                    'rfna' => $voudt[0]->vuno,
                    'dcrp' => 'Voucher payment ',
                    'acco' => 106,    // cross acc code
                    'spcd' => $voudt[0]->pyac,    // split acc code
                    'acst' => '(' . $voudt[0]->pyac . ') ' . $accdt[0]->hadr,
                    'dbam' => $voudt[0]->vuam,
                    'cram' => 0,
                    'stat' => 0
                );
                $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);
                if ($result) {
                    $chk = $chk + 1;
                }

                $data_aclg2 = array(
                    'brno' => $voudt[0]->brco, // BRANCH ID
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'Voucher',
                    'trid' => 10,
                    'rfna' => $voudt[0]->vuno,
                    'dcrp' => 'Voucher payment ',
                    'acco' => $voudt[0]->pyac,    // cross acc code
                    'spcd' => '106',    // split acc code
                    'acst' => '(106) Cash Book',
                    'dbam' => 0,
                    'cram' => $voudt[0]->vuam,
                    'stat' => 0
                );
                $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
                if ($re1) {
                    $chk = $chk + 1;
                }

            } else if ($voudt[0]->pmtp == 2 || $voudt[0]->pmtp == 3 || $voudt[0]->pmtp == 4) {  // BANK PAYMENT TYPE

                // ACCOUNT LEDGE
                $data_aclg1 = array(
                    'brno' => $voudt[0]->brco, // BRANCH ID
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'Voucher',
                    'trid' => 10,
                    'rfna' => $voudt[0]->vuno,
                    'dcrp' => 'vouc chk approval ',
                    'acco' => 209,    // cross acc code
                    'spcd' => $voudt[0]->pyac,    // split acc code
                    'acst' => '(' . $voudt[0]->pyac . ') ' . $accdt[0]->hadr,
                    'dbam' => $voudt[0]->vuam,
                    'cram' => 0,
                    'stat' => 0
                );
                $result = $this->Generic_model->insertData('acc_leg', $data_aclg1);
                if ($result) {
                    $chk = $chk + 1;
                }

                $data_aclg2 = array(
                    'brno' => $voudt[0]->brco, // BRANCH ID
                    'acdt' => date('Y-m-d H:i:s'),
                    'trtp' => 'Voucher',
                    'trid' => 10,
                    'rfna' => $voudt[0]->vuno,
                    'dcrp' => 'vouc chk approval ',
                    'acco' => $voudt[0]->pyac,    // cross acc code
                    'spcd' => '209',    // split acc code
                    'acst' => '(209) payable payment',
                    'dbam' => 0,
                    'cram' => $voudt[0]->vuam,
                    'stat' => 0
                );
                $re1 = $this->Generic_model->insertData('acc_leg', $data_aclg2);
                if ($re1) {
                    $chk = $chk + 1;
                }

            } else {
            }
        } else {
            $chk = $chk + 2;
        }
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'voucher approval ');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }

    // IN CASH GROUP VOUCHER PRINT
    function vouPrintx($vuid)
    {
        $rcdt = $this->Generic_model->getData('voucher', array('pntc'), array('void' => $vuid));
        $pntc = $rcdt[0]->pntc + 1;

        // PRINT COUNT UPDATE VOUCHER TB
        $data_ar1 = array(
            'prby' => $_SESSION['userId'],
            'prdt' => date('Y-m-d H:i:s'),
            'pntc' => $pntc,
        );
        $result1 = $this->Generic_model->updateData('voucher', $data_ar1, array('void' => $vuid));

        $lndt = $this->Generic_model->getData('micr_crt', array('lnid', 'vpno', 'stat'), array('vpno' => $vuid));
        $siz = sizeof($lndt);
        $a = 0;

        // MICRO CART UPDATED GROUP VU NO
        if ($siz > 0) {
            for ($i = 0; $i < $siz; $i++) {
                $data_ar1 = array(
                    'vupd' => 1,
                    'vpdt' => date('Y-m-d H:i:s'),
                );
                $this->Generic_model->updateData('micr_crt', $data_ar1, array('lnid' => $lndt[$i]->lnid));
                $a = $a + 1;
            }
        }

        // VOUCHER PDF GENARATED
        if (count($result1) > 0 && $a == $siz) {

            $this->load->library('ciqrcode');
            $this->db->select("voucher.*,vouc_des.rfdc,brch_mas.brnm,user_mas.fnme,pay_terms.dsnm, CONCAT(accu_chrt.idfr,' (',accu_chrt.hadr,')') AS acc ,
                                bnk_accunt.acnm,bnk_accunt.acno,chq_issu.cqno ,aa.acno AS cuac,aa.bknm,aa.bkbr ");
            $this->db->from("voucher");
            $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco ');
            $this->db->join('user_mas', 'user_mas.auid = voucher.crby ');
            $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void ');
            $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp ');
            $this->db->join('accu_chrt', 'accu_chrt.idfr = voucher.pyac', 'left');

            $this->db->join('chq_issu', 'chq_issu.vuid = voucher.void', 'left');
            $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid', 'left');
            $this->db->join("(SELECT aa.cuid,aa.bkbr,aa.acno, b.bknm
            FROM `cus_mas` AS aa  
            JOIN bnk_names AS b ON b.bkid=aa.bkid
            )AS aa ",
                'aa.cuid = voucher.clid', 'left'); //customer bank details


            $this->db->where('voucher.void', $vuid);
            $this->db->group_by('vuno');

            $query = $this->db->get();
            $data = $query->result();

            $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
            $usr = $usedetails[0]->fnme;

            $comdt = $this->Generic_model->getData('com_det', array('cmne'), array('stat' => 1));
            $branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brco));

            $_SESSION['hid'] = mt_rand(10000000, 999999999);
            $cy = date('Y');
            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf->AddPage('L', 'A5');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, 'GROUP VOUCHER PAYMENT ', 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $branc[0]->brad);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, "Tel : " . $branc[0]->brtp);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, "Fax : " . $branc[0]->brfx);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, "E-mail : " . $branc[0]->brem);
            $this->pdf->SetXY(5.5, 30);
            $this->pdf->Cell(0, 0, "Web : " . $branc[0]->brwb);

            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 8);

            $this->pdf->SetXY(16, 45);
            $this->pdf->Cell(1, 0, 'PAYEE NAME : ' . $data[0]->pynm, 0, 1, 'L');
            /*$this->pdf->SetFont('Helvetica', '', 8);*/
            $this->pdf->SetXY(16, 49);
            $this->pdf->Cell(1, 0, 'PAY TYPE : ' . $data[0]->dsnm, 0, 1, 'L');
            $this->pdf->SetXY(16, 53);

            if ($data[0]->pmtp == 2 || $data[0]->pmtp == 10) {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . $data[0]->acnm . '(' . $data[0]->acno . ') Chq no ' . $data[0]->cqno, 0, 1, 'L');

            } else if ($data[0]->pmtp == 3 || $data[0]->pmtp == 4) {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . $data[0]->bknm . '(' . $data[0]->bkbr . ' Branch) Acc no ' . $data[0]->cuac, 0, 1, 'L');

            } else {
                $this->pdf->Cell(1, 0, 'BANK DETAILS   : ' . '-', 0, 1, 'L');
            }

            /*if (response['vudt'][i]['pmtp'] == '2') {
                document.getElementById("bkdt").innerHTML = response['vudt'][i]['acnm'] + '  (' + response['vudt'][i]['acno'] + ')<br>'
                    + 'Chq No ' + response['vudt'][i]['cqno'];
            } else {
                document.getElementById("bkdt").innerHTML = '-';
            }*/

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(135, 45);
            $this->pdf->Cell(1, 0, 'VOUCHER NO', 0, 1, 'L');
            $this->pdf->SetXY(135, 49);
            $this->pdf->Cell(1, 0, 'VOUCHER DATE : ' . $data[0]->crdt, 0, 1, 'L');
            $this->pdf->SetXY(135, 53);
            $this->pdf->Cell(1, 0, 'BRANCH', 0, 1, 'L');
            $this->pdf->SetXY(158.5, 45);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->vuno, 0, 1, 'L');
            $this->pdf->SetXY(158.5, 53);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->brnm, 0, 1, 'L');


            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(15, 37);
            $this->pdf->Cell(180, 30, '', '1');

            // Payment details table border
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(15, 50, '', '1');
            $this->pdf->SetXY(30, 60);
            $this->pdf->Cell(70, 50, '', '1');
            $this->pdf->SetXY(100, 60);
            $this->pdf->Cell(70, 50, '', '1');

            $this->pdf->SetXY(170, 60);
            $this->pdf->Cell(25, 50, '', '1');

            // #0
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(15, 7, 'BILL NO', 1, 1, 'C');
            $this->pdf->SetXY(30, 60);
            $this->pdf->Cell(70, 7, 'PAYMENT DESCRIPTION', 1, 1, 'C');
            $this->pdf->SetXY(100, 60);
            $this->pdf->Cell(70, 7, 'ACCOUNT NAME', 1, 1, 'C');
            $this->pdf->SetXY(170, 60);
            $this->pdf->Cell(25, 7, 'AMOUNT', 1, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($data);

            $y = 70;
            $pyamt = 0;
            for ($i = 0; $i < $len; $i++) {
                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(15, 0, $i + 1, '0', '', 'C');
                $this->pdf->SetXY(30, $y);
                $this->pdf->Cell(70, 0, $data[$i]->rfdc, '0');
                $this->pdf->SetXY(100, $y);
                $this->pdf->Cell(70, 0, $data[$i]->acc, 'C');
                $this->pdf->SetXY(170, $y);
                $this->pdf->Cell(25, 0, number_format($data[$i]->vuam, 2, '.', ','), '0', '', 'R');
                $y = $y + 5;
                $pyamt = $pyamt + $data[$i]->vuam;
            }


            //-----TOTAL AMOUNT--------//
            $this->pdf->SetXY(170, 110);
            $this->pdf->Cell(25, 8, '', '1');
            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(154, 110);
            $this->pdf->Cell(6, 10, 'TOTAL AMOUNT', 0, 1, 'R');
            $this->pdf->SetXY(170, 114);
            $this->pdf->Cell(25, 0, number_format($pyamt, 2, '.', ','), '0', '', 'R');
            $this->pdf->SetAutoPageBreak(false);


            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(5, 121);
            $this->pdf->Cell(0, 0, 'Prepared By : ' . $data[0]->fnme . ' | ' . $data[0]->crdt);
            $this->pdf->SetXY(5, 128);
            $this->pdf->Cell(0, 0, 'Approved By      : .....................................');
            $this->pdf->SetXY(75, 121);
            $this->pdf->Cell(0, 0, 'NIC / Passport   : ....................................');
            $this->pdf->SetXY(75, 128);
            $this->pdf->Cell(0, 0, 'Received By      : .......................................');
            $this->pdf->SetXY(75, 135);
            $this->pdf->Cell(0, 0, 'Signature        : .......................................');

            //FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 135);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 140);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 140);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');

            // REPRINT TAG
            $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
            if ($policy[0]->post == 1) {
                if ($rcdt[0]->pntc > 1) {
                    $this->pdf->SetFont('Helvetica', 'B', 7);
                    $this->pdf->SetXY(4, 140);
                    $this->pdf->Cell(0, 0, 'REPRINTED (' . $pntc . ')');
                }
            }

            //QR CODE
            $cd = 'Vou No : ' . $data[0]->vuno . ' | Date : ' . $data[0]->crdt . ' | Payee Name : ' . $data[0]->pynm . ' | Branch : ' . $data[0]->brnm . ' | Pay Type : ' . $data[0]->dsnm . ' | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('Group Voucher - ' . $data[0]->vuno);
            $this->pdf->Output('Group_voucher _' . $data[0]->vuno . '.pdf', 'I');
            ob_end_flush();

        } else {
            echo json_encode(false);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Group voucher print vuno(' . $data[0]->vuno . ')');
    }


}
