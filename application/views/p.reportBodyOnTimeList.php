<script type= 'text/javascript'>
    $(document).ready(function() {
/*        $('#dataTables').DataTable({
            "ajax": {
                url : "<!--?php echo site_url("PageController/ReportOnTimeUserDataTable") ?-->",
                type : 'GET'
            }




        });*/

        $('#dataTables').DataTable({
            "ajax": {
                url : "<?php echo site_url("PageController/ctl_GateHistoryEarlyTimeline") ?>",
                type : 'GET'
            }
        });

    });
</script>

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">On Time Logins</h1>
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
                                                <th>Card ID</th>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Type</th>
                                                <th>Gate Id</th>

                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                    <!-- /.panel-body -->





                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- /.row -->
                </div>