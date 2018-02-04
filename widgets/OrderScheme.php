<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 04.02.18
 * Time: 17:54
 */

namespace app\widgets;

use yii\base\Widget;

class OrderScheme extends Widget
{
    public function run()
    {
        return $this->render('orderScheme');
    }
}