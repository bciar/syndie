<?php
/**
 * Created with love.
 * User: benas
 * Date: 5/22/17
 * Time: 12:40 AM
 */

namespace app\components;

use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;

class Nav extends \yii\bootstrap\Nav
{

    /**
     * @inheritdoc
     */
    protected function renderDropdown($items, $parentItem)
    {
        $return = Dropdown::widget([
            'options' => ArrayHelper::getValue($parentItem, 'dropDownOptions', []),
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'clientOptions' => false,
            'view' => $this->getView(),
        ]);

        $return = str_replace('<ul', '<div', $return);

        return $return;
    }
}