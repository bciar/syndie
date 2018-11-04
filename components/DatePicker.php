<?php
/**
 * Created with love.
 * User: benas
 * Date: 7/13/17
 * Time: 4:36 AM
 */

namespace app\components;

use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;


class DatePicker extends \kartik\date\DatePicker
{

    protected function renderAddon(&$options, $type = 'picker')
    {
        if ($options === false) {
            return '';
        }
        if (is_string($options)) {
            return $options;
        }
        $icon = ($type === 'picker') ? 'calendar' : 'remove';
        Html::addCssClass($options, 'input-group-addon kv-date-' . $icon);
        $icon = '<i class="fa fa-' . ArrayHelper::remove($options, 'icon', $icon) . '"></i>';
        $title = ArrayHelper::getValue($options, 'title', '');
        if ($title !== false && empty($title)) {
            $options['title'] = ($type === 'picker') ? Yii::t('kvdate', 'Select date') :
                Yii::t('kvdate', 'Clear field');
        }
        return Html::tag('span', $icon, $options);
    }
}