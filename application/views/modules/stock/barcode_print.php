<!DOCTYPE html>
<html class="">

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">
                <div class="pull-left hidden-xs">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url(); ?>admin"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="">Stock Control</a></li>
                        <li class="active"><strong>Barcode Print</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Barcode Print</h3>
                    <button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#" id="printTg">
                        <span><i class="fa fa-print"></i></span> Print
                    </button>

                    <button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#modalAdd" id="clrAll">
                        <span><i class="fa fa-plus"></i></span> Clear All
                    </button>
                </header>

                <div class="content-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">1</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no1" id="no1" value="" onkeyup="addBarTag(event,this.value,1)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">

                                    <table style="width: 100px; display: none;" id="tb1">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img1"/>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th id="itcd1"></th>
                                            <th id="pric1"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm1"></th>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">2</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control "
                                           name="no2" id="no2" onkeyup="addBarTag(event,this.value,2)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb2">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img2"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd2"></th>
                                            <th id="pric2"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm2"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">3</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no3" id="no3" onkeyup="addBarTag(event,this.value,3)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb3">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img3"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd3"></th>
                                            <th id="pric3"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm3"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">4</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no4" id="no4" onkeyup="addBarTag(event,this.value,4)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb4">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img4"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd4"></th>
                                            <th id="pric4"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm4"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">5</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no5" id="no5" onkeyup="addBarTag(event,this.value,5)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb5">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img5"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd5"></th>
                                            <th id="pric5"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm5"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">6</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no6" id="no6" onkeyup="addBarTag(event,this.value,6)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb6">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img6"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd6"></th>
                                            <th id="pric6"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm6"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">7</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no7" id="no7" onkeyup="addBarTag(event,this.value,7)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb7">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img7"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd7"></th>
                                            <th id="pric7"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm7"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">8</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no8" id="no8" onkeyup="addBarTag(event,this.value,8)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb8">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img8"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd8"></th>
                                            <th id="pric8"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm8"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">9</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no9" id="no9" onkeyup="addBarTag(event,this.value,9)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb9">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img9"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd9"></th>
                                            <th id="pric9"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm9"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">10</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no10" id="no10" onkeyup="addBarTag(event,this.value,10)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb10">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img10"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd10"></th>
                                            <th id="pric10"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm10"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">11</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no11" id="no11" onkeyup="addBarTag(event,this.value,11)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb11">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img11"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd11"></th>
                                            <th id="pric11"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm11"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">12</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no12" id="no12" onkeyup="addBarTag(event,this.value,12)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb12">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img12"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd12"></th>
                                            <th id="pric12"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm12"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">13</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no13" id="no13" onkeyup="addBarTag(event,this.value,13)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb13">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img13"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd13"></th>
                                            <th id="pric13"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm13"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">14</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no14" id="no14" onkeyup="addBarTag(event,this.value,14)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb14">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img14"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd14"></th>
                                            <th id="pric14"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm14"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">15</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no15" id="no15" onkeyup="addBarTag(event,this.value,15)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb15">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img15"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd15"></th>
                                            <th id="pric15"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm15"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">16</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no16" id="no16" onkeyup="addBarTag(event,this.value,16)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb16">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img16"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd16"></th>
                                            <th id="pric16"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm16"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">17</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no17" id="no17" onkeyup="addBarTag(event,this.value,17)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb17">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img17"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd17"></th>
                                            <th id="pric17"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm17"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">18</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no18" id="no18" onkeyup="addBarTag(event,this.value,18)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb18">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img18"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd18"></th>
                                            <th id="pric18"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm18"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">19</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no19" id="no19" onkeyup="addBarTag(event,this.value,19)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb19">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img19"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd19"></th>
                                            <th id="pric19"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm19"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">20</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no20" id="no20" onkeyup="addBarTag(event,this.value,20)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb20">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img20"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd20"></th>
                                            <th id="pric20"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm20"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <div class="col-md-1 col-xs-1"><label class=" control-label">21</label>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <input type="text" class="form-control pybx "
                                           name="no21" id="no21" onkeyup="addBarTag(event,this.value,21)"/>
                                </div>
                                <div class="col-md-7 col-xs-8">
                                    <table style="width: 100px; display: none;" id="tb21">
                                        <tbody>
                                        <tr>
                                            <th>
                                                <img src="" id="img2"/></th>
                                        </tr>
                                        <tr>
                                            <th id="itcd21"></th>
                                            <th id="pric21"></th>
                                        </tr>
                                        <tr>
                                            <th id="itnm21"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                </div>

            </section>
        </div>

    </section>
