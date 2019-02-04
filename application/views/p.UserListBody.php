<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script type= 'text/javascript'>
    $(document).ready(function() {
        var table = $('#dataTables').DataTable({
            "ajax": {
                url : "<?php echo site_url("PageController/ctl_ReportGetAllGateUsers") ?>",
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
                        }else return '<img src="<?php echo base_url()?>'+data+'" height="50px" width="50px"">';
                        }
                    },

                    {
                        "targets": 1,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": 11,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": 13,
                        "render": function(data){

                            if(data != null){
                                return data
                            }
                            else return "<button type='button' id='btn_Assign' name='btn_Assign'>Assign ID</button>"
                        }



                    },
                    {
                        "targets": 14,
                        "render": function(data){
                            if(data == null){
                                return "<button type='button' id='btn_addContact' name='btn_addContact'>Add Contact</button>"
                            }
                            else return data + "<br/><button type='button' id='btn_EditContact' name='btn_EditContact'>Edit</button>"
                                                }
                    },
                    {
                        "targets": 15,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": 16,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": 17,
                        "render": function(data){

                            if(data == "Y"){
                                return "<button type='button' id='btn_EditPhoto' name='btn_EditPhoto'>Edit Photo</button> <button type='button' id='btn_EditDetails' name='btn_EditDetails'>Edit Details</button> "
                            }
                            else return "<button type='button' id='btn_UploadPhoto' name='btn_UploadPhoto'>Upload Photo</button> <button type='button' id='btn_EditDetails' name='btn_EditDetails'>Edit Details</button>"
                        }



                    }
                ]


        });

        $('#btn_AddModal').on( 'click', function () {

            $('#AddRecordModal').modal("show")

        });
        $('#dataTables tbody').on( 'click', '#btn_addContact', function () {
            $('#RecordContactModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#post_userContactid').attr('value', data[1]);


        });

        $('#dataTables tbody').on( 'click', '#btn_EditContact', function () {
            $('#EditContactModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#edit_userContactid').attr('value', data[1]);
            $('#edit_ContactName').attr('value', data[14]);
            $('#edit_Relation').attr('value', data[16]);
            $('#edit_Number').attr('value', data[15]);
        });


        $('#dataTables tbody').on( 'click', '#btn_EditDetails', function () {
            $('#EditRecordModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#edit_studentID').attr('value', data[1]);
            $('#edit_existingUserID').attr('value', data[2]);
            $('#edit_lastName').attr('value', data[3]);
            $('#edit_givenName').attr('value', data[4]);
            $('#edit_middleName').attr('value', data[5]);
            $('#edit_suffix').attr('value', data[6]);
            $('#edit_CivilStatus').val(data[7]);
            $('#edit_Gender').val(data[8]);
            $('#edit_Birthday').attr('value', data[9]);
            $('#edit_age').attr('value', data[10]);
            $('#edit_Category').val(data[11]);
        } );


        $('#dataTables tbody').on( 'click', '#btn_Assign', function () {
            $('#AssignCardModal').modal("show");
            var data = table.row( $(this).parents('tr') ).data();
            $('#post_partyid').attr('value', data[1]);
            $('#post_studentName').attr('value', data[3]+' '+data[4]);
            $('#post_userType').attr('value', data[11]);
        } );


        $('#dataTables tbody').on( 'click', '#btn_UploadPhoto', function () {
            $('#UpldModal').modal({backdrop: 'static', keyboard: false});
            var data = table.row( $(this).parents('tr') ).data();
            $('#post_PartyIdUpload').attr('value', data[1]);
            $('#up_stdNumb').attr('value', data[3]+' '+data[4]);
        } );

        $('#dataTables tbody').on( 'click','#btn_EditPhoto', function () {
            var data = table.row( $(this).parents('tr') ).data();
            $('#EditPhotoModal').modal({backdrop: 'static', keyboard: false});
            $('#DataTable_dataPrompt').prepend('<img id="theImg" src="<?php echo base_url()?>'+data[0]+'" height="200px" width="200px"/>')
            $('#post_PartyIdPhotoEdit').attr('value', data[1]);

        });

        $('.remove-prepend').on( 'click', function () {
            $("#theImg").remove();
            $("#thumb-output img").remove();
            $("#file-input").attr('value','')
            $("#FilePathName_edit").attr('value', '');
            $("#FilePathName_upload").attr('value', '');

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
            $('#FilePathName_edit').attr('value',cleanedExtFileName);

        }

        function fn_updateFileNameBoxUpload()
        {
            var extractedFileName = document.getElementById('file-input-upload');
            var cleanedExtFileName = extractedFileName.value.replace('C:\\fakepath\\', '');
            $('#FilePathName_upload').attr('value',cleanedExtFileName);
        }


        	$('#record_Birthday').datepicker({
                    dateFormat: "yy-mm-dd",
        		onSelect: function(value, ui) {
        	        var today = new Date(), 
        	            age = today.getFullYear() - ui.selectedYear;
                    $('#record_Birthday').attr('value',value);
        	        $('#record_age').attr('value',age);

        	    },
        	    maxDate: '+0d',
        	    changeMonth: true,
        	    changeYear: true,
        	    defaultDate: '-18yr'

        	}
        	);
        $('#edit_Birthday').datepicker({
                dateFormat: "yy-mm-dd",
                onSelect: function(evalue, ui) {
                    var today = new Date(),
                        age = today.getFullYear() - ui.selectedYear;
                    $('#edit_Birthday').attr('value',evalue);
                    $('#edit_age').attr('value',age);

                },
                maxDate: '+0d',
                changeMonth: true,
                changeYear: true,
                defaultDate: '-18yr'

            }
        );


        $('#addNewRecordPerson').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        })

        $("#Checker").click(function(e){  // passing down the event
           var dataString = $("#record_existingUserID").val();
            $.ajax({
                url:'<?php echo site_url("DataController/rolekey_exists") ?>',
                method: 'POST',
                data: {key : dataString},
                success: function(data) {
                    $('#result').html(data);
                },
                error: function(data,xhr, error) {
                    $('#result').html(data);
                }
            });
            e.preventDefault(); // could also use: return false;
        });


    });
