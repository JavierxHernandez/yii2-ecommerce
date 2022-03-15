<?php

namespace frontend\base;

use Yii;
use common\models\CartItem;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->view->params['cartItemCount'] = CartItem::findBySql("
            SELECT SUM(quantity) FROM cart_items WHERE created_by = :userId",
            ['userId' => Yii::$app->user->id])->scalar();
        return parent::beforeAction($action);
    }
}
