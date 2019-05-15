<script type= 'text/javascript'>
    $(document).ready(function() {



        $("#btn_enable").click(function(){
            $("#triggerStatus").val("");
            $("#triggerStatus").removeAttr('value');
            $("#triggerStatus").val("Processing Messages");
            $("#triggerStatus").attr('value','1');
            pullCurrentIpAddress();
            checkPendingSms();


        });

        $("#btn_disable").click(function(){
            $("#triggerStatus").val("");
            $("#triggerStatus").removeAttr('value');
            $("#triggerStatus").val("Not Processing");
            $("#triggerStatus").attr('value','0');

        });

      var checkPendingSms = function(){


        var checker = $('#triggerStatus').attr('value');
       // console.log(checker);
         if (checker == 1){
             console.log('Checking Pending Messages');
             $.ajax({
                 url: "<?php echo site_url('SmsController/ctl_countPendingSms'); ?>",
                 type: "GET",
                 success: function (data) {
                     $("#pendingCount").val("");
                     $("#pendingCount").val(data);
                     console.log('Start Sending Notification');
                     sendSmsNotification();
                     setTimeout(function(){ checkPendingSms() }, 10000);
                 }
             });
         }
         else
         {
             console.log('Stopped Checking Pending Messages');
         }

      };


      var sendSmsNotification = function(){
          $.ajax({
              url: "<?php echo site_url('SmsController/ctl_updatePendingSmsStatus'); ?>",
              type: "POST",
              success: function (data) {
               //  console.log(data);
                 console.log("Sent Message Complete");
              }
          });
        };

        var pullCurrentIpAddress = function(){
            $.ajax({
                url: "<?php echo site_url('SmsController/ctl_getCurrentIpAddress'); ?>",
                type: "Get",
                success: function (data) {
                    console.log("Initializing IP Address");
                    console.log(data);
                    $("#SmsAddress").val();
                    $("#SmsAddress").val(data);
                }
            });
        };

    });
</script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">SMS Settings</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">

                <!-- Profile Image -->
                <div class="card">
                    <div class="card-body">
<!--                        <ul class="list-group list-group-unbordered">-->
<!--                            <li class="list-group-item">-->
<!---->
<!--                                <b>Pending Messages</b> <input class="pull-right" type="text" id="pendingCount" readonly/>-->
<!--                            </li>-->
<!--                            <li class="list-group-item">-->
<!--                                <b>IP Address</b> <input class="pull-right" type="text" name="SmsAddress" id="SmsAddress" readonly/>-->
<!--                            </li>-->
<!--                            <li class="list-group-item">-->
<!--                                <b>Status</b> <input class="pull-right" type="text" id="triggerStatus" value="" readonly/>-->
<!--                            </li>-->
<!--                        </ul>-->



                        <div class="form-group">
                            <label for="exampleInputEmail1">Pending Messages</label>
                            <input class="pull-right" type="text" id="pendingCount" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">IP Address</label>
                            <input class="pull-right" type="text" name="SmsAddress" id="SmsAddress" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <input class="pull-right" type="text" id="triggerStatus" value="" readonly/>
                        </div>




                        <button id="btn_enable" class="btn btn-success btn-block"><b>Enable</b></button>
                        <button id="btn_disable" class="btn btn-danger btn-block"><b>Disable</b></button>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>



        </div>
    </div>

    <!-- /.row -->
</div>