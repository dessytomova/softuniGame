<?php
/**
 * @var \SoftUni\Core\ViewInterface $this
 * @var \SoftUni\Models\View\ShipBuyViewModel $model
 * @var \SoftUni\Models\DB\BuildingRequirements $bld
 */

?>
<div class="container">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="<?=$this->url("ship", "addPost");?>">
            <fieldset>
                <label><?=$model->getName()?>Resources Needed To Unlock Ship:</label>
                <div class="list-group table-of-contents">
                    <ul class="nav nav-tabs">
                        <?php
                        foreach($model->getBuildingResources() as $bld){  ?>
                            <li class="list-group-item"><?= $bld->getBuildingName()." Level: " .$bld->getLevel();?></li>
                        <?php }?>
                    </ul>
                </div>
                <label><?=$model->getName()?>Resources Needed To Buy:</label>
                <div class="list-group table-of-contents">
                    <ul class="nav nav-tabs">
                        <?php
                        foreach($model->getCost() as $bld){  ?>
                            <li class="list-group-item"><?= $bld->getName()." Amount: " .$bld->getAmount();?></li>
                        <?php }?>
                    </ul>
                </div>
                <div class="list-group table-of-contents">
                    <div class="form-group has-success">
                        <label class="control-label" for="quality">Quantity</label>
                        <input type="number" class="form-control" id="quality" name="quality"  min="1" max = "15" maxlength="5">
                    </div>
                </div>
                <input type="hidden" name="ship_id" value="<?=$model->getId()?>">
            </fieldset>
            <a href = "<?=$this->url("players", "profile")?>" class = ' btn btn-primary'>Cancel</a>
            <input type="submit" value="Buy" class = ' btn btn-warning'/>
        </form>
    </div>
</div>





