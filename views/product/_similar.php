<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:03
 *
 * @var $similar dench\products\models\Product[]
 * @var $viewed boolean
 */

use app\widgets\ProductCard;

?>
<?php if ($viewed): ?>
    <div class="h1 text-center mt-4"><?= Yii::t('app', 'You looked through') ?></div>
<?php else: ?>
    <div class="h1 text-center mt-4"><?= Yii::t('app', 'Similar products') ?></div>
<?php endif; ?>

<div class="list-group mb-4">
    <?php foreach ($similar as $product) : ?>
        <div class="list-group-item">
            <?= ProductCard::widget([
                'model' => $product,
                'link' => ['product/index', 'slug' => $product->slug],
            ]);
            ?>
        </div>
    <?php endforeach; ?>
</div>