<?php
/**
 * Created by PhpStorm.
 * User: kostys
 * Date: 05.11.15
 * Time: 13:28
 */
use yii\helpers\Html;



foreach ($specitems as $item) {

    $choice = 'none';
    if ($item['ch_ff'] == 1)
        $choice = 'form_fulltime';
    if ($item['ch_fe'] == 1)
        $choice = 'form_extramural';

    $options = [];
    $options['none'] = 'не выбрана';
    if ($item['form_fulltime'] == 1)
        $options['form_fulltime'] = 'Очная';
    if ($item['form_extramural'] == 1)
        $options['form_extramural'] = 'Заочная';


    echo '<div class="list-group-item"><h4><small>[' . $item['code'] . ']</small> ' . $item['name'] . '</h4>'
        . Html::radioList(
            'spec['.$item['id'].']',
            $choice,
            $options
        ) . '</div>';
}
?>

