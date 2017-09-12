<?php

namespace frontend\service\auth;

use common\models\User;
use frontend\forms\SignupForm;

class SignupService
{
    public function signup(SignupForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->name1,
            $form->name2,
            $form->name3,
            $form->email,
            $form->password
        );

        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }

        // the following three lines were added:
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('manager');
        $auth->assign($authorRole, $user->getId());

        return $user;
    }
}