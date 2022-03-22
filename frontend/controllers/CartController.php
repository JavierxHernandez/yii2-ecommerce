<?php

namespace frontend\controllers;

use Yii;
use common\models\CartItem;
use common\models\Product;
use frontend\base\Controller as BaseController;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
class CartController extends BaseController
{
    /**
     * This function tells the controller that the content negotiation will be handled by the
     * ContentNegotiator class. 
     * 
     * The only actions that will be affected by the content negotiation are the add action. 
     * 
     * The formats that will be accepted are JSON. 
     * 
     * The VerbFilter class will be used to filter the delete action. 
     * 
     * The delete action will only be affected by POST and DELETE HTTP verbs.
     * 
     * @return The ContentNegotiator class is used to return the correct format.
     */
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST', 'DELETE'],
                ],
            ]
            ];
    }

    /**
     * If the user is logged in, get all the cart items from the database. If the user is not logged
     * in, get the cart items from the session
     *
     * @return The view file index.php is being rendered.
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
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

    /**
     * If the user is logged in, add the product to the user's cart. If the user is not logged in, add
     * the product to the session
     *
     * @return The success flag and errors array.
     */
    public function actionAdd()
    {
        $id = Yii::$app->request->post('id');
        $product = Product::find()->id($id)->published()->one();

        if (! $product) {
            throw new NotFoundHttpException("Product does not exits");
        }

        if (Yii::$app->user->isGuest) {

            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            $found = false;

            foreach ($cartItems as &$item) {
                if ($item['id'] == $id) {
                    $item['quantity']++;
                    $found = true;
                    break;
                }
            }

            if (! $found) {
                $cartItem = [
                    'id' => $id,
                    'image' => $product->image,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'total_price' => $product->price,
                ];
                $cartItems[] = $cartItem;
            }

            Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);

        } else {
            $userId = Yii::$app->user->id;
            $cartItem = CartItem::find()->userId($userId)->productId($id)->one();

            if ($cartItem) {
                $cartItem->quantity++;
            } else {
                $cartItem = new CartItem();
                $cartItem->product_id = $id;
                $cartItem->created_by = $userId;
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

     /**
      * Delete a product from the cart
      * @param id The ID of the product to be deleted.
      * @return Nothing.
      */
     public function actionDelete($id)
    {
        if (isGuest()) {
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY, []);
            foreach ($cartItems as $i => $cartItem) {
                if ($cartItem['id'] == $id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
        } else {
            CartItem::deleteAll(['product_id' => $id, 'created_by' => currUserId()]);
        }

        return $this->redirect(['index']);
    }

    /**
     * If the user is logged in, update the quantity of the product in the user's cart. If the user is
     * not logged in, update the quantity of the product in the session
     * 
     * @return The total quantity of items in the cart.
     */
    public function actionChangeQuantity()
    {
        $id = Yii::$app->request->post('id');
        $product = Product::find()->id($id)->published()->one();
        if (! $product) {
            throw  new NotFoundHttpException("Product does not exist");
        }
        $quantity = Yii::$app->request->post('quantity');
        if ($quantity < 1 || $quantity === '') {
            $quantity = 1;
        }

        if (isGuest()) {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);

            foreach ($cartItems as &$cartItem) {
                if ($cartItem['id'] == $id) {
                    $cartItem['quantity'] = $quantity;
                    break;
                }
            }
            Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);

        } else {
            $cartItem = CartItem::find()->userId(currUserId())->productId($id)->one();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        }
        return CartItem::getTotalQuantityForUser(currUserId());
    }
}
