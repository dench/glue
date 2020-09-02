<?php

namespace app\controllers;

use dench\products\models\Currency;
use Yii;
use yii\web\Controller;

class CronController extends Controller
{
    public function actionFinance()
    {
        $json = file_get_contents('https://api.privatbank.ua/p24api/exchange_rates?json&date=' . date('d.m.Y'));
        //$json = file_get_contents('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11');

        $data = json_decode($json);

        $currency = Currency::find()->where(['enabled' => 1])->orderBy(['position' => SORT_ASC])->one();
        $currencyDef = Currency::findOne(Yii::$app->params['currency_id']);

        /*foreach ($data as $item) {
            if ($item->ccy == $currency->code) {
                $currencyDef->rate = $item->sale;
                $currencyDef->save();
                break;
            }
        }*/

        foreach ($data->exchangeRate as $item) {
            if ($currency->code == @$item->currency && $rate = @$item->saleRateNB) {
                $exchangeRateType = Yii::$app->params['exchangeRateType'];
                switch ($exchangeRateType) {
                    case 'NBU':
                        $rate = @$item->saleRateNB;
                        break;
                    case 'PrivatSale':
                        $rate = @$item->saleRate;
                        break;
                    case 'PrivatPurchase':
                        $rate = @$item->purchaseRate;
                        break;
                    default:
                        $rate = @$item->saleRateNB;
                }
                $currencyDef->rate = $rate;
                $currencyDef->save();
                break;
            }
        }

        die();
    }
}
