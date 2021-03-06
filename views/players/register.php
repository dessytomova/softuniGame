<?php /** @var \SoftUni\Models\View\ApplicationViewModel $model
** @var \SoftUni\Core\ViewInterface $this
 */ ?>

<h1>Welcome to my <?= $model->getName() ;?></h1>


<div class="container">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="<?=$this->url("players","registerPost")?>" >
            <fieldset>
                <?php if(mb_strlen($this->session->get('error'))>0){ ?>
                    <div class="alert alert-dismissible alert-danger"><?= $this->session->message('error');?></div>
                <?php } ?>

                <legend>Register</legend>
                <div class="form-group">
                    <label for="inputUsername" class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-10">
                        <input class="form-control" name="username" id="inputUsername" placeholder="Username" type="text">
                    </div>
                </div>
<!---->
<!--                <div class="form-group">-->
<!--                    <label for="inputfName" class="col-lg-2 control-label">First name</label>-->
<!--                    <div class="col-lg-10">-->
<!--                        <input class="form-control" name="firstName" id="inputfName" placeholder="First name" type="text">-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="form-group">-->
<!--                    <label for="inputlName" class="col-lg-2 control-label">Last name</label>-->
<!--                    <div class="col-lg-10">-->
<!--                        <input class="form-control" name="lastName" id="inputlName" placeholder="Last name" type="text">-->
<!--                    </div>-->
<!--                </div>-->

                <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                    <div class="col-lg-10">
                        <input class="form-control" name="password" id="inputPassword" placeholder="Password" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <a href = "<?=$this->url("players", "login")?>" class = 'btn btn-success'>Login</a>
                        <button name="register" type="submit" class="btn btn-warning">Register</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
