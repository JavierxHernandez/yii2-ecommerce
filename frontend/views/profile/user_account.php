<?php

use yii\bootstrap4\ActiveForm;

?>


<?php if (isset($success) && $success) : ?>
    <div class="alert alert-success">
        Your account was successfully updated
    </div>
<?php endif ?>

<?php $form = ActiveForm::begin([
    'action' => ['/profile/update-account'],
    'options' => [
        'data-pjax' => 1,
    ],
]); ?>

<?= $form->field($user, 'username') ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($user, 'firstname') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($user, 'lastname') ?>
    </div>
</div>
<?= $form->field($user, 'email') ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($user, 'password')->passwordInput() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($user, 'passwordConfirm')->passwordInput() ?>
    </div>
</div>

<button class="btn btn-primary">Update</button>
<?php ActiveForm::end(); ?>