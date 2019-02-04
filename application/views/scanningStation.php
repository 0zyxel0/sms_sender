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
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
    <script type="text/javascript">
        $(document).ready(function() {

            $('#cardScan').on('submit',function(e){


                var post_data1 = $('#crdScanned').val();
                var post_data2 = $('#gateStationId').val();

                $.ajax({
                    url: "<?php echo site_url('DataController/checkCardDetails'); ?>",
                    type: 'POST',
                    data: { crdScanned: post_data1,
                        gateStationId: post_data2
                    }, // This is all you have to change
                    success: function (data) {
                        $('#crdScanned').val('');
                        console.log("Submitted Data!");

                    }
                });return false;
            });




            var interval = 500;
            var refresh = function() {
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('DataController/getRecentGateTopUp'); ?>",

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
                        var image_path_concat = '<?php echo base_url()?>' + db_image_path;
                        $("#scanned_user_pic").attr('src',image_path_concat);
                        $("#scanned_user_id").text(jsonVal[1]);
                        $("#scanned_user_college").text(jsonVal[3]);
                        $("#scanned_user_timestamp").text(jsonVal[2]);
                        $("#scanned_user_course").text(jsonVal[4]);



                        console.log(image_path_concat);
                        setTimeout(function () {refresh();}, interval);
                    }
                });

            }
            refresh();

        });


    </script>
</head>

<body>

    <div class="wrapper">
    <?php require('navBarScanner.php')?>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                    <div class="row">
            			<!--div class="col-md" style="text-align:center; margin-top:10%;;">
            				<img src="<!?php echo base_url(); ?>ui/img/stock.png" width="300" height="300">
                        </div-->
                    </div>
        <div class="panel-body">
                            <div class="table-responsive">
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
                                                <th>Course Code</th>
                                                <td id="scanned_user_course"></td>
                                            </tr>
                                            <tr>
                                                <th>Time Stamp</th>
                                                <td id="scanned_user_timestamp"></td>
                                            </tr>
                                    </tbody>

                                </table>
                          
                            <!-- /.table-responsive -->
                            </div>
                        <p>
                            <form id="cardScan" method="post" autocomplete="off">
                            <input name="crdScanned" id="crdScanned" value=""  style=" background: transparent;border: none; color:#f8f8f8; width:500px;   outline-width: 0;" autofocus>
                            <input class="form-control"  name="gateStationId" id="gateStationId" value="GTONE" type="hidden" autofocus>
                            <button id="btnCheck" class="btn btn-primary btn-lg btn-block" style="display: none;">check</button>
                            </form>
                </div>
            </div>
        </div>
    </div>




</body>

</html>
