<?php

/**
 * @var array $cartItems
 */

use common\models\Product;
use yii\bootstrap4\Html;
use yii\helpers\Url;

?>

<div class="card">
    <div class="card-header">
        <h3>Your card items</h3>
    </div>
    <div class="card-body p-0">
        <?php if(!empty($cartItems)): ?>
        <table class="table table-hover">
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
            <tbody>
                <?php foreach ($cartItems as $cartItem) : ?>
                    <tr>
                        <td><?php echo $cartItem['name'] ?></td>
                        <td><img src="<?php echo Product::getProductImageUrl($cartItem['image']) ?>" alt="<?php echo $cartItem['name'] ?>" style="width:100px"></td>
                        <td><?php echo $cartItem['price'] ?></td>
                        <td><?php echo $cartItem['quantity'] ?></td>
                        <td><?php echo $cartItem['total_price'] ?></td>
                        <td>
                            <?php echo Html::a('Delete', ['cart/delete', 'id' => $cartItem['id']], [
                                'class' => 'btn btn-outline-danger btn-sm',
                                'data-method' => 'post',
                                'data-confirm' => 'Are you sure you want to remove this product from your cart?'
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="card">
            <div class="card-body text-right">
                <a class="btn btn-primary" href="<?php echo Url::to(['cart/checkout']) ?>">Checkout</a>
            </div>
        </div>
        <?php else: ?>
            <p class="text-muted text-center p-5">There are no items in the card</p>
        <?php endif; ?>
    </div>
</div>