<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:09
 *
 * @var $text string
 * @var $name string
 */
?>
<?php if ($text) : ?>
    <div class="card my-3">
        <a class="card-header bg-dark text-white" id="headingText" data-toggle="collapse" href="#collapseText" aria-expanded="true" aria-controls="collapseText">
            <i class="fa fa-minus-square"></i><?= Yii::t('app', 'Description') ?>
        </a>
        <div id="collapseText" class="collapse show" aria-labelledby="headingText" data-parent="#accordion">
            <div class="card-body">
                <?= $text ?>
            </div>
        </div>
    </div>
<?php endif; ?>
