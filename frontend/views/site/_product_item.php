<?php

/** @var yii\web\View $this */

use yii\helpers\StringHelper;
use yii\helpers\Url;

/** @var \common\models\Product $model */

?>
<div class="card h-100">
    <!-- Product image-->
    <img class="card-img-top" src="<?php echo $model::getProductImageUrl($model->image) ?>" alt="<?php echo $model->imageFile ?>" />
    <!-- Product details-->
    <div class="card-body p-4">
        <div class="text-justify">
            <!-- Product name-->
            <h5 class="fw-bolder"><?php echo $model->name ?></h5>
            <!-- Product price-->
            <div class="card-text">
                <p><?php echo $model->getShortDescription() ?></p>
                <h3><?php echo Yii::$app->formatter->asCurrency($model->price) ?></h3>
            </div>
        </div>
    </div>
    <!-- Product actions-->
    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
        <a class="btn btn-outline-dark mt-auto btn-add-to-cart" href="<?php echo Url::to(['cart/add']) ?>">Add to Cart</a>
    </div>
</div>
