<?php

/**
 * @var \common\models\Order $oder
 * @var \common\models\OrderAddress $orderAddress
 * @var array $cartItems
 * @var int $productQuantity
 * @var float $totalPrice
 */

use yii\bootstrap4\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'action' => [''],
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
                <table class="table">
                    <tr>
                        <td>
                            <?php echo $productQuantity ?> Products
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total Price
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