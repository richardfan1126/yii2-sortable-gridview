<?php

namespace richardfan1126\sortable;

use yii\web\AssetBundle;

class SortableGridViewAsset extends AssetBundle {
    public $sourcePath = '@vendor/richardfan1126/yii2-sortable-gridview/assets';
    public $baseUrl = '@web';
    public $js = [
        'js/jquery.ui.touch-punch.min.js',
        'js/sortable-grid-view.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];
}