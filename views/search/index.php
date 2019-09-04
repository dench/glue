<?php
/* @var $this yii\web\View */
/* @var $page dench\products\models\Category */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\ListView;
?>
<h1 class="mb-3"><?= $page->h1 ?></h1>

<?= $page->short ?>

<?php if ($page->text) : ?>
    <div class="card mb-3">
        <div class="card-body">
            <?= $page->text ?>
        </div>
    </div>
<?php endif; ?>

<style>
.card-img-top img {
    height: 150px !important;
}
</style>

<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
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
]);