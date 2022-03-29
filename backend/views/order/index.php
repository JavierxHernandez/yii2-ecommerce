<?php

use common\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'id' => 'ordersTable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'fullname',
                'content' => function($model) {
                    return $model->firstname . ' ' . $model->lastname;
                },
            ],
            'total_price:currency',
            //'email:email',
            //'transaction_id',
            //'paypal_order_id',
            [
                'attribute' => 'status',
                'content' => function($model) {
                    if ($model->status === Order::STATUS_COMPLETED) {
                        return Html::tag('span', 'Paid', ['class' => 'badge badge-success']);
                    } else if ($model->status === Order::STATUS_DRAFT){
                        return Html::tag('span', 'Unpaid', ['class' => 'badge badge-secondary']);
                    } else {
                        return Html::tag('span', 'Failed', ['class' => 'badge badge-danger']);
                    }
                }

            ],
            'created_at:datetime',
            //'created_by',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {delete}',
                'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