</section>
<!-- END CONTENT -->

<!-- View Model -->
<div class="modal" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-backdrop in" style="height: 100%; z-index: -10"></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Print Barcode</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Branch</label>
                                            <label class="col-md-4  control-label" id="brch_cnt_vew"></label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Officer</label>
                                            <label class="col-md-4  control-label" id="cnt_exc_vew"></label>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Center Name</label>
                                            <label class="col-md-4  control-label" id="cntnm_vew"></label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Collection Day</label>
                                            <label class="col-md-4  control-label" id="coldy_vew"></label>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">From Time</label>
                                            <label class="col-md-4  control-label" id="frotm_vew"> </label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-md-4  control-label">To Time</label>
                                            <label class="col-md-4  control-label" id="totm_vew"> </label>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Max Member</label>
                                            <label class="col-md-4  control-label" id="mxmbr_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Remarks</label>
                                            <label class="col-md-8 control-label" id="remk_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Longitude</label>
                                            <label class="col-md-4  control-label" id="gplg_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Latitude</label>
                                            <label class="col-md-4 control-label" id="gplt_vew"></label>
                                        </div>
                                    </div>
                                </div>

                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="window.print();">print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End View Model -->

<!--GENERATE NUMBER MODAL-->
<div class="modal" id="modal_gennummedt" tabindex="-2" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true"
     style="margin-top: 10%">
    <div class="modal-backdrop in" style="height: 100%; z-index: -10"></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">Generate Number</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Type</label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="form-control"
                                                    name="notypeedt" id="notypeedt"
                                                    onchange="">
                                                <option value="0"> -- Select Type --
                                                </option>
                                                <option value="1"> Barcode No</option>
                                                <option value="2"> Serial No</option>
                                                <option value="3"> IMEI No</option>
                                                <option value="4"> Part No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">If
                                            Sequence</label>
                                        <div class="col-md-6 ">
                                            <label class="switch">
                                                No
                                                <input onchange="squenceedt()"
                                                       class="iswitch iswitch-md iswitch-primary"
                                                       name="sameedt" id="sameedt"
                                                       type="checkbox" value="1"/>
                                                Yes <span></span> </label>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="form-group" id="seqeedt"
                                         style="display: block">
                                        <label class="col-md-4 col-xs-6 control-label">
                                            Enter No.
                                        </label>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" class="form-control"
                                                   id="normlnumedt" name="normlnumedt">
                                        </div>
                                    </div>
                                    <div class="form-group" id="strtedt"
                                         style="display: none">
                                        <label class="col-md-4 col-xs-6 control-label">
                                            Start No.
                                        </label>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" class="form-control"
                                                   id="strtnumedt" name="strtnumedt">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="gennumberedt();"
                        class="btn btn-success "
                        id="cp_accept">Accept
                </button>
                <button type="button" data-dismiss="modal"
                        class="btn btn-default">Close
                </button>
            </div>
        </div>
    </div>
</div>
<!--GENERATE NUMBER MODAL-->

<!-- END CONTAINER -->
</html>

