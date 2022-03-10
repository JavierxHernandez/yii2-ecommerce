<?php

/** @var yii\web\View $this */

use yii\bootstrap4\LinkPager;
use yii\widgets\ListView;

/** @var \Yii\data\ActiveDataProvider $dataProvider */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">
        <?php echo ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{summary}<div class="row">{items}</div>{pager}',
            'itemView' => '_product_item',
            'itemOptions' => [
                'class' => 'col-lg-4 d-flex align-items-stretch product-item'
            ],
            'pager' => [
                'class' => LinkPager::class
            ]
        ]) ?>
    </div>
</div>