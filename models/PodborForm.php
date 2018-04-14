<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 01.04.18
 * Time: 19:06
 */

namespace app\models;

use yii\base\Model;

class PodborForm extends Model
{
    public $step = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['step'], 'each', 'rule' => ['integer']],
        ];
    }
}