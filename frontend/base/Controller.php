<?php

namespace frontend\base;

use Yii;
use common\models\CartItem;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->view->params['cartItemCount'] = CartItem::getTotalQuantityForUser(currUserId());
        return parent::beforeAction($action);
    }
}
