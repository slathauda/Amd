<?php

class Admin_model extends CI_Model
{
    //  Product Details
    var $cl_srch1 = array('prna', 'prnm', 'prcd', 'lamt', 'rent'); //set column field database for datatable searchable
    var $cl_odr1 = array(null, '', ''); //set column field database for datatable orderable
    var $order = array('cnnm' => 'asc'); // default order

    function product_query()
    {
        $brn = $this->input->post('brn');
        $prtp = $this->input->post('prtp');
        $sta = $this->input->post('stat');

        $this->db->select("product.* ,brch_mas.brnm,prdt_typ.prna,prdt_typ.pymd");
        $this->db->from("product");
        $this->db->join('brch_mas', 'brch_mas.brid = product.brid');
        $this->db->join('prdt_typ', 'prdt_typ.prid = product.prtp');

//        $this->db->join("(SELECT aa.brco,aa.ccnt, COUNT(*)  AS cncust
//        FROM `cus_mas` AS aa WHERE  stat = 1 GROUP BY aa.brco,aa.ccnt )AS aa ",
//            'aa.brco = cen_mas.brco AND aa.ccnt = cen_mas.caid ', 'left'); //customer count

        if ($sta != 'all') {
            $this->db->where('product.stat ', $sta);
        }
        if ($brn != 'all') {
            $this->db->where('product.brid', $brn);
        }
        if ($prtp != 'all') {
            $this->db->where('product.prtp', $prtp);
        }
    }

