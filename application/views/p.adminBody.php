<script>

        $(document).ready(function() {

            $("div.Addbox").hide();
            $("div.Editbox").hide();
            $("div.Findbox").hide();
            $("div.Photobox").hide();
            $("div.Uploadbox").hide();
            $("div.AddRecordbox").hide();

            $("#Addtab").click(function() {
                if($('div.Addbox').is(":visible")===true)
                {
                    $('div.Addbox').hide();
                }
                else
                {  $('div.Addbox').show();}


            });

            $("#Edittab").click(function() {
                if($('div.Editbox').is(":visible")===true)
                {
                    $('div.Editbox').hide();
                }else
                {  $('div.Editbox').show();}


            });

            $("#Findtab").click(function() {
                if($('div.Findbox').is(":visible")===true)
                {
                    $('div.Findbox').hide();
                }else
                {  $('div.Findbox').show();}


            });



            $("#Uploadtab").click(function() {
                if($('div.Uploadbox').is(":visible")===true)
                {
                    $('div.Uploadbox').hide();
                }else
                {  $('div.Uploadbox').show();}


            });

            $("#AddRecordtab").click(function() {
                if($('div.AddRecordbox').is(":visible")===true)
                {
                    $('div.AddRecordbox').hide();
                }else
                {  $('div.AddRecordbox').show();}


            });






                function fn_updateFileNameBox()
                {
                    var extractedFileName = document.getElementById('userfile');
                    var cleanedExtFileName = extractedFileName.value.replace('C:\\fakepath\\', '');
                    $('#FilePathName').attr('value',cleanedExtFileName);
                }

            $("#userfile").change(function(){
                fn_updateFileNameBox();
            });



        });




</script>


