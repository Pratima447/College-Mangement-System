<?php
    session_start();
    if(isset($_POST['submit']))
    {
        include('../../config/DbQueries.php');
        $obj = new DbQueries();

        $_SESSION['login'] = $_POST['id'];
        $obj->login($_POST['id'],$_POST['password']);
    }

    include('../common/header.html');

?>

<body>
    <div class="container">
        <br><br><br><br>
            <div class="col-md-4 col-md-offset-4">
                <center class="panel panel-primary" id="login_form">
                    <div class="panel-heading form_head">
                        <h3 class="panel-title">Login Here</h3>
                    </div>
                    <div class="panel-body">
                        <form id="login_credentails" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label for="loginid" class="white_text">Login :</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input required class="form-control white_text no_background no_border border_b" placeholder="Enter Login Id"  id="id"name="id" type="text" autofocus autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group m_t_30">
                                    <div class="col-md-4">
                                        <label for="password" class="white_text">Password :</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input required class="form-control white_text no_background no_border border_b" placeholder="Enter Password"  id="password"name="password" type="password" value="">
                                    </div>
                                </div>
                                

                                <div class="form-group col-md-offset-3 col-md-6">
                                    <input type="submit" value="Submit" name="submit" class="white_text btn btn-lg btn-block btn-login">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </center>
            </div>
        </div>
    </div>
</body>

<?php
    include('../common/footer.html');
?>
