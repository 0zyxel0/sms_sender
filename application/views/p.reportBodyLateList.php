<script type= 'text/javascript'>
    $(document).ready(function() {
      var table = $('#dataTables').DataTable({
            "ajax": {
                url : "<?php echo site_url("PageController/ctl_gateHistoryLateTimeline") ?>",
                type : 'GET'
            },"columnDefs": [


               {
                   "targets": 7,
                   "visible": false,
                   "searchable": false
               },
               {
                   "targets": 8,
                   "visible": false,
                   "searchable": false
               },

               {
               "targets": 9,
               "data": null,
               "defaultContent": "<button id='btn_notifyContact'>Notify</button>"
           }
                            ]

        });

        $('#dataTables tbody').on( 'click', '#btn_notifyContact', function () {
            $('#NotifyContactModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#notify_contactName').attr('value',data[7]);
            $('#NumberTo').attr('value',data[8]);
            $('#StudentNames').attr('value',data[3]+" "+data[4]);


        });

    });
</script>

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Late Logins</h1>
                    </div>
                    <?php require('navReportLinks.php')?>

                </div>
                <div class="row">


                    <div class="col-l-2">
                        <!-- Nav tabs -->
                        <div class="card">

                                    <div class="panel-body">

                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                            <tr>

                                                <th>Time In</th>
                                                <th>Person ID</th>
                                                <th>Card ID</th>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Type</th>
                                                <th>Gate Id</th>
                                                <th>Contact Name</th>
                                                <th>Contact Number</th>
                                                <th>Option</th>

                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                    <!-- /.panel-body -->





                                </div>
                            </div>

                    <div class="modal fade" id="NotifyContactModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Reminder</h3>

                                </div>
                                <div class="modal-body">
                                    <form action="<?= site_url('MsgController/send_SingleSms') ?>" method="post" autocomplete="off">
                                        <fieldset>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="To Contact" name="notify_contactName" id="notify_contactName" value="" readonly><br/>
                                                <input class="form-control" placeholder="Contact Number" name="NumberTo" id="NumberTo" value="" readonly>
                                                <input class="form-control" placeholder="Student" name="StudentNames" id="StudentNames" value="" style="display: none;">
                                                <select class="form-control" id="message" name="message">
                                                    <option value="" selected disabled>-- Template Type --</option>
                                                    <?php

                                                    foreach($msg as $row)
                                                    {
                                                        echo '<option id="addTextMsg" value="'.$row->msg_text.'">'.$row->message_type.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <input id="submit" type="submit" name="padd" value="Send" onclick="" class="btn btn-lg btn-success btn-block"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                        </div>
                    </div>

                    <!-- /.row -->
                </div>

