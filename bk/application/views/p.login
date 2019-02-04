<div class="container" style="margin-top:20%;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please sign in</h3>
                </div>
                <div class="panel-body">
                    <?php echo validation_errors(); ?>
                    <?php echo form_open('verifyLogin'); ?>
                    <label for="username">Username:</label>
                    <input type="text" size="20" id="username" name="username"/>
                    <br/>
                    <label for="password">Password:</label>
                    <input type="password" size="20" id="passowrd" name="password"/>
                    <br/>
                    <input type="submit" value="Login"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>