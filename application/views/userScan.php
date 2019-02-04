<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">



    <?php require('StyleBundle.php')?>
    <?php require('ScriptBundle.php')?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>


    <![endif]-->
    <script type="text/javascript">
        $(document).ready(function() {


            $('#dataTables').DataTable({
                "ajax": {
                    url : "<?php echo site_url("PageController/ctl_getUserImageTimeline") ?>",
                    type : 'GET'

                },"columnDefs":
            [
                {
                    "targets": 0,
                    "render": function ( data)
                    {
                        if (data == null)
                        {
                            return ' ';
                        }else return '<img src="<?php echo base_url()?>'+data+'" height="100px" width="100px" style="text-align:center;">';
                    }
                }],

                "bFilter": false,
                "searching": false,
                "paging": false,
                "info": false,
                "lengthChange":false,
                "ordering": false

            });



            /*          $("#btnStart").click(function(){
                     $.ajax({
                         type: "GET",
                         url: "http://localhost:8899/Phton/gate_consumer.py"
                     });
                 });
                 var interval = 1000;
                 var refresh = function() {
                     $.ajax({
                         type: "GET",
                         url: "<!?php echo site_url('PageController/TrialGet'); ?>",

                         success: function (data) {
                             var json = JSON.parse(data);
                             var jsonVal = Object.values(json.getGateTopUp.result_object[0]);
                             var arr = [];
                             var count = 0;
                             for(var x in jsonVal){
                                 arr.push(jsonVal[x]);
                                 count ++;
                                 }
                             var db_image_path =jsonVal[0].toString();
                             var image_path_concat = '<!?php echo base_url()?>' + db_image_path;
                                 $("#scanned_user_pic").attr('src',image_path_concat);
                                 $("#scanned_user_id").text(jsonVal[1]);
                                 $("#scanned_user_college").text(jsonVal[3]);
                                 $("#scanned_user_timestamp").text(jsonVal[2]);
                             console.log(image_path_concat);
                             setTimeout(function () {refresh();}, interval);
                         },
                         error: function(xhr, status, error){
                             console.log(status);
                             console.log(error);
                             console.log(xhr);}
                     });

                 }
                 refresh();*/

            $("#btnStart").click(function(){
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url("PageController/ctl_getUserImageTimeline") ?>",
                    success:function(response){

                        var json = JSON.parse(data);

                        var jsonVal = Object.values(json.imageHistory.result_object[0]);
                        var arr = [];
                        var count = 0;
                        for(var x in jsonVal){
                            arr.push(jsonVal[x]);
                            count ++;
                            for (var y in count){
                            console.log(jsonVal[x]);}
                        }



                    }
                });
            });


        });


    </script>

    <style>
        .sidebar{
            background-color:#eee;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
        }
    </style>
</head>

<body>

    <div class="wrapper">
    <?php require('navBarScanner.php')?>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">


        <div class="panel-body">
                            <div class="table-responsive">
                                <div class="wrapper">
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                    <td colspan="2" style="text-align: center; border-color: transparent;">

                                         <img id="scanned_user_pic" src="" width="300" height="300">

                                    </td>
                                    </tbody>
                                    <tbody>

                                            <tr>
                                                <th>Student Number</th>
                                                <td id="scanned_user_id"></td>
                                            </tr>
                                            <tr>
                                                <th>ID Number</th>
                                                <td id="scanned_user_college"></td>
                                            </tr>
                                            <tr>
                                                <th>Time Stamp</th>
                                                <td id="scanned_user_timestamp"></td>
                                            </tr>
                                    </tbody>

                                </table>

                            <!-- /.table-responsive -->
                                </div></div>

                </div>

            </div>

        </div>
        <div class="col-xs-4 sidebar">


            <section>
                <h3 style="text-align: center;">History</h3>
                <table width="100%"class="table dataTable no-footer dtr-inline" id="dataTables" style="text-align:center;">
                    <thead>
                    <tr>
                        <th style="display: none;">url</th>

                    </tr>
                    </thead>
                </table>
            </section>

        </div> <!--./col-->





    </div>








</body>

</html>
