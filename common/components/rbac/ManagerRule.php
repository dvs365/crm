<?
namespace common\components\rbac;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class ManagerRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['client'])) {
			if ($params['client']->user_id == $user) {
				return true;
			}
			if ($params['client']->user_add_id == $user) {
				return true;
			}
		}
		return false;
		//return isset($params['client']) ? $params['client']->user_id == $user : false;
    }
}