# yii2-sortable-gridview
This is an extension of Yii2 GridView.

This extension render a sortable GridView which you can drag and drop the record items from the list, and store the order in ActiveRecord.

## Getting Started
### Installing
Install with Composer:

    composer require richardfan1126/yii2-sortable-gridview

or

    php composer.phar require richardfan1126/yii2-sortable-gridview

### Setting up SortableAction
In your controller, add the SortableAction into action():
```php
use richardfan\sortable\SortableAction;

public function actions(){
    return [
        'sortItem' => [
            'class' => SortableAction::className(),
            'activeRecordClassName' => YourActiveRecordClass::className(),
            'orderColumn' => 'name_of_field_storing_ordering',
        ],
        // your other actions
    ];
}
```

### Setting up SortableGridView
In the view file, use SortableGridView as using the Yii default GridView
```php
use richardfan\sortable\SortableGridView;

<?= SortableGridView::widget([
    'dataProvider' => $dataProvider,
    
    // you can choose how the URL look like,
    // but it must match the one you put in the array of controller's action()
    'sortUrl' => Url::to(['sortItem']),
    
    'columns' => [
        // Data Columns
    ],
]); ?>
```

You may also want to disable the pagination of data provider, in order to allow reordering across pages.

You can do it by calling below before passing data provider into SortableGridView
```php
$dataProvider->pagination = false;
```
