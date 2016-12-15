<?php /** @var \SoftUni\Core\ViewInterface $this */ ;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://bootswatch.com/darkly/bootstrap.min.css"/>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=$this->url("players", "profile");?>">Island Battle</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                if(isset($model) && method_exists($model,getIslandResources)){
                foreach ($model->getIslandResources() as $resource){?>
                    <li>
                        <p class="alert alert-dismissible alert-success">
                            <?= $resource->getName().': '.$resource->getAmount();?>
                        </p>
                    </li>
                <?php }}?>
            </ul>
        </div>
    </div>
</nav>

