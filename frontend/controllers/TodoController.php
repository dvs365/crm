<?php

namespace frontend\controllers;

use Yii;
use common\models\Todo;
use frontend\models\TodoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TodoController implements the CRUD actions for Todo model.
 */
class TodoController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
            'access' => [
                'class' => AccessControl::className(),
//              'only' => ['*'],
                'rules' => [
                    [
//                      'actions' => ['index','view', 'update', 'create', 'day', 'week'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post', 'get'],
				],
			],
		];
	}

	/**
	 * Lists all Todo models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new TodoSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

    /**
     * Lists all Todo models.
     * @return mixed
     */
    public function actionDay()
    {
        $datetime = \Yii::$app->request->post('date') ? Yii::$app->request->post('date') : date('d.m.Y');
        $date = \DateTime::createFromFormat('d.m.Y', $datetime);
        $models = Todo::find()->where(
            'todo.user_id = '.\Yii::$app->user->id
        )->andWhere(
            'time_from < \''.$date->format('Y-m-d 00:00:01').'\''
        )->andWhere(['OR',
            ['repeat' => Todo::REPEAT_NO],
			['repeat' => Todo::REPEAT_DAY],
            ['AND', ['=', 'EXTRACT(DOW FROM time_from)', $date->format('w')], ['=', 'repeat', Todo::REPEAT_WEEK]],
            ['AND', ['=', 'EXTRACT(DAY FROM time_from)', $date->format('j')], ['=', 'repeat', Todo::REPEAT_MONTH]],
            ['AND', ['=', 'EXTRACT(DAY FROM time_from)', $date->format('j')], ['=', 'EXTRACT(MONTH FROM time_from)', $date->format('n')], ['=', 'repeat', Todo::REPEAT_YEAR]],
        ])->orderBy(['time_to' => SORT_ASC])->all();
        return $this->render('day', [
            'models' => $models,
        ]);
    }

    /**
     * Lists all Todo models.
     * @return mixed
     */
    public function actionWeek()
    {
        $datetime = \Yii::$app->request->post('date') ? Yii::$app->request->post('date') : date('d.m.Y');
        $date = \DateTime::createFromFormat('d.m.Y', $datetime);
        for ($i = 1; $i <= 7; $i++) {
            $models[$i] = Todo::find()->where(
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
            ])->orderBy(['time_to' => SORT_ASC])->all();
            $day[$i] = \DateTime::createFromFormat('d.m.Y', $date->format('d.m.Y'));
            $week[$i] = $this->dayOfWeek($date->format('w'));
            $date->add(new \DateInterval('P1D'));//Добавляем 1 день
        }

        return $this->render('week', [
            'models' => $models,
            'day' => $day,
            'week' => $week,
        ]);
    }

    public function actionMonth()
	{
		$datetime = \Yii::$app->request->post('date') ? Yii::$app->request->post('date') : date('d.m.Y');
		$dateCur = \DateTime::createFromFormat('d.m.Y', $datetime);
		$date = \DateTime::createFromFormat('d.m.Y', '01.'.$dateCur->format('m').'.'.$dateCur->format('Y'));
		$month = $date->format('m');
		$lastDay = $date->format('t');
        $flag = false;
		for ($i = 1; $i <= $lastDay; $i++) {
			$count = Todo::find()->where(
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
			$monthArr[$month][$date->format('W')][$date->format('w')] = ['date' => \DateTime::createFromFormat('d.m.Y', $date->format('d.m.Y')), 'count' => $count];
			$date->add(new \DateInterval('P1D'));//Добавляем 1 день
			if ($month != $date->format('m') && !$flag) {
				$month = $date->format('m');
				$i = 0;
				$lastDay = $date->format('t');
				$flag = true;
			}
		}
		return $this->render('month', [
			'month' => $monthArr,
		]);
	}
	/**
	 * Displays a single Todo model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Todo model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($client_id = null)
	{
		$model = new Todo();
		if ($model->load(Yii::$app->request->post())) {
			$model->client_id = $client_id;
			$model->user_id = \Yii::$app->user->id;
			$model->time_from = $model->setTimeFrom();
			$model->time_to = $model->setTimeTo();
			if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Todo model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->date = $model->getDate();
		$model->time = $model->getTime();
		$model->date1 = $model->getDate1();
		$model->date2 = $model->getDate2();
		if ($model->load(Yii::$app->request->post())) {
			$model->time_from = $model->setTimeFrom();
			$model->time_to = $model->setTimeTo();
			if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
		}
		return $this->render('update', [
			'model' => $model,
		]);

	}

	/**
	 * Deletes an existing Todo model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Todo model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Todo the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Todo::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	private function dayOfWeek($week)
    {
        $dayOfWeek = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];
        return $dayOfWeek[$week];
    }
}