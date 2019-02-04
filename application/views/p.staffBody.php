<script type= 'text/javascript'>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            "ajax": {
                url : "<?php echo site_url("PageController/ReportStaffListTable") ?>",
                type : 'GET'
            },
        });
    });
</script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Staff List</h1>
            </div>


            <!--                    <div class="panel-heading">
                                    <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>
                                </div>-->
            <!-- /.panel-heading -->



            <!-- /.col-lg-12 -->
        </div>
        <div class="row">


            <div class="col-l-2">
                <!-- Nav tabs -->
                <div class="card">

                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Staff ID</th>
                                <th>Family Name</th>
                                <th>Given Name</th>
                                <th>Status</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Staff ID</th>
                                <th>Family Name</th>
                                <th>Given Name</th>
                                <th>Status</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.panel-body -->





                </div>
            </div>


        </div>
    </div>

    <!-- /.row -->
</div>