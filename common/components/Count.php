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
            ['repeat' => Todo::REPEAT_NO],
            ['repeat' => Todo::REPEAT_DAY],
            ['AND', ['=', 'EXTRACT(DOW FROM time_from)', $date->format('w')], ['=', 'repeat', Todo::REPEAT_WEEK]],
            ['AND', ['=', 'EXTRACT(DAY FROM time_from)', $date->format('j')], ['=', 'repeat', Todo::REPEAT_MONTH]],
            ['AND', ['=', 'EXTRACT(DAY FROM time_from)', $date->format('j')], ['=', 'EXTRACT(MONTH FROM time_from)', $date->format('n')], ['=', 'repeat', Todo::REPEAT_YEAR]],
        ])->count();
        return $models;
    }
}