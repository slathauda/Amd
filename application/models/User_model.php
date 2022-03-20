<?php

class User_model extends CI_Model
{

    //makes this to work with columns and without where,limit and offset
    //var $table = 'acc_leg';
    // var $column_order = array(null, 'acid', 'acdt', 'trtp', 'rfno', 'rfna', 'dcrp', 'dbam', 'cram'); //set column field database for datatable orderable
    // var $column_search = array('acid', 'acdt', 'trtp', 'rfno', 'rfna', 'dcrp', 'dbam', 'cram'); //set column field database for datatable searchable
    // var $order = array('acid' => 'asc'); // default order

    function ccsh_query()
    {
        $brn = $this->input->post('brn');
        $frdt = $this->input->post('frdt');
        $todt4 = $this->input->post('todt');

        $this->db->select("*");
        $this->db->from("acc_leg al");
        $this->db->where('al.acst LIKE', '%Cash Book%');
        $this->db->where("DATE_FORMAT(al.acdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt4'");
        if ($brn != 'all') {
            $this->db->where('al.brno', $brn);
        }
    }

    private function get_dataCashbook_query()
    {
        $this->ccsh_query();
        $i = 0;
        foreach ($this->column_search as $item) // loop column
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

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
    }

    function get_dataCashbook()
    {
        $this->get_dataCashbook_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->get_dataCashbook_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->ccsh_query();
        return $this->db->count_all_results();
    }


    //  Center Details
    var $cl_srch1 = array('cnnm'); //set column field database for datatable searchable
    var $cl_odr1 = array(null, 'cnnm', 'brnm', 'usnm', 'cday', 'cday', 'cday', 'cday', 'cday', 'cday', 'cday'); //set column field database for datatable orderable
    var $order = array('cnnm' => 'asc'); // default order

