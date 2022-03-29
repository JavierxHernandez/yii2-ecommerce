<?php

use common\models\Order;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = 'Details - Order #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$orderAddress = $model->orderAddress;

?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'total_price:currency',
            [
                'attribute' => 'status',
                'content' => function ($model) {
                    if ($model->status === Order::STATUS_COMPLETED) {
                        return Html::tag('span', 'Paid', ['class' => 'badge badge-success']);
                    } else if ($model->status === Order::STATUS_DRAFT) {
                        return Html::tag('span', 'Unpaid', ['class' => 'badge badge-secondary']);
                    } else {
                        return Html::tag('span', 'Failed', ['class' => 'badge badge-danger']);
                    }
                }

            ],
            'firstname',
            'lastname',
            'email:email',
            'transaction_id',
            'paypal_order_id',
            'created_at:datetime',
        ],
    ]) ?>
    <h4>Address</h4>
    <?= DetailView::widget([
        'model' => $orderAddress,
        'attributes' => [
            'address',
            'city',
            'state',
            'country',
            'zipcode',
        ],
    ]) ?>

    <h4>Order Items</h4>
    <table class="table table-sm">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <?php foreach ($model->orderItems as $item) : ?>
                <tbody>
                    <tr>
                        <td>
                            <img src="<?php echo $item->product->imageUrl() ?>" style="width: 100px">
                        </td>
                        <td>
                            <?php echo $item->product_name ?>
                        </td>
                        <td>
                            <?php echo $item->quantity ?>
                        </td>
                        <td>
                            <?php echo Yii::$app->formatter->asCurrency($item->quantity * $item->unit_price) ?>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>

</div>