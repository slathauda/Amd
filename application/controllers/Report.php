<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{

    /*  THIS CONTROLLER USE FOR REPORT  */
    function __construct()
    {
        parent::__construct();

        //$this->load->library('Pdf'); // Load library
        $this->load->library('Pdf2'); // Load library

        $this->pdf2->fontpath = 'font/'; // Specify font folder
        $this->load->database(); // load database
        $this->load->model('Generic_model'); // load model
        $this->load->model('Report_model'); // load model
        $this->load->model('Log_model'); // load model
        $this->load->model('User_model'); // load model

        date_default_timezone_set('Asia/Colombo');

        if (!empty($_SESSION['userId'])) {

        } else {
            redirect('/');
        }

        // GET COMPANY REPORT LOGO AD SET IT SESSION
        $cmdt = $this->Generic_model->getData('com_det', array('rplg'), array('stat' => 1));
        $_SESSION['rpt_logo'] = $cmdt[0]->rplg;

    }

    public function index()
    {
        $data['permission'] = $this->Generic_model->getPermision();

        $this->load->view('modules/common/tmp_header');
        $this->load->view('modules/user/includes/user_header', $data);
        $this->load->view('modules/user/dashboard');
        $this->load->view('modules/common/footer');
    }

// COMMON
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
            $this->db->where('micr_crleg.dsid', $tp);
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

// LOAD CHART OF ACCOUNT
    function getChrtAcc()
    {
        $mnac = $this->input->post('mnac');
        if ($mnac == 'all') {
            $data = $this->Generic_model->getData('accu_chrt', array('auid', 'idfr', 'hadr'), "stat IN(1,3)");
        } else {
            $data = $this->Generic_model->getData('accu_chrt', array('auid', 'idfr', 'hadr'), "stat IN(1,3) AND acid = '$mnac'");
        }

        echo json_encode($data);

    }

// LOAD PRODUCT
    function getProduct()
    {
        $prtp = $this->input->post('prtp');
        $brco = $this->input->post('brnc');

        $this->db->select("auid,prnm ");
        $this->db->from("product");
        $this->db->where('stat ', 1);
        if ($prtp != 'all') {
            $this->db->where('prtp ', $prtp);
        }

        if ($prtp == 6 || $prtp == 7 || $prtp == 8) {
            $this->db->group_by('prtp');
        } else {
            $this->db->group_by('prnm');
            if ($brco != 'all') {
                $this->db->where('brid ', $brco);
            }
        }
        $query = $this->db->get();
        echo json_encode($query->result());

    }
////////////////////////////////////////////////////////////
// RECOVER
    function recver()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('recver');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $this->load->view('modules/report/loan_recovery', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // ARREST LOAN
    function srchArrLoan()
    {
        $result = $this->Report_model->get_arrLn();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $stat = " <span class='label label-warning'> Pending </span> ";
            $option = "<button type='button' onclick='recvryAdd($row->lnid);' class='btn  btn-default btn-condensed' title='Add Recover Loan'><i class='fa fa-check' aria-hidden='true'></i></button> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' / ' . $row->cnnm;        //brnc
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->cuno;         //no of pg
            $sub_arr[] = $row->init;
            $sub_arr[] = number_format($row->loam, 2);         //
            $sub_arr[] = $row->cage;         //
            $sub_arr[] = number_format($row->aboc + $row->aboi + $row->cage, 2);
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_arrLn(),
            "recordsFiltered" => $this->Report_model->count_filtered_arrLn(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    // ADD RECOVERY LOAN
    function recvryAdd()
    {
        $id = $this->input->post('lnid');
        $result1 = $this->Generic_model->updateData('micr_crt', array('rcst' => 1), array('lnid' => $id));

        $lndt = $this->Generic_model->getData('micr_crt', array('brco', 'clct', 'ccnt', 'cage', 'aboc', 'aboi'), array('lnid' => $id));
        $data_arr = array(
            'brcd' => $lndt[0]->brco,
            'user' => $lndt[0]->clct,
            'cntr' => $lndt[0]->ccnt,
            'lnid' => $id,
            //'armt' => $lndt[0]->aboc + $lndt[0]->aboi,
            //'arag' => $lndt[0]->cage,
            'ltct' => 0,
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result2 = $this->Generic_model->insertData('loan_recr', $data_arr);


        $funcPerm = $this->Generic_model->getFuncPermision('recver');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Recovery loan add id(' . $id . ')');

        if (count($result1) > 0 && count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // VIEW RECOVERY DETAILS
    function vewRcveryLoan()
    {
        $auid = $this->input->post('auid');

        $this->db->select("loan_recr.* , micr_crt.*,IF(micr_crt.lntp = 1,'Product Loan','Dynamic Loan') AS lntpnm,cus_mas.cuno,cus_mas.init,cus_mas.hoad,cus_mas.mobi,
        cus_mas.anic,brch_mas.brnm ,cen_mas.cnnm,user_mas.fnme ,user_mas.lnme , product.prnm,
        prdt_typ.prna,prdt_typ.pymd,  IFNULL(re.ramt,'0') AS ramt ,IFNULL(re.crdt,' - ') AS crdt ,IFNULL(re.crb,' - ') AS crb ");

        $this->db->from("loan_recr");
        $this->db->join('micr_crt', 'micr_crt.lnid = loan_recr.lnid ');
        $this->db->join('cen_mas', 'cen_mas.caid = loan_recr.cntr');
        $this->db->join('brch_mas', 'brch_mas.brid = loan_recr.brcd ');
        $this->db->join('user_mas', 'user_mas.auid = loan_recr.user ');
        $this->db->join('product', 'product.auid = micr_crt.prid ');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');

        $this->db->join("(SELECT r.rfno,r.reno,r.ramt,r.crdt , CONCAT(u.fnme, ' ' , u.lnme) AS crb
                        FROM `receipt` AS r 
                        JOIN user_mas AS u ON u.auid = r.crby
                        WHERE  r.retp = 2 AND r.stat IN(1,2) 
                        ORDER BY `reid` DESC LIMIT 1) AS re", 're.rfno = micr_crt.lnid', 'left');

        $this->db->where('loan_recr.rcid ', $auid);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // RECOVERY LOAN
    function srchRcverLoan()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('recver');
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
        if ($funcPerm[0]->reac == 1) {
            $reac = "";
        } else {
            $reac = "disabled";
        }

        $result = $this->Report_model->get_rcvryLn();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->ltct == 0) {
                if ($row->flpby == 0) {
                    $disa = "disabled";
                } else {
                    $disa = "";
                }
                $stat = " <span class='label label-warning'> Pending </span> ";
                $prnt = "<button type='button' $prnt onclick='ltrPrint($row->rcid,$row->ltct);' class='btn  btn-default btn-condensed label-info' title='1 Letter print'><i class='fa fa-print' aria-hidden='true'></i></button> ";
                $send = "<button type='button' $disa $app onclick='ltrSend($row->rcid,$row->ltct);' class='btn  btn-default btn-condensed' title='Letter send'><i class='fa fa-envelope' aria-hidden='true'></i></button> ";
            } else if ($row->ltct == 1) {
                if ($row->slpby == 0) {
                    $disa = "disabled";
                } else {
                    $disa = "";
                }
                $stat = " <span class='label label-info'> 1 Letter  </span> ";
                $prnt = "<button type='button' $prnt onclick='ltrPrint($row->rcid,$row->ltct);' class='btn  btn-default btn-condensed label-warning' title='2 Letter print'><i class='fa fa-print' aria-hidden='true'></i></button> ";
                $send = "<button type='button' $disa $app onclick='ltrSend($row->rcid,$row->ltct);' class='btn  btn-default btn-condensed' title='Letter send'><i class='fa fa-envelope' aria-hidden='true'></i></button> ";
            } else if ($row->ltct == 2) {
                if ($row->tlpby == 0) {
                    $disa = "disabled";
                } else {
                    $disa = "";
                }
                $stat = " <span class='label label-warning'> 2 Letter </span> ";
                $prnt = "<button type='button' $prnt onclick='ltrPrint($row->rcid,$row->ltct);' class='btn  btn-default btn-condensed label-danger' title='3 Letter print'><i class='fa fa-print' aria-hidden='true'></i></button> ";
                $send = "<button type='button' $disa $app onclick='ltrSend($row->rcid,$row->ltct);' class='btn  btn-default btn-condensed' title='Letter send'><i class='fa fa-envelope' aria-hidden='true'></i></button> ";
            } else if ($row->ltct == 3) {
                $stat = " <span class='label label-danger'> 3 Letter </span> ";
                $prnt = "<button type='button' disabled onclick='ltrPrint($row->rcid,$row->ltct);' class='btn  btn-default btn-condensed label-info' title=' Letter print'><i class='fa fa-print' aria-hidden='true'></i></button> ";
                $send = "<button type='button' disabled onclick='ltrSend($row->rcid,$row->ltct);' class='btn  btn-default btn-condensed' title='Letter send'><i class='fa fa-envelope' aria-hidden='true'></i></button> ";
            }

            $option = "<button type='button' $viw id='viw' data-toggle='modal' data-target='#modalView' onclick='viewDetails($row->rcid);' class='btn  btn-default btn-condensed' title='View more details'><i class='fa fa-eye' aria-hidden='true'></i></button> "
                . $prnt . $send .
                "<button type='button'  $reac onclick='chngMode($row->rcid,$row->lnid);'  class='btn  btn-default btn-condensed ' title='Mode change'><i class='fa fa-send' aria-hidden='true'></i> </button> " .
                "<button type='button' onclick='viewCommnt($row->lnid);' data-toggle='modal' data-target='#modalCmnt' class='btn  btn-default btn-condensed ' title='Add comment'><i class='fa fa-comments' aria-hidden='true'></i> </button> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' / ' . $row->cnnm;        //brnc
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->cuno;         //no of pg
            $sub_arr[] = $row->init;
            $sub_arr[] = number_format($row->loam, 2);         //
            $sub_arr[] = $row->cage;         //
            $sub_arr[] = number_format($row->aboc + $row->aboi + $row->cage, 2);
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_rcvryLn(),
            "recordsFiltered" => $this->Report_model->count_filtered_rcvryLn(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // RECOVERY LETTER PRINT
    function letter_print($rcid, $ltct)
    {
        //$rcid = $this->input->post('rcid');
        //$ltct = $this->input->post('ltct');

        if ($ltct == 0) {             // 1 letter print
            $data_arr = array(
                'stat' => 1,
                'flpby' => $_SESSION['userId'],
                'flpdt' => date('Y-m-d H:i:s'),
            );
            $result1 = $this->Generic_model->updateData('loan_recr', $data_arr, array('rcid' => $rcid));

            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf2->AddPage('P', 'A5');
            $this->pdf2->SetFont('Helvetica', 'B', 15);
            $this->pdf2->SetTextColor(50, 50, 50);

            $this->pdf2->SetFont('Helvetica', 'B', 15);
            $this->pdf2->SetXY(10, 9);
            $this->pdf2->Cell(0, 0, $rcid . 'First Letter  ');
            $this->pdf2->SetFont('Helvetica', '', 9);
            $this->pdf2->SetXY(10, 14);
            $this->pdf2->Cell(0, 0, "Date : " . $date);

            $this->pdf2->SetTitle('First Letter  :' . $rcid);
            $this->pdf2->Output('First_letter_' . $rcid . '.pdf', 'I');
            ob_end_flush();

        } else if ($ltct == 1) {      // 2 letter print
            $data_arr = array(
                'slpby' => $_SESSION['userId'],
                'slpdt' => date('Y-m-d H:i:s'),
            );
            $result1 = $this->Generic_model->updateData('loan_recr', $data_arr, array('rcid' => $rcid));

            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf2->AddPage('L', 'A5');
            $this->pdf2->SetFont('Helvetica', 'B', 15);
            $this->pdf2->SetTextColor(50, 50, 50);

            $this->pdf2->SetFont('Helvetica', 'B', 15);
            $this->pdf2->SetXY(10, 9);
            $this->pdf2->Cell(0, 0, 'Second Letter  ');
            $this->pdf2->SetFont('Helvetica', '', 9);
            $this->pdf2->SetXY(10, 14);
            $this->pdf2->Cell(0, 0, "Date : " . $date);

            $this->pdf2->SetTitle('Second Letter  :' . $rcid);
            $this->pdf2->Output('Second_letter_' . $rcid . '.pdf', 'I');
            ob_end_flush();

        } else if ($ltct == 2) {       // 3 letter print
            $data_arr = array(
                'tlpby' => $_SESSION['userId'],
                'tlpdt' => date('Y-m-d H:i:s'),
            );
            $result1 = $this->Generic_model->updateData('loan_recr', $data_arr, array('rcid' => $rcid));

            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf2->AddPage('L', 'A5');
            $this->pdf2->SetFont('Helvetica', 'B', 15);
            $this->pdf2->SetTextColor(50, 50, 50);

            $this->pdf2->SetFont('Helvetica', 'B', 15);
            $this->pdf2->SetXY(10, 9);
            $this->pdf2->Cell(0, 0, '3rd Letter  ');
            $this->pdf2->SetFont('Helvetica', '', 9);
            $this->pdf2->SetXY(10, 14);
            $this->pdf2->Cell(0, 0, "Date : " . $date);

            $this->pdf2->SetTitle('3rd Letter  : ' . $rcid);
            $this->pdf2->Output('3rd_letter_' . $rcid . '.pdf', 'I');
            ob_end_flush();

        }
        /* if (count($result1) > 0) {
             echo json_encode(true);
         } else {
             echo json_encode(false);
         }*/
    }

    // RECOVERY LETTER SEND
    function letter_send()
    {
        $rcid = $this->input->post('rcid');
        $ltct = $this->input->post('ltct');

        $rcdt = $this->Generic_model->getData('loan_recr', array('ltct', 'lnid'), array('rcid' => $rcid));
        if ($ltct == 0) {             // 1 letter print
            $data_arr = array(
                'ltct' => $rcdt[0]->ltct + 1,
                //'stat' => 1,
                'flsby' => $_SESSION['userId'],
                'flsdt' => date('Y-m-d H:i:s'),
            );
            $result1 = $this->Generic_model->updateData('loan_recr', $data_arr, array('rcid' => $rcid));
            $data_arr = array(
                'cmtp' => 2,
                'cmmd' => 0,
                'cmrf' => $rcdt[0]->lnid,
                'cmnt' => "1st Letter Send Date " . date('Y-m-d H:i:s'),
                'stat' => 1,
                'crby' => 0,
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('comments', $data_arr);

            $funcPerm = $this->Generic_model->getFuncPermision('recver');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, '1st Letter Send id(' . $rcdt[0]->lnid . ')');

        } else if ($ltct == 1) {      // 2 letter print
            $data_arr = array(
                'ltct' => $rcdt[0]->ltct + 1,
                'slsby' => $_SESSION['userId'],
                'slsdt' => date('Y-m-d H:i:s'),
            );
            $result1 = $this->Generic_model->updateData('loan_recr', $data_arr, array('rcid' => $rcid));
            $data_arr = array(
                'cmtp' => 2,
                'cmmd' => 0,
                'cmrf' => $rcdt[0]->lnid,
                'cmnt' => "2nd Letter Send Date " . date('Y-m-d H:i:s'),
                'stat' => 1,
                'crby' => 0,
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('comments', $data_arr);
            $funcPerm = $this->Generic_model->getFuncPermision('recver');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, '2nd Letter Send id(' . $rcdt[0]->lnid . ')');

        } else if ($ltct == 2) {       // 3 letter print
            $data_arr = array(
                'ltct' => $rcdt[0]->ltct + 1,
                'tlsby' => $_SESSION['userId'],
                'tlsdt' => date('Y-m-d H:i:s'),
            );
            $result1 = $this->Generic_model->updateData('loan_recr', $data_arr, array('rcid' => $rcid));
            $data_arr = array(
                'cmtp' => 2,
                'cmmd' => 0,
                'cmrf' => $rcdt[0]->lnid,
                'cmnt' => "3rd Letter Send Date " . date('Y-m-d H:i:s'),
                'stat' => 1,
                'crby' => 0,
                'crdt' => date('Y-m-d H:i:s'),
            );
            $result = $this->Generic_model->insertData('comments', $data_arr);
            $funcPerm = $this->Generic_model->getFuncPermision('recver');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, '3rd Letter Send id(' . $rcdt[0]->lnid . ')');
        }

        if (count($result1) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }

    // RECOVERY LOAN MODE CHANGE TO NORMAL MODE
    function recvry_modechng()
    {
        $rcid = $this->input->post('rcid');
        $lnid = $this->input->post('lnid');

        $data_arr = array(
            'stat' => 2,
            'moby' => $_SESSION['userId'],
            'modt' => date('Y-m-d H:i:s'),
        );
        $result1 = $this->Generic_model->updateData('loan_recr', $data_arr, array('rcid' => $rcid));

        $result2 = $this->Generic_model->updateData('micr_crt', array('rcst' => 0), array('lnid' => $lnid));

        $funcPerm = $this->Generic_model->getFuncPermision('recver');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Recovery loan change to normal mode id(' . $lnid . ')');

        if (count($result1) > 0 && count($result2) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    // ADD LOAN COMMENT
    function addRcveryCmnt()
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

        $funcPerm = $this->Generic_model->getFuncPermision('recver');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add Recovery comment (' . $cmnt . ')');

        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

    }
// END RECOVER
//
// REPORT RECEIPTS
    function rpt_rcpt()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rcpt');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $this->load->view('modules/report/rpt_receipts', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function searchRecpt()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_rcpt');

        if ($funcPerm[0]->prnt == 1) {
            $prn = "";
        } else {
            $prn = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $apv = "";
        } else {
            $apv = "disabled";
        }

        $result = $this->Report_model->get_rceipt();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->stat == 1) {
                $stat = "Active";
                $sn = "";
                $pr = "";
            } else {
                $stat = "Cancel";
                $sn = "disabled";
                $pr = "disabled";
            }

            if ($row->retp == 1) {
                $retp = "General";
                $sn = "disabled";
                $pr = "disabled";
            } else if ($row->retp == 2) {
                $retp = "Repaymemt";
                $sn = "";
                $pr = "";
            } else if ($row->retp == 3) {
                $retp = "Deposit";
                $sn = "disabled";
                $pr = "disabled";
            } else if ($row->retp == 4) {
                $retp = "Topup";
                $sn = "";
                $pr = "";
            } else {
                $retp = "--";
                $sn = "disabled";
                $pr = "disabled";
            }

            if ($row->remd == 1) {
                $remd = "At Office";
            } else if ($row->remd == 2) {
                $remd = "Mobile";
            } else if ($row->remd == 3) {
                $remd = "Online";
            } else {
                $remd = "--";
            }

            $auid = $row->reid;

            $option = "<button type='button' id='app' $apv $sn data-toggle='modal' data-target='#modalEdt' onclick='sendRecipt($auid,id);' class='btn btn-default btn-condensed' title='Send Mail'><i class='fa fa-envelope' aria-hidden='true'></i></button>  " .
                "<button type='button' id='pnt' $prn $pr onclick='prntRecipt($auid);' class='btn btn-default btn-condensed' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button> ";


            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->reno;
            $sub_arr[] = $retp;
            $sub_arr[] = $remd;
            $sub_arr[] = number_format($row->ramt, 2);
            $sub_arr[] = $row->tem_name;
            $sub_arr[] = $stat;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_rceipt(),
            "recordsFiltered" => $this->Report_model->count_filtered_rceipt(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printReceipts($brn, $exc, $cen, $frdt, $todt, $rctp, $rcst)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_rcpt');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Receipt Report');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;
        $_POST['rctp'] = $rctp;
        $_POST['rcst'] = $rcst;

        $result = $this->Report_model->rceipt_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Receipts Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "RECEIPTS DETAILS ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(10, 20);
        $this->pdf2->Cell(0, 0, "From " . $frdt . "    " . "To " . $todt, 0, 1, 'C');

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 10);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        /*$this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, '$center', 0, 1, 'L');
        $this->pdf2->SetXY(250, 25);
        $this->pdf2->Cell(10, 6, '$executive', 0, 1, 'L');
        $this->Image($img, 5, 5, 30, 20, '');
        $this->SetXY(9, 28); */

        // Column widths
        $this->pdf2->SetY(25);
        $header = array('NO', 'BRCH', 'CUST NO', ' CUST NAME', 'RECEIPTS NO', 'RECEIPTS TYPE', 'AMOUNT', 'PAY TYPE', 'STATUS', 'USER', 'CREATE DATE');
        $w = array(10, 10, 30, 50, 30, 30, 20, 20, 20, 25, 35);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $ttl = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {
            if ($row->retp == 1) {
                $retp = "General Payment";
            } else if ($row->retp == 2) {
                $retp = "Repaymemt";
            } else if ($row->retp == 3) {
                $retp = "Deposit Payment";
            } else if ($row->retp == 4) {
                $retp = "Topup Payment";
            } else {
                $retp = "--";
            }

            if ($row->stat == 1) {
                $stat = "Active";
            } else {
                $stat = "Cancel";
            }
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[2], 6, $row->cuno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->init, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->reno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $retp, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[6], 6, number_format($row->ramt, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, $row->tem_name, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[8], 6, $stat, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[9], 6, $row->usnm, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[10], 6, $row->crdt, 'LR', 0, 'L', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttl = $ttl + $row->ramt;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, number_format($ttl, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, '', 'LR', 0, 'R', $fill);

// Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Receipts Report');
        $this->pdf2->Output('Receipts Report.pdf', 'I');
        ob_end_flush();
    }


// END RECEIPTS
//
// REPORT VOUCHER
    function rpt_vouc()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_vouc');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['vutpinfo'] = $this->Generic_model->getData('vouc_type', '', array('stat' => 1));

        $this->load->view('modules/report/rpt_vouchers', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function searchVouc()
    {
        $result = $this->Report_model->get_vouchers();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->mode == 1) {
                $vutp = "Credit Voucher";
            } else if ($row->mode == 2) {
                $vutp = "Incash Group Voucher";
            } else if ($row->mode == 3) {
                $vutp = "General Voucher";
            } else if ($row->mode == 4) {
                $vutp = "Gift Voucher";
            } else {
                $vutp = "--";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->vuno;
            $sub_arr[] = $row->pynm;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $vutp;
            $sub_arr[] = number_format($row->vuam, 2);
            $sub_arr[] = number_format($row->tohnd, 2);
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $row->usnm;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_vouchers(),
            "recordsFiltered" => $this->Report_model->count_filtered_vouchers(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printVouc($brn, $exc, $cen, $frdt, $todt, $vutp)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Voucher Report');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;
        $_POST['vutp'] = $vutp;

        $result = $this->Report_model->vouchers_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Voucher Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "VOUCHERS DETAILS ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(10, 20);
        $this->pdf2->Cell(0, 0, "From " . $frdt . "    " . "To " . $todt, 0, 1, 'C');

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 10);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        /*$this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, '$center', 0, 1, 'L');
        $this->pdf2->SetXY(250, 25);
        $this->pdf2->Cell(10, 6, '$executive', 0, 1, 'L');
        $this->Image($img, 5, 5, 30, 20, '');
        $this->SetXY(9, 28); */

        // Column widths
        $this->pdf2->SetY(25);
        $header = array('NO', 'BRCH', 'VOUCHER NO', 'CUST NAME', ' CUST NO', 'VOUCHER TYPE', 'AMOUNT', 'TO HAND', 'USER', 'CREATE DATE');
        $w = array(10, 10, 30, 50, 30, 40, 22, 22, 26, 35);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $ttlamt = $ttlhnd = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {
            if ($row->mode == 1) {
                $vutp = "Credit Voucher";
            } else if ($row->mode == 2) {
                $vutp = "Incash Group Voucher";
            } else if ($row->mode == 3) {
                $vutp = "General Voucher";
            } else if ($row->mode == 4) {
                $vutp = "Gift Voucher";
            } else {
                $vutp = "--";
            }

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->vuno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->pynm, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->cuno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $vutp, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[6], 6, number_format($row->vuam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->tohnd, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->usnm, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[9], 6, $row->crdt, 'LR', 0, 'L', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttlamt = $ttlamt + $row->vuam;
            $ttlhnd = $ttlhnd + $row->tohnd;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, number_format($ttlamt, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($ttlhnd, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, '', 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Voucher Report');
        $this->pdf2->Output('Voucher Report.pdf', 'I');
        ob_end_flush();
    }
// END VOUCHER
//
// REPORT REPAYMENT
    function rpt_rpsht()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prductinfo'] = $this->Generic_model->getData('prdt_typ', array('prid,prtp,stat'), 'stat = 1 AND prbs IN(1,2)', '');

        $this->load->view('modules/report/rpt_repayment', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function searchRepymnt()
    {
        $result = $this->Report_model->get_repymntsheet();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->grno;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = $row->brcd . ' / ' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = number_format($row->arres, 2);
            $sub_arr[] = number_format($row->baln, 2);
            $sub_arr[] = $row->cage;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_repymnt(),
            "recordsFiltered" => $this->Report_model->count_filtered_repymnt(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printRepymnt($brn, $exc, $cen, $grp, $prd)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Repayment Sheet');

        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($exc != 'all') {
            $ofcinfo = $this->Generic_model->getData('user_mas', array('usnm'), array('auid' => $exc));
            $usnm = $ofcinfo[0]->usnm;
        } else {
            $usnm = "All Officers";
        }

        if ($cen != 'all') {
            $cntinfo = $this->Generic_model->getData('cen_mas', array('cnnm'), array('caid' => $cen));
            $cnnm = $cntinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Voucher Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "LOAN REPAYMENT SHEET ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(10, 20);
        // $this->pdf2->Cell(0, 0, "From " . $frdt . "    " . "To " . $todt, 0, 1, 'C');

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 10);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 15, "Officer : " . $usnm, 0, 1, 'L');


        // Column widths
        $this->pdf2->SetFont('Helvetica', 'B', 8);
        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();

        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(8, 13, 'NO', 1, 1, 'C');

        $this->pdf2->SetXY(13, $cy);
        $this->pdf2->Cell(8, 13, 'GRP', 1, 1, 'C');

        $this->pdf2->SetXY(21, $cy);
        $this->pdf2->Cell(10, 13, 'PRCD', 1, 1, 'C');

        $this->pdf2->SetXY(31, $cy);
        $this->pdf2->Cell(41, 13, 'CUSTOMER NAME', 1, 1, 'C');

        $this->pdf2->SetXY(72, $cy);
        $this->pdf2->Cell(20, 13, 'MOBILE', 1, 1, 'C');

        $this->pdf2->SetXY(92, $cy);
        $this->pdf2->Cell(18, 13, 'LOAN AMT', 1, 1, 'C');

        $this->pdf2->SetXY(110, $cy);
        $this->pdf2->Cell(20, 13, 'RENTAL', 1, 1, 'C');

        $this->pdf2->SetXY(130, $cy);
        $this->pdf2->Cell(20, 13, 'ARR AMT', 1, 1, 'C');

        $this->pdf2->SetXY(150, $cy);
        $this->pdf2->Cell(26, 13, 'CURR BAL', 1, 1, 'C');

        $this->pdf2->SetXY(176, $cy);
        $this->pdf2->Cell(12, 13, 'AGE', 1, 1, 'C');

        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(188, $cy + 6.5);
        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(201, $cy + 6.5);
        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(214, $cy + 6.5);
        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(227, $cy + 6.5);
        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(240, $cy + 6.5);
        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(253, $cy + 6.5);
        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(266, $cy + 6.5);
        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(279, $cy + 6.5);
        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');

        // GET GROUP FOR GROUPING
        $this->db->select("grup_mas.grno,grup_mas.grpid ");
        $this->db->from("cus_mas");
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno');

        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cus_mas.exec', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt', $cen);
        }
        if ($grp != 'all') {
            $this->db->where('cus_mas.grno', $grp);
        }

        $this->db->group_by('grup_mas.grno', 'ASC');

        $query = $this->db->get();
        $data['group'] = $query->result();

        $ttlamt = $ttlhnd = 0;
        $i = 1;
        $tlan = 0;
        $trnt = 0;
        $tarry = 0;
        $tcubal = 0;

        foreach ($data['group'] as $group) {
            $au2 = 1;
            $cy = $this->pdf2->GetY();
            $this->pdf2->SetFillColor(235, 235, 224);
            $this->pdf2->SetXY(5, $cy);
            $this->pdf2->Cell(287, 7, 'GROUP ' . $group->grno, 1, 1, 'L', true);

            $this->db->select("grup_mas.grno,cus_mas.init,cus_mas.anic,cus_mas.mobi ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,user_mas.usnm ,cus_mas.init,cus_mas.cuno,product.prcd,
                (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres,  cen_mas.cnnm,
                ((micr_crt.boc + micr_crt.boi + micr_crt.avdb + micr_crt.avpe ) - micr_crt.avcr ) AS baln,  IFNULL(micr_crt.cage,0) AS cage,
                    ");
            $this->db->from("cus_mas");
            $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco');
            $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec');
            $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt');
            $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno');
            $this->db->join('micr_crt', 'micr_crt.apid = cus_mas.cuid', 'left');
            $this->db->join('product', 'product.auid = micr_crt.prdtp', 'left');

            $this->db->where('micr_crt.stat IN(5)');
            $this->db->where('grup_mas.grpid', $group->grpid);

            if ($prd != 'all') {
                $this->db->where('micr_crt.prdtp', $prd);
            }

            $this->db->order_by('cus_mas.anic', 'asc');


            $query = $this->db->get();
            $data['cust'] = $query->result();

            foreach ($data['cust'] as $row) {

                $this->pdf2->SetFont('Helvetica', '', 8);
                $cy = $this->pdf2->GetY();
                //NO
                $this->pdf2->SetXY(5, $cy);
                $this->pdf2->Cell(8, 7, $i, 1, 1, 'C');

                //GROUP NO
                $this->pdf2->SetXY(13, $cy);
                $this->pdf2->Cell(8, 7, $row->grno, 1, 1, 'C');

                //PRCD NO
                $this->pdf2->SetXY(21, $cy);
                $this->pdf2->Cell(10, 7, $row->prcd, 1, 1, 'C');


                //CUSTOMER
                $this->pdf2->SetXY(31, $cy);
                $this->pdf2->Cell(41, 7, substr($row->init, -30), 1, 1, 'L');   //number_format($row1['loam'],0, '.', ',')

                //MOBILE
                $this->pdf2->SetXY(72, $cy);
                $this->pdf2->Cell(20, 7, $row->mobi, 1, 1, 'R');

                //LOAN AMOUNT
                $this->pdf2->SetXY(92, $cy);
                $this->pdf2->Cell(18, 7, number_format($row->loam, 2, '.', ','), 1, 1, 'R');

                //RENTAL
                $this->pdf2->SetXY(110, $cy);
                $this->pdf2->Cell(20, 7, number_format($row->inam, 2, '.', ','), 1, 1, 'R');

                //ARR AMT
                $this->pdf2->SetXY(130, $cy);
                $this->pdf2->Cell(20, 7, number_format($row->arres, 2, '.', ','), 1, 1, 'R');

                //CURRENT BALANCE
                $this->pdf2->SetXY(150, $cy);
                $this->pdf2->Cell(26, 7, number_format($row->baln, 2, '.', ','), 1, 1, 'R');

                //AGE
                $this->pdf2->SetXY(176, $cy);
                $this->pdf2->Cell(12, 7, $row->cage, 1, 1, 'R');//$rr

                //1ST WEEKS
                $this->pdf2->SetXY(188, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
                $this->pdf2->SetXY(201, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

                //2ND WEEKS
                $this->pdf2->SetXY(214, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
                $this->pdf2->SetXY(227, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

                //3RD WEEKS
                $this->pdf2->SetXY(240, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'R');    //$rr
                $this->pdf2->SetXY(253, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

                //4TH WEEKS
                $this->pdf2->SetXY(266, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
                $this->pdf2->SetXY(279, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

                $au2++;
                $i++;
                $tlan += $row->loam;
                $trnt += $row->inam;
                $tarry += $row->arres;
                $tcubal += $row->baln;

                // 153
                $cy = $this->pdf2->GetY();
                if ($cy >= 170) {                       //   Add New Page
                    $this->pdf2->AddPage('L');
                    $this->pdf2->SetMargins(10, 10, 10);
                    $this->pdf2->SetAuthor('www.gdcreations.com');
                    $this->pdf2->SetTitle('LOAN REPAYMENT SHEET');
                    $this->pdf2->SetDisplayMode('default');

                    $this->pdf2->SetY(15);
                    $this->pdf2->SetFont('Helvetica', 'B', 15);
                    $this->pdf2->Cell(0, 0, "LOAN REPAYMENT SHEET ", 0, 1, 'C');
                    $this->pdf2->SetFont('Helvetica', 'B', 11);
                    $this->pdf2->SetXY(10, 20);
                    $this->pdf2->SetFont('Helvetica', 'B', 9);
                    $this->pdf2->SetXY(250, 10);
                    $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
                    $this->pdf2->SetXY(250, 15);
                    $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
                    $this->pdf2->SetXY(250, 20);
                    $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');

                    $cy = 35;
                    $this->pdf2->SetY(5);
                    $this->pdf2->SetFont('Helvetica', 'B', 8);
                    $this->pdf2->SetXY(5, $cy);
                    $this->pdf2->Cell(8, 13, 'NO', 1, 1, 'C');

                    $this->pdf2->SetXY(13, $cy);
                    $this->pdf2->Cell(8, 13, 'GRP', 1, 1, 'C');

                    $this->pdf2->SetXY(21, $cy);
                    $this->pdf2->Cell(10, 13, 'PRCD', 1, 1, 'C');

                    $this->pdf2->SetXY(31, $cy);
                    $this->pdf2->Cell(41, 13, 'CUSTOMER NAME', 1, 1, 'C');
                    $this->pdf2->SetXY(72, $cy);
                    $this->pdf2->Cell(20, 13, 'MOBILE', 1, 1, 'C');
                    $this->pdf2->SetXY(92, $cy);
                    $this->pdf2->Cell(18, 13, 'LOAN AMT', 1, 1, 'C');
                    $this->pdf2->SetXY(110, $cy);
                    $this->pdf2->Cell(20, 13, 'RENTAL', 1, 1, 'C');
                    $this->pdf2->SetXY(130, $cy);
                    $this->pdf2->Cell(20, 13, 'ARR AMT', 1, 1, 'C');
                    $this->pdf2->SetXY(150, $cy);
                    $this->pdf2->Cell(26, 13, 'CURR BAL', 1, 1, 'C');
                    $this->pdf2->SetXY(176, $cy);
                    $this->pdf2->Cell(12, 13, 'AGE', 1, 1, 'C');

                    $this->pdf2->SetXY(188, $cy);
                    $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(188, $cy + 6.5);
                    $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(201, $cy + 6.5);
                    $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(214, $cy);
                    $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(214, $cy + 6.5);
                    $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(227, $cy + 6.5);
                    $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(240, $cy);
                    $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(240, $cy + 6.5);
                    $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(253, $cy + 6.5);
                    $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(266, $cy);
                    $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(266, $cy + 6.5);
                    $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(279, $cy + 6.5);
                    $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                    $cy = $this->pdf2->GetY();
                } else {
                    $cy = $cy + 7;
                }
            }

            // ********************************************************************
            // ********************************************************************
            // ADD NEW BLANK ROW
            if ($au2 < '4') {
                $aa = 5;
                $n = 1;
                $ba = $aa - $au2;
                while ($n <= $ba) {
                    $cy = $this->pdf2->GetY();              // blank row2
                    $this->pdf2->SetXY(5, $cy);
                    $this->pdf2->Cell(8, 7, ' ', 1, 1, 'C');

                    $this->pdf2->SetXY(13, $cy);
                    $this->pdf2->Cell(8, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(21, $cy);
                    $this->pdf2->Cell(10, 7, '', 1, 1, 'C');

                    $this->pdf2->SetXY(31, $cy);
                    $this->pdf2->Cell(41, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(72, $cy);
                    $this->pdf2->Cell(20, 7, ' ', 1, 1, 'C');
                    $this->pdf2->SetXY(92, $cy);
                    $this->pdf2->Cell(18, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(110, $cy);
                    $this->pdf2->Cell(20, 7, ' ', 1, 1, 'C');
                    $this->pdf2->SetXY(130, $cy);
                    $this->pdf2->Cell(20, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(150, $cy);
                    $this->pdf2->Cell(26, 7, ' ', 1, 1, 'C');
                    $this->pdf2->SetXY(176, $cy);
                    $this->pdf2->Cell(12, 7, '', 1, 1, 'C');

                    $this->pdf2->SetXY(188, $cy);
                    $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(201, $cy);
                    $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(214, $cy);
                    $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(227, $cy);
                    $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(240, $cy);
                    $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(253, $cy);
                    $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(266, $cy);
                    $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                    $this->pdf2->SetXY(279, $cy);
                    $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                    $n++;

                    $cy = $this->pdf2->GetY();
                    if ($cy >= 175) {                       //   Add New Page
                        $this->pdf2->AddPage('L');
                        $this->pdf2->SetMargins(10, 10, 10);
                        $this->pdf2->SetAuthor('www.gdcreations.com');
                        $this->pdf2->SetTitle('LOAN REPAYMENT SHEET');
                        $this->pdf2->SetDisplayMode('default');
                        $cy = 25;
                        $this->pdf2->SetY(5);
                        $this->pdf2->SetFont('Helvetica', 'B', 8);
                        $this->pdf2->SetXY(5, $cy);
                        $this->pdf2->Cell(8, 13, 'NO', 1, 1, 'C');

                        $this->pdf2->SetXY(13, $cy);
                        $this->pdf2->Cell(8, 13, 'GRP', 1, 1, 'C');

                        $this->pdf2->SetXY(21, $cy);
                        $this->pdf2->Cell(10, 13, 'PRCD', 1, 1, 'C');

                        $this->pdf2->SetXY(31, $cy);
                        $this->pdf2->Cell(41, 13, 'CUSTOMER NAME', 1, 1, 'C');
                        $this->pdf2->SetXY(72, $cy);
                        $this->pdf2->Cell(20, 13, 'MOBILE', 1, 1, 'C');
                        $this->pdf2->SetXY(92, $cy);
                        $this->pdf2->Cell(18, 13, 'LOAN AMT', 1, 1, 'C');
                        $this->pdf2->SetXY(110, $cy);
                        $this->pdf2->Cell(20, 13, 'RENTAL', 1, 1, 'C');
                        $this->pdf2->SetXY(130, $cy);
                        $this->pdf2->Cell(20, 13, 'ARR AMT', 1, 1, 'C');
                        $this->pdf2->SetXY(150, $cy);
                        $this->pdf2->Cell(26, 13, 'CURR BAL', 1, 1, 'C');
                        $this->pdf2->SetXY(176, $cy);
                        $this->pdf2->Cell(12, 13, 'AGE', 1, 1, 'C');

                        $this->pdf2->SetXY(188, $cy);
                        $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(188, $cy + 6.5);
                        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(201, $cy + 6.5);
                        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(214, $cy);
                        $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(214, $cy + 6.5);
                        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(227, $cy + 6.5);
                        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(240, $cy);
                        $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(240, $cy + 6.5);
                        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(253, $cy + 6.5);
                        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(266, $cy);
                        $this->pdf2->Cell(26, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(266, $cy + 6.5);
                        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                        $this->pdf2->SetXY(279, $cy + 6.5);
                        $this->pdf2->Cell(13, 6.5, '', 1, 1, 'C');
                        $cy = $this->pdf2->GetY();

                    } else {
                        $cy = $cy + 7;
                    }

                }
            } else {
                $cy = $this->pdf2->GetY();              // blank row1
                $this->pdf2->SetXY(5, $cy);
                $this->pdf2->Cell(8, 7, ' ', 1, 1, 'C');

                $this->pdf2->SetXY(13, $cy);
                $this->pdf2->Cell(8, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(21, $cy);
                $this->pdf2->Cell(10, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(31, $cy);
                $this->pdf2->Cell(41, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(72, $cy);
                $this->pdf2->Cell(20, 7, ' ', 1, 1, 'C');
                $this->pdf2->SetXY(92, $cy);
                $this->pdf2->Cell(18, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(110, $cy);
                $this->pdf2->Cell(20, 7, ' ', 1, 1, 'C');
                $this->pdf2->SetXY(130, $cy);
                $this->pdf2->Cell(20, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(150, $cy);
                $this->pdf2->Cell(26, 7, ' ', 1, 1, 'C');
                $this->pdf2->SetXY(176, $cy);
                $this->pdf2->Cell(12, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(188, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(201, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(214, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(227, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(240, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(253, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(266, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(279, $cy);
                $this->pdf2->Cell(13, 7, '', 1, 1, 'C');
            }
            $au2 = 1;
            //$n++;
            // END ADD NEW BLANK ROW
        }

        // ************************************************************************
        // ************************************************************************
        //TOTALL
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFillColor(163, 194, 194);
        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(67, 7, 'CSU TOTAL COLLECTION', 1, 1, 'C', true);

        //LOAN AMOUNT
        $this->pdf2->SetXY(72, $cy);
        $this->pdf2->Cell(20, 7, '', 1, 1, 'R', true);

        //RENTAL
        $this->pdf2->SetXY(92, $cy);
        $this->pdf2->Cell(18, 7, number_format($tlan, 2, '.', ','), 1, 1, 'R', true);

        //ARR AMT
        $this->pdf2->SetXY(110, $cy);
        $this->pdf2->Cell(20, 7, number_format($trnt, 2, '.', ','), 1, 1, 'R', true);

        //AGE
        $this->pdf2->SetXY(130, $cy);
        $this->pdf2->Cell(20, 7, number_format($tarry, 2, '.', ','), 1, 1, 'R', true);

        //CURRENT BALANCE
        $this->pdf2->SetXY(150, $cy);
        $this->pdf2->Cell(26, 7, number_format($tcubal, 2, '.', ','), 1, 1, 'R', true);

        //1ST WEEKS
        $this->pdf2->SetXY(176, $cy);
        $this->pdf2->Cell(12, 7, '', 1, 1, 'R', true);//$rr

        //2ND WEEKS
        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R', true);//$rr

        $this->pdf2->SetXY(201, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R', true);//$ccb

        //3RD WEEKS
        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R', true);//$rr

        $this->pdf2->SetXY(227, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R', true);//$ccb

        //4TH WEEKS
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R', true);    //$rr

        $this->pdf2->SetXY(253, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R', true);//$ccb

        //5TH WEEKS
        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R', true);//$rr

        $this->pdf2->SetXY(279, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R', true);//$ccb


        //   ************** SUMMER PAGE  ***********************
        //ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('REPAYMENT SHEETS');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(157, 7, 'NO OF UNDER PAYMENT', 1, 1, 'L');

        //1ST WEEKS
        $this->pdf2->SetXY(162, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(175, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //2ND WEEKS
        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(201, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //3RD WEEKS
        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(227, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //4TH WEEKS
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');    //$rr
        $this->pdf2->SetXY(253, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //5TH WEEKS
        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(279, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        $cy = $this->pdf2->GetY();

        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(157, 7, 'UNDER PAYMENT AMOUNT', 1, 1, 'L');

        //1ST WEEKS
        $this->pdf2->SetXY(162, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(175, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //2ND WEEKS
        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(201, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //3RD WEEKS
        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(227, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //4TH WEEKS
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');    //$rr
        $this->pdf2->SetXY(253, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //5TH WEEKS
        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(279, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        $cy = $this->pdf2->GetY();

        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(157, 7, 'NO OF NOT PAYMENT', 1, 1, 'L');

        //1ST WEEKS
        $this->pdf2->SetXY(162, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(175, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //2ND WEEKS
        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(201, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //3RD WEEKS
        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(227, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //4TH WEEKS
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');    //$rr
        $this->pdf2->SetXY(253, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //5TH WEEKS
        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(279, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        $cy = $this->pdf2->GetY();

        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(157, 7, 'NOT PAYMENT AMOUNT', 1, 1, 'L');

        //1ST WEEKS
        $this->pdf2->SetXY(162, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(175, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //2ND WEEKS
        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(201, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //3RD WEEKS
        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(227, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //4TH WEEKS
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');    //$rr
        $this->pdf2->SetXY(253, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb

        //5TH WEEKS
        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$rr
        $this->pdf2->SetXY(279, $cy);
        $this->pdf2->Cell(13, 7, '', 1, 1, 'R');//$ccb


        $cy = $this->pdf2->GetY() + 5;
        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(127, 9, ' CSU MANAGER', 0, 1, 'L');
        $this->pdf2->SetXY(162, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(127, 9, ' CASHIER', 0, 1, 'L');

        $this->pdf2->SetXY(162, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(127, 9, ' MICRO MANAGER', 0, 1, 'L');
        $this->pdf2->SetXY(162, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(188, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(214, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');
        $this->pdf2->SetXY(266, $cy);
        $this->pdf2->Cell(26, 9, '----------------------', 0, 1, 'C');

        $this->pdf2->SetTitle('Repayment Sheet');
        $this->pdf2->Output('Repayment Sheet.pdf', 'I');
        ob_end_flush();
    }

    //  PRINT ATTENDANCES
    function printCustAttnd($brn, $exc, $cen, $grp, $prd)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Customer Attandence Sheet');

        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $cntinfo = $this->Generic_model->getData('cen_mas', array('cnnm'), array('caid' => $cen));
            $cnnm = $cntinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('customer attendance sheet');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "CUSTOMER ATTENDANCES SHEET ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(10, 20);

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 10);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt2, 0, 1, 'L');
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');


        // Column widths
        $this->pdf2->SetFont('Helvetica', 'B', 8);
        $this->pdf2->SetY(30);
        $cy = $this->pdf2->GetY();

        //$this->pdf2->SetXY(5, $cy);
        //$this->pdf2->Cell(8, 13, 'NO', 1, 1, 'C');

        $this->pdf2->SetXY(5, $cy);
        $this->pdf2->Cell(28, 13, 'CUST NO', 1, 1, 'C');
        $this->pdf2->SetXY(33, $cy);
        $this->pdf2->Cell(55, 13, 'CUSTOMER NAME', 1, 1, 'C');
        $this->pdf2->SetXY(88, $cy);
        $this->pdf2->Cell(33, 13, 'Mobile', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy + 6.5);
        $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

        // GET GROUP FOR GROUPING
        $this->db->select("grup_mas.grno,grup_mas.grpid ");
        $this->db->from("cus_mas");
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno');

        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cus_mas.exec', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt', $cen);
        }
        if ($grp != 'all') {
            $this->db->where('cus_mas.grno', $grp);
        }
        $this->db->group_by('grup_mas.grno', 'ASC');

        $query = $this->db->get();
        $data['group'] = $query->result();

        $ttlamt = $ttlhnd = 0;
        $i = 1;
        $tlan = 0;
        $trnt = 0;
        $tarry = 0;
        $tcubal = 0;

        foreach ($data['group'] as $group) {
            $au2 = 1;
            $cy = $this->pdf2->GetY();
            $this->pdf2->SetFillColor(235, 235, 224);
            $this->pdf2->SetXY(5, $cy);
            $this->pdf2->Cell(291, 7, 'GROUP ' . $group->grno, 1, 1, 'L', true);

            $this->db->select("grup_mas.grno,cus_mas.init,cus_mas.anic,cus_mas.mobi ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,user_mas.usnm ,cus_mas.init,cus_mas.cuno,
                (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres,  cen_mas.cnnm,
                ((micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe + micr_crt.boc + micr_crt.boi) - micr_crt.avcr ) AS baln,  IFNULL(micr_crt.cage,0) AS cage,
                    ");
            $this->db->from("cus_mas");
            $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco');
            $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec');
            $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt');
            $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno');
            $this->db->join('micr_crt', 'micr_crt.apid = cus_mas.cuid', 'left');

            $this->db->where('micr_crt.stat IN(3,5)');
            $this->db->where('grup_mas.grpid', $group->grpid);
            $query = $this->db->get();
            $data['cust'] = $query->result();

            foreach ($data['cust'] as $row) {

                $this->pdf2->SetFont('Helvetica', '', 8);
                $cy = $this->pdf2->GetY();

                $this->pdf2->SetXY(5, $cy);
                $this->pdf2->Cell(28, 7, $row->cuno, 1, 1, 'C');
                $this->pdf2->SetXY(33, $cy);
                $this->pdf2->Cell(55, 7, substr($row->init, -30), 1, 1, 'L');
                $this->pdf2->SetXY(88, $cy);
                $this->pdf2->Cell(33, 7, $row->mobi, 1, 1, 'C');

                $this->pdf2->SetXY(121, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(128, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(135, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(142, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(149, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(156, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(163, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(170, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(177, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(184, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(191, $cy);
                $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(191, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(198, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(205, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(212, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(219, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(226, $cy);
                $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(226, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(233, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(240, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(247, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(254, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(261, $cy);
                $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

                $this->pdf2->SetXY(261, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(268, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(275, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(282, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
                $this->pdf2->SetXY(289, $cy);
                $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

                $au2++;
                $i++;

                // 153
                $cy = $this->pdf2->GetY();
                if ($cy >= 170) {                       //   Add New Page
                    $this->pdf2->AddPage('L');
                    $this->pdf2->SetMargins(10, 10, 10);
                    $this->pdf2->SetAuthor('www.gdcreations.com');
                    $this->pdf2->SetTitle('Customer attendance sheet');
                    $this->pdf2->SetDisplayMode('default');
                    $cy = 15;
                    $this->pdf2->SetY(5);
                    $this->pdf2->SetFont('Helvetica', 'B', 8);

                    $this->pdf2->SetXY(5, $cy);
                    $this->pdf2->Cell(28, 13, 'CUST NO', 1, 1, 'C');
                    $this->pdf2->SetXY(33, $cy);
                    $this->pdf2->Cell(55, 13, 'CUSTOMER NAME', 1, 1, 'C');
                    $this->pdf2->SetXY(88, $cy);
                    $this->pdf2->Cell(33, 13, 'Mobile', 1, 1, 'C');

                    $this->pdf2->SetXY(121, $cy);
                    $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(121, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(128, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(135, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(142, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(149, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(156, $cy);
                    $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(156, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(163, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(170, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(177, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(184, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(191, $cy);
                    $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(191, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(198, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(205, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(212, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(219, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(226, $cy);
                    $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(226, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(233, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(240, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(247, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(254, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(261, $cy);
                    $this->pdf2->Cell(35, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(261, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(268, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(275, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(282, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(289, $cy + 6.5);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $cy = $this->pdf2->GetY();
                } else {
                    $cy = $cy + 7;
                }
            }

            // ********************************************************************
            // ********************************************************************
            // ADD NEW BLANK ROW
            if ($au2 < '4') {
                $aa = 5;
                $n = 1;
                $ba = $aa - $au2;
                while ($n <= $ba) {
                    $cy = $this->pdf2->GetY();              // blank row2
                    $this->pdf2->SetXY(5, $cy);
                    $this->pdf2->Cell(28, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(33, $cy);
                    $this->pdf2->Cell(55, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(88, $cy);
                    $this->pdf2->Cell(33, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(121, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(128, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(135, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(142, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(149, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(156, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(163, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(170, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(177, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(184, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(191, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(198, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(205, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(212, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(219, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(226, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(233, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(240, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(247, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(254, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                    $this->pdf2->SetXY(261, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(268, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(275, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(282, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $this->pdf2->SetXY(289, $cy);
                    $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                    $n++;
                }
            } else {
                $cy = $this->pdf2->GetY();              // blank row1
                $this->pdf2->SetXY(5, $cy);
                $this->pdf2->Cell(28, 6.5, ' ', 1, 1, 'C');
                $this->pdf2->SetXY(33, $cy);
                $this->pdf2->Cell(55, 6.5, ' ', 1, 1, 'C');
                $this->pdf2->SetXY(88, $cy);
                $this->pdf2->Cell(33, 6.5, '', 1, 1, 'C');

                $this->pdf2->SetXY(121, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(128, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(135, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(142, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(149, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                $this->pdf2->SetXY(156, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(163, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(170, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(177, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(184, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                $this->pdf2->SetXY(191, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(198, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(205, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(212, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(219, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                $this->pdf2->SetXY(226, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(233, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(240, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(247, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(254, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');

                $this->pdf2->SetXY(261, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(268, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(275, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(282, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
                $this->pdf2->SetXY(289, $cy);
                $this->pdf2->Cell(7, 6.5, '', 1, 1, 'C');
            }
            $au2 = 1;
            //$n++;
            // END ADD NEW BLANK ROW
        }

        // ************************************************************************
        // ************************************************************************
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Customer attendance sheet');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetY(15);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(3, $cy);
        $this->pdf2->Cell(83, 7, ' PRESENT', 1, 1, 'L');

        $this->pdf2->SetXY(86, $cy);
        $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        //        $this->pdf2->AddPage('L');                     //  LATE
//        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(3, $cy);
        $this->pdf2->Cell(83, 7, ' LATE', 1, 1, 'L');

        $this->pdf2->SetXY(86, $cy);
        $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        //        $this->pdf2->AddPage('L');                     //  INFORM
//        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(3, $cy);
        $this->pdf2->Cell(83, 7, ' INFORM', 1, 1, 'L');

        $this->pdf2->SetXY(86, $cy);
        $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        //        $this->pdf2->AddPage('L');                     //  ABSENT
//        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(3, $cy);
        $this->pdf2->Cell(83, 7, ' ABSENT', 1, 1, 'L');

        $this->pdf2->SetXY(86, $cy);
        $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        //        $this->pdf2->AddPage('L');                     //  TOTAL
//        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(3, $cy);
        $this->pdf2->Cell(83, 7, ' TOTAL', 1, 1, 'L');

        $this->pdf2->SetXY(86, $cy);
        $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        //        $this->pdf2->AddPage('L');                     //  PRESENTAGE %
//        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(3, $cy);
        $this->pdf2->Cell(83, 7, ' PRESENTAGE %', 1, 1, 'L');

        $this->pdf2->SetXY(86, $cy);
        $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        //        $this->pdf2->AddPage('L');                     //  CSU MANAGER
//        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(3, $cy);
        $this->pdf2->Cell(83, 7, ' CSU MANAGER', 1, 1, 'L');

        $this->pdf2->SetXY(86, $cy);
        $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        //        $this->pdf2->AddPage('L');                     //  MICRO MANAGER
//        $this->pdf2->SetY(35);
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(3, $cy);
        $this->pdf2->Cell(83, 7, ' MICRO MANAGER', 1, 1, 'L');

        $this->pdf2->SetXY(86, $cy);
        $this->pdf2->Cell(35, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(121, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(135, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(142, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(149, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(156, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(163, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(170, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(184, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(191, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(198, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(205, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(212, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(219, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(226, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(233, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(240, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(247, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(254, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetXY(261, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(268, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(275, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(282, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(289, $cy);
        $this->pdf2->Cell(7, 7, '', 1, 1, 'C');

        $this->pdf2->SetTitle('customer attendance sheet');
        $this->pdf2->Output('customer attendance sheet.pdf', 'I');
        ob_end_flush();
    }

// END REPAYMENT
//
// REPORT TODAY ARREARS
    function rpt_tdysch()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['collinfo'] = $this->Generic_model->getData('cen_days', array('dyid', 'cday'), '');
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_todaySch', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function searchTdarrs()
    {
        $result = $this->Report_model->get_tdyArres();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->cage < 0) {
                $st = " <span class='label label-success'> Over pay </span> ";
            } else if ($row->cage == 0) {
                $st = " <span class='label label-info'> Normal </span> ";
            } else if ($row->cage > 0) {
                $st = "<span class='label label-danger'> Arrears </span> ";
            }

            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' / ' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $acno;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->baln, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = number_format($row->arres, 2);
            $sub_arr[] = $row->cage;
            $sub_arr[] = $st;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_tdyArres(),
            "recordsFiltered" => $this->Report_model->count_filtered_tdyArres(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printTodyArres($brn, $exc, $cen, $cndy, $prtp)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_tdysch');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Schedule Arrears Report');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['cndy'] = $cndy;
        $_POST['prtp'] = $prtp;

        $result = $this->Report_model->tdyArres_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $centinfo = $this->Generic_model->getData('cen_mas', array('caid', 'cnnm'), array('caid' => $cen));
            $cnnm = $centinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }
        $collinfo = $this->Generic_model->getData('cen_days', array('dyid', 'cday'), array('dyid' => $cndy));


        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Center  Schedule Arrears');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "CENTER SCHEDULE ARREARS ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(100, 22);
        $this->pdf2->Cell(10, 0, "Center Name : " . $cnnm, 0, 1, 'L');
        $this->pdf2->SetXY(175, 22);
        $this->pdf2->Cell(10, 0, "Center Day : " . $collinfo[0]->cday, 0, 1, 'L');

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH/CNT', 'NAME', 'NIC', ' LOAN NO', 'AMOUNT', 'BALANCE', 'RENTAL', 'ARREARS', 'AGE', 'STATUES');
        $w = array(10, 40, 45, 25, 35, 20, 20, 20, 20, 10, 30);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $tamt = $tbal = $trnt = $tarr = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {
            if ($row->cage < 0) {
                $sta = "Over payment";
            } else if ($row->cage == 0) {
                $sta = "Normal";
            } else if ($row->cage > 0) {
                $sta = "Arrears";
            } else {
                $sta = "--";
            }

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . ' / ' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->anic, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->acno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, number_format($row->loam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, number_format($row->baln, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->inam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, number_format($row->arres, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, $row->cage, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[10], 6, $sta, 'LR', 0, 'L', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $tamt += $row->loam;
            $tbal += $row->baln;
            $trnt += $row->inam;
            $tarr += $row->arres;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, number_format($tamt, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, number_format($tbal, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($trnt, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, number_format($tarr, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Center Schedule Report');
        $this->pdf2->Output('Center Schedule Report.pdf', 'I');
        ob_end_flush();
    }
// END TODAY ARREARS
//
// REPORT NOT PAID
    function rpt_notpaid()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_notpaid', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchNtpaid()
    {
        $result = $this->Report_model->get_notPaid();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->cage < 0) {
                $st = " <span class='label label-success'> Over pay </span> ";
            } else if ($row->cage == 0) {
                $st = " <span class='label label-info'> Normal </span> ";
            } else if ($row->cage > 0) {
                $st = "<span class='label label-danger'> Arrears </span> ";
            }

            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' / ' . $row->cnnm;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $acno;
            $sub_arr[] = number_format($row->inam, 2);
            // SHEDULE DAY
            $sub_arr[] = $row->ledt;
            $sub_arr[] = number_format($row->arres, 2);
            $sub_arr[] = $row->cage;
            $sub_arr[] = $st;
            // PAID DETAILS
            $sub_arr[] = number_format($row->lspa, 2);
            $sub_arr[] = $row->lspd;
            $sub_arr[] = number_format($row->ttpy, 2);
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_notPaid(),
            "recordsFiltered" => $this->Report_model->count_filtered_notPaid(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printNotpaid($brn, $exc, $cen, $prtp, $frdt, $todt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_notpaid');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Notpaid Report');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;

        $result = $this->Report_model->notPaid_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $centinfo = $this->Generic_model->getData('cen_mas', array('caid', 'cnnm'), array('caid' => $cen));
            $cnnm = $centinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Not Paid Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "NOT PAID REPORT ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(100, 22);
        $this->pdf2->Cell(10, 0, "From Date : " . $frdt, 0, 1, 'L');
        $this->pdf2->SetXY(165, 22);
        $this->pdf2->Cell(10, 0, "To Date : " . $todt, 0, 1, 'L');


        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 22);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH/ CNT', 'NAME', 'NIC', ' LOAN NO', 'RENTAL', 'SCH DATE', 'ARREARS', 'AGE', 'LST AMT', 'LST DATE', 'TTL PAID');
        $w = array(10, 35, 35, 25, 35, 20, 20, 20, 15, 20, 20, 20);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $trnt = $tlpd = $tarr = $ttpy = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {
            /*if ($row->cage < 0) {
                $sta = "Over payment";
            } else if ($row->cage == 0) {
                $sta = "Normal";
            } else if ($row->cage > 0) {
                $sta = "Arrears";
            } else {
                $sta = "--";
            }*/

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . ' / ' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->anic, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->acno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, number_format($row->inam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, $row->nxdd, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->arres, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->cage, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, number_format($row->lspa, 2), 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[10], 6, $row->lspd, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[11], 6, number_format($row->ttpy, 2), 'LR', 0, 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $trnt += $row->inam;
            $tlpd += $row->lspa;
            $tarr += $row->arres;
            $ttpy += $row->ttpy;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, number_format($trnt, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($tarr, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, number_format($tlpd, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[11], 6, number_format($ttpy, 2), 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Not paid Report');
        $this->pdf2->Output('Not Paid Report.pdf', 'I');
        ob_end_flush();
    }
// END NOT PAID
//
// REPORT LOAN SUMMERY
    function rpt_lnsum()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_loansummery', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function getCenterSummery()
    {
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $result = $this->Report_model->get_cntrsumry();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $brn = $row->brco;
            $exc = $row->clct;
            $cnt = $row->ccnt;
            $prd = $row->prdtp;

            $all = "<a href=#  title=All View  data-toggle=modal data-target=#modalView onclick='viewSummry12( 1,$brn,$cnt,$exc,$prd,$frdt,$todt)' > " . $row->cc0 . "  </a> ";

            // Current Paid
            if ($row->cc1 > 0) {
                $crt = "<a href='#'  title='Current'   data-toggle='modal' data-target='#modalView'  onclick='viewSummry12(2,$brn,$cnt,$exc,$prd,$frdt,$todt)' >" . $row->cc1 . "  </a> ";
            } else {
                $crt = '0';
            }
            //Non Paid
            if ($row->cc2 > 0) {
                $non = "<a href='#'  title='Non Paid' id='22'  data-toggle='modal' data-target='#modalView'  onclick='viewSummry12(3,$brn,$cnt,$exc,$prd,$frdt,$todt)' >" . $row->cc2 . "  </a> ";
            } else {
                $non = '0';
            }
            // Under Paid
            if ($row->cc3 > 0) {
                $udr = "<a href='#'  title='Under Paid' id='22'  data-toggle='modal' data-target='#modalView'  onclick='viewSummry12(4,$brn,$cnt,$exc,$prd,$frdt,$todt)' >" . $row->cc3 . "  </a> ";
            } else {
                $udr = '0';
            }
            // Arrears
            if ($row->cc4 > 0) {
                $arr = "<a href='#'  title='Arrears' id='22'  data-toggle='modal' data-target='#modalView'  onclick='viewSummry12(5,$brn,$cnt,$exc,$prd,$frdt,$todt )' >" . $row->cc4 . "  </a> ";
            } else {
                $arr = '0';
            }
            // Period Over
            if ($row->cc5 > 0) {
                $por = "<a href='#'  title='Period Over' id='22'  data-toggle='modal' data-target='#modalView'  onclick='viewSummry12(6,$brn,$cnt,$exc,$prd,$frdt,$todt  )' >" . $row->cc5 . "  </a> ";
            } else {
                $por = '0';
            }
            // Over Paid
            if ($row->cc6 > 0) {
                $orp = "<a href='#'  title='Over Paid' id='22'  data-toggle='modal' data-target='#modalView'  onclick='viewSummry12(7,$brn,$cnt,$exc,$prd,$frdt,$todt   )' > " . $row->cc6 . "  </a> ";
            } else {
                $orp = '0';
            }

//            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->fnme;
            $sub_arr[] = $row->prtp;
            $sub_arr[] = $all; // ALL
            $sub_arr[] = $crt; // CURRENR
            $sub_arr[] = $non; // NON PAID
            $sub_arr[] = $udr; // UNDER PAID
            $sub_arr[] = $arr; // ARREARS
            $sub_arr[] = $por; // PERIOS OVER
            $sub_arr[] = $orp; // OVER PAID

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_cntrsumry(),
            "recordsFiltered" => $this->Report_model->count_filtered_cntrsumry(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    // VIEW SUMMERY
    function loanViewSummery()
    {
        $result = $this->Report_model->get_viewsumry();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            /*$ag = $row->cage;
            if ($ag >= '5') {
                $age = " <span class='label label-danger  col-md-10'>" . round($ag, 2) . "</span> ";
            } else if ($ag > '2') {
                $age = " <span class='label label-primary  col-md-10'>" . round($ag, 2) . "</span> ";
            } else if ($ag > '0') {
                $age = " <span class='label label-warning col-md-10'>" . round($ag, 2) . "</span> ";
            } else if ($ag <= '0') {
                $age = " <span class='label label-success col-md-10'>" . round($ag, 2) . "</span> ";
            }*/

            if ($row->durg == '0' && $row->aboc > 0) {
                $stat = " OC ";
            } else {
                $stat = $row->nxpn . ' of ' . $row->noin;
            }

            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->init;
            $sub_arr[] = $acno;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->aboc, 2);
            $sub_arr[] = number_format($row->aboc + $row->aboi, 2);
            $sub_arr[] = number_format($row->aboc + $row->aboi, 2);
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = $row->cage;
            $sub_arr[] = $stat;

            $data[] = $sub_arr;
        }
        $output = array(
            /* "draw" => $_POST['draw'],
             "data" => $data,*/
            "sEcho" => 2,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function Az1($brn, $exc, $cen, $prtp, $frdt, $todt)
    {
        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;

        $result = $this->Report_model->notPaid_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $centinfo = $this->Generic_model->getData('cen_mas', array('caid', 'cnnm'), array('caid' => $cen));
            $cnnm = $centinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Not Paid Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "NOT PAID REPORT ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(100, 22);
        $this->pdf2->Cell(10, 0, "From Date : " . $frdt, 0, 1, 'L');
        $this->pdf2->SetXY(165, 22);
        $this->pdf2->Cell(10, 0, "To Date : " . $todt, 0, 1, 'L');


        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 22);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH/ CNT', 'NAME', 'NIC', ' LOAN NO', 'RENTAL', 'SCH DATE', 'ARREARS', 'AGE', 'LST AMT', 'LST DATE', 'TTL PAID');
        $w = array(10, 35, 35, 25, 35, 20, 20, 20, 15, 20, 20, 20);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $trnt = $tlpd = $tarr = $ttpy = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {
            /*if ($row->cage < 0) {
                $sta = "Over payment";
            } else if ($row->cage == 0) {
                $sta = "Normal";
            } else if ($row->cage > 0) {
                $sta = "Arrears";
            } else {
                $sta = "--";
            }*/

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . ' / ' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->anic, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->acno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, number_format($row->inam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, $row->nxdd, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->arres, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->cage, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, number_format($row->lspa, 2), 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[10], 6, $row->lspd, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[11], 6, number_format($row->ttpy, 2), 'LR', 0, 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $trnt += $row->inam;
            $tlpd += $row->lspa;
            $tarr += $row->arres;
            $ttpy += $row->ttpy;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, number_format($trnt, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($tarr, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, number_format($tlpd, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[11], 6, number_format($ttpy, 2), 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Not paid Report');
        $this->pdf2->Output('Not Paid Report.pdf', 'I');
        ob_end_flush();
    }
// END LOAN SUMMERY
//
// REPORT ARREARS AGE WISE
    function rpt_arsag()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_arrers_age_wise', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchArrsag()
    {
        $result = $this->Report_model->get_arrsAg();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->cage < 0) {
                $st = " <span class='label label-success'> Over pay </span> ";
            } else if ($row->cage == 0) {
                $st = " <span class='label label-info'> Normal </span> ";
            } else if ($row->cage > 0) {
                $st = "<span class='label label-danger'> Arrears </span> ";
            }

            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd . ' / ' . $row->cnnm;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $acno;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = $row->acdt;
            $sub_arr[] = number_format($row->arres, 2);
            $sub_arr[] = $row->cage;
            $sub_arr[] = $row->lspd;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_arrsAg(),
            "recordsFiltered" => $this->Report_model->count_filtered_arrsAg(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printArresAge($brn, $exc, $cen, $prtp, $frag, $toag)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_arsag');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Arrears Age Report');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['frag'] = $frag;
        $_POST['toag'] = $toag;

        $result = $this->Report_model->arrsAg_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $centinfo = $this->Generic_model->getData('cen_mas', array('caid', 'cnnm'), array('caid' => $cen));
            $cnnm = $centinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        if ($frag == '-100') {
            $aag = '<10';
        } else {
            $aag = $frag;
        }

        if ($toag == 100) {
            $bag = '>10';
        } else {
            $bag = $toag;
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "ARREARS AGE REPORT ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(120, 22);
        $this->pdf2->Cell(10, 0, "Arrears Age Rang : " . $aag . ' ~ ' . $bag, 0, 1, 'L');
        $this->pdf2->SetXY(165, 22);


        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 22);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH | CNT', 'OFFICER', 'PRDU', 'CUSTOMER', 'CUSTOMER NO', 'LOAN NO', 'AMMOUNT', 'START DATE', 'ARREARS', 'AGE', 'LAST PAY');
        $w = array(10, 30, 25, 15, 35, 30, 35, 25, 20, 25, 15, 20);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $ttln = $tarr = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . ' / ' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->usnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->prcd, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->cuno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, $row->acno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->loam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->acdt, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, number_format($row->arres, 2), 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[10], 6, $row->cage, 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[11], 6, $row->lspd, 'LR', 0, 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttln += $row->loam;
            $tarr += $row->arres;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($ttln, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, number_format($tarr, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[11], 6, '', 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->Output('Arrears Age Report.pdf', 'I');
        ob_end_flush();
    }
// END ARREARS AGE WISE
//
// REPORT PORTFOLIO
    function rpt_portfo()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_portfolio', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchPortfolio()
    {
        $result = $this->Report_model->get_portfolio();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $acno;

            $sub_arr[] = $row->lcnt;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->inta, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = $row->noin;
            $sub_arr[] = number_format($row->boc, 2);
            $sub_arr[] = number_format($row->boi, 2);
            $sub_arr[] = number_format($row->aboc, 2);
            $sub_arr[] = number_format($row->aboi, 2);

            $sub_arr[] = number_format($row->avpe, 2);
            $sub_arr[] = number_format($row->avcp, 2);
            $sub_arr[] = number_format($row->avin, 2);
            $sub_arr[] = number_format(($row->avcp + $row->avin), 2);

            $sub_arr[] = number_format($row->ttpym, 2);
            $sub_arr[] = number_format($row->avcr, 2);
            $sub_arr[] = number_format($row->docg, 2);
            $sub_arr[] = number_format($row->incg, 2);
            $sub_arr[] = $row->cage;

            $sub_arr[] = $row->acdt;
            $sub_arr[] = $row->madt;
            $sub_arr[] = $row->nxdd;

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_portfo(),
            "recordsFiltered" => $this->Report_model->count_filtered_portfo(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function Az2($brn, $exc, $cen, $prtp, $frag, $toag)
    {
        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['frag'] = $frag;
        $_POST['toag'] = $toag;

        $result = $this->Report_model->arrsAg_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $centinfo = $this->Generic_model->getData('cen_mas', array('caid', 'cnnm'), array('caid' => $cen));
            $cnnm = $centinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        if ($frag == '-100') {
            $aag = '<10';
        } else {
            $aag = $frag;
        }

        if ($toag == 100) {
            $bag = '>10';
        } else {
            $bag = $toag;
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "ARREARS AGE REPORT ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(120, 22);
        $this->pdf2->Cell(10, 0, "Arrears Age Rang : " . $aag . ' ~ ' . $bag, 0, 1, 'L');
        $this->pdf2->SetXY(165, 22);


        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 22);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH | CNT', 'OFFICER', 'PRDU', 'CUSTOMER', 'CUSTOMER NO', 'LOAN NO', 'AMMOUNT', 'START DATE', 'ARREARS', 'AGE', 'LAST PAY');
        $w = array(10, 30, 25, 15, 35, 30, 35, 25, 20, 25, 15, 20);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $ttln = $tarr = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . ' / ' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->usnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->prcd, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->cuno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, $row->acno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->loam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->acdt, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, number_format($row->arres, 2), 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[10], 6, $row->cage, 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[11], 6, $row->lspd, 'LR', 0, 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttln += $row->loam;
            $tarr += $row->arres;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($ttln, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, number_format($tarr, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[11], 6, '', 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->Output('Arrears Age Report.pdf', 'I');
        ob_end_flush();
    }
// END PORTFOLIO
//
// REPORT PA BRANCH
    function rpt_pa_brn()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_pa_branch', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchPaBrnch()
    {
        $result = $this->Report_model->get_paBrnch();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            //$acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $br = $row->brco;
            $pr = $row->prdtp;

            $sub_arr = array();
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->prtp;
            $sub_arr[] = number_format($row->tt1, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,1);'>" . round(($row->tt1 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = number_format($row->tt2, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,2);'>" . round(($row->tt2 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = number_format($row->tt3, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,3);'>" . round(($row->tt3 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = number_format($row->tt4, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,4);'>" . round(($row->tt4 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = number_format($row->tt5, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,5);'>" . round(($row->tt5 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = number_format($row->tt6, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,6);'>" . round(($row->tt6 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = number_format($row->tt7, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,7);'>" . round(($row->tt7 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = number_format($row->tt8, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,8);'>" . round(($row->tt8 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = number_format($row->tt00, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($br,$pr,9);'>" . round(($row->tt00 / $row->tt00) * 100, 2) . "</a>";
            $sub_arr[] = '';
            //$sub_arr[] = number_format($row->loam, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_paBrnch(),
            "recordsFiltered" => $this->Report_model->count_filtered_paBrnch(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

// END PA BRANCH
//
// PA LEDGER  - COMMON
    function getPaLeg()
    {
        $result = $this->Report_model->get_paLeger();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->acno;

            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = $row->lnpr;
            $sub_arr[] = $row->lcnt;
            $sub_arr[] = $row->durg;
            $sub_arr[] = number_format($row->inam, 2);

            $sub_arr[] = number_format($row->boc, 2);
            $sub_arr[] = number_format($row->boi, 2);
            $sub_arr[] = number_format($row->aboc, 2);
            $sub_arr[] = number_format($row->aboi, 2);
            $sub_arr[] = number_format($row->avpe, 2);

            $sub_arr[] = number_format($row->bal, 2);
            $sub_arr[] = number_format($row->arres, 2);
            $sub_arr[] = $row->cage;
            $sub_arr[] = $row->lspd;
            $sub_arr[] = number_format($row->lspa, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_paLeger(),
            "recordsFiltered" => $this->Report_model->count_filtered_paLeger(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

// END PA LEDGER
//
// REPORT PA OFFICER
    function rpt_pa_ofc()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_pa_officer', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchPaOfcr()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prtp');
        $exc = $this->input->post('ofcr');

        if ($brn == 'all') {
            $brn = '';
        } else {
            $brn = " AND micr_crt.brco = $brn ";
        }

        if ($prtp == 'all') {
            $prtp = '';
        } else {
            $prtp = " AND micr_crt.prdtp = $prtp ";
        }

        if ($exc == 'all') {
            $exc = '';
        } else {
            $exc = " AND micr_crt.clct = $exc ";
        }

        // ALL
        $this->db->select(" SUM(aboc + aboi) AS dtsum   ");
        $this->db->from("micr_crt");
        $this->db->where("micr_crt.stat IN(5,18) $brn $prtp $exc AND (aboc + aboi) > 0 ");
        $data_all = $this->db->get()->result();

        // AGE < 0
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage <= 0 $brn $prtp $exc ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_a = $this->db->get()->result();

        //AGE 0 - 1
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 0.01 AND 1.01 $brn $prtp $exc ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_b = $this->db->get()->result();

        // AGE 1 - 2
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 1.01 AND 2.01 $brn $prtp $exc ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_c = $this->db->get()->result();

        // AGE 2 - 3
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 2.01 AND 3.01 $brn $prtp $exc ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_d = $this->db->get()->result();

        // AGE 3 - 4
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 3.01 AND 4.01 $brn $prtp $exc ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_e = $this->db->get()->result();

        // AGE 4 - 5
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 4.01 AND 5.01 $brn $prtp $exc ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_f = $this->db->get()->result();

        // AGE 5 - 6
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 5.01 AND 6.01 $brn $prtp $exc ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_g = $this->db->get()->result();

        // AGE > 6
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage > 6.01 $brn $prtp $exc ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_h = $this->db->get()->result();

//var_dump($data_all[0]-> dtsum);

// AGE < 0
        foreach ($data_a as $a) {

            $sub_arr = array();
            $sub_arr[] = '1';
            $sub_arr[] = '< 0';
            $sub_arr[] = number_format($a->lnsum, 2);
            $sub_arr[] = number_format($a->cpsum, 2);
            $sub_arr[] = $a->cust;
            $sub_arr[] = number_format($a->dtsum, 2);
            $sub_arr[] = ($a->dtsum != 0) ? number_format((($a->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($a->sumcp, 2);
            $sub_arr[] = number_format($a->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(1);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 0 - 1
        foreach ($data_b as $b) {

            $sub_arr = array();
            $sub_arr[] = '2';
            $sub_arr[] = '0 - 1';
            $sub_arr[] = number_format($b->lnsum, 2);
            $sub_arr[] = number_format($b->cpsum, 2);
            $sub_arr[] = $b->cust;
            $sub_arr[] = number_format($b->dtsum, 2);
            $sub_arr[] = ($b->dtsum != 0) ? number_format((($b->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($b->sumcp, 2);
            $sub_arr[] = number_format($b->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(2);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 1 - 2
        foreach ($data_c as $c) {

            $sub_arr = array();
            $sub_arr[] = '3';
            $sub_arr[] = '1 - 2';
            $sub_arr[] = number_format($c->lnsum, 2);
            $sub_arr[] = number_format($c->cpsum, 2);
            $sub_arr[] = $c->cust;
            $sub_arr[] = number_format($c->dtsum, 2);
            $sub_arr[] = ($c->dtsum != 0) ? number_format((($c->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($c->sumcp, 2);
            $sub_arr[] = number_format($c->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(3);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 2 - 3
        foreach ($data_d as $d) {

            $sub_arr = array();
            $sub_arr[] = '4';
            $sub_arr[] = '2 - 3';
            $sub_arr[] = number_format($d->lnsum, 2);
            $sub_arr[] = number_format($d->cpsum, 2);
            $sub_arr[] = $d->cust;
            $sub_arr[] = number_format($d->dtsum, 2);
            $sub_arr[] = ($d->dtsum != 0) ? number_format((($d->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($d->sumcp, 2);
            $sub_arr[] = number_format($d->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(4);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 3 - 4
        foreach ($data_e as $e) {

            $sub_arr = array();
            $sub_arr[] = '5';
            $sub_arr[] = '3 - 4';
            $sub_arr[] = number_format($e->lnsum, 2);
            $sub_arr[] = number_format($e->cpsum, 2);
            $sub_arr[] = $e->cust;
            $sub_arr[] = number_format($e->dtsum, 2);
            $sub_arr[] = ($e->dtsum != 0) ? number_format((($e->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($e->sumcp, 2);
            $sub_arr[] = number_format($e->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(5);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 4 - 5
        foreach ($data_f as $f) {

            $sub_arr = array();
            $sub_arr[] = '6';
            $sub_arr[] = '4 - 5';
            $sub_arr[] = number_format($f->lnsum, 2);
            $sub_arr[] = number_format($f->cpsum, 2);
            $sub_arr[] = $f->cust;
            $sub_arr[] = number_format($f->dtsum, 2);
            $sub_arr[] = ($f->dtsum != 0) ? number_format((($f->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($f->sumcp, 2);
            $sub_arr[] = number_format($f->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(6);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 5 - 6
        foreach ($data_g as $g) {

            $sub_arr = array();
            $sub_arr[] = '7';
            $sub_arr[] = '5 - 6';
            $sub_arr[] = number_format($g->lnsum, 2);
            $sub_arr[] = number_format($g->cpsum, 2);
            $sub_arr[] = $g->cust;
            $sub_arr[] = number_format($g->dtsum, 2);
            $sub_arr[] = ($g->dtsum != 0) ? number_format((($g->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($g->sumcp, 2);
            $sub_arr[] = number_format($g->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(7);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE > 6
        foreach ($data_h as $h) {

            $sub_arr = array();
            $sub_arr[] = '8';
            $sub_arr[] = '> 6';
            $sub_arr[] = number_format($h->lnsum, 2);
            $sub_arr[] = number_format($h->cpsum, 2);
            $sub_arr[] = $h->cust;
            $sub_arr[] = number_format($h->dtsum, 2);
            $sub_arr[] = ($h->dtsum != 0) ? number_format((($h->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($h->sumcp, 2);
            $sub_arr[] = number_format($h->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(8);'> View </a>";
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => 8,
            "recordsFiltered" => 8,
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

// END PA OFFICER
//
// REPORT PA CENTER
    function rpt_pa_cnt()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_pa_center', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchPaCnt()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prtp');
        $exc = $this->input->post('ofcr');
        $cen = $this->input->post('cen');

        if ($brn == 'all') {
            $brn = '';
        } else {
            $brn = " AND micr_crt.brco = $brn ";
        }

        if ($prtp == 'all') {
            $prtp = '';
        } else {
            $prtp = " AND micr_crt.prdtp = $prtp ";
        }

        if ($exc == 'all') {
            $exc = '';
        } else {
            $exc = " AND micr_crt.clct = $exc ";
        }

        if ($cen == 'all') {
            $cen = '';
        } else {
            $cen = " AND micr_crt.ccnt = $cen ";
        }

        // ALL
        $this->db->select(" SUM(aboc + aboi) AS dtsum   ");
        $this->db->from("micr_crt");
        $this->db->where("micr_crt.stat IN(5,18) $brn $prtp $exc $cen AND (boc + boi) > 0 ");
        $data_all = $this->db->get()->result();

        // AGE < 0
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage <= 0 $brn $prtp $exc $cen ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_a = $this->db->get()->result();

        //AGE 0 - 1
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 0.01 AND 1.01 $brn $prtp $exc $cen ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_b = $this->db->get()->result();

        // AGE 1 - 2
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 1.01 AND 2.01 $brn $prtp $exc $cen ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_c = $this->db->get()->result();

        // AGE 2 - 3
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 2.01 AND 3.01 $brn $prtp $exc $cen ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_d = $this->db->get()->result();

        // AGE 3 - 4
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 3.01 AND 4.01 $brn $prtp $exc $cen ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_e = $this->db->get()->result();

        // AGE 4 - 5
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 4.01 AND 5.01 $brn $prtp $exc $cen ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_f = $this->db->get()->result();

        // AGE 5 - 6
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage BETWEEN 5.01 AND 6.01 $brn $prtp $exc $cen ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_g = $this->db->get()->result();

        // AGE > 6
        $this->db->select("SUM(loam) AS lnsum, SUM(boc + boi) AS cpsum, COUNT(apid) AS cust , SUM(aboc + aboi) AS dtsum, SUM(boc) AS sumcp, SUM(boc + aboc) AS port   ");
        $this->db->from("micr_crt");
        $this->db->where(" micr_crt.cage > 6.01 $brn $prtp $exc $cen ");
        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        $data_h = $this->db->get()->result();

//var_dump($data_all[0]-> dtsum);

// AGE < 0
        foreach ($data_a as $a) {

            $sub_arr = array();
            $sub_arr[] = '1';
            $sub_arr[] = '< 0';
            $sub_arr[] = number_format($a->lnsum, 2);
            $sub_arr[] = number_format($a->cpsum, 2);
            $sub_arr[] = $a->cust;
            $sub_arr[] = number_format($a->dtsum, 2);
            $sub_arr[] = ($a->dtsum != 0) ? number_format((($a->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($a->sumcp, 2);
            $sub_arr[] = number_format($a->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(1);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 0 - 1
        foreach ($data_b as $b) {

            $sub_arr = array();
            $sub_arr[] = '2';
            $sub_arr[] = '0 - 1';
            $sub_arr[] = number_format($b->lnsum, 2);
            $sub_arr[] = number_format($b->cpsum, 2);
            $sub_arr[] = $b->cust;
            $sub_arr[] = number_format($b->dtsum, 2);
            $sub_arr[] = ($b->dtsum != 0) ? number_format((($b->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($b->sumcp, 2);
            $sub_arr[] = number_format($b->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(2);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 1 - 2
        foreach ($data_c as $c) {

            $sub_arr = array();
            $sub_arr[] = '3';
            $sub_arr[] = '1 - 2';
            $sub_arr[] = number_format($c->lnsum, 2);
            $sub_arr[] = number_format($c->cpsum, 2);
            $sub_arr[] = $c->cust;
            $sub_arr[] = number_format($c->dtsum, 2);
            $sub_arr[] = ($c->dtsum != 0) ? number_format((($c->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($c->sumcp, 2);
            $sub_arr[] = number_format($c->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(3);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 2 - 3
        foreach ($data_d as $d) {

            $sub_arr = array();
            $sub_arr[] = '4';
            $sub_arr[] = '2 - 3';
            $sub_arr[] = number_format($d->lnsum, 2);
            $sub_arr[] = number_format($d->cpsum, 2);
            $sub_arr[] = $d->cust;
            $sub_arr[] = number_format($d->dtsum, 2);
            $sub_arr[] = ($d->dtsum != 0) ? number_format((($d->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($d->sumcp, 2);
            $sub_arr[] = number_format($d->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(4);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 3 - 4
        foreach ($data_e as $e) {

            $sub_arr = array();
            $sub_arr[] = '5';
            $sub_arr[] = '3 - 4';
            $sub_arr[] = number_format($e->lnsum, 2);
            $sub_arr[] = number_format($e->cpsum, 2);
            $sub_arr[] = $e->cust;
            $sub_arr[] = number_format($e->dtsum, 2);
            $sub_arr[] = ($e->dtsum != 0) ? number_format((($e->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($e->sumcp, 2);
            $sub_arr[] = number_format($e->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(5);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 4 - 5
        foreach ($data_f as $f) {

            $sub_arr = array();
            $sub_arr[] = '6';
            $sub_arr[] = '4 - 5';
            $sub_arr[] = number_format($f->lnsum, 2);
            $sub_arr[] = number_format($f->cpsum, 2);
            $sub_arr[] = $f->cust;
            $sub_arr[] = number_format($f->dtsum, 2);
            $sub_arr[] = ($f->dtsum != 0) ? number_format((($f->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($f->sumcp, 2);
            $sub_arr[] = number_format($f->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(6);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE 5 - 6
        foreach ($data_g as $g) {

            $sub_arr = array();
            $sub_arr[] = '7';
            $sub_arr[] = '5 - 6';
            $sub_arr[] = number_format($g->lnsum, 2);
            $sub_arr[] = number_format($g->cpsum, 2);
            $sub_arr[] = $g->cust;
            $sub_arr[] = number_format($g->dtsum, 2);
            $sub_arr[] = ($g->dtsum != 0) ? number_format((($g->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($g->sumcp, 2);
            $sub_arr[] = number_format($g->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(7);'> View </a>";
            $data[] = $sub_arr;
        }
// AGE > 6
        foreach ($data_h as $h) {

            $sub_arr = array();
            $sub_arr[] = '8';
            $sub_arr[] = '> 6';
            $sub_arr[] = number_format($h->lnsum, 2);
            $sub_arr[] = number_format($h->cpsum, 2);
            $sub_arr[] = $h->cust;
            $sub_arr[] = number_format($h->dtsum, 2);
            $sub_arr[] = ($h->dtsum != 0) ? number_format((($h->dtsum / $data_all[0]->dtsum) * 100), 2) : 0;
            $sub_arr[] = number_format($h->sumcp, 2);
            $sub_arr[] = number_format($h->port, 2);
            $sub_arr[] = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(8);'> View </a>";
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => 8,
            "recordsFiltered" => 8,
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

// END PA CENTER
//
// REPORT GENERAL LEDGER
    function rprt_gl()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $data['minacinfo'] = $this->Generic_model->getData('accu_main', array('auid', 'name'), '');

        $this->load->view('modules/report/rpt_mng_general_leg', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function searchGl()
    {
        $result = $this->Report_model->get_gl();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->hadr;
            $sub_arr[] = $row->acdt;
            $sub_arr[] = $row->trtp;
            $sub_arr[] = $row->dcrp . '( ' . $row->rfna . ' )';
            $sub_arr[] = number_format($row->dbam, 2);
            $sub_arr[] = number_format($row->cram, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_gl(),
            "recordsFiltered" => $this->Report_model->count_filtered_gl(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printGenerLedg($brn, $mnac, $chac, $frdt, $todt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rprt_gl');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print General Ledger Report');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['mnac'] = $mnac;
        $_POST['chac'] = $chac;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;

        $result = $this->Report_model->gl_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }

        // CHART OF ACCOUNT
        if ($chac != 'all') {
            $accmain = $this->Generic_model->getData('accu_chrt', array('hadr'), array('idfr' => $chac));
            $accchrt = $accmain[0]->hadr;
        } else {
            $accchrt = "All Account";
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('General Ledger');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "GENERAL LEDGER ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(60, 22);
        $this->pdf2->Cell(10, 0, "From : " . $frdt . ' To : ' . $todt, 0, 1, 'L');
        $this->pdf2->SetXY(165, 22);
        $this->pdf2->Cell(10, 0, "Account : " . $accchrt, 0, 1, 'L');

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRANCH', 'ACCOUNT NAME', 'DATE', ' TYPE', 'DESCRIPTION', 'DEBIT', 'CREDIT');
        $w = array(10, 30, 30, 35, 40, 75, 30, 30);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $tdb = $tcr = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->hadr, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->acdt, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->trtp, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->dcrp . '( ' . $row->rfna . ' )', 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[6], 6, number_format($row->dbam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->cram, 2), 'LR', '', 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $tdb += $row->dbam;
            $tcr += $row->cram;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, number_format($tdb, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($tcr, 2), 'LR', 0, 'R', $fill);


        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('General Ledger Report');
        $this->pdf2->Output('General Ledger Report.pdf', 'I');
        ob_end_flush();
    }
// END GENERAL LEDGER
//
// REPORT BALANCE SHEET
    function bal_sheet()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $this->load->view('modules/report/rpt_mng_balance_sheet', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function searchBalsheet()
    {
        $result = $this->Report_model->get_gl();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->hadr;
            $sub_arr[] = $row->acdt;
            $sub_arr[] = $row->trtp;
            $sub_arr[] = $row->dcrp . '( ' . $row->rfna . ' )';
            $sub_arr[] = number_format($row->dbam, 2);
            $sub_arr[] = number_format($row->cram, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_gl(),
            "recordsFiltered" => $this->Report_model->count_filtered_gl(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printBalanceSheet($brn, $asdt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('bal_sheet');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Balance Sheet Report');

        // GET REPORT MODULE DATA
        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Balance Sheet');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "BALANCE SHEET ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(125, 22);
        $this->pdf2->Cell(10, 0, "As at Date : " . $asdt, 0, 1, 'L');
        /*$this->pdf2->SetXY(165, 22);
        $this->pdf2->Cell(10, 0, "Account : " , 0, 1, 'L');*/

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        $this->pdf2->SetFont('Helvetica', 'B', 8);
        $this->pdf2->SetY(30);
        $cy = $this->pdf2->GetY();

        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 9, 'ASSETS & LIABILITY', 0, 1, 'L');

        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 9, 'Debits', 0, 1, 'R');
        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 9, 'Credits', 0, 1, 'R');
        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 9, 'Balance', 0, 1, 'R');

        $this->db->select("*");
        $this->db->from("accu_main");
        $this->db->where('stat', '1');
        $this->db->where('acc_mode', '2');
        $query = $this->db->get();
        $data['acc_main'] = $query->result();

        $tot_dbam = 0;
        $tot_cram = 0;

        $cy = $this->pdf2->GetY();
        foreach ($data['acc_main'] as $mac) {
            $this->pdf2->SetFont('Helvetica', 'B', 8);
            $this->pdf2->SetFillColor(235, 235, 224);
            $this->pdf2->SetXY(28, $cy);
            $this->pdf2->Cell(250, 7, $mac->name, 0, 1, 'L', true);

            $this->db->select("accu_chrt.hadr,accu_chrt.idfr,acc_leg.acst,SUM(acc_leg.dbam) AS dbam,SUM(acc_leg.cram) AS cram");
            $this->db->from("acc_leg");
            $this->db->join('accu_chrt', "accu_chrt.idfr = acc_leg.spcd", 'left');

            if ($brn != 'all') {
                $this->db->where('acc_leg.brno', $brn);
            }
            //$this->db->where('accu_chrt.stat', '1');
            $this->db->where('accu_chrt.acid', $mac->auid);
            $this->db->group_by('spcd');

            $query = $this->db->get();
            $data['chrt_acc'] = $query->result();

            $cy = $this->pdf2->GetY();
            $this->pdf2->SetFont('Helvetica', '', 8);
            foreach ($data['chrt_acc'] as $chtacc) {
                $tot_dbam = $tot_dbam + $chtacc->dbam;
                $tot_cram = $tot_cram + $chtacc->cram;

                $this->pdf2->SetXY(35, $cy);
                $this->pdf2->Cell(100, 7, $chtacc->idfr . "    " . $chtacc->hadr . "", 0, 1, 'L');

                $this->pdf2->SetXY(128, $cy);
                $this->pdf2->Cell(50, 7, number_format($chtacc->dbam, 2, '.', ','), 0, 1, 'R');

                $this->pdf2->SetXY(178, $cy);
                $this->pdf2->Cell(50, 7, number_format($chtacc->cram, 2, '.', ','), 0, 1, 'R');

                $this->pdf2->SetXY(228, $cy);
                $this->pdf2->Cell(50, 7, number_format(($chtacc->dbam - $chtacc->cram), 2, '.', ','), 0, 1, 'R');

                if ($cy >= 153) {                       //   Add New Page
                    $this->pdf2->AddPage('L');
                    $this->pdf2->SetMargins(10, 10, 10);
                    $this->pdf2->SetAuthor('www.Ideas.com');
                    $this->pdf2->SetTitle('Balance Sheet');
                    $this->pdf2->SetDisplayMode('default');

                    $cy = 35;
                    $this->pdf2->SetY(35);
                    $this->pdf2->SetFont('Helvetica', 'B', 8);

                    $cy = $this->pdf2->GetY();
                } else {
                    $cy = $cy + 7;
                }
            }
        }
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 7, "TOTAL", 1, 1, 'L');

        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_dbam, 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_cram, 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 7, number_format(($tot_dbam - $tot_cram), 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetTitle('Balance Sheet Report');
        $this->pdf2->Output('Balance Sheet Report.pdf', 'I');
        ob_end_flush();
    }
// END BALANCE SHEET
//
// REPORT PROFIT AND LOSS
    function rprt_pnl()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $this->load->view('modules/report/rpt_mng_profitNloss', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function search_rprt_pnl()
    {
        $result = $this->Report_model->get_gl();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->hadr;
            $sub_arr[] = $row->acdt;
            $sub_arr[] = $row->trtp;
            $sub_arr[] = $row->dcrp . '( ' . $row->rfna . ' )';
            $sub_arr[] = number_format($row->dbam, 2);
            $sub_arr[] = number_format($row->cram, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_gl(),
            "recordsFiltered" => $this->Report_model->count_filtered_gl(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printPnl($brn, $asdt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rprt_pnl');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Profit & Loss Report');

        // GET REPORT MODULE DATA
        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Profit & Loss');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "PROFIT & LOSS ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(125, 22);
        $this->pdf2->Cell(10, 0, "As at Date : " . $asdt, 0, 1, 'L');
        /*$this->pdf2->SetXY(165, 22);
        $this->pdf2->Cell(10, 0, "Account : " , 0, 1, 'L');*/

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        $this->pdf2->SetFont('Helvetica', 'B', 8);
        $this->pdf2->SetY(30);
        $cy = $this->pdf2->GetY();

        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 9, 'REVENUE & EXPENSE', 0, 1, 'L');

        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 9, 'Debits', 0, 1, 'R');
        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 9, 'Credits', 0, 1, 'R');
        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 9, 'Balance', 0, 1, 'R');

        $this->db->select("*");
        $this->db->from("accu_main");
        $this->db->where('stat', '1');
        $this->db->where('acc_mode', '1');
        $query = $this->db->get();
        $data['acc_main'] = $query->result();

        $tot_dbam = 0;
        $tot_cram = 0;

        $cy = $this->pdf2->GetY();
        foreach ($data['acc_main'] as $mac) {
            $this->pdf2->SetFont('Helvetica', 'B', 8);
            $this->pdf2->SetFillColor(235, 235, 224);
            $this->pdf2->SetXY(28, $cy);
            $this->pdf2->Cell(250, 7, $mac->name, 0, 1, 'L', true);

            $this->db->select("accu_chrt.hadr,accu_chrt.idfr,acc_leg.acst,SUM(acc_leg.dbam) AS dbam,SUM(acc_leg.cram) AS cram");
            $this->db->from("acc_leg");
            $this->db->join('accu_chrt', "accu_chrt.idfr = acc_leg.spcd", 'left');

            if ($brn != 'all') {
                $this->db->where('acc_leg.brno', $brn);
            }
            //$this->db->where('accu_chrt.stat', '1');
            $this->db->where('accu_chrt.acid', $mac->auid);
            $this->db->group_by('spcd');

            $query = $this->db->get();
            $data['chrt_acc'] = $query->result();

            $cy = $this->pdf2->GetY();
            $this->pdf2->SetFont('Helvetica', '', 8);
            foreach ($data['chrt_acc'] as $chtacc) {
                $tot_dbam = $tot_dbam + $chtacc->dbam;
                $tot_cram = $tot_cram + $chtacc->cram;

                $this->pdf2->SetXY(35, $cy);
                $this->pdf2->Cell(100, 7, $chtacc->idfr . "    " . $chtacc->hadr . "", 0, 1, 'L');

                $this->pdf2->SetXY(128, $cy);
                $this->pdf2->Cell(50, 7, number_format($chtacc->dbam, 2, '.', ','), 0, 1, 'R');

                $this->pdf2->SetXY(178, $cy);
                $this->pdf2->Cell(50, 7, number_format($chtacc->cram, 2, '.', ','), 0, 1, 'R');

                $this->pdf2->SetXY(228, $cy);
                $this->pdf2->Cell(50, 7, number_format(($chtacc->dbam - $chtacc->cram), 2, '.', ','), 0, 1, 'R');

                if ($cy >= 153) {                       //   Add New Page
                    $this->pdf2->AddPage('L');
                    $this->pdf2->SetMargins(10, 10, 10);
                    $this->pdf2->SetAuthor('www.Ideas.com');
                    $this->pdf2->SetTitle('Balance Sheet');
                    $this->pdf2->SetDisplayMode('default');

                    $cy = 35;
                    $this->pdf2->SetY(35);
                    $this->pdf2->SetFont('Helvetica', 'B', 8);

                    $cy = $this->pdf2->GetY();
                } else {
                    $cy = $cy + 7;
                }
            }
        }
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 7, "TOTAL", 1, 1, 'L');

        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_dbam, 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_cram, 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 7, number_format(($tot_dbam - $tot_cram), 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetTitle('Profit & Loss Report');
        $this->pdf2->Output('Profit & Loss Report.pdf', 'I');
        ob_end_flush();
    }
// END PROFIT AND LOSS
//
// REPORT TRAIL BALANCE
    function rprt_tb()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/admin/template/admin_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();

        $this->load->view('modules/report/rpt_mng_trailBalance', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function search_rprt_tb()
    {
        $result = $this->Report_model->get_gl();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->hadr;
            $sub_arr[] = $row->acdt;
            $sub_arr[] = $row->trtp;
            $sub_arr[] = $row->dcrp . '( ' . $row->rfna . ' )';
            $sub_arr[] = number_format($row->dbam, 2);
            $sub_arr[] = number_format($row->cram, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_gl(),
            "recordsFiltered" => $this->Report_model->count_filtered_gl(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printTrailBal($brn, $asdt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rprt_tb');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Trail Balance Report');

        // GET REPORT MODULE DATA
        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Trail Balance');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "TRAIL BALANCE ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(125, 22);
        $this->pdf2->Cell(10, 0, "As at Date : " . $asdt, 0, 1, 'L');
        /*$this->pdf2->SetXY(165, 22);
        $this->pdf2->Cell(10, 0, "Account : " , 0, 1, 'L');*/

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        $this->pdf2->SetFont('Helvetica', 'B', 8);
        $this->pdf2->SetY(30);
        $cy = $this->pdf2->GetY();

        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 9, 'ASSETS & REVENUE', 0, 1, 'L');

        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 9, 'Debits', 0, 1, 'R');
        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 9, 'credits', 0, 1, 'R');
        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 9, 'Balance', 0, 1, 'R');


        $this->db->select("*");
        $this->db->from("accu_main");
        $this->db->where('stat', '1');
        $this->db->where('auid IN(1,4)');
        $query = $this->db->get();
        $data['acc_main'] = $query->result();

        $tot_dbam = 0;
        $tot_cram = 0;

        $cy = $this->pdf2->GetY();
        foreach ($data['acc_main'] as $mac) {
            $this->pdf2->SetFont('Helvetica', 'B', 8);
            $this->pdf2->SetFillColor(235, 235, 224);
            $this->pdf2->SetXY(28, $cy);
            $this->pdf2->Cell(250, 7, $mac->name, 0, 1, 'L', true); //. "   " . $mac->auid

            $this->db->select("accu_chrt.hadr,accu_chrt.idfr,acc_leg.acst,SUM(acc_leg.dbam) AS dbam,SUM(acc_leg.cram) AS cram");
            $this->db->from("acc_leg");
            $this->db->join('accu_chrt', "accu_chrt.idfr = acc_leg.spcd", 'left');

            if ($brn != 'all') {
                $this->db->where('acc_leg.brno', $brn);
            }
            //$this->db->where('acc_charts_account.stat', '1');
            $this->db->where('accu_chrt.acid', $mac->auid);
            $this->db->group_by('spcd');

            $query = $this->db->get();
            $data['chrt_acc'] = $query->result();

            $cy = $this->pdf2->GetY();
            $this->pdf2->SetFont('Helvetica', '', 8);
            foreach ($data['chrt_acc'] as $chtacc) {
                $tot_dbam = $tot_dbam + $chtacc->dbam;
                $tot_cram = $tot_cram + $chtacc->cram;

                $this->pdf2->SetXY(35, $cy);
                $this->pdf2->Cell(100, 7, $chtacc->idfr . "    " . $chtacc->hadr, 0, 1, 'L');

                $this->pdf2->SetXY(128, $cy);
                $this->pdf2->Cell(50, 7, number_format($chtacc->dbam, 2, '.', ','), 0, 1, 'R');

                $this->pdf2->SetXY(178, $cy);
                $this->pdf2->Cell(50, 7, number_format($chtacc->cram, 2, '.', ','), 0, 1, 'R');

                $this->pdf2->SetXY(228, $cy);
                $this->pdf2->Cell(50, 7, number_format(($chtacc->dbam - $chtacc->cram), 2, '.', ','), 0, 1, 'R');

                if ($cy >= 153) {                       //   Add New Page
                    $this->pdf2->AddPage('L');
                    $this->pdf2->SetMargins(10, 10, 10);
                    $this->pdf2->SetAuthor('www.gdcreations.com');
                    $this->pdf2->SetTitle('Trail Balance');
                    $this->pdf2->SetDisplayMode('default');

                    $cy = 35;
                    $this->pdf2->SetY(35);
                    $this->pdf2->SetFont('Helvetica', 'B', 8);

                    $cy = $this->pdf2->GetY();
                } else {
                    $cy = $cy + 7;
                }
            }
        }
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 7, "SUB TOTAL", 1, 1, 'L');

        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_dbam, 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_cram, 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_dbam - $tot_cram, 2, '.', ','), 1, 1, 'R');


        // ***************************************************************************

        $this->pdf2->AddPage('L');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Trial Balance');
        $this->pdf2->SetDisplayMode('default');

        $cy = 15;
        $this->pdf2->SetY(35);
        $this->pdf2->SetFont('Helvetica', 'B', 8);
        //$cy = $this->pdf2->GetY() + 10;
        //$this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 9, 'LIABILITIES , EQUITY & EXPENSE', 0, 1, 'L');

        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 9, 'Debits', 0, 1, 'R');
        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 9, 'credits', 0, 1, 'R');
        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 9, 'Balance', 0, 1, 'R');

        $this->db->select("*");
        $this->db->from("accu_main");
        $this->db->where('stat', '1');
        $this->db->where('auid IN(2,3,5)');
        $query = $this->db->get();
        $data['acc_main2'] = $query->result();

        $tot_dbam2 = 0;
        $tot_cram2 = 0;
        $cy = $this->pdf2->GetY();
        foreach ($data['acc_main2'] as $mac2) {
            $this->pdf2->SetFont('Helvetica', 'B', 8);
            $this->pdf2->SetFillColor(235, 235, 224);
            $this->pdf2->SetXY(28, $cy);
            $this->pdf2->Cell(250, 7, $mac2->name, 0, 1, 'L', true); //. "  ****  " . $mac2->auid

            $this->db->select("accu_chrt.hadr,accu_chrt.idfr,acc_leg.acst,SUM(acc_leg.dbam) AS dbam,SUM(acc_leg.cram) AS cram");
            $this->db->from("acc_leg");
            $this->db->join('accu_chrt', "accu_chrt.idfr = acc_leg.spcd", 'left');

            if ($brn != 'all') {
                $this->db->where('acc_leg.brno', $brn);
            }
            $this->db->where('accu_chrt.acid', $mac2->auid);
            $this->db->group_by('spcd');

            $query = $this->db->get();
            $data['chrt_acc2'] = $query->result();

            $cy = $this->pdf2->GetY();
            $this->pdf2->SetFont('Helvetica', '', 8);
            foreach ($data['chrt_acc2'] as $chtacc2) {
                $tot_dbam2 = $tot_dbam2 + $chtacc2->dbam;
                $tot_cram2 = $tot_cram2 + $chtacc2->cram;

                $this->pdf2->SetXY(35, $cy);
                $this->pdf2->Cell(100, 7, $chtacc2->idfr . "    " . $chtacc2->hadr, 0, 1, 'L');

                $this->pdf2->SetXY(128, $cy);
                $this->pdf2->Cell(50, 7, number_format($chtacc2->dbam, 2, '.', ','), 0, 1, 'R');

                $this->pdf2->SetXY(178, $cy);
                $this->pdf2->Cell(50, 7, number_format($chtacc2->cram, 2, '.', ','), 0, 1, 'R');

                $this->pdf2->SetXY(228, $cy);
                $this->pdf2->Cell(50, 7, number_format(($chtacc2->dbam - $chtacc2->cram), 2, '.', ','), 0, 1, 'R');

                if ($cy >= 153) {                       //   Add New Page
                    $this->pdf2->AddPage('L');
                    $this->pdf2->SetMargins(10, 10, 10);
                    $this->pdf2->SetAuthor('www.gdcreations.com');
                    $this->pdf2->SetTitle('Trial Balance');
                    $this->pdf2->SetDisplayMode('default');

                    $cy = 35;
                    $this->pdf2->SetY(35);
                    $this->pdf2->SetFont('Helvetica', 'B', 8);

                    $cy = $this->pdf2->GetY();
                } else {
                    $cy = $cy + 7;
                }
            }
        }
        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 7, "TOTAL ", 1, 1, 'L');

        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_dbam2, 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_cram2, 2, '.', ','), 1, 1, 'R');

        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 7, number_format(($tot_dbam2 - $tot_cram2), 2, '.', ','), 1, 1, 'R');

        // **************** summery ******************
        $cy = $this->pdf2->GetY() + 10;
        $this->pdf2->SetFont('Helvetica', 'B', 8);

        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 9, 'Summery ', 0, 1, 'L');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 9, 'Debits', 0, 1, 'R');
        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 9, 'Credits', 0, 1, 'R');
        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 9, 'Balance', 0, 1, 'R');

        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 7, "Assets & Revenue Total", 0, 1, 'L');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_dbam, 2, '.', ','), 0, 1, 'R');
        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_cram, 2, '.', ','), 0, 1, 'R');
        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 9, number_format($tot_dbam - $tot_cram, 2, '.', ','), 0, 1, 'R');

        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 7, "Liabilities , Equity & Expense Total ", 0, 1, 'L');
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_dbam2, 2, '.', ','), 0, 1, 'R');
        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_cram2, 2, '.', ','), 0, 1, 'R');
        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 9, number_format($tot_dbam2 - $tot_cram2, 2, '.', ','), 0, 1, 'R');


        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFillColor(235, 235, 224);
        $this->pdf2->SetXY(28, $cy);
        $this->pdf2->Cell(100, 7, " ", 0, 1, 'L', true);
        $this->pdf2->SetXY(128, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_dbam + $tot_dbam2, 2, '.', ','), 0, 1, 'R', true);
        $this->pdf2->SetXY(178, $cy);
        $this->pdf2->Cell(50, 7, number_format($tot_cram + $tot_cram2, 2, '.', ','), 0, 1, 'R', true);
        $this->pdf2->SetXY(228, $cy);
        $this->pdf2->Cell(50, 7, number_format(($tot_dbam + $tot_dbam2) - ($tot_cram + $tot_cram2), 2, '.', ','), 0, 1, 'R', true);

        $this->pdf2->SetTitle('Trail Balance Report');
        $this->pdf2->Output('Trail Balance Report.pdf', 'I');
        ob_end_flush();
    }
// END TRAIL BALANCE
//
// REPORT DEBTOR PORTFOLIO
    function rpt_dbt_port()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_dbtr_portfolio', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchDbtPort()
    {
        $result = $this->Report_model->get_dbtPort();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $acno;

            $sub_arr[] = $row->lcnt;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->inta, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = $row->noin;
            $sub_arr[] = number_format($row->boc, 2);
            $sub_arr[] = number_format($row->boi, 2);
            $sub_arr[] = number_format($row->aboc, 2);
            $sub_arr[] = number_format($row->aboi, 2);
            $sub_arr[] = number_format($row->avpe, 2);

            $sub_arr[] = number_format($row->ttpym, 2);
            $sub_arr[] = number_format($row->avcr, 2);
            $sub_arr[] = $row->cage;

            $sub_arr[] = $row->lspd;
            $sub_arr[] = number_format($row->lspa, 2);
            $sub_arr[] = $row->cvdt;
            $sub_arr[] = $row->madt;

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_dbtPort(),
            "recordsFiltered" => $this->Report_model->count_filtered_dbtPort(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //  PRINT PDF
    function printDbtPort($brn, $exc, $cen, $prtp, $frag, $toag)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_dbt_port');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Debtor As Portfolio Report');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['frag'] = $frag;
        $_POST['toag'] = $toag;

        $result = $this->Report_model->arrsAg_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $centinfo = $this->Generic_model->getData('cen_mas', array('caid', 'cnnm'), array('caid' => $cen));
            $cnnm = $centinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        if ($frag == '-100') {
            $aag = '<10';
        } else {
            $aag = $frag;
        }

        if ($toag == 100) {
            $bag = '>10';
        } else {
            $bag = $toag;
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "ARREARS AGE REPORT ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(120, 22);
        $this->pdf2->Cell(10, 0, "Arrears Age Rang : " . $aag . ' ~ ' . $bag, 0, 1, 'L');
        $this->pdf2->SetXY(165, 22);


        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 22);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH | CNT', 'OFFICER', 'PRDU', 'CUSTOMER', 'CUSTOMER NO', 'LOAN NO', 'AMMOUNT', 'START DATE', 'ARREARS', 'AGE', 'LAST PAY');
        $w = array(10, 30, 25, 15, 35, 30, 35, 25, 20, 25, 15, 20);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $ttln = $tarr = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . ' / ' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->usnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->prcd, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->cuno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, $row->acno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->loam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->acdt, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, number_format($row->arres, 2), 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[10], 6, $row->cage, 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[11], 6, $row->lspd, 'LR', 0, 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttln += $row->loam;
            $tarr += $row->arres;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($ttln, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, number_format($tarr, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[11], 6, '', 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->Output('Arrears Age Report.pdf', 'I');
        ob_end_flush();
    }
// END DEBTOR PORTFOLIO
//
// REPORT DEBTOR INVERSMENT
    function rpt_dbt_insv()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_dbtr_invstment', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchDbtInvst()
    {
        $result = $this->Report_model->get_dbtInvst();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $acno;
            $sub_arr[] = $row->cvdt;

            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->arres, 2);
            $sub_arr[] = $row->cage;
            $sub_arr[] = $row->lspd;
            $sub_arr[] = number_format($row->lspa, 2);
            $sub_arr[] = number_format($row->boc, 2);
            $sub_arr[] = number_format($row->boi, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_dbtPort(),
            "recordsFiltered" => $this->Report_model->count_filtered_dbtPort(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //  PRINT PDF
    function Az3($brn, $exc, $cen, $prtp, $frag, $toag)
    {
        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['frag'] = $frag;
        $_POST['toag'] = $toag;

        $result = $this->Report_model->arrsAg_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $centinfo = $this->Generic_model->getData('cen_mas', array('caid', 'cnnm'), array('caid' => $cen));
            $cnnm = $centinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        if ($frag == '-100') {
            $aag = '<10';
        } else {
            $aag = $frag;
        }

        if ($toag == 100) {
            $bag = '>10';
        } else {
            $bag = $toag;
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "ARREARS AGE REPORT ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(120, 22);
        $this->pdf2->Cell(10, 0, "Arrears Age Rang : " . $aag . ' ~ ' . $bag, 0, 1, 'L');
        $this->pdf2->SetXY(165, 22);


        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 22);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH | CNT', 'OFFICER', 'PRDU', 'CUSTOMER', 'CUSTOMER NO', 'LOAN NO', 'AMMOUNT', 'START DATE', 'ARREARS', 'AGE', 'LAST PAY');
        $w = array(10, 30, 25, 15, 35, 30, 35, 25, 20, 25, 15, 20);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $ttln = $tarr = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . ' / ' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->usnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->prcd, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->cuno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, $row->acno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->loam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->acdt, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, number_format($row->arres, 2), 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[10], 6, $row->cage, 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[11], 6, $row->lspd, 'LR', 0, 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttln += $row->loam;
            $tarr += $row->arres;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($ttln, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, number_format($tarr, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[11], 6, '', 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->Output('Arrears Age Report.pdf', 'I');
        ob_end_flush();
    }
// END DEBTOR INVERSMENT
//
// REPORT DEBTOR AGE
    function rpt_dbt_age()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_dbtr_age', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchDbtAge()
    {
        $asdt = $this->input->post('asdt');
        $result = $this->Report_model->get_dbtAge();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $brn = $row->brco;
            $exc = $row->clct;
            $cnt = $row->ccnt;
            $prd = $row->prdtp;

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->cnnm;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->prtp;
            $sub_arr[] = $row->tt00;
            $sub_arr[] = round($row->tt0, 2);

            $sub_arr[] = ($row->c1 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry12(1,$brn,$cnt,$exc,$prd,$asdt)' >" . $row->c1 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta1, 2);
            $sub_arr[] = number_format($row->tb1, 2);

            $sub_arr[] = ($row->c2 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry12(2,$brn,$cnt,$exc,$prd,$asdt)' >" . $row->c2 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta2, 2);
            $sub_arr[] = number_format($row->tb2, 2);

            $sub_arr[] = ($row->c3 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry12(3,$brn,$cnt,$exc,$prd,$asdt)' >" . $row->c3 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta3, 2);
            $sub_arr[] = number_format($row->tb3, 2);

            $sub_arr[] = ($row->c4 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry12(4,$brn,$cnt,$exc,$prd,$asdt)' >" . $row->c4 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta4, 2);
            $sub_arr[] = number_format($row->tb4, 2);

            $sub_arr[] = ($row->c5 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry12(5,$brn,$cnt,$exc,$prd,$asdt)' >" . $row->c5 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta5, 2);
            $sub_arr[] = number_format($row->tb5, 2);

            $sub_arr[] = ($row->c6 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry12(6,$brn,$cnt,$exc,$prd,$asdt)' >" . $row->c6 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta6, 2);
            $sub_arr[] = number_format($row->tb6, 2);

            $sub_arr[] = ($row->c7 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry12(7,$brn,$cnt,$exc,$prd,$asdt)' >" . $row->c7 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta7, 2);
            $sub_arr[] = number_format($row->tb7, 2);

            $sub_arr[] = ($row->c8 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry12(8,$brn,$cnt,$exc,$prd,$asdt)' >" . $row->c8 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta8, 2);
            $sub_arr[] = number_format($row->tb8, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_dbtAge(),
            "recordsFiltered" => $this->Report_model->count_filtered_dbtAge(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // DEBTER AGE SUMMERY
    function detrAgeSummery()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cnt');
        $prtp = $this->input->post('prd');
        $asdt = $this->input->post('asdt');
        $typ = $this->input->post('typ');

        $today = date("Y-m-d");     //TODAY DATE

        $this->db->select("cen_mas.cnnm,brch_mas.brcd,user_mas.fnme,prdt_typ.prtp ,mc.brco,mc.clct,mc.ccnt,mc.prdtp,
        cus_mas.init,mc.lnid,mc.acno,mc.loam,mc.cage,mc.durg,mc.aboc,mc.aboi,mc.nxpn ,mc.noin");

        $this->db->from("micr_crt mc");
        $this->db->join('brch_mas', 'brch_mas.brid = mc.brco');
        $this->db->join('user_mas', 'user_mas.auid = mc.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = mc.ccnt');
        $this->db->join('prdt_typ', 'prdt_typ.prid = mc.prdtp');
        $this->db->join('cus_mas', 'cus_mas.cuid = mc.apid');

        if ($brn != 'all') {
            $this->db->where('mc.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('mc.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('mc.ccnt', $cen);
        }
        if ($prtp != 'all') {
            $this->db->where('mc.prdtp', $prtp);
        }
        $this->db->where('mc.stat IN(5,18)');

        if ($typ == 1) {
            $this->db->where(" mc.cage <= 0 ");                           // < 0
        } else if ($typ == 2) {
            $this->db->where(" mc.cage BETWEEN '0.00' AND '1.01'  ");     // 0 - 1
        } else if ($typ == 3) {
            $this->db->where(" mc.cage BETWEEN '1.01' AND '2.01'  ");     // 1 - 2
        } else if ($typ == 4) {
            $this->db->where(" mc.cage BETWEEN '2.01' AND '3.01'  ");     // 2 - 3
        } else if ($typ == 5) {
            $this->db->where(" mc.cage BETWEEN '3.01' AND '4.01'  ");     // 3 - 4
        } else if ($typ == 6) {
            $this->db->where(" mc.cage BETWEEN '4.01' AND '5.01'  ");     // 4 - 5
        } else if ($typ == 7) {
            $this->db->where(" mc.cage BETWEEN '5.01' AND '6.01'  ");     // 5 - 6
        } else if ($typ == 8) {
            $this->db->where(" mc.cage > 6.01  ");                        // > 6
        }

        $result = $this->db->get()->result();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->durg == '0' && $row->aboc > 0) {
                $stat = " OC ";
            } else {
                $stat = $row->nxpn . ' of ' . $row->noin;
            }

            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->init;
            $sub_arr[] = $acno;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->aboc, 2);
            $sub_arr[] = number_format($row->aboc + $row->aboi, 2);
            $sub_arr[] = number_format($row->aboc + $row->aboi, 2);
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = $row->cage;
            $sub_arr[] = $stat;

            $data[] = $sub_arr;
        }
        $output = array(
            /* "draw" => $_POST['draw'],
             "data" => $data,*/
            "sEcho" => 2,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        //$output = array("data" => $data);
        echo json_encode($output);

    }

    //  PRINT PDF
    function Az4($brn, $exc, $cen, $prtp, $frag, $toag)
    {
        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['frag'] = $frag;
        $_POST['toag'] = $toag;

        $result = $this->Report_model->arrsAg_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        if ($cen != 'all') {
            $centinfo = $this->Generic_model->getData('cen_mas', array('caid', 'cnnm'), array('caid' => $cen));
            $cnnm = $centinfo[0]->cnnm;
        } else {
            $cnnm = "All Center";
        }

        if ($frag == '-100') {
            $aag = '<10';
        } else {
            $aag = $frag;
        }

        if ($toag == 100) {
            $bag = '>10';
        } else {
            $bag = $toag;
        }

        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "ARREARS AGE REPORT ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(120, 22);
        $this->pdf2->Cell(10, 0, "Arrears Age Rang : " . $aag . ' ~ ' . $bag, 0, 1, 'L');
        $this->pdf2->SetXY(165, 22);


        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 22);
        $this->pdf2->Cell(10, 6, "Center : " . $cnnm, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH | CNT', 'OFFICER', 'PRDU', 'CUSTOMER', 'CUSTOMER NO', 'LOAN NO', 'AMMOUNT', 'START DATE', 'ARREARS', 'AGE', 'LAST PAY');
        $w = array(10, 30, 25, 15, 35, 30, 35, 25, 20, 25, 15, 20);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $ttln = $tarr = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {

            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . ' / ' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->usnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->prcd, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->cuno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, $row->acno, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->loam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->acdt, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, number_format($row->arres, 2), 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[10], 6, $row->cage, 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[11], 6, $row->lspd, 'LR', 0, 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttln += $row->loam;
            $tarr += $row->arres;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($ttln, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, number_format($tarr, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[11], 6, '', 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Arrears Age Report');
        $this->pdf2->Output('Arrears Age Report.pdf', 'I');
        ob_end_flush();
    }
// END DEBTOR AGE
//
// REPORT PROVISION SUMMERY
    function rpt_prvis()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_provision', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchProv()
    {
        $result = $this->Report_model->get_provis();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $brn = $row->brco;
            $prd = $row->prdtp;

            $ttlsum = $row->ta1 + $row->ta2 + $row->ta3 + $row->ta4;

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->prtp;

            $sub_arr[] = ($row->c1 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry15(1,$brn,$prd)' >" . $row->c1 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta1, 2);

            $sub_arr[] = ($row->c2 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry15(2,$brn,$prd)' >" . $row->c2 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta2, 2);


            $sub_arr[] = ($row->c3 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry15(3,$brn,$prd)' >" . $row->c3 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta3, 2);


            $sub_arr[] = ($row->c4 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry15(4,$brn,$prd)' >" . $row->c4 . "  </a> " : 0;
            $sub_arr[] = number_format($row->ta4, 2);

            $sub_arr[] = ($row->tt1 > 0) ? "<a href='#'  title='Current' data-toggle='modal' data-target='#modalView' onclick='viewSummry15(5,$brn,$prd)' >" . $row->tt1 . "  </a> " : 0;
            $sub_arr[] = number_format($ttlsum, 2);

            $sub_arr[] = number_format($row->stck, 2);
            $sub_arr[] = '-';
            $sub_arr[] = '-';
            $sub_arr[] = number_format($row->port, 2);
            $sub_arr[] = round(($ttlsum / $row->port) * 100, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_provis(),
            "recordsFiltered" => $this->Report_model->count_filtered_provis(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // PROVISION SUMMERY
    function provisSummery()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prd');
        $typ = $this->input->post('typ');
        $today = date("Y-m-d");     //TODAY DATE

        $this->db->select("cen_mas.cnnm,brch_mas.brcd,user_mas.fnme,prdt_typ.prtp ,mc.brco,mc.clct,mc.ccnt,mc.prdtp,
        cus_mas.init,mc.lnid,mc.acno,mc.loam,mc.cage,mc.durg,mc.aboc,mc.aboi,mc.nxpn ,mc.noin");

        $this->db->from("micr_crt mc");
        $this->db->join('brch_mas', 'brch_mas.brid = mc.brco');
        $this->db->join('user_mas', 'user_mas.auid = mc.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = mc.ccnt');
        $this->db->join('prdt_typ', 'prdt_typ.prid = mc.prdtp');
        $this->db->join('cus_mas', 'cus_mas.cuid = mc.apid');

        if ($brn != 'all') {
            $this->db->where('mc.brco', $brn);
        }
        if ($prtp != 'all') {
            $this->db->where('mc.prdtp', $prtp);
        }
        $this->db->where('mc.stat IN(5,18)');

        if ($typ == 1) {
            $this->db->where(" mc.cage BETWEEN '3.00' AND '6.01' ");        // 3 - 6
        } else if ($typ == 2) {
            $this->db->where(" mc.cage BETWEEN '6.01' AND '12.01'  ");      // 6 - 12
        } else if ($typ == 3) {
            $this->db->where(" mc.cage BETWEEN '12.01' AND '24.01'  ");     // 12 -24
        } else if ($typ == 4) {
            $this->db->where(" mc.cage > '24.01'  ");                       // > 24
        }

        $result = $this->db->get()->result();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->durg == '0' && $row->aboc > 0) {
                $stat = " OC ";
            } else {
                $stat = $row->nxpn . ' of ' . $row->noin;
            }

            $acno = "<a href='' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg($row->lnid);'  display:inline-block; '>" . $row->acno . "</a>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->init;
            $sub_arr[] = $acno;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->aboc, 2);
            $sub_arr[] = number_format($row->aboc + $row->aboi, 2);
            $sub_arr[] = number_format($row->aboc + $row->aboi, 2);
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = $row->cage;
            $sub_arr[] = $stat;

            $data[] = $sub_arr;
        }
        $output = array(
            /* "draw" => $_POST['draw'],
             "data" => $data,*/
            "sEcho" => 2,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        //$output = array("data" => $data);
        echo json_encode($output);

    }

// END PROVISION SUMMERY
//
// REPORT PROVISION SUMMERY
    function rpt_invs()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_invest_budget', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchInverst()
    {
        $result = $this->Report_model->get_inverst();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->exe;
            $sub_arr[] = $row->prtp;
            $sub_arr[] = $row->prnm;
            $sub_arr[] = number_format($row->tt1, 2);
            $sub_arr[] = number_format($row->tt2, 2);
            $sub_arr[] = ($row->tt1 > 0) ? round(($row->tt2 / $row->tt1) * 100, 2) : 0;
            $sub_arr[] = number_format($row->tt3, 2);
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_inverst(),
            "recordsFiltered" => $this->Report_model->count_filtered_inverst(),
            "data" => $data,
        );
        echo json_encode($output);
    }

// END PROVISION SUMMERY
//
// REPORT INCOME DETAILS
    function rpt_incom()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_rpsht');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_income_details', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchIncom()
    {
        $result = $this->Report_model->get_incom();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            //   $sub_arr[] = ($row->tt1 > 0) ? round(($row->tt2 / $row->tt1) * 100, 2) : 0;

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            // PORTFLIO
            $sub_arr[] = number_format($row->tt1, 2);
            $sub_arr[] = number_format($row->tt2, 2);
            $sub_arr[] = number_format($row->tt3, 2);
            // INVESMENT
            $sub_arr[] = '-';
            $sub_arr[] = number_format($row->inmt, 2);
            // SHOULD COLLECTED
            $sub_arr[] = number_format($row->rncp, 2);
            $sub_arr[] = number_format($row->rnin, 2);
            // INCOME
            $sub_arr[] = number_format($row->avcp, 2);
            $sub_arr[] = number_format($row->avin, 2);
            // FUTURE INCOME
            $sub_arr[] = number_format($row->boc, 2);
            $sub_arr[] = number_format($row->boi, 2);
            // DEBTOR
            $sub_arr[] = number_format($row->aboc, 2);
            $sub_arr[] = number_format($row->aboi, 2);
            // DOC/INSU FEE
            $sub_arr[] = number_format($row->dcg, 2);
            $sub_arr[] = number_format($row->icg, 2);

            $sub_arr[] = number_format($row->dpet, 2);
            $sub_arr[] = number_format(0, 2);
            $sub_arr[] = number_format(0, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_incom(),
            "recordsFiltered" => $this->Report_model->count_filtered_incom(),
            "data" => $data,
        );
        echo json_encode($output);
    }

// END INCOME DETAILS
//
// REPORT DEPLETION
    function rpt_dplt()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_dplt');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ', array('prid', 'prna'), array('stat' => 1));

        $this->load->view('modules/report/rpt_depletion', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function srchDepletion()
    {
        $result = $this->Report_model->get_deplt();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->boc > 0 && $row->s3 > 0) {
                $aa = ($row->s3 / $row->boc) * 100;
            } else {
                $aa = 0;
            }

            if ($row->s4 > 0 && $row->s5 > 0) {
                $ab = ($row->s5 / $row->s4) * 100;
            } else {
                $ab = 0;
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->ofer;
            $sub_arr[] = $row->prcd;

            $sub_arr[] = number_format($row->s1, 2);
            $sub_arr[] = number_format($row->s2, 2);
            $sub_arr[] = number_format($row->boc, 2);
            $sub_arr[] = $aa;
            $sub_arr[] = number_format($row->s4, 2);
            $sub_arr[] = $ab;
            $sub_arr[] = number_format($row->boc + $row->s4, 2);
            $sub_arr[] = number_format($row->s6, 2);
            $sub_arr[] = number_format($row->s7, 2);
            $sub_arr[] = number_format($row->boi, 2);
            $sub_arr[] = number_format($row->tta, 2);
            $sub_arr[] = number_format($row->tpr, 2);

            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_deplt(),
            "recordsFiltered" => $this->Report_model->count_filtered_deplt(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

// END DEPLETION
//
// OFFICE DAY END PRINT
    function printDayend($brn, $exc, $dte)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('ofcr_dyend');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Officer Dayend ');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['exe'] = $exc;
        $_POST['dte'] = $dte;

        $result = $this->User_model->ofcrdyend_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('OFFICER DENOMINATION');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "OFFICER DAYEND DENOMINATION : " . $dte, 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(120, 22);

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        $cy = date('Y');
        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(25);
        $cy = $this->pdf2->GetY();

        $this->pdf2->SetXY(7, $cy + 2);
        $this->pdf2->Cell(10, 14, 'NO', 1, 1, 'C');

        $this->pdf2->SetXY(17, $cy + 2);
        $this->pdf2->Cell(30, 14, 'BRANCH', 1, 1, 'C');

        $this->pdf2->SetXY(47, $cy + 2);
        $this->pdf2->Cell(30, 14, 'EXECUTIVE', 1, 1, 'C');

        $this->pdf2->SetXY(77, $cy + 2);
        $this->pdf2->Cell(100, 7, 'CASH DENOMINATION', 1, 1, 'C');

        $this->pdf2->SetXY(77, $cy + 9);
        $this->pdf2->Cell(10, 7, '5000', 1, 1, 'C');

        $this->pdf2->SetXY(87, $cy + 9);
        $this->pdf2->Cell(10, 7, '2000', 1, 1, 'C');

        $this->pdf2->SetXY(97, $cy + 9);
        $this->pdf2->Cell(10, 7, '1000', 1, 1, 'C');

        $this->pdf2->SetXY(107, $cy + 9);
        $this->pdf2->Cell(10, 7, '500', 1, 1, 'C');

        $this->pdf2->SetXY(117, $cy + 9);
        $this->pdf2->Cell(10, 7, '200', 1, 1, 'C');

        $this->pdf2->SetXY(127, $cy + 9);
        $this->pdf2->Cell(10, 7, '100', 1, 1, 'C');

        $this->pdf2->SetXY(137, $cy + 9);
        $this->pdf2->Cell(10, 7, '50', 1, 1, 'C');

        $this->pdf2->SetXY(147, $cy + 9);
        $this->pdf2->Cell(10, 7, '20', 1, 1, 'C');

        $this->pdf2->SetXY(157, $cy + 9);
        $this->pdf2->Cell(10, 7, '10', 1, 1, 'C');

        $this->pdf2->SetXY(167, $cy + 9);
        $this->pdf2->Cell(10, 7, 'COIN', 1, 1, 'C');

        $this->pdf2->SetXY(177, $cy + 2);
        $this->pdf2->Cell(30, 14, 'CASH TTL', 1, 1, 'C');

        $this->pdf2->SetXY(207, $cy + 2);
        $this->pdf2->Cell(23, 14, 'CENTERS', 1, 1, 'C');

        $this->pdf2->SetXY(230, $cy + 2);
        $this->pdf2->Cell(30, 14, 'REPAYMENTS', 1, 1, 'C');

        $this->pdf2->SetXY(260, $cy + 2);
        $this->pdf2->Cell(30, 14, 'POST BY', 1, 1, 'C');

        $i = 1;
        $k5 = 0;
        $k2 = 0;
        $k1 = 0;
        $c5 = 0;
        $c2 = 0;
        $c1 = 0;
        $ca = 0;
        $cb = 0;
        $cc = 0;
        $coin = 0;
        $ttl = 0;
        $cnt = 0;
        $rep = 0;

        foreach ($data['aa'] as $dyend) {
            $this->pdf2->SetFont('Helvetica', '', 8);
            $cy = $this->pdf2->GetY();

            $this->pdf2->SetXY(7, $cy);
            $this->pdf2->Cell(10, 7, $i, 1, 1, 'C');
            $this->pdf2->SetXY(17, $cy);
            $this->pdf2->Cell(30, 7, $dyend->brnm, 1, 1, 'L');
            $this->pdf2->SetXY(47, $cy);
            $this->pdf2->Cell(30, 7, $dyend->dnur, 1, 1, 'L');
            $this->pdf2->SetXY(77, $cy);
            $this->pdf2->Cell(10, 7, $dyend->x5000, 1, 1, 'C');
            $this->pdf2->SetXY(87, $cy);
            $this->pdf2->Cell(10, 7, $dyend->x2000, 1, 1, 'C');
            $this->pdf2->SetXY(97, $cy);
            $this->pdf2->Cell(10, 7, $dyend->x1000, 1, 1, 'C');
            $this->pdf2->SetXY(107, $cy);
            $this->pdf2->Cell(10, 7, $dyend->x500, 1, 1, 'C');
            $this->pdf2->SetXY(117, $cy);
            $this->pdf2->Cell(10, 7, 0, 1, 1, 'C');
            $this->pdf2->SetXY(127, $cy);
            $this->pdf2->Cell(10, 7, $dyend->x100, 1, 1, 'C');
            $this->pdf2->SetXY(137, $cy);
            $this->pdf2->Cell(10, 7, $dyend->x50, 1, 1, 'C');
            $this->pdf2->SetXY(147, $cy);
            $this->pdf2->Cell(10, 7, $dyend->x20, 1, 1, 'C');
            $this->pdf2->SetXY(157, $cy);
            $this->pdf2->Cell(10, 7, $dyend->x10, 1, 1, 'C');
            $this->pdf2->SetXY(167, $cy);
            $this->pdf2->Cell(10, 7, $dyend->cott, 1, 1, 'C');
            $this->pdf2->SetXY(177, $cy);
            $this->pdf2->Cell(30, 7, number_format($dyend->dntt, 2, '.', ','), 1, 1, 'R');
            $this->pdf2->SetXY(207, $cy);
            $this->pdf2->Cell(23, 7, $dyend->nocn, 1, 1, 'C');
            $this->pdf2->SetXY(230, $cy);
            $this->pdf2->Cell(30, 7, $dyend->norp, 1, 1, 'C');
            $this->pdf2->SetXY(260, $cy);
            $this->pdf2->Cell(30, 7, $dyend->exe, 1, 1, 'L');

            if ($cy >= 170) {                       //   Add New Page
                $this->pdf2->AddPage('L');
                $this->pdf2->SetMargins(10, 10, 10);
                $this->pdf2->SetAuthor('www.gdcreations.com');
                $this->pdf2->SetTitle('OFFICER DENOMINATION');
                $this->pdf2->SetDisplayMode('default');
                $cy = 35;
                $cy = $this->pdf2->GetY();
            } else {
                $cy = $cy + 7;
            }
            $k5 = $k5 + $dyend->x5000;
            $k2 = $k2 + $dyend->x2000;
            $k1 = $k1 + $dyend->x1000;
            $c5 = $c5 + $dyend->x500;
            $c2 = 0;
            $c1 = $c1 + $dyend->x100;
            $ca = $ca + $dyend->x50;
            $cb = $cb + $dyend->x20;
            $cc = $cc + $dyend->x10;
            $ttl = $ttl + $dyend->dntt;
            $cnt = $cnt + $dyend->nocn;
            $rep = $rep + $dyend->norp;
            $i++;
        }

        $cy = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(77, $cy);
        $this->pdf2->Cell(10, 7, $k5, 1, 1, 'C');
        $this->pdf2->SetXY(87, $cy);
        $this->pdf2->Cell(10, 7, $k2, 1, 1, 'C');
        $this->pdf2->SetXY(97, $cy);
        $this->pdf2->Cell(10, 7, $k1, 1, 1, 'C');
        $this->pdf2->SetXY(107, $cy);
        $this->pdf2->Cell(10, 7, $c5, 1, 1, 'C');
        $this->pdf2->SetXY(117, $cy);
        $this->pdf2->Cell(10, 7, $c2, 1, 1, 'C');
        $this->pdf2->SetXY(127, $cy);
        $this->pdf2->Cell(10, 7, $c1, 1, 1, 'C');
        $this->pdf2->SetXY(137, $cy);
        $this->pdf2->Cell(10, 7, $ca, 1, 1, 'C');
        $this->pdf2->SetXY(147, $cy);
        $this->pdf2->Cell(10, 7, $cb, 1, 1, 'C');
        $this->pdf2->SetXY(157, $cy);
        $this->pdf2->Cell(10, 7, $cc, 1, 1, 'C');
        $this->pdf2->SetXY(167, $cy);
        $this->pdf2->Cell(10, 7, $coin, 1, 1, 'C');
        $this->pdf2->SetXY(177, $cy);
        $this->pdf2->Cell(30, 7, number_format($ttl, 2, '.', ','), 1, 1, 'R');
        $this->pdf2->SetXY(207, $cy);
        $this->pdf2->Cell(23, 7, $cnt, 1, 1, 'C');
        $this->pdf2->SetXY(230, $cy);
        $this->pdf2->Cell(30, 7, $rep, 1, 1, 'C');
        $this->pdf2->SetTitle('Day End Report - ' . $dte);
        $this->pdf2->Output(' Day End Report  ' . $dte . '.pdf', 'I');
        ob_end_flush();
    }

// END OFFICE DAY END
//
//PRINT DENOMINATION
    function printDenomiPdf($auid)
    {
        $dndtx = $this->Generic_model->getData('denm_details', array('dnid', 'brco', 'dnsr', 'dndt', 'rfcd'), array('dnid' => $auid));
        //var_dump($dndt);
        $brco = $dndtx[0]->brco;
        $dnsr = $dndtx[0]->dnsr;
        $dndt = $dndtx[0]->dndt;
        $rfcd = $dndtx[0]->rfcd;

        // SUMMERY OF CENTER
        $this->db->select("SUM(receipt.ramt) AS ttl, COUNT(*) AS nrp, micr_crt.ccnt, cen_mas.cnnm");
        $this->db->from("receipt");
        $this->db->join('micr_crt', 'micr_crt.lnid = receipt.rfno');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->where('receipt.retp', 2);
        $this->db->where("receipt.stat IN(1,2)");
        $this->db->where('receipt.brco', $brco);
        $this->db->where('receipt.crby', $dnsr);
        if($dndt < '2018-08-27'){
        }else{
            $this->db->where('receipt.dnid', $auid);
        }
        $this->db->where(" DATE_FORMAT(receipt.crdt, '%Y-%m-%d') = '$dndt' ");
        $this->db->group_by('micr_crt.ccnt');
        $query = $this->db->get();
        $dat1 = $query->result();


        // TOTOLA RECIPTE
        $this->db->select("receipt.* ,micr_crt.acno, brch_mas.brcd,user_mas.usnm ,cus_mas.init,cus_mas.cuno,cen_mas.cnnm ");
        $this->db->from("receipt");
        $this->db->join('brch_mas', 'brch_mas.brid = receipt.brco');
        $this->db->join('user_mas', 'user_mas.auid = receipt.crby');
        $this->db->join('micr_crt', 'micr_crt.lnid = receipt.rfno', 'left');
        $this->db->join('cus_mas', 'micr_crt.apid = cus_mas.cuid');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->where('receipt.brco', $brco);
        $this->db->where('receipt.crby', $dnsr);
        $this->db->where('receipt.retp', 2);
        if($dndt < '2018-08-27'){
        }else{
            $this->db->where('receipt.dnid', $auid);
        }
        $this->db->where(" DATE_FORMAT(receipt.crdt, '%Y-%m-%d') = '$dndt' ");
        $query = $this->db->get();
        $data = $query->result();


        // GET REPORT MODULE DATA
        if ($brco != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brco));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('OFFICER DENOMINATION');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "OFFICER DENOMINATION : " . $dndt, 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(120, 22);

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 12);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dndt, 0, 1, 'L');
        $this->pdf2->SetXY(250, 17);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');
        $this->pdf2->SetXY(250, 22);
        $this->pdf2->Cell(10, 6, "Referance : " . $rfcd, 0, 1, 'L');

        $cy = date('Y');
        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(25);
        $cy = $this->pdf2->GetY();

        // SUMMERY OF REPAYMENT
        $this->pdf2->SetXY(100, $cy + 2);
        $this->pdf2->Cell(10, 7, 'NO', 1, 1, 'C');
        $this->pdf2->SetXY(110, $cy + 2);
        $this->pdf2->Cell(40, 7, 'CENTER', 1, 1, 'C');
        $this->pdf2->SetXY(150, $cy + 2);
        $this->pdf2->Cell(30, 7, 'REPAYMENT', 1, 1, 'C');
        $this->pdf2->SetXY(180, $cy + 2);
        $this->pdf2->Cell(30, 7, 'TOTAL VALUE', 1, 1, 'C');
        $i = 1;
        $ttlr = 0;
        $ttlv = 0;

        foreach ($dat1 as $dyend) {
            $this->pdf2->SetFont('Helvetica', '', 8);
            $cy = $this->pdf2->GetY();
            $this->pdf2->SetXY(100, $cy);
            $this->pdf2->Cell(10, 7, $i, 1, 1, 'C');
            $this->pdf2->SetXY(110, $cy);
            $this->pdf2->Cell(40, 7, $dyend->cnnm, 1, 1, 'L');
            $this->pdf2->SetXY(150, $cy);
            $this->pdf2->Cell(30, 7, $dyend->nrp, 1, 1, 'C');
            $this->pdf2->SetXY(180, $cy);
            $this->pdf2->Cell(30, 7, number_format($dyend->ttl, 2), 1, 1, 'R');
            if ($cy >= 170) {                       //   Add New Page
                $this->pdf2->AddPage('L');
                $this->pdf2->SetMargins(10, 10, 10);
                $this->pdf2->SetAuthor('www.gdcreations.com');
                $this->pdf2->SetTitle('OFFICER DENOMINATION');
                $this->pdf2->SetDisplayMode('default');
                $cy = 35;
                $cy = $this->pdf2->GetY();
            } else {
                $cy = $cy + 7;
            }
            $ttlr += $dyend->nrp;
            $ttlv += $dyend->ttl;
            $i++;
        }

        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(100, $cy);
        $this->pdf2->Cell(10, 7, '', 1, 1, 'C');
        $this->pdf2->SetXY(110, $cy);
        $this->pdf2->Cell(40, 7, 'Total', 1, 1, 'L');
        $this->pdf2->SetXY(150, $cy);
        $this->pdf2->Cell(30, 7, $ttlr, 1, 1, 'C');
        $this->pdf2->SetXY(180, $cy);
        $this->pdf2->Cell(30, 7, number_format($ttlv, 2), 1, 1, 'R');


        // Column widths
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetY($cy + 10);
        $header = array('NO', 'BRCH', 'CENTER', 'CUST NO', ' CUST NAME', 'RECEIPTS NO', 'LOAN NO', 'AMOUNT', 'USER', 'CREATE DATE');
        $w = array(10, 10, 30, 30, 40, 30, 35, 30, 25, 35);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $ttl = 0;
        $i = 1;
        foreach ($data as $row) {
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[2], 6, $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->cuno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->init, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->reno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[6], 6, $row->acno, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->ramt, 2), 'LR', '', 'R', $fill);
            //$this->pdf2->Cell($w[7], 6, '$row->tem_name', 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[8], 6, $row->usnm, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[9], 6, $row->crdt, 'LR', 0, 'L', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttl = $ttl + $row->ramt;
            if ($cy >= 170) {                       //   Add New Page
                $this->pdf2->AddPage('L');
                $this->pdf2->SetMargins(10, 10, 10);
                $this->pdf2->SetAuthor('www.gdcreations.com');
                $this->pdf2->SetTitle('OFFICER DENOMINATION');
                $this->pdf2->SetDisplayMode('default');
                $cy = 35;
                $cy = $this->pdf2->GetY();
            } else {
                $cy = $cy + 7;
            }
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($ttl, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, '', 'LR', 0, 'R', $fill);

// Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        $this->pdf2->SetTitle('Day End Report - ' . $dndt);
        $this->pdf2->Output(' Day End Report  ' . $dndt . '.pdf', 'I');
        ob_end_flush();

        $funcPerm = $this->Generic_model->getFuncPermision('denomi');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Officer Denomination ');

    }
// END PRINT DENOMINATION
//
// REPORT LOAN
    function rpt_loan()
    {
        $this->load->view('modules/common/tmp_header');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('modules/user/includes/user_header', $per);

        $data['funcPerm'] = $this->Generic_model->getFuncPermision('rpt_loan');
        $data['branchinfo'] = $this->Generic_model->getBranch();
        $data['execinfo'] = $this->Generic_model->getExe();
        $data['centinfo'] = $this->Generic_model->getCen();
        $data['statinfo'] = $this->Generic_model->getData('loan_stat', array('stid', 'stnm'), array('isac' => 1));
        $data['prtpinfo'] = $this->Generic_model->getData('prdt_typ' ,array('prid', 'prna'),array('stat' => 1) );

        $this->load->view('modules/report/rpt_loan', $data);
        $this->load->view('modules/common/footer');
        $this->load->view('modules/common/cus_script_full_width');
        $this->load->view('modules/common/custom_js_common');
    }

    // SEARCH BTN
    function searchLoan()
    {
        $result = $this->Report_model->get_loan();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            // IF CHECK PRODUCT LOAN OR DYNAMIC LOAN
            if ($row->lntp == 1) {
                $lntp = "<span class='label label-success' title='Product Loan'>P</span>";
            } elseif ($row->lntp == 2) {
                $lntp = "<span class='label label-warning' title='Dynamic Loan'>D</span>";
            }
            if($row->lnst=1)
                $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd.'/'.$row->cnnm;
            $sub_arr[] = $row->full;
            $sub_arr[] = $row->prcd;
            $sub_arr[] = $row->acno;
            $sub_arr[] = $row->init;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = number_format($row->loam, 2);
            $sub_arr[] = number_format($row->inam, 2);
            $sub_arr[] = $row->lnpr . ' ' . $row->pymd;
            $sub_arr[] = number_format($row->boc, 2);
            $sub_arr[] = number_format($row->boi, 2);
            $sub_arr[] = $row->stnm;
            $sub_arr[] = $row->cvdt;
            $sub_arr[] = $row->usr;
            $data[] = $sub_arr;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Report_model->count_all_loan(),
            "recordsFiltered" => $this->Report_model->count_filtered_loan(),
            "data" => $data,
        );
        //$output = array("data" => $data);
        echo json_encode($output);
    }

    //  PRINT PDF
    function printLoan($brn, $exc, $cen, $frdt, $todt, $stat,$prdt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_loan');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Loan Report');

        // GET REPORT MODULE DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;
        $_POST['stat'] = $stat;
        $_POST['prdt'] = $prdt;

        $result = $this->Report_model->loan_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brn != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brn));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Loan Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "LOAN REPORT ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(10, 20);
        $this->pdf2->Cell(0, 0, "From " . $frdt . "    " . "To " . $todt, 0, 1, 'C');

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 10);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');
        $this->pdf2->SetXY(250, 15);
        $this->pdf2->Cell(10, 6, "Branch : " . $brnm, 0, 1, 'L');

        /*$this->pdf2->SetXY(250, 20);
        $this->pdf2->Cell(10, 6, '$center', 0, 1, 'L');
        $this->pdf2->SetXY(250, 25);
        $this->pdf2->Cell(10, 6, '$executive', 0, 1, 'L');
        $this->Image($img, 5, 5, 30, 20, '');
        $this->SetXY(9, 28); */

        // Column widths
        $this->pdf2->SetY(25);
        $header = array('NO', 'BRCH/ CNTR', 'CUST NAME', ' CUST NIC', 'LOAN NO', 'PRDT', 'AMOUNT', 'RENTAL', 'PERIOD', 'STATUS', 'CR DATE', 'CR BY');
        $w = array(10, 35, 50, 25, 35, 10, 25, 20, 10, 20, 20, 25);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;
        $ttln = $ttrn = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {
            if ($row->lntp == 1) {
                $lntp = "<span class='label label-success' title='Product Loan'>P</span>";
            } elseif ($row->lntp == 2) {
                $lntp = "<span class='label label-warning' title='Dynamic Loan'>D</span>";
            }
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd . '/' . $row->cnnm, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->init, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->anic, 'LR', '', 'C', $fill);
            $this->pdf2->Cell($w[4], 6, $row->acno, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->prcd, 'LR', '', 'C', $fill);
            $this->pdf2->Cell($w[6], 6, number_format($row->loam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->inam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, $row->lnpr . ' ' . $row->pymd, 'LR', '', 'C', $fill);
            $this->pdf2->Cell($w[9], 6, $row->stnm, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[10], 6, $row->crdt, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[11], 6, $row->usr, 'LR', 0, 'L', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $ttln = $ttln + $row->loam;
            $ttrn = $ttrn + $row->inam;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[6], 6, number_format($ttln, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($ttrn, 2), 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[8], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[9], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[10], 6, '', 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[11], 6, '', 'LR', 0, 'R', $fill);

        // Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Loan Report');
        $this->pdf2->Output('Loan Report.pdf', 'I');
        ob_end_flush();
    }
// END RECEIPTS
//
// LOAN LEADGER PRINT
    function printLoanleg($lnid)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('nicSearchDtils');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print Loan Ledger');

        // GET REPORT MODULE DATA
        $this->db->select("");
        $this->db->from("micr_crleg");
        $this->db->where('acid', $lnid);
        $this->db->where('stat', '1');
        $this->db->order_by('micr_crleg.lgid', 'asc');
        $query = $this->db->get();
        $data['aa'] = $query->result();

        $lninfo = $this->Generic_model->getData('micr_crt', array('acno'), array('lnid' => $lnid));
        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Loan Ledger Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "ACCOUNT LEDGER SHEET (" . $lninfo[0]->acno . ')', 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);

        $this->pdf2->SetFont('Helvetica', 'B', 9);
        $this->pdf2->SetXY(250, 10);
        $this->pdf2->Cell(10, 6, 'DATE : ' . $dt1, 0, 1, 'L');

        // Column widths
        $this->pdf2->SetY(25);
        $header = array('NO', 'DATE', 'REFERANCE', 'DESCRIPTION', 'CAPITAL', 'INTEREST', 'PENALTY', 'OTHERS', 'DUE', 'PAYMENT', 'ARREARS');
        $w = array(10, 25, 30, 50, 25, 25, 20, 20, 25, 25, 25);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        //$this->pdf2->SetFillColor(224, 235, 255);
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;

        $blam = $tcp = $tin = $tpn = $otr = $tdu = $tpy = $tar = 0;
        $i = 1;
        foreach ($data['aa'] as $row) {
            $blam = $blam + ($row->duam - $row->ream);
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, date("Y-m-d", strtotime($row->ledt)), 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[2], 6, $row->reno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->dcrp, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, number_format($row->avcp, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[5], 6, number_format($row->avin, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[6], 6, number_format($row->dpet, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[7], 6, number_format($row->schg, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[8], 6, number_format($row->duam, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[9], 6, number_format($row->ream, 2), 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[10], 6, number_format($blam, 2), 'LR', '', 'R', $fill);

            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;

            $tcp = $tcp + $row->avcp;
            $tin = $tin + $row->avin;
            $tpn = $tpn + $row->dpet;
            $otr = $otr + $row->schg;
            $tdu = $tdu + $row->duam;
            $tpy = $tpy + $row->ream;
            $tar = $tar + $blam;
        }

        // sum
        //$this->pdf2->SetX(40);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->pdf2->Cell($w[3], 6, '', 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, number_format($tcp, 2), 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[5], 6, number_format($tin, 2), 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[6], 6, number_format($tpn, 2), 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[7], 6, number_format($otr, 2), 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[8], 6, number_format($tdu, 2), 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[9], 6, number_format($tpy, 2), 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[10], 6, number_format($tar, 2), 'LR', '', 'R', $fill);

// Closing line
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(10, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(10, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        // Closing line
        //$this->pdf2->Cell(array_sum($w), 0, '', 'T');

        $this->pdf2->SetTitle('Loan Ledger Report');
        $this->pdf2->Output('Loan Ledger Report.pdf', 'I');
        ob_end_flush();

    }
// END LOAN LEADGER PRINT
//
// PRINT RECONSILATION REPORT
    function printReconsi($deid,$date2,$brid){
        $_POST['deid'] = $deid;
        $_POST['date'] = $date2;
        $_POST['brid'] = $brid;

        $resultDe = $this->Generic_model->getData('dayend_process','', array('rcid' => $deid));//day end process details
        $resultBr = $this->Generic_model->getData('brch_mas','', array('brid' => $brid));//branch details

        ob_start();
        $this->pdf2->AddPage('P', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('Reconsilation Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "RECONSILATION DETAILS ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(10, 20);
        $this->pdf2->Cell(0, 0,"Date : ".$date2, 0, 1, 'C');
        $this->pdf2->SetXY(10, 25);
        $this->pdf2->Cell(0, 0, "Branch : " . $resultBr[0]->brnm, 0, 1, 'C');

        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->setXY(30,35);
        $this->pdf2->Cell(0, 0,"Summary", 0, 'L');
        $this->pdf2->Line(20, 38, 190, 38);
        $this->pdf2->Ln();

        $reconciTTL = 0;

        $this->pdf2->SetFont('','', 9);
        $this->pdf2->setXY(40,42);
        $this->pdf2->Cell(10, 0,"(01)", 0, 'L', false);
        $this->pdf2->Cell(60, 0,"Disbursement Loans", 0, 'L', false);
        $this->pdf2->Cell(5, 0,":", 0, 'C', false);
        $this->pdf2->Cell(30, 0,number_format($resultDe[0]->dsln, 2), 0, 'R', true);

        $reconciTTL+=$resultDe[0]->dsln;

        $this->pdf2->setXY(40,47);
        $this->pdf2->Cell(10, 0,"(02)", 0, 'L', false);
        $this->pdf2->Cell(60, 0,"Disbursement RTN Loans", 0, 'L', false);
        $this->pdf2->Cell(5, 0,":", 0, 'C', false);
        $this->pdf2->Cell(30, 0,number_format(-$resultDe[0]->drln, 2), 0, 'R', true);

        $reconciTTL+=(-$resultDe[0]->drln);

        $this->pdf2->setXY(40,52);
        $this->pdf2->Cell(10, 0,"(03)", 0, 'L', false);
        $this->pdf2->Cell(60, 0,"Denomination", 0, 'L', false);
        $this->pdf2->Cell(5, 0,":", 0, 'C', false);
        $this->pdf2->Cell(30, 0,number_format($resultDe[0]->tdnm, 2), 0, 'R', true);

        $reconciTTL+=$resultDe[0]->tdnm;

        $this->pdf2->setXY(40,57);
        $this->pdf2->Cell(10, 0,"(04)", 0, 'L', false);
        $this->pdf2->Cell(60, 0,"General Voucher", 0, 'L', false);
        $this->pdf2->Cell(5, 0,":", 0, 'C', false);
        $this->pdf2->Cell(30, 0,number_format(-$resultDe[0]->gnvu, 2), 0, 'R', true);

        $reconciTTL+=(-$resultDe[0]->gnvu);

        $this->pdf2->setXY(40, 62);
        $this->pdf2->Cell(10, 0, "(04)", 0, 'L', false);
        $this->pdf2->Cell(60, 0, "Petty Cash", 0, 'L', false);
        $this->pdf2->Cell(5, 0, ":", 0, 'C', false);
        $this->pdf2->Cell(30, 0, number_format(-$resultDe[0]->ptch, 2), 0, 'R', true);

        $reconciTTL+=(-$resultDe[0]->ptch);

        $this->pdf2->setXY(40, 67);
        $this->pdf2->Cell(10, 0, "(05)", 0, 'L', false);
        $this->pdf2->Cell(60, 0, "Cancelled Loans", 0, 'L', false);
        $this->pdf2->Cell(5, 0, ":", 0, 'C', false);
        $this->pdf2->Cell(30, 0, number_format($resultDe[0]->lncn, 2), 0, 'R', true);

        $reconciTTL+=$resultDe[0]->lncn;
        $this->pdf2->Ln();
        $this->pdf2->Line(115, 69, 145, 69);
        $this->pdf2->setXY(40, 73);
        $this->pdf2->Cell(10, 0, "", 0, 'L', false);
        $this->pdf2->Cell(60, 0, "Total", 0, 'L', false);
        $this->pdf2->Cell(5, 0, ":", 0, 'C', false);
        $this->pdf2->Cell(30, 0, number_format($reconciTTL, 2), 0, 'R', true);

        $this->pdf2->Ln();
        $this->pdf2->Line(115, 75, 145, 75);
        $this->pdf2->Line(115, 76, 145, 76);
        $this->pdf2->Ln();
        $this->pdf2->setXY(40, 80);
        $this->pdf2->Cell(10, 0, "", 0, 'L', false);
        $this->pdf2->Cell(60, 0, "Collector Total", 0, 'L', false);
        $this->pdf2->Cell(5, 0, ":", 0, 'C', false);
        $this->pdf2->Cell(30, 0, number_format($resultDe[0]->rttl, 2), 0, 'R', true);
        $this->pdf2->Ln();
        $this->pdf2->setXY(40, 83);

        //Paid Loan reconsilation
        $upStY = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 10);
        $this->pdf2->setXY(30,$upStY+5);
        $this->pdf2->Cell(0, 0,"Disbursement Loans", 0, 'L');
        $this->pdf2->Line(20, $upStY+8, 190, $upStY+8);
        $this->pdf2->Ln();

        $resultPaidLn = $this->Report_model->getDsbLnRec();
        $this->pdf2->SetXY(20,$upStY+10);
        $header = array('NO', 'CUS NIC', 'LOAN NO', 'PRDT', 'AMOUNT');
        $w = array(10, 30, 50, 30, 50);
//        $this->pdf2->SetFillColor(100, 100, 100);
//        $this->pdf2->SetTextColor(255);
//        $this->pdf2->SetDrawColor(0, 0, 0);
//        $this->pdf2->SetLineWidth(.3);
//        $this->pdf2->SetFont('', 'B');
        for ($i = 0; $i < count($header); $i++) {
            $this->pdf2->SetFillColor(221, 218, 213);
            $this->pdf2->SetTextColor(0);
            $this->pdf2->SetFont('');
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $fill = false;
        $ttl = 0;
        $i = 1;
        foreach ($resultPaidLn AS $row){
            $this->pdf2->Ln();
            $this->pdf2->SetX(20);
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->anic, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[2], 6, $row->acno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->prtp, 'LR', '', 'C', $fill);
            $this->pdf2->Cell($w[4], 6, number_format($row->loam, 2), 'LR', 0, 'R', $fill);
            $fill = !$fill;
            $i++;

            $ttl = $ttl + $row->loam;
        }
        $this->pdf2->Ln();
        $this->pdf2->SetX(20);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell(110, 6, 'Total Amount',1, 0, 'C');
        $this->pdf2->Cell($w[4], 6, number_format($ttl, 2), 'LR', 0, 'R', $fill);
        //Line close at the end of table
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(20, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(20, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        //Unpaid Loan reconsilation
        $upStY = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 10);
        $this->pdf2->setXY(30,$upStY+5);
        $this->pdf2->Cell(0, 0,"Disbursement RTN Loans", 0, 'L');
        $this->pdf2->Line(20, $upStY+8, 190, $upStY+8);
        $this->pdf2->Ln();

        $resultUnPaidLn = $this->Report_model->getUnDsbLnRec();
        $this->pdf2->SetXY(20,$upStY+10);
        $header = array('NO', 'CUS NIC', 'LOAN NO', 'PRDT', 'AMOUNT');
        $w = array(10, 30, 50, 30, 50);
        for ($i = 0; $i < count($header); $i++) {
            $this->pdf2->SetFillColor(221, 218, 213);
            $this->pdf2->SetTextColor(0);
            $this->pdf2->SetFont('');
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $fill = false;
        $ttl = 0;
        $i = 1;
        foreach ($resultUnPaidLn AS $row){
            $this->pdf2->Ln();
            $this->pdf2->SetX(20);
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->anic, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[2], 6, $row->acno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->prtp, 'LR', '', 'C', $fill);
            $this->pdf2->Cell($w[4], 6, number_format($row->loam, 2), 'LR', 0, 'R', $fill);
            $fill = !$fill;
            $i++;

            $ttl = $ttl + $row->loam;
        }
        $this->pdf2->Ln();
        $this->pdf2->SetX(20);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell(110, 6, 'Total Amount',1, 0, 'C');
        $this->pdf2->Cell($w[4], 6, number_format($ttl, 2), 'LR', 0, 'R', $fill);
        //Line close at the end of table
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(20, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(20, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        //Denomination reconsilation
        $upStY = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 10);
        $this->pdf2->setXY(30,$upStY+5);
        $this->pdf2->Cell(0, 0,"Denominations", 0, 'L');
        $this->pdf2->Line(20, $upStY+8, 190, $upStY+8);
        $this->pdf2->Ln();

        $resultDe = $this->Report_model->getDenimRec();
        $this->pdf2->SetXY(20,$upStY+10);
        $header = array('NO', 'DENOMINATED BY', 'CEN COUNT', 'RE-PAY COUNT', 'AMOUNT');
        $w = array(10, 50, 30, 30, 50);
        for ($i = 0; $i < count($header); $i++) {
            $this->pdf2->SetFillColor(221, 218, 213);
            $this->pdf2->SetTextColor(0);
            $this->pdf2->SetFont('');
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $fill = false;
        $ttl=0; $cenc=0; $repc = 0;
        $i = 1;
        foreach ($resultDe AS $row){
            $this->pdf2->Ln();
            $this->pdf2->SetX(20);
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->dnur, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->nocn, 'LR', 0, 'R', $fill);
            $this->pdf2->Cell($w[3], 6, $row->norp, 'LR', '', 'R', $fill);
            $this->pdf2->Cell($w[4], 6, number_format($row->dntt, 2), 'LR', 0, 'R', $fill);
            $fill = !$fill;
            $i++;

            $ttl = $ttl + $row->dntt;
            $cenc += $row->nocn;
            $repc += $row->norp;
        }
        $this->pdf2->Ln();
        $this->pdf2->SetX(20);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell($w[1], 6, 'Total',1, 0, 'C');
        $this->pdf2->Cell($w[2], 6, $cenc, 'LR', 0, 'R', $fill);
        $this->pdf2->Cell($w[3], 6, $repc, 'LR', '', 'R', $fill);
        $this->pdf2->Cell($w[4], 6, number_format($ttl, 2), 'LR', 0, 'R', $fill);
        //Line close at the end of table
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(20, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(20, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        //General Voucher reconsilation
        $upStY = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 10);
        $this->pdf2->setXY(30,$upStY+5);
        $this->pdf2->Cell(0, 0,"General Vouchers", 0, 'L');
        $this->pdf2->Line(20, $upStY+8, 190, $upStY+8);
        $this->pdf2->Ln();

        $resultGenV = $this->Report_model->getGenRec();
        $this->pdf2->SetXY(20,$upStY+10);
        $header = array('NO', 'VOUC NO', 'VOUC DEC', 'PAY TYPE','AMOUNT');
        $w = array(10, 30, 50, 30, 50);
        for ($i = 0; $i < count($header); $i++) {
            $this->pdf2->SetFillColor(221, 218, 213);
            $this->pdf2->SetTextColor(0);
            $this->pdf2->SetFont('');
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $fill = false;
        $ttl=0;
        $i = 1;
        foreach ($resultGenV AS $row){
            $this->pdf2->Ln();
            $this->pdf2->SetX(20);
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->vuno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->rfdc, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->tem_name, 'LR', '', 'C', $fill);
            $this->pdf2->Cell($w[4], 6, number_format($row->vuam, 2), 'LR', 0, 'R', $fill);
            $fill = !$fill;
            $i++;

            $ttl = $ttl + $row->vuam;
        }
        $this->pdf2->Ln();
        $this->pdf2->SetX(20);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell(110, 6, 'Total Amount',1, 0, 'C');
        $this->pdf2->Cell($w[4], 6, number_format($ttl, 2), 'LR', 0, 'R', $fill);
        //Line close at the end of table
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(20, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(20, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        //Petty Cash reconsilation
        $upStY = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 10);
        $this->pdf2->setXY(30,$upStY+5);
        $this->pdf2->Cell(0, 0,"Petty Cash", 0, 'L');
        $this->pdf2->Line(20, $upStY+8, 190, $upStY+8);
        $this->pdf2->Ln();

        $resultPetCa = $this->Report_model->getPetRec();
        $this->pdf2->SetXY(20,$upStY+10);
        $header = array('NO','VOUC NO', 'ACCOUNT','AMOUNT');
        $w = array(10, 30, 80, 50);
        for ($i = 0; $i < count($header); $i++) {
            $this->pdf2->SetFillColor(221, 218, 213);
            $this->pdf2->SetTextColor(0);
            $this->pdf2->SetFont('');
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $fill = false;
        $ttl=0;
        $i = 1;
        foreach ($resultPetCa AS $row){
            $this->pdf2->Ln();
            $this->pdf2->SetX(20);
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->vuno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[2], 6, $row->hadr, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, number_format($row->amut, 2), 'LR', 0, 'R', $fill);
            $fill = !$fill;
            $i++;

            $ttl = $ttl + $row->amut;
        }
        $this->pdf2->Ln();
        $this->pdf2->SetX(20);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell(110, 6, 'Total Amount',1, 0, 'C');
        $this->pdf2->Cell($w[3], 6, number_format($ttl, 2), 'LR', 0, 'R', $fill);
        //Line close at the end of table
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(20, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(20, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        //Cancellation loans reconsilation
        $upStY = $this->pdf2->GetY();
        $this->pdf2->SetFont('Helvetica', 'B', 10);
        $this->pdf2->setXY(30,$upStY+5);
        $this->pdf2->Cell(0, 0,"Cancelled Loans", 0, 'L');
        $this->pdf2->Line(20, $upStY+8, 190, $upStY+8);
        $this->pdf2->Ln();

        $resultUnPaidLn = $this->Report_model->getCnLnRec();
        $this->pdf2->SetXY(20,$upStY+10);
        $header = array('NO', 'CUS NIC', 'LOAN NO', 'PRDT', 'AMOUNT');
        $w = array(10, 30, 50, 30, 50);
        for ($i = 0; $i < count($header); $i++) {
            $this->pdf2->SetFillColor(221, 218, 213);
            $this->pdf2->SetTextColor(0);
            $this->pdf2->SetFont('');
            $this->pdf2->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $fill = false;
        $ttl = 0;
        $i = 1;
        foreach ($resultUnPaidLn AS $row){
            $this->pdf2->Ln();
            $this->pdf2->SetX(20);
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->anic, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[2], 6, $row->acno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->prtp, 'LR', '', 'C', $fill);
            $this->pdf2->Cell($w[4], 6, number_format($row->loam, 2), 'LR', 0, 'R', $fill);
            $fill = !$fill;
            $i++;

            $ttl = $ttl + $row->loam;
        }
        $this->pdf2->Ln();
        $this->pdf2->SetX(20);
        $this->pdf2->Cell($w[0], 6, '', 'LR', 0, 'C', $fill);
        $this->pdf2->Cell(110, 6, 'Total Amount',1, 0, 'C');
        $this->pdf2->Cell($w[4], 6, number_format($ttl, 2), 'LR', 0, 'R', $fill);
        //Line close at the end of table
        $cy = $this->pdf2->GetY();
        $this->pdf2->SetXY(20, $cy);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');
        $this->pdf2->SetXY(20, $cy + 6);
        $this->pdf2->Cell(array_sum($w), 6, '', 'T');

        $this->pdf2->SetTitle('Reconsilation Report');
        $this->pdf2->Output("Reconsilation Report ".date('Y-m-d').".pdf", 'I');
        ob_end_flush();
    }
// END PRINT RECONSILATION REPORT
//
// SMS REPORT PDF
    function smsrpt($brch, $frdt, $sest, $todt, $type)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('sms_rpt');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print SMS Report');
        // GET REPORT MODULE DATA
        $_POST['brch'] = $brch;
        $_POST['frdt'] = $frdt;
        $_POST['sest'] = $sest;
        $_POST['todt'] = $todt;
        $_POST['type'] = $type;
        //get qurry
        $result = $this->User_model->sms_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brch != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brch ));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        $dt1 = date('Y-m-d');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(10, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('SMS Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "SMS Report ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(10, 20);
        $this->pdf2->Cell(0, 0, "From " . $frdt . "    " . "To " . $todt, 0, 1, 'C');

        $this->pdf2->SetFont('Helvetica', '', 11);
        $this->pdf2->SetXY(0, 15);
        $this->pdf2->Cell(0, 0, "Date : ". $dt1 , 0, 1, 'R');
        $this->pdf2->SetXY(0, 20);
        $this->pdf2->Cell(0,0, "Branch : ". $brnm, 0, 1, 'R');

        $this->pdf2->SetFont('Helvetica', '', 9);
        $this->pdf2->SetXY(10,26);
        $this->pdf2->Cell(0, 0, "RM-Repayment Message", 0, 1, 'L');
        $this->pdf2->SetXY(50, 26);
        $this->pdf2->Cell(0,0, "CM-Cancel Message", 10, 1, 'L');
        $this->pdf2->SetXY(85, 26);
        $this->pdf2->Cell(0, 0, "DM-Disbursement Message", 0, 1, 'L');

        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH',' LOAN NO', 'CUSTOMER NO', 'CUSTOMER',  'PHONE NO','RECEIPT NO', 'CRDT DATE&TIME', 'TYPE');
        $w = array(10, 15, 42, 30,60 , 25, 35, 40, 20);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 9, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;
        $i = 1;
        foreach ($data['aa'] as $row) {
            if ($row->mstp == 1) {
                $trac = "RM";
            } else if ($row->mstp == 2) {
                $trac = "CM";
            } else {
                $trac = "DM";
            }
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd , 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[2], 6, $row->acno, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->cuno, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->init, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->spno, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[6], 6, $row->reno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[7], 6, $row->crdt, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[8], 6, $trac, 'LR', 0, 'C', $fill);
            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;
        }
        $this->pdf2->SetTitle('SMS Report');
        $this->pdf2->Output('SMS Report.pdf', 'I');
        ob_end_flush();
    }
// END SMS REPORT PDF
//
// SMS DELIVERY REPORT
    function sms_dlvRpt($brch, $frdt, $sest, $todt, $type)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('sms_rpt');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Print SMS Report');
        // GET REPORT MODULE DATA
        $_POST['brch'] = $brch;
        $_POST['frdt'] = $frdt;
        $_POST['sest'] = $sest;
        $_POST['todt'] = $todt;
        $_POST['type'] = $type;
        //get qurry
        $result = $this->User_model->smsdl_query();
        $query = $this->db->get();
        $data['aa'] = $query->result();

        // GET REPORT MODULE DATA
        if ($brch != 'all') {
            $brninfo = $this->Generic_model->getData('brch_mas', array('brnm'), array('brid' => $brch ));
            $brnm = $brninfo[0]->brnm;
        } else {
            $brnm = "All Branch";
        }
        $dt1 = date('Y-m-d');

        ob_start();
        $this->pdf2->AddPage('L', 'A4');
        $this->pdf2->SetMargins(23, 10, 10);
        $this->pdf2->SetAuthor('www.gdcreations.com');
        $this->pdf2->SetTitle('SMS Delivery Report');
        $this->pdf2->SetDisplayMode('default');

        $this->pdf2->SetFont('Helvetica', '', 8);
        $this->pdf2->SetY(15);
        $this->pdf2->SetFont('Helvetica', 'B', 15);
        $this->pdf2->Cell(0, 0, "SMS Delivery  Report ", 0, 1, 'C');
        $this->pdf2->SetFont('Helvetica', 'B', 11);
        $this->pdf2->SetXY(22, 20);
        $this->pdf2->Cell(0, 0, "From " . $frdt . "    " . "To " . $todt, 0, 1, 'C');

        $this->pdf2->SetFont('Helvetica', '', 11);
        $this->pdf2->SetXY(240, 15);
        $this->pdf2->Cell(0, 0, "Date : ". $dt1 , 0, 1, '');
        $this->pdf2->SetXY(240, 20);
        $this->pdf2->Cell(0,0, "Branch : ". $brnm, 0, 1, '');

        $this->pdf2->SetFont('Helvetica', '', 9);
        $this->pdf2->SetXY(23,26);
        $this->pdf2->Cell(0, 0, "RM-Repayment Message", 0, 1, 'L');
        $this->pdf2->SetXY(60, 26);
        $this->pdf2->Cell(0,0, "CM-Cancel Message", 10, 1, 'L');
        $this->pdf2->SetXY(90, 26);
        $this->pdf2->Cell(0, 0, "DM-Disbursement Message", 0, 1, 'L');

        $this->pdf2->SetY(30);
        $header = array('NO', 'BRCH',' LOAN NO', 'CUSTOMER NO',  'PHONE NO','RECEIPT NO', 'TYPE', 'STATUS','SEND DATE&TIME');
        $w = array(10, 15, 45, 35,30 , 35, 15, 20, 45);
        // Colors, line width and bold font
        $this->pdf2->SetFillColor(100, 100, 100);
        //$this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(255);
        $this->pdf2->SetDrawColor(0, 0, 0);
        $this->pdf2->SetLineWidth(.3);
        $this->pdf2->SetFont('', 'B');
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->pdf2->Cell($w[$i], 8, $header[$i], 1, 0, 'C', true);
        $this->pdf2->Ln();
        // Color and font restoration
        $this->pdf2->SetFillColor(221, 218, 213);
        $this->pdf2->SetTextColor(0);
        $this->pdf2->SetFont('');
        // Data
        $fill = false;
        $i = 1;
        foreach ($data['aa'] as $row) {
            if ($row->mstp == 1) {
                $tra = "RM";
            } else if ($row->mstp == 2) {
                $tra = "CM";
            } else {
                $tra = "DM";
            }

            if ($row->stat == 0) {
                $stat = "Pending";
            } else if ($row->stat == 1) {
                $stat = "Send";
            }

            if($row->sndt == null){
                $sndt="-";
            }
            else{
                $sndt =$row->sndt;
            }
            $this->pdf2->Cell($w[0], 6, $i, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[1], 6, $row->brcd , 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[2], 6, $row->acno, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[3], 6, $row->cuno, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[4], 6, $row->spno, 'LR', '', 'L', $fill);
            $this->pdf2->Cell($w[5], 6, $row->reno, 'LR', 0, 'L', $fill);
            $this->pdf2->Cell($w[6], 6, $tra, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[7], 6, $stat, 'LR', 0, 'C', $fill);
            $this->pdf2->Cell($w[8], 6, $sndt, 'LR', 0, 'C', $fill);
            $this->pdf2->Ln();
            $fill = !$fill;
            $i++;
        }
        $this->pdf2->SetTitle('SMS Delivery  Report');
        $this->pdf2->Output('SMS Delivery Report .pdf', 'I');
        ob_end_flush();
    }

// END SMS DELIVERY REPORT

}
