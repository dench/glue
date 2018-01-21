<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 23:09
 *
 * @var $model dench\products\models\Product
 */

use app\widgets\FeaturesTable;

?>
<?php if (@$model->variants[0]->values) : ?>
    <div class="card my-3">
        <a class="card-header bg-dark text-white" id="headingFeatures" data-toggle="collapse" href="#collapseFeatures" aria-expanded="true" aria-controls="collapseFeatures">
            <i class="fa fa-minus-square"></i><?= Yii::t('app', 'Features') ?>
        </a>
        <div id="collapseFeatures" class="collapse show" aria-labelledby="headingFeatures" data-parent="#accordion">
            <div class="card-body">
                <?= $model->text_features ?>
                <div class="table-responsive">
                    <?= FeaturesTable::widget([
                        'variants' => $model->variants,
                        'theadText' => '',
                        'options' => [
                            'class' => 'table table-sm table-striped text-center table-hover table-condensed table-default table-head-bg',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>