<?php

namespace app\controllers;

use dench\products\models\Currency;
use Yii;
use yii\web\Controller;

class CronController extends Controller
{
    public function actionFinance()
    {
        $json = file_get_contents('http://resources.finance.ua/ru/public/currency-cash.json');

        $data = json_decode($json);

        $bank = Yii::$app->params['bank'];

        foreach ($data->organizations as $org) {
            if ($org->id === $bank) {
                $currency = Currency::findOne(1);
                $currency->rate = $org->currencies->USD->ask;
                $currency->save();
                break;
            }
        }

        die();
    }
}
