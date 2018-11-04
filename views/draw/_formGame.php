<div class="form-group" id="add-game">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Game',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'visible' => false],
        'name' => ['type' => TabularForm::INPUT_TEXT],
        'country_id' => [
            'label' => 'Country',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Country::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Choose Country'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'price_per_line' => ['type' => TabularForm::INPUT_TEXT],
        'logo_path' => ['type' => TabularForm::INPUT_TEXT],
        'active' => ['type' => TabularForm::INPUT_TEXT],
        'draw_frequency' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowGame(' . $key . '); return false;', 'id' => 'game-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Game', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowGame()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

