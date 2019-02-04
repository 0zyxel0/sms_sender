
<script type= 'text/javascript'>
    $(document).ready(function() {
       /* $('#dataTables').DataTable({
            "ajax": {
                url : "<!--?php echo site_url("PageController/ReportDataTable") ?-->",
                type : 'GET'
            }
        });*/

       var table =  $('#dataTables').DataTable({
         "ajax": {
         url : "<?php echo site_url("PageController/ctl_GetMsgTemplateList") ?>",
         type : 'GET'
         },"columnDefs": [
               {
                   "targets": 0,
                   "visible": false,
                   "searchable": false
               },

             {
                 "targets": 5,
                 "data": null,
                 "defaultContent": "<button id='btn_EditMessage'>Edit</button> | <button id='btn_DeleteMessage'>Delete</button>"
             } ]
         });

        $('#dataTables tbody').on( 'click', '#btn_EditMessage', function () {
            $('#EditMSGTemplateModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#msgId').attr('value', data[0]);
            $('#msgType').attr('value', data[1]);
            $('#msgTxt').val(data[2]);

        } );

        $('#dataTables tbody').on( 'click', '#btn_DeleteMessage', function () {
            $('#DeleteMSGTemplateModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#dlt_msgId').attr('value', data[0]);
            $('#dlt_msgType').attr('value', data[1]);
            $('#dlt_msgTxt').val(data[2]);

        } );



        $('#btn_AddModal').on( 'click', function () {

            $('#AddMessagebox').modal("show")

        });

    });
</script>

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Message Templates</h1>
                    </div>
                    <div class="row">
                    <button type="button" id="btn_AddModal" class="btn btn-primary btn-lg" style="float:right;">Add Message Type</button>
                    </div>
                <div class="row">



                                      <div class="col-l-2">
                        <!-- Nav tabs -->
                        <div class="card">

                                    <div class="panel-body">

                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Message Type</th>
                                                <th>Message</th>
                                                <th>Updated By</th>
                                                <th>Updated On</th>
                                                <th>Option</th>


                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <div class="modal fade" id="EditMSGTemplateModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Message Details</h3>

                </div>
                <div class="modal-body">
                    <form action="<?= site_url('DataController/ctl_EditMsgTemplateDetails') ?>" id="msgForm" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Message ID" id="msgId" name="msgId"  value="" autocomplete="false" style="display: none;">
                                <input class="form-control" placeholder="Message Type" id="msgType" name="msgType"  value="" autocomplete="false" autofocus><br/>
                                <textarea row="3" cols="5"  class="form-control" name="msgTxt" id="msgTxt" value="" autocomplete="false" form="msgForm" placeholder="Enter Message Here.."  maxlength="150" autofocus></textarea>
                            </div>
                            <input id="submit" type="submit" name="padd" value="Save" onclick="" class="btn btn-lg btn-success btn-block"/>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="DeleteMSGTemplateModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Message Details</h3>

                </div>
                <div class="modal-body">
                    <form action="<?= site_url('DataController/ctl_DeleteMsgTemplateDetails') ?>" id="msgForm" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Message ID" id="dlt_msgId" name="dlt_msgId"  value="" autocomplete="false" style="display: none;" readonly>
                                <input class="form-control" placeholder="Message Type" id="dlt_msgType" name="dlt_msgType"  value="" autocomplete="false" readonly><br/>

                                <textarea row="3" cols="5"  class="form-control" name="dlt_msgTxt" id="dlt_msgTxt" value="" autocomplete="false" form="msgForm" placeholder="Enter Message Here.."  maxlength="150" readonly></textarea>
                            </div>
                            <input id="submit" type="submit" name="padd" value="Delete" onclick="" class="btn btn-lg btn-danger btn-block"/>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="AddMessagebox" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Message Details</h3>

                </div>
                <div class="modal-body">
                    <form action="<?= site_url('DataController/ctl_addMessageTemplate') ?>" id="msgForm2" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Message Type" id="msgType" name="msgType" autocomplete="false" autofocus><br/>

                                <textarea row="3" cols="5"  class="form-control" name="msgTxt" id="msgTxt" value="" autocomplete="false" form="msgForm2" placeholder="Enter Message Here.."  maxlength="150" autofocus></textarea>
                            </div>
                            <input id="submit" type="submit" name="padd" value="Save" onclick="" class="btn btn-lg btn-success btn-block"/>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>







</div>