<script type= 'text/javascript'>
    $(document).ready(function() {

       var table = $('#dataTables').DataTable({
            "ajax": {
                url : "<?php echo site_url("PageController/ctl_getGateUsersForCardAssignment") ?>",
                type : 'GET'

            }, "columnDefs": [
               {
                   "targets": 0,
                   "visible": false,
                   "searchable": false
               },
               {
                   "targets": 5,
                   "render": function ( data)
                   {
                       if(data == 0)
                       {
                           return 'Active';
                       }
                       else return 'Disabled';
                   }
               },
                {
                    "targets": 6,
                    "render": function ( data)
                    {
                        if(data != null)
                        {
                            return '<button id="">Assign</button>';
                        }
                        else return '<button id="btn_EditCardDetails">Edit</button>';
                    }
                }



            ]

        });




        $('#dataTables tbody').on( 'click', '#btn_EditCardDetails', function () {
            $('#EditCardDetailsModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#edit_userId').attr('value', data[0]);
            $('#edit_userCardId').attr('value', data[1]);
            $('#edit_userGivenName').attr('value', data[2]);
            $('#edit_userLastName').attr('value', data[3]);
            $('#edit_cardStatus').val(data[5]);


        } );

        var jsonList = []
        $('#dataTables tbody').on( 'click', 'tr', function () {
            jsonList.push(table.row( this ).data());
            console.log(jsonList);
        } );

    });
</script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Card Users</h1>

            </div>

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
                                <th>Card Number</th>
                                <th>Last Name</th>
                                <th>Given Name</th>
                                <th>Category</th>
                                <th>Card Status</th>
                                <th>Options</th>

                            </tr>
                            </thead>

                        </table>
                    </div>
                    <!-- /.panel-body -->

                    <div class="modal fade" id="EditCardDetailsModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Update Card Details</h3>

                                </div>
                                <div class="modal-body">

                                    <form action="<?= site_url('DataController/ctl_EditCardAssignmentDetail') ?>" method="post" autocomplete="off">
                                        <fieldset>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Category ID" id="edit_userLastName" name="edit_userLastName"  value="" readonly><br/>
                                                <input class="form-control" placeholder="User ID" id="edit_userGivenName" name="edit_userGivenName"  value="" readonly>
                                                <input class="form-control" placeholder="User ID" id="edit_userId" name="edit_userId"  value="" style="display: none;"><br/>
                                                <input class="form-control" placeholder="Card ID" id="edit_userCardId" name="edit_userCardId"  value=""><br/>
                                                <select class="form-control" id="edit_cardStatus" name="edit_cardStatus">
                                                    <option value="" selected disabled>Card Status</option>
                                                    <option value="0">Active</option>
                                                    <option value="1">Disabled</option>
                                                </select>
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






        </div>
    </div>



    <!-- /.row -->
</div>