<script type= 'text/javascript'>
    $(document).ready(function() {


    });
</script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">IP Settings</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <form action="<?= site_url('SmsController/ctl_saveIpAddress') ?>" method="post">
                            <div class="form-group">
<!--                            <ul class="list-group list-group-unbordered">-->
<!---->
<!--                                <li><b>IP Address</b> <input class="pull-right" type="text" value="" id="smsIpAddress" name="smsIpAddress"/></li>-->
<!--                                 <li> <input id="submit" type="submit" name="btn_update" value="Save" onclick="" class="btn btn-lg btn-success btn-block"/></li>-->
<!--                            </ul>-->


                                <label for="exampleInputEmail1">IP Address</label>
                                <input class="pull-right" type="text" value="" id="smsIpAddress" name="smsIpAddress"/>
                                 <hr>
                                <input id="submit" type="submit" name="btn_update" value="Save" onclick="" class="btn btn-lg btn-success btn-block"/>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>



        </div>
    </div>

    <!-- /.row -->
</div>