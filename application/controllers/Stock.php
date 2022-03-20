<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
        $this->output->delete_cache();

        $this->load->model('Generic_model', '', TRUE);  // load model
        $this->load->model('Stock_model', '', TRUE);    // load model
        //$this->load->model('Admin_model', '', TRUE);  // load model
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
// SUPPLY MANAGEMENT
    function sply_mng()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('sply_mng');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $data['bankinfo'] = $this->Generic_model->getSortData('bnk_names', '', "bkid != 1", '', '', 'bknm', 'asc');

        $this->load->view('modules/stock/supply_managmnt', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
    }

    function srchSupply()
    {
        //$ctgr = $this->input->post('ctgr');
        //$stat = $this->input->post('stat');

        $funcPerm = $this->Generic_model->getFuncPermision('sply_mng');

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

        $result = $this->Stock_model->get_supply();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $itid = $row->spid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewSpply($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtSpply($itid,this.id);' class='btn  btn-sm btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app  data-toggle='modal' data-target='#modalEdt'  onclick='edtSpply($itid,this.id);' class='btn  btn-sm btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  onclick='rejecSppy($itid);' class='btn  btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewSpply($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtSpply();' class='btn  btn-sm btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtSpply();' class='btn  btn-sm btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecSppy($itid);' class='btn btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {            // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='edtMdel($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtSpply();' class='btn  btn-sm btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtSpply();' class='btn  btn-sm btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvSppy($itid);' class='btn btn-default btn-sm btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->spcd;
            $sub_arr[] = $row->spnm;
            $sub_arr[] = $row->addr;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->exe;
            $sub_arr[] = date_format(date_create($row->crdt), 'Y-m-d'); //  date('Y-m-d');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->all_supply(),
            "recordsFiltered" => $this->Stock_model->filtered_supply(),
            "data" => $data,
        );
        echo json_encode($output);

    }

    // ALREADY NAME CHECK
    function chk_supply()
    {
        $spnm = $this->input->post('spnm');
        $result = $this->Generic_model->getData('stck_supply', array('spid', 'spnm'), array('spnm' => $spnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY NAME CHECK
    function chk_supply_edit()
    {

        $auid = $this->input->post('auid');
        $spnm = $this->input->post('spnm');

        $result = $this->Generic_model->getData('stck_supply', array('spid', 'spnm'), array('spnm' => $spnm));
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
    function addSupply()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->db->select("spcd");
        $this->db->from("stck_supply");
        $this->db->order_by('spid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $spcd = 'S-001';  // Ex S-001

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
            $spcd = 'S-' . $xx;
        }

        $data_arr = array(
            'spcd' => $spcd,
            'spnm' => strtoupper($this->input->post('spnm')),
            'addr' => $this->input->post('addr'),
            'mobi' => $this->input->post('mobi'),
            'tele' => $this->input->post('tele'),
            'emil' => $this->input->post('emil'),
            'bkid' => $this->input->post('bknm'),
            'brnm' => $this->input->post('brnm'),
            'bkac' => $this->input->post('bkac'),
            'dscr' => $this->input->post('remk'),

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('stck_supply', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('sply_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New HP Supply (' . $spcd . ')');
    }

    function vewSupply()
    {
        $auid = $this->input->post('auid');
        //$result = $this->Generic_model->getData('stck_supply', '', array('spid' => $auid));

        $this->db->select("stck_supply.*, bnk_names.bknm");
        $this->db->from("stck_supply");
        $this->db->join('bnk_names', 'bnk_names.bkid = stck_supply.bkid', 'left');
        $this->db->where('stck_supply.spid', $auid);

        $query = $this->db->get();
        $result = $query->result();
        echo json_encode($result);
    }

    // UPDATE MODEL
    function edtSupply()
    {
        $auid = $this->input->post('auid');
        $func = $this->input->post('func');

        // EDIT
        if ($func == 1) {

            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr = array(

                'spnm' => strtoupper($this->input->post('spnmEdt')),
                'addr' => $this->input->post('addrEdt'),
                'mobi' => $this->input->post('mobiEdt'),
                'tele' => $this->input->post('teleEdt'),
                'emil' => $this->input->post('emilEdt'),
                'bkid' => $this->input->post('bknmEdt'),
                'brnm' => $this->input->post('brnmEdt'),
                'bkac' => $this->input->post('bkacEdt'),
                'dscr' => $this->input->post('remkEdt'),

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'spid' => $auid
            );
            $result22 = $this->Generic_model->updateData('stck_supply', $data_arr, $where_arr);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('sply_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Supply Update id(' . $auid . ')');

        } else {       // APPROVAL

            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr = array(

                'spnm' => strtoupper($this->input->post('spnmEdt')),
                'addr' => $this->input->post('addrEdt'),
                'mobi' => $this->input->post('mobiEdt'),
                'tele' => $this->input->post('teleEdt'),
                'emil' => $this->input->post('emilEdt'),
                'bkid' => $this->input->post('bkidEdt'),
                'brnm' => $this->input->post('brnmEdt'),
                'bkac' => $this->input->post('bkacEdt'),
                'dscr' => $this->input->post('remkEdt'),

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'spid' => $auid
            );
            $result22 = $this->Generic_model->updateData('stck_supply', $data_arr, $where_arr);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('sply_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Supply Approval id(' . $auid . ')');

        }
    }

    // REJECT MODEL
    function rejSupply()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_supply', array('stat' => 2), array('spid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('sply_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Supply Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE MODEL
    function reactSupply()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_supply', array('stat' => 1), array('spid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('sply_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Supply Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END SUPPLY
//
// WARE HOUSE MANAGEMENT
    function ware_house()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('ware_house');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $data['bankinfo'] = $this->Generic_model->getSortData('bnk_names', '', "bkid != 1", '', '', 'bknm', 'asc');

        $this->load->view('modules/stock/warehouse_managmnt', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
    }

    function srchWarehouse()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('ware_house');

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


        $result = $this->Stock_model->get_warehouse();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $itid = $row->whid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewWarHuse($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtWarHuse($itid,this.id);' class='btn  btn-sm btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app  data-toggle='modal' data-target='#modalEdt'  onclick='edtWarHuse($itid,this.id);' class='btn  btn-sm btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  onclick='rejecWarHuse($itid);' class='btn btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewWarHuse($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtWarHuse();' class='btn btn-sm  btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtWarHuse();' class='btn btn-sm  btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecWarHuse($itid);' class='btn btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {            // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='edtMdel($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtWarHuse();' class='btn  btn-sm btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtWarHuse();' class='btn  btn-sm btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvWarHuse($itid);' class='btn btn-sm btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->whcd;
            $sub_arr[] = $row->whnm;
            $sub_arr[] = $row->addr;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->exe;
            $sub_arr[] = date_format(date_create($row->crdt), 'Y-m-d');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->all_warehouse(),
            "recordsFiltered" => $this->Stock_model->filtered_warehouse(),
            "data" => $data,
        );
        echo json_encode($output);

    }

    // ALREADY NAME CHECK
    function chk_warehouse()
    {
        $whnm = $this->input->post('whnm');
        $result = $this->Generic_model->getData('stck_warehouse', array('whid', 'whnm'), array('whnm' => $whnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY NAME CHECK
    function chk_warehouse_edit()
    {
        $auid = $this->input->post('auid');
        $whnm = $this->input->post('whnm');

        $result = $this->Generic_model->getData('stck_warehouse', array('whid', 'whnm'), array('whnm' => $whnm));
        if (count($result) > 0) {
            if ($result[0]->whid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // MODEL ADD
    function addWarehouse()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->db->select("whcd");
        $this->db->from("stck_warehouse");
        $this->db->order_by('whid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $whcd = 'WH-001';  // Ex WH-001

        } else {
            $spc = $data[0]->whcd;
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
            $whcd = 'WH-' . $xx;
        }

        $data_arr = array(
            'whcd' => $whcd,
            'whnm' => strtoupper($this->input->post('whnm')),
            'addr' => ucwords(strtolower($this->input->post('addr'))),
            'mobi' => $this->input->post('mobi'),
            'tele' => $this->input->post('tele'),
            'emil' => $this->input->post('emil'),
            'dscr' => $this->input->post('remk'),

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('stck_warehouse', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('ware_house');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New HP Warehouse (' . $whcd . ')');
    }

    function vewWarehouse()
    {
        $auid = $this->input->post('auid');
        $this->db->select("stck_warehouse.*");
        $this->db->from("stck_warehouse");
        $this->db->where('stck_warehouse.whid', $auid);

        $query = $this->db->get();
        $result = $query->result();
        echo json_encode($result);
    }

    // UPDATE MODEL
    function edtWarehouse()
    {
        $auid = $this->input->post('auid');
        $func = $this->input->post('func');

        // EDIT
        if ($func == 1) {

            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr = array(

                'whnm' => strtoupper($this->input->post('whnmEdt')),
                'addr' => $this->input->post('addrEdt'),
                'mobi' => $this->input->post('mobiEdt'),
                'tele' => $this->input->post('teleEdt'),
                'emil' => $this->input->post('emilEdt'),
                'dscr' => $this->input->post('remkEdt'),

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'whid' => $auid
            );
            $result22 = $this->Generic_model->updateData('stck_warehouse', $data_arr, $where_arr);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('ware_house');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Warehouse Update id(' . $auid . ')');

        } else {       // APPROVAL

            $this->db->trans_begin(); // SQL TRANSACTION START
            $data_arr = array(

                'whnm' => strtoupper($this->input->post('whnmEdt')),
                'addr' => $this->input->post('addrEdt'),
                'mobi' => $this->input->post('mobiEdt'),
                'tele' => $this->input->post('teleEdt'),
                'emil' => $this->input->post('emilEdt'),
                'dscr' => $this->input->post('remkEdt'),

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'whid' => $auid
            );
            $result22 = $this->Generic_model->updateData('stck_warehouse', $data_arr, $where_arr);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('ware_house');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Warehouse Approval id(' . $auid . ')');

        }
    }

    // REJECT MODEL
    function rejWarHouse()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_warehouse', array('stat' => 2), array('whid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('ware_house');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Warehouse Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE MODEL
    function reactWarHouse()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_warehouse', array('stat' => 1), array('whid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('ware_house');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Warehouse Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END WARE HOUSE
//
// CATEGORY
    public function cate_mng()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);
        $this->load->view('modules/stock/category_managmnt');

        //$this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/footer');
    }

    function srchCategory()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cate_mng');

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

        $stat = $this->input->post('stat');

        $this->db->select("stck_category.*,CONCAT(user_mas.usnm) AS exe");
        $this->db->from("stck_category");
        $this->db->join('user_mas', 'user_mas.auid = stck_category.crby');
        if ($stat != 'all') {
            $this->db->where("stck_category.stat", $stat);
        }

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '1') {  // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtLvl($row->ctid);' class='btn  btn-sm btn-default btn-condensed' title='Contact System Admin' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecCategry($row->ctid);' class='btn btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '2') {  // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLvl(id);' class='btn  btn-sm btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvCatery($row->ctid);' class='btn btn-sm btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->ctnm;
            $sub_arr[] = $row->exe;
            $sub_arr[] = date_format(date_create($row->crdt), 'Y-m-d');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // ALREADY CATEGORY NAME CHECK
    function chk_ctnm()
    {
        $ctnm = $this->input->post('ctnm');
        $result = $this->Generic_model->getData('stck_category', array('ctid', 'ctnm'), array('ctnm' => $ctnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY CATEGORY NAME CHECK
    function chk_ctnm_edt()
    {
        $lvnm = $this->input->post('ctnm_edt');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('stck_category', array('ctid', 'ctnm'), array('ctnm' => $lvnm));
        if (count($result) > 0) {
            if ($result[0]->ctid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // CATEGORY ADD
    function addCategory()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_arr = array(
            'ctnm' => strtoupper($this->input->post('ctnm')), // strtoupper($this->input->post('synm')),
            'remk' => $this->input->post('remk'),
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('stck_category', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('cate_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New HP Category (' . $this->input->post('ctnm') . ')');
    }

    function vewCategory()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('stck_category', '', array('ctid' => $auid));
        echo json_encode($result);
    }

    // UPDATE CATEGORY
    function edtCategory()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_ar1 = array(
            'ctnm' => strtoupper($this->input->post('ctnm_edt')),
            'remk' => $this->input->post('remk_edt'),
            'mdby' => $_SESSION['userId'],
            'modt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'ctid' => $this->input->post('auid')
        );

        $result22 = $this->Generic_model->updateData('stck_category', $data_ar1, $where_arr);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('cate_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Category Update id(' . $this->input->post('auid'));
    }

    // REJECT CATEGORY
    function rejCategry()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_category', array('stat' => 2), array('ctid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('cate_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Category Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE CATEGORY
    function reactCategry()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_category', array('stat' => 1), array('ctid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('cate_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Category Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END CATEGORY
//
// MODEL MANAGEMENT
    function mdl_mng()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('mdl_mng');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $data['ctgryinfo'] = $this->Generic_model->getSortData('stck_category', array('ctid', 'ctnm'), array('stat' => 1), '', '', 'ctnm', 'asc');

        $this->load->view('modules/stock/model_managmnt', $data);
        $this->load->view('modules/common/footer');
        //$this->load->view('modules/common/cus_script_full_width');
    }

    function srchModel()
    {
        $ctgr = $this->input->post('ctgr');
        $stat = $this->input->post('stat');

        $funcPerm = $this->Generic_model->getFuncPermision('mdl_mng');

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

        $this->db->select("stck_model.*,CONCAT(user_mas.usnm) AS exe, stck_category.ctnm");
        $this->db->from("stck_model");
        $this->db->join('user_mas', 'user_mas.auid = stck_model.crby');
        $this->db->join('stck_category', 'stck_category.ctid = stck_model.ctid');
        if ($ctgr != 'all') {
            $this->db->where('stck_model.ctid', $ctgr);
        }
        if ($stat != 'all') {
            $this->db->where('stck_model.stat', $stat);
        }
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtMdel($row->mdid);' class='btn btn-sm btn-default btn-condensed' title='Contact System Admin' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecModel($row->mdid);' class='btn btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {    // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLvl(id);' class='btn  btn-sm btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvModel($row->mdid);' class='btn  btn-sm btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->ctnm;
            $sub_arr[] = $row->mdnm;
            $sub_arr[] = $row->exe;
            $sub_arr[] = date_format(date_create($row->crdt), 'Y-m-d');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // ALREADY MODEL NAME CHECK
    function chk_mdnm()
    {
        $mdnm = $this->input->post('mdnm');
        $result = $this->Generic_model->getData('stck_model', array('mdid', 'ctid', 'mdnm'), array('mdnm' => $mdnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY CATEGORY NAME CHECK
    function chk_mdnm_edt()
    {
        $mdnm = $this->input->post('mdnm');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('stck_model', array('mdid', 'ctid', 'mdnm'), array('mdnm' => $mdnm));
        if (count($result) > 0) {
            if ($result[0]->mdid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // MODEL ADD
    function addModel()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_arr = array(
            'ctid' => $this->input->post('ctnm'),
            'mdnm' => strtoupper($this->input->post('mdnm')), // strtoupper($this->input->post('synm')),
            'remk' => $this->input->post('remk'),
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('stck_model', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('mdl_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New HP Model (' . $this->input->post('mdnm') . ')');
    }

    function vewModel()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('stck_model', '', array('mdid' => $auid));
        echo json_encode($result);
    }

    // UPDATE MODEL
    function edtModel()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_ar1 = array(
            'ctid' => $this->input->post('ctnmEdt'),
            'mdnm' => strtoupper($this->input->post('mdnmEdt')),
            'remk' => $this->input->post('remkEdt'),
            'mdby' => $_SESSION['userId'],
            'modt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'mdid' => $this->input->post('auid')
        );

        $result22 = $this->Generic_model->updateData('stck_model', $data_ar1, $where_arr);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('mdl_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Model Update id(' . $this->input->post('auid'));
    }

    // REJECT MODEL
    function rejModel()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_model', array('stat' => 2), array('mdid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('mdl_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Model Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE MODEL
    function reactModel()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_model', array('stat' => 1), array('mdid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('mdl_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Model Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END MODEL
//
// BRAND MANAGEMENT
    function brnd_mng()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('brnd_mng');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $data['ctgryinfo'] = $this->Generic_model->getSortData('stck_category', array('ctid', 'ctnm'), array('stat' => 1), '', '', 'ctnm', 'asc');

        $this->load->view('modules/stock/brands_managmnt', $data);
        $this->load->view('modules/common/footer');
        // $this->load->view('modules/common/cus_script_full_width');
    }

    function srchBrands()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('brnd_mng');

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

        $this->db->select("stck_brands.*,CONCAT(user_mas.usnm) AS exe ");
        $this->db->from("stck_brands");
        $this->db->join('user_mas', 'user_mas.auid = stck_brands.crby');
        //$this->db->join('stck_category', 'stck_category.ctid = stck_model.ctid');

        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtBrnd($row->brid);' class='btn btn-sm btn-default btn-condensed' title='Contact System Admin' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecBrnd($row->brid);' class='btn btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {    // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLvl(id);' class='btn  btn-sm btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvBrnd($row->brid);' class='btn btn-sm btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->exe;
            $sub_arr[] = date_format(date_create($row->crdt), 'Y-m-d');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // ALREADY BRAND NAME CHECK
    function chk_brnm()
    {
        $brnm = $this->input->post('brnm');
        $result = $this->Generic_model->getData('stck_brands', array('brid', 'brnm'), array('brnm' => $brnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY BRAND NAME CHECK
    function chk_brnm_edt()
    {
        $brnm = $this->input->post('brnm');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('stck_brands', array('brid', 'brnm'), array('brnm' => $brnm));
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

    // MODEL ADD
    function addBrands()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_arr = array(
            'brnm' => strtoupper($this->input->post('brnm')), // strtoupper($this->input->post('synm')),
            'remk' => $this->input->post('remk'),
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('stck_brands', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('brnd_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New HP Brands (' . $this->input->post('brnm') . ')');
    }

    function vewBrand()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('stck_brands', '', array('brid' => $auid));
        echo json_encode($result);
    }

    // UPDATE MODEL
    function edtBrand()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_ar1 = array(
            'brnm' => strtoupper($this->input->post('brnm_edt')),
            'remk' => $this->input->post('remkEdt'),
            'mdby' => $_SESSION['userId'],
            'modt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'brid' => $this->input->post('auid')
        );

        $result22 = $this->Generic_model->updateData('stck_brands', $data_ar1, $where_arr);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('brnd_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Brand Update id(' . $this->input->post('auid') . ')');
    }

    // REJECT MODEL
    function rejBrand()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_brands', array('stat' => 2), array('brid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('brnd_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Brand Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE MODEL
    function reactBrand()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_brands', array('stat' => 1), array('brid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('brnd_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Brand Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END BRAND
//
// TYPE MANAGEMENT
    function type_mng()
    {
        $data['funcPerm'] = $this->Generic_model->getFuncPermision('type_mng');
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/includes/admin_header', $per);

        $data['ctgryinfo'] = $this->Generic_model->getSortData('stck_category', array('ctid', 'ctnm'), array('stat' => 1), '', '', 'ctnm', 'asc');

        $this->load->view('modules/stock/type_managmnt', $data);
        $this->load->view('modules/common/footer');
        //$this->load->view('modules/common/cus_script_full_width');
        //$this->load->view('modules/common/custom_js_common');
    }

    function srchType()
    {
        $ctgr = $this->input->post('ctgr');
        $stat = $this->input->post('stat');

        $funcPerm = $this->Generic_model->getFuncPermision('type_mng');

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

        $this->db->select("stck_type.*,CONCAT(user_mas.usnm) AS exe, stck_category.ctnm");
        $this->db->from("stck_type");
        $this->db->join('user_mas', 'user_mas.auid = stck_type.crby');
        $this->db->join('stck_category', 'stck_category.ctid = stck_type.ctid');
        if ($ctgr != 'all') {
            $this->db->where('stck_type.ctid', $ctgr);
        }
        if ($stat != 'all') {
            $this->db->where('stck_type.stat', $stat);
        }
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;
        foreach ($result as $row) {
            $st = $row->stat;

            if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option = "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtType($row->tpid);' class='btn btn-sm btn-default btn-condensed' title='Contact System Admin' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecTyp($row->tpid);' class='btn btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {    // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option = "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtLvl(id);' class='btn  btn-sm btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvTyp($row->tpid);' class='btn btn-sm btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->ctnm;
            $sub_arr[] = $row->tpnm;
            $sub_arr[] = $row->exe;
            $sub_arr[] = date_format(date_create($row->crdt), 'Y-m-d');
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array("data" => $data);
        echo json_encode($output);
    }

    // ALREADY  NAME CHECK
    function chk_tpnm()
    {
        $mdnm = $this->input->post('tpnm');
        $ctid = $this->input->post('ctnm');
        $result = $this->Generic_model->getData('stck_type', array('tpid', 'ctid', 'tpnm'), array('ctid' => $ctid, 'tpnm' => $mdnm));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY NAME CHECK
    function chk_tpnm_edt()
    {
        $mdnm = $this->input->post('tpnm');
        $ctid = $this->input->post('ctnm');
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('stck_type', array('tpid', 'ctid', 'tpnm'), array('ctid' => $ctid, 'tpnm' => $mdnm));
        if (count($result) > 0) {
            if ($result[0]->tpid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // MODEL ADD
    function addType()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_arr = array(
            'ctid' => $this->input->post('ctnm'),
            'tpnm' => strtoupper($this->input->post('tpnm')), // strtoupper($this->input->post('synm')),
            'remk' => $this->input->post('remk'),
            'stat' => 1,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('stck_type', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('type_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New HP Type (' . $this->input->post('mdnm') . ')');
    }

    function vewType()
    {
        $auid = $this->input->post('auid');
        $result = $this->Generic_model->getData('stck_type', '', array('tpid' => $auid));
        echo json_encode($result);
    }

    // UPDATE MODEL
    function edtType()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_ar1 = array(
            'ctid' => $this->input->post('ctnmEdt'),
            'tpnm' => strtoupper($this->input->post('tpnmEdt')),
            'remk' => $this->input->post('remkEdt'),
            'mdby' => $_SESSION['userId'],
            'modt' => date('Y-m-d H:i:s')
        );
        $where_arr = array(
            'tpid' => $this->input->post('auid')
        );

        $result22 = $this->Generic_model->updateData('stck_type', $data_ar1, $where_arr);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('type_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Type Update id(' . $this->input->post('auid'));
    }

    // REJECT MODEL
    function rejType()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_type', array('stat' => 2), array('tpid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('type_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Type Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE MODEL
    function reactType()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_type', array('stat' => 1), array('tpid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('type_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Type Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END TYPE
//
// ITEM MANAGEMENT
    function item_mng()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $data['ctgryinfo'] = $this->Generic_model->getSortData('stck_category', array('ctid', 'ctnm'), array('stat' => 1), '', '', 'ctnm', 'asc');   // CATEGORY
        $data['brndinfo'] = $this->Generic_model->getSortData('stck_brands', array('brid', 'brnm'), array('stat' => 1), '', '', 'brnm', 'asc');      // BRAND
        $data['modelinfo'] = $this->Generic_model->getSortData('stck_model', array('mdid', 'mdnm'), array('stat' => 1), '', '', 'mdnm', 'asc');      // MODEL
        $data['wrntyinfo'] = $this->Generic_model->getSortData('stck_wrnty_perid', array('wrid', 'wrds'), array('stat' => 1), '', '', 'wrid', 'asc');      // WARRANTY PERIOD

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('item_mng');
        $this->load->view('modules/stock/item_managmnt', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        //$this->load->view('modules/common/custom_js_common');
    }

    function srchItem()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('item_mng');

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

        $result = $this->Stock_model->get_hireItem();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $itid = $row->itid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewItem($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtItem($itid,this.id);' class='btn  btn-sm btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app  data-toggle='modal' data-target='#modalEdt'  onclick='edtItem($itid,this.id);' class='btn  btn-sm btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  onclick='rejecItem($itid);' class='btn  btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewItem($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtItem();' class='btn  btn-sm btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtItem();' class='btn  btn-sm btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' " . $rej . "  onclick='rejecItem($itid);' class='btn btn-sm btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {            // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='edtMdel($itid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtMdel();' class='btn  btn-sm btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtMdel();' class='btn  btn-sm btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='reactvItem($itid);' class='btn btn-sm btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->icde;
            $sub_arr[] = $row->ctnm;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->mdnm;
            $sub_arr[] = $row->tpnm;
            $sub_arr[] = $row->itcd;
            $sub_arr[] = $row->itnm;

            $sub_arr[] = $row->exc;
            //$sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_hireItem(),
            "recordsFiltered" => $this->Stock_model->count_filtered_hireItem(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // GET SUB CATEGORY DATA
    function getSubCat()
    {
        $mdnm = $this->input->post('id');

        $this->db->select("mdid,mdnm");
        $this->db->from("stck_model");
        if ($mdnm != 'all') {
            $this->db->where('stck_model.ctid ', $mdnm);
        }
        $this->db->where('stck_model.stat', 1);
        $this->db->order_by('stck_model.mdnm', 'asc');
        $query = $this->db->get();
        $data['mdle'] = $query->result();

        $this->db->select("tpid,tpnm");
        $this->db->from("stck_type");
        if ($mdnm != 'all') {
            $this->db->where('stck_type.ctid ', $mdnm);
        }
        $this->db->where('stck_type.stat', 1);
        $this->db->order_by('stck_type.tpnm', 'asc');
        $query = $this->db->get();
        $data['type'] = $query->result();

        echo json_encode($data);
    }

    // ALREADY CODE CHECK
    function chk_itmcode()
    {
        $ctid = $this->input->post('ctgr');
        $itcd = $this->input->post('itcd');

        $result = $this->Generic_model->getData('stck_item', array('itid', 'ctid', 'itcd'), array('ctid' => $ctid, 'itcd' => $itcd));
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY CATEGORY NAME CHECK
    function chk_itmcode_edt()
    {
        $ctid = $this->input->post('ctgr');
        $itcd = $this->input->post('itcd');
        $auid = $this->input->post('auid');

        $result = $this->Generic_model->getData('stck_item', array('itid', 'ctid', 'itcd'), array('ctid' => $ctid, 'itcd' => $itcd));
        if (count($result) > 0) {
            if ($result[0]->itid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // ALREADY CHECK PUBLIC CODE
    function chk_pubcode()
    {
        //$ctid = $this->input->post('ctgr');
        $pbcd = $this->input->post('pbcd');

        $result = $this->Generic_model->getData('stck_item', array('itid', 'ctid', 'pbcd'), array('pbcd' => $pbcd)); // 'ctid' => $ctid,
        if (count($result) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // EDIT ALREADY CATEGORY NAME CHECK
    function chk_pubcode_edt()
    {
        //$ctid = $this->input->post('ctgr'); // 'ctid' => $ctid,
        $pbcd = $this->input->post('pbcd');
        $auid = $this->input->post('auid');

        $result = $this->Generic_model->getData('stck_item', array('itid', 'ctid', 'pbcd'), array('pbcd' => $pbcd));
        if (count($result) > 0) {
            if ($result[0]->itid == $auid) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    // MODEL ADD
    function additem()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->db->select("icde");
        $this->db->from("stck_item");
        //$this->db->where('dndt ', $dndt);
        $this->db->order_by('icde', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        if (count($data) == '0') {
            $itno = '00001';  // Ex I-00001
        } else {
            $aa = $data[0]->icde + 1;
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
            $itno = $xx;
        }

        $data_arr = array(
            'icde' => $itno,
            'sttp' => $this->input->post('sttp'),
            'ctid' => $this->input->post('ctgr'),
            'brid' => $this->input->post('brnd'),
            'mdid' => $this->input->post('modl'),
            'tpid' => $this->input->post('type'),
            'itnm' => strtoupper($this->input->post('itnm')),
            'itcd' => strtoupper($this->input->post('itcd')),
            'pbcd' => strtoupper($this->input->post('pbcd')),
            'dscr' => $this->input->post('remk'),

            'ifwr' => $this->input->post('wrtp'),
            'wrtp' => $this->input->post('wrmd'),
            'pird' => $this->input->post('wrpr'),

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('stck_item', $data_arr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('item_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Stock Item (' . $this->input->post('mdnm') . ')');
    }

    function vewItem()
    {
        $auid = $this->input->post('auid');

        $this->db->select("stck_item.*, stck_category.ctnm, stck_brands.brnm, stck_model.mdnm, stck_type.tpnm, CONCAT(user_mas.usnm) AS exc, DATE_FORMAT(stck_item.crdt, '%Y-%m-%d') AS crdt");
        $this->db->from("stck_item");
        $this->db->join('stck_category', 'stck_category.ctid = stck_item.ctid ');
        $this->db->join('stck_brands', 'stck_brands.brid = stck_item.brid ');
        $this->db->join('stck_model', 'stck_model.mdid = stck_item.mdid ');
        $this->db->join('stck_type', 'stck_type.tpid = stck_item.tpid ');
        $this->db->join('user_mas', 'user_mas.auid = stck_item.crby ');
        $this->db->where('stck_item.itid', $auid);
        $query = $this->db->get();
        $result = $query->result();

        echo json_encode($result);
    }

    // UPDATE ITEM
    function edtItem()
    {
        $func = $this->input->post('func'); // 1 - edit / 2 - approval
        $auid = $this->input->post('auid');

        if ($func == 1) {
            $this->db->trans_begin();           // SQL TRANSACTION START
            $data_ar1 = array(
                'sttp' => $this->input->post('sttpEdt'),
                'ctid' => $this->input->post('ctgrEdt'),
                'brid' => $this->input->post('brndEdt'),
                'mdid' => $this->input->post('modlEdt'),
                'tpid' => $this->input->post('typeEdt'),
                'itnm' => strtoupper($this->input->post('itnmEdt')),
                'itcd' => strtoupper($this->input->post('itcdEdt')),
                'pbcd' => strtoupper($this->input->post('pbcdEdt')),
                'dscr' => $this->input->post('remkEdt'),

                'ifwr' => $this->input->post('wrtpEdt'),
                'wrtp' => $this->input->post('wrmdEdt'),
                'pird' => $this->input->post('wrprEdt'),

                'mdby' => $_SESSION['userId'],
                'modt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'itid' => $auid
            );

            $result22 = $this->Generic_model->updateData('stck_item', $data_ar1, $where_arr);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('item_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Item Update id(' . $this->input->post('auid'));

        } else if ($func == 2) {

            $this->db->trans_begin();           // SQL TRANSACTION START
            $data_ar1 = array(
                'sttp' => $this->input->post('sttpEdt'),
                'ctid' => $this->input->post('ctgrEdt'),
                'brid' => $this->input->post('brndEdt'),
                'mdid' => $this->input->post('modlEdt'),
                'tpid' => $this->input->post('typeEdt'),
                'itnm' => strtoupper($this->input->post('itnmEdt')),
                'itcd' => strtoupper($this->input->post('itcdEdt')),
                'pbcd' => strtoupper($this->input->post('pbcdEdt')),
                'dscr' => $this->input->post('remkEdt'),

                'ifwr' => $this->input->post('wrtpEdt'),
                'wrtp' => $this->input->post('wrmdEdt'),
                'pird' => $this->input->post('wrprEdt'),

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'itid' => $auid
            );

            $result22 = $this->Generic_model->updateData('stck_item', $data_ar1, $where_arr);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('item_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Item Approval Update id(' . $this->input->post('auid'));
        }
    }

    // REJECT
    function rejItem()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_item', array('stat' => 2), array('itid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('item_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Item Inactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE MODEL
    function reactItem()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_item', array('stat' => 1), array('itid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('item_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Item Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END ITEM
//
// STOCK MANAGEMENT
    function stck_mng()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $data['ctgryinfo'] = $this->Generic_model->getSortData('stck_category', array('ctid', 'ctnm'), array('stat' => 1), '', '', 'ctnm', 'asc');   // CATEGORY
        $data['iteminfo'] = $this->Generic_model->getSortData('stck_item', array('itid', 'pbcd', 'itnm'), array('stat' => 1, 'sttp' => 1), '', '', 'pbcd', 'asc');   // ITEM LIST
        $data['spplyinfo'] = $this->Generic_model->getSortData('stck_supply', array('spid', 'spcd', 'spnm'), array('stat' => 1), '', '', 'spnm', 'asc');      // SUPPLY
        $data['whuseinfo'] = $this->Generic_model->getSortData('stck_warehouse', array('whid', 'whcd', 'whnm'), array('stat' => 1), '', '', 'whcd', 'asc');      // WARE HOUSE

        //$data['brndinfo'] = $this->Generic_model->getSortData('stck_brands', array('brid', 'brnm'), array('stat' => 1), '', '', 'brnm', 'asc');      // BRAND
        //$data['modelinfo'] = $this->Generic_model->getSortData('stck_model', array('mdid', 'mdnm'), array('stat' => 1), '', '', 'mdnm', 'asc');      // MODEL
        //$data['spplyinfo'] = $this->Generic_model->getSortData('stck_supply', array('spid', 'spcd', 'spnm'), array('stat' => 1), '', '', 'spnm', 'asc');      // SUPPLY

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('stck_mng');
        $this->load->view('modules/stock/stock_managmnt', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        //$this->load->view('modules/common/custom_js_common');
    }

    function srchStck()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('stck_mng');

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

        $result = $this->Stock_model->get_stock();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $stid = $row->stid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck($stid,this.id);' class='btn  btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck($stid,this.id);' class='btn  btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  onclick='rejecStck($stid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn  btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn  btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {            // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn  btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn  btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

                /*"<button type='button' onclick='reactvStck($itid);' class='btn btn-default btn-condensed $reac2' title='ReActive'><i class='glyphicon glyphicon-wrench' aria-hidden='true'></i></button> "*/
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->stno;
            $sub_arr[] = $row->spnm;
            $sub_arr[] = number_format($row->totl, 2, '.', ',');
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $row->exc;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_stock(),
            "recordsFiltered" => $this->Stock_model->count_filtered_stock(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // LOAD ITEM
    function getItem()
    {
        $ctgr = $this->input->post('ctid');

        $this->db->select("itid,itnm,itcd");
        $this->db->from("stck_item");
        if ($ctgr != 'all') {
            $this->db->where('stck_item.ctid ', $ctgr);
        }
        $this->db->where('stck_item.stat', 1);
        $this->db->order_by('stck_item.itcd', 'asc');
        $query = $this->db->get();

        echo json_encode($query->result());
    }

    // GET ITEM
    function getItemDtils()
    {
        $auid = $this->input->post('itnm');
        $data = $this->Generic_model->getData('stck_item', array('itcd', 'itnm'), array('itid' => $auid));

        echo json_encode($data);
    }

    // GET ITEM NAME
    function getItemName()
    {
        $ctgr = $this->input->post('ctgr');
        $brnd = $this->input->post('brnd');
        $modl = $this->input->post('modl');
        $type = $this->input->post('type');

        //LOAD ITEM
        $this->db->select("itid,itnm,itcd");
        $this->db->from("stck_item");
        if ($ctgr != 'all') {
            $this->db->where('stck_item.ctid ', $ctgr);
        }
        if ($brnd != 'all') {
            $this->db->where('stck_item.brid ', $brnd);
        }
        if ($modl != 'all') {
            $this->db->where('stck_item.mdid ', $modl);
        }
        if ($type != 'all') {
            $this->db->where('stck_item.tpid ', $type);
        }
        $this->db->where('stck_item.stat', 1);
        $this->db->order_by('stck_item.itcd', 'asc');
        $query = $this->db->get();
        $data['item'] = $query->result();

        echo json_encode($data);
    }

    // MODEL ADD
    function addStock()
    {
        $spid = $this->input->post('spid');
        $this->db->trans_begin(); // SQL TRANSACTION START

        //STOCK CODE GENERATE
        $supply = $this->Generic_model->getData('stck_supply', array('spcd'), array('stat' => 1, 'spid' => $spid));
        $spcd = $supply[0]->spcd;

        $this->db->select("stno");
        $this->db->from("stck_main");
        //$this->db->where('spid', $spid);
        $this->db->order_by('stid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');
        if (count($data) == '0') {
            $stno = 'ST' . $yr . '-0001';  // Ex (STOCK)(YEAR)-NO - ST18-0001

        } else {
            $icde = $data[0]->stno;
            $re = (explode("-", $icde));

            $aa = intval($re[1]) + 1;
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
            $stno = 'ST' . $yr . '-' . $xx;
        }

        $data_arr = array(
            'spid' => $spid,
            'stno' => $stno,
            'whid' => $this->input->post('whid'),
            'rfno' => $this->input->post('rfdt'),
            'oddt' => $this->input->post('ordt'),
            'sbtl' => $this->input->post('sbttl'),
            'totl' => $this->input->post('sbttl'),
            'remk' => $this->input->post('remk'),

            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('stck_main', $data_arr);


        // PO DETAILS SAVE SUB DETAILS TABLE
        // get voucher last recode id
        $podt = $this->Generic_model->getData('stck_main', array('stid'), array('stno' => $stno));
        $lstid = $podt[0]->stid;

        $itmcd = $this->input->post("itnmcd[]");    // ITM ID
        $qunty = $this->input->post('qunty[]');     // QUNTY
        $caspr = $this->input->post('csvlpr[]');    // CASH
        $salvl = $this->input->post('slvlpr[]');    // SALES
        $dipvl = $this->input->post('dsvlpr[]');    // DISPLAY
        $subvl = $this->input->post('unttl[]');     // SUB TOTAL
        $siz = sizeof($itmcd);

        $en = 0;        // loping count
        for ($a = 0; $a < $siz; $a++) {
            // if ($subamt[$a] != '' || $subamt[$a] != 0) {

            $data_arr2 = array(
                'stid' => $lstid,                     // po id
                'spid' => $spid,
                'itid' => $itmcd[$a],
                'qnty' => $qunty[$a],
                'avqn' => $qunty[$a],

                'csvl' => $caspr[$a],
                'slvl' => $salvl[$a],
                'dsvl' => $dipvl[$a],
                'sbtt' => $subvl[$a],
                'stat' => 1,
            );
            $result2 = $this->Generic_model->insertData('stck_main_sub', $data_arr2);
            // }
            $en++;
        }


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stck_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New Stock (' . $stno . ')');
    }

    // VIEW STOCK
    function vewStockList()
    {
        $auid = $this->input->post('auid');

        $this->db->select("stck_main.*, stck_supply.spnm, stck_warehouse.whnm, stck_warehouse.whcd, DATE_FORMAT(stck_main.crdt, '%Y-%m-%d') AS crdt");
        $this->db->from("stck_main");
        $this->db->join('stck_supply', 'stck_supply.spid = stck_main.spid ');
        $this->db->join('stck_warehouse', 'stck_warehouse.whid = stck_main.whid ');
        $this->db->where('stck_main.stid', $auid);
        $query = $this->db->get();
        $data['podtil'] = $query->result();

        $this->db->select("stck_main_sub.*, stck_item.itnm, stck_item.itcd");
        $this->db->from("stck_main_sub");
        $this->db->join('stck_item', 'stck_item.itid = stck_main_sub.itid ');
        $this->db->where('stck_main_sub.stid', $auid);
        $this->db->where('stck_main_sub.stat', 1);
        $this->db->order_by('stck_main_sub.stid', 'asc'); // desc
        $query = $this->db->get();
        $data['poitem'] = $query->result();

        echo json_encode($data);
    }

    function vewStock()
    {
        $auid = $this->input->post('auid');

        $this->db->select("Zxstck_stock.*, stck_supply.spcd, stck_supply.spnm, stck_item.itnm, stck_item.itcd, stck_category.ctnm, stck_brands.brnm, stck_model.mdnm, stck_type.tpnm, CONCAT(user_mas.usnm) AS exc,
         DATE_FORMAT(stck_item.crdt, '%Y-%m-%d') AS crdt, stck_item.ctid, stck_item.brid, stck_item.mdid, stck_item.tpid");
        $this->db->from("stck_stock");
        $this->db->join('stck_item', 'stck_item.itid = stck_stock.itid ');
        $this->db->join('stck_supply', 'stck_supply.spid = stck_stock.spid ');

        $this->db->join('stck_category', 'stck_category.ctid = stck_item.ctid ');
        $this->db->join('stck_brands', 'stck_brands.brid = stck_item.brid ');
        $this->db->join('stck_model', 'stck_model.mdid = stck_item.mdid ');
        $this->db->join('stck_type', 'stck_type.tpid = stck_item.tpid ');
        $this->db->join('user_mas', 'user_mas.auid = stck_item.crby ');
        $this->db->where('stck_stock.stid', $auid);
        $query = $this->db->get();
        $result = $query->result();

        echo json_encode($result);
    }

    // UPDATE STOCK
    function edtStock()
    {
        $func = $this->input->post('func'); // 1 - edit / 2 - approval
        $auid = $this->input->post('auid');
        $spid = $this->input->post('spidEdt');

        if ($func == 1) {
            $this->db->trans_begin();           // SQL TRANSACTION START

            $data_arr = array(
                'spid' => $spid,
                'whid' => $this->input->post('whidEdt'),
                'rfno' => $this->input->post('rfdtEdt'),
                'oddt' => $this->input->post('ordtEdt'),
                'sbtl' => $this->input->post('ttlEdt'),
                'totl' => $this->input->post('ttlEdt'),
                'remk' => $this->input->post('remkEdt'),

                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'stid' => $auid
            );
            $result22 = $this->Generic_model->updateData('stck_main', $data_arr, $where_arr);


            // REMOVE STOCK ITEM
            $sbid = $this->input->post("sbid[]");
            $prvTb = $this->input->post('prvTbLeng');

            $this->db->select("sbid ");
            $this->db->from("stck_main_sub");
            $this->db->where('stid', $auid);
            $this->db->where('stat', 1);
            $query = $this->db->get();
            $podt = $query->result();

            // CURRENT ITEM ORDERING
            if (!empty($sbid)) {
                $sz = sizeof($sbid);
                for ($x = 0; $x < $sz; $x++) {
                    $result[] = $sbid[$x];
                }

                // IF PREVIOUS TABLE DATA AND CURRENT ITEM CHECK
                for ($a = 0; $a < $prvTb; $a++) {
                    if (in_array($podt[$a]->sbid, $result, TRUE)) {
                        $this->Generic_model->updateData('stck_main_sub', array('stat' => 1), array('sbid' => $podt[$a]->sbid));

                    } else {
                        $this->Generic_model->updateData('stck_main_sub', array('stat' => 0), array('sbid' => $podt[$a]->sbid));
                    }
                }
            } else {
                $this->Generic_model->updateData('stck_main_sub', array('stat' => 0), array('stid' => $auid));
            }

            // ADD NEW PO ITEM
            $itmcd = $this->input->post("itnmcdEdt_n[]");
            $qunty = $this->input->post('quntyEdt_n[]');
            $cshpr = $this->input->post('csvlEdt_n[]');
            $salvl = $this->input->post('slvlEdt_n[]');
            $dspvl = $this->input->post('dsvlEdt_n[]');
            $unttl = $this->input->post('unttlEdt_n[]');

            $siz = sizeof($itmcd);
            for ($a = 0; $a < $siz; $a++) {
                $data_arr2 = array(
                    'stid' => $auid,                     // po id
                    'spid' => $this->input->post('spidEdt'),
                    'itid' => $itmcd[$a],
                    'qnty' => $qunty[$a],
                    'csvl' => $cshpr[$a],
                    'slvl' => $salvl[$a],
                    'dsvl' => $dspvl[$a],
                    'sbtt' => $unttl[$a],
                    'stat' => 1,
                );
                $result2 = $this->Generic_model->insertData('stck_main_sub', $data_arr2);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('stck_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Stock Update id(' . $auid . ')');

        } else if ($func == 2) {

            $this->db->trans_begin();           // SQL TRANSACTION START

            $data_arr = array(
                'spid' => $spid,
                'whid' => $this->input->post('whidEdt'),
                'rfno' => $this->input->post('rfdtEdt'),
                'oddt' => $this->input->post('ordtEdt'),
                'sbtl' => $this->input->post('ttlEdt'),
                'totl' => $this->input->post('ttlEdt'),
                'remk' => $this->input->post('remkEdt'),

                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            );
            $where_arr = array(
                'stid' => $auid
            );
            $result22 = $this->Generic_model->updateData('stck_main', $data_arr, $where_arr);

            // REMOVE STOCK ITEM
            $sbid = $this->input->post("sbid[]");
            $prvTb = $this->input->post('prvTbLeng');

            $this->db->select("sbid ");
            $this->db->from("stck_main_sub");
            $this->db->where('stid', $auid);
            $this->db->where('stat', 1);
            $query = $this->db->get();
            $podt = $query->result();

            // CURRENT ITEM ORDERING
            if (!empty($sbid)) {
                $sz = sizeof($sbid);
                for ($x = 0; $x < $sz; $x++) {
                    $result[] = $sbid[$x];
                }

                // IF PREVIOUS TABLE DATA AND CURRENT ITEM CHECK
                for ($a = 0; $a < $prvTb; $a++) {
                    if (in_array($podt[$a]->sbid, $result, TRUE)) {
                        $this->Generic_model->updateData('stck_main_sub', array('stat' => 1), array('sbid' => $podt[$a]->sbid));

                    } else {
                        $this->Generic_model->updateData('stck_main_sub', array('stat' => 0), array('sbid' => $podt[$a]->sbid));
                    }
                }
            } else {
                $this->Generic_model->updateData('stck_main_sub', array('stat' => 0), array('stid' => $auid));
            }

            // ADD NEW PO ITEM
            $itmcd = $this->input->post("itnmcdEdt_n[]");
            $qunty = $this->input->post('quntyEdt_n[]');
            $cshpr = $this->input->post('csvlEdt_n[]');
            $salvl = $this->input->post('slvlEdt_n[]');
            $dspvl = $this->input->post('dsvlEdt_n[]');
            $unttl = $this->input->post('unttlEdt_n[]');

            $siz = sizeof($itmcd);
            for ($a = 0; $a < $siz; $a++) {
                $data_arr2 = array(
                    'stid' => $auid,                     // po id
                    'spid' => $this->input->post('spidEdt'),
                    'itid' => $itmcd[$a],
                    'qnty' => $qunty[$a],
                    'avqn' => $qunty[$a],
                    'csvl' => $cshpr[$a],
                    'slvl' => $salvl[$a],
                    'dsvl' => $dspvl[$a],
                    'sbtt' => $unttl[$a],
                    'stat' => 1,
                );
                $result2 = $this->Generic_model->insertData('stck_main_sub', $data_arr2);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
            $funcPerm = $this->Generic_model->getFuncPermision('stck_mng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Stock Approval id(' . $auid . ')');
        }
    }

    // REJECT
    function rejStock()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_main', array('stat' => 2, 'trdt' => date('Y-m-d H:i:s'), 'trby' => $_SESSION['userId']), array('stid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('stck_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Stock Reject id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // REACTIVE
    function reactItemX()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('stck_item', array('stat' => 1), array('itid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('stck_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Item Reactive id(' . $id . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            //  echo json_encode(false);
        }
    }
// END STOCK
//
//
// STOCK LIST
    function stck_list()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $data['ctgryinfo'] = $this->Generic_model->getSortData('stck_category', array('ctid', 'ctnm'), array('stat' => 1), '', '', 'ctnm', 'asc');   // CATEGORY
        $data['iteminfo'] = $this->Generic_model->getSortData('stck_item', array('itid', 'pbcd', 'itnm'), array('stat' => 1, 'sttp' => 1), '', '', 'pbcd', 'asc');   // ITEM LIST
        $data['spplyinfo'] = $this->Generic_model->getSortData('stck_supply', array('spid', 'spcd', 'spnm'), array('stat' => 1), '', '', 'spnm', 'asc');      // SUPPLY
        $data['whuseinfo'] = $this->Generic_model->getSortData('stck_warehouse', array('whid', 'whcd', 'whnm'), array('stat' => 1), '', '', 'whcd', 'asc');      // WARE HOUSE


        $data['funcPerm'] = $this->Generic_model->getFuncPermision('stck_list');
        $this->load->view('modules/stock/stock_list', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        //$this->load->view('modules/common/custom_js_common');
    }

    function srchStckList()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('stck_list');

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

        $result = $this->Stock_model->get_stockList();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $stid = $row->sbid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-danger'> Inactive </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button>" .
                    " <button type='button' $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtDetils($stid);' class='btn btn-sm btn-default btn-condensed' title='Change Details' ><i class='fa fa-pencil' aria-hidden='true'></i></button>";
            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button>" .
                    " <button type='button' $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtDetils($stid);' class='btn btn-sm btn-default btn-condensed' title='Change Details' ><i class='fa fa-pencil' aria-hidden='true'></i></button>";
            } else if ($st == '2') {            // Rejected
                $stat = " <span class='label label-success'> Active</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn  btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button>" .
                    " <button type='button' $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtDetils($stid);' class='btn  btn-sm btn-default btn-condensed' title='Change Details' ><i class='fa fa-pencil' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->stno;
            $sub_arr[] = $row->icde;
            $sub_arr[] = $row->itnm . ' | ' . $row->itnm;
            $sub_arr[] = $row->qnty;
            $sub_arr[] = $row->avqn;
            $sub_arr[] = number_format($row->csvl, 2, '.', ',');
            $sub_arr[] = number_format($row->slvl, 2, '.', ',');
            $sub_arr[] = number_format($row->dsvl, 2, '.', ',');
            //$sub_arr[] = number_format($row->sbtt, 2, '.', ',');
            $sub_arr[] = $row->crdt;
            //$sub_arr[] = $row->crby;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_stockList(),
            "recordsFiltered" => $this->Stock_model->count_filtered_stockList(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function getStock()
    {
        $auid = $this->input->post('auid');

        $this->db->select("stck_main_sub.*, stck_item.itnm, stck_item.itcd,stck_item.icde, stck_main.stno, CONCAT(user_mas.usnm) AS crby, DATE_FORMAT(stck_main.crdt, '%Y-%m-%d') AS crdt ");
        $this->db->from("stck_main_sub");
        $this->db->join('stck_main', 'stck_main.stid = stck_main_sub.stid ');
        $this->db->join('stck_item', 'stck_item.itid = stck_main_sub.itid ');
        $this->db->join('user_mas', 'user_mas.auid = stck_main.crby ');
        //$this->db->where('stck_main_sub.stat', 1);
        $this->db->where('stck_main.stat', 1);
        $this->db->where('stck_main_sub.sbid', $auid);
        $query = $this->db->get();
        $result['main'] = $query->result();

        $result['sub'] = $this->Generic_model->getData('stck_main_sub_des', '', array('stsb' => $auid));

        echo json_encode($result);
    }

    function addStkSubDtils()
    {
        $func = $this->input->post("func");         // func

        if ($func == 1) {
            $this->db->trans_begin(); // SQL TRANSACTION START

            $tbid = $this->input->post("tbid[]");      // tbl id

            for ($a = 0; $a < sizeof($tbid); $a++) {

                $stsb = $this->input->post("tbid[" . $a . "]");   // tbid

                $bcode = $this->input->post("bcode[" . $a . "]");   // bcode
                $serno = $this->input->post("serno[" . $a . "]");   // serno
                $batno = $this->input->post("batno[" . $a . "]");   // batno
                $prtno = $this->input->post("prtno[" . $a . "]");   // prtno


                $data_arr = array(
                    'stsb' => $stsb,    // stck_main_sub tb id
                    'brcd' => $bcode,
                    'srno' => $serno,
                    'btno' => $batno,
                    'prno' => $prtno,

                    'stat' => 1,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->insertData('stck_main_sub_des', $data_arr);
            }

            $this->Generic_model->updateData('stck_main_sub', array('stat' => 2), array('sbid' => $this->input->post("auid")));

            $funcPerm = $this->Generic_model->getFuncPermision('stck_list');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add stock list to details (' . $this->input->post("auid") . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }


        } else if ($func == 2) {

            $this->db->trans_begin(); // SQL TRANSACTION START

            $xxc = $this->input->post("dtid[]");      // tbl id

            for ($a = 0; $a < sizeof($xxc); $a++) {

                $dtid = $this->input->post("dtid[" . $a . "]");   // tbid

                $bcode = $this->input->post("bcode[" . $a . "]");   // bcode
                $serno = $this->input->post("serno[" . $a . "]");   // serno
                $batno = $this->input->post("batno[" . $a . "]");   // batno
                $prtno = $this->input->post("prtno[" . $a . "]");   // prtno

                $data_arr = array(
                    //'stsb' => $stsb,    // stck_main_sub tb id
                    'brcd' => $bcode,
                    'srno' => $serno,
                    'btno' => $batno,
                    'prno' => $prtno,
                    //'stat' => 1,
                    //'crby' => $_SESSION['userId'],
                    //'crdt' => date('Y-m-d H:i:s'),
                );
                $result = $this->Generic_model->updateData('stck_main_sub_des', $data_arr, array('dtid' => $dtid));
            }

            //$this->Generic_model->updateData('stck_main_sub', array('stat' => 2), array('sbid' => $this->input->post("auid")));

            $funcPerm = $this->Generic_model->getFuncPermision('stck_list');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Update stock list details (' . $dtid . ')');

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

// END STOCK LIST
//
// BARCODE PRINT
    function bcdePrnt()
    {
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('stck_list');
        $data['tmpBarcd'] = $this->Generic_model->getData('stck_bcde_prnt', array('IFNULL(bcde,00000) AS bcde'), array('stat' => 1));

        $this->load->view('modules/stock/barcode_print', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
    }

    function addBcodeTmp()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $cde = $this->input->post("val");       // value
        $posi = $this->input->post("posi");     // position

        $result = $this->Generic_model->getData('stck_item', array('itid', 'itnm', 'itcd'), array('icde' => $cde));
        $result2 = $this->Generic_model->getSortData('stck_main_sub', array('csvl', 'slvl', 'dsvl'), array('itid' => $result[0]->itid), '1', '', 'dsvl', 'desc');

        if (!empty($result)) {

            $data_arr = array(
                'bcde' => $cde,
                'itcd' => strtoupper($result[0]->itcd),
                'itnm' => $result[0]->itnm,
                'pric' => number_format($result2[0]->dsvl, 2), //number_format($row->avcp, 2);
                'stat' => 1,
            );
            $result = $this->Generic_model->updateData('stck_bcde_prnt', $data_arr, array('auid' => $posi));

            $code = $cde;
            //load library
            $this->load->library('Zend');
            //load in folder Zend
            $this->zend->load('Zend/Barcode');
            //generate barcode
            //Zend_Barcode::render('code128', 'image', array('text' => $code), array());
            $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
            //$code = time().$code;
            $code = $code;
            $store_image = imagepng($file, "uploads/barcode/{$code}.png");

            if ($store_image) {
                $last = $this->Generic_model->getData('stck_bcde_prnt', array(''), array('auid' => $posi));
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->Log_model->ErrorLog('0', '1', '2', '3');
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode($last);
            }
        } else {
            echo json_encode(false);
        }
    }

    function getBcodeTmp(){
        $barTmp = $this->Generic_model->getData('stck_bcde_prnt', array(''), array('stat'=>1));
        echo json_encode($barTmp);

        /*$this->db->select("IFNULL(bcde, 00000) AS bcde, IFNULL(itcd,'--') AS itcd ");
        $this->db->from("stck_bcde_prnt");
        //$this->db->where('stck_main_sub.stat', 1);
        $query = $this->db->get();
        echo json_encode($query->result());*/
    }

    function barcode()
    {
        /*$this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $test = Zend_Barcode::draw('ean8', 'image', array('text' => '1234565'), array());
        var_dump($test);
        imagejpeg($test, 'barcode.jpg', 100);*/

        //I'm just using rand() function for data example
        $temp = rand(10000, 99999);
        $this->set_barcode($temp);
    }

    private function set_barcode($code)
    {
        //load library
        $this->load->library('Zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        Zend_Barcode::render('code128', 'image', array('text' => $code), array());
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
        //$code = time().$code;
        $code = $code;
        $store_image = imagepng($file, "uploads/barcode/{$code}.png");
    }

    function srchStckListXX()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('stck_list');

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

        $result = $this->Stock_model->get_stockList();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $stid = $row->sbid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-danger'> Inactive </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button>" .
                    " <button type='button' $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtDetils($stid);' class='btn btn-sm btn-default btn-condensed' title='Add Details' ><i class='fa fa-plus' aria-hidden='true'></i></button>";
            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button>" .
                    " <button type='button' $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtDetils($stid);' class='btn btn-sm btn-default btn-condensed' title='Add Details' ><i class='fa fa-plus' aria-hidden='true'></i></button>";
            } else if ($st == '2') {            // Rejected
                $stat = " <span class='label label-success'> Active</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modalView'  onclick='viewStck($stid);' class='btn  btn-sm btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button>" .
                    " <button type='button' $edt  data-toggle='modal' data-target='#modalEdt'  onclick='edtDetils($stid);' class='btn  btn-sm btn-default btn-condensed' title='Add Details' ><i class='fa fa-plus' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->stno;
            $sub_arr[] = $row->icde;
            $sub_arr[] = $row->itnm . ' | ' . $row->itnm;
            $sub_arr[] = $row->qnty;
            $sub_arr[] = $row->avqn;
            $sub_arr[] = number_format($row->csvl, 2, '.', ',');
            $sub_arr[] = number_format($row->slvl, 2, '.', ',');
            $sub_arr[] = number_format($row->dsvl, 2, '.', ',');
            //$sub_arr[] = number_format($row->sbtt, 2, '.', ',');
            $sub_arr[] = $row->crdt;
            //$sub_arr[] = $row->crby;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_stockList(),
            "recordsFiltered" => $this->Stock_model->count_filtered_stockList(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function clerBcdeAll()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->Generic_model->updateData('stck_bcde_prnt', array('bcde' => '', 'itcd' => '', 'itnm' => '', 'pric' => '', 'stat' => 0), array('stat' => 1));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function barTagPrint(){

        //$data['tmpBarcd'] = $this->Generic_model->getData('stck_bcde_prnt', array('IFNULL(bcde,00000) AS bcde'), array('stat' => 1));

        $this->db->select("IFNULL(bcde, '00000') AS bcde, itcd, CONCAT('Rs.', ROUND(pric,2)) AS price ");
        $this->db->from("stck_bcde_prnt");
        //$this->db->where('stck_main.stat', 1);
        $query = $this->db->get();
        $data['tmpBarcd'] = $query->result();


        $this->load->view('modules/stock/barcodeTagPrint', $data);

    }


}