<script>
    $().ready(function () {

        srchBarTag();

    });

    function chckBtn(id, httml) {
        if (id == '-') {
            document.getElementById(httml).style.borderColor = "red";
        } else {
            document.getElementById(httml).style.borderColor = "";
        }
    }

    // ADD BARCODE TO TMP TABLE
    function srchBarTag() {
        //onsole.log(posi + ' ** ' + val);

        var jqXHR = jQuery.ajax({
            type: "POST",
            url: "<?= base_url(); ?>stock/getBcodeTmp",
            data: {},
            dataType: 'json',
            success: function (data) {

                var len = data.length;
                var imgn = '';

                for (var a = 0; a < 20; a++) {

                    if (len > 0) {
                        if (a < len) {
                            document.getElementById('tb' + data[a]['auid']).style.display = 'block';
                            document.getElementById('img' + data[a]['auid']).src = "../uploads/barcode/" + data[a]['bcde'] + '.png';
                            document.getElementById('itcd' + data[a]['auid']).innerHTML = data[a]['itcd'];
                            document.getElementById('pric' + data[a]['auid']).innerHTML = numeral(data[a]['pric']).format('0,0.00');
                            document.getElementById('itnm' + data[a]['auid']).innerHTML = data[a]['itnm'];

                            document.getElementById('no' + (+data[a]['auid'] + +1)).focus();
                            document.getElementById('no' + data[a]['auid']).style.borderColor = '';

                        } else {
                            var b = a + 1;
                            document.getElementById('tb' + b).style.display = 'none';
                            //document.getElementById('img' + b).src = "../uploads/barcode/" + '00000.png';
                            document.getElementById('img' + b).src = "";
                            document.getElementById('itcd' + b).innerHTML = '--';
                            document.getElementById('pric' + b).innerHTML = numeral(000).format('0,0.00');
                            document.getElementById('itnm' + a).innerHTML = '---';
                            document.getElementById('no' + (+b + +1)).focus();
                            document.getElementById('no' + b).style.borderColor = '';
                        }
                    }
                }
            },
            error: function () {
                swal({title: "", text: "No XXX", type: "info"},);
                document.getElementById('no' + data[a]['auid']).style.borderColor = 'red';
            }
        });
    }

    // ADD BARCODE TO TMP TABLE
    function addBarTag(event, val, posi) {
        //console.log(posi + ' ** ' + val);

        if (event.keyCode == 13) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>stock/addBcodeTmp",
                data: {
                    val: val,
                    posi: posi
                },
                dataType: 'json',
                success: function (data) {
                    document.getElementById('tb' + posi).style.display = 'block';
                    document.getElementById('img' + posi).src = "../uploads/barcode/" + val + '.png';
                    document.getElementById('itcd' + posi).innerHTML = data[0]['itcd'];
                    document.getElementById('pric' + posi).innerHTML = numeral(data[0]['pric']).format('0,0.00');
                    document.getElementById('itnm' + posi).innerHTML = data[0]['itnm'];

                    document.getElementById('no' + (+posi + +1)).focus();
                    document.getElementById('no' + posi).style.borderColor = '';
                },
                error: function () {
                    swal({title: "", text: "No item this code", type: "info"},);

                    document.getElementById('no' + posi).style.borderColor = 'red';
                }
            });
        }
    }

    // CLEAR ALL
    $("#clrAll").on('click', function (e) {
        e.preventDefault();
        var jqXHR = jQuery.ajax({
            type: "POST",
            url: "<?= base_url(); ?>stock/clerBcdeAll",
            data: {},
            dataType: 'json',
            success: function (data) {

                $('.pybx').val('');

                location.reload();

            },
            error: function () {
                swal({title: "", text: "Some error,, Contact system admin..", type: "error"},);
            }
        });
        //document.getElementById("process_btn").disabled = true;
    });

    // TAG PRINT
    $("#printTg").on('click', function (e) {
        e.preventDefault();
//        var jqXHR = jQuery.ajax({
//            type: "POST",
//            url: "<?//= base_url(); ?>//stock/clerBcdeAll",
//            data: {},
//            dataType: 'json',
//            success: function (data) {
//
//                $('.pybx').val('');
//
//                location.reload();
//
//            },
//            error: function () {
//                swal({title: "", text: "Some error,, Contact system admin..", type: "error"},);
//            }
//        });
        //document.getElementById("process_btn").disabled = true;


            //var d1 = '/' + id;
            window.open('<?= base_url(); ?>Stock/barTagPrint', 'popup', 'width=800,height=600,scrollbars=no,resizable=no');


    });


</script>