<?php
/**
 * @var $this \SoftUni\Core\ViewInterface
 * @var $model \SoftUni\Models\View\PlayerProfileEditViewModel
 */
?>
<div class="container">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="<?= $this->url("players", "profileEditPost", [$model->getId()]);?>">
            <fieldset>
                <?php if(mb_strlen($this->session->get('error'))>0){ ?>
                    <div class="alert alert-dismissible alert-danger"><?= $this->session->message('error');?></div>
                <?php } ?>
                <legend>Edit your profile</legend>
                <div class="form-group">
                    <label for="inputUsername" class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-10">
                        <input class="form-control" value="<?=$model->getUsername();?>" name="username" id="inputUsername" placeholder="Username" type="text">
                    </div>
                </div>

                    <div class="form-group">
                        <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-10">
                            <input class="form-control" value="<?=$model->getPassword();?>" name="password" id="inputPassword" placeholder="Password" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordConfirm" class="col-lg-2 control-label">Confirm</label>
                        <div class="col-lg-10">
                            <input class="form-control" name="confirmPassword" id="inputPasswordConfirm" placeholder="Password" type="password">
                        </div>
                    </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="reset" class="btn btn-default">Cancel</button>
                        <button name="edit" type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>