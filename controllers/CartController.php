<?php

namespace app\controllers;

use app\models\OrderForm;
use app\widgets\Cart;
use dench\page\models\Page;
use dench\products\models\Variant;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;

class CartController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\AjaxFilter',
                'only' => ['modal', 'add', 'del'],
            ],
        ];
    }

    public function actionIndex()
    {
        $page = Page::viewPage('cart');

        $cart = $this->getCart();

        $variant_ids = array_keys($cart);

        $items = Variant::find()->where(['id' => $variant_ids])->andWhere(['enabled' => true])->all();

        return $this->render('index', [
            'page' => $page,
            'items' => $items,
            'cart' => $cart,
        ]);
    }

    public function actionModal()
    {
        $footer = Html::button(Yii::t('app', 'Continue shopping'), ['class' => 'btn btn-primary mr-auto', 'data-dismiss' => 'modal']);
        $footer .= Html::a(Yii::t('app', 'Place an order'), ['/cart/index'], ['class' => 'btn btn-warning']);

        $cart = $this->getCart();

        $variant_ids = array_keys($cart);

        $items = Variant::find()->where(['id' => $variant_ids])->andWhere(['enabled' => true])->all();

        $data = [
            'title' => Yii::t('app', 'Buy'),
            'body' => $this->renderAjax('modal', [
                'items' => $items,
                'cart' => $cart,
            ]),
            'footer' => $footer,
        ];

        return Json::encode($data);
    }

    public function actionBlock()
    {
        return Cart::widget();
    }

    public function actionOrder()
    {
        $page = Page::viewPage('order');

        $model = new OrderForm();

        /*if ($model->load(Yii::$app->request->post()) && $model->send()) {
            Yii::$app->session->setFlash('orderSubmitted');
            return $this->redirect(['']);
        }*/

        return $this->render('order', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    public function actionDel($id)
    {
        $cart = $this->getCart();

        ArrayHelper::remove($cart, $id);

        return $this->setCart($cart);
    }

    public function actionAdd($id)
    {
        $cart = $this->getCart();

        @$cart[$id] += 1;

        return $this->setCart($cart);
    }

    public function actionSet($id, $count)
    {
        $cart = $this->getCart();

        $cart[$id] = $count;

        return $this->setCart($cart);
    }

    private function setCart($data)
    {
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => serialize($data),
            'expire' => time() + 3600 * 24 * 7,
        ]));

        return true;
    }

    private function getCart()
    {
        $cart = Yii::$app->request->cookies->getValue('cart');

        if (empty($cart)) {
            return [];
        } else {
            return unserialize($cart);
        }
    }
}
