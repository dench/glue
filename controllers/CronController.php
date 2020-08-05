<?php

namespace app\controllers;

use dench\products\models\Currency;
use Yii;
use yii\web\Controller;

class CronController extends Controller
{
    /**
     * [0] => stdClass Object
    (
        [ccy] => USD
        [base_ccy] => UAH
        [buy] => 27.50000
        [sale] => 27.90000
    )

    [1] => stdClass Object
    (
        [ccy] => EUR
        [base_ccy] => UAH
        [buy] => 32.30000
        [sale] => 32.90000
    )

    [2] => stdClass Object
    (
        [ccy] => RUR
        [base_ccy] => UAH
        [buy] => 0.35900
        [sale] => 0.38700
    )

    [3] =>
        [ccy] => BTC
        [base_ccy] => USD
        [buy] => 10761.3847
        [sale] => 11894.1621
     */
    public function actionFinance()
    {
        $json = file_get_contents('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11');

        $data = json_decode($json);

        $currency = Currency::find()->where(['enabled' => 1])->orderBy(['position' => SORT_ASC])->one();
        $currencyDef = Currency::findOne(Yii::$app->params['currency_id']);

        foreach ($data as $item) {
            if ($item->ccy == $currency->code) {
                $currencyDef->rate = $item->sale;
                $currencyDef->save();
                break;
            }
        }

        die();
    }
}
