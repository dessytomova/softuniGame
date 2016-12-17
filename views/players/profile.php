<?php
/**
 * @var \SoftUni\Core\ViewInterface $this
 * @var \SoftUni\Models\View\PlayerProfileViewModel $model
 */
?>
<?php if(mb_strlen($this->session->get('error'))>0){ ?>
    <div class="alert alert-dismissible alert-danger"><?= $this->session->message('error');?></div>
<?php } ?>
<h1>Welcome, <?= $model->getUsername(); ?></h1>
<div  class="col-lg-3 col-md-3 col-sm-4">
    <div>
        <div class="list-group table-of-contents">
            <p class="list-group-item active">Islands</p>
            <?php foreach($model->getIslands() as $island){?>
              <a href="<?=$this->url("island", "changeIsland", [$island->getId()]);?>" class="list-group-item" <?php if($this->session->get('activeIsland')== $island->getId()){?>style = "color:yellow"<?php }?>><?= $island->getName()." (".$island->getX().",".$island->getY().")";?></a>
            <?php }?>
        </div>
    </div>

    <div>
        <div class="list-group table-of-contents">
            <p class="list-group-item active">Buildings</p>
            <?php foreach($model->getBuildings() as $building){?>
                <a href="<?=$this->url("buildings", "add", [$building->getBuildingId(),$building->getLevel()]);?>" class="list-group-item"><?=$building->getName()." Level: ".$building->getLevel();?></a>
            <?php }?>
        </div>
    </div>

    <div>
        <div class="list-group table-of-contents">
            <p class="list-group-item active">Ships</p>
                <?php
                foreach($model->getShips() as $s){?>
                    <a href="<?=$this->url("ship", "add", [$s->getShipId(), $s->getName()]);?>"  class="list-group-item"><?= $s->getName().' Amount: '.$s->getAmount();?></a>
               <?php } ?>
        </div>
    </div>

    <div>
        <div class="list-group table-of-contents">
            <p class="list-group-item active">Start Battle</p>
            <div class="well">
                <a href = "<?=$this->url("island", "listIslands");?>"" >Choose enemy</a>
            </div>
        </div>
    </div>


</div>
<!--<a href="<?=$this->url("players", "profileEdit", [$model->getId()]);?>">Edit your profile</a>--
