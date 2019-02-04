<script type= 'text/javascript'>
    $(document).ready(function() {
        var table = $('#dataTables').DataTable({
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
                                                                                    return '<button id="Edit_TableRow">EDIT</button>';
                                                                                }
                                                                                else return '<button id="Insert_TableRow">UPLOAD</button>';
                                                                            }
                                                                        }

                                                                    ]
                                                });



        $('#dataTables tbody').on( 'click','#Edit_TableRow', function () {
            var data = table.row( $(this).parents('tr') ).data();
            $('#DescModal').modal("show");
            $('#DataTable_dataPrompt').prepend('<img id="theImg" src="<?php echo base_url()?>'+data[0]+'" height="200px" width="200px"/>')
            $('#stdNumb').attr('value', data[1]);
        });

        $('#dataTables tbody').on( 'click','#Insert_TableRow', function () {
            var data = table.row( $(this).parents('tr') ).data();
            $('#UpldModal').modal("show");
            $('#up_stdNumb').attr('value', data[1]);
        });




        $('.remove-prepend').on( 'click', function () {
            $("#theImg").remove();
            $("#thumb-output img").remove();
            $("#file-input").val("");
            $("#FilePathName").attr('value', '');

        });

        $('#file-input').on('change', function(){
            if (window.File && window.FileReader && window.FileList && window.Blob)
            {
                $('#thumb-output').html('');
                var data = $(this)[0].files;

                $.each(data, function(index, file){
                    if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){
                        var fRead = new FileReader();
                        fRead.onload = (function(file){
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).css('height',200).css('width',200);
                                $('#thumb-output').append(img);
                            };
                        })(file);
                        fRead.readAsDataURL(file);
                        fn_updateFileNameBox();
                    }
                });
            }else{
                alert("Your browser doesn't support File API!");
            }
        });


        $('#file-input-upload').on('change', function(){
            if (window.File && window.FileReader && window.FileList && window.Blob)
            {
                $('#thumb-output-upload').html('');
                var data = $(this)[0].files;

                $.each(data, function(index, file){
                    if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){
                        var fRead = new FileReader();
                        fRead.onload = (function(file){
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).css('height',200).css('width',200);
                                $('#thumb-output-upload').append(img);
                            };
                        })(file);
                        fRead.readAsDataURL(file);
                        fn_updateFileNameBoxUpload();
                    }
                });
            }else{
                alert("Your browser doesn't support File API!");
            }
        });

        function fn_updateFileNameBox()
        {
            var extractedFileName = document.getElementById('file-input');
            var cleanedExtFileName = extractedFileName.value.replace('C:\\fakepath\\', '');
            $('#FilePathName').attr('value',cleanedExtFileName);

        }

        function fn_updateFileNameBoxUpload()
        {
            var extractedFileName = document.getElementById('file-input-upload');
            var cleanedExtFileName = extractedFileName.value.replace('C:\\fakepath\\', '');
            $('#FilePathName_upload').attr('value',cleanedExtFileName);
        }





    });
</script>
<style>
    .thumb{
        margin: 10px 5px 0 0;
        width: 100px;
    }
</style>

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


                    <!-- modal body -->

                    <div class="modal fade" id="DescModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Current Photo</h3>

                                </div>
                                <div class="modal-body">
                                   <div id="DataTable_dataPrompt" style="text-align: center;"></div>

                                    <hr>
                                   <div id="DataTable_dataPrompt_Fields" style="text-align: center;">
                                       <h3>Upload New Photo</h3>
                                       <hr>
                                       <div id="thumb-output"></div>
                                        <br/>
                                        <?php echo form_open_multipart('DataController/updateExistingUserPhoto');?>
                                         <fieldset>
                                            <div class="form-group">
                                                <input class="form-control" name="stdNumb" id="stdNumb" value="" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Image Filename" name="FilePathName" id="FilePathName" value="" readonly>
                                                <br/>
                                                <input type="file" name="userfile" id="file-input"/>
                                            </div>
                                            <input id ="submit" type="submit" name="submit" value="Save" onclick="" class="btn btn-lg btn-success btn-block"/>
                                             <input type="button" class="remove-prepend btn btn-primary btn-block" value="Close" onclick=""  data-dismiss="modal"/>
                                         </fieldset>
                                        </form>
                                   </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>




                    <!--Upload Modal body-->

                    <div class="modal fade" id="UpldModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Upload New Photo</h3>

                                </div>
                                <div class="modal-body">
                                    <div id="DataTable_dataPrompt_Fields" style="text-align: center;">

                                        <hr>
                                        <div id="thumb-output-upload"></div>
                                        <br/>
                                        <?php echo form_open_multipart('DataController/uploadNewUserPhotoFile');?>
                                        <fieldset>
                                            <div class="form-group">
                                                <input class="form-control" name="up_stdNumb" id="up_stdNumb" value="" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Image Filename" name="FilePathName_upload" id="FilePathName_upload" value="" readonly>
                                                <br/>
                                                <input type="file" name="userfile" id="file-input-upload"/>
                                            </div>
                                            <input id ="submit" type="submit" name="submit" value="Save" onclick="" class="btn btn-lg btn-success btn-block"/>
                                        </fieldset>
                                        </form>
                                    </div>
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