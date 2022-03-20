<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excelrpt extends CI_Controller
{

    /*  THIS CONTROLLER USE FOR REPORT  */
    function __construct()
    {
        parent::__construct();

        //load our new PHPExcel library
        $this->load->library('excel');

        $this->load->database(); // load database
        $this->load->model('Generic_model'); // load model
        $this->load->model('Report_model'); // load model
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
        $this->load->view('modules/user/includes/user_header', $data);
        $this->load->view('modules/user/dashboard');
        $this->load->view('modules/common/footer');
    }

// ############### START BEGIN EXCEL REPORT ####################//
//
//
// START EXCEL TODAY ARREARS
    public function todyArres($brn, $exc, $cen, $cndy, $prtp)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_tdysch');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Center Schedule Arrears Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $exc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['cndy'] = $cndy;

        $result = $this->Report_model->tdyArres_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();
        // END GET LOAD DATA

        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Center Schedule Arrears Reports')
            ->setKeywords('Center Schedule Arrears Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Center Schedule Arrears Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(9);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(15);
        $activeSheet->getColumnDimension('E')->setWidth(15);
        $activeSheet->getColumnDimension('F')->setWidth(30);

        $activeSheet->getColumnDimension('G')->setWidth(15);
        $activeSheet->getColumnDimension('H')->setWidth(15);
        $activeSheet->getColumnDimension('I')->setWidth(15);
        $activeSheet->getColumnDimension('J')->setWidth(15);
        $activeSheet->getColumnDimension('K')->setWidth(15);
        $activeSheet->getColumnDimension('L')->setWidth(15);

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));

        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "CENTER")
            ->setCellValue('C1', "SHED DAY ")
            ->setCellValue('D1', "CUSTOMER NO")
            ->setCellValue('E1', "NIC")
            ->setCellValue('F1', "LOAN NO")
            ->setCellValue('G1', "LOAN AMNT")
            ->setCellValue('H1', "BALANCE")
            ->setCellValue('I1', "RENTAL")
            ->setCellValue('J1', "ARR AMNT")
            ->setCellValue('K1', "ARR AGE")
            ->setCellValue('L1', "STATUS");

        $activeSheet->getStyle('A1:L1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:L1')->applyFromArray($styleArray1);

        $col = 'O';
        $rownum = 2;
        // read data to active sheet
        foreach ($dataValue as $value) {

            if ($value ["cage"] < 0) {
                $sta = "Over payment";
            } else if ($value ["cage"] == 0) {
                $sta = "Normal";
            } else if ($value ["cage"] > 0) {
                $sta = "Arrears";
            } else {
                $sta = "--";
            }

            $col = 'A';
            $activeSheet->setCellValue($col++ . $rownum, $value ["brcd"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cnnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cday"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["cuno"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["anic"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["acno"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["loam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["baln"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["inam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["arres"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["cage"]);
            $activeSheet->setCellValue($col++ . $rownum, $sta);

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $activeSheet->getStyle('G1:G' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('H1:H' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('I1:I' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('J1:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('K1:K' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');


        $activeSheet->SetCellValue('G' . $rownum, "=SUM(G2:G" . ($rownum - 1) . ")")->getStyle('G' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('H' . $rownum, "=SUM(H2:H" . ($rownum - 1) . ")")->getStyle('H' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('I' . $rownum, "=SUM(I2:I" . ($rownum - 1) . ")")->getStyle('I' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J2:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('K' . $rownum, "=SUM(K2:K" . ($rownum - 1) . ")")->getStyle('K' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);


        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A2');


        $filename = 'Center Schedule Arrears.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }

// END TODAY ARREARS
//
// START EXCEL PORTFOLIO
    public function portfolio($brn, $type, $asdt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_portfo');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Portfolio Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['type'] = $type;
        $_POST['asdt'] = $asdt;

        $result = $this->Report_model->portfo_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();

        // END GET LOAD DATA

        if ($type == '1') {
            $tp_nm = 'Current';
        } elseif ($type == '2') {
            $tp_nm = 'Finished';
        } elseif ($type == '3') {
            $tp_nm = 'Terminate';
        }


        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Portfolio Reports')
            ->setKeywords('Portfolio Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($tp_nm . ' Portfolio Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:AP1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(9);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(25);
        $activeSheet->getColumnDimension('E')->setWidth(10);
        $activeSheet->getColumnDimension('F')->setWidth(25);
        $activeSheet->getColumnDimension('G')->setWidth(15);
        $activeSheet->getColumnDimension('H')->setWidth(10);
        foreach (range('I', 'K') as $cid1) {
            $activeSheet->getColumnDimension($cid1)->setWidth(15);
        }
        $activeSheet->getColumnDimension('L')->setWidth(9);
        foreach (range('M', 'V') as $cid2) {
            $activeSheet->getColumnDimension($cid2)->setWidth(15);
        }
        foreach (range('W', 'Z') as $cid3) {
            $activeSheet->getColumnDimension($cid3)->setWidth(11);
        }
        $activeSheet->getColumnDimension('AA')->setWidth(19);
        $activeSheet->getColumnDimension('AB')->setWidth(13);
        $activeSheet->getColumnDimension('AC')->setWidth(15);
        $activeSheet->getColumnDimension('AD')->setWidth(15);

        $activeSheet->getColumnDimension('AE')->setWidth(20);
        $activeSheet->getColumnDimension('AF')->setWidth(15);
        $activeSheet->getColumnDimension('AG')->setWidth(15);
        $activeSheet->getColumnDimension('AH')->setWidth(15);
        $activeSheet->getColumnDimension('AI')->setWidth(15);
        $activeSheet->getColumnDimension('AJ')->setWidth(15);
        $activeSheet->getColumnDimension('AK')->setWidth(15);
        $activeSheet->getColumnDimension('AL')->setWidth(15);
        $activeSheet->getColumnDimension('AM')->setWidth(15);
        $activeSheet->getColumnDimension('AN')->setWidth(15);
        $activeSheet->getColumnDimension('AO')->setWidth(15);
        $activeSheet->getColumnDimension('AP')->setWidth(20);
        //$activeSheet->getColumnDimension('AN')->setWidth(15);


        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));


        $activeSheet->setCellValue('A1', "BRANCH\nCODE")
            ->setCellValue('B1', "CENTER")
            ->setCellValue('C1', "CUSTOMER\nNO")
            ->setCellValue('D1', "LOAN NO")
            ->setCellValue('E1', "TYPE")
            ->setCellValue('F1', "CUSTOMER")
            ->setCellValue('G1', "NIC")
            ->setCellValue('H1', "Loan\nIndex")
            ->setCellValue('I1', "LOAN\nAMOUNT")
            ->setCellValue('J1', "INT\nAMOUNT")
            ->setCellValue('K1', "RENTAL")
            ->setCellValue('L1', "NO OF\nPERIOD")
            ->setCellValue('M1', "BAL CAP")
            ->setCellValue('N1', "BAL INT")
            ->setCellValue('O1', "ARR CAP")
            ->setCellValue('P1', "ARR INT")
            ->setCellValue('Q1', "PENALTY")
            ->setCellValue('R1', "CAPITAL\nPAID")
            ->setCellValue('S1', "INTERST\nPAID")
            ->setCellValue('T1', "CAP+INT")
            ->setCellValue('U1', "CUSTOMER\nTOTAL PAID")
            ->setCellValue('V1', "Over\nPayments")
            ->setCellValue('W1', "DOC\nCHARGE")
            ->setCellValue('X1', "INSU\nCHARGE")
            ->setCellValue('Y1', "ARREARS \nAGE")
            ->setCellValue('Z1', "ACCOUNT\nDATE")
            ->setCellValue('AA1', "DISBURSEMENT\nDATE")
            ->setCellValue('AB1', "NEXT RENTAL\nDATE")
            ->setCellValue('AC1', "FUTURE NO\nOF RENTALS")
            ->setCellValue('AD1', "LAST PAY DATE ")
            ->setCellValue('AE1', "EXECUTIVE ")
            ->setCellValue('AF1', "LAST WEEK\nPAID AMOUNT")
            ->setCellValue('AG1', "DUE\nRENTAL AMOUNT")
            ->setCellValue('AH1', "WITHIN LAST\n21 DAYS PAID")
            ->setCellValue('AI1', "PAID\nAMT %")
            ->setCellValue('AJ1', "WITHIN LAST\n45 DAYS PAID")
            ->setCellValue('AK1', "LAST 45 DAYS\nPAID AMT")
            ->setCellValue('AL1', "WITHIN LAST\n60 DAYS PAID")
            ->setCellValue('AM1', "LAST 60 DAYS\n PAID AMT")
            ->setCellValue('AN1', "WITHIN LAST\n90 DAYS PAID")
            ->setCellValue('AO1', "LAST 90 DAYS\n PAID AMT")
            ->setCellValue('AP1', "PHONE NO");

        //->setCellValue('AD1', "EXEC ");
        $activeSheet->getStyle('A1:AP1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:AP1')->applyFromArray($styleArray1);


        $col = 'O';
        $rownum = 2;
        // read data to active sheet
        foreach ($dataValue as $value) {
            $col = 'A';
            $activeSheet->setCellValue($col++ . $rownum, $value ["brcd"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cnnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cuno"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["acno"]);
            $activeSheet->setCellValue($col++ . $rownum, substr($value ["prcd"], 0, 2));
            $activeSheet->setCellValue($col++ . $rownum, $value ["init"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["anic"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["lcnt"]); // loan index

            $activeSheet->setCellValue($col++ . $rownum, $value ["loam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["inta"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["inam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["noin"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["boc"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boi"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["aboc"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["aboi"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["avpe"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["avcp"]); // capital pyd
            $activeSheet->setCellValue($col++ . $rownum, $value ["avin"]); // int pyd
            $activeSheet->setCellValue($col++ . $rownum, $value ["avcp"] + $value ["avcp"]); // cap + int

            $activeSheet->setCellValue($col++ . $rownum, $value ["ttpym"]); //total
            $activeSheet->setCellValue($col++ . $rownum, $value ["avcr"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["docg"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["incg"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cage"]); // $value ["loan_age"]

            $activeSheet->setCellValue($col++ . $rownum, date('n/d/Y', strtotime($value ["acdt"]))); //date("Y-m-d", strtotime($value ["acdt"]))
            $activeSheet->setCellValue($col++ . $rownum, date('n/d/Y', strtotime($value ["madt"])));                 //DISBURSEMENT DATE
            $activeSheet->setCellValue($col++ . $rownum, date('n/d/Y', strtotime($value ["nxdd"])));       //NEXT RENTAL DATE

            $activeSheet->setCellValue($col++ . $rownum, $value ["durg"]); // future rental
            $activeSheet->setCellValue($col++ . $rownum, date('n/d/Y', strtotime($value ["lspd"])));       //LAST PAYMNT DATE
            $activeSheet->setCellValue($col++ . $rownum, $value ["usnm"]); // EXECUTIVE

            $activeSheet->setCellValue($col++ . $rownum, $value ["lwpd"]);          //LAST PAYED
            $activeSheet->setCellValue($col++ . $rownum, $value ["inam"]);          //due rental

            $activeSheet->setCellValue($col++ . $rownum, $value ["lp21"]);        //last 21
            $activeSheet->setCellValue($col++ . $rownum, $value ["pr21"]);          //last 21%
            $activeSheet->setCellValue($col++ . $rownum, $value ["lpmt45"]);          //last 45
            $activeSheet->setCellValue($col++ . $rownum, $value ["lp45"]);          //last 45
            $activeSheet->setCellValue($col++ . $rownum, $value ["lpmt60"]);          //last 60
            $activeSheet->setCellValue($col++ . $rownum, $value ["lp60"]);          //last 60
            $activeSheet->setCellValue($col++ . $rownum, $value ["lpmt90"]);          //last 90
            $activeSheet->setCellValue($col++ . $rownum, $value ["lp90"]);          //last 90
            $activeSheet->setCellValue($col++ . $rownum, $value ["mobi"]);          //cust mobile

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('P2:P' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('Q2:Q' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('R2:R' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('S2:S' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('T2:T' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('U2:U' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('V2:V' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('W2:W' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('X2:X' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('Y2:Y' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('Z2:Z' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AA2:AA' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AB2:AB' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AC2:AC' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('AD2:AD' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //$activeSheet->getStyle('AD2:AD' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('AE2:AE' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('AF2:AF' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AG2:AG' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AH2:AH' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('AI2:AI' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AJ2:AJ' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('AK2:AK' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AL2:AL' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('AM2:AM' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AN2:AN' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('AO2:AO' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AP2:AP' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $activeSheet->getStyle('I1:I' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('J1:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('K1:K' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('M1:M' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('N1:N' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('O1:O' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('P1:P' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('Q1:Q' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('R1:R' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('S1:S' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('T1:T' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('U1:U' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('V1:V' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('W1:W' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('X1:X' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        // $activeSheet->getStyle('Y1:Y' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AF1:AF' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AG1:AG' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AI1:AI' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AK1:AK' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AM1:AM' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AO1:AO' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');

        $activeSheet->SetCellValue('I' . $rownum, "=SUM(I2:I" . ($rownum - 1) . ")")->getStyle('I' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J2:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('K' . $rownum, "=SUM(K2:K" . ($rownum - 1) . ")")->getStyle('K' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('M' . $rownum, "=SUM(M2:M" . ($rownum - 1) . ")")->getStyle('M' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('N' . $rownum, "=SUM(N2:N" . ($rownum - 1) . ")")->getStyle('N' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('O' . $rownum, "=SUM(O2:O" . ($rownum - 1) . ")")->getStyle('O' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('P' . $rownum, "=SUM(P2:P" . ($rownum - 1) . ")")->getStyle('P' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('Q' . $rownum, "=SUM(Q2:Q" . ($rownum - 1) . ")")->getStyle('Q' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('R' . $rownum, "=SUM(R2:R" . ($rownum - 1) . ")")->getStyle('R' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('S' . $rownum, "=SUM(S2:S" . ($rownum - 1) . ")")->getStyle('S' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('T' . $rownum, "=SUM(T2:T" . ($rownum - 1) . ")")->getStyle('T' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('U' . $rownum, "=SUM(U2:U" . ($rownum - 1) . ")")->getStyle('U' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('V' . $rownum, "=SUM(V2:V" . ($rownum - 1) . ")")->getStyle('V' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('W' . $rownum, "=SUM(W2:W" . ($rownum - 1) . ")")->getStyle('W' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('X' . $rownum, "=SUM(X2:X" . ($rownum - 1) . ")")->getStyle('X' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
//        $activeSheet->SetCellValue('AF' . $rownum, "=SUM(AF2:AF" . ($rownum - 1) . ")")->getStyle('Y' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
//        $activeSheet->SetCellValue('Y' . $rownum, "=SUM(Y2:Y" . ($rownum - 1) . ")")->getStyle('Y' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('AF' . $rownum, "=SUM(AF2:AF" . ($rownum - 1) . ")")->getStyle('AF' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('AG' . $rownum, "=SUM(AG2:AG" . ($rownum - 1) . ")")->getStyle('AG' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        //   $activeSheet->SetCellValue('AI' . $rownum, "=SUM(AI2:AI" . ($rownum - 1) . ")")->getStyle('AI' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('AK' . $rownum, "=SUM(AK2:AK" . ($rownum - 1) . ")")->getStyle('AK' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('AM' . $rownum, "=SUM(AM2:AM" . ($rownum - 1) . ")")->getStyle('AM' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('AO' . $rownum, "=SUM(AO2:AO" . ($rownum - 1) . ")")->getStyle('AO' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);

        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A2');


        $filename = $tp_nm . '_Portflio_Report_As@_' . $asdt . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }
// END PORTFOLIO
//
// START EXCEL DEBTOR FROM INVESTMENT
    public function debtorinvestment($brn, $ofc, $cen, $prtp, $frdt, $todt, $frag, $toag)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_dbt_insv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Debtor from Investment Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['ofcr'] = $ofc;
        $_POST['cen'] = $cen;
        $_POST['prtp'] = $prtp;

        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;
        $_POST['frag'] = $frag;
        $_POST['toag'] = $toag;

        $result = $this->Report_model->dbtInvst_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();

        // END GET LOAD DATA


        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Debtor From Investment Reports')
            ->setKeywords('Debtor From Investment Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Debtor From Investment Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:AP1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(10);
        $activeSheet->getColumnDimension('E')->setWidth(25);
        $activeSheet->getColumnDimension('F')->setWidth(15);
        $activeSheet->getColumnDimension('G')->setWidth(25);
        $activeSheet->getColumnDimension('H')->setWidth(15);
        $activeSheet->getColumnDimension('I')->setWidth(15);
        $activeSheet->getColumnDimension('J')->setWidth(15);
        $activeSheet->getColumnDimension('K')->setWidth(15);
        $activeSheet->getColumnDimension('L')->setWidth(15);
        $activeSheet->getColumnDimension('M')->setWidth(15);
        $activeSheet->getColumnDimension('N')->setWidth(15);
        $activeSheet->getColumnDimension('O')->setWidth(15);

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));


        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "CENTER")
            ->setCellValue('C1', "OFFICER")
            ->setCellValue('D1', "PRDS")
            ->setCellValue('E1', "CUSTOMER")
            ->setCellValue('F1', "CUST NO")
            ->setCellValue('G1', "LOAN NO")
            ->setCellValue('H1', "START")
            ->setCellValue('I1', "LOAN AMT")
            ->setCellValue('J1', "ARREARS")
            ->setCellValue('K1', "AGE")
            ->setCellValue('L1', "LAST PAY DATE")
            ->setCellValue('M1', "LAST PAID AMT")
            ->setCellValue('N1', "CAP BAL")
            ->setCellValue('O1', "INT BAL");

        $activeSheet->getStyle('A1:O1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:O1')->applyFromArray($styleArray1);


        $col = 'O';
        $rownum = 2;
        // read data to active sheet
        foreach ($dataValue as $value) {
            $col = 'A';
            $activeSheet->setCellValue($col++ . $rownum, $value ["brcd"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cnnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["usnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["prcd"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["init"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cuno"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["acno"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cvdt"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["loam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["arres"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cage"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["lspd"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["lspa"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boc"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boi"]);

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $activeSheet->getStyle('I1:I' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('J1:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('M1:M' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('N1:N' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('O1:O' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');


        $activeSheet->SetCellValue('I' . $rownum, "=SUM(I2:I" . ($rownum - 1) . ")")->getStyle('I' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J2:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('M' . $rownum, "=SUM(M2:M" . ($rownum - 1) . ")")->getStyle('M' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('N' . $rownum, "=SUM(N2:N" . ($rownum - 1) . ")")->getStyle('N' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('O' . $rownum, "=SUM(O2:O" . ($rownum - 1) . ")")->getStyle('O' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);


        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A2');


        $filename = 'Debtor From Investment Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }

// END DEBTOR FROM INVESTMENT
//
// START EXCEL DEBTOR PORTFOLIO
    public function debtorPortfo($brn, $ofcr, $cen, $prtp)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_dbt_port');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Debtor As Portfolio Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['prtp'] = $prtp;
        $_POST['ofcr'] = $ofcr;
        $_POST['cen'] = $cen;

        $result = $this->Report_model->dbtPort_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();

        // END GET LOAD DATA


        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Debtor As Portfolio Reports')
            ->setKeywords('Debtor As Portfolio Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Debtor As Portfolio Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:Y1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(10);
        $activeSheet->getColumnDimension('E')->setWidth(25);
        $activeSheet->getColumnDimension('F')->setWidth(15);
        $activeSheet->getColumnDimension('G')->setWidth(13);
        $activeSheet->getColumnDimension('H')->setWidth(25);
        $activeSheet->getColumnDimension('I')->setWidth(10);
        foreach (range('J', 'L') as $cid1) {
            $activeSheet->getColumnDimension($cid1)->setWidth(15);
        }
        $activeSheet->getColumnDimension('M')->setWidth(10);
        foreach (range('N', 'T') as $cid2) {
            $activeSheet->getColumnDimension($cid2)->setWidth(15);
        }
        $activeSheet->getColumnDimension('U')->setWidth(10);
        foreach (range('V', 'Y') as $cid3) {
            $activeSheet->getColumnDimension($cid3)->setWidth(15);
        }

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));

        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "CENTER")
            ->setCellValue('C1', "OFFICER")
            ->setCellValue('D1', "PRDT")
            ->setCellValue('E1', "CUSTOMER")
            ->setCellValue('F1', "CUSTOMER NO")
            ->setCellValue('G1', "NIC")
            ->setCellValue('H1', "LOAN NO")
            ->setCellValue('I1', "Index")
            ->setCellValue('J1', "LOAN\nAMOUNT")
            ->setCellValue('K1', "INT")
            ->setCellValue('L1', "RENTAL")
            ->setCellValue('M1', "TENEER")
            ->setCellValue('N1', "BAL CAP")
            ->setCellValue('O1', "BAL INT")
            ->setCellValue('P1', "ARR CAP")
            ->setCellValue('Q1', "ARR INT")
            ->setCellValue('R1', "PENALTY")
            ->setCellValue('S1', "TOTAL PAID")
            ->setCellValue('T1', "OVER PYMT")
            ->setCellValue('U1', "AGE")
            ->setCellValue('V1', "LAST PAY\nDATE")
            ->setCellValue('W1', "PAID\nAMOUNT")
            ->setCellValue('X1', "START\nDATE")
            ->setCellValue('Y1', "MATUARITY\n DATE");

        //->setCellValue('AD1', "EXEC ");
        $activeSheet->getStyle('A1:Y1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:Y1')->applyFromArray($styleArray1);


        $col = 'O';
        $rownum = 2;
        foreach ($dataValue as $value) {
            $col = 'A';
            $activeSheet->setCellValue($col++ . $rownum, $value ["brnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cnnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["usnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["prcd"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["init"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cuno"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["anic"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["acno"]); // loan index

            $activeSheet->setCellValue($col++ . $rownum, $value ["lcnt"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["loam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["inta"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["inam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["noin"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["boc"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boi"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["aboc"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["aboi"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["avpe"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["ttpym"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["avcr"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cage"]);

            $activeSheet->setCellValue($col++ . $rownum, date('n/d/Y', strtotime($value ["lspd"])));
            $activeSheet->setCellValue($col++ . $rownum, $value ["lspa"]);
            $activeSheet->setCellValue($col++ . $rownum, date('n/d/Y', strtotime($value ["cvdt"])));
            $activeSheet->setCellValue($col++ . $rownum, date('n/d/Y', strtotime($value ["madt"])));

            $rownum++;
        }
        // read data to active sheet

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('P2:P' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('Q2:Q' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('R2:R' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('S2:S' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('T2:T' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('U2:U' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('V2:V' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('W2:W' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('X2:X' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('Y2:Y' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('Z2:Z' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $activeSheet->getStyle('J1:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('K1:K' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('L1:L' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('N1:N' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('O1:O' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('P1:P' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('Q1:Q' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('R1:R' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('S1:S' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('T1:T' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('W1:W' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');

        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J2:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('K' . $rownum, "=SUM(K2:K" . ($rownum - 1) . ")")->getStyle('K' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('L' . $rownum, "=SUM(L2:L" . ($rownum - 1) . ")")->getStyle('L' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('N' . $rownum, "=SUM(N2:N" . ($rownum - 1) . ")")->getStyle('N' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('O' . $rownum, "=SUM(O2:O" . ($rownum - 1) . ")")->getStyle('O' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('P' . $rownum, "=SUM(P2:P" . ($rownum - 1) . ")")->getStyle('P' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('Q' . $rownum, "=SUM(Q2:Q" . ($rownum - 1) . ")")->getStyle('Q' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('R' . $rownum, "=SUM(R2:R" . ($rownum - 1) . ")")->getStyle('R' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('S' . $rownum, "=SUM(S2:S" . ($rownum - 1) . ")")->getStyle('S' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('T' . $rownum, "=SUM(T2:T" . ($rownum - 1) . ")")->getStyle('T' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('W' . $rownum, "=SUM(W2:W" . ($rownum - 1) . ")")->getStyle('W' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);


        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A2');

        $filename = 'Debtor As Portfolio Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }

// END DEBTOR PORTFOLIO
//
// START EXCEL NOT PAID
    public function notpaid($brn, $ofc, $cen, $prtp, $frdt, $todt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_notpaid');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Notpaid Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $ofc;
        $_POST['cnt'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;

        $result = $this->Report_model->notPaid_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();

        // END GET LOAD DATA

        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Not Paid Reports')
            ->setKeywords('Not Paid Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Not Paid Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:AP1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(25);
        $activeSheet->getColumnDimension('E')->setWidth(15);
        $activeSheet->getColumnDimension('F')->setWidth(15);
        $activeSheet->getColumnDimension('G')->setWidth(25);
        $activeSheet->getColumnDimension('H')->setWidth(15);
        $activeSheet->getColumnDimension('I')->setWidth(15);
        $activeSheet->getColumnDimension('J')->setWidth(15);
        $activeSheet->getColumnDimension('K')->setWidth(15);
        $activeSheet->getColumnDimension('L')->setWidth(15);
        $activeSheet->getColumnDimension('M')->setWidth(15);
        $activeSheet->getColumnDimension('N')->setWidth(15);
        $activeSheet->getColumnDimension('O')->setWidth(15);

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));


        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "CENTER")
            ->setCellValue('C1', "OFFICER")
            ->setCellValue('D1', "CUSTOMER")
            ->setCellValue('E1', "CUST NO")
            ->setCellValue('F1', "NIC")
            ->setCellValue('G1', "LOAN NO")
            ->setCellValue('H1', "RENTAL")
            ->setCellValue('I1', "SHED DATE")
            ->setCellValue('J1', "ARREARS")
            ->setCellValue('K1', "AGE")
            ->setCellValue('L1', "LAST PAY DATE")
            ->setCellValue('M1', "LAST PAID AMT")
            ->setCellValue('N1', "TOTAL PAID")
            ->setCellValue('O1', "STATUS");

        $activeSheet->getStyle('A1:O1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:O1')->applyFromArray($styleArray1);


        $col = 'O';
        $rownum = 2;
        // read data to active sheet
        foreach ($dataValue as $value) {
            $col = 'A';

            if ($value ["cage"] < 0) {
                $st = " Over pay  ";
            } else if ($value ["cage"] == 0) {
                $st = " Normal  ";
            } else if ($value ["cage"] > 0) {
                $st = " Arrears  ";
            }

            $activeSheet->setCellValue($col++ . $rownum, $value ["brnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cnnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["usnm"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["init"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cuno"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["anic"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["acno"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["inam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["nxdd"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["arres"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cage"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["lspd"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["lspa"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ttpy"]);
            $activeSheet->setCellValue($col++ . $rownum, $st);

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


        $activeSheet->getStyle('H1:H' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('J1:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('M1:M' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('N1:N' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');

        $activeSheet->SetCellValue('H' . $rownum, "=SUM(H2:H" . ($rownum - 1) . ")")->getStyle('H' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J2:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('M' . $rownum, "=SUM(M2:M" . ($rownum - 1) . ")")->getStyle('M' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('N' . $rownum, "=SUM(N2:N" . ($rownum - 1) . ")")->getStyle('N' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);

        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A2');


        $filename = 'Not Paid Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }
// END NOT PAID
//
// START EXCEL DEBTOR AGE
    public function debtorage($brn, $ofc, $cen, $prtp, $asdt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_dbt_age');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Debtor Age Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['ofcr'] = $ofc;
        $_POST['cen'] = $cen;
        $_POST['prtp'] = $prtp;
        $_POST['asdt'] = $asdt;

        $result = $this->Report_model->dbtAge_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();

        // END GET LOAD DATA

        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Debtor Age Reports')
            ->setKeywords('Debtor Age Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Debtor Age Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:AD1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(25);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(10);
        $activeSheet->getColumnDimension('E')->setWidth(15);
        $activeSheet->getColumnDimension('F')->setWidth(15);
        foreach (range('G', 'Z') as $cid1) {
            $activeSheet->getColumnDimension($cid1)->setWidth(10);
        }
        foreach (range('AA', 'AD') as $cid2) {
            $activeSheet->getColumnDimension($cid2)->setWidth(10);
        }

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));

        // CELL MERGIN
        $activeSheet->mergeCells('A1:A2');
        $activeSheet->mergeCells('B1:B2');
        $activeSheet->mergeCells('C1:C2');
        $activeSheet->mergeCells('D1:D2');
        $activeSheet->mergeCells('E1:E2');
        $activeSheet->mergeCells('F1:F2');

        $activeSheet->mergeCells('G1:I1');
        $activeSheet->mergeCells('J1:L1');
        $activeSheet->mergeCells('M1:O1');
        $activeSheet->mergeCells('P1:R1');
        $activeSheet->mergeCells('S1:U1');
        $activeSheet->mergeCells('V1:X1');
        $activeSheet->mergeCells('Y1:AA1');
        $activeSheet->mergeCells('AB1:AD1');
        // END CELL MERGIN

        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "CENTER")
            ->setCellValue('C1', "OFFICER")
            ->setCellValue('D1', "PRDT")
            ->setCellValue('E1', "TTL DEBT")
            ->setCellValue('F1', "TTL DEBT %")
            ->setCellValue('G1', "AGE < 0")
            ->setCellValue('G2', "SUM")
            ->setCellValue('H2', "ARR CAP")
            ->setCellValue('I2', "CAP + INT")
            ->setCellValue('J1', "0 - 1")
            ->setCellValue('J2', "SUM")
            ->setCellValue('K2', "ARR CAP")
            ->setCellValue('L2', "CAP + INT")
            ->setCellValue('M1', "1 - 2")
            ->setCellValue('M2', "SUM")
            ->setCellValue('N2', "ARR CAP")
            ->setCellValue('O2', "CAP + INT")
            ->setCellValue('P1', "2 - 3")
            ->setCellValue('P2', "SUM")
            ->setCellValue('Q2', "ARR CAP")
            ->setCellValue('R2', "CAP + INT")
            ->setCellValue('S1', "3 - 4")
            ->setCellValue('S2', "SUM")
            ->setCellValue('T2', "ARR CAP")
            ->setCellValue('U2', "CAP + INT")
            ->setCellValue('V1', "4 - 5")
            ->setCellValue('V2', "SUM")
            ->setCellValue('W2', "ARR CAP")
            ->setCellValue('X2', "CAP + INT")
            ->setCellValue('Y1', "5 - 6")
            ->setCellValue('Y2', "SUM")
            ->setCellValue('Z2', "ARR CAP")
            ->setCellValue('AA2', "CAP + INT")
            ->setCellValue('AB1', " AGE > 6")
            ->setCellValue('AB2', "SUM")
            ->setCellValue('AC2', "ARR CAP")
            ->setCellValue('AD2', "CAP + INT");

        $activeSheet->getStyle('A1:AD1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:AD1')->applyFromArray($styleArray1);
        $activeSheet->getStyle('A2:AD2')->getFont()->setBold(true);
        $activeSheet->getStyle('A2:AD2')->applyFromArray($styleArray1);


        $col = 'O';
        $rownum = 3;
        // read data to active sheet
        foreach ($dataValue as $value) {
            $col = 'A';

            $activeSheet->setCellValue($col++ . $rownum, $value ["brnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cnnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["usnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["prtp"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tt00"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tt0"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["c1"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta1"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tb1"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c2"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta2"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tb2"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c3"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta3"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tb3"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c4"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta4"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tb4"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c5"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta5"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tb5"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c6"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta6"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tb6"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c7"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta7"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tb7"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c8"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta8"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tb8"]);

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('P2:P' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('Q2:Q' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('R2:R' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('S2:S' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('T2:T' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('U2:U' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('V2:V' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('W2:W' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('X2:X' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('Y2:Y' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('Z2:Z' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AA2:AA' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AB2:AB' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('AC2:AC' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('AD2:AD' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $activeSheet->getStyle('E2:E' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('F2:F' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('H2:H' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('I2:I' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('K2:K' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('L2:L' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('N2:N' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('O2:O' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('Q2:Q' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('R2:R' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('T2:T' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('U2:U' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('W2:W' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('X2:X' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('Z2:Z' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AA2:AA' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AC2:AC' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('AD2:AD' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');


        $activeSheet->SetCellValue('E' . $rownum, "=SUM(E3:E" . ($rownum - 1) . ")")->getStyle('E' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('F' . $rownum, "=SUM(F3:F" . ($rownum - 1) . ")")->getStyle('F' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('H' . $rownum, "=SUM(H3:H" . ($rownum - 1) . ")")->getStyle('H' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('I' . $rownum, "=SUM(I3:I" . ($rownum - 1) . ")")->getStyle('I' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('K' . $rownum, "=SUM(K3:K" . ($rownum - 1) . ")")->getStyle('K' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('L' . $rownum, "=SUM(L3:L" . ($rownum - 1) . ")")->getStyle('L' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('N' . $rownum, "=SUM(N3:N" . ($rownum - 1) . ")")->getStyle('N' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('O' . $rownum, "=SUM(O3:O" . ($rownum - 1) . ")")->getStyle('O' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('Q' . $rownum, "=SUM(Q3:Q" . ($rownum - 1) . ")")->getStyle('Q' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('R' . $rownum, "=SUM(R3:R" . ($rownum - 1) . ")")->getStyle('R' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('T' . $rownum, "=SUM(T3:T" . ($rownum - 1) . ")")->getStyle('T' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('U' . $rownum, "=SUM(U3:U" . ($rownum - 1) . ")")->getStyle('U' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('W' . $rownum, "=SUM(W3:W" . ($rownum - 1) . ")")->getStyle('W' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('X' . $rownum, "=SUM(X3:X" . ($rownum - 1) . ")")->getStyle('X' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('Z' . $rownum, "=SUM(Z3:Z" . ($rownum - 1) . ")")->getStyle('Z' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('AA' . $rownum, "=SUM(AA3:AA" . ($rownum - 1) . ")")->getStyle('AA' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('AC' . $rownum, "=SUM(AC3:AC" . ($rownum - 1) . ")")->getStyle('AC' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('AD' . $rownum, "=SUM(AD3:AD" . ($rownum - 1) . ")")->getStyle('AD' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);

        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A3');

        $filename = 'Debtor Age Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }
// END DEBTOR AGE
//
// START EXCEL PROVISION SUMMERY
    public function provisionSummery($brn, $prtp)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_prvis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Provision Summery Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['prtp'] = $prtp;

        $result = $this->Report_model->provis_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();

        // END GET LOAD DATA

        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Provision Summery Reports')
            ->setKeywords('Provision Summery Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Provision Summery Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:AD1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(20);
        $activeSheet->getColumnDimension('B')->setWidth(10);
        foreach (range('C', 'K') as $cid1) {
            $activeSheet->getColumnDimension($cid1)->setWidth(10);
        }
        foreach (range('L', 'P') as $cid1) {
            $activeSheet->getColumnDimension($cid1)->setWidth(15);
        }
        $activeSheet->getColumnDimension('Q')->setWidth(10);

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));

        // CELL MERGIN
        $activeSheet->mergeCells('A1:A2');
        $activeSheet->mergeCells('B1:B2');
        $activeSheet->mergeCells('M1:M2');
        $activeSheet->mergeCells('N1:N2');
        $activeSheet->mergeCells('O1:O2');
        $activeSheet->mergeCells('P1:P2');
        $activeSheet->mergeCells('Q1:Q2');

        $activeSheet->mergeCells('C1:D1');
        $activeSheet->mergeCells('E1:F1');
        $activeSheet->mergeCells('G1:H1');
        $activeSheet->mergeCells('I1:J1');
        $activeSheet->mergeCells('K1:L1');
        // END CELL MERGIN

        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "PRDT")
            ->setCellValue('C1', "AGE 3-6")
            ->setCellValue('C2', "COUNT")
            ->setCellValue('D2', "SUM")
            ->setCellValue('E1', "AGE 6-10")
            ->setCellValue('E2', "COUNT")
            ->setCellValue('F2', "SUM")
            ->setCellValue('G1', "AGE 12-24")
            ->setCellValue('G2', "COUNT")
            ->setCellValue('H2', "SUM")
            ->setCellValue('I1', "AGE OVER 24")
            ->setCellValue('I2', "COUNT")
            ->setCellValue('J2', "SUM")
            ->setCellValue('K1', "TOTAL PROV")
            ->setCellValue('K2', "COUNT")
            ->setCellValue('L2', "SUM")
            ->setCellValue('M1', "STOCK")
            ->setCellValue('N1', "PROV TRGT")
            ->setCellValue('O1', "FUT \n FORCAST")
            ->setCellValue('P1', "PORTFOLIO")
            ->setCellValue('Q1', "%");

        $activeSheet->getStyle('A1:Q1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:Q1')->applyFromArray($styleArray1);
        $activeSheet->getStyle('A2:Q2')->getFont()->setBold(true);
        $activeSheet->getStyle('A2:Q2')->applyFromArray($styleArray1);

        $col = 'O';
        $rownum = 3;
        // read data to active sheet
        foreach ($dataValue as $value) {
            $col = 'A';
            $ttlsum = $value ["ta1"] + $value ["ta2"] + $value ["ta3"] + $value ["ta4"];

            $activeSheet->setCellValue($col++ . $rownum, $value ["brnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["prtp"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["c1"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta1"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c2"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta2"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["c3"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta3"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["c4"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ta4"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["tt1"]);
            $activeSheet->setCellValue($col++ . $rownum, $ttlsum); //$row->ta1 + $row->ta2 + $row->ta3 + $row->ta4
            $activeSheet->setCellValue($col++ . $rownum, $value ["stck"]);
            $activeSheet->setCellValue($col++ . $rownum, '-');
            $activeSheet->setCellValue($col++ . $rownum, '-');
            $activeSheet->setCellValue($col++ . $rownum, $value ["port"]);
            $activeSheet->setCellValue($col++ . $rownum, ($ttlsum / $value ["port"]) * 100); //round(($ttlsum / $row->port) * 100, 2)

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('P2:P' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('Q2:Q' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $activeSheet->getStyle('D2:D' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('F2:F' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('H2:H' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('J2:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('L2:L' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('M2:M' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('N2:N' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('O2:O' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('P2:P' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');


        $activeSheet->SetCellValue('C' . $rownum, "=SUM(C3:C" . ($rownum - 1) . ")")->getStyle('C' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('D' . $rownum, "=SUM(D3:D" . ($rownum - 1) . ")")->getStyle('D' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('E' . $rownum, "=SUM(E3:E" . ($rownum - 1) . ")")->getStyle('E' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('F' . $rownum, "=SUM(F3:F" . ($rownum - 1) . ")")->getStyle('F' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('G' . $rownum, "=SUM(G3:G" . ($rownum - 1) . ")")->getStyle('G' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('H' . $rownum, "=SUM(H3:H" . ($rownum - 1) . ")")->getStyle('H' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('I' . $rownum, "=SUM(I3:I" . ($rownum - 1) . ")")->getStyle('I' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J3:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('K' . $rownum, "=SUM(K3:K" . ($rownum - 1) . ")")->getStyle('K' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('L' . $rownum, "=SUM(L3:L" . ($rownum - 1) . ")")->getStyle('L' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('M' . $rownum, "=SUM(M3:M" . ($rownum - 1) . ")")->getStyle('M' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('N' . $rownum, "=SUM(N3:N" . ($rownum - 1) . ")")->getStyle('N' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('O' . $rownum, "=SUM(O3:O" . ($rownum - 1) . ")")->getStyle('O' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('P' . $rownum, "=SUM(P3:P" . ($rownum - 1) . ")")->getStyle('P' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('Q' . $rownum, "=SUM(Q3:Q" . ($rownum - 1) . ")")->getStyle('Q' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);


        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A3');

        $filename = 'Provision Summery Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }
// END PROVISION SUMMERY
//
// START EXCEL PROVISION SUMMERY
    public function incomeDetails($brn, $frdt, $todt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_incom');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Income Details Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;

        $result = $this->Report_model->incom_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();

        // END GET LOAD DATA

        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Income Details Reports')
            ->setKeywords('Income Details Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Income Details Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:AD1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(20);
        foreach (range('B', 'S') as $cid1) {
            $activeSheet->getColumnDimension($cid1)->setWidth(15);
        }

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));

        // CELL MERGIN
        $activeSheet->mergeCells('A1:A2');
        $activeSheet->mergeCells('P1:P2');
        $activeSheet->mergeCells('Q1:Q2');
        $activeSheet->mergeCells('R1:R2');
        $activeSheet->mergeCells('S1:S2');


        $activeSheet->mergeCells('B1:D1');
        $activeSheet->mergeCells('E1:F1');
        $activeSheet->mergeCells('G1:H1');
        $activeSheet->mergeCells('I1:J1');
        $activeSheet->mergeCells('K1:L1');
        $activeSheet->mergeCells('M1:N1');
        $activeSheet->mergeCells('O1:P1');
        // END CELL MERGIN

        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "LOAN AS PORTFOLIO")
            ->setCellValue('B2', "CURRENT")
            ->setCellValue('C2', "FINISHED")
            ->setCellValue('D2', "TERMINATED")
            ->setCellValue('E1', "INVESTMENT")
            ->setCellValue('E2', "CUMILATIVE")
            ->setCellValue('F2', "MONTHLY")
            ->setCellValue('G1', "SHOULD COLLECTED")
            ->setCellValue('G2', "CAP")
            ->setCellValue('H2', "INT")
            ->setCellValue('I1', "INCOME")
            ->setCellValue('I2', "CAP")
            ->setCellValue('J2', "INT")
            ->setCellValue('K1', "FUTURE INCOME	")
            ->setCellValue('K2', "BAL CAP")
            ->setCellValue('L2', "BAL INT")
            ->setCellValue('M1', "DEBTOR")
            ->setCellValue('M2', "DUE CAP")
            ->setCellValue('N2', "DUE INT")
            ->setCellValue('O1', "DOC / INSU FEE")
            ->setCellValue('O2', "DOC")
            ->setCellValue('P2', "NSU")
            ->setCellValue('Q1', "PENTY RECVD")
            ->setCellValue('R1', "TARGET")
            ->setCellValue('S1', "ACHIV %");

        $activeSheet->getStyle('A1:S1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:S1')->applyFromArray($styleArray1);
        $activeSheet->getStyle('A2:S2')->getFont()->setBold(true);
        $activeSheet->getStyle('A2:S2')->applyFromArray($styleArray1);

        $col = 'O';
        $rownum = 3;
        // read data to active sheet
        foreach ($dataValue as $value) {
            $col = 'A';
            $activeSheet->setCellValue($col++ . $rownum, $value ["brnm"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["tt1"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tt2"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tt3"]);

            $activeSheet->setCellValue($col++ . $rownum, '-');
            $activeSheet->setCellValue($col++ . $rownum, $value ["inmt"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["rncp"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["rnin"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["avcp"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["avin"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["boc"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boi"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["aboc"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["aboi"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["dcg"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["icg"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["dpet"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["dpet"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["dpet"]);

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('P2:P' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('Q2:Q' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('R2:R' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('S2:S' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $activeSheet->getStyle('B2:B' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('C2:C' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('D2:D' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('E2:E' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('F2:F' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('G2:G' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('H2:H' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('I2:I' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('J2:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('K2:K' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('L2:L' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('M2:M' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('N2:N' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('O2:O' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('P2:P' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('Q2:Q' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('R2:R' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');


        $activeSheet->SetCellValue('B' . $rownum, "=SUM(B3:B" . ($rownum - 1) . ")")->getStyle('B' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('C' . $rownum, "=SUM(C3:C" . ($rownum - 1) . ")")->getStyle('C' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('D' . $rownum, "=SUM(D3:D" . ($rownum - 1) . ")")->getStyle('D' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('E' . $rownum, "=SUM(E3:E" . ($rownum - 1) . ")")->getStyle('E' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('F' . $rownum, "=SUM(F3:F" . ($rownum - 1) . ")")->getStyle('F' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('G' . $rownum, "=SUM(G3:G" . ($rownum - 1) . ")")->getStyle('G' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('H' . $rownum, "=SUM(H3:H" . ($rownum - 1) . ")")->getStyle('H' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('I' . $rownum, "=SUM(I3:I" . ($rownum - 1) . ")")->getStyle('I' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J3:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('K' . $rownum, "=SUM(K3:K" . ($rownum - 1) . ")")->getStyle('K' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('L' . $rownum, "=SUM(L3:L" . ($rownum - 1) . ")")->getStyle('L' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('M' . $rownum, "=SUM(M3:M" . ($rownum - 1) . ")")->getStyle('M' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('N' . $rownum, "=SUM(N3:N" . ($rownum - 1) . ")")->getStyle('N' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('O' . $rownum, "=SUM(O3:O" . ($rownum - 1) . ")")->getStyle('O' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('P' . $rownum, "=SUM(P3:P" . ($rownum - 1) . ")")->getStyle('P' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('Q' . $rownum, "=SUM(Q3:Q" . ($rownum - 1) . ")")->getStyle('Q' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('R' . $rownum, "=SUM(R3:R" . ($rownum - 1) . ")")->getStyle('R' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('S' . $rownum, "=SUM(S3:S" . ($rownum - 1) . ")")->getStyle('S' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);


        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A3');

        $filename = 'Income Details Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }
// END PROVISION SUMMERY
//
// START EXCEL INVEST & BUDGET
    public function investNbuget($brn, $exc, $prtp, $prdt, $frdt, $todt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_invs');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Investment & Budget Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['exc'] = $exc;
        $_POST['prtp'] = $prtp;
        $_POST['prdt'] = $prdt;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;

        $result = $this->Report_model->inverst_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();
        // END GET LOAD DATA

        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Investment & Budget Reports')
            ->setKeywords('Investment & Budget Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Investment & Budget Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(25);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(15);
        $activeSheet->getColumnDimension('E')->setWidth(15);
        $activeSheet->getColumnDimension('F')->setWidth(15);

        $activeSheet->getColumnDimension('G')->setWidth(15);
        $activeSheet->getColumnDimension('H')->setWidth(15);

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));

        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "OFFICER")
            ->setCellValue('C1', "PRODUCT TYPE ")
            ->setCellValue('D1', "PRODUCT")
            ->setCellValue('E1', "BUDG AMOUNT")
            ->setCellValue('F1', "ACTIV AMOUNT")
            ->setCellValue('G1', "ACTIV AMOUNT % ")
            ->setCellValue('H1', "PENDING AMOUNT");


        $activeSheet->getStyle('A1:HL1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:H1')->applyFromArray($styleArray1);

        $col = 'O';
        $rownum = 2;
        // read data to active sheet
        foreach ($dataValue as $value) {
            $col = 'A';
            $activeSheet->setCellValue($col++ . $rownum, $value ["brnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["exe"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["prtp"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["prnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tt1"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tt2"]);

            $activeSheet->setCellValue($col++ . $rownum, ($value ["tt1"] > 0) ? round(($value ["tt2"] / $value ["tt1"]) * 100, 2) : 0);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tt3"]);

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $activeSheet->getStyle('E1:E' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('F1:F' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('H1:H' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');


        $activeSheet->SetCellValue('E' . $rownum, "=SUM(E2:E" . ($rownum - 1) . ")")->getStyle('E' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('F' . $rownum, "=SUM(F2:F" . ($rownum - 1) . ")")->getStyle('F' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('H' . $rownum, "=SUM(H2:H" . ($rownum - 1) . ")")->getStyle('H' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);

        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A2');


        $filename = 'Investment & Budget.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }
// END INVEST & BUDGET
//
// START EXCEL DEPLETION
    public function depletion($brn, $exc, $prtp, $frdt, $todt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_dplt');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Depletion Report');

        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['ofcr'] = $exc;
        $_POST['prtp'] = $prtp;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;

        $result = $this->Report_model->deplt_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();
        // END GET LOAD DATA

        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Depletion Reports')
            ->setKeywords('Depletion Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);

        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Depletion Report');

        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');


        $activeSheet->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(25);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        foreach (range('D', 'O') as $cid1) {
            $activeSheet->getColumnDimension($cid1)->setWidth(15);
        }

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));


        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "OFFICER")
            ->setCellValue('C1', "PRODUCT")
            ->setCellValue('D1', "OPENING STOCK")
            ->setCellValue('E1', "PRODUCT INVESTMENT")
            ->setCellValue('F1', "NORMAL DEPLETION")
            ->setCellValue('G1', "YEAR OPEN STOCK % ")
            ->setCellValue('H1', date('Y') . " YEAR EARLY SET.DEP")
            ->setCellValue('I1', "MONTH OPEN STOCK % EARLY")
            ->setCellValue('J1', "TOTAL DEPLETION")
            ->setCellValue('K1', "CLOSING STOCK")
            ->setCellValue('L1', "OFFICER NORMAL INCOME")
            ->setCellValue('M1', "EARLY SET INCOME")
            ->setCellValue('N1', "TOTAL INCOME")
            ->setCellValue('O1', "PORTFOLIO");


        $activeSheet->getStyle('A1:O1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:O1')->applyFromArray($styleArray1);

        $col = 'O';
        $rownum = 2;
        // read data to active sheet
        foreach ($dataValue as $value) {

            if($value['boc'] > 0 && $value['s3'] > 0){
                $aa = ($value['s3']/$value['boc'])*100;
            } else {
                $aa = 0;
            }

            if($value['s4'] > 0 && $value['s5'] > 0){
                $ab = ($value['s5']/$value['s4'])*100;
            } else {
                $ab = 0;
            }

            $col = 'A';
            $activeSheet->setCellValue($col++ . $rownum, $value ["brnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["ofer"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["prcd"]);

            $activeSheet->setCellValue($col++ . $rownum, $value ["s1"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["s2"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boc"]);
            $activeSheet->setCellValue($col++ . $rownum, $aa);
            $activeSheet->setCellValue($col++ . $rownum, $value ["s4"]);
            $activeSheet->setCellValue($col++ . $rownum, $ab);

            $activeSheet->setCellValue($col++ . $rownum, $value ["boc"] + $value ["s4"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["s6"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["s7"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boi"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tta"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["tpr"]);

            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $activeSheet->getStyle('D1:D' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('E1:E' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('F1:F' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('G1:G' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('H1:H' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('I1:I' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('J1:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('K1:K' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('L1:L' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('M1:M' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('N1:N' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('O1:O' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');


        $activeSheet->SetCellValue('D' . $rownum, "=SUM(D2:D" . ($rownum - 1) . ")")->getStyle('D' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('E' . $rownum, "=SUM(E2:E" . ($rownum - 1) . ")")->getStyle('E' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('F' . $rownum, "=SUM(F2:F" . ($rownum - 1) . ")")->getStyle('F' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('H' . $rownum, "=SUM(H2:H" . ($rownum - 1) . ")")->getStyle('H' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J2:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('K' . $rownum, "=SUM(K2:K" . ($rownum - 1) . ")")->getStyle('K' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('L' . $rownum, "=SUM(L2:L" . ($rownum - 1) . ")")->getStyle('L' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('M' . $rownum, "=SUM(M2:M" . ($rownum - 1) . ")")->getStyle('M' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('N' . $rownum, "=SUM(N2:N" . ($rownum - 1) . ")")->getStyle('N' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('O' . $rownum, "=SUM(O2:O" . ($rownum - 1) . ")")->getStyle('O' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);

        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A2');


        $filename = 'Depletion.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }

// END DEPLETION
//
// START EXCEL  LOAN REPORT
    public function loanreport($brn, $ofc, $cnt,$frdt,$todt,$stat,$prdt)
    {
        $funcPerm = $this->Generic_model->getFuncPermision('rpt_loan');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Export Loan Report Excel');
        // GET LOAD DATA
        $_POST['brn'] = $brn;
        $_POST['ofc'] = $ofc;
        $_POST['cnt'] = $cnt;
        $_POST['frdt'] = $frdt;
        $_POST['todt'] = $todt;
        $_POST['stat'] = $stat;
        $_POST['prdt'] = $prdt;
        $result = $this->Report_model->loan_query();
        $query = $this->db->get();
        $dataValue = $query->result_array();
        // END GET LOAD DATA
        $this->excel->getProperties()->setCreator('www.gdcreations.com')
            ->setLastModifiedBy('gdcreations')
            ->setTitle('Portfolio Reports')
            ->setKeywords('Portfolio Reports');
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getDefaultStyle()->getFont()->setName('Calibri');
        $this->excel->getDefaultStyle()->getFont()->setSize(11);
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle(' Loan Report');
        $activeSheet = $this->excel->getActiveSheet();

        $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
            ->setFitToWidth(1)
            ->setFitToHeight(50);

        $activeSheet->getHeaderFooter()->setOddHeader('&C&B&16' .
            $this->excel->getProperties()->getTitle())->setOddFooter('&CPage &P of &N');

        $activeSheet->getRowDimension('1')->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->getStyle('A1:P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(15);
        $activeSheet->getColumnDimension('D')->setWidth(25);
        $activeSheet->getColumnDimension('E')->setWidth(25);
        $activeSheet->getColumnDimension('F')->setWidth(10);
        $activeSheet->getColumnDimension('G')->setWidth(30);
        $activeSheet->getColumnDimension('H')->setWidth(15);
        $activeSheet->getColumnDimension('I')->setWidth(13);
        $activeSheet->getColumnDimension('J')->setWidth(15);
        $activeSheet->getColumnDimension('K')->setWidth(15);
        $activeSheet->getColumnDimension('L')->setWidth(15);
        $activeSheet->getColumnDimension('M')->setWidth(15);
        $activeSheet->getColumnDimension('N')->setWidth(15);
        $activeSheet->getColumnDimension('O')->setWidth(20);
        $activeSheet->getColumnDimension('P')->setWidth(15);

        //COLOUR THEM
        $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $styleArray2 = array('borders' => array(
            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE)
        ));


        $activeSheet->setCellValue('A1', "BRANCH")
            ->setCellValue('B1', "CENTER")
            ->setCellValue('C1', "OFFICER")
            ->setCellValue('D1', "PRODUCTS")
            ->setCellValue('E1', "LOAN NO")
            ->setCellValue('F1', "PERIOD")
            ->setCellValue('G1', "CUSTOMER")
            ->setCellValue('H1', "NIC")
            ->setCellValue('I1', "PHONE NO")
            ->setCellValue('J1', "LOAN AMOUNT")
            ->setCellValue('K1', "RENTAL")
            ->setCellValue('L1', "CAPITAL")
            ->setCellValue('M1', "INT")
            ->setCellValue('N1', "MODE")
            ->setCellValue('O1', "DISBUG DATE&TIME")
            ->setCellValue('P1', "APPROVAL BY");

        $activeSheet->getStyle('A1:P1')->getFont()->setBold(true);
        $activeSheet->getStyle('A1:P1')->applyFromArray($styleArray1);

        $col = 'O';
        $rownum = 2;
        // read data to active sheet
        foreach ($dataValue as $value) {

            $col = 'A';
            $activeSheet->setCellValue($col++ . $rownum, $value ["brnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cnnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["full"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["prnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["acno"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["lnpr"].' WEEK');
            $activeSheet->setCellValue($col++ . $rownum, $value ["init"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["anic"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["mobi"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["loam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["inam"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boc"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["boi"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["stnm"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["cvdt"]);
            $activeSheet->setCellValue($col++ . $rownum, $value ["usr"]);
            $rownum++;
        }

        $rownum = $rownum + 1;
        $activeSheet->getStyle('A2:A' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('B2:B' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('C2:C' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('D2:D' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('E2:E' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('F2:F' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('G2:G' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('H2:H' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('I2:I' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('J2:J' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('K2:K' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('L2:L' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('M2:M' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('N2:N' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('O2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $activeSheet->getStyle('P2:O' . $rownum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);



        $activeSheet->getStyle('J1:J' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('K1:K' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('L1:L' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');
        $activeSheet->getStyle('M1:M' . $rownum)->getNumberFormat()->setFormatCode('#,##0.00');


        $activeSheet->SetCellValue('J' . $rownum, "=SUM(J2:J" . ($rownum - 1) . ")")->getStyle('J' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('K' . $rownum, "=SUM(K2:K" . ($rownum - 1) . ")")->getStyle('K' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('L' . $rownum, "=SUM(L2:L" . ($rownum - 1) . ")")->getStyle('L' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);
        $activeSheet->SetCellValue('M' . $rownum, "=SUM(M2:M" . ($rownum - 1) . ")")->getStyle('M' . $rownum)->applyFromArray($styleArray2)->getFont()->setBold(true);


        $activeSheet->getRowDimension($rownum)->setRowHeight(27);//BOTTEM ROW HEIGHT
        $activeSheet->freezePane('A2');


        $filename = 'Loan_Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

    }
// END LOAN REPORT
}
