<?php
/**
 * @var \SoftUni\Core\ViewInterface $this
 * @var \SoftUni\Models\View\BattleStartViewModel $model
 */

?>
<div class="container">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="<?=$this->url("battle", "startPost");?>">
            <fieldset>
                <label><h1><?=$model->getName()?></h1></label>
                <div class="list-group table-of-contents">
                    <ul class="nav ">
                        <?php
                        foreach($model->getShipsForIsland() as $k => $ship){  ?>
                            <li class="list-group-item">
                                <h4><?= $ship->getName()
                                        . " ( Health: ".$ship->getHealth()
                                        . "; Demage: ".$ship->getDemage()." ) "
                                    . " Amount: ".$ship->getAmount();?></h4>
                                <input type="number" class="form-control" id = "ship_<?=$ship->getShipId();?>" name = "ships[<?=$ship->getShipId()?>]" min="0" max = "<?=$ship->getAmount();?>" maxlength="5" value  = "0">
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <input type="hidden" name="attackedId" value="<?=$model->getAttackedId()?>">

            </fieldset>

            <a href = "<?= $this->url("players","profile");?>" class = ' btn btn-primary'>Cancel</a>
            <input type="submit" value="Start Battle" class = ' btn btn-warning'/>
        </form>
    </div>
</div>





