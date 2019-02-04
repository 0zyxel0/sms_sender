<div class="modal fade" id="EditPhotoModal" role="dialog">
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
                    <?php echo form_open_multipart('DataController/ctl_updateExistingUserPhoto');?>
                    <fieldset>
                        <div class="form-group">

                            <input class="form-control" name="post_PartyIdPhotoEdit" id="post_PartyIdPhotoEdit" value="" style="display: none;">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Image Filename" name="FilePathName_edit" id="FilePathName_edit" value="" readonly>
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