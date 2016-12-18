<?php

/**
 * @var \SoftUni\Core\ViewInterface $this
 * @var \SoftUni\Models\View\BattleResultsViewModel $model
 */
?>
<div class="col-lg-10">

    <div class="list-group table-of-contents">
        <p class="list-group-item active">Islands</p>
        <ul>
            <?php foreach ($model->getBattleReport() as $report){?>
                <li class="list-group-item" >

                    <label class = "btn btn-default btn-xs">Attacker:</label><?= $report->getAttackerId()?>
                    <label class = "btn btn-default btn-xs">Attacked:</label><?= $report->getAttackedId()?>
                    <label class = "btn btn-default btn-xs">Result:</label><?= $report->getResult()?>
                    <label class = "btn btn-default btn-xs">Date:</label><?= $report->getBattleDate()?>
                </li>
            <?php } ?>
        </ul>
        <a href = "<?= $this->url("players","profile");?>" class = ' btn btn-primary'>Cancel</a>
    </div>
</div>