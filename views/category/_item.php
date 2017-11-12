<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:24
 *
 * @var dench\products\models\Product $model
 */

use app\widgets\ProductCard;

echo ProductCard::widget([
    'model' => $model,
    'link' => ['product/index', 'slug' => $model->slug],
]);