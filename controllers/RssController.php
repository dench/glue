<?php

namespace app\controllers;

use app\components\Filter;
use dench\image\helpers\ImageHelper;
use dench\page\models\Page;
use dench\products\models\Category;
use dench\products\models\Product;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class RssController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');

        if (!$page = Page::findOne(1)) {
            return null;
        }

        $items = [
            'title' => Yii::$app->name,
            'link' => Yii::$app->request->hostInfo,
            'description' => $page->description,
        ];

        $main = $this->generateXml($items);

        $items = [];

        $temp = Category::find()->select('id')->where(['enabled' => false])->asArray()->column();

        $category_ids = [];

        foreach ($temp as $id) {
            $category_ids[] = $id;
            $pods = Category::find()->select('id')->where(['parent_id' => $id])->asArray()->column();
            foreach ($pods as $p) {
                $category_ids[] = $p;
                $pods2 = Category::find()->select('id')->where(['parent_id' => $id])->asArray()->column();
                foreach ($pods2 as $p2) {
                    $category_ids[] = $p2;
                }
            }
        }

        $products = Product::find()->joinWith('categories')->where(['{{%product}}.enabled' => true])->andWhere(['NOT IN', '{{%category}}.id', $category_ids])->all();


        foreach ($products as $product) {
            if (empty($product->description)) {
                $product->description = str_replace('{0}', $product->name, Yii::$app->params['templateDescription_ru']);
            }

            $available = $product->variants[0]->available;

            if ($available > 0) {
                $availability = 'in_stock';
            } elseif ($available < 0) {
                $availability = 'preorder';
            } else {
                $availability = 'out_of_stock';
            }

            $items[] = $this->generateXml([
                'g:id' => $product->id,
                'g:title' => $product->name,
                //'g:description' => trim(str_replace(['&nbsp;', "\n\n", '&mdash;', '&ndash;', '&deg;', '&laquo;', '&raquo;', '&bull;'], [' ', "\n", '-', '-', '°', '«', '»', '•'], Filter::text($product->text))),
                'g:description' => trim(htmlspecialchars_decode(Filter::text($product->text))),
                'g:link' => Url::to(['product/index', 'slug' => $product->slug], true),
                'g:image_link' => $product->image ? Url::to(ImageHelper::thumb($product->image->id, 'normal'), true) : null,
                'g:condition' => 'new',
                'g:availability' => $availability,
                'g:mpn' => @$product->categories[0]->name,
                'g:brand' => $product->brand ? $product->brand->name : @$product->categories[0]->parent->name,
                'g:price' =>  $product->priceDef . '.00 ' . $product->currencyDef->code,
                'g:google_product_category' => '',
                'g:product_type' => '',
            ], 'item');
        }

        $rss = Html::tag('rss', $main . "<channel>\n" . implode("", $items) . "</channel>", ['xmlns:g' => 'http://base.google.com/ns/1.0', 'version' => '2.0']);

        return '<?xml version="1.0" encoding="UTF-8" ?>
' . $rss;
    }

    public function generateXml($array, $wrap = null)
    {
        $xml = "\n";

        foreach ($array as $key => $value) {
            $xml .= '<' . $key . '>' . $value . '</' . $key . '>' . "\n";
        }

        if ($wrap) {
            $xml = '<' . $wrap . '>' . $xml . '</' . $wrap . '>' . "\n";
        }

        return  $xml;
    }
}