</script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Gate Users</h1>

            </div>

        </div>
        <div class="row">

            <div class="row">
                <button type="button" id="btn_AddModal" class="btn btn-primary btn-lg" style="float:right;">Add User</button>
            </div>

            <div class="col-l-2">
                <!-- Nav tabs -->
                <div class="card">

                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Person ID</th>
                                <th>User ID</th>
                                <th>Last Name</th>
                                <th>Given Name</th>
                                <th>Middle Name</th>
                                <th>Suffix</th>
                                <th>Civil Status</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Age</th>
                                <th>Category ID</th>
                                <th>Type</th>
                                <th>Card ID</th>
                                <th>Guardian</th>
                                <th>Number</th>
                                <th>Relationship</th>
                                <th>Options</th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.panel-body -->





                </div>
            </div>


        </div>
    </div>
    <!--Modal for Assigning Guardians Contacts-->
    <div class="modal fade" id="RecordContactModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Guardian Details</h3>

                </div>
                <div class="modal-body">
                    <form action="<?= site_url('DataController/ctl_AddPersonEmergencyContact') ?>" method="post" autocomplete="off">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Student ID" id="post_userContactid" name="post_userContactid"  value="" style="display: none;">
                                <input class="form-control" placeholder="Contact Name" name="post_ContactName" id="post_ContactName" value="" ><br/>
                                <input class="form-control" placeholder="Relation" name="post_Relation" id="post_Relation" value="" autofocus><br/>
                                <input class="form-control" placeholder="Contact Number" name="post_Number" id="post_Number" value="" >

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



    <!--Modal for Editing Guardians Contacts-->
    <div class="modal fade" id="EditContactModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Guardian Details</h3>

                </div>
                <div class="modal-body">
                    <form action="<?= site_url('DataController/ctl_EditPersonEmergencyContact') ?>" method="post" autocomplete="off">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Student ID" id="edit_userContactid" name="edit_userContactid"  value="" style="display: none;">
                                <input class="form-control" placeholder="Contact Name" name="edit_ContactName" id="edit_ContactName" value="" ><br/>
                                <input class="form-control" placeholder="Relation" name="edit_Relation" id="edit_Relation" value="" autofocus><br/>
                                <input class="form-control" placeholder="Contact Number" name="edit_Number" id="edit_Number" value="" >

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



    <!--Modal For Assigning Cards-->
    <div class="modal fade" id="AssignCardModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Assign Card ID</h3>

                </div>
                <div class="modal-body">
                    <form action="<?= site_url('DataController/ctl_AssignCardToUser') ?>" method="post" autocomplete="off">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Student ID" id="post_partyid" name="post_partyid"  value="" style="display: none;">
                                <input class="form-control" placeholder="Student Name" name="post_studentName" id="post_studentName" value="" readonly><br/>
                                <input class="form-control" placeholder="Card ID" name="post_cardId" id="post_cardId" value="" autofocus maxlength="10">
                                <input class="form-control" placeholder="User Type" name="post_userType" id="post_userType" value="" style="display:none;">
                                <br/>
                                <input class="form-control" placeholder="isDisabled" id="post_isDisabled" name="post_isDisabled" value="0" style="display: none">

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
    <?php require('uploadExistingPhotoModal.php')?>
    <?php require('uploadPhotoModal.php')?>
