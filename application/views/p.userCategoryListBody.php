<script type= 'text/javascript'>
    $(document).ready(function() {
       var table =  $('#dataTables').DataTable({
            "ajax": {
                url: "<?php echo site_url("PageController/ctl_GetAllUserCategory") ?>",
                type: 'GET'

            }, "columnDefs": [

               {
                   "targets": 0,
                   "visible": false,
                   "searchable": false
               },
               {
                    "targets": 7,
                    "render": function ( data)
                    {
                        if(data == 'O')
                        {
                            return '<button id="btn_EditCategoryDetails">Edit</button> | <button id="btn_DeleteCategoryDetails">Delete</button>';
                        }
                        else return '<button id="btn_EditCategoryDetails">Edit</button>| <button id="btn_DeleteCategoryDetails">Delete</button>';
                    }
                }]

        });

        $('#dataTables tbody').on( 'click', '#btn_EditCategoryDetails', function () {
            $('#EditCategoryDetailsModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#edit_catID').attr('value', data[0]);
            $('#edit_catName').attr('value', data[1]);
            $('#edit_catType').attr('value', data[2]);
            $('#edit_catTime').attr('value', data[3]);
            $('#edit_catAbsentTime').attr('value', data[4]);


        } );


        $('#dataTables tbody').on( 'click', '#btn_DeleteCategoryDetails', function () {
            $('#DeleteCategoryDetailsModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#dlt_catID').attr('value', data[0]);
            $('#dlt_catName').attr('value', data[1]);
            $('#dlt_catType').attr('value', data[2]);
            $('#dlt_catTime').attr('value', data[3]);
            $('#dlt_catAbsentTime').attr('value', data[4]);


        } );



        $('#btn_AddModal').on( 'click', function () {

            $('#AddCategoryModal').modal("show")


        });


    });
</script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User Category</h1>

            </div>

        </div>
        <div class="row">
            <button type="button" id="btn_AddModal" class="btn btn-primary btn-lg" style="float:right;">Add Category</button>
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
                                <th>Category Name</th>
                                <th>Type</th>
                                <th>On Time Setting</th>
                                <th>Absent Time Setting</th>
                                <th>Created By</th>
                                <th>Update Date</th>
                                <th>Option</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                    <!-- /.panel-body -->





                </div>
            </div>

            <div class="modal fade" id="EditCategoryDetailsModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Update Card Details</h3>

                        </div>
                        <div class="modal-body">
                            <form action="<?= site_url('DataController/ctl_editGateUserCategory') ?>" method="post" autocomplete="off">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Category ID" id="edit_catID" name="edit_catID"  value="" readonly style="display: none;">
                                        <input class="form-control" placeholder="Category Name" id="edit_catName" name="edit_catName"  value=""><br/>
                                        <input class="form-control" placeholder="Category Type" id="edit_catType" name="edit_catType"  value=""><br/>
                                        <input class="form-control" placeholder="On Time Setting" id="edit_catTime" name="edit_catTime"  value=""><br/>
                                        <input class="form-control" placeholder="Absent Time Setting" id="edit_catAbsentTime" name="edit_catAbsentTime"  value=""><br/>
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


            <div class="modal fade" id="DeleteCategoryDetailsModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Update Card Details</h3>

                        </div>
                        <div class="modal-body">
                            <form action="<?= site_url('DataController/ctl_deleteGateUserCategory') ?>" method="post" autocomplete="off">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Category ID" id="dlt_catID" name="dlt_catID"  value="" readonly style="display: none;">
                                        <input class="form-control" placeholder="Category Name" id="dlt_catName" name="dlt_catName"  value="" readonly><br/>
                                        <input class="form-control" placeholder="Category Type" id="dlt_catType" name="dlt_catType"  value="" readonly><br/>
                                        <input class="form-control" placeholder="On Time Setting" id="dlt_catTime" name="dlt_catTime"  value="" readonly><br/>
                                        <input class="form-control" placeholder="Absent Time Setting" id="dlt_catAbsentTime" name="dlt_catAbsentTime"  value="" readonly >
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






            <div class="modal fade" id="AddCategoryModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Update Card Details</h3>

                        </div>
                        <div class="modal-body">
                            <form action="<?= site_url('DataController/AddGateUserCategory') ?>" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Category Name" name="catName" id="catName" value="" autocomplete="false" autofocus><br/>
                                        <input class="form-control" placeholder="Category Code" id="catType" name="catType" autocomplete="false" autofocus><br/>
                                        <input class="form-control" placeholder="Set Late Time (HH:MM:SS) Military Time" name="catTime" id="catTime" value="" autocomplete="false" autofocus><br/>
                                        <input class="form-control" placeholder="Set Absent Time (HH:MM:SS) Military Time" name="absTime" id="absTime" value="" autocomplete="false" autofocus><br/>
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


    <!-- /.row -->
</div>