<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Genaral</li>
    <li class="active">Policy Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Policy Management </strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th class="col-md-8" style="text-align: center">Policy Description</th>
                                <th style="text-align: center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>01</td>
                                <td><strong>Group Member Range</strong><br>
                                    <small>This policy allows you to decide minimum and maximum limit which allows to a
                                        Group.
                                    </small>
                                </td>
                                <td>
                                    <div class="col-md-6"><input type="number" id="plc_grp_min" name="plc_grp_min"
                                                                 class="form-control" placeholder="Min"></div>
                                    <div class="col-md-6"><input type="number" id="plc_grp_max" name="plc_grp_max"
                                                                 class="form-control" placeholder="Max"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td><strong>Center Member Range</strong><br>
                                    <small>This policy allows you to decide minimum and maximum limit which allows to a
                                        Center.
                                    </small>
                                </td>
                                <td>
                                    <div class="col-md-6"><input type="number" id="plc_cen_min" name="plc_cen_min"
                                                                 class="form-control" placeholder="Min"></div>
                                    <div class="col-md-6"><input type="number" id="plc_cen_max" name="plc_cen_max"
                                                                 class="form-control" placeholder="Max"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td><strong>Customer Age Limit</strong><br>
                                    <small>This policy allows you to decide minimum and maximum age limit of Registered
                                        Customers.
                                    </small>
                                </td>
                                <td>
                                    <div class="col-md-6"><input type="number" id="plc_cust_min" name="plc_cust_min"
                                                                 class="form-control" placeholder="Min"></div>
                                    <div class="col-md-6"><input type="number" id="plc_cust_max" name="plc_cust_max"
                                                                 class="form-control" placeholder="Max"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>04</td>
                                <td><strong>Currency Type</strong><br>
                                    <small>Select your currency type here.</small>
                                </td>
                                <td align='center'>
                                    <select class="form-control col-md-12" name="plc_curr_type" id="plc_curr_type">
                                        <option value="86">LKR - Sri Lanka</option>
                                        <?php
                                        foreach ($currencies as $curency) {
                                            echo "<option value='$curency->curId'>$curency->symbol - $curency->country</option>";
                                        }
                                        ?>
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td>05</td>
                                <td><strong>Maximum Loan Amount</strong><br>
                                    <small>This policy allows you to decide maximum loan amount which can be issue to
                                        customer.
                                    </small>
                                </td>
                                <td align='center'>
                                    <div class="col-md-12">

                                        <input type="number" id="plc_loan_amt" name="plc_loan_amt" class="form-control"
                                               placeholder="0.00"/>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>06</td>
                                <td><strong>Parallel Loans</strong><br>
                                    <small>This policy allows you to decide acceptance of parallel loans. It means, if
                                        parallel loans are allowed, customers can request for a loan when they already
                                        have a loan.
                                    </small>
                                </td>
                                <td align='center'>
                                    <select class="form-control" name="plc_par_loan" id="plc_par_loan">
                                        <option value="1">Allow</option>
                                        <option value="2">Disallow</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>07</td>
                                <td><strong>Saving Account</strong><br>
                                    <small>This policy allows you to decide which method should use to collect
                                        customer's repayment. If it use a Saving account you should allow this policy.
                                        Else, Recipts will be use to collect repayments. For enable this feature you
                                        should insert Minimum balance and Interest Rate of saving account.
                                    </small>
                                </td>
                                <td align='center'>
                                    <select class="form-control" name="plc_sav_acc" id="plc_sav_acc"
                                            onchange="setSav();">
                                        <option value="1">Allow</option>
                                        <option value="2">Disallow</option>
                                    </select>
                                    <br><br>
                                    <div class="row" id="saving_acc" style="display:block">
                                        <div class="form-group col-md-6">
                                            <input type="number" id="plc_sav_amt" name="plc_sav_amt"
                                                   class="form-control" placeholder="Min Amt">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="number" id="plc_sav_int" name="plc_sav_int"
                                                   class="form-control" placeholder="Interest">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>08</td>
                                <td><strong>Topup Age Limit</strong><br>
                                    <small>When topup an ongoing loan, age of current loan must below than this Value.
                                    </small>
                                </td>
                                <td align='center'>
                                    <div class="col-md-12"><input type="number" id="plc_topup_age" name="plc_topup_age"
                                                                  class="form-control" placeholder=""></div>
                                </td>
                            </tr>
                            <tr>
                                <td>09</td>
                                <td><strong>Minimum Tenner Precentage for Topup</strong><br>
                                    <small>When topup a loan, Precantage of paid installment from total installment of
                                        loan must be higher than this value.
                                    </small>
                                </td>
                                <td align='center'>
                                    <div class="input-group col-md-12">
                                        <input type="number" id="plc_topup_ins" name="plc_topup_ins"
                                               class="form-control" placeholder="">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><strong>Minimum Paid Precentage for Topup</strong><br>
                                    <small>When topup a loan, Precantage of paid amount from total
                                        amount(Capital+Interest) of loan must be higher than this value.
                                    </small>
                                </td>
                                <td align='center'>
                                    <div class="input-group col-md-12">
                                        <input type="number" id="plc_topup_amt" name="plc_topup_amt"
                                               class="form-control" placeholder="">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td><strong>Year end Date</strong><br>
                                    <small>This policy allows you to decide Year end Proccess Date of the company. Don't
                                        consider about the year when selecting the date. (*Don't use February 29th as
                                        year end date)
                                    </small>
                                </td>
                                <td align='center'>
                                    <div class="col-md-12"><input type="text" id="plc_year_end" name="plc_year_end"
                                                                  class="form-control" placeholder=""></div>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td><strong>PPI Questionary</strong><br>
                                    <small>This policy allows you to enable or disable PPI Questionary. If this function
                                        is enabled, It will ask an questionary when full registering a customer.
                                    </small>
                                </td>
                                <td align='center'>
                                    <select class="form-control" name="plc_ppi_qst" id="plc_ppi_qst">
                                        <option value="1">Enable</option>
                                        <option value="2">Disable</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td><strong>Default Repayment Value</strong><br>
                                    <small>Select which amount load as default Repayment Value.</small>
                                </td>
                                <td align='center'>
                                    <select class="form-control" name="plc_repay_amt" id="plc_repay_amt">
                                        <option value="1">Installment Amount</option>
                                        <option value="2">Last Paid Amount</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td><strong>Topup Type</strong><br>
                                    <small>This policy allows you to set Loan Topup Permissions. It can be configure to
                                        topup any product or only for same category.
                                    </small>
                                </td>
                                <td align='center'>
                                    <select class="form-control" name="plc_topup_type" id="plc_topup_type">
                                        <option value="1">To Any Product</option>
                                        <option value="2">Only Same Category</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td><strong>Reprint Tag</strong><br>
                                    <small>If this policy Enabled, all the reprints including vouchers and cheques print
                                        with Reprint Tag. Disable it if you don't need it.
                                    </small>
                                </td>
                                <td align='center'>
                                    <select class="form-control" name="plc_reprint_tag" id="plc_reprint_tag">
                                        <option value="1">Enable</option>
                                        <option value="2">Disable</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td><strong>Center Leader</strong><br>
                                    <small>If this policy Enabled, None can create a Loan without Center Leader at the
                                        related Center.
                                    </small>
                                </td>
                                <td align='center'>
                                    <select class="form-control" name="plc_cen_leader" id="plc_cen_leader">
                                        <option value="1">Enable</option>
                                        <option value="2">Disable</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success pull-right">Process</button>

                </div>
            </div>

        </div>
    </div>

</div>
<!-- END PAGE CONTENT WRAPPER -->