    private function product_queryData()
    {
        $this->product_query();
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

    function get_productDtils()
    {
        $this->product_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function filtered_prduct()
    {
        $this->product_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function all_prduct()
    {
        $this->product_query();
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

        $this->db->select("cus_mas.cuid,cus_mas.cuno,cus_mas.init,cus_mas.mobi,cus_type.cutp,grup_mas.grno,cen_mas.cnnm,cen_mas.caid");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->where('cus_mas.stat ', 1);

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

        $this->db->select("grup_mas.*,cen_mas.cnnm,sys_stat.stnm,cus_mas.init,IFNULL(aa.grcust,'0') AS grcust");
        $this->db->from("grup_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = grup_mas.cnid ');
        $this->db->join('cus_mas', 'cus_mas.cuid = grup_mas.grld ', 'left');
        $this->db->join('sys_stat', 'sys_stat.stid = grup_mas.stat ');
        $this->db->join("(SELECT aa.ccnt,aa.grno, COUNT(*)  AS grcust
        FROM `cus_mas` AS aa WHERE  stat = 1 GROUP BY aa.grno,aa.ccnt )AS aa ",
            'aa.ccnt = grup_mas.cnid AND aa.grno = grup_mas.grno ', 'left'); //customer count


        // $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        // $this->db->where('cus_mas.stat ', 1);

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

    // center leader
    var $cl_srch4 = array('cnnm'); //set column field database for datatable searchable
    var $cl_odr4 = array(null, 'cnnm', 'grno', 'cuno', 'init', 'mobi', 'cutp', ''); //set column field database for datatable orderable
    var $order4 = array('cnnm' => 'asc'); // default order

    function grpLedDet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $grp = $this->input->post('grp');

        $this->db->select("cus_mas.cuid,cus_mas.cuno,cus_mas.init,cus_mas.mobi,cus_mas.metp,cus_type.cutp,grup_mas.grno,cen_mas.cnnm,grup_mas.grpid");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->where('cus_mas.stat ', 1);
        $this->db->where('grup_mas.stat ', 1);

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
        // $this->db->order_by('recipts.crdt', 'ASC'); //ASC  DESC

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
    var $cl_srch5 = array('cnnm'); //set column field database for datatable searchable
    var $cl_odr5 = array(null, 'brnm', 'cnnm', 'exc', 'cuno', 'init', '', '', 'cutp', ''); //set column field database for datatable orderable
    var $order5 = array('crdt' => 'desc'); // default order

    function custDet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');

        $this->db->select("cus_mas.cuid, brch_mas.brnm,CONCAT(user_mas.usnm ) AS exc,  cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.cuty,cus_mas.hoad,cus_mas.mobi,cus_mas.stat,grup_mas.grno,cen_mas.cnnm,cust_stat.stnm");
        $this->db->from("cus_mas");
        $this->db->join('cen_mas', 'cen_mas.caid = cus_mas.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = cus_mas.brco ');
        $this->db->join('grup_mas', 'grup_mas.grpid = cus_mas.grno ');
        $this->db->join('user_mas', 'user_mas.auid = cus_mas.exec ');
        $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        $this->db->join('cust_stat', 'cust_stat.stid = cus_mas.stat ');

        $this->db->where('grup_mas.stat ', 1);
        //$this->db->where('cus_mas.stat IN(3,4,5)');
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

                if (count($this->cl_srch2) - 1 == $i) //last loop
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
    // loan
    var $cl_srch6 = array('cnnm'); //set column field database for datatable searchable
    var $cl_odr6 = array(null, 'brnm', 'cnnm', 'exc', 'cuno', 'init', '', '', 'cutp', ''); //set column field database for datatable orderable
    var $order6 = array('crdt' => 'desc'); // default order

    function loanDet_query()
    {
        $brn = $this->input->post('brn');
        $exc = $this->input->post('exc');
        $cen = $this->input->post('cen');
        $stat = $this->input->post('stat');

        $this->db->select("cus_mas.cuid,cus_mas.grno, brch_mas.brnm,CONCAT(user_mas.usnm ) AS exc,  cus_mas.cuno,cus_mas.anic,cus_mas.init,cus_mas.cuty,cus_mas.hoad,cus_mas.mobi,cus_mas.stat,cen_mas.cnnm");
        $this->db->from("micr_crt");
        $this->db->join('cen_mas', 'cen_mas.caid = micr_crt.ccnt ');
        $this->db->join('brch_mas', 'brch_mas.brid = micr_crt.brco ');
        $this->db->join('cus_mas', 'cus_mas.cuid = micr_crt.apid ');
        $this->db->join('user_mas', 'user_mas.auid = micr_crt.clct ');
        // $this->db->join('cus_type', 'cus_type.cuid = cus_mas.metp ');
        // $this->db->join('cust_stat', 'cust_stat.stid = cus_mas.stat ');

        //$this->db->where('cus_mas.stat IN(3,4,5)');
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

    // end loan

//  Recent activity
    var $cl_srch7 = array('pnm', 'func', 'lgdt'); //set column field database for datatable searchable
    var $cl_odr7 = array(null, 'fnme', 'pnm', 'lgdt'); //set column field database for datatable orderable
    var $order7 = array('cnnm' => 'asc'); // default order

    function recnt_query()
    {
        $brn = $this->input->post('brn');
        $usr = $this->input->post('user');
        $act = $this->input->post('act');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("user_log.*,user_mas.uimg,user_mas.usnm");
        $this->db->from("user_log");
        $this->db->join('user_mas', 'user_mas.auid = user_log.usid');
        $this->db->where("DATE_FORMAT(user_log.lgdt, '%Y-%m-%d') BETWEEN '$frdt' AND  '$todt' ");

        if ($brn != 'all') {
            $this->db->where('user_mas.brch ', $brn);
        }
        if ($usr != 'all') {
            $this->db->where('user_log.usid ', $usr);
        }
        if ($act != 'all') {
            $this->db->like('user_log.func', $act, 'both');
            // Produces: WHERE title LIKE '%match%'
        }
        if ($_SESSION['role'] != 1) {
            $this->db->where('user_mas.usmd != 1 ');
        }

    }

    private function recnt_queryData()
    {
        $this->recnt_query();
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

    function get_recntDtils()
    {
        $this->recnt_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function filtered_recnt()
    {
        $this->recnt_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function all_recnt()
    {
        $this->recnt_query();
        return $this->db->count_all_results();
    }

//  End Recent activity
//  Target management
    var $cl_srch8 = array('', ''); //set column field database for datatable searchable
    var $cl_odr8 = array(null, '', ''); //set column field database for datatable orderable
    var $order8 = array('cnnm' => 'asc'); // default order

    function target_query()
    {
        $brn = $this->input->post('brch');
        $exc = $this->input->post('exe');
        $cen = $this->input->post('cnt');
        $per = $this->input->post('per');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("target.*,target_dura.dunm,target_typ.tpnm,com_det.cmne,brch_mas.brnm,user_mas.fnme,cen_mas.cnnm ,aa.crusr,DATE_FORMAT(target.crdt, '%Y-%m-%d') AS crdt  ");
        $this->db->from("target");
        $this->db->join('target_dura', 'target_dura.auid = target.dura');
        $this->db->join('target_typ', 'target_typ.auid = target.trtp');

        $this->db->join('com_det', 'com_det.cmid = target.cmid', 'left');
        $this->db->join('brch_mas', 'brch_mas.brid = target.brid', 'left');
        $this->db->join('user_mas', 'user_mas.auid = target.usid', 'left');
        $this->db->join('cen_mas', 'cen_mas.caid = target.cnnt', 'left');

        $this->db->join("(SELECT aa.auid,aa.usnm AS crusr
        FROM `user_mas` AS aa  )AS aa ", 'aa.auid = target.crby');

        $this->db->where('target.stat != 5'); // without history recode
        $this->db->where("target.frdt >= '$frdt' ");
        $this->db->where("target.todt <= '$todt' ");

        if ($brn != 'all') {
            $this->db->where('target.brid', $brn);
        }
        if ($exc != 'all') {
            $this->db->where('target.usid', $exc);
        }
        if ($cen != 'all') {
            $this->db->where('target.cnnt', $cen);
        }
        if ($per != 'all') {
            $this->db->where('target.dura', $per);
        }
    }

    private function target_queryData()
    {
        $this->target_query();
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

    function get_targetDtils()
    {
        $this->target_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function filtered_target()
    {
        $this->target_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function all_target()
    {
        $this->target_query();
        return $this->db->count_all_results();
    }

//  End Target
//  User management
    var $cl_srch9 = array('brnm', 'usnm', 'fnme', 'almo', 'unic', 'lvnm',); //set column field database for datatable searchable
    var $cl_odr9 = array(null, 'brnm', '', 'usnm', 'fnme', 'almo', 'unic', 'lvnm', '', '', '', 'stat', '', ''); //set column field database for datatable orderable
    var $order9 = array('stat' => 'asc'); // default order

    function user_query()
    {
        $brn = $this->input->post('brch');
        $uslv = $this->input->post('uslv');

        $this->db->select("user_mas.* ,brch_mas.brcd,brch_mas.brnm,user_level.lvnm, DATE_FORMAT(user_mas.crdt, '%Y-%m-%d') AS jidt   ");
        $this->db->from("user_mas");
        $this->db->join('brch_mas', 'brch_mas.brid = user_mas.brch');
        $this->db->join('user_level', 'user_level.id = user_mas.usmd');
        $this->db->where('user_mas.usmd != 1'); // without super admin

        if ($brn != 'all') {
            $this->db->where('user_mas.brch', $brn);
        }
        if ($uslv != 'all') {
            $this->db->where('user_mas.usmd', $uslv);
        }
    }

    private function user_queryData()
    {
        $this->user_query();
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

    function get_userDtils()
    {
        $this->user_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function filtered_user()
    {
        $this->user_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function all_user()
    {
        $this->user_query();
        return $this->db->count_all_results();
    }

// End User management

////////////////////////////////start investor //////////////////////////////////////////////////////

    var $ins_srch1 = array('inic');
    var $ins_odr1 = array(null, 'innm', 'hoad', 'inic', 'mobi', 'mail', 'ivtp', 'stat', '');
    var $ins_order = array('cnnm' => 'asc');

    function get_investorDtils()
    {
        $this->investor_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    } //set column field database for datatable orderable

    private function investor_queryData()
    {
        $this->investor_query();
        $i = 0;
        foreach ($this->ins_srch1 as $item) // loop column
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

                if (count($this->ins_srch1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->ins_odr1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $ins_order = $this->order;
            $this->db->order_by(key($ins_order), $ins_order[key($ins_order)]);
        }
    } // default order

    function investor_query()
    {
        $fill_mode = $this->input->post('fill_mode');
        $fill_stat = $this->input->post('fill_stat');

        $this->db->select("*");
        $this->db->from("inve_mas");
        if ($fill_mode != 'all') {
            $this->db->where('inve_mas.ivtp', $fill_mode);
        }
        if ($fill_stat != 'all') {
            $this->db->where('inve_mas.stat', $fill_stat);
        }

    }

    public function count_all_investor()
    {
        // $this->db->from($this->table);
        $this->investor_query();
        return $this->db->count_all_results();
    }

    function count_filtered_investor()
    {
        $this->investor_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_investorbankDtils()
    {
        $this->investorbank_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    //bank start

    var $insbank_srch1 = array('inic');
    var $insbank_odr1 = array(null, 'innm', 'inic', 'bknm', 'bkbr', 'actp', 'acno', 'stat');
    var $insbank_order = array('innm' => 'asc'); //set column field database for datatable searchable

    private function investorbank_queryData()
    {
        $this->investorbank_query();
        $i = 0;
        foreach ($this->insbank_srch1 as $item) // loop column
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

                if (count($this->insbank_srch1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->insbank_odr1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $insbank_order = $this->order;
            $this->db->order_by(key($insbank_order), $insbank_order[key($insbank_order)]);
        }
    }

//investor bank management details  search table end

//investment search table start

    var $insvest_srch1 = array('in'); //set column field database for datatable orderable
    var $insvest_odr1 = array(null, 'innm', 'inic', 'mobi', 'acno', 'amnt', 'tort', 'stdt', 'mtdt', 'inst'); // default order
    var $insvest_order = array('innm' => 'asc');

    function investorbank_query()
    {
        $fill_stat = $this->input->post('fill_stat');

        $this->db->select("inve_bank.*,inve_mas.innm,inve_mas.inic,bnk_names.bknm");
        $this->db->from("inve_bank");
        $this->db->join('inve_mas', 'inve_mas.auid = inve_bank.inid');
        $this->db->join('bnk_names', 'bnk_names.bkid = inve_bank.bkid');

        if ($fill_stat != 'all') {
            $this->db->where('inve_bank.stat', $fill_stat);
        }

    } //set column field database for datatable searchable

    public function count_all_investorbank()
    {
        // $this->db->from($this->table);
        $this->investorbank_query();
        return $this->db->count_all_results();
    } //set column field database for datatable orderable

    function count_filtered_investorbank()
    {
        $this->investorbank_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    } // default order

    function get_InsvestDtils()
    {
        $this->insvest_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function insvest_queryData()
    {
        $this->insvest_query();
        $i = 0;
        foreach ($this->insvest_srch1 as $item) // loop column
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

                if (count($this->insvest_srch1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->insvest_odr1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $insvest_order = $this->order;
            $this->db->order_by(key($insvest_order), $insvest_order[key($insvest_order)]);
        }
    }

    function insvest_query()
    {
        $fill_stat = $this->input->post('fill_stat');


        $this->db->select("investment.*,inve_mas.*,inve_bank.*,invest_dura.*");
        $this->db->from("investment");
        $this->db->join('inve_mas', 'inve_mas.auid = investment.ivid', 'left');
        // $this->db->join('bnk_names', 'bnk_names.bkid = inve_bank.bkid');
        $this->db->join('inve_bank', 'inve_bank.bnid = investment.ivid', 'left');
        $this->db->join('invest_dura', 'invest_dura.auid = investment.pamd', 'left');
        if ($fill_stat != 'all') {
            $this->db->where('investment.inst', $fill_stat);
        }
    }

//table entry Showing 1 to 1 of 1 entries
    public function count_all_insvest()
    {
        $this->insvest_query();
        return $this->db->count_all_results();
    }

    function count_filtered_insvest()
    {
        $this->insvest_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

//investment search table end
//
//
//
//investor payment details  search table start
    var $inspy_srch1 = array('inic'); //set column field database for datatable searchable
    var $inspy_odr1 = array(null, 'innm', 'inic', 'mobi', 'mail', 'ivtp', 'amnt', 'tort'); //set column field database for datatable orderable
    var $inspy_order = array('innm' => 'asc'); // default order

    function get_inspyDtils()
    {
        $this->inspy_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function inspy_queryData()
    {
        $this->inspy_query();
        $i = 0;
        foreach ($this->inspy_srch1 as $item) // loop column
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

                if (count($this->inspy_srch1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->inspy_odr1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $inspy_order = $this->order;
            $this->db->order_by(key($inspy_order), $inspy_order[key($inspy_order)]);
        }
    }

    function inspy_query()
    {
        //$fill_stat = $this->input->post('fill_stat');

        $this->db->select("invst_pymt.pyid,invst_pymt.psat,invst_pymt.amnt,invst_pymt.amnt,inve_mas.auid,inve_mas.innm,inve_mas.inic,inve_mas.mobi,inve_mas.mail,inve_mas.ivtp,investment.*");
        $this->db->from("invst_pymt");
        $this->db->join('inve_mas', 'inve_mas.auid = invst_pymt.pnic');
        $this->db->join('investment', 'investment.invd = invst_pymt.pyam');

//        if ($fill_stat != 'all') {
//            $this->db->where('inve_bank.stat', $fill_stat);
//        }

    }

//table entry Showing 1 to 1 of 1 entries
    public function count_all_inspy()
    {
        // $this->db->from($this->table);
        $this->inspy_query();
        return $this->db->count_all_results();
    }

    function count_filtered_inspy()
    {
        $this->inspy_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    //investor payment  search table end


}

?>
