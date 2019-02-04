<!--Upload Modal body-->

<div class="modal fade" id="UpldModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Upload New Photo</h3>

            </div>
            <div class="modal-body">
                <div id="DataTable_dataPrompt_Fields" style="text-align: center;">


                    <div id="thumb-output-upload"></div>
                    <br/>
                    <?php echo form_open_multipart('DataController/ctl_uploadUserPhoto');?>
                    <fieldset>
                        <div class="form-group">

                            <input class="form-control" name="post_PartyIdUpload" id="post_PartyIdUpload" value="" style="display: none;">
                            <input class="form-control" name="up_stdNumb" id="up_stdNumb" value="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Image Filename" name="FilePathName_upload" id="FilePathName_upload" value="" readonly>
                            <br/>
                            <input type="file" name="userfile" id="file-input-upload"/>
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