    function tdySles_query()
    {
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("invoice.* , user_mas.usnm, user_mas.lnme ");
        $this->db->from("invoice");
        $this->db->join('user_mas', 'user_mas.auid = invoice.crby ');
        $this->db->where("DATE_FORMAT(invoice.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
    }

    private function tdySles_queryData()
    {
        $this->tdySles_query();
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
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_tdySles()
    {
        $this->tdySles_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_sles()
    {
        $this->tdySles_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_sles()
    {
        // $this->db->from($this->table);
        $this->tdySles_query();
        return $this->db->count_all_results();
    }


    // center leader
    var $cl_srch2 = array('cnnm'); //set column field database for datatable searchable
    var $cl_odr2 = array(null, 'cnnm', 'grno', 'cuno', 'init', 'mobi', 'cutp', ''); //set column field database for datatable orderable
    var $order2 = array('cnnm' => 'asc'); // default order

    function cenLedDet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');

        $this->db->select("cus_mas.cuid,cus_mas.cuno,cus_mas.init,cus_mas.mobi,cus_type.cutp,grup_mas.grno,cen_mas.cnnm,cen_mas.caid,CONCAT(user_mas.usnm) AS exe");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->join('user_mas', 'user_mas.auid = cen_mas.usid ');
        $this->db->where('cus_mas.rgtp', 1);
        $this->db->where('cus_mas.stat IN(3,4)');

        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cen_mas.usid', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt ', $cen);
        }
        $this->db->order_by('grup_mas.grno', 'ASC'); //ASC  DESC
        $this->db->order_by('cus_mas.cuno', 'ASC'); //ASC  DESC

    }

    private function cenLedDet_queryData()
    {
        $this->cenLedDet_query();
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

    function get_cenLedrDtils()
    {
        $this->cenLedDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_cnldr()
    {
        $this->cenLedDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cnldr()
    {
        // $this->db->from($this->table);
        $this->cenLedDet_query();
        return $this->db->count_all_results();
    }

    // end center leader

    // Group
    var $cl_srch3 = array('cnnm'); //set column field database for datatable searchable
    var $cl_odr3 = array(null, 'cnnm', 'grno', 'cuno', 'init', 'mobi', 'cutp', ''); //set column field database for datatable orderable
    var $order3 = array('cnnm' => 'asc'); // default order

    function grup_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');

        $this->db->select("grup_mas.*,cen_mas.cnnm,sys_stat.stnm,cus_mas.init, brch_mas.brnm,
        (SELECT COUNT(*) AS grcust FROM `cus_mas` AS aa WHERE stat IN(1,3,4) AND aa.ccnt = grup_mas.cnid AND aa.grno = grup_mas.grpid) AS grcust,CONCAT(user_mas.usnm) AS exe");
        $this->db->from("grup_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = grup_mas.cnid ');
        $this->db->join('cus_mas', 'cus_mas.cuid = grup_mas.grld ', 'left');
        $this->db->join('sys_stat', 'sys_stat.stid = grup_mas.stat ');
        $this->db->join('user_mas', 'user_mas.auid = cen_mas.usid ');
        $this->db->join('brch_mas', 'brch_mas.brid = cen_mas.brco ');

        if ($brn != 'all') {
            $this->db->where('cen_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cen_mas.usid', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('grup_mas.cnid ', $cen);
        }
        // $this->db->order_by('recipts.crdt', 'ASC'); //ASC  DESC

    }

    private function grup_queryData()
    {
        $this->grup_query();
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

    function get_grupDtils()
    {
        $this->grup_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function filtered_grp()
    {
        $this->grup_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function all_grp()
    {
        // $this->db->from($this->table);
        $this->grup_query();
        return $this->db->count_all_results();
    }

    // end center leader

    // Group leader
    var $cl_srch4 = array('cnnm'); //set column field database for datatable searchable
    var $cl_odr4 = array(null, 'cnnm', 'grno', 'cuno', 'init', 'mobi', 'cutp', ''); //set column field database for datatable orderable
    var $order4 = array('cnnm' => 'asc'); // default order

    function grpLedDet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $grp = $this->input->post('grp');

        $this->db->select("cus_mas.cuid,cus_mas.cuno,cus_mas.init,cus_mas.mobi,cus_mas.metp,cus_type.cutp,grup_mas.grno,cen_mas.cnnm,grup_mas.grpid,CONCAT(user_mas.usnm) AS exe");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->join('user_mas', 'user_mas.auid = cen_mas.usid ');

        $this->db->where('cus_mas.stat IN(3,4)');
        $this->db->where('grup_mas.stat ', 1);
        $this->db->where('cus_mas.rgtp', 1);

        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cen_mas.usid', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt ', $cen);
        }
        if ($grp != 'all') {
            $this->db->where('cus_mas.grno ', $grp);
        }
        $this->db->order_by('grup_mas.grno', 'ASC'); //ASC  DESC
        $this->db->order_by('cus_mas.cuno', 'ASC'); //ASC  DESC

    }

    private function grpLedDet_queryData()
    {
        $this->grpLedDet_query();
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

                if (count($this->cl_srch2) - 1 == $i) //last loop
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

    function get_grupLedrDtils()
    {
        $this->grpLedDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_grpldr()
    {
        $this->grpLedDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_grpldr()
    {
        // $this->db->from($this->table);
        $this->grpLedDet_query();
        return $this->db->count_all_results();
    }
    // end center leader

    // customer
    var $cl_srch5 = array('usnm', 'lnme', 'cnnm', 'mobi', 'anic', 'cuno', 'init'); //set column field database for datatable searchable
    var $cl_odr5 = array(null, 'brnm', 'exc', 'cnnm', 'cuno', 'init', 'anic', 'mobi', 'metp', 'stat', ''); //set column field database for datatable orderable
    var $order5 = array('stat' => 'asc'); // default order

    function custDet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');
        $grtp = $this->input->post('grtp');

        $this->db->select("cus_mas.rgtp,cus_mas.cuid, brch_mas.brcd,CONCAT(user_mas.usnm ) AS exc, cus_mas.trst,  cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.funm,cus_mas.cuty,cus_mas.hoad,cus_mas.mobi,cus_mas.stat,grup_mas.grno,cen_mas.cnnm,cust_stat.stnm");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->join('cust_stat', 'cust_stat.stid = cus_mas.stat ');

        $this->db->where('grup_mas.stat ', 1);
        if ($grtp != 'all') {
            $this->db->where('cus_mas.rgtp', $grtp);
        }

        if ($stat != 'all') {
            $this->db->where('cus_mas.stat', $stat);
        }
        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cen_mas.usid', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt ', $cen);
        }
        // $this->db->order_by('recipts.crdt', 'ASC'); //ASC  DESC
    }

    private function custDet_queryData()
    {
        $this->custDet_query();
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

    function get_customerDtils()
    {
        $this->custDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_cust()
    {
        $this->custDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cust()
    {
        // $this->db->from($this->table);
        $this->custDet_query();
        return $this->db->count_all_results();
    }
    // end customer

    // LOAN
    var $cl_srch6 = array('cnnm', 'init', 'cuno', 'micr_crt.acno', 'loam'); //set column field database for datatable searchable
    var $cl_odr6 = array(null, 'cnnm', 'init', 'cuno', 'acno', 'prcd', 'loam', 'noin', 'lnst', 'micr_crt.stat', 'crdt', ''); //set column field database for datatable orderable
    var $order6 = array('crdt' => 'desc'); // default order

    function loanDet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("micr_crt.acno,micr_crt.lnid,micr_crt.inam,micr_crt.loam,micr_crt.lntp,product.prcd,micr_crt.noin,micr_crt.lnpr,micr_crt.stat AS lnst,
        cus_mas.cuid,cus_mas.grno, brch_mas.brcd,CONCAT(user_mas.usnm) AS exc,  micr_crt.apdt,micr_crt.prva,
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
            $this->db->where('micr_crt.stat', $stat);
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
        $this->db->where("micr_crt.lntp IN(1,2) "); // ONLY PRODUCT & DYNAMIC LOAN

        switch ($stat) {
            case 2:     // APPROVAL LOAN
                $this->db->where("DATE_FORMAT(micr_crt.apdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
                break;
            case 3:     // FINISH LOAN
                $this->db->where("DATE_FORMAT(micr_crt.lspd, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
                break;
            case 5:     // DISBURS LOAN
                $this->db->where("DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
                break;
            default:
                $this->db->where("DATE_FORMAT(micr_crt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
        }

        //$this->db->where('micr_crt.prva ', 1);
        //$this->db->order_by('micr_crt.lnid', 'DESC'); //ASC  DESC
    }

    private function loanDet_queryData()
    {
        $this->loanDet_query();
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

    function get_loanDtils()
    {
        $this->loanDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_loan()
    {
        $this->loanDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_loan()
    {
        // $this->db->from($this->table);
        $this->loanDet_query();
        return $this->db->count_all_results();
    }
    // END LOAN

    // customer transfer
    var $cl_srch7 = array('cnnm', 'mobi', 'anic', 'cuno'); //set column field database for datatable searchable
    var $cl_odr7 = array(null, 'cuno', 'init', 'anic', '', '', '', '', 'stat', ''); //set column field database for datatable orderable
    var $order7 = array('stat' => 'asc'); // default order

    function custTransf_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        //$stat = $this->input->post('stat');

        $this->db->select("cus_mas.cuid, brch_mas.brnm,CONCAT(user_mas.usnm) AS exc,cus_mas.trst ,  cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.cuty,cus_mas.hoad,cus_mas.mobi,cus_mas.stat,grup_mas.grno,cen_mas.cnnm,cust_stat.stnm");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->join('cust_stat', 'cust_stat.stid = cus_mas.stat ');
        //$this->db->join('cus_mas_base', 'cust_stat.stid = cus_mas.stat ');


        $this->db->where('cus_mas.rgtp', 1);
        $this->db->where('cus_mas.stat IN(3,4)');
//        if ($stat != 'all') {
//            $this->db->where('cus_mas.stat', $stat);
//        }
        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cen_mas.usid', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt ', $cen);
        }
        // $this->db->order_by('recipts.crdt', 'ASC'); //ASC  DESC
    }

    private function custTransf_queryData()
    {
        $this->custTransf_query();
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

    function get_customerTransfList()
    {
        $this->custTransf_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_custTransf()
    {
        $this->custTransf_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_custTransf()
    {
        // $this->db->from($this->table);
        $this->custTransf_query();
        return $this->db->count_all_results();
    }
    // end customer

    // customer transfer request
    var $cl_srch8 = array('cnnm', 'mobi', 'anic', 'cuno'); //set column field database for datatable searchable
    var $cl_odr8 = array(null, 'cuno', 'init', 'anic', '', '', '', '', 'stat', ''); //set column field database for datatable orderable
    var $order8 = array('stat' => 'asc'); // default order

    function custRqust_query()
    {
        $brn = $this->input->post('brn');
        // $exc = $this->input->post('exc');
        // $cen = $this->input->post('cen');
        //$stat = $this->input->post('stat');

        $this->db->select("cus_mas.cuno,cus_mas.init,cus_mas.brco,cus_mas.hoad,cus_mas.anic,brch_mas.brnm,a.rqusr,b.rqbrn,cus_mas.stat, cus_mas_base.auid,cus_mas_base.cuid,cus_mas_base.rqrs ,c.apusr ");

        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ', 'left');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco', 'left');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec', 'left');
        $this->db->join('cus_mas_base', 'cus_mas_base.cuid = cus_mas.cuid ');
        $this->db->join("(SELECT  a.auid,CONCAT(a.usnm ) AS rqusr
                         FROM `user_mas` AS a   ) AS a", 'a.auid = cus_mas_base.rqby');

        $this->db->join("(SELECT  b.brid,b.brnm AS rqbrn
                         FROM `brch_mas` AS b   ) AS b", 'b.brid = cus_mas_base.rqbr');

        $this->db->join("(SELECT  c.auid,CONCAT(c.usnm ) AS apusr
                         FROM `user_mas` AS c   ) AS c", 'c.auid = cus_mas_base.apby', 'left');

        $this->db->where('cus_mas_base.stat IN(9,10)');

        if ($brn != 'all') {
            $this->db->where('cus_mas_base.rqbr', $brn);
        }

    }

    private function custRqust_queryData()
    {
        $this->custRqust_query();
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

                if (count($this->cl_srch2) - 1 == $i) //last loop
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

    function get_customerRqustList()
    {
        $this->custRqust_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_custRqust()
    {
        $this->custRqust_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_custRqust()
    {
        // $this->db->from($this->table);
        $this->custRqust_query();
        return $this->db->count_all_results();
    }
    // end transfer request
    //
    // customer transfer responed
    var $cl_srch9 = array('cnnm', 'mobi', 'anic', 'cuno'); //set column field database for datatable searchable
    var $cl_odr9 = array(null, 'cuno', 'init', 'anic', '', '', '', '', 'stat', ''); //set column field database for datatable orderable
    var $order9 = array('stat' => 'asc'); // default order

    function custResp_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        //$stat = $this->input->post('stat');

        $this->db->select("cus_mas.cuno,cus_mas.init,cus_mas.hoad,cus_mas.anic,brch_mas.brnm,a.rqusr,b.rqbrn,cus_mas.stat, cus_mas_base.auid,cus_mas_base.cuid,cus_mas_base.rqrs ,c.apusr ");

        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ', 'left');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco', 'left');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec', 'left');
        $this->db->join('cus_mas_base', 'cus_mas_base.cuid = cus_mas.cuid ');
        $this->db->join("(SELECT  a.auid,CONCAT(a.usnm ) AS rqusr
                         FROM `user_mas` AS a   ) AS a", 'a.auid = cus_mas_base.rqby');

        $this->db->join("(SELECT  b.brid,b.brnm AS rqbrn
                         FROM `brch_mas` AS b   ) AS b", 'b.brid = cus_mas_base.rqbr');

        $this->db->join("(SELECT  c.auid,CONCAT(c.usnm ) AS apusr
                         FROM `user_mas` AS c   ) AS c", 'c.auid = cus_mas_base.apby', 'left');

        $this->db->where('cus_mas_base.stat IN(9,10)');

        if ($brn != 'all') {
            $this->db->where('cus_mas_base.brid', $brn);
        }

    }

    private function custRespnd_queryData()
    {
        $this->custResp_query();
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

                if (count($this->cl_srch2) - 1 == $i) //last loop
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

    function get_custRespndList()
    {
        $this->custRespnd_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_custResp()
    {
        $this->custRespnd_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_custResp()
    {
        // $this->db->from($this->table);
        $this->custResp_query();
        return $this->db->count_all_results();
    }
    // end transfer request
    //
    //
    // Repayment enter show loan details
    var $cl_srch10 = array('cnnm', 'mobi', 'anic', 'cuno'); //set column field database for datatable searchable
    var $cl_odr10 = array(null, 'grno', 'brcd', 'init', 'acno', 'anic', '', '', 'baln', ''); //set column field database for datatable orderable
    var $order10 = array('stat' => 'asc'); // default order

    function Rpymt_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $grp = $this->input->post('grp');
        $prd = $this->input->post('prd');
        $today = date("Y-m-d");

        $this->db->select("micr_crt.lnid,micr_crt.acno,(micr_crt.aboc + micr_crt.aboi) AS arre,micr_crt.inam,micr_crt.boc, micr_crt.boi,micr_crt.aboc ,
            micr_crt.aboi,micr_crt.avpe, micr_crt.crdt, micr_crt.avdb, micr_crt.avcr,
            (( micr_crt.avdb + micr_crt.avpe + micr_crt.boc + micr_crt.boi) - micr_crt.avcr ) AS baln ,
            cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg, cen_mas.cnnm ,brch_mas.brcd,user_mas.fnme,prdt_typ.prtp,grup_mas.grno,   
            IFNULL( FORMAT(a.tdpy, 2), '0')  AS tdpy  ,micr_crt.lspa  ");
        /* IFNULL((SELECT r.ramt
                        FROM `receipt` AS r
                        WHERE  r.retp = 2 AND r.stat IN(1,2) AND r.rfno = micr_crt.lnid
                        GROUP BY r.rfno
                        ORDER BY `reid` DESC LIMIT 1),'0') AS lspmt  */
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno');

        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join("(SELECT rfno,SUM(ramt)  AS tdpy
                          FROM `receipt` AS a  
                          WHERE stat IN(1,2) AND a.retp = '2' AND DATE_FORMAT(a.crdt, '%Y-%m-%d') = '$today'
                           GROUP BY rfno) AS a", 'a.rfno = micr_crt.lnid', 'left');

        //$this->db->join("(SELECT  c.auid,CONCAT(c.fnme, ' ', c.lnme ) AS apusr
        //                FROM `user_mas` AS c   ) AS c", 'c.auid = cus_mas_base.apby', 'left');

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
        if ($grp != 'all') {
            $this->db->where('cus_mas.grno', $grp);
        }
        if ($prd != 'all') {
            $this->db->where('micr_crt.prdtp', $prd);
        }
        $this->db->where('micr_crt.stat', 5);
    }

    private function Rpymt_queryData()
    {
        $this->Rpymt_query();
        $i = 0;
        foreach ($this->cl_srch10 as $item) // loop column
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

                if (count($this->cl_srch10) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr10[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order10)) {
            $order10 = $this->order10;
            $this->db->order_by(key($order10), $order10[key($order10)]);
        }
    }

    function get_loanRpymtDtils()
    {
        $this->Rpymt_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_Rpymt()
    {
        $this->Rpymt_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_Rpymt()
    {
        // $this->db->from($this->table);
        $this->Rpymt_query();
        return $this->db->count_all_results();
    }
    // end Repayment Enter
    //
    //
    // Credit Voucher Details
    var $cl_srch11 = array('cnnm', 'mobi', 'anic', 'cuno', 'micr_crt.acno', 'vuno'); //set column field database for datatable searchable
    var $cl_odr11 = array(null, 'cuno', 'init', 'anic', '', '', '', '', 'vuno', 'voucher.stat', ''); //set column field database for datatable orderable
    var $order11 = array('stat' => 'asc'); // default order

    function crdvou_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        //$grp = $this->input->post('grp');
        //$prd = $this->input->post('prd');
        //$today = date("Y-m-d");

        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.noin,micr_crt.crdt,micr_crt.cvpt,micr_crt.agno, micr_crt.chmd,micr_crt.chpy,
        cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg, cen_mas.cnnm ,brch_mas.brcd,user_mas.fnme,prdt_typ.prtp,prdt_typ.pymd,product.prcd ,
          voucher.vuno , micr_crt.docg,micr_crt.incg,");

        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        $this->db->join('voucher', 'voucher.void = micr_crt.vpno');

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }

        $this->db->where('micr_crt.vpno != 0');
        //$this->db->where('micr_crt.stat', 2);
        $this->db->where('voucher.stat', 2);

        //$this->db->where('micr_crt.stat IN(2,5)');
    }

    private function crdvou_queryData()
    {
        $this->crdvou_query();
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

    function get_crdvouDtils()
    {
        $this->crdvou_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_crdvou()
    {
        $this->crdvou_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_crdvou()
    {
        // $this->db->from($this->table);
        $this->crdvou_query();
        return $this->db->count_all_results();
    }
    // end Credit voucher
    //
    // Group Voucher
    var $cl_srch12 = array('cnnm', 'mobi', 'anic', 'cuno', 'micr_crt.acno'); //set column field database for datatable searchable
    var $cl_odr12 = array(null, 'cuno', 'init', 'anic', '', '', '', '', 'stat', ''); //set column field database for datatable orderable
    var $order12 = array('stat' => 'asc'); // default order

    function grupvou_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        //$grp = $this->input->post('grp');
        //$prd = $this->input->post('prd');
        //$today = date("Y-m-d");


        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.lnpr,micr_crt.crdt,micr_crt.docg,micr_crt.incg,micr_crt.chmd,
        cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.bkdt,cus_mas.cuid, cen_mas.cnnm ,brch_mas.brcd,user_mas.fnme,prdt_typ.prtp ,
        micr_crt.prva, ( SELECT blam  FROM `topup_loans` WHERE stat = 1 AND tpnm = lnid) AS tpbal, ");

        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');

        // IF TOPUP LOANS ONLY
        //$this->db->join('topup_loans', 'topup_loans.prid = micr_crt.prdtp');


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
        $this->db->where('micr_crt.vpno', 0);
        //$this->db->where('micr_crt.vpno', null);


    }

    private function grupvou_queryData()
    {
        $this->grupvou_query();
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

    function get_grupVou()
    {
        $this->grupvou_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_grupvou()
    {
        $this->grupvou_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_grupvou()
    {
        // $this->db->from($this->table);
        $this->grupvou_query();
        return $this->db->count_all_results();
    }
    // end Group Voucher
    //
    // Voucher
    var $cl_srch13 = array('voucher.vuno', 'pynm', 'vuam'); //set column field database for datatable searchable
    var $cl_odr13 = array(null, '', 'vcrdt', 'vuno', '', 'mode', 'dsnm', 'vuam', 'stat', ''); //set column field database for datatable orderable
    var $order13 = array('vcrdt' => 'desc'); // default order

    function vou_query()
    {
        $brn = $this->input->post('brn');
        $pytp = $this->input->post('pytp'); // payment type (cash/ chq ... )
        $vutp = $this->input->post('vutp'); // voucher type (credit/group in cash/genaral)
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("voucher.*,DATE_FORMAT(voucher.crdt, '%Y-%m-%d') AS vcrdt,  brch_mas.brnm ,pay_terms.tem_name,chq_issu.cpnt,chq_issu.stat AS chst   ");
        $this->db->from("voucher");
        $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void');
        $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp');
        $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco');
        $this->db->join('chq_issu', 'chq_issu.vuid = voucher.void', 'left');
        $this->db->group_by('vuno');
        $this->db->where("DATE_FORMAT(voucher.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

        if ($brn != 'all') {
            $this->db->where('voucher.brco', $brn);
        }
        if ($vutp != 'all') {
            $this->db->where('voucher.mode', $vutp);
        }
        if ($pytp != 'all') {
            $this->db->where('voucher.pmtp', $pytp);
        }
        $this->db->where('voucher.mode NOT IN(4,5)');
        $this->db->where('voucher.stat IN(0,1,2)');
    }

    private function vou_queryData()
    {
        $this->vou_query();
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

    function get_Vou()
    {
        $this->vou_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_vou()
    {
        $this->vou_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_vou()
    {
        // $this->db->from($this->table);
        $this->vou_query();
        return $this->db->count_all_results();
    }
    // end Voucher
    //
    // Cheque
    var $cl_srch14 = array('vuno', 'cqno'); //set column field database for datatable searchable
    var $cl_odr14 = array(null, 'brnm', 'vuno', 'mode', 'pynm', 'cqno', 'cqdt', 'cqam', 'stat', ''); //set column field database for datatable orderable
    var $order14 = array('stat' => 'asc'); // default order

    function chq_query()
    {
        $brn = $this->input->post('brn');
        $stat = $this->input->post('stat'); // chq stat
        $vutp = $this->input->post('vutp'); // voucher type (credit/group in cash/genaral)
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("chq_issu.*,  brch_mas.brnm ,voucher.vuno,voucher.pynm,voucher.void,voucher.mode ,bnk_accunt.acnm ");
        $this->db->from("chq_issu");
        $this->db->join('voucher', 'voucher.void = chq_issu.vuid');
        $this->db->join('brch_mas', 'brch_mas.brid = chq_issu.brco');
        $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid');

        $this->db->where("DATE_FORMAT(chq_issu.isdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
        //$this->db->where('voucher.stat', 2);

        if ($brn != 'all') {
            $this->db->where('chq_issu.brco', $brn);
        }
        if ($vutp != 'all') {
            $this->db->where('chq_issu.chmd', $vutp);
        }
        if ($stat != 'all') {
            $this->db->where('chq_issu.stat', $stat);
        }

    }

    private function chq_queryData()
    {
        $this->chq_query();
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

    function get_chq()
    {
        $this->chq_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_chq()
    {
        $this->chq_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_chq()
    {
        // $this->db->from($this->table);
        $this->chq_query();
        return $this->db->count_all_results();
    }
    // end Cheque
    //
    // Guranter  upgrade
    var $cl_srch15 = array('usnm', 'lnme', 'cnnm', 'mobi', 'anic', 'cuno', 'init'); //set column field database for datatable searchable
    var $cl_odr15 = array(null, 'brnm', 'exc', 'cnnm', 'cuno', 'init', 'anic', 'mobi', 'metp', 'stat', ''); //set column field database for datatable orderable
    var $order15 = array('stat' => 'asc'); // default order

    function grnter_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');

        $this->db->select("cus_mas.cuid, brch_mas.brcd,CONCAT(user_mas.usnm ) AS exc, cus_mas.trst,cus_mas.rgtp,  cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.funm,cus_mas.cuty,cus_mas.hoad,cus_mas.mobi,cus_mas.stat,grup_mas.grno,cen_mas.cnnm,cust_stat.stnm");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->join('cust_stat', 'cust_stat.stid = cus_mas.stat ');


        $this->db->where('grup_mas.stat ', 1);
        //$this->db->where('cus_mas.cuty', 1);
        $this->db->where('cus_mas.stat IN(3,4)');

        if ($stat == 1) {
            $this->db->where('cus_mas.rgtp', 0);
        } else if ($stat == 2) {
            $this->db->join('upgrd_dtils', 'upgrd_dtils.upid = cus_mas.cuid ');
            $this->db->where('upgrd_dtils.uptp ', 1);
        }

        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cen_mas.usid', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt ', $cen);
        }
    }

    private function grnter_queryData()
    {
        $this->grnter_query();
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

    function get_gurnterDtils()
    {
        $this->grnter_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_grnt()
    {
        $this->grnter_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_grnt()
    {
        // $this->db->from($this->table);
        $this->grnter_query();
        return $this->db->count_all_results();
    }
    // end Guranter
    //
    // customer upgrade
    var $cl_srch16 = array('usnm', 'lnme', 'cnnm', 'mobi', 'anic', 'cuno', 'init'); //set column field database for datatable searchable
    var $cl_odr16 = array(null, 'brnm', 'exc', 'cnnm', 'cuno', 'init', 'anic', 'mobi', 'metp', 'stat', ''); //set column field database for datatable orderable
    var $order16 = array('stat' => 'asc'); // default order

    function nmcust_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');

        $this->db->select("cus_mas.cuid, brch_mas.brcd,CONCAT(user_mas.usnm ) AS exc, cus_mas.trst,  cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.funm,cus_mas.cuty,cus_mas.hoad,cus_mas.mobi,cus_mas.stat,grup_mas.grno,cen_mas.cnnm,cust_stat.stnm");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->join('cust_stat', 'cust_stat.stid = cus_mas.stat ');


        $this->db->where('grup_mas.stat ', 1);
        $this->db->where('cus_mas.cuty', 1);
        $this->db->where('cus_mas.stat IN(3,4)');
        $this->db->where('cus_mas.rgtp', 1);


        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cen_mas.usid', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt ', $cen);
        }
    }

    private function nmcust_queryData()
    {
        $this->nmcust_query();
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

    function get_nmcustDtils()
    {
        $this->nmcust_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_nmcust()
    {
        $this->nmcust_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_nmcust()
    {
        // $this->db->from($this->table);
        $this->nmcust_query();
        return $this->db->count_all_results();
    }
    // end Guranter
    //
    //
    // Disbursement Loan Check
    var $cl_srch19 = array('cnnm', 'mobi', 'anic', 'cuno'); //set column field database for datatable searchable
    var $cl_odr19 = array(null, 'cuno', 'init', 'anic', '', '', '', '', 'stat', 'cvdt'); //set column field database for datatable orderable
    var $order19 = array('stat' => 'asc'); // default order

    function disbursLoan_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');
        //$prd = $this->input->post('prd');


        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam, micr_crt.noin,micr_crt.crdt,micr_crt.cvpt,micr_crt.agno,micr_crt.ckby, DATE_FORMAT(micr_crt.ckdt, '%Y-%m-%d') AS ckdt, DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') AS dsdt,
        cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,cus_mas.uimg, cen_mas.cnnm ,brch_mas.brcd,prdt_typ.prtp,prdt_typ.pymd,product.prcd, IFNULL(CONCAT(user_mas.usnm),' - ') AS chkby ");

        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.ckby', 'left');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp');
        $this->db->join('product', 'product.auid = micr_crt.prid');
        //$this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat');

        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
        if ($stat != 'all') {
            if ($stat == 0) {
                $this->db->where('micr_crt.ckby', 0);
            } else {
                $this->db->where("micr_crt.ckby != 0");
            }
        }

        $this->db->where('micr_crt.stat', 5);
    }

    private function disbursLoan_queryData()
    {
        $this->disbursLoan_query();
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

    function get_disbursLoan()
    {
        $this->disbursLoan_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_disbursLoan()
    {
        $this->disbursLoan_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_disbursLoan()
    {
        $this->disbursLoan_query();
        return $this->db->count_all_results();
    }
    // end Credit voucher
    //
    //
    // Repayment enter show loan details
    var $cl_srch20 = array('cnnm', 'acno', 'anic', 'cuno', 'reno', 'ramt', 'usnm'); //set column field database for datatable searchable
    var $cl_odr20 = array(null, '', 'init', 'cuno', 'anic', 'acno', 'reno', 'ramt', 'crdt', ''); //set column field database for datatable orderable
    var $order20 = array('crdt' => 'asc'); // default order

    function recpt_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $todt = $this->input->post('todt');

        $this->db->select("micr_crt.lnid,micr_crt.acno,micr_crt.acno,micr_crt.brco AS lnbr, receipt.reno,receipt.ramt,receipt.crdt,receipt.reid,receipt.brco AS rcbr,
            cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi, cen_mas.cnnm ,brch_mas.brnm,CONCAT(user_mas.usnm) AS exe , micr_crt.stat, denm_details.stat AS dnst");

        $this->db->from("receipt");
        $this->db->join('brch_mas', 'brch_mas.brid = receipt.brco');
        $this->db->join('user_mas', 'user_mas.auid = receipt.crby');
        $this->db->join('micr_crt', 'micr_crt.lnid = receipt.rfno');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('denm_details', 'denm_details.dnid = receipt.dnid', 'left');

        if ($brn != 'all') {
            $this->db->where('receipt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('receipt.crby', $exc);
        }

        $this->db->where('receipt.retp', 2);
        $this->db->where('receipt.stat', 1);
        $this->db->where("DATE_FORMAT(receipt.crdt, '%Y-%m-%d') = '$todt'");
    }

    private function recpt_queryData()
    {
        $this->recpt_query();
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

    function get_RpymtDtils()
    {
        $this->recpt_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_recpt()
    {
        $this->recpt_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_recpt()
    {
        // $this->db->from($this->table);
        $this->recpt_query();
        return $this->db->count_all_results();
    }
    // end Repayment Enter
    //
    // Other payment
    var $cl_srch21 = array('brnm', 'acno', 'anic', 'cuno', 'modt', 'pymt'); //set column field database for datatable searchable
    var $cl_odr21 = array(null, '', 'init', 'cuno', 'anic', 'acno', 'reno', 'ramt', 'crdt', ''); //set column field database for datatable orderable
    var $order21 = array('crdt' => 'asc'); // default order

    function othrPymnt_query()
    {
        $brn = $this->input->post('brn');
        $pytp = $this->input->post('pytp');

        $this->db->select("oter_payment.*, micr_crt.lnid,micr_crt.acno,micr_crt.brco AS lnbr,chg_type.modt,
            cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi, brch_mas.brnm,CONCAT(user_mas.usnm) AS exe ");

        $this->db->from("oter_payment");
        $this->db->join('brch_mas', 'brch_mas.brid = oter_payment.pybr');
        $this->db->join('user_mas', 'user_mas.auid = oter_payment.crby');
        $this->db->join('micr_crt', 'micr_crt.lnid = oter_payment.lnid');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('chg_type', 'chg_type.chid = oter_payment.pytp');

        if ($brn != 'all') {
            $this->db->where('oter_payment.pybr', $brn);
        }
        if ($pytp != 'all') {
            $this->db->where('oter_payment.pytp', $pytp);
        }
    }

    private function othrPymnt_queryData()
    {
        $this->othrPymnt_query();
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

    function get_othrPymnt()
    {
        $this->othrPymnt_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_otpymt()
    {
        $this->othrPymnt_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_otpymt()
    {
        // $this->db->from($this->table);
        $this->othrPymnt_query();
        return $this->db->count_all_results();
    }
    // end Other payment
    //
    // BANK CASH
    var $cl_srch22 = array('brnm', 'acno', 'anic', 'cuno', 'modt', 'pymt'); //set column field database for datatable searchable
    var $cl_odr22 = array(null, '', 'init', 'cuno', 'anic', 'acno', 'reno', 'ramt', 'crdt', ''); //set column field database for datatable orderable
    var $order22 = array('crdt' => 'asc'); // default order

    function bankCash_query()
    {
        $brch = $this->input->post('brch');
        $bkid = $this->input->post('bkid');

        $this->db->select("bnk_trans.*, bnk_names.bknm,brch_mas.brnm,bnk_accunt.acnm,bnk_accunt.acno ,
         CONCAT(user_mas.usnm) AS exe");
        $this->db->from("bnk_trans");
        $this->db->join('brch_mas', 'brch_mas.brid = bnk_trans.brid');
        $this->db->join('bnk_accunt', 'bnk_accunt.acid = bnk_trans.acid');
        $this->db->join('bnk_names', 'bnk_names.bkid = bnk_accunt.bkid');
        $this->db->join('user_mas', 'user_mas.auid = bnk_trans.crby');

        if ($brch != 'all') {
            $this->db->where('bnk_trans.brid', $brch);
        }
        if ($bkid != 'all') {
            $this->db->where('bnk_trans.acid', $bkid);
        }
    }

    private function bankCash_queryData()
    {
        $this->bankCash_query();
        $i = 0;
        foreach ($this->cl_srch22 as $item) // loop column
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
                if (count($this->cl_srch22) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr22[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order22)) {
            $order22 = $this->order22;
            $this->db->order_by(key($order22), $order22[key($order22)]);
        }
    }

    function get_bankCash()
    {
        $this->bankCash_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_bankCash()
    {
        $this->bankCash_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_bankCash()
    {
        $this->bankCash_query();
        return $this->db->count_all_results();
    }
    // END BANK CASH
    //
    // ISSUE CHEQUE
    var $cl_srch23 = array('acno', 'cqno'); //set column field database for datatable searchable
    var $cl_odr23 = array(null, 'brnm', 'bknm', 'acnm', 'acno', 'cqno', 'cqdt', 'cqam', 'stat', ''); //set column field database for datatable orderable
    var $order23 = array('stat' => 'asc'); // default order

    function isueeChq_query()
    {
        $brn = $this->input->post('brn');
        $bkac = $this->input->post('bkac'); // bank account

        $this->db->select("chq_issu.*, brch_mas.brnm ,bnk_accunt.acnm ,bnk_accunt.acno,bnk_names.bknm,
        IF(DATE_FORMAT(chq_issu.cqdt, '%Y-%m-%d') = '0000-00-00' ,' - ',DATE_FORMAT(chq_issu.cqdt, '%Y-%m-%d')) AS ncqdt ");
        $this->db->from("chq_issu");
        $this->db->join('brch_mas', 'brch_mas.brid = chq_issu.brco');
        $this->db->join('bnk_accunt', 'bnk_accunt.acid = chq_issu.accid');
        $this->db->join('bnk_names', 'bnk_names.bkid = bnk_accunt.bkid');


        if ($brn != 'all') {
            $this->db->where('chq_issu.brco', $brn);
        }
        if ($bkac != 'all') {
            $this->db->where('chq_issu.accid', $bkac);
        }
    }

    private function isueeChq_queryData()
    {
        $this->isueeChq_query();
        $i = 0;
        foreach ($this->cl_srch23 as $item) // loop column
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
                if (count($this->cl_srch23) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr23[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order23)) {
            $order23 = $this->order23;
            $this->db->order_by(key($order23), $order23[key($order23)]);
        }
    }

    function get_isueeChq()
    {
        $this->isueeChq_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_isueeChq()
    {
        $this->isueeChq_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_isueeChq()
    {
        $this->isueeChq_query();
        return $this->db->count_all_results();
    }
    // END ISSUE CHQ
    //
    // TERMINATION LOAN
    var $cl_srch24 = array('acno', 'cqno'); //set column field database for datatable searchable
    var $cl_odr24 = array(null, 'brnm', 'bknm', 'acnm', 'acno', 'cqno', 'cqdt', 'cqam', 'stat', ''); //set column field database for datatable orderable
    var $order24 = array('stat' => 'asc'); // default order

    function TrmiLn_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');

        $this->db->select("loan_trmi.*, brch_mas.brnm,cen_mas.cnnm ,micr_crt.lnid,micr_crt.acno,micr_crt.inam,micr_crt.loam,micr_crt.boi, micr_crt.boc, micr_crt.aboc, micr_crt.aboi, 
         micr_crt.avpe, cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi,
        DATE_FORMAT(loan_trmi.rqdt, '%Y-%m-%d') AS rqqdt,CONCAT(user_mas.usnm) AS exe ");

        $this->db->from("loan_trmi");
        $this->db->join('micr_crt', 'micr_crt.lnid = loan_trmi.lnid');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco');
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('user_mas', 'user_mas.auid = loan_trmi.rqby');

        //$this->db->join('bnk_names', 'bnk_names.bkid = bnk_accunt.bkid');


        if ($brn != 'all') {
            $this->db->where('micr_crt.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('micr_crt.clct', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('micr_crt.ccnt', $cen);
        }
    }

    private function TrmiLn_queryData()
    {
        $this->TrmiLn_query();
        $i = 0;
        foreach ($this->cl_srch24 as $item) // loop column
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
                if (count($this->cl_srch24) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr24[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order24)) {
            $order24 = $this->order24;
            $this->db->order_by(key($order24), $order24[key($order24)]);
        }
    }

    function get_TrmiLn()
    {
        $this->TrmiLn_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_TrmiLn()
    {
        $this->TrmiLn_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_TrmiLn()
    {
        $this->TrmiLn_query();
        return $this->db->count_all_results();
    }
    // END TERMINATION LOAN
    //
    // OTHER TRANSACTION
    var $cl_srch25 = array('voucher.vuno', 'pynm', 'vuam'); //set column field database for datatable searchable
    var $cl_odr25 = array(null, '', 'vcrdt', 'vuno', '', 'mode', 'dsnm', 'vuam', 'stat', ''); //set column field database for datatable orderable
    var $order25 = array('vcrdt' => 'desc'); // default order

    function otrTrn_query()
    {
        $brn = $this->input->post('brn');
        $pytp = $this->input->post('pytp'); // payment type (cash/ chq ... )
        $vutp = $this->input->post('vutp'); // voucher type (credit/group in cash/genaral)
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("onl_trns.*,voucher.vuno,voucher.void,voucher.pynm,DATE_FORMAT(voucher.crdt, '%Y-%m-%d') AS vcrdt,
          brch_mas.brcd ,pay_terms.tem_name,bnk_accunt.acnm ,bnk_accunt.acno ,cus_mas.anic ,cus_mas.cuno  ");
        $this->db->from("onl_trns");
        $this->db->join('voucher', 'voucher.void = onl_trns.vuid');
        //$this->db->join('vouc_des', 'vouc_des.vuid = voucher.void');
        $this->db->join('pay_terms', 'pay_terms.tmid = onl_trns.trtp');
        $this->db->join('brch_mas', 'brch_mas.brid = onl_trns.brco');

        $this->db->join('bnk_accunt', 'bnk_accunt.acid = onl_trns.accid');
        $this->db->join('cus_mas', 'cus_mas.cuid = onl_trns.tuid');


        $this->db->where("DATE_FORMAT(voucher.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

        if ($brn != 'all') {
            $this->db->where('onl_trns.brco', $brn);
        }
        if ($vutp != 'all') {
            $this->db->where('onl_trns.chmd', $vutp);
        }
        if ($pytp != 'all') {
            $this->db->where('onl_trns.trtp', $pytp);
        }
        //$this->db->where('onl_trns.stat IN(0,1,2)');
    }

    private function otrTrn_queryData()
    {
        $this->otrTrn_query();
        $i = 0;
        foreach ($this->cl_srch25 as $item) // loop column
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
                if (count($this->cl_srch25) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr25[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order25)) {
            $order25 = $this->order25;
            $this->db->order_by(key($order25), $order25[key($order25)]);
        }
    }

    function get_othrTrans()
    {
        $this->otrTrn_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_otrTrn()
    {
        $this->otrTrn_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_otrTrn()
    {
        // $this->db->from($this->table);
        $this->otrTrn_query();
        return $this->db->count_all_results();
    }
    // END OTHER TRANSACTION
    //
    // TOPUP LOAN
    var $cl_srch26 = array('cnnm', 'init', 'cuno', 'acno', 'loam'); //set column field database for datatable searchable
    var $cl_odr26 = array(null, 'cnnm', 'init', 'cuno', 'acno', 'prcd', 'loam', 'noin', 'lnst', ''); //set column field database for datatable orderable
    var $order26 = array('crdt' => 'desc'); // default order

    function TpuploanDet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');

        $this->db->select("micr_crt.acno,micr_crt.lnid,micr_crt.inam,micr_crt.loam,micr_crt.lntp,product.prcd,micr_crt.noin,micr_crt.lnpr,micr_crt.stat AS lnst,
        cus_mas.cuid,cus_mas.grno, brch_mas.brcd,CONCAT(user_mas.usnm) AS exc,  micr_crt.apdt,micr_crt.prva,
        cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.hoad,cus_mas.mobi,cen_mas.cnnm,prdt_typ.pymd,loan_stat.stnm");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        $this->db->join('product', 'product.auid = micr_crt.prid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('loan_stat', 'loan_stat.stid = micr_crt.stat ');

        if ($stat != 'all') {
            $this->db->where('micr_crt.stat', $stat);
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
        $this->db->where('micr_crt.prva != 0');
        $this->db->where('micr_crt.stat IN(1,2,4)');

        //$this->db->order_by('micr_crt.lnid', 'DESC'); //ASC  DESC

    }

    private function TpuploanDet_queryData()
    {
        $this->TpuploanDet_query();
        $i = 0;
        foreach ($this->cl_srch26 as $item) // loop column
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

                if (count($this->cl_srch26) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr26[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order26)) {
            $order26 = $this->order26;
            $this->db->order_by(key($order26), $order26[key($order26)]);
        }
    }

    function get_TpuploanDtils()
    {
        $this->TpuploanDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_loanTpup()
    {
        $this->TpuploanDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_loanTpup()
    {
        // $this->db->from($this->table);
        $this->TpuploanDet_query();
        return $this->db->count_all_results();
    }
    // end loan
    //
    // BDAY CUSTOMER LIST
    var $cl_srch27 = array('cnnm', 'init', 'cuno', 'acno', 'loam'); //set column field database for datatable searchable
    var $cl_odr27 = array(null, 'cnnm', 'init', 'cuno', 'acno', '', 'dobi', '', '', ''); //set column field database for datatable orderable
    var $order27 = array('crdt' => 'desc'); // default order

    function BadyCust_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('off');
        $cen = $this->input->post('cnt');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');
        $tdy = date("Y-m-d");

        $this->db->select(" cus_mas.cuid,cus_mas.grno, brch_mas.brcd,CONCAT(user_mas.usnm ) AS exc,
        cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.hoad,cus_mas.dobi,cus_mas.mobi,cen_mas.cnnm ,DATE_FORMAT(cus_mas.dobi,'%m-%d')  AS xx ,
        DATE_FORMAT( DATE_ADD(cus_mas.dobi, INTERVAL +7 DAY), '%m-%d')  AS yy      ");

        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco ');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec ');

        $this->db->where("DATE_FORMAT(cus_mas.dobi,'%m-%d') BETWEEN DATE_FORMAT('$frdt','%m-%d') AND  DATE_FORMAT( '$todt','%m-%d') 
         AND `cus_mas`.`cuid` NOT IN((SELECT aa.cuid  FROM `bday_gift` AS aa  WHERE  stat  IN(0,1)) ) ");

        if ($brn != 'all') {
            $this->db->where('cus_mas.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('cus_mas.exec', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('cus_mas.ccnt ', $cen);
        }
        //$this->db->order_by('micr_crt.lnid', 'DESC'); //ASC  DESC
    }

    private function BadyCust_queryData()
    {
        $this->BadyCust_query();
        $i = 0;
        foreach ($this->cl_srch27 as $item) // loop column
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

                if (count($this->cl_srch27) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr27[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order27)) {
            $order27 = $this->order27;
            $this->db->order_by(key($order27), $order27[key($order27)]);
        }
    }

    function get_BadyCust()
    {
        $this->BadyCust_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_BadyCust()
    {
        $this->BadyCust_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_BadyCust()
    {
        $this->BadyCust_query();
        return $this->db->count_all_results();
    }
    // END BDAY CUSTOMER LIST
    //
    // GIFT CUSTOMER LIST
    var $cl_srch28 = array('cnnm', 'init', 'cuno', 'mobi', 'gfnm'); //set column field database for datatable searchable
    var $cl_odr28 = array(null, 'cnnm', 'init', 'cuno', 'mobi', 'gfnm', '', '', 'rqdt', '', ''); //set column field database for datatable orderable
    var $order28 = array('crdt' => 'desc'); // default order

    function gift_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("bday_gift.*,brch_mas.brcd,cen_mas.cnnm , CONCAT(user_mas.usnm ) AS exc,
        cus_mas.anic,cus_mas.init,cus_mas.hoad,cus_mas.dobi,cus_mas.mobi,bday_gift_type.gfnm , DATE_FORMAT(bday_gift.rqdt,'%Y-%m-%d') AS rqsdt
        ");

        $this->db->from("bday_gift");
        $this->db->join('brch_mas', 'brch_mas.brid = bday_gift.brco ');
        $this->db->join('cen_mas', 'cen_mas.caid = bday_gift.ccnt ');
        $this->db->join('cus_mas', 'cus_mas.cuid = bday_gift.cuid');
        $this->db->join('bday_gift_stock', 'bday_gift_stock.auid = bday_gift.stid');
        $this->db->join('bday_gift_type', 'bday_gift_type.gfid = bday_gift_stock.gftp');
        $this->db->join('user_mas', 'user_mas.auid = bday_gift.rqby ');

        if ($brn != 'all') {
            $this->db->where('bday_gift.brco', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('bday_gift.exec', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('bday_gift.ccnt ', $cen);
        }
        $this->db->where("DATE_FORMAT(bday_gift.rqdt,'%Y-%m-%d') BETWEEN '$frdt' AND '$todt' ");

        //$this->db->order_by('micr_crt.lnid', 'DESC'); //ASC  DESC

    }

    private function gift_queryData()
    {
        $this->gift_query();
        $i = 0;
        foreach ($this->cl_srch28 as $item) // loop column
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

                if (count($this->cl_srch28) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr28[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order28)) {
            $order28 = $this->order28;
            $this->db->order_by(key($order28), $order28[key($order28)]);
        }
    }

    function get_gift()
    {
        $this->gift_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_gift()
    {
        $this->gift_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_gift()
    {
        $this->gift_query();
        return $this->db->count_all_results();
    }
// END GIFT CUSTOMER LIST
//
// PETTY CASH ACOOUNT
    var $cl_srch29 = array('cnnm', 'init', 'cuno', 'acno', 'loam'); //set column field database for datatable searchable
    var $cl_odr29 = array(null, 'rqbrn', 'ptamt', 'rqamt', 'crbal', '', '', 'rqdt'); //set column field database for datatable orderable
    var $order29 = array('crdt' => 'desc'); // default order

    function ptycash_query()
    {
        $brn = $this->input->post('brch');

        $this->db->select("pettycash_acc.*,brch_mas.brnm, user_mas.usnm");
        $this->db->from("pettycash_acc");
        $this->db->join('brch_mas', 'brch_mas.brid = pettycash_acc.rqbrn ');
        $this->db->join('user_mas', 'user_mas.auid = pettycash_acc.rqur ');

        if ($brn != 'all') {
            $this->db->where('pettycash_acc.rqbrn', $brn);
        }
    }

    private function ptycash_queryData()
    {
        $this->ptycash_query();
        $i = 0;
        foreach ($this->cl_srch29 as $item) // loop column
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

                if (count($this->cl_srch29) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr29[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order29)) {
            $order29 = $this->order29;
            $this->db->order_by(key($order29), $order29[key($order29)]);
        }
    }

    function get_ptycashDtils()
    {
        $this->ptycash_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_ptycash()
    {
        $this->ptycash_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_ptycash()
    {
        $this->ptycash_query();
        return $this->db->count_all_results();
    }

//  END PETTY CASH ACOOUNT
//
// PETTY CASH VOUCHER
    var $cl_srch30 = array('cnnm', 'init', 'cuno', 'acno', 'loam'); //set column field database for datatable searchable
    var $cl_odr30 = array(null, 'rqbrn', 'ptamt', 'rqamt', 'crbal', '', '', '', 'crdt', ''); //set column field database for datatable orderable
    var $order30 = array('crdt' => 'desc'); // default order

    function ptycashVouc_query()
    {
        $brn = $this->input->post('brch');

        $this->db->select("pettycash_vou.*, DATE_FORMAT(pettycash_vou.crdt, '%Y-%m-%d') AS crdt,brch_mas.brcd,  aa.rqusr, bb.crusr, accu_chrt.hadr");

        $this->db->from("pettycash_vou");
        $this->db->join('brch_mas', 'brch_mas.brid = pettycash_vou.brid ');
        $this->db->join('accu_chrt', 'accu_chrt.auid = pettycash_vou.pyac', 'left');

        $this->db->join("(SELECT auid,usnm  AS rqusr FROM `user_mas` )AS aa ", 'aa.auid = pettycash_vou.usrid', 'left'); // request user
        $this->db->join("(SELECT auid,usnm  AS crusr FROM `user_mas` )AS bb ", 'bb.auid = pettycash_vou.crby', 'left'); // crete user

        if ($brn != 'all') {
            $this->db->where('pettycash_vou.brid', $brn);
        }
    }

    private function ptycashVouc_queryData()
    {
        $this->ptycashVouc_query();
        $i = 0;
        foreach ($this->cl_srch30 as $item) // loop column
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

                if (count($this->cl_srch30) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr30[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order30)) {
            $order30 = $this->order30;
            $this->db->order_by(key($order30), $order30[key($order30)]);
        }
    }

    function get_ptycashVouc()
    {
        $this->ptycashVouc_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_ptycashVouc()
    {
        $this->ptycashVouc_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_ptycashVouc()
    {
        $this->ptycashVouc_query();
        return $this->db->count_all_results();
    }

//  END PETTY CASH ACOOUNT
//
// LOAN OTHER CHARGS
    var $cl_srch31 = array('brnm', 'acno', 'anic', 'cuno', 'modt', 'pymt'); //set column field database for datatable searchable
    var $cl_odr31 = array(null, '', 'init', 'cuno', 'anic', 'acno', 'reno', 'ramt', 'crdt', ''); //set column field database for datatable orderable
    var $order31 = array('crdt' => 'asc'); // default order

    function loanChargs_query()
    {
        $brn = $this->input->post('brn');
        $pytp = $this->input->post('pytp');

        $this->db->select("oter_charges.*, micr_crt.lnid,micr_crt.acno,micr_crt.brco AS lnbr,chg_type.modt,
            cus_mas.cuno,cus_mas.init,cus_mas.anic,cus_mas.mobi, brch_mas.brnm,CONCAT(user_mas.usnm) AS exe ");

        $this->db->from("oter_charges");
        $this->db->join('brch_mas', 'brch_mas.brid = oter_charges.brco');
        $this->db->join('user_mas', 'user_mas.auid = oter_charges.crby');
        $this->db->join('micr_crt', 'micr_crt.lnid = oter_charges.lnid');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid');
        $this->db->join('chg_type', 'chg_type.chid = oter_charges.chtp');

        if ($brn != 'all') {
            $this->db->where('oter_charges.brco', $brn);
        }
        if ($pytp != 'all') {
            $this->db->where('oter_charges.chtp', $pytp);
        }
    }

    private function loanChargs_queryData()
    {
        $this->loanChargs_query();
        $i = 0;
        foreach ($this->cl_srch31 as $item) // loop column
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
                if (count($this->cl_srch31) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr31[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order31)) {
            $order31 = $this->order31;
            $this->db->order_by(key($order31), $order31[key($order31)]);
        }
    }

    function get_loanChargs()
    {
        $this->loanChargs_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_loanChargs()
    {
        $this->loanChargs_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_loanChargs()
    {
        $this->loanChargs_query();
        return $this->db->count_all_results();
    }
// END LOAN OTHER CHARGS
//
// OFFICER DENIMINATION
    var $cl_srch32 = array('brnm', 'acno', 'anic', 'cuno', 'modt', 'pymt'); //set column field database for datatable searchable
    var $cl_odr32 = array(null, 'brco', 'dnsr', 'dndt', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order32 = array('crdt' => 'asc'); // default order

    function denomi_query()
    {
        $brn = $this->input->post('brn');
        $exe = $this->input->post('exe');
        $srdt = $this->input->post('srdt');

        $this->db->select("denm_details.*, brch_mas.brcd, (SELECT usnm FROM user_mas WHERE auid = dnsr) AS dnur ,   CONCAT(user_mas.usnm) AS exe ");
        $this->db->from("denm_details");
        $this->db->join('brch_mas', 'brch_mas.brid = denm_details.brco');
        $this->db->join('user_mas', 'user_mas.auid = denm_details.crby');

        $this->db->where('denm_details.dndt', $srdt);
        if ($brn != 'all') {
            $this->db->where('denm_details.brco', $brn);
        }
        if ($exe != 'all') {
            $this->db->where('denm_details.dnsr', $exe);
        }
    }

    private function denomi_queryData()
    {
        $this->denomi_query();
        $i = 0;
        foreach ($this->cl_srch32 as $item) // loop column
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
                if (count($this->cl_srch32) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr32[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order32)) {
            $order32 = $this->order32;
            $this->db->order_by(key($order32), $order32[key($order32)]);
        }
    }

    function get_denomi()
    {
        $this->denomi_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_denomi()
    {
        $this->denomi_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_denomi()
    {
        $this->denomi_query();
        return $this->db->count_all_results();
    }
// END OFFICER DENIMINATION
//
// OFFICE DAY END
    var $cl_srch33 = array('brnm', 'acno', 'anic', 'cuno', 'modt', 'pymt'); //set column field database for datatable searchable
    var $cl_odr33 = array(null, 'brco', 'dnsr', 'dndt', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order33 = array('crdt' => 'asc'); // default order

    function ofcrdyend_query()
    {
        $brn = $this->input->post('brn');
        $exe = $this->input->post('exe');
        $dte = $this->input->post('dte');

        $this->db->select("denm_details.*, brch_mas.brnm, (SELECT usnm FROM user_mas WHERE auid = dnsr) AS dnur ,CONCAT(user_mas.usnm) AS exe,
            (SELECT SUM(r.ramt) AS ttl        FROM `receipt` AS r 
            WHERE  r.stat IN(1,2) AND r.retp = 2  AND r.brco = denm_details.brco  AND r.crby = denm_details.dnsr AND  
            DATE_FORMAT(r.crdt, '%Y-%m-%d') = denm_details.dndt AND r.dnid = denm_details.dnid) AS ttl  ");
        $this->db->from("denm_details");
        $this->db->join('brch_mas', 'brch_mas.brid = denm_details.brco');
        $this->db->join('user_mas', 'user_mas.auid = denm_details.crby');

        $this->db->where('denm_details.dndt', $dte);
        $this->db->where("denm_details.stat != 3");
        if ($brn != 'all') {
            $this->db->where('denm_details.brco', $brn);
        }
        if ($exe != 'all') {
            $this->db->where('denm_details.dnsr', $exe);
        }
    }

    private function ofcrdyend_queryData()
    {
        $this->ofcrdyend_query();
        $i = 0;
        foreach ($this->cl_srch33 as $item) // loop column
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
                if (count($this->cl_srch33) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr33[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order33)) {
            $order33 = $this->order33;
            $this->db->order_by(key($order33), $order33[key($order33)]);
        }
    }

    function get_ofcrdyend()
    {
        $this->ofcrdyend_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_ofcrdyend()
    {
        $this->ofcrdyend_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_ofcrdyend()
    {
        $this->ofcrdyend_query();
        return $this->db->count_all_results();
    }
// END OFFICE DAY END
//
//
// BRANCH RECONCILATION
    var $cl_srch34 = array('brnm', 'acno', 'anic', 'cuno', 'modt', 'pymt'); //set column field database for datatable searchable
    var $cl_odr34 = array(null, 'brco', 'date', '', '', '', '', '', '', ''); //set column field database for datatable orderable
    var $order34 = array('crdt' => 'asc'); // default order

    function reconsilation_query()
    {
        $brn = $this->input->post('brn');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("dayend_process.*, brch_mas.brnm, CONCAT(user_mas.usnm) AS exe ");
        $this->db->from("dayend_process");
        $this->db->join('brch_mas', 'brch_mas.brid = dayend_process.brid');
        $this->db->join('user_mas', 'user_mas.auid = dayend_process.prby');

        if ($brn != 'all') {
            $this->db->where('dayend_process.brid', $brn);
        }
        $this->db->where("DATE_FORMAT(dayend_process.date, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

    }

    private function reconsilation_queryData()
    {
        $this->reconsilation_query();
        $i = 0;
        foreach ($this->cl_srch34 as $item) // loop column
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
                if (count($this->cl_srch34) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr34[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order34)) {
            $order34 = $this->order34;
            $this->db->order_by(key($order34), $order34[key($order34)]);
        }
    }

    function get_reconsilation()
    {
        $this->reconsilation_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_reconsi()
    {
        $this->reconsilation_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_reconsi()
    {
        $this->reconsilation_query();
        return $this->db->count_all_results();
    }
// END OFFICER DENIMINATION
//
// DUAL APPROVAL LOAN
    var $cl_srch35 = array('cnnm', 'init', 'cuno', 'micr_crt.acno', 'loam'); //set column field database for datatable searchable
    var $cl_odr35 = array(null, 'cnnm', 'init', 'cuno', 'acno', 'prcd', 'loam', 'noin', 'lnst', 'micr_crt.stat', 'crdt', ''); //set column field database for datatable orderable
    var $order35 = array('crdt' => 'desc'); // default order

    function dualLoan_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("micr_crt.acno,micr_crt.lnid,micr_crt.inam,micr_crt.loam,micr_crt.lntp,product.prcd,micr_crt.noin,micr_crt.lnpr,dual_approval.stat AS apst,
        cus_mas.cuid,cus_mas.grno, brch_mas.brcd,CONCAT(user_mas.usnm) AS exc,  micr_crt.apdt,micr_crt.prva,
        cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.hoad,cus_mas.mobi,cen_mas.cnnm,prdt_typ.pymd, DATE_FORMAT(dual_approval.crdt, '%Y-%m-%d') AS crdt");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        $this->db->join('product', 'product.auid = micr_crt.prid ');
        $this->db->join('prdt_typ', 'prdt_typ.prid = micr_crt.prdtp ');
        $this->db->join('dual_approval', 'dual_approval.lnid = micr_crt.lnid ');

        if ($stat != 'all') {
            $this->db->where('micr_crt.stat', $stat);
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
        $this->db->where("DATE_FORMAT(dual_approval.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
        //$this->db->where('micr_crt.prva ', 1);

        //$this->db->order_by('micr_crt.lnid', 'DESC'); //ASC  DESC
    }

    private function dualLoan_queryData()
    {
        $this->dualLoan_query();
        $i = 0;
        foreach ($this->cl_srch35 as $item) // loop column
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
            $this->db->order_by($this->cl_odr35[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order35)) {
            $order35 = $this->order35;
            $this->db->order_by(key($order35), $order35[key($order35)]);
        }
    }

    function get_dualLoan()
    {
        $this->dualLoan_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_dualLoan()
    {
        $this->dualLoan_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_dualLoan()
    {
        $this->dualLoan_query();
        return $this->db->count_all_results();
    }

// END DUAL APPROVAL LOAN
//
// ADVANCE LOAN
    var $cl_srch36 = array('cnnm', 'init', 'cuno', 'micr_crt.acno', 'loam'); //set column field database for datatable searchable
    var $cl_odr36 = array(null, 'cnnm', 'init', 'cuno', 'acno', 'prcd', 'loam', 'noin', 'lnst', 'micr_crt.stat', 'crdt', ''); //set column field database for datatable orderable
    var $order36 = array('crdt' => 'desc'); // default order

    function advncLoan_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("micr_crt.acno,micr_crt.lnid,micr_crt.inam,micr_crt.loam,micr_crt.lntp,product.prcd,micr_crt.noin,micr_crt.lnpr,micr_crt.stat AS lnst,
        cus_mas.cuid,cus_mas.grno, brch_mas.brcd,CONCAT(user_mas.usnm) AS exc,  micr_crt.apdt, micr_crt.prva, micr_crt.inta, micr_crt.pyam,
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
            $this->db->where('micr_crt.stat', $stat);
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
        $this->db->where("micr_crt.lntp IN(3,4) "); // ONLY INT FREE LOAN & DOWN PAYMENT LOAN

        switch ($stat) {
            case 2:     // APPROVAL LOAN
                $this->db->where("DATE_FORMAT(micr_crt.apdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
                break;
            case 3:     // FINISH LOAN
                $this->db->where("DATE_FORMAT(micr_crt.lspd, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
                break;
            case 5:     // DISBURS LOAN
                $this->db->where("DATE_FORMAT(micr_crt.cvdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
                break;
            default:
                $this->db->where("DATE_FORMAT(micr_crt.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
        }

        //$this->db->where('micr_crt.prva ', 1);
        //$this->db->order_by('micr_crt.lnid', 'DESC'); //ASC  DESC
    }

    private function advncLoan_queryData()
    {
        $this->advncLoan_query();
        $i = 0;
        foreach ($this->cl_srch36 as $item) // loop column
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

                if (count($this->cl_srch36) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr36[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order36)) {
            $order36 = $this->order36;
            $this->db->order_by(key($order36), $order36[key($order36)]);
        }
    }

    function get_advnceLoanDtils()
    {
        $this->advncLoan_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_advncLoan()
    {
        $this->advncLoan_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_advncLoan()
    {
        $this->advncLoan_query();
        return $this->db->count_all_results();
    }

// END ADVANCE LOAN
//
// PROMOTION MODULE SHOP MANAGEMENT
    var $cl_srch37 = array('cnnm', 'init', 'cuno', 'micr_crt.acno', 'loam'); //set column field database for datatable searchable
    var $cl_odr37 = array(null, '', 'init', 'cuno', 'acno', 'prcd', 'loam', 'noin', 'lnst', 'micr_crt.stat', 'crdt', ''); //set column field database for datatable orderable
    var $order37 = array('crdt' => 'desc'); // default order

    function shoplist_query()
    {
        $brn = $this->input->post('brch');

        $this->db->select("shop_mas.*,CONCAT(user_mas.usnm) AS exe, brch_mas.brcd");
        $this->db->from("shop_mas");
        $this->db->join('user_mas', 'user_mas.auid = shop_mas.crby');
        $this->db->join('brch_mas', 'brch_mas.brid = shop_mas.brid');

        if ($brn != 'all') {
            $this->db->where('shop_mas.brid', $brn);
        }
    }

    private function shoplist_queryData()
    {
        $this->shoplist_query();
        $i = 0;
        foreach ($this->cl_srch37 as $item) // loop column
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

                if (count($this->cl_srch37) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr37[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order37)) {
            $order37 = $this->order37;
            $this->db->order_by(key($order37), $order37[key($order37)]);
        }
    }

    function get_shoplist()
    {
        $this->shoplist_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_shoplist()
    {
        $this->shoplist_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_shoplist()
    {
        $this->shoplist_query();
        return $this->db->count_all_results();
    }

// END ADVANCE LOAN
//
//
    // Shop Voucher
    var $cl_srch38 = array('voucher.vuno', 'pynm', 'vuam'); //set column field database for datatable searchable
    var $cl_odr38 = array(null, '', 'vcrdt', 'vuno', '', 'mode', 'dsnm', 'vuam', 'stat', ''); //set column field database for datatable orderable
    var $order38 = array('vcrdt' => 'desc'); // default order

    function shopVou_query()
    {
        $brn = $this->input->post('brn');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("voucher.*,DATE_FORMAT(voucher.crdt, '%Y-%m-%d') AS vcrdt,  brch_mas.brnm ,pay_terms.tem_name,chq_issu.cpnt,chq_issu.stat AS chst   ");
        $this->db->from("voucher");
        $this->db->join('vouc_des', 'vouc_des.vuid = voucher.void');
        $this->db->join('pay_terms', 'pay_terms.tmid = voucher.pmtp');
        $this->db->join('brch_mas', 'brch_mas.brid = voucher.brco');
        $this->db->join('chq_issu', 'chq_issu.vuid = voucher.void', 'left');
        $this->db->group_by('vuno');
        $this->db->where("DATE_FORMAT(voucher.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");

        if ($brn != 'all') {
            $this->db->where('voucher.brco', $brn);
        }
        $this->db->where('voucher.mode', 5);
        $this->db->where('voucher.stat IN(0,1,2)');
    }

    private function shopVou_queryData()
    {
        $this->shopVou_query();
        $i = 0;
        foreach ($this->cl_srch38 as $item) // loop column
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
                if (count($this->cl_srch38) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr38[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order38)) {
            $order38 = $this->order38;
            $this->db->order_by(key($order38), $order38[key($order38)]);
        }
    }

    function get_shopVou()
    {
        $this->shopVou_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filt_shopVou()
    {
        $this->shopVou_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_shopVou()
    {
        $this->shopVou_query();
        return $this->db->count_all_results();
    }
    // end Voucher
    //


}

?>
