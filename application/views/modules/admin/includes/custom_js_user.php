<script>
    $(document).ready(function () {
        //===========================================================
        // CHECK USER LEVEL PERMISSION WHEN TRYING TO ACCESS BY URL
        //===========================================================

//        $.ajax({
//            url: '<?//= base_url(); ?>//welcome/userPermission',
//            type: 'post',
//            data: {
//                user_id: <?//= $_SESSION["userId"] ?>
//            },
//            dataType: 'json',
//            success: function(response) {
//                if (response[1]['system_status_status_id'] == 2) {
//                    swal("Unauthorized Access!", "", "warning");
//                    window.setTimeout(function() {
//                        location = '<?//= base_url(); ?>//welcome/not_access';
//                    }, 1000);
//                }
//            }
//        });

        //============================================================

    });

    // Main Filter List for Add
    function getExe(id, idexc, exvl, idcen) {  // id - branch id / idexc - executive html id / idcen - center html id

        var x = "#" + idexc;  // executive id html
        var y = "#" + idcen;  // center id html
        var branch_id = id;
        var exe_id = exvl;

        if (branch_id == 0) {
            $(x).empty();
            $(x).append("<option value='0'>--Select Officer--</option>");
            $(y).empty();
            $(y).append("<option value='0'>--Select Center--</option>");
        } else {
            $.ajax({
                url: '<?= base_url(); ?>user/getExecutive',
                type: 'post',
                data: {
                    brch_id: branch_id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    if (len != 0) {
                        $(x).empty();
                        $(x).append("<option value='all'>All Officer</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['auid'];
                            var name = response[i]['fnme'] + ' ' + response[i]['lnme'];
                            var $el = $(x);
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $(x).empty();
                        $(x).append("<option value='0'>No Officer</option>");
                    }
                }
            });

            $.ajax({
                url: '<?= base_url(); ?>user/getCenter',
                type: 'post',
                data: {
                    branch_id: branch_id,
                    exe_id: exe_id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    if (len != 0) {
                        $(y).empty();
                        $(y).append("<option value='all'>All Centers</option>");

                        for (var i = 0; i < len; i++) {
                            var id = response[i]['caid'];
                            var name = response[i]['cnnm'];
                            var $el = $(y);
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $(y).empty();
                        $(y).append("<option value='no'>No Centers</option>");
                    }
                }
            });
        }

    }

    function getCenter(id, idcen, brn) {  // id - exec id /  idcen - center html id / brn - brn value

        var exe_id = id; //exec value
        var branch_id = brn; // brn value
        var m = "#" + idcen; // cent html id

        $(m).empty();
        $(m).append("<option value='0'>&#xf110;</option>");

        $.ajax({
            url: '<?= base_url(); ?>user/getCenter',
            type: 'post',
            data: {
                exe_id: exe_id,
                branch_id: branch_id
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $(m).empty();
                    $(m).append("<option value='all'>All Centers</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['caid'];
                        var name = response[i]['cnnm'];
                        var $el = $(m);
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $(m).empty();
                    $(m).append("<option value='no'>No Centers</option>");
                }
            }
        });

    }

    function getGrup(id, htid, brnid, excid, cenid) { // id value,html value,brnch id,exe id,cen id


        var m = "#" + htid; // group html id

        $(m).empty();
        $(m).append("<option value='-'>Select Group</option>");

        $.ajax({
            url: '<?= base_url(); ?>user/getGrup',
            type: 'post',
            data: {
                brn_id: brnid,
                exe_id: excid,
                cen_id: cenid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $(m).empty();
                    $(m).append("<option value='all'>All Group</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['grpid'];
                        var name = response[i]['cnnm'] + ' - ' + response[i]['grno'];
                        var $el = $(m);
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $(m).empty();
                    $(m).append("<option value='no'>No Group</option>");
                }
            }
        });
    }

    // Main Filter List for Edit
    function getExeEdit(id, idexc, exvl, idcen) {  // id - branch id / idexc - executive html id / idcen - center html id

        var x = "#" + idexc;  // executive id html
        var y = "#" + idcen;  // center id html
        var branch_id = id;
        var exe_id = exvl;

        if (branch_id == 0) {
            $(x).empty();
            $(x).append("<option value='0'>--Select Officer--</option>");
            $(y).empty();
            $(y).append("<option value='0'>--Select Center--</option>");
        } else {
            $.ajax({
                url: '<?= base_url(); ?>user/getExecutive',
                type: 'post',
                data: {
                    brch_id: branch_id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    if (len != 0) {
                        $(x).empty();
                        $(x).append("<option value='all'>All Officer</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['auid'];
                            var name = response[i]['fnme'] + ' ' + response[i]['lnme'];
                            var $el = $(x);
                            if (id == exe_id) {
                                $el.append($("<option selected></option>")
                                    .attr("value", id).text(name));
                            } else {
                                $el.append($("<option></option>")
                                    .attr("value", id).text(name));
                            }
                        }
                    } else {
                        $(x).empty();
                        $(x).append("<option value='0'>No Officer</option>");
                    }
                }
            });
//            $.ajax({
//                url: '<?//= base_url(); ?>//user/getCenter',
//                type: 'post',
//                data: {
//                    branch_id: branch_id,
//                    exe_id: exe_id
//                },
//                dataType: 'json',
//                success: function (response) {
//                    var len = response.length;
//                    if (len != 0) {
//                        $(y).empty();
//                        $(y).append("<option value='all'>All Centers</option>");
//
//                        for (var i = 0; i < len; i++) {
//                            var id = response[i]['caid'];
//                            var name = response[i]['cnnm'];
//                            var $el = $(y);
//                            $el.append($("<option></option>")
//                                .attr("value", id).text(name));
//                        }
//                    } else {
//                        $(y).empty();
//                        $(y).append("<option value='no'>No Centers</option>");
//                    }
//                }
//            });
        }
    }

    function getCenterEdit(id, idcen, brn, ccnt) {  // id - exec value /  idcen - center html id / brn - brn value / ccnt - center value

        var exe_id = id; //exec value
        var branch_id = brn; // brn value
        var m = "#" + idcen; // cent html id

        $(m).empty();
        $(m).append("<option value='0'>&#xf110;</option>");

        $.ajax({
            url: '<?= base_url(); ?>user/getCenter',
            type: 'post',
            data: {
                exe_id: exe_id,
                branch_id: branch_id
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $(m).empty();
                    $(m).append("<option value='all'>All Centers</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['caid'];
                        var name = response[i]['cnnm'];
                        var $el = $(m);
                        if (id == ccnt) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    }
                } else {
                    $(m).empty();
                    $(m).append("<option value='no'>No Centers</option>");
                }
            }
        });

    }



//GPS LOCATION
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
            $("#sts2").html('<img src="<?php echo base_url(); ?>assets/images/GPSloader.gif" width="35" height="35" align="absmiddle"><span> Processing...</span>');
        } else {
            innerHTML = "Geolocation is not supported by this browser.";
        }
    };

    function showPosition(position) {
        $("#sts2").hide('slow');
        $("#gplt").val(position.coords.latitude);
        $("#gplg").val(position.coords.longitude);
    };

    function getLocation2() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition2);
            $("#sts22").html('<img src="<?php echo base_url(); ?>assets/images/GPSloader.gif" width="35" height="35" align="absmiddle"><span> Processing...</span>');
        } else {
            innerHTML = "Geolocation is not supported by this browser.";
        }
    };

    function showPosition2(position) {
        $("#sts22").hide('slow');
        $("#adv_gplt").val(position.coords.latitude);
        $("#adv_gplg").val(position.coords.longitude);
    };

    //GPS LOCATION EDIT CUSTOMER
    function getLocation_edt() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition_edt);
            $("#sts2_edt").html('<img src="<?php echo base_url(); ?>assets/images/GPSloader.gif" width="35" height="35" align="absmiddle"><span> Processing...</span>');
        } else {
            innerHTML = "Geolocation is not supported by this browser.";
        }
    };

    function showPosition_edt(position) {
        $("#sts2_edt").hide('slow');
        $("#gplt_edt").val(position.coords.latitude);
        $("#gplg_edt").val(position.coords.longitude);
    };

    function getLocation2_edt() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition2_edt);
            $("#sts22_edt").html('<img src="<?php echo base_url(); ?>assets/images/GPSloader.gif" width="35" height="35" align="absmiddle"><span> Processing...</span>');
        } else {
            innerHTML = "Geolocation is not supported by this browser.";
        }
    };

    function showPosition2_edt(position) {
        $("#sts22_edt").hide('slow');
        $("#adv_gplt_edt").val(position.coords.latitude);
        $("#adv_gplg_edt").val(position.coords.longitude);
    };

