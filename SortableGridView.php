<?php

namespace richardfan\sortable;

use Closure;

use yii\base\InvalidConfigException;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\grid\GridViewAsset;
use yii\helpers\Html;

class SortableGridView extends GridView {
    /**
     * (required) The URL of related SortableAction
     * 
     * @see \richardfan1126\sortable\SortableAction
     * @var string
     */
    public $sortUrl;
    
    /**
     * (optional) The text shown in the model while the server is reordering model
     * You can use HTML tag in this attribute.
     * 
     * @var string
     */
    public $sortingPromptText = 'Loading...';
    
    /**
     * (optional) The text shown in alert box when sorting failed.
     * 
     * @var string
     */
    public $failText = 'Fail to sort';

    public function init(){
        parent::init();
        
        if(!isset($this->sortUrl)){
            throw new InvalidConfigException("You must specify the sortUrl");
        }
        
        GridViewAsset::register($this->view);
        SortableGridViewAsset::register($this->view);

        $this->tableOptions['class'] .= ' sortable-grid-view';
    }
    
    /**
     * {@inheritDoc}
     * @see \yii\grid\GridView::renderTableRow()
     */
    public function renderTableRow($model, $key, $index)
    {
        $cells = [];
        /* @var $column Column */
        foreach ($this->columns as $column) {
            $cells[] = $column->renderDataCell($model, $key, $index);
        }
        
        if ($this->rowOptions instanceof Closure) {
            $options = call_user_func($this->rowOptions, $model, $key, $index, $this);
        } else {
            $options = $this->rowOptions;
        }
        
        $options['id'] = "items[]_{$model->primaryKey}";
        $options['data-key'] = is_array($key) ? json_encode($key) : (string) $key;
        
        return Html::tag('tr', implode('', $cells), $options);
    }

    public function run(){
        foreach($this->columns as $column){
			if(property_exists($column, 'enableSorting'))
				$column->enableSorting = false;
        }
        
        parent::run();

        $options = [
            'id' => $this->id,
            'action' => $this->sortUrl,
            'sortingPromptText' => $this->sortingPromptText,
            'sortingFailText' => $this->failText,
            'csrfTokenName' => \Yii::$app->request->csrfParam,
            'csrfToken' => \Yii::$app->request->csrfToken,
        ];
        
        $options = Json::encode($options);
        
        $this->view->registerJs("jQuery.SortableGridView($options);");
    }
}
