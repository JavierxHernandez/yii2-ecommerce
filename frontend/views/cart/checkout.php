<?php

/**
 * @var \common\models\Order $oder
 * @var \common\models\OrderAddress $orderAddress
 * @var array $cartItems
 * @var int $productQuantity
 * @var float $totalPrice
 */

use common\models\Product;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

?>


<?php $form = ActiveForm::begin([
    'id' => 'checkout-form',
]); ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Account information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($order, 'firstname') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'lastname') ?>
                    </div>
                </div>
                <?= $form->field($order, 'email') ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Address information</h5>
            </div>
            <div class="card-body">
                <?= $form->field($orderAddress, 'address') ?>
                <?= $form->field($orderAddress, 'city') ?>
                <?= $form->field($orderAddress, 'state') ?>
                <?= $form->field($orderAddress, 'country') ?>
                <?= $form->field($orderAddress, 'zipcode') ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5>Checkout information</h5>
            </div>
            <div class="card-body">
            <table class="table table-hover">
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
            <tbody>
                <?php foreach ($cartItems as $cartItem) : ?>
                    <tr data-id="<?php echo $cartItem['id'] ?>" data-url="<?php echo Url::to(['/cart/change-quantity'])?>">
                        <td><img src="<?php echo Product::getProductImageUrl($cartItem['image']) ?>" alt="<?php echo $cartItem['name'] ?>" style="width:100px"></td>
                        <td><?php echo $cartItem['name'] ?></td>
                        <td><?php echo $cartItem['quantity'] ?></td>
                        <td><?php echo Yii::$app->formatter->asCurrency($cartItem['total_price']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
                <table class="table">
                        <td>
                            <b>Total Items</b>
                        </td>
                        <td class="text-right">
                            <?php echo $productQuantity ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Total Price</b>
                        </td>
                        <td class="text-right">
                            <?php echo Yii::$app->formatter->asCurrency($totalPrice) ?>
                        </td>
                    </tr>
                </table>

                <p class="text-right mt-3">
                    <button class="btn btn-secondary">Checkout</button>
                </p>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>