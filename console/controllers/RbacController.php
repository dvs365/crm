<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\components\rbac\ManagerRule;

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
		$auth->addChild($moder, $deleteClient);
		$auth->addChild($moder, $manager);


		//add the rule
		$rule = new ManagerRule();
		$auth->add($rule);

		// add "updateOwnClient" permission
		$updateOwnClient = $auth->createPermission('updateOwnClient');
		$updateOwnClient->description = 'Update own client';
		$updateOwnClient->ruleName = $rule->name;
		$auth->add($updateOwnClient);

		//"updateOwnClient" будет использоваться из "updateClient"
		$auth->addChild($updateOwnClient, $updateClient);

		//разрешаем "менеджеру" обновлять его клиентов
		$auth->addChild($manager, $updateOwnClient);

		// add "deleteOwnClient" permission
		$deleteOwnClient = $auth->createPermission('deleteOwnClient');
		$deleteOwnClient->description = 'Delete own client';
		$deleteOwnClient->ruleName = $rule->name;
		$auth->add($deleteOwnClient);

		//"deleteOwnClient" будет использоваться из "deleteClient"
		$auth->addChild($deleteOwnClient, $deleteClient);

		//разрешаем "менеджеру" удалять его клиентов
		$auth->addChild($manager, $deleteOwnClient);

		// Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
		// usually implemented in your User model.
		$auth->assign($moder, 1);
		$auth->assign($manager, 2);
		$auth->assign($manager, 5);
	}
}