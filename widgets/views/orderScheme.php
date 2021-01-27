<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 04.02.18
 * Time: 17:55
 *
 * @var $baseUrl string
 */
?>
<div class="card how mt-3 mb-4">
    <div class="card-body text-center">
        <div class="h1"><?= Yii::t('app', 'Order scheme') ?></div>
        <div class="row">
            <div class="col-sm-4 px-lg-5">
                <div>
                    <img src="<?= $baseUrl . '/img/how-1.png' ?>" alt="<?= Yii::t('app', 'Ordering goods') ?>">
                </div>
                <div class="my-2">
                    <a href="#" class="h3"><span class="text-primary">1.</span> <?= Yii::t('app', 'Ordering goods') ?></a>
                </div>
                <div class="text-muted">
                    <?= Yii::t('app', 'Place an order on the website through the shopping cart or contact us by phone.') ?>
                </div>
            </div>
            <div class="col-sm-4 px-lg-5">
                <div>
                    <img src="<?= $baseUrl . '/img/how-2.png' ?>" alt="<?= Yii::t('app', '100% prepayment') ?>">
                </div>
                <div class="my-2">
                    <a href="#" class="h3"><span class="text-primary">2.</span> <?= Yii::t('app', 'Payment') ?></a>
                </div>
                <div class="text-muted">
                    <?= Yii::t('app', 'Choose a convenient form of payment') ?>:<br>
                    - <?= Yii::t('app', 'Payment upon receipt') ?><br>
                    - <?= Yii::t('app', 'Payment on the site') ?>
                </div>
            </div>
            <div class="col-sm-4 px-lg-5">
                <div>
                    <img src="<?= $baseUrl . '/img/how-3.png' ?>" alt="<?= Yii::t('app', 'Delivery') ?>">
                </div>
                <div class="my-2">
                    <a href="#" class="h3"><span class="text-primary">3.</span> <?= Yii::t('app', 'Delivery') ?></a>
                </div>
                <div class="text-muted">
                    <?= Yii::t('app', 'Receive the goods at the Nova Poshta branch or pick it up yourself at our office.') ?>
                </div>
            </div>
        </div>
    </div>
</div>