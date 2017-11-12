<?php
/* @var $this yii\web\View */
/* @var $page dench\products\models\Category */
/* @var $categories dench\products\models\Category[] */
/* @var $products dench\products\models\Product[] */
/* @var $searchModel dench\products\models\ProductFilter */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $features dench\products\models\Feature[] */

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Products'),
    'url' => ['category/index'],
];
$this->params['breadcrumbs'][] = $page->name;
?>
<h1><?= $page->h1 ?></h1>

<?= $page->text ?>

<?php Pjax::begin(['id' => 'pjax']); ?>

    <?= $this->render('_search', [
        'model' => $searchModel,
        'page' => $page,
        'features' => $features])
    ?>

    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => "{items}\n{pager}",
        'emptyTextOptions' => [
            'class' => 'alert alert-danger',
        ],
        'options' => [
            'class' => 'list-group',
        ],
        'itemOptions' => [
            'class' => 'list-group-item',
        ],
    ]);
    ?>

<?php Pjax::end(); ?>

<div class="page-seo">
    <?= $page->seo ?>
</div>