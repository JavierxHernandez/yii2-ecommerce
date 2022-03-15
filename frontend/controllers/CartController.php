<?php

namespace frontend\controllers;

use Yii;
use common\models\CartItem;
use common\models\Product;
use frontend\base\Controller as BaseController;
use yii\filters\ContentNegotiator;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends BaseController
{
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ]
            ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            // Get items from session
        } else {
            $cartItems = CartItem::findBySql("
                SELECT
                    c.product_id as id,
                    p.image,
                    p.name,
                    p.price,
                    c.quantity,
                    p.price * c.quantity as total_price
                FROM
                    cart_items c LEFT JOIN products p ON p.id = c.product_id
                WHERE
                    c.created_by = :userId", [
                'userId' => Yii::$app->user->id,
            ])->asArray()->all();
        }

        return $this->render('index', [
            'cartItems' => $cartItems,
        ]);
    }

    public function actionAdd()
    {
        $id = Yii::$app->request->post('id');
        $product = Product::find()->id($id)->published()->one();
        if (! $product) {
            throw new NotFoundHttpException("Product does not exits");
        } 
        
        if (Yii::$app->user->isGuest) {
            // Todo save in session
        } else {
            $userId = Yii::$app->user->id;
            $cartItem = CartItem::find()->userId($userId)->productId($id)->one();

            if ($cartItem) {
                $cartItem->quantity++;
            } else {
                $cartItem = new CartItem();
                $cartItem->product_id = $id;
                $cartItem->created_by = Yii::$app->user->id;
                $cartItem->quantity = 1;
            }

            if ($cartItem->save()) {
                return [
                    'success' => true,
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => $cartItem->errors,
                ];
            }
        }

    }
}
