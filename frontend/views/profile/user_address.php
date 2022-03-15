<?php

use yii\bootstrap4\ActiveForm;

?>


<?php if (isset($success) && $success) : ?>
    <div class="alert alert-success">
        Your address was successfully updated
    </div>
<?php endif ?>

<?php $addressForm = ActiveForm::begin([
    'action' => ['/profile/update-address'],
    'options' => [
        'data-pjax' => 1,
    ],
]); ?>

<?= $addressForm->field($userAddress, 'address') ?>
<?= $addressForm->field($userAddress, 'city') ?>
<?= $addressForm->field($userAddress, 'state') ?>
<?= $addressForm->field($userAddress, 'country') ?>
<?= $addressForm->field($userAddress, 'zipcode') ?>

<button class="btn btn-primary">Update</button>
<?php ActiveForm::end(); ?>