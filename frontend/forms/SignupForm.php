<?php
namespace frontend\forms;

use common\models\User;
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

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
			$user->name1 = $this->name1;
			$user->name2 = $this->name2;
			$user->name3 = $this->name3;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
			$user->save(false);

            // the following three lines were added:
            $auth = Yii::$app->authManager;
            $authorRole = $auth->getRole('manager');
            $auth->assign($authorRole, $user->getId());

            return $user;
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Имя пользователя'),
			'name1' => Yii::t('app', 'Фамилия'),
			'name2' => Yii::t('app', 'Имя'),
			'name3' => Yii::t('app', 'Отчество'),
            'email' => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Пароль'),
        ];
    }
}
