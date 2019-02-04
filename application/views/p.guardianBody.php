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
         url : "<?php echo site_url("PageController/ctl_GetGuardianList") ?>",
         type : 'GET'
         },"columnDefs": [
               {
                   "targets": 0,
                   "visible": false,
                   "searchable": false
               },
               {
                "targets": 6,
                "data": null,
                "defaultContent": '<button id="btn_EditGuardianDetails">Edit</button>'
                }
        ]
         });


        $('#dataTables tbody').on( 'click', '#btn_EditGuardianDetails', function () {
            $('#EditGuardianModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#edit_userContactid').attr('value', data[0]);
            $('#edit_ContactName').attr('value', data[3]);
            $('#edit_Relation').attr('value', data[4]);
            $('#edit_Number').attr('value', data[5]);


        });

    });
</script>

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">User Emergency Contact List</h1>
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
                                                <th>User Name</th>
                                                <th>Type</th>
                                                <th>Contact Name</th>
                                                <th>Relationship</th>
                                                <th>Contact Number</th>
                                                <th>Option</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="EditGuardianModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Update Card Details</h3>

                            </div>
                            <div class="modal-body">
                                <form action="<?= site_url('DataController/ctl_EditPersonContact') ?>" method="post" autocomplete="off">
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Contact ID" id="edit_userContactid" name="edit_userContactid"  value="" readonly style="display: none;">
                                            <input class="form-control" placeholder="Contact Name" id="edit_ContactName" name="edit_ContactName"  value=""><br/>
                                            <input class="form-control" placeholder="Relationship" id="edit_Relation" name="edit_Relation"  value=""><br/>
                                            <input class="form-control" placeholder="Contact Number" id="edit_Number" name="edit_Number"  value=""><br/>
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
</div>