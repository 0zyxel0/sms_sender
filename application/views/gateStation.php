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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#changing').css('opacity', 0);
            $('#cardScan').on('submit',function(e){


                var post_data1 = $('#crdScanned').val();
                var post_data2 = $('#gateStationId').val();
                $("#hotreload")[0].contentWindow.document.getElementById('crdScanned').value = post_data1;
                $("#hotreload")[0].contentWindow.document.getElementById('btn_pass').click();
                $.ajax({
                    url: "<?php echo site_url('DataController/checkCardDetails'); ?>",
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: { crdScanned: post_data1,
                        gateStationId: post_data2
                    }, // This is all you have to change
                    success: function (data) {
                        $('#crdScanned').val('');
                        console.log(post_data1);
                        refresh();
                        console.log(data);

                    }
                });return false;
            });

            var reloadIFrame = function () {
                document.frames["hotreload"].location.reload();
                console.log('refresh');
            }

            var sendSMSNotification= function(){
                $.ajax({
                    url: "<?php echo site_url('DataController/ctl_buildSmsNotification'); ?>",
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: { crdScanned: post_data1
                    }, // This is all you have to change
                    success: function (data) {

                        console.log(data);

                    }
                });return false;
            }




            var refresh = function() {
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('DataController/ctl_extractUserIdScan'); ?>",
                    cache: false,
                    async: false,
                    success: function (data) {



                        var json = JSON.parse(data);
                        var jsonVal = Object.values(json.userDataScanned.result_object[0]);
                        var arr = [];
                        var count = 0;
                        for(var x in jsonVal){
                            arr.push(jsonVal[x]);
                            count ++;
                        }
                        var db_image_path =jsonVal[0].toString();
                        var image_path_concat = '<?php echo base_url()?>' + db_image_path;
                        $("#scanned_user_pic").attr('src',image_path_concat);
                        $("#scanned_user_id").text(jsonVal[5]);
                        $("#scanned_user_name").text(jsonVal[2]+ ' ' +jsonVal[3]);
                        $("#scanned_user_timestamp").text(jsonVal[4]);



                    }
                });

                hideDetails();
                reloadIFrame()
                $('#dataTables').DataTable().ajax.reload();



            }



function hideDetails(){
    var interval = 6000;
    $('#changing').css('opacity',100);
    setTimeout(function () {
        $('#changing').css('opacity',0);
    }, interval);
};



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

                    <div class="row">

                    </div>
        <div class="panel-body" id="changing">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                    <td colspan="2" style="text-align: center; border-color: transparent;">

                                         <img id="scanned_user_pic" src="" width="300" height="300">

                                    </td>
                                    </tbody>
                                    <tbody>

                                            <tr>
                                                <th>User ID</th>
                                                <td id="scanned_user_id"></td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td id="scanned_user_name"></td>
                                            </tr>
                                            <tr>
                                                <th>Time Stamp</th>
                                                <td id="scanned_user_timestamp"></td>
                                            </tr>
                                    </tbody>

                                </table>
                          
                            <!-- /.table-responsive -->
                            </div>

                            <form id="cardScan" method="post" autocomplete="off">
                            <input name="crdScanned" id="crdScanned" value=""  maxlength="10" style=" background: transparent;border: solid; color:#f8f8f8; width:500px;   outline-width: 0;"  autofocus>
                            <input class="form-control"  name="gateStationId" id="gateStationId" value="GTONE" type="hidden" autofocus>
                            <button id="btnCheck" class="btn btn-primary btn-lg btn-block" style="display: none;">check</button>
                            </form>
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
    <div class="row">
        <iframe id="hotreload" src="<?php echo site_url('PageController/loader');?>" style="opacity: 0">

        </iframe>
    </div>



</body>

</html>
