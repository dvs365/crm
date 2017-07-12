<?php

namespace common\components;

use common\models\Todo;
use yii\base\Component;

class Count extends Component {

    public function todo() {
        $datetime = date('d.m.Y');
        $date = \DateTime::createFromFormat('d.m.Y', $datetime);
        $models = Todo::find()->where(
            'todo.user_id = '.\Yii::$app->user->id
        )->andWhere(
            'time_from < \''.$date->format('Y-m-d 00:00:01').'\''
        )->andWhere(
            'time_to > \''.$date->format('Y-m-d 00:00:01').'\''
        )->andWhere(['OR',
            ['repeat' => 'none'],
            ['repeat' => 'dayly'],
            ['AND', ['=', 'DAYOFWEEK(time_from)', $date->format('w')+1], ['=', 'repeat', 'weekly']],
            ['AND', ['=', 'DAYOFMONTH(time_from)', $date->format('j')], ['=', 'repeat', 'monthly']],
            ['AND', ['=', 'DAYOFMONTH(time_from)', $date->format('j')], ['=', 'MONTH(time_from)', $date->format('n')], ['=', 'repeat', 'yearly']],
        ])->orderBy(['time_to' => SORT_ASC])->count();
        return $models;
    }
}