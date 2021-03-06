<?php
namespace frontend\forms;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
	public $name1;
	public $name2;
	public $name3;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот логин уже занят.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

			['name1', 'filter', 'filter' => 'trim'],
			['name1', 'required'],
			['name1', 'string', 'min' => 2, 'max' => 255],

			['name2', 'filter', 'filter' => 'trim'],
			['name2', 'required'],
			['name2', 'string', 'min' => 2, 'max' => 255],

			['name3', 'filter', 'filter' => 'trim'],
			['name3', 'required'],
			['name3', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот e-mail уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Логин'),
			'name1' => Yii::t('app', 'Фамилия'),
			'name2' => Yii::t('app', 'Имя'),
			'name3' => Yii::t('app', 'Отчество'),
            'email' => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Пароль'),
        ];
    }
}
