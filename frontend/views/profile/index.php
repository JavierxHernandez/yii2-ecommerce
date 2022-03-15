<?php

/** @var yii\web\View $this */

use yii\widgets\Pjax;

/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */
/** @var \yii\web\View $this */

?>

<div class="row justify-content-center">

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                Address information
            </div>
            <div class="card-body">
                <?php Pjax::begin([
                    'enablePushState' => false,
                ]) ?>

                <?php echo $this->render('user_address', [
                    'userAddress' => $userAddress,
                ]) ?>

                <?php Pjax::end() ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                Account information
            </div>
            <div class="card-body">
                <?php Pjax::begin([
                    'enablePushState' => false,
                ]) ?>

                <?php echo $this->render('user_account', [
                    'user' => $user,
                ]) ?>

                <?php Pjax::end() ?>
            </div>
        </div>
    </div>

</div>