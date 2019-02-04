<script type= 'text/javascript'>
    $(document).ready(function() {
        $('#dataTables').DataTable({


            "ajax": {
                url : "<?php echo site_url("PageController/ReportStudentListTable") ?>",
                type : 'GET'

                    },
            "columnDefs": [
                {
                    "targets": 0,
                    "render": function ( data)
                        { if (data == null){
                            return ' ';
                        }else return '<img src="<?php echo base_url()?>'+data+'" height="50px" width="50px"">';
                        }
                },
                {
                    "targets": 6,
                    "render": function ( data)
                    {
                        if(data == 'Y'){
                            return '<button>EDIT</button>';
                        }
                        else return '<button>UPLOAD</button>';
                    }
                }

            ]

        });


        var table = $('#dataTables').DataTable();

        $('#dataTables tbody').on( 'click', 'tr', function () {
            console.log( table.row( this ).data() );
            alert("sdfg");
        } );




    });
</script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Student List</h1>
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
                                <th id="userImageBoxPlacement">Photo</th>
                                <th>Student Number</th>
                                <th>Family Name</th>
                                <th>Given Name</th>
                                <th>Application Type</th>
                                <th>Student Status</th>
                                <th>Upload Photo</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Photo</th>
                                <th>Student Number</th>
                                <th>Family Name</th>
                                <th>Given Name</th>
                                <th>Application Type</th>
                                <th>Student Status</th>
                                <th>Upload Photo</th>
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