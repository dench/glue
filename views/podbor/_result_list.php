<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 14.04.18
 * Time: 17:59
 *
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\widgets\ListView;
?>

<h2><?= Yii::t('app', '{0, plural, =0{items not found} =1{item found} one{# items found} few{# items found} many{# items found} other{# items found} for these criteria', [$dataProvider->totalCount]) ?></h2>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_result_list_item',
    'layout' => "{items}\n{pager}",
    'emptyTextOptions' => [
        'class' => 'alert alert-danger',
    ],
    'options' => [
        'class' => 'list-group mb-4',
    ],
    'itemOptions' => [
        'class' => 'list-group-item',
    ],
]); ?>