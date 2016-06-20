<?php

namespace richardfan\sortable;

use yii\base\Action;
use yii\web\HttpException;
use yii\base\InvalidConfigException;

class SortableAction extends Action {
    /**
     * (required) The ActiveRecord Class name
     * 
     * @var string
     */
    public $activeRecordClassName;
    
    /**
     * (required) The attribute name where your store the sort order.
     * 
     * @var string
     */
    public $orderColumn;
    
    public function init(){
        parent::init();
        
        if(!isset($this->activeRecordClassName)){
            throw new InvalidConfigException("You must specify the activeRecordClassName");
        }

        if(!isset($this->orderColumn)){
            throw new InvalidConfigException("You must specify the orderColumn");
        }
    }
    
    public function run(){
        if(!\Yii::$app->request->isAjax){
            throw new HttpException(404);
        }
        
        if (isset($_POST['items']) && is_array($_POST['items'])) {
            $activeRecordClassName = $this->activeRecordClassName;
            foreach ($_POST['items'] as $i=>$item) {
                $page = $activeRecordClassName::findOne($item);
                $page->updateAttributes([
                    $this->orderColumn => $i,
                ]);
            }
        }
    }
}