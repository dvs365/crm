<?php

namespace frontend\services\auth;

use common\models\User;
use frontend\forms\SignupForm;
use yii\mail\MailerInterface;
use Yii;

class SignupService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function signup(SignupForm $form): User
    {
        $user = User::requestSignup(
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

        $sent = $this->mailer
            ->compose(
                ['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Sending error.');
        }

        return $user;
    }

    public function confirm($token)
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }

        /* @var $user User */
        $user = User::findOne(['email_confirm_token' => $token]);

        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->confirmSignup();

        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }
}