<div id="page-wrapper">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">ID Options</h1>
                    </div>
                    <?php if (isset($message)) { ?><CENTER><h3 style="color:green;">Data inserted successfully</h3></CENTER><br><?php } ?>
                    <!-- /.col-lg-12 -->
                </div>

                <div class = "row">


                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading cb"  id="Addtab" >
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">+</div>
                                            <div>Assign ID</div>
                                        </div>
                                    </div>
                                </div>

                                <a href="" data-toggle="modal">
                                    <div class="panel-footer">
                                        <span class="pull-left">Assign</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                                    </div>
                            </div>


                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading cb" id="Edittab">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">-</div>
                                        <div>Remove ID</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="modal">
                                <div class="panel-footer">
                                    <span class="pull-left">Remove</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading cb" id="Findtab">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">?</div>
                                        <div>Find ID</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="modal">
                                <div class="panel-footer">
                                    <span class="pull-left">Search</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading cb" id="Uploadtab">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="glyphicon glyphicon-cloud-upload fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><i class="glyphicon glyphicon-upload"></i></div>
                                        <div>Upload</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="modal">
                                <div class="panel-footer">
                                    <span class="pull-left">Upload ID Picture</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading cb" id="AddRecordtab">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">+</div>
                                        <div>Add Record</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="modal">
                                <div class="panel-footer">
                                    <span class="pull-left">Add Record</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>



                </div>
                <!-- /.row -->


                    <hr/>

                <div class="row" >
                    <div id="tabShows" class="Addbox">
                        <div class="col-lg-12" id="tab1show">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Assign Card</h3>
                                </div>
                                <div class="panel-body">


                                    <form action="<?= site_url('DataController/AddAssignNumber') ?>" method="post">
                                        <fieldset>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Student Number" id="stdNumb" name="stdNumb" autofocus><br/>
                                                <input class="form-control" placeholder="Student Name" name="stdName" id="stdName" value="" autofocus><br/>
                                                <input class="form-control" placeholder="ID Number" id="formPutSerial" name="formPutSerial" value="" ><br/>
                                                <input class="form-control" placeholder="userCategory" id="userCategory" name="userCategory" value="" >
                                                <input class="form-control" placeholder="cardStat" id="cardStat" name="cardStat" value="0" style="display: none;">
                                            </div>

                                            <!--input type="button" name="pcall" value="Scan ID" onclick="location = 'http://localhost:8899/Phton/run.php'; closeSelf();"  class="btn btn-lg btn-warning btn-block"/-->
                                            <!--input type="button" id="btnGetSerial" value="Scan ID" class="btn btn-lg btn-warning btn-block"/-->

                                            <input id="submit" type="submit" name="padd" value="Add Record" onclick="" class="btn btn-lg btn-success btn-block"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" >
                    <div id="tabShows" class="Editbox">
                        <div class="col-lg-12" id="tab2show">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Edit Student ID</h3>
                                </div>
                                <div class="panel-body">
                                    <form action="" method="post">
                                        <fieldset>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Student Number" name="stdNumb" id="stdNumb" value="" autofocus>

                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Student Name" name="stdName" id="stdName" value="" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" name="idNum" type="idNum" value="<?php if(isset($datum)) {echo $datum;} else {echo 'ID Number';}?>" readonly>
                                            </div>

                                            <input type="button" name="pcall" value="Scan ID" onclick="location = 'http://localhost:8899/Phton/run.php'; closeSelf();"  class="btn btn-lg btn-warning btn-block"/>
                                            <input type="button" name="padd" value="Save" onclick="" class="btn btn-lg btn-success btn-block"/>    </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div id="tabShows" class="Findbox">
                        <div class="col-lg-12" id="tab3show">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Find Student ID</h3>
                                </div>
                                <div class="panel-body">
                                    <form action="" method="post">
                                        <fieldset>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Student Number" name="stdNumb" id="stdNumb" value="" autofocus>

                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Student Name" name="stdName" id="stdName" value="" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" name="idNum" type="idNum" value="<?php if(isset($datum)) {echo $datum;} else {echo 'ID Number';}?>" readonly>
                                            </div>

                                            <!--input type="button" name="pcall" value="Scan ID" onclick="location = 'http://localhost:8899/Phton/run.php'; closeSelf();"  class="btn btn-lg btn-warning btn-block"/-->
                                            <input type="button" name="padd" value="Find Record" onclick="" class="btn btn-lg btn-success btn-block"/>    </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="tabShows" class="Uploadbox">
                        <div class="col-lg-12" id="tab3show">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Upload ID Photo</h3>
                                </div>
                                <div class="panel-body">
                                    <?php echo form_open_multipart('DataController/CombinedPhotoUpload');?>
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Student Number" name="stdNumb" id="stdNumb" value="" autofocus>

                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Image Filename" name="FilePathName" id="FilePathName" value="" readonly>
                                            <br/>
                                            <input type="file" name="userfile" id="userfile"/>
                                        </div>
                                        <input id ="submit" type="submit" name="submit" value="Save" onclick="" class="btn btn-lg btn-success btn-block"/>    </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div id="tabShows" class="AddRecordbox">
                        <div class="col-lg-12" id="tab3show">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Add Record</h3>
                                </div>
                                <br class="panel-body">

                                <form action="<?= site_url('DataController/createNewRecordPerson') ?>" method="post">

                                            <div class="form-inline">
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Last Name" name="record_lastName" id="record_lastName" value="" autofocus>

                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="First Name" name="record_givenName" id="record_givenName" value="" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Middle Name" name="record_middleName" id="record_middleName" value="" autofocus>

                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Suffix" name="record_suffix" id="record_suffix" value="" autofocus>
                                            </div>
                                            </div>
                                        <br>

                                                <div class="form-inline">
                                                    <div class="form-group">
                                            <select class="form-control" id="slt_CivilStatus" name="slt_CivilStatus">
                                                <option value="" selected disabled>-- Civil Status --</option>
                                                <option>Single</option>
                                                <option>Married</option>
                                            </select>
                                                </div>

                                            <select class="form-control " id="slt_Gender" name="slt_Gender">
                                                <option value="" selected disabled>-- Gender --</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>

                                            <select class="form-control " id="slt_Religion" name="slt_Religion">
                                                <option value="" selected disabled>-- Religion --</option>
                                                <option value="African Traditional & Diasporic">African Traditional & Diasporic</option>
                                                <option value="Agnostic">Agnostic</option>
                                                <option value="Atheist">Atheist</option>
                                                <option value="Baha'i">Baha'i</option>
                                                <option value="Buddhism">Buddhism</option>
                                                <option value="Cao Dai">Cao Dai</option>
                                                <option value="Chinese traditional religion">Chinese traditional religion</option>
                                                <option value="Christianity">Christianity</option>
                                                <option value="Hinduism">Hinduism</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Jainism">Jainism</option>
                                                <option value="Juche">Juche</option>
                                                <option value="Judaism">Judaism</option>
                                                <option value="Neo-Paganism">Neo-Paganism</option>
                                                <option value="Nonreligious">Nonreligious</option>
                                                <option value="Rastafarianism">Rastafarianism</option>
                                                <option value="Secular">Secular</option>
                                                <option value="Shinto">Shinto</option>
                                                <option value="Sikhism">Sikhism</option>
                                                <option value="Spiritism">Spiritism</option>
                                                <option value="Tenrikyo">Tenrikyo</option>
                                                <option value="Unitarian-Universalism">Unitarian-Universalism</option>
                                                <option value="Zoroastrianism">Zoroastrianism</option>
                                                <option value="primal-indigenous">primal-indigenous</option>
                                                <option value="Other">Other</option>
                                            </select>

                                                    <select class="form-control " id="slt_Nationality" name="slt_Nationality">
                                                        <option value="">-- Nationality --</option>
                                                        <option value="afghan">Afghan</option>
                                                        <option value="albanian">Albanian</option>
                                                        <option value="algerian">Algerian</option>
                                                        <option value="american">American</option>
                                                        <option value="andorran">Andorran</option>
                                                        <option value="angolan">Angolan</option>
                                                        <option value="antiguans">Antiguans</option>
                                                        <option value="argentinean">Argentinean</option>
                                                        <option value="armenian">Armenian</option>
                                                        <option value="australian">Australian</option>
                                                        <option value="austrian">Austrian</option>
                                                        <option value="azerbaijani">Azerbaijani</option>
                                                        <option value="bahamian">Bahamian</option>
                                                        <option value="bahraini">Bahraini</option>
                                                        <option value="bangladeshi">Bangladeshi</option>
                                                        <option value="barbadian">Barbadian</option>
                                                        <option value="barbudans">Barbudans</option>
                                                        <option value="batswana">Batswana</option>
                                                        <option value="belarusian">Belarusian</option>
                                                        <option value="belgian">Belgian</option>
                                                        <option value="belizean">Belizean</option>
                                                        <option value="beninese">Beninese</option>
                                                        <option value="bhutanese">Bhutanese</option>
                                                        <option value="bolivian">Bolivian</option>
                                                        <option value="bosnian">Bosnian</option>
                                                        <option value="brazilian">Brazilian</option>
                                                        <option value="british">British</option>
                                                        <option value="bruneian">Bruneian</option>
                                                        <option value="bulgarian">Bulgarian</option>
                                                        <option value="burkinabe">Burkinabe</option>
                                                        <option value="burmese">Burmese</option>
                                                        <option value="burundian">Burundian</option>
                                                        <option value="cambodian">Cambodian</option>
                                                        <option value="cameroonian">Cameroonian</option>
                                                        <option value="canadian">Canadian</option>
                                                        <option value="cape verdean">Cape Verdean</option>
                                                        <option value="central african">Central African</option>
                                                        <option value="chadian">Chadian</option>
                                                        <option value="chilean">Chilean</option>
                                                        <option value="chinese">Chinese</option>
                                                        <option value="colombian">Colombian</option>
                                                        <option value="comoran">Comoran</option>
                                                        <option value="congolese">Congolese</option>
                                                        <option value="costa rican">Costa Rican</option>
                                                        <option value="croatian">Croatian</option>
                                                        <option value="cuban">Cuban</option>
                                                        <option value="cypriot">Cypriot</option>
                                                        <option value="czech">Czech</option>
                                                        <option value="danish">Danish</option>
                                                        <option value="djibouti">Djibouti</option>
                                                        <option value="dominican">Dominican</option>
                                                        <option value="dutch">Dutch</option>
                                                        <option value="east timorese">East Timorese</option>
                                                        <option value="ecuadorean">Ecuadorean</option>
                                                        <option value="egyptian">Egyptian</option>
                                                        <option value="emirian">Emirian</option>
                                                        <option value="equatorial guinean">Equatorial Guinean</option>
                                                        <option value="eritrean">Eritrean</option>
                                                        <option value="estonian">Estonian</option>
                                                        <option value="ethiopian">Ethiopian</option>
                                                        <option value="fijian">Fijian</option>
                                                        <option value="filipino">Filipino</option>
                                                        <option value="finnish">Finnish</option>
                                                        <option value="french">French</option>
                                                        <option value="gabonese">Gabonese</option>
                                                        <option value="gambian">Gambian</option>
                                                        <option value="georgian">Georgian</option>
                                                        <option value="german">German</option>
                                                        <option value="ghanaian">Ghanaian</option>
                                                        <option value="greek">Greek</option>
                                                        <option value="grenadian">Grenadian</option>
                                                        <option value="guatemalan">Guatemalan</option>
                                                        <option value="guinea-bissauan">Guinea-Bissauan</option>
                                                        <option value="guinean">Guinean</option>
                                                        <option value="guyanese">Guyanese</option>
                                                        <option value="haitian">Haitian</option>
                                                        <option value="herzegovinian">Herzegovinian</option>
                                                        <option value="honduran">Honduran</option>
                                                        <option value="hungarian">Hungarian</option>
                                                        <option value="icelander">Icelander</option>
                                                        <option value="indian">Indian</option>
                                                        <option value="indonesian">Indonesian</option>
                                                        <option value="iranian">Iranian</option>
                                                        <option value="iraqi">Iraqi</option>
                                                        <option value="irish">Irish</option>
                                                        <option value="israeli">Israeli</option>
                                                        <option value="italian">Italian</option>
                                                        <option value="ivorian">Ivorian</option>
                                                        <option value="jamaican">Jamaican</option>
                                                        <option value="japanese">Japanese</option>
                                                        <option value="jordanian">Jordanian</option>
                                                        <option value="kazakhstani">Kazakhstani</option>
                                                        <option value="kenyan">Kenyan</option>
                                                        <option value="kittian and nevisian">Kittian and Nevisian</option>
                                                        <option value="kuwaiti">Kuwaiti</option>
                                                        <option value="kyrgyz">Kyrgyz</option>
                                                        <option value="laotian">Laotian</option>
                                                        <option value="latvian">Latvian</option>
                                                        <option value="lebanese">Lebanese</option>
                                                        <option value="liberian">Liberian</option>
                                                        <option value="libyan">Libyan</option>
                                                        <option value="liechtensteiner">Liechtensteiner</option>
                                                        <option value="lithuanian">Lithuanian</option>
                                                        <option value="luxembourger">Luxembourger</option>
                                                        <option value="macedonian">Macedonian</option>
                                                        <option value="malagasy">Malagasy</option>
                                                        <option value="malawian">Malawian</option>
                                                        <option value="malaysian">Malaysian</option>
                                                        <option value="maldivan">Maldivan</option>
                                                        <option value="malian">Malian</option>
                                                        <option value="maltese">Maltese</option>
                                                        <option value="marshallese">Marshallese</option>
                                                        <option value="mauritanian">Mauritanian</option>
                                                        <option value="mauritian">Mauritian</option>
                                                        <option value="mexican">Mexican</option>
                                                        <option value="micronesian">Micronesian</option>
                                                        <option value="moldovan">Moldovan</option>
                                                        <option value="monacan">Monacan</option>
                                                        <option value="mongolian">Mongolian</option>
                                                        <option value="moroccan">Moroccan</option>
                                                        <option value="mosotho">Mosotho</option>
                                                        <option value="motswana">Motswana</option>
                                                        <option value="mozambican">Mozambican</option>
                                                        <option value="namibian">Namibian</option>
                                                        <option value="nauruan">Nauruan</option>
                                                        <option value="nepalese">Nepalese</option>
                                                        <option value="new zealander">New Zealander</option>
                                                        <option value="ni-vanuatu">Ni-Vanuatu</option>
                                                        <option value="nicaraguan">Nicaraguan</option>
                                                        <option value="nigerien">Nigerien</option>
                                                        <option value="north korean">North Korean</option>
                                                        <option value="northern irish">Northern Irish</option>
                                                        <option value="norwegian">Norwegian</option>
                                                        <option value="omani">Omani</option>
                                                        <option value="pakistani">Pakistani</option>
                                                        <option value="palauan">Palauan</option>
                                                        <option value="panamanian">Panamanian</option>
                                                        <option value="papua new guinean">Papua New Guinean</option>
                                                        <option value="paraguayan">Paraguayan</option>
                                                        <option value="peruvian">Peruvian</option>
                                                        <option value="polish">Polish</option>
                                                        <option value="portuguese">Portuguese</option>
                                                        <option value="qatari">Qatari</option>
                                                        <option value="romanian">Romanian</option>
                                                        <option value="russian">Russian</option>
                                                        <option value="rwandan">Rwandan</option>
                                                        <option value="saint lucian">Saint Lucian</option>
                                                        <option value="salvadoran">Salvadoran</option>
                                                        <option value="samoan">Samoan</option>
                                                        <option value="san marinese">San Marinese</option>
                                                        <option value="sao tomean">Sao Tomean</option>
                                                        <option value="saudi">Saudi</option>
                                                        <option value="scottish">Scottish</option>
                                                        <option value="senegalese">Senegalese</option>
                                                        <option value="serbian">Serbian</option>
                                                        <option value="seychellois">Seychellois</option>
                                                        <option value="sierra leonean">Sierra Leonean</option>
                                                        <option value="singaporean">Singaporean</option>
                                                        <option value="slovakian">Slovakian</option>
                                                        <option value="slovenian">Slovenian</option>
                                                        <option value="solomon islander">Solomon Islander</option>
                                                        <option value="somali">Somali</option>
                                                        <option value="south african">South African</option>
                                                        <option value="south korean">South Korean</option>
                                                        <option value="spanish">Spanish</option>
                                                        <option value="sri lankan">Sri Lankan</option>
                                                        <option value="sudanese">Sudanese</option>
                                                        <option value="surinamer">Surinamer</option>
                                                        <option value="swazi">Swazi</option>
                                                        <option value="swedish">Swedish</option>
                                                        <option value="swiss">Swiss</option>
                                                        <option value="syrian">Syrian</option>
                                                        <option value="taiwanese">Taiwanese</option>
                                                        <option value="tajik">Tajik</option>
                                                        <option value="tanzanian">Tanzanian</option>
                                                        <option value="thai">Thai</option>
                                                        <option value="togolese">Togolese</option>
                                                        <option value="tongan">Tongan</option>
                                                        <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                                                        <option value="tunisian">Tunisian</option>
                                                        <option value="turkish">Turkish</option>
                                                        <option value="tuvaluan">Tuvaluan</option>
                                                        <option value="ugandan">Ugandan</option>
                                                        <option value="ukrainian">Ukrainian</option>
                                                        <option value="uruguayan">Uruguayan</option>
                                                        <option value="uzbekistani">Uzbekistani</option>
                                                        <option value="venezuelan">Venezuelan</option>
                                                        <option value="vietnamese">Vietnamese</option>
                                                        <option value="welsh">Welsh</option>
                                                        <option value="yemenite">Yemenite</option>
                                                        <option value="zambian">Zambian</option>
                                                        <option value="zimbabwean">Zimbabwean</option>
                                                    </select>
                                                </div>

                                <br>


                                            <div class="form-group">
                                                <input class="form-control" placeholder="Birthday" name="record_Birthday" id="record_Birthday" value="" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Age" name="record_age" id="record_age" value="" autofocus>
                                            </div>

                                            <div class="form-group">
                                                <input class="form-control" placeholder="Family Income" name="record_Income" id="record_Income" value="" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Place of Birth" name="record_placeOfBirth" id="record_placeOfBirth" value="" autofocus>
                                            </div>

                                            <input type="submit" id="btn_addNewRecord" name="btn_addNewRecord" value="Save Record" onclick="" class="btn btn-lg btn-success btn-block"/>    </fieldset>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>










                <!-- /.row -->
                </div>