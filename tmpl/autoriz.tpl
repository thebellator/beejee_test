%error_message%
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <div class="tab" role="tabpanel">

                <!-- Tab panes -->
                <div class="tab-content tabs">
                    <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                        <form action="functions.php" method="post" class="form-horizontal">
                            <input name="auth_form" value="true" type="hidden" />
                            <div class="form-group">
                                <label for="exampleInputEmail1">Login</label>
                                <input type="text" name="login" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /.col-md-offset-3 col-md-6 -->
    </div><!-- /.row -->
</div><!-- /.container -->