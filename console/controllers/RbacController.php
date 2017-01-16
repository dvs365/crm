<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;
		$auth->removeAll();

		// add "createClient" permission
		$createClient = $auth->createPermission('createClient');
		$createClient->description = 'Create a client';
		$auth->add($createClient);

		// add "updateClient" permission
		$updateClient = $auth->createPermission('updateClient');
		$updateClient->description = 'Update client';
		$auth->add($updateClient);

		// add "deleteClient" permission
		$deleteClient = $auth->createPermission('deleteClient');
		$deleteClient->description = 'Delete client';
		$auth->add($deleteClient);

		// add "manager" role and give this role the "createClient" permission
		$manager = $auth->createRole('manager');
		$auth->add($manager);
		$auth->addChild($manager, $createClient);

		// add "moder" role and give this role the "updateClient" permission
		// as well as the permissions of the "moder" role
		$moder = $auth->createRole('moder');
		$auth->add($moder);
		$auth->addChild($moder, $updateClient);
		$auth->addChild($moder, $manager);

		// Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
		// usually implemented in your User model.
		$auth->assign($manager, 2);
		$auth->assign($moder, 1);
	}
}