<!--Modal For Adding-->
    <div class="modal fade" id="AddRecordModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add New User</h3>

                </div>
                <div class="modal-body">
                    <form id="addNewRecordPerson" action="<?= site_url('DataController/createNewRecordPerson') ?>" method="post">



                        <div class="form-row align-items-center">
                            <div class="form-group">

                                <div class="input-group">
                                    <input class="form-control " placeholder="Existing User ID" name="record_existingUserID" id="record_existingUserID" value="" autocomplete="false" required="" autofocus>
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary" id="Checker" type="button">Check if Exist</button>
                                    </span>
                                </div>
                                <span id="result"></span>
                            </div>

                            <div class="form-group">
                                <input class="form-control" placeholder="Last Name" name="record_lastName" id="record_lastName" value="" autocomplete="false" autofocus required="">
                            </div>

							
                            <div class="form-group">
                                <input class="form-control" placeholder="First Name" name="record_givenName" id="record_givenName" value="" autocomplete="false" autofocus required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Middle Name" name="record_middleName" id="record_middleName" value="" autocomplete="false" autofocus required="">

                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Suffix" name="record_suffix" id="record_suffix" value="" autocomplete="false" autofocus>
                            </div>
                        </div>
         

                        <div class="form-inline">
                            <div class="form-group">
                                <select class="form-control" id="slt_CivilStatus" name="slt_CivilStatus" required="">
                                    <option value="" selected disabled>-- Civil Status --</option>
                                    <option>Single</option>
                                    <option>Married</option>
                                </select>
                            </div>

                            <select class="form-control " id="slt_Gender" name="slt_Gender" required="">
                                <option value="" selected disabled >-- Gender --</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>

                        </div>

                        <br>


                        <div class="form-group">
     
                            <input class="form-control" placeholder="Birthday" name="record_Birthday" id="record_Birthday"  value="" autofocus required="">

                        </div>
                        <div class="form-group">
                            <input class="form-control checked" placeholder="Age" name="record_age" id="record_age" >

                            </input>
                        </div>
                        

                        <div class="form-group">


                            <select class="form-control" name="record_Category" id="record_Category" required="">
                                <option value="" selected disabled>User Category</option>
                                <?php

                                foreach($category as $row)
                                {
                                    echo '<option value="'.$row->categoryId.'">'.$row->categoryName.'</option>';
                                }
                                ?>
                            </select>
                        </div>






                        <input type="submit" id="btn_addNewRecord" name="btn_addNewRecord" value="Save Record" onclick="" class="btn btn-lg btn-success btn-block"/>    </fieldset>

                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Modal For Adding-->


    <!--Edit User Details Modal-->
    <div class="modal fade" id="EditRecordModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit User Details</h3>

                </div>
                <div class="modal-body">
                    <form action="<?= site_url('DataController/ctl_EditUserRecordDetails') ?>" method="post">



                        <div class="form-row align-items-center">
                            <div class="form-group">
                                <input class="form-control" placeholder="Student ID" name="edit_studentID" id="edit_studentID" value="" autocomplete="false" autofocus style="display:none;">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Existing User ID" name="edit_existingUserID" id="edit_existingUserID" value="" autocomplete="false" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Last Name" name="edit_lastName" id="edit_lastName" value="" autocomplete="false" autofocus>
                            </div>


                            <div class="form-group">
                                <input class="form-control" placeholder="First Name" name="edit_givenName" id="edit_givenName" value="" autocomplete="false" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Middle Name" name="edit_middleName" id="edit_middleName" value="" autocomplete="false" autofocus>

                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Suffix" name="edit_suffix" id="edit_suffix" value="" autocomplete="false" autofocus>
                            </div>
                        </div>


                        <div class="form-inline">
                            <div class="form-group">
                                <select class="form-control" id="edit_CivilStatus" name="edit_CivilStatus">
                                    <option value="" selected disabled>-- Civil Status --</option>
                                    <option>Single</option>
                                    <option>Married</option>
                                </select>
                            </div>

                            <select class="form-control " id="edit_Gender" name="edit_Gender">
                                <option value="" selected disabled>-- Gender --</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>


                        </div>

                        <br>


                        <div class="form-group">

                            <input class="form-control" placeholder="Birthday" name="edit_Birthday" id="edit_Birthday"  value="" autofocus>

                        </div>
                        <div class="form-group">
                            <input class="form-control checked" placeholder="Age" name="edit_age" id="edit_age" >

                            </input>
                        </div>


                        <div class="form-group">

                            <select class="form-control" name="edit_Category" id="edit_Category">
                                <option value="" selected disabled>User Category</option>
                                <?php

                                foreach($category as $row)
                                {
                                    echo '<option value="'.$row->categoryId.'">'.$row->categoryName.'</option>';
                                }
                                ?>
                            </select>

                        </div>

                        <input type="submit" id="btn_EditRecord" name="btn_EditRecord" value="Save Record" onclick="" class="btn btn-lg btn-success btn-block"/>    </fieldset>

                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <!-- /.row -->
</div>
