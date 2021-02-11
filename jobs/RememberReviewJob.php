<?php

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class RememberReviewJob extends BaseObject implements JobInterface
{
    public $email;
    public $products;

    public function execute($queue)
    {
        Yii::$app->esputnik->event('get_review', $this->email, [
            'products' => $this->products,
        ]);
    }
}