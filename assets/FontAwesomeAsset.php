<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 07.12.17
 * Time: 15:21
 */

namespace app\assets;

use kartik\base\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/fortawesome/font-awesome';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'only' => ['fonts/*', 'css/*']
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setupAssets('css', ['css/font-awesome']);
        parent::init();
    }
}