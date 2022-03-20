<?php

class Report_model extends CI_Model
{

    //makes this to work with columns and without where,limit and offset

// Arrears loan
    var $cl_srch17 = array('brnm', 'acno', 'cuno', 'init', 'loam', 'cage'); //set column field database for datatable searchable
    var $cl_odr17 = array(null, 'brnm', 'acno', 'cuno', 'init', 'loam', 'cage', '', '', ''); //set column field database for datatable orderable
    var $order17 = array('cage' => 'asc'); // default order

    function arrLn_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');

        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.noin,micr_crt.crdt,micr_crt.cvpt,micr_crt.agno,micr_crt.cage,
        micr_crt.aboc,micr_crt.aboi,cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg, cen_mas.cnnm ,brch_mas.brcd,user_mas.fnme  ");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
        $this->db->where('micr_crt.stat IN(2,5)');
        $this->db->where('micr_crt.rcst', 0);
        //$query = $this->db->get();
        //$result = $query->result();
    }

    private function arrLn_queryData()
    {
        $this->arrLn_query();
        $i = 0;
        foreach ($this->cl_srch17 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch17) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr17[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order17)) {
            $order17 = $this->order17;
            $this->db->order_by(key($order17), $order17[key($order17)]);
        }
    }

    function get_arrLn()
    {
        $this->arrLn_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_arrLn()
    {
        $this->arrLn_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_arrLn()
    {
        // $this->db->from($this->table);
        $this->arrLn_query();
        return $this->db->count_all_results();
    }
// end Arrears loan
//
// Recovery loan
    var $cl_srch18 = array('brnm', 'acno', 'cuno', 'init', 'loam', 'cage'); //set column field database for datatable searchable
    var $cl_odr18 = array(null, 'brnm', 'acno', 'cuno', 'init', 'loam', 'cage', '', '', ''); //set column field database for datatable orderable
    var $order18 = array('cage' => 'asc'); // default order

    function rcvryLn_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');

        $this->db->select("loan_recr.*, micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.cage,micr_crt.aboc,micr_crt.aboi,
        cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi, cen_mas.cnnm ,brch_mas.brcd,user_mas.fnme  ");
        $this->db->from("loan_recr");
        $this->db->join('micr_crt', 'micr_crt.lnid = loan_recr.lnid ');
        $this->db->join('cen_mas', 'cen_mas.caid = loan_recr.cntr ');
        $this->db->join('brch_mas', 'brch_mas.brid = loan_recr.brcd');
        $this->db->join('user_mas', 'user_mas.auid = loan_recr.user');

        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        if ($brn != 'all') {
            $this->db->where('loan_recr.brcd', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('loan_recr.user', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('loan_recr.cntr', $cen);
        }
        $this->db->where('loan_recr.stat IN(0,1)');

    }

    private function rcvryLn_queryData()
    {
        $this->rcvryLn_query();
        $i = 0;
        foreach ($this->cl_srch18 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch18) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr18[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order18)) {
            $order18 = $this->order18;
            $this->db->order_by(key($order18), $order18[key($order18)]);
        }
    }

    function get_rcvryLn()
    {
        $this->rcvryLn_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_rcvryLn()
    {
        $this->rcvryLn_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_rcvryLn()
    {
        // $this->db->from($this->table);
        $this->rcvryLn_query();
        return $this->db->count_all_results();
    }
// end Recovery loan
//
// RECEIPT
    var $cl_srch1 = array('brcd', 'cuno', 'init', 'reno', 'ramt'); //set column field database for datatable searchable
    var $cl_odr1 = array(null, 'brcd', 'cuno', 'init', 'reno', '', '', 'ramt', 'tem_name', '', '', ''); //set column field database for datatable orderable
    var $order1 = array('cage' => 'asc'); // default order

    function rceipt_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $rctp = $this->input->post('rctp');
        $rcst = $this->input->post('rcst');

        $this->db->select("receipt.* ,micr_crt.acno, brch_mas.brcd,user_mas.usnm ,cus_mas.init,cus_mas.cuno, pay_terms.tem_name, DATE_FORMAT(receipt.crdt, '%Y-%m-%d') AS crdt ");
        $this->db->from("receipt");
        $this->db->join('brch_mas', 'brch_mas.brid = receipt.brco');
        $this->db->join('user_mas', 'user_mas.auid = receipt.crby');
        $this->db->join('micr_crt', 'micr_crt.lnid = receipt.rfno', 'left');
        $this->db->join('cus_mas', 'micr_crt.apid = cus_mas.cuid');
        $this->db->join('pay_terms', 'pay_terms.tmid = receipt.pymd');
        if ($brn != 'all') {
            $this->db->where('receipt.brco', $brn);
        }
        if ($rctp != 'all') {
            $this->db->where('receipt.retp', $rctp);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
        if ($rcst != 'all') {
            $this->db->where('receipt.stat', $rcst);
        }

        $this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

    }

    private function rceipt_queryData()
    {
        $this->rceipt_query();
        $i = 0;
        foreach ($this->cl_srch1 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order1)) {
            $order1 = $this->order1;
            $this->db->order_by(key($order1), $order1[key($order1)]);
        }
    }

    function get_rceipt()
    {
        $this->rceipt_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_rceipt()
    {
        $this->rceipt_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_rceipt()
    {
        // $this->db->from($this->table);
        $this->rceipt_query();
        return $this->db->count_all_results();
    }
// END RECEIPT
//
// VOUCHERS
    var $cl_srch2 = array('vuno', 'pynm', 'cuno', 'vuam'); //set column field database for datatable searchable
    var $cl_odr2 = array(null, 'brcd', 'vuno', 'pynm', 'cuno', '', 'vuam', 'tohnd', 'crdt', 'usnm'); //set column field database for datatable orderable
    var $order2 = array('cage' => 'asc'); // default order

    function vouchers_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $vutp = $this->input->post('vutp');

        $this->db->select("voucher.* , brch_mas.brcd,user_mas.usnm ,cus_mas.init,cus_mas.cuno,aa.x AS tohnd ");
        $this->db->from("voucher");
        $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco');
        $this->db->join('user_mas', 'user_mas.auid = voucher.crby');
        $this->db->join('micr_crt', 'micr_crt.lnid = voucher.rfid', 'left');
        $this->db->join('cus_mas', 'cus_mas.cuid = voucher.clid', 'left');
        $this->db->join("(SELECT aa.vuid,SUM(aa.amut) AS x FROM vouc_des AS aa GROUP BY aa.vuid) AS aa", 'aa.vuid = voucher.void', 'left');

        if ($brn != 'all') {
            $this->db->where('voucher.brco', $brn);
        }
        if ($vutp != 'all') {
            $this->db->where('voucher.mode', $vutp);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
        $this->db->where("DATE_FORMAT(voucher.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

    }

    private function vouchers_queryData()
    {
        $this->vouchers_query();
        $i = 0;
        foreach ($this->cl_srch2 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch2) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order2)) {
            $order2 = $this->order2;
            $this->db->order_by(key($order2), $order2[key($order2)]);
        }
    }

    function get_vouchers()
    {
        $this->vouchers_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_vouchers()
    {
        $this->vouchers_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_vouchers()
    {
        $this->vouchers_query();
        return $this->db->count_all_results();
    }
// END VOUCHERS
//
// REPAYMENT SHEET
    var $cl_srch3 = array('cnnm', 'mobi', 'anic', 'cuno'); //set column field database for datatable searchable
    var $cl_odr3 = array(null, 'grno', 'grno', '', 'anic', '', '', '', '', 'cage'); //set column field database for datatable orderable
    var $order3 = array('' => ''); // default order

    function repymntsheet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $grp = $this->input->post('grp');
        $prd = $this->input->post('prd');

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

        $this->db->where('micr_crt.stat IN(5,18)');
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
        if ($prd != 'all') {
            $this->db->where('micr_crt.prdtp', $prd);
        }
    }

    private function repymntsheet_queryData()
    {
        $this->repymntsheet_query();
        $i = 0;
        foreach ($this->cl_srch3 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch3) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr3[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order3)) {
            $order3 = $this->order3;
            $this->db->order_by(key($order3), $order3[key($order3)]);
        }
    }

    function get_repymntsheet()
    {
        $this->repymntsheet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_repymnt()
    {
        $this->repymntsheet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_repymnt()
    {
        $this->repymntsheet_query();
        return $this->db->count_all_results();
    }
// END REPAYMENT SHEET
//
// TODAY ARREARS
    var $cl_srch4 = array('init', 'anic', 'loam'); //set column field database for datatable searchable
    var $cl_odr4 = array(null, 'brcd', 'init', 'anic', '', 'loam', 'baln', 'inam', 'arres', 'cage', ''); //set column field database for datatable orderable
    var $order4 = array('cage' => 'asc'); // default order

    function tdyArres_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $cndy = $this->input->post('cndy');
        $prtp = $this->input->post('prtp');

        $this->db->select("cus_mas.init,cus_mas.anic ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,user_mas.usnm ,cus_mas.init,cus_mas.cuno,
        (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres,  cen_mas.cnnm, micr_crt.lnid, cen_days.cday,
        ((micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe + micr_crt.boc + micr_crt.boi) - micr_crt.avcr ) AS baln,  IFNULL(micr_crt.cage,0) AS cage,
            ");
        $this->db->from("micr_crt");
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('cen_days', 'cen_days.dyid = cen_mas.cody');

        $this->db->where('micr_crt.stat IN(3,5)');

        if ($cndy != 'all') {
            $this->db->where('cen_mas.cody', $cndy);
        }
        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
        if ($prtp != 'all') {
            $this->db->where('micr_crt.prdtp', $prtp);
        }

    }

    private function tdyArres_queryData()
    {
        $this->tdyArres_query();
        $i = 0;
        foreach ($this->cl_srch4 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch4) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr4[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order4)) {
            $order4 = $this->order4;
            $this->db->order_by(key($order4), $order4[key($order4)]);
        }
    }

    function get_tdyArres()
    {
        $this->tdyArres_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_tdyArres()
    {
        $this->tdyArres_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_tdyArres()
    {
        $this->tdyArres_query();
        return $this->db->count_all_results();
    }
// END TODAY ARREARS
//
// NOT PAID
    var $cl_srch5 = array('brnm', 'micr_crt.acno',  'anic'); //set column field database for datatable searchable
    var $cl_odr5 = array(null, 'brnm', 'init', 'anic', 'acno', '', 'nxdd', '', '', '', '', ''); //set column field database for datatable orderable
    var $order5 = array('nxdd' => 'asc'); // default order

    function notPaid_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $prtp = $this->input->post('prtp');

        $this->db->select("cus_mas.init,cus_mas.anic ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,brch_mas.brnm,user_mas.usnm ,cus_mas.init,cus_mas.cuno,
        (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres,  cen_mas.cnnm, micr_crt.lnid,
        micr_crt.nxdd,micr_crt.lspd, IFNULL((SELECT sum(ramt) FROM `receipt` WHERE retp = 2 AND rfno = lnid ),0) AS ttpy,
        IFNULL(micr_crt.cage,0) AS cage, DATE_FORMAT(micr_crleg.ledt, '%Y-%m-%d') AS ledt ,
        IFNULL((SELECT ream FROM `micr_crleg` WHERE dsid = 2 AND acid = lnid ORDER BY ledt  DESC LIMIT 1),0) AS lspa,  ");
        $this->db->from("micr_crt");
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('micr_crleg', 'micr_crleg.acid = micr_crt.lnid');

        //$this->db->where('micr_crt.stat IN(5,18)');

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
        if ($prtp != 'all') {
            $this->db->where('micr_crt.prdtp', $prtp);
        }

        $this->db->where("DATE_FORMAT(micr_crleg.ledt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
        $this->db->where('micr_crleg.dsid', 3);

    }

    private function notPaid_queryData()
    {
        $this->notPaid_query();
        $i = 0;
        foreach ($this->cl_srch5 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch5) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr5[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order5)) {
            $order5 = $this->order5;
            $this->db->order_by(key($order5), $order5[key($order5)]);
        }
    }

    function get_notPaid()
    {
        $this->notPaid_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_notPaid()
    {
        $this->notPaid_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_notPaid()
    {
        // $this->db->from($this->table);
        $this->notPaid_query();
        return $this->db->count_all_results();
    }
// END NOT PAID
//
// LOAN SUMMERY - CENTER SUMMERY
    var $cl_srch6 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr6 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order6 = array('cage' => 'asc'); // default order

    function cntrsumry_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $prtp = $this->input->post('prtp');

        $today = date("Y-m-d");     //TODAY DATE

        if ($prtp == '3' || $prtp == '6') {             // DAILY
            $inteval = "INTERVAL 1 DAY";
        } elseif ($prtp == '4' || $prtp == '7') {       // WK
            $inteval = "INTERVAL 7 DAY";
        } elseif ($prtp == '5' || $prtp == '8') {       // ML
            $inteval = "INTERVAL 7 DAY";
        } else {
            $inteval = "INTERVAL 7 DAY";
        }

        /*$this->db->select(" `ld`.`auid`, `bd`.`branch_code`, `cd`.`center_name`, `pc`.`ctco`, `user`.`username` ,
         cgd.branch_details_branch_id,cgd.center_details_center_id,cd.center_exe,ld.type,pd.pd_category, ld.lnno,ld.auid,
        COUNT(*) AS cc0 ,COUNT(b.cc1) AS cc1, COUNT(c.cc2) AS cc2 ,COUNT(d.cc3) AS cc3, COUNT(e.cc4) AS cc4 ,COUNT(f.cc5) AS cc5 ,COUNT(g.cc6) AS cc6 ");
        $this->db->from("loan_details ld");
        $this->db->join(" (SELECT b.auid,COUNT(*) AS cc1
            FROM loan_details AS b
            WHERE b.stat = 8   AND  DATE_ADD(DATE_FORMAT(b.dbdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY b.auid ) AS b ", 'b.auid = ld.auid ', 'left'); //current

        $this->db->join(" (SELECT c.auid,COUNT(*) AS cc2
            FROM loan_details AS c
            WHERE c.stat = 8  AND c.auid NOT IN
            (SELECT r.rfno FROM recipts AS r WHERE r.stat IN('1','2','6') AND r.retp ='2' AND DATE_FORMAT(r.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt')
            AND  DATE_ADD(DATE_FORMAT(c.dbdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY c.auid
           ) AS c ", 'c.auid=ld.auid ', 'left'); // non paid

        $this->db->join("(SELECT d.auid,COUNT(*) AS cc3
            FROM loan_details AS d
            JOIN loan_current_status AS lc ON d.auid =lc.loan_id
            WHERE  d.stat = 8 AND d.auid IN
            (SELECT r.rfno FROM recipts AS r WHERE r.stat IN('1','2','6') AND r.retp ='2' AND DATE_FORMAT(r.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt' AND  r.ramt > 1 AND r.ramt <  d.prim )
             AND  DATE_ADD(DATE_FORMAT(d.dbdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY d.auid
           ) AS d ", 'd.auid=ld.auid ', 'left');  //under paid

        $this->db->join(" (SELECT e.auid,COUNT(*) AS cc4
            FROM loan_details AS e
            JOIN loan_current_status AS lc ON e.auid =lc.loan_id
            WHERE(lc.aboc)>0 AND e.stat = 8    AND  DATE_ADD(DATE_FORMAT(e.dbdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY e.auid
           ) AS e  ", 'e.auid =  ld.auid', 'left');  //arrears

        $this->db->join("(SELECT f.auid,COUNT(*) AS cc5
            FROM loan_details AS f
            JOIN loan_current_status AS lc ON f.auid =lc.loan_id
            JOIN loan_product_details AS pd ON pd.loan_auid = f.auid
            WHERE f.stat=8 AND (lc.aboc) > 0 AND (lc.curr_inst-1) = pd.max_time      AND  DATE_ADD(DATE_FORMAT(f.dbdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY f.auid
           ) AS f  ", 'f.auid = ld.auid', 'left'); //period over

        $this->db->join("(SELECT g.auid,COUNT(*) AS cc6
            FROM loan_details AS g
            JOIN loan_current_status AS lc ON g.auid =lc.loan_id
            WHERE lc.opamt > 0   AND  DATE_ADD(DATE_FORMAT(g.dbdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY g.auid
           )AS g  ", 'g.auid = ld.auid', 'left'); //over paid

        */

        $this->db->select("cen_mas.cnnm,brch_mas.brcd,user_mas.fnme,prdt_typ.prtp ,mc.brco,mc.clct,mc.ccnt,mc.prdtp,
        COUNT(*) AS cc0 , COUNT(b.cc1) AS cc1 ,COUNT(c.cc2) AS cc2 ,COUNT(d.cc3) AS cc3 ,COUNT(e.cc4) AS cc4 , COUNT(f.cc5) AS cc5 ,COUNT(g.cc6) AS cc6");

        $this->db->from("micr_crt mc");
        $this->db->join(" (SELECT b.lnid,COUNT(*) AS cc1
            FROM micr_crt AS b
            WHERE b.stat IN(5,18)   AND  DATE_ADD(DATE_FORMAT(b.cvdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY b.lnid ) AS b ", 'b.lnid = mc.lnid ', 'left');     // CURRENT

        $this->db->join(" (SELECT c.lnid,COUNT(*) AS cc2
            FROM micr_crt AS c
            WHERE c.stat IN(5,18) AND c.lnid NOT IN
            (SELECT r.rfno FROM receipt AS r WHERE r.stat IN('1','2') AND r.retp ='2' AND DATE_FORMAT(r.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt')
            AND  DATE_ADD(DATE_FORMAT(c.cvdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY c.lnid
               ) AS c ", 'c.lnid=mc.lnid ', 'left');     // NON PAID

        $this->db->join(" (SELECT d.lnid,COUNT(*) AS cc3
            FROM micr_crt AS d
            WHERE d.stat IN(5,18) AND d.lnid IN
            (SELECT r.rfno FROM receipt AS r WHERE r.stat IN('1','2') AND r.retp ='2' AND DATE_FORMAT(r.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt')
            AND  DATE_ADD(DATE_FORMAT(d.cvdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY d.lnid
               ) AS d ", 'd.lnid=mc.lnid ', 'left');     // UNDER PAID

        $this->db->join(" (SELECT e.lnid,COUNT(*) AS cc4
            FROM micr_crt AS e          
            WHERE(e.aboc + e.aboi)> 0 AND e.stat IN(5,18)  AND  DATE_ADD(DATE_FORMAT(e.cvdt, '%Y-%m-%d') , $inteval ) < '$today'
            GROUP BY e.lnid
           ) AS e  ", 'e.lnid =  mc.lnid', 'left');     // ARREARS

        $this->db->join("(SELECT f.lnid,COUNT(*) AS cc5
            FROM micr_crt AS f          
            WHERE f.stat IN(5,18) AND (f.aboc + f.aboi) > 0 AND f.durg = 0 AND DATE_ADD(DATE_FORMAT(f.cvdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY f.lnid
            ) AS f  ", 'f.lnid = mc.lnid', 'left');     // PERIOD OVER

        $this->db->join("(SELECT g.lnid,COUNT(*) AS cc6
            FROM micr_crt AS g           
            WHERE g.avcr > 0 AND DATE_ADD(DATE_FORMAT(g.cvdt, '%Y-%m-%d') , $inteval )  < '$today'
            GROUP BY g.lnid
           )AS g ", 'g.lnid = mc.lnid', 'left');     // OVER PAID

        $this->db->join('brch_mas', 'brch_mas.brid = mc.brco');
        $this->db->join('user_mas', 'user_mas.auid = mc.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = mc.ccnt');
        $this->db->join('prdt_typ', 'prdt_typ.prid = mc.prdtp');

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
        $this->db->group_by('mc.brco');
        $this->db->group_by('mc.clct');
        $this->db->group_by('mc.ccnt');
        $this->db->group_by('mc.prdtp');

        $this->db->where('mc.stat IN(5,18)');

        //$this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

    }

    private function cntrsumry_queryData()
    {
        $this->cntrsumry_query();
        $i = 0;
        foreach ($this->cl_srch6 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch6) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr6[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order6)) {
            $order6 = $this->order6;
            $this->db->order_by(key($order6), $order6[key($order6)]);
        }
    }

    function get_cntrsumry()
    {
        $this->cntrsumry_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_cntrsumry()
    {
        $this->cntrsumry_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cntrsumry()
    {
        $this->cntrsumry_query();
        return $this->db->count_all_results();
    }


    function get_viewsumry()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cnt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $prtp = $this->input->post('prd');

        $typ = $this->input->post('typ');

        $today = date("Y-m-d");     //TODAY DATE

        if ($prtp == '3' || $prtp == '6') {             // DAILY
            $inteval = "INTERVAL 1 DAY";
        } elseif ($prtp == '4' || $prtp == '7') {       // WK
            $inteval = "INTERVAL 7 DAY";
        } elseif ($prtp == '5' || $prtp == '8') {       // ML
            $inteval = "INTERVAL 7 DAY";
        } else {
            $inteval = "INTERVAL 7 DAY";
        }

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

        if ($typ == 2) {
            $this->db->where(" DATE_ADD(DATE_FORMAT(mc.cvdt, '%Y-%m-%d') , $inteval )  < '$today' ");         // CURRENT
        } else if ($typ == 3) {
            $this->db->where(" mc.lnid NOT IN
            (SELECT r.rfno FROM receipt AS r WHERE r.stat IN('1','2') AND r.retp ='2' AND DATE_FORMAT(r.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt')
            AND  DATE_ADD(DATE_FORMAT(mc.cvdt, '%Y-%m-%d') , $inteval )  < '$today' ");        // NON PAID
        } else if ($typ == 4) {
            $this->db->where(" mc.lnid IN
            (SELECT r.rfno FROM receipt AS r WHERE r.stat IN('1','2') AND r.retp ='2' AND DATE_FORMAT(r.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt')
            AND  DATE_ADD(DATE_FORMAT(mc.cvdt, '%Y-%m-%d') , $inteval )  < '$today' ");        // UNDER PAID
        } else if ($typ == 5) {
            $this->db->where(" (mc.aboc + mc.aboi)> 0 AND DATE_ADD(DATE_FORMAT(mc.cvdt, '%Y-%m-%d') , $inteval ) < '$today' ");         // ARREARS
        } else if ($typ == 6) {
            $this->db->where(" (mc.aboc + mc.aboi) > 0 AND mc.durg = 0 AND DATE_ADD(DATE_FORMAT(mc.cvdt, '%Y-%m-%d') , $inteval )  < '$today' ");         // PERIOD OVER
        } else if ($typ == 7) {
            $this->db->where("mc.avcr > 0 AND DATE_ADD(DATE_FORMAT(mc.cvdt, '%Y-%m-%d') , $inteval )  < '$today' ");        // OVER PAID
        }

        /*$this->db->group_by('mc.brco');
        $this->db->group_by('mc.clct');
        $this->db->group_by('mc.ccnt');
        $this->db->group_by('mc.prdtp');*/
        //$this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

        $query = $this->db->get();
        return $query->result();
    }

// END LOAN SUMMERY - CENTER SUMMERY
//
// ARREARS AGE WISE
    var $cl_srch7 = array('cnnm', 'usnm', 'product.prcd', 'init', 'cuno', 'micr_crt.acno'); //set column field database for datatable searchable
    var $cl_odr7 = array(null, 'brcd', 'usnm', 'prcd', 'init', 'cuno', 'acno', 'loam', 'acdt', 'arres', 'cage', 'lspd'); //set column field database for datatable orderable
    var $order7 = array('cage' => 'asc'); // default order

    function arrsAg_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $prtp = $this->input->post('prtp');
        $frag = $this->input->post('frag');
        $toag = $this->input->post('toag');

        $this->db->select("cus_mas.init,cus_mas.anic ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,user_mas.usnm ,cus_mas.cuno,
        (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres,  cen_mas.cnnm, micr_crt.lnid,  IFNULL(micr_crt.cage,0) AS cage,
         product.prcd,micr_crt.acdt ,micr_crt.lspd   ");
        $this->db->from("micr_crt");
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('product', 'product.auid = micr_crt.prid');

        $this->db->where('micr_crt.stat IN(5,18)');

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
        if ($prtp != 'all') {
            $this->db->where('micr_crt.prdtp', $prtp);
        }

        $this->db->where("micr_crt.cage BETWEEN '$frag' AND '$toag'");

    }

    private function arrsAg_queryData()
    {
        $this->arrsAg_query();
        $i = 0;
        foreach ($this->cl_srch7 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch7) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr7[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order7)) {
            $order7 = $this->order7;
            $this->db->order_by(key($order7), $order7[key($order7)]);
        }
    }

    function get_arrsAg()
    {
        $this->arrsAg_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_arrsAg()
    {
        $this->arrsAg_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_arrsAg()
    {
        $this->arrsAg_query();
        return $this->db->count_all_results();
    }
// END ARREARS AGE WISE
//
// PORTFOLIO
    var $cl_srch8 = array('micr_crt.acno', 'cus_mas.cuno', 'anic', '', ''); //set column field database for datatable searchable
    var $cl_odr8 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order8 = array('cage' => 'asc'); // default order

    function portfo_query()
    {
        $brn = $this->input->post('brn');
        $type = $this->input->post('type'); // 1-CURRENT / 2 - FINISHED / 3- TERMINATED
        $asdt = $this->input->post('asdt');

        $date = date("Y-m-d");//TODAY DATE


        $this->db->select("cus_mas.init,cus_mas.anic ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,user_mas.usnm ,cus_mas.cuno,
        (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres,  cen_mas.cnnm, micr_crt.lnid,  IFNULL(micr_crt.cage,0) AS cage,
         product.prcd,micr_crt.acdt ,micr_crt.lspd ,micr_crt.inta,micr_crt.noin,micr_crt.docg,micr_crt.incg,micr_crt.nxdd, 
           micr_crt.boc,micr_crt.boi,micr_crt.aboc,micr_crt.aboi,micr_crt.avcr,micr_crt.madt,micr_crt.lcnt, micr_crt.avpe,
            (SELECT SUM(ramt) FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp IN(1,2) AND stat IN(1,2)) AS ttpym ,z.avcp, z.avin,
            micr_crt.durg, cus_mas.mobi, 
            
            IFNULL( (SELECT ramt FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2)
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -7 DAY) AND  '$date'
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ),'0')  AS lwpd,
    IFNULL( (SELECT DATE_FORMAT(crdt, '%m/%d/%Y')  FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2) 
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -7 DAY) AND  '$date'
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ),'-')  AS lstpydt,
    IF((SELECT ramt FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2) 
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -21 DAY) AND  '$date' 
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ) > 0,'YES','NO') AS lp21,   
     ROUND(IFNULL(((select sum(receipt.ramt) from receipt where receipt.rfno=micr_crt.lnid AND receipt.retp=2 AND receipt.stat IN(1,2))  / (micr_crt.loam + `micr_crt`.`inta`) *100 ),'0'),2) AS pr21,
    IF((SELECT ramt FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2) 
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -45 DAY) AND  '$date'
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ) > 0,'YES','NO') AS lpmt45,   
    IFNULL( (SELECT ramt FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2)
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -45 DAY) AND  '$date'
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ),'0')    AS lp45 ,
    IF((SELECT ramt FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2) 
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -60 DAY) AND  '$date'
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ) > 0,'YES','NO') AS lpmt60,
    IFNULL( (SELECT ramt FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2) 
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -60 DAY) AND  '$date'
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ),'0') AS lp60 ,
    IF((SELECT ramt FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2) 
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -90 DAY) AND  '$date'
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ) > 0,'YES','NO') AS lpmt90,
    IFNULL( (SELECT ramt FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp = 2 AND receipt.stat IN (1,2) 
        AND DATE_FORMAT(crdt, '%Y-%m-%d') BETWEEN  DATE_ADD(DATE_FORMAT('$date', '%Y-%m-%d'), INTERVAL -90 DAY) AND  '$date'
        ORDER BY `receipt`.`reid` DESC LIMIT 1 ),'0')     AS lp90,
        
            ");
        $this->db->from("micr_crt");
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('product', 'product.auid = micr_crt.prid');

        $this->db->join(" (SELECT acid,SUM(avcp) AS avcp, SUM(avin) AS avin  
                FROM `micr_crleg` z WHERE dsid IN(2,10) AND stat IN(1,2) GROUP BY acid
                     ) AS z", 'z.acid = micr_crt.lnid ', 'left');     // PAID CAP ,PAID INT

        if ($type == 1) {
            $this->db->where('micr_crt.stat IN(5,18)');
        } else if ($type == 2) {
            $this->db->where('micr_crt.stat IN(3,7)');
        } else if ($type == 3) {
            $this->db->where('micr_crt.stat IN(8,12)');
        }

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        //$this->db->where(" DATE_ADD(DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') , INTERVAL 7 DAY )  < '$asdt' ");

    }

    private function portfo_queryData()
    {
        $this->portfo_query();
        $i = 0;
        foreach ($this->cl_srch8 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch8) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr8[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order8)) {
            $order8 = $this->order8;
            $this->db->order_by(key($order8), $order8[key($order8)]);
        }
    }

    function get_portfolio()
    {
        $this->portfo_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_portfo()
    {
        $this->portfo_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_portfo()
    {
        // $this->db->from($this->table);
        $this->portfo_query();
        return $this->db->count_all_results();
    }
// END PORTFOLIO
//
// PA REPORT BRANCH
    var $cl_srch9 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr9 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order9 = array('cage' => 'asc'); // default order

    function paBrnch_query()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prtp');

        $this->db->select("brch_mas.brcd, mc.lnid,  prdt_typ.prtp,  mc.brco, mc.prdtp,    
        (SELECT SUM(boc) FROM `micr_crt` ) AS tt0, z.tt00, a.tt1, b.tt2, c.tt3, d.tt4, e.tt5, f.tt6, g.tt7, h.tt8  ");

        $this->db->from("micr_crt mc");
        $this->db->join('brch_mas', 'brch_mas.brid = mc.brco');
        $this->db->join('prdt_typ', 'prdt_typ.prid = mc.prdtp');

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt00 FROM `micr_crt` z WHERE stat IN(5,18) AND (boc + boi) > 0
                     GROUP BY z.brco ,z.prdtp) AS z", 'z.brco=mc.brco AND z.prdtp = mc.prdtp ', 'left');                    //  BRANCH TOTAL

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt1 FROM `micr_crt` a 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND a.cage < 0 GROUP BY a.brco ,a.prdtp) AS a", 'a.brco=mc.brco AND a.prdtp = mc.prdtp ', 'left');     // < 0

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt2 FROM `micr_crt` b 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND b.cage BETWEEN 0.00 AND 1.01  GROUP BY b.brco ,b.prdtp) AS b", 'b.brco=mc.brco AND b.prdtp = mc.prdtp ', 'left');     // 0 - 1

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt3 FROM `micr_crt` c 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND c.cage BETWEEN 1.01 AND 2.01 GROUP BY c.brco ,c.prdtp) AS c", 'c.brco=mc.brco AND c.prdtp = mc.prdtp ', 'left');     // 1 - 2

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt4 FROM `micr_crt` d 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND d.cage BETWEEN 2.01 AND 3.01 GROUP BY d.brco ,d.prdtp) AS d", 'd.brco=mc.brco AND d.prdtp = mc.prdtp ', 'left');     // 2 - 3

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt5 FROM `micr_crt` e 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND e.cage BETWEEN 3.01 AND 4.01 GROUP BY e.brco ,e.prdtp) AS e", 'c.brco=mc.brco AND e.prdtp = mc.prdtp ', 'left');     // 3 - 4

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt6 FROM `micr_crt` f 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND f.cage BETWEEN 4.01 AND 5.01 GROUP BY f.brco ,f.prdtp) AS f", 'f.brco=mc.brco AND f.prdtp = mc.prdtp ', 'left');     // 4 - 5

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt7 FROM `micr_crt` g 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND g.cage BETWEEN 5.01 AND 6.00 GROUP BY g.brco ,g.prdtp) AS g", 'g.brco=mc.brco AND g.prdtp = mc.prdtp ', 'left');     // 5 - 6

        $this->db->join(" (SELECT brco, prdtp, SUM(boc) AS tt8 FROM `micr_crt` h 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND h.cage >= 6 GROUP BY h.brco ,h.prdtp) AS h", 'h.brco=mc.brco AND h.prdtp = mc.prdtp ', 'left');     // > 6

        if ($brn != 'all') {
            $this->db->where('mc.brco', $brn);
        }
        $this->db->group_by('mc.brco');

        if ($prtp != 'all') {
            $this->db->where('mc.prdtp', $prtp);
        }
        $this->db->group_by('mc.prdtp');

        $this->db->where('mc.stat IN(5,18)');
        $this->db->where("(mc.boc + mc.boi) > 0");

        //$this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
    }

    private function paBrnch_queryData()
    {
        $this->paBrnch_query();
        $i = 0;
        foreach ($this->cl_srch9 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch9) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr9[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order9)) {
            $order9 = $this->order9;
            $this->db->order_by(key($order9), $order9[key($order9)]);
        }
    }

    function get_paBrnch()
    {
        $this->paBrnch_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_paBrnch()
    {
        $this->paBrnch_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_paBrnch()
    {
        $this->paBrnch_query();
        return $this->db->count_all_results();
    }
// END PA BRANCH
//
// PA LEADGER
    var $cl_srch10 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr10 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order10 = array('cage' => 'asc'); // default order

    function paLeger_query()
    {
        $brn = $this->input->post('brid');
        $prd = $this->input->post('prid');
        $typ = $this->input->post('typ');
        $asdt = date('Y-m-d');

        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');

        $this->db->select("cus_mas.init,cus_mas.anic ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,user_mas.usnm ,cus_mas.cuno,cus_mas.mobi, product.prcd,
        (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres, ((micr_crt.boc + micr_crt.boi +micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) - micr_crt.avcr ) AS bal,  
        cen_mas.cnnm, micr_crt.lnid,  IFNULL(micr_crt.cage,0) AS cage,
         micr_crt.acdt ,micr_crt.lspd ,micr_crt.inta,micr_crt.noin,micr_crt.docg,micr_crt.incg,micr_crt.nxdd, micr_crt.durg, 
         micr_crt.boc,micr_crt.boi,micr_crt.aboc,micr_crt.aboi,micr_crt.avcr,micr_crt.madt,micr_crt.lcnt,micr_crt.lnpr, micr_crt.avpe,micr_crt.lspd,micr_crt.lspa,
         (SELECT SUM(ramt) FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp IN(1,2) AND stat IN(1,2)) AS ttpym");
        $this->db->from("micr_crt");
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('product', 'product.auid = micr_crt.prid');

        $this->db->where('micr_crt.stat IN(5,18) AND (boc + boi) > 0');
        //$this->db->where(" DATE_ADD(DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') , INTERVAL 7 DAY )  < '$asdt' ");

        if ($prd != 'all') {
            $this->db->where('micr_crt.prdtp', $prd);
        }

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }

        if (!empty($exc)) {
            if ($exc != 'all') {
                $this->db->where('micr_crt.clct', $exc);
            }
        }

        if (!empty($cen)) {
            if ($cen != 'all') {
                $this->db->where('micr_crt.ccnt', $cen);
            }
        }

        if ($typ == 1) {
            $this->db->where(" micr_crt.cage <= 0 ");                        // < 0
        } else if ($typ == 2) {
            $this->db->where(" micr_crt.cage BETWEEN '0.00' AND '1.01'  ");     // 0 - 1
        } else if ($typ == 3) {
            $this->db->where(" micr_crt.cage BETWEEN '1.01' AND '2.01'  ");     // 1 - 2
        } else if ($typ == 4) {
            $this->db->where(" micr_crt.cage BETWEEN '2.01' AND '3.01'  ");     // 2 - 3
        } else if ($typ == 5) {
            $this->db->where(" micr_crt.cage BETWEEN '3.01' AND '4.01'  ");     // 3 - 4
        } else if ($typ == 6) {
            $this->db->where(" micr_crt.cage BETWEEN '4.01' AND '5.01'  ");     // 4 - 5
        } else if ($typ == 7) {
            $this->db->where(" micr_crt.cage BETWEEN '5.01' AND '6.01'  ");     // 5 - 6
        } else if ($typ == 8) {
            $this->db->where(" micr_crt.cage > 6.01  ");                    // > 6
        }

    }

    private function paLeger_queryData()
    {
        $this->paLeger_query();
        $i = 0;
        foreach ($this->cl_srch1 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order1)) {
            $order1 = $this->order1;
            $this->db->order_by(key($order1), $order1[key($order1)]);
        }
    }

    function get_paLeger()
    {
        $this->paLeger_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_paLeger()
    {
        $this->paLeger_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_paLeger()
    {
        $this->paLeger_query();
        return $this->db->count_all_results();
    }
// END PA LEDGER
//
// GENERAL LEDGER
    var $cl_srch11 = array('brnm', '', '', '', '', ''); //set column field database for datatable searchable
    var $cl_odr11 = array(null, 'brnm', '', 'acdt', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order11 = array('cage' => 'asc'); // default order

    function gl_query()
    {
        $brn = $this->input->post('brn');
        $mnac = $this->input->post('mnac');
        $chac = $this->input->post('chac');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');


        $this->db->select("acc_leg.* , brch_mas.brnm,accu_chrt.hadr ");
        $this->db->from("acc_leg");
        $this->db->join('brch_mas', 'brch_mas.brid = acc_leg.brno');
        $this->db->join('accu_chrt', 'accu_chrt.idfr = acc_leg.spcd');


        if ($brn != 'all') {
            $this->db->where('acc_leg.brno', $brn);
        }
        if ($mnac != 'all') {
            $this->db->where('accu_chrt.acid', $mnac);
        }
        if ($chac != 'all') {
            $this->db->where('acc_leg.spcd', $chac);
        }

        $this->db->where("DATE_FORMAT(acc_leg.acdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

    }

    private function gl_queryData()
    {
        $this->gl_query();
        $i = 0;
        foreach ($this->cl_srch11 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch11) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr11[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order11)) {
            $order11 = $this->order11;
            $this->db->order_by(key($order11), $order11[key($order11)]);
        }
    }

    function get_gl()
    {
        $this->gl_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_gl()
    {
        $this->gl_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_gl()
    {
        $this->gl_query();
        return $this->db->count_all_results();
    }
// END GENERAL LEDGER
//
// DEBTOR PORTFOLIO
    var $cl_srch12 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr12 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order12 = array('cage' => 'asc'); // default order

    function dbtPort_query()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prtp');
        $ofcr = $this->input->post('ofcr');
        $cen = $this->input->post('cen');
        $dt = date('Y-m-d');

        $this->db->select("cus_mas.init,cus_mas.anic ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,brch_mas.brnm,user_mas.usnm ,cus_mas.cuno,
        (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres,  cen_mas.cnnm, micr_crt.lnid,  IFNULL(micr_crt.cage,0) AS cage,
         product.prcd,micr_crt.acdt ,micr_crt.lspd ,micr_crt.inta,micr_crt.noin,micr_crt.docg,micr_crt.incg,micr_crt.nxdd, 
           micr_crt.boc,micr_crt.boi,micr_crt.aboc,micr_crt.aboi,micr_crt.avcr,micr_crt.madt,micr_crt.lcnt, micr_crt.avpe,micr_crt.lspa,DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') AS cvdt,
            (SELECT SUM(ramt) FROM `receipt` WHERE `rfno` = micr_crt.lnid AND retp IN(1,2) AND stat IN(1,2)) AS ttpym ");
        $this->db->from("micr_crt");
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('product', 'product.auid = micr_crt.prid');

        /* $this->db->join(" (SELECT acid,SUM(avcp) AS avcp, SUM(avin) AS avin
                 FROM `micr_crleg` z WHERE dsid IN(2,10) AND stat IN(1,2) GROUP BY acid
                      ) AS z", 'z.acid = micr_crt.lnid ', 'left');     // PAID CAP ,PAID INT*/

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($prtp != 'all') {
            $this->db->where('micr_crt.prdtp', $prtp);
        }
        if ($ofcr != 'all') {
            $this->db->where('micr_crt.clct', $ofcr);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }

        $this->db->where('micr_crt.stat IN(5,18)');
        //$this->db->where(" DATE_ADD(DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') , INTERVAL 7 DAY )  < '$dt' ");

    }

    private function dbtPort_queryData()
    {
        $this->dbtPort_query();
        $i = 0;
        foreach ($this->cl_srch12 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch12) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr12[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order12)) {
            $order12 = $this->order12;
            $this->db->order_by(key($order12), $order12[key($order12)]);
        }
    }

    function get_dbtPort()
    {
        $this->dbtPort_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_dbtPort()
    {
        $this->dbtPort_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_dbtPort()
    {
        $this->dbtPort_query();
        return $this->db->count_all_results();
    }
// END DEBTOR PORTFOLIO
//
// DEBTOR INVESTMENT
    var $cl_srch13 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr13 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order13 = array('cage' => 'asc'); // default order

    function dbtInvst_query()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prtp');
        $ofcr = $this->input->post('ofcr');
        $cen = $this->input->post('cen');

        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $frag = $this->input->post('frag');
        $toag = $this->input->post('toag');

        $this->db->select("cus_mas.init,cus_mas.anic ,micr_crt.acno,micr_crt.loam,micr_crt.inam,brch_mas.brcd,user_mas.usnm ,cus_mas.cuno,
        (micr_crt.aboc + micr_crt.aboi + micr_crt.avdb + micr_crt.avpe) AS arres,  cen_mas.cnnm, micr_crt.lnid,  IFNULL(micr_crt.cage,0) AS cage,
         product.prcd,micr_crt.acdt ,micr_crt.lspd ,micr_crt.inta,micr_crt.noin,micr_crt.docg,micr_crt.incg, micr_crt.nxdd, micr_crt.boc, micr_crt.boi, 
           micr_crt.boc,micr_crt.boi,micr_crt.aboc,micr_crt.aboi,micr_crt.avcr,micr_crt.madt,micr_crt.lcnt, micr_crt.avpe,micr_crt.lspa,DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') AS cvdt,
            ");
        $this->db->from("micr_crt");
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('product', 'product.auid = micr_crt.prid');

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($prtp != 'all') {
            $this->db->where('micr_crt.prdtp', $prtp);
        }
        if ($ofcr != 'all') {
            $this->db->where('micr_crt.clct', $ofcr);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }

        $this->db->where('micr_crt.stat IN(5,18)');
        $this->db->where(" DATE_ADD(DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') , INTERVAL 7 DAY )  BETWEEN  '$frdt' AND '$todt' ");
        $this->db->where(" micr_crt.cage BETWEEN  '$frag' AND '$toag' ");

    }

    private function dbtInvst_queryData()
    {
        $this->dbtInvst_query();
        $i = 0;
        foreach ($this->cl_srch13 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch13) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr13[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order13)) {
            $order13 = $this->order13;
            $this->db->order_by(key($order13), $order13[key($order13)]);
        }
    }

    function get_dbtInvst()
    {
        $this->dbtInvst_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_dbtInvst()
    {
        $this->dbtInvst_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_dbtInvst()
    {
        $this->dbtInvst_query();
        return $this->db->count_all_results();
    }
// END DEBTOR INVESTMENT
//
// DEBTOR PORTFOLIO
    var $cl_srch14 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr14 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order14 = array('cage' => 'asc'); // default order

    function dbtAge_query()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prtp');
        $exc = $this->input->post('ofcr');
        $cen = $this->input->post('cen');
        $asdt = $this->input->post('asdt');

        $this->db->select("brch_mas.brcd,brch_mas.brnm, mc.lnid,  prdt_typ.prtp,  mc.brco, mc.prdtp,mc.clct,mc.ccnt, user_mas.usnm, cen_mas.cnnm,  
        (z.tt00 / (SELECT SUM(aboc + aboi) FROM `micr_crt` WHERE stat IN(5,18) AND (boc + boi) > 0)*100) AS tt0, 
        IFNULL(z.tt00,0) AS tt00 , IFNULL(a.c1,0)AS c1 ,IFNULL(a.ta1,0) AS ta1 ,IFNULL(a.tb1,0) AS tb1 ,IFNULL(b.c2,0) AS c2 ,IFNULL(b.ta2,0) AS ta2 ,IFNULL(b.tb2,0) AS tb2,
        IFNULL(c.c3,0) AS c3,IFNULL(c.ta3,0) AS ta3,IFNULL(c.tb3,0) AS tb3, IFNULL(d.c4,0) AS c4,IFNULL(d.ta4,0) AS ta4,IFNULL(d.tb4,0) AS tb4, IFNULL(e.c5,0) AS c5,IFNULL(e.ta5,0) AS ta5,
        IFNULL(e.tb5,0) AS tb5,IFNULL(f.c6,0) AS c6 ,IFNULL(f.ta6,0) AS ta6 ,IFNULL(f.tb6,0) AS tb6 ,IFNULL(g.c7,0) AS c7, IFNULL(g.ta7,0) AS ta7 ,IFNULL(g.tb7,0) AS tb7 ,
        IFNULL(h.c8,0) AS c8 ,IFNULL(h.ta8,0) AS ta8 ,IFNULL(h.tb8,0) AS tb8    ");

        $this->db->from("micr_crt mc");
        $this->db->join('brch_mas', 'brch_mas.brid = mc.brco');
        $this->db->join('user_mas', 'user_mas.auid = mc.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = mc.ccnt');
        $this->db->join('prdt_typ', 'prdt_typ.prid = mc.prdtp');

        $this->db->join(" (SELECT brco, prdtp, SUM(aboc + aboi) AS tt00 FROM `micr_crt` z WHERE stat IN(5,18) AND (boc + boi) > 0
                     GROUP BY z.brco ,z.prdtp) AS z", 'z.brco=mc.brco AND z.prdtp = mc.prdtp ', 'left');     //  BRANCH TOTAL

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c1, SUM(aboc) AS ta1, SUM(aboc + aboi) AS tb1 FROM `micr_crt` a 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND a.cage < 0 GROUP BY a.brco ,a.prdtp) AS a", 'a.brco=mc.brco AND a.prdtp = mc.prdtp ', 'left');     // < 0

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c2, SUM(aboc) AS ta2, SUM(aboc + aboi) AS tb2 FROM `micr_crt` b 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND b.cage BETWEEN 0.00 AND 1.01  GROUP BY b.brco ,b.prdtp) AS b", 'b.brco=mc.brco AND b.prdtp = mc.prdtp ', 'left');     // 0 - 1

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c3, SUM(aboc) AS ta3, SUM(aboc + aboi) AS tb3 FROM `micr_crt` c 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND c.cage BETWEEN 1.01 AND 2.01 GROUP BY c.brco ,c.prdtp) AS c", 'c.brco=mc.brco AND c.prdtp = mc.prdtp ', 'left');     // 1 - 2

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c4, SUM(aboc) AS ta4, SUM(aboc + aboi) AS tb4 FROM `micr_crt` d 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND d.cage BETWEEN 2.01 AND 3.01 GROUP BY d.brco ,d.prdtp) AS d", 'd.brco=mc.brco AND d.prdtp = mc.prdtp ', 'left');     // 2 - 3

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c5, SUM(aboc) AS ta5, SUM(aboc + aboi) AS tb5 FROM `micr_crt` e 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND e.cage BETWEEN 3.01 AND 4.01 GROUP BY e.brco ,e.prdtp) AS e", 'c.brco=mc.brco AND e.prdtp = mc.prdtp ', 'left');     // 3 - 4

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c6, SUM(aboc) AS ta6, SUM(aboc + aboi) AS tb6 FROM `micr_crt` f 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND f.cage BETWEEN 4.01 AND 5.01 GROUP BY f.brco ,f.prdtp) AS f", 'f.brco=mc.brco AND f.prdtp = mc.prdtp ', 'left');     // 4 - 5

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c7, SUM(aboc) AS ta7, SUM(aboc + aboi) AS tb7 FROM `micr_crt` g 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND g.cage BETWEEN 5.01 AND 6.00 GROUP BY g.brco ,g.prdtp) AS g", 'g.brco=mc.brco AND g.prdtp = mc.prdtp ', 'left');     // 5 - 6

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c8, SUM(aboc) AS ta8, SUM(aboc + aboi) AS tb8 FROM `micr_crt` h 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND h.cage >= 6 GROUP BY h.brco ,h.prdtp) AS h", 'h.brco=mc.brco AND h.prdtp = mc.prdtp ', 'left');     // > 6

        if ($brn != 'all') {
            $this->db->where('mc.brco', $brn);
        }
        if ($prtp != 'all') {
            $this->db->where('mc.prdtp', $prtp);
        }
        if ($exc != 'all') {
            $this->db->where('mc.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('mc.ccnt', $cen);
        }

        $this->db->where('mc.stat IN(5,18)');
        $this->db->where("(mc.boc + mc.boi) > 0");
        //$this->db->where(" DATE_ADD(DATE_FORMAT(mc.cvdt, '%Y-%m-%d') , INTERVAL 7 DAY )  < '$asdt' ");

        $this->db->group_by('mc.brco');
        $this->db->group_by('mc.prdtp');
        $this->db->group_by('mc.clct');
        $this->db->group_by('mc.ccnt');


        //$this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
    }

    private function dbtAge_queryData()
    {
        $this->dbtAge_query();
        $i = 0;
        foreach ($this->cl_srch14 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch14) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr14[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order14)) {
            $order14 = $this->order14;
            $this->db->order_by(key($order14), $order14[key($order14)]);
        }
    }

    function get_dbtAge()
    {
        $this->dbtAge_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_dbtAge()
    {
        $this->dbtAge_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_dbtAge()
    {
        $this->dbtAge_query();
        return $this->db->count_all_results();
    }
// END DEBTOR PORTFOLIO
//
// PROVISION SUMMERY
    var $cl_srch15 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr15 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order15 = array('cage' => 'asc'); // default order

    function provis_query()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prtp');
        $asdt = $this->input->post('asdt');

        $this->db->select("brch_mas.brcd,brch_mas.brnm, mc.lnid,  prdt_typ.prtp,  mc.brco, mc.prdtp,mc.clct,mc.ccnt, user_mas.usnm, cen_mas.cnnm,  
         IFNULL(a.c1,0) AS c1,IFNULL(a.ta1,0) AS ta1 ,IFNULL(b.c2,0) AS c2,IFNULL(b.ta2,0) AS ta2, IFNULL(c.c3,0) AS c3,IFNULL(c.ta3,0) AS ta3, IFNULL(d.c4,0) AS c4,IFNULL(d.ta4,0) AS ta4,
         IFNULL(z.tt1,0) AS tt1, IFNULL(z.port,0) AS port ,IFNULL(z.stck,0) AS stck");
        $this->db->from("micr_crt mc");
        $this->db->join('brch_mas', 'brch_mas.brid = mc.brco');
        $this->db->join('user_mas', 'user_mas.auid = mc.clct');
        $this->db->join('cen_mas', 'cen_mas.caid = mc.ccnt');
        $this->db->join('prdt_typ', 'prdt_typ.prid = mc.prdtp');

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS tt1, SUM(boc) AS stck, SUM(boc + aboc) AS port FROM `micr_crt` z 
                    WHERE stat IN(5,18) AND (boc + boi) > 0  GROUP BY z.brco ,z.prdtp) AS z", 'z.brco=mc.brco AND z.prdtp = mc.prdtp ', 'left');        //  total

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c1, SUM(boc + aboc) AS ta1 FROM `micr_crt` a 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND a.cage BETWEEN 3.00 AND 6.01 GROUP BY a.brco ,a.prdtp) AS a", 'a.brco=mc.brco AND a.prdtp = mc.prdtp ', 'left');        // 3 - 6

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c2, SUM(boc + aboc) AS ta2 FROM `micr_crt` b 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND b.cage BETWEEN 6.01 AND 12.01  GROUP BY b.brco ,b.prdtp) AS b", 'b.brco=mc.brco AND b.prdtp = mc.prdtp ', 'left');      // 3 - 12

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c3, SUM(boc + aboc) AS ta3 FROM `micr_crt` c 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND c.cage BETWEEN 12.01 AND 24.01 GROUP BY c.brco ,c.prdtp) AS c", 'c.brco=mc.brco AND c.prdtp = mc.prdtp ', 'left');      // 12 - 24

        $this->db->join(" (SELECT brco, prdtp, COUNT(*) AS c4, SUM(boc + aboc) AS ta4 FROM `micr_crt` d 
                    WHERE stat IN(5,18) AND (boc + boi) > 0 AND d.cage  > 24.01  GROUP BY d.brco ,d.prdtp) AS d", 'd.brco=mc.brco AND d.prdtp = mc.prdtp ', 'left');             //  AGE > 24

        if ($brn != 'all') {
            $this->db->where('mc.brco', $brn);
        }
        if ($prtp != 'all') {
            $this->db->where('mc.prdtp', $prtp);
        }


        $this->db->where('mc.stat IN(5,18)');
        $this->db->where("(mc.boc + mc.boi) > 0");
        //$this->db->where(" DATE_ADD(DATE_FORMAT(mc.cvdt, '%Y-%m-%d') , INTERVAL 7 DAY )  < '$asdt' ");

        $this->db->group_by('mc.brco');
        $this->db->group_by('mc.prdtp');

        //$this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
    }

    private function provis_queryData()
    {
        $this->provis_query();
        $i = 0;
        foreach ($this->cl_srch15 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch15) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr15[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order15)) {
            $order15 = $this->order15;
            $this->db->order_by(key($order15), $order15[key($order15)]);
        }
    }

    function get_provis()
    {
        $this->provis_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_provis()
    {
        $this->provis_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_provis()
    {
        $this->provis_query();
        return $this->db->count_all_results();
    }
// END PROVISION SUMMERY
//
// INVERSMENT REPORT
    var $cl_srch16 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr16 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order16 = array('cage' => 'asc'); // default order

    function inverst_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $prtp = $this->input->post('prtp');
        $prdt = $this->input->post('prdt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("brch_mas.brcd,brch_mas.brnm, mc.lnid,  prdt_typ.prtp, product.prnm,  mc.brco, mc.prdtp,mc.clct,mc.ccnt, CONCAT(user_mas.fnme,' ',user_mas.lnme) AS exe,
         a.tt1, a.tt2, b.tt3 ");
        $this->db->from("micr_crt mc");
        $this->db->join('brch_mas', 'brch_mas.brid = mc.brco');
        $this->db->join('user_mas', 'user_mas.auid = mc.clct');
        // $this->db->join('cen_mas', 'cen_mas.caid = mc.ccnt');
        $this->db->join('prdt_typ', 'prdt_typ.prid = mc.prdtp');
        $this->db->join('product', 'product.auid = mc.prid');

        $this->db->join(" (SELECT a.brco ,a.prdtp,SUM(loam) AS tt1 ,SUM(vuam) AS tt2 FROM `micr_crt` a 
                    JOIN voucher ON voucher.rfid = a.lnid 
                    WHERE vupd = 1  AND a.stat IN(5,18) GROUP BY a.brco ,a.prdtp ) AS a", 'a.brco=mc.brco AND a.prdtp = mc.prdtp ', 'left');

        $this->db->join(" (SELECT b.brco ,b.prdtp, SUM(loam) AS tt3  FROM `micr_crt` b                   
                    WHERE vupd = 0  AND b.stat =2  GROUP BY b.brco ,b.prdtp  ) AS b", 'b.brco=mc.brco AND b.prdtp = mc.prdtp ', 'left');

        if ($brn != 'all') {
            $this->db->where('mc.brco', $brn);
        }
        if ($prtp != 'all') {
            $this->db->where('mc.prdtp', $prtp);
        }
        if ($exc != 'all') {
            $this->db->where('mc.clct', $exc);
        }
        if ($prdt != 'all') {
            $this->db->where('mc.prid', $prdt);
        }

        //$this->db->where('mc.stat IN(5,18)',);
        $this->db->where("DATE_FORMAT(mc.cvdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
        $this->db->group_by('mc.brco');
        $this->db->group_by('mc.prdtp');
        $this->db->group_by('mc.clct');
    }

    private function inverst_queryData()
    {
        $this->inverst_query();
        $i = 0;
        foreach ($this->cl_srch16 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch16) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr16[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order16)) {
            $order16 = $this->order16;
            $this->db->order_by(key($order16), $order16[key($order16)]);
        }
    }

    function get_inverst()
    {
        $this->inverst_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_inverst()
    {
        $this->inverst_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_inverst()
    {
        $this->inverst_query();
        return $this->db->count_all_results();
    }
// END INVERSMENT REPORT
//
// INCOME REPORT
    var $cl_srch19 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr19 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order19 = array('cage' => 'asc'); // default order

    function incom_query()
    {
        $brn = $this->input->post('brn');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("brch_mas.brcd,brch_mas.brnm, mc.lnid, mc.brco, mc.prdtp,mc.clct,mc.ccnt, 
         a.tt1, b.tt2, c.tt3 ,d.rncp, d.rnin, e.avcp, e.avin ,e.dpet ,a.boc, a.boi, a.aboc, a.aboi, g.inmt, g.dcg, g.icg ");
        $this->db->from("micr_crt mc");
        $this->db->join('brch_mas', 'brch_mas.brid = mc.brco');
// CURRENT
        $this->db->join(" (SELECT a.brco ,SUM(loam) AS tt1, SUM(boc) AS boc, SUM(boi) AS boi, SUM(aboc) AS aboc, SUM(aboi) AS aboi
                    FROM `micr_crt` a                    
                    WHERE (boc + aboc) > 0 AND  a.stat IN(5,18) GROUP BY a.brco ) AS a", 'a.brco=mc.brco ', 'left');
// FINIDHED
        $this->db->join(" (SELECT b.brco ,SUM(loam) AS tt2  FROM `micr_crt` b                    
                    WHERE (boc + aboc) < 0 AND  b.stat IN(3,7) GROUP BY b.brco ) AS b", 'a.brco=mc.brco ', 'left');
// TERMINATED
        $this->db->join(" (SELECT c.brco ,SUM(loam) AS tt3  FROM `micr_crt` c                    
                    WHERE c.stat IN(8,12) GROUP BY c.brco ) AS c", 'c.brco=mc.brco ', 'left');
// SHOULD COLLECTED
        $this->db->join(" (SELECT lnid ,SUM(rncp) AS rncp ,SUM(rnin) AS rnin  FROM `micr_crleg` d        
                    JOIN micr_crt ON micr_crt.lnid = d.acid 
                    WHERE dsid = 3 AND d.stat = 1  ) AS d", 'd.lnid = mc.lnid ', 'left');

// INCOME
        $this->db->join(" (SELECT lnid ,SUM(avcp) AS avcp ,SUM(avin) AS avin ,SUM(dpet) AS dpet FROM `micr_crleg` e 
                    JOIN micr_crt ON micr_crt.lnid = e.acid 
                    WHERE dsid IN(2,9,10,11) AND e.stat = 1  ) AS e", 'e.lnid = mc.lnid ', 'left');
// DOC/INSU FEE
        $this->db->join(" (SELECT g.brco ,SUM(docg) AS dcg, SUM(incg) AS icg, SUM(loam) AS inmt 
                    FROM `micr_crt` g                    
                    WHERE g.stat IN(5,18) AND g.cvpt = 1 GROUP BY g.brco ) AS g", 'g.brco=mc.brco ', 'left');


        if ($brn != 'all') {
            $this->db->where('mc.brco', $brn);
        }
        $this->db->group_by('mc.brco');
        $this->db->where("DATE_FORMAT(mc.cvdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

        //$this->db->where('mc.stat IN(5,18)',);
//        $this->db->group_by('mc.prdtp');
//        $this->db->group_by('mc.clct');
    }

    private function incom_queryData()
    {
        $this->incom_query();
        $i = 0;
        foreach ($this->cl_srch19 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch19) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr19[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order19)) {
            $order19 = $this->order19;
            $this->db->order_by(key($order19), $order19[key($order19)]);
        }
    }

    function get_incom()
    {
        $this->incom_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_incom()
    {
        $this->incom_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_incom()
    {
        $this->incom_query();
        return $this->db->count_all_results();
    }
// END INCOME REPORT
//
// DEPLETION
    var $cl_srch20 = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odr20 = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order20 = array('cage' => 'asc'); // default order

    function deplt_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofcr');
        $prtp = $this->input->post('prtp');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $dt1 = date('Y-m-d');

        $de1 = new DateTime($frdt);
        $de1->modify('last day of last month');
        $me1 = $de1->format('Y-m-d'); //LAST DAY LAST MONTH

        $cy1 = date('Y-m-d', strtotime("this year January 1st")); //LAST DAY LAST YEAR
        $ly1 = date('Y-m-d', strtotime("last year December 31st")); //LAST DAY LAST YEAR


        $this->db->select("a.brco, a.clct, b.brcd,b.brnm, a.prid,p.prcd, IFNULL(c.usnm, a.clct) AS ofer, IFNULL(e.s1,0) AS s1, IFNULL(f.s2,0) AS s2, IFNULL(g.boc, 0) AS boc, 
        IFNULL(h.s3,0) AS s3, IFNULL(i.s4,0) AS s4, IFNULL(j.s5,0) AS s5, IFNULL(k.s6,0) AS s6, IFNULL(j.s7,0) AS s7, IFNULL(g.boi, 0) AS boi, IFNULL(g.tta, 0) AS tta,
         IFNULL(g.tpr, 0) AS tpr");

        $this->db->from("acc_day_bal a");
        $this->db->join('brch_mas b', 'b.brid = a.brco');
        $this->db->join('user_mas c', 'c.auid = a.clct');
        $this->db->join('product p', 'p.auid = a.prid');

        $this->db->join(" (SELECT e.brco, e.prid, e.clct, SUM(e.bcap) AS s1
						FROM acc_day_bal e
						WHERE e.cdte = '$me1' ) AS e", 'e.brco = a.brco AND a.prid = e.prid AND a.clct = e.clct ', 'left');

        $this->db->join(" (SELECT f.brco, f.prid, f.clct, SUM(f.inam) AS s2
						FROM acc_day_bal f
						WHERE f.cdte BETWEEN '$frdt' AND '$todt'
						GROUP BY f.brco, f.prid, f.clct ) AS f", ' f.brco = a.brco AND a.prid = f.prid AND a.clct = f.clct ', 'left');

        $this->db->join(" (SELECT g.brco, g.prid, g.clct, SUM(g.loam) AS ttl, ROUND(SUM(g.boc),2) AS boc, ROUND(SUM(g.boi),2) AS boi, ROUND(SUM(g.aboc)+SUM(g.aboi)+SUM(g.boc),2) AS tta, ROUND(SUM(g.aboc)+SUM(g.boc)+SUM(g.aboi)+SUM(g.boi),2) AS tpr 
						FROM micr_crt AS g 
						WHERE g.stat= 2 AND (g.boc+g.boi) > 0
						GROUP BY g.brco, g.prid, g.clct) AS g", ' g.brco = a.brco AND a.prid = g.prid AND a.clct = g.clct', 'left');

        $this->db->join(" (SELECT h.brco, h.prid, h.clct, SUM(h.bcap) AS s3
						FROM acc_day_bal h
						WHERE h.cdte = '$ly1'
						GROUP BY h.brco, h.prid, h.clct) AS h", ' h.brco = a.brco AND a.prid = h.prid AND a.clct = h.clct ', 'left');

        $this->db->join(" (SELECT i.brco, i.prid, i.clct, SUM(i.tpcp) AS s4
						FROM acc_day_bal i
						WHERE i.cdte BETWEEN '$cy1' AND '$dt1'
						GROUP BY i.brco, i.prid, i.clct ) AS i", ' i.brco = a.brco AND a.prid = i.prid AND a.clct = i.clct ', 'left');


        $this->db->join(" (SELECT j.brco, j.prid, j.clct, SUM(j.tpcp) AS s5, SUM(j.iint) AS s7 
						FROM acc_day_bal j
						WHERE j.cdte BETWEEN '$frdt' AND '$todt'
						GROUP BY j.brco, j.prid, j.clct ) AS j", ' j.brco = a.brco AND a.prid = j.prid AND a.clct = j.clct ', 'left');


        $this->db->join(" (SELECT k.brco, k.prid, SUM(k.bcap) AS s6
						FROM acc_day_bal k
						WHERE k.cdte = '$me1'
						GROUP BY k.brco, k.prid ) AS k", ' k.brco = a.brco AND a.prid = k.prid ', 'left');


        if ($brn != 'all') {
            $this->db->where('a.brco', $brn);
        }

        if ($exc != 'all') {
            $this->db->where('a.clct', $exc);
        }

        $this->db->group_by('a.brco');
        $this->db->group_by('a.clct');


        /*if ($prtp != 'all') {
            $this->db->where('acc_day_bal.prid', $prtp);
        }*/

        //$this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

    }

    private function deplt_queryData()
    {
        $this->deplt_query();
        $i = 0;
        foreach ($this->cl_srch20 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch20) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr20[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order20)) {
            $order20 = $this->order20;
            $this->db->order_by(key($order20), $order20[key($order20)]);
        }
    }

    function get_deplt()
    {
        $this->deplt_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_deplt()
    {
        $this->deplt_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_deplt()
    {
        $this->deplt_query();
        return $this->db->count_all_results();
    }
// END DEPLETION
//
// RECEIPT XX
    var $cl_srchXH = array('brnm', 'acno', 'cuno', '', '', ''); //set column field database for datatable searchable
    var $cl_odrXH = array(null, 'brnm', 'acno', 'cuno', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $orderXH = array('cage' => 'asc'); // default order

    function rceipt_queryXH()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $rctp = $this->input->post('rctp');

        $this->db->select("receipt.* ,micr_crt.acno, brch_mas.brcd,user_mas.usnm ,cus_mas.init,cus_mas.cuno, DATE_FORMAT(receipt.crdt, '%Y-%m-%d') AS crdt  ");
        $this->db->from("receipt");
        $this->db->join('brch_mas', 'brch_mas.brid = receipt.brco');
        $this->db->join('user_mas', 'user_mas.auid = receipt.crby');
        $this->db->join('micr_crt', 'micr_crt.lnid = receipt.rfno', 'left');
        $this->db->join('cus_mas', 'micr_crt.apid = cus_mas.cuid');

        if ($brn != 'all') {
            $this->db->where('receipt.brco', $brn);
        }
        if ($rctp != 'all') {
            $this->db->where('receipt.retp', $rctp);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }

        $this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

    }

    private function rceipt_queryDataHX()
    {
        $this->rceipt_query();
        $i = 0;
        foreach ($this->cl_srch1 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order1)) {
            $order1 = $this->order1;
            $this->db->order_by(key($order1), $order1[key($order1)]);
        }
    }

    function get_rceiptXH()
    {
        $this->rceipt_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_rceiptHX()
    {
        $this->rceipt_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_rceiptHX()
    {
        // $this->db->from($this->table);
        $this->rceipt_query();
        return $this->db->count_all_results();
    }
// END RECEIPT
//
// LOAN
    var $cl_srch21 = array('anic', 'micr_crt.acno', 'init', 'inam'); //set column field database for datatable searchable
    var $cl_odr21 = array(null, 'cnnm', 'init', 'anic', 'acno', 'prcd', 'loam', 'inam', 'lnpr', 'stnm', 'crdt', 'usr'); //set column field database for datatable orderable
    var $order21 = array('cage' => 'asc'); // default order

    function loan_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('ofc');
        $cen = $this->input->post('cnt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $stat = $this->input->post('stat');

        $this->db->select("micr_crt.acno,micr_crt.lnid,micr_crt.inam,micr_crt.loam,micr_crt.lntp,product.prcd,micr_crt.noin,micr_crt.lnpr,micr_crt.stat AS lnst,
        cus_mas.cuid,cus_mas.grno, brch_mas.brcd,CONCAT(user_mas.usnm) AS usr,  micr_crt.apdt,micr_crt.prva,
        cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.hoad,cus_mas.mobi,cen_mas.cnnm,prdt_typ.pymd,loan_stat.stnm, DATE_FORMAT(micr_crt.crdt, '%Y-%m-%d') AS crdt");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        $this->db->join('product', 'product.auid = micr_crt.prid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat ');

        if ($stat != 'all') {
            if ($stat == 'tpup') {
                $this->db->where('micr_crt.prva != 0');
            }else{
                $this->db->where('micr_crt.stat', $stat);
            }
        }
        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt ', $cen);
        }
        $this->db->where("DATE_FORMAT(micr_crt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

    }

    private function loan_queryData()
    {
        $this->loan_query();
        $i = 0;
        foreach ($this->cl_srch21 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->cl_srch21) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr21[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order21)) {
            $order21 = $this->order21;
            $this->db->order_by(key($order21), $order21[key($order21)]);
        }
    }

    function get_loan()
    {
        $this->loan_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_loan()
    {
        $this->loan_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_loan()
    {
        $this->loan_query();
        return $this->db->count_all_results();
    }
// END LOAN
//


}

?>
