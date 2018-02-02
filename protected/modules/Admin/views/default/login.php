<?php $form = $this->beginWidget('CActiveForm', array('id' => 'login')); ?>

<div class="login-form ">
    <div class="row mb-0">
        <div class="col s4 push-s4">
            <div class="card-panel login-panel">
                <h5 class="grey-text text-darken-2 mb-30">Login</h5>

                <form action="">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <input id="username" autocomplete="off" name="username" type="text" required>
                                <label>Username</label>
                            </div>
                            <div class="input-field">
                                <input id="password" autocomplete="off" name="password" type="password" required>
                                <label>Password</label>
                            </div>
                        </div>
                        <div class="col s12 mt-15">
                            <button type="button" onclick="login()" class="btn-login btn waves-light waves-effect blue">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    $(function () {
        $('#password').keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                login()
                return false;
            }
        });

        $("#username").keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                login()
                return false;
            }
        });
    });

    function login() {
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/Admin/Default/Login'; ?>",
            data: $('#login').serialize(),
            dataType: 'json',
            success: function (responce) {
                if (responce.code == 200) {
                Message.success('Login Success..');
                <?php if ($url != '') { ?> window.location = http_path + "<?php echo $url ?>";
                <?php } else { ?> window.location = http_path + "Admin/Default/Index";
                <?php } ?>
                }
                else {
                Message.danger('Ops!, Something went wrong.');
                }
            }
        });
    }
</script>