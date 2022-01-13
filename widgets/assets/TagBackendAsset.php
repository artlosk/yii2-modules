<?php

namespace artlosk\tags\widgets\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class TagBackendAsset
 * @package artlosk\tags\widgets\assets
 */
class TagBackendAsset extends AssetBundle
{
    public $sourcePath = '@vendor/contrib/yii2-tag/widgets/assets';

    /**
     * @var array
     */
    public $css = [
        'css/token.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/token.js',
        'js/tag.js',
    ];

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
    ];
}
