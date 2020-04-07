<?php
/** @var Entities\Product $product */
?>
<div class="card bg-light" style="width:300px">
    <img class="card-img-top" src="<?=$product->getImageUrl()?>" alt="Card image" style="width:100%">
    <div class="card-body">
        <h4 class="card-title"><?=$product->getName()?></h4>
        <a href="/site/delete/<?=$product->getId()?>" class="btn btn-primary">Delete</a>
    </div>
</div>
