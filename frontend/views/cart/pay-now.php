<?php

/**
 * @var common\models\Order $order
 * @var common\models\OrderAddress $orderAddress
 * @var array $cartItems
 * @var int $productQuantity
 * @var float $totalPrice
 */

use yii\helpers\Url;

$orderAddress = $order->orderAddress;

?>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo Yii::$app->params['paypalClientId'] ?>&currency=USD"></script>

<h4>Order summary: #<?php echo $order->id ?></h4>
<hr>
<div class="row">
    <div class="col">
        <h4>Account information</h4>
        <table class="table">
            <tr>
                <th>Firstname</th>
                <td><?php echo $order->firstname ?></td>
            </tr>
            <tr>
                <th>Lastname</th>
                <td><?php echo $order->lastname ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $order->email ?></td>
            </tr>
        </table>
        <h4>Addres information</h4>
        <table class="table">
            <tr>
                <th>Address</th>
                <td><?php echo $orderAddress->address ?></td>
            </tr>
            <tr>
                <th>City</th>
                <td><?php echo $orderAddress->city ?></td>
            </tr>
            <tr>
                <th>State</th>
                <td><?php echo $orderAddress->state ?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?php echo $orderAddress->country ?></td>
            </tr>
            <tr>
                <th>Zip-code</th>
                <td><?php echo $orderAddress->zipcode ?></td>
            </tr>
        </table>
    </div>
    <div class="col">
        <h4>Products</h4>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <?php foreach ($order->orderItems as $item) : ?>
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
        <hr>
        <table class="table">
            <tr>
                <th>Total Items</th>
                <td><?php echo $order->getItemsQuantity() ?></td>
            </tr>
            <tr>
                <th>Total Price</th>
                <td><?php echo Yii::$app->formatter->asCurrency($order->total_price) ?></td>
            </tr>
        </table>
        <!-- Set up a container element for the button -->
        <div id="paypal-button-container"></div>
    </div>
</div>

<script>
    paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $order->total_price ?> // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                    }
                }]
            });
        },

        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                console.log(orderData);
                const $form = $('#checkout-form');
                const formData = $form.serializeArray();
                formData.push({
                    name: 'transactionId',
                    value: orderData.id,
                });
                formData.push({
                    name: 'orderId',
                    value: data.orderID
                    });
                formData.push({
                    name: 'transactionStatus',
                    value: orderData.status,
                });

                $.ajax({
                    method: 'post',
                    url: '<?php echo Url::to(['/cart/submit-payment', 'orderId' => $order->id]) ?>',
                    data: formData,
                    success: function(res) {
                        alert("Thank you for your payment!");
                        window.location.href = "";
                    }
                });
            });
        }
    }).render('#paypal-button-container');
</script>