// NIC CHECK
    // common NIC check
    function checkNicCmmn(nic, vlid, htid) { // nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button)
        var nicNo = nic;
        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            document.getElementById(vlid).style.borderColor = "#e6e8ed";
            document.getElementById(htid).disabled = false;

        } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {
            document.getElementById(vlid).style.borderColor = "#e6e8ed";
            document.getElementById(htid).disabled = false;

        } else {
            document.getElementById(vlid).focus();
            document.getElementById(vlid).style.borderColor = "red";
            document.getElementById(htid).disabled = true;
        }
    }

    function checkNic1(nic, vlid, htid) { // nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button)

        //var nicNo = document.getElementById("nic").value;
        var nicNo = nic;
        var month = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {

            var birthYear = nicNo.substr(0, 2);
            var x = nicNo.substr(2, 3);

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }

            if (x < 500) {
                //  document.getElementById("g2").checked = false;
                //  document.getElementById("g1").checked = true;
                document.getElementById("gend").value = 1;

            } else {
                //  document.getElementById("g1").checked = false;
                //  document.getElementById("g2").checked = true;
                document.getElementById("gend").value = 2;
                x = +x - +500;
            }

            var mo = 0;
            var da = 0;
            var days = x;

            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }

            var today = +1900 + +birthYear + "-" + (mo) + "-" + (da);

            $('#dobi').val(today);
            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;

        } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {

            var birthYear = nicNo.substr(0, 4);
            var x = nicNo.substr(4, 3);

            if (x < 500) {
                //  document.getElementById("g2").checked = false;
                //  document.getElementById("g1").checked = true;
                document.getElementById("gend").value = 1;
            } else {
                //  document.getElementById("g1").checked = false;
                //  document.getElementById("g2").checked = true;
                document.getElementById("gend").value = 2;
                x = +x - +500;
            }

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }

            var mo = 0;
            var da = 0;
            var days = x;

            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }

            var today = +birthYear + "-" + (mo) + "-" + (da);

            $('#dobi').val(today);
            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;

        } else {
            document.getElementById(vlid).focus();
            document.getElementById(vlid).style.borderColor = "red";

            document.getElementById(htid).disabled = true;
        }

        // document.getElementById('msg_text').innerHTML = "<div></div>";
    };

    function checkNic_edt(nic, vlid, htid) { // nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button)

       // var nicNo = document.getElementById("nic_edt").value;
        var nicNo = nic;
        var month = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {

            var birthYear = nicNo.substr(0, 2);
            var x = nicNo.substr(2, 3);

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }

            if (x < 500) {
                document.getElementById("gend_edt").value = 1;
            } else {
                document.getElementById("gend_edt").value = 2;
                x = +x - +500;
            }

            var mo = 0;
            var da = 0;
            var days = x;

            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }

            var today = +1900 + +birthYear + "-" + (mo) + "-" + (da);

            $('#dobi_edt').val(today);
            document.getElementById('nic_edt').style.borderColor = "";
            document.getElementById(htid).disabled = false;

        } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {

            var birthYear = nicNo.substr(0, 4);
            var x = nicNo.substr(4, 3);

            if (x < 500) {
                document.getElementById("gend_edt").value = 1;
            } else {
                document.getElementById("gend_edt").value = 2;
                x = +x - +500;
            }

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }

            var mo = 0;
            var da = 0;
            var days = x;

            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }

            var today = +birthYear + "-" + (mo) + "-" + (da);

            $('#dobi_edt').val(today);
            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;

        } else {
            document.getElementById(vlid).focus();
            document.getElementById(vlid).style.borderColor = "red";

            document.getElementById(htid).disabled = true;
        }
    };

    function checkNicAdv(nic, vlid, htid) { // nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button)

        var nicNo = nic;
        var month = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        if (nicNo.length == 10) {
            var birthYear = nicNo.substr(0, 2);
            var x = nicNo.substr(2, 3);

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }

            if (x < 500) {
                // document.getElementById("gender2").checked = false;
                // document.getElementById("gender1").checked = true;
                document.getElementById("adv_gend").value = 1;
            } else {
                //  document.getElementById("gender1").checked = false;
                //  document.getElementById("gender2").checked = true;
                document.getElementById("adv_gend").value = 2;
                x = +x - +500;
            }

            var mo = 0;
            var da = 0;
            var days = x;

            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }

            var today = +1900 + +birthYear + "-" + (mo) + "-" + (da);
            //            var today = +(da)+"-"+(mo)+"-"+1900 + +birthYear ;

            $('#adv_dobi').val(today);
            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;

        } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {

            var birthYear = nicNo.substr(0, 4);
            var x = nicNo.substr(4, 3);

            if (x < 500) {
                //   document.getElementById("gender2").checked = false;
                //   document.getElementById("gender1").checked = true;
                document.getElementById("adv_gend").value = 1;
            } else {
                // document.getElementById("gender1").checked = false;
                // document.getElementById("gender2").checked = true;
                document.getElementById("adv_gend").value = 2;
                x = +x - +500;
            }

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }

            var mo = 0;
            var da = 0;
            var days = x;

            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }

            var today = +birthYear + "-" + (mo) + "-" + (da);

            $('#adv_dobi').val(today);

            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;

        } else {
            document.getElementById(vlid).focus();
            document.getElementById(vlid).style.borderColor = "red";

            document.getElementById(htid).disabled = true;
        }

        // document.getElementById('msg_text').innerHTML = "<div></div>";
    };

    function checkNicAdv_edt() {
        var nicNo = document.getElementById("adv_nic_edt").value;
        var month = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            var birthYear = nicNo.substr(0, 2);
            var x = nicNo.substr(2, 3);

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }

            if (x < 500) {
                document.getElementById("adv_gend_edt").value = 1;
            } else {
                document.getElementById("adv_gend_edt").value = 2;
                x = +x - +500;
            }

            var mo = 0;
            var da = 0;
            var days = x;

            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }
            if (da < 10) {
                da = '0' + days;
            }

            var today = +1900 + +birthYear + "-" + (mo) + "-" + (da);
            $('#adv_dobi_edt').val(today);
            document.getElementById('adv_nic_edt').style.borderColor = "#e6e8ed";

        } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {

            var birthYear = nicNo.substr(0, 4);
            var x = nicNo.substr(4, 3);

            if (x < 500) {
                document.getElementById("adv_gend_edt").value = 1;
            } else {
                document.getElementById("adv_gend_edt").value = 2;
                x = +x - +500;
            }

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }

            var mo = 0;
            var da = 0;
            var days = x;

            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }

            var today = +birthYear + "-" + (mo) + "-" + (da);

            $('#adv_dobi_edt').val(today);
            document.getElementById('adv_nic_edt').style.borderColor = "#e6e8ed";

        } else {
            document.getElementById('adv_nic_edt').focus();
            document.getElementById('adv_nic_edt').style.borderColor = "red";
        }

        // document.getElementById('msg_text').innerHTML = "<div></div>";
    };



</script>
<!--<script src=" http://ajax.microsoft.com/ajax/jquery.validate/1.7/additional-methods.js"></script>-->
<!-- validate lettres only-->
