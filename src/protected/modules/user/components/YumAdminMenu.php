<?

Yii::import('zii.widgets.CPortlet');

class YumAdminMenu extends CPortlet {
	public function init() {
		$this->title = sprintf('%s <br /> %s: %s',
				Yum::t('Usermenu'),
				Yum::t('Logged in as'),
				Yii::app()->user->data()->username);
		$this->contentCssClass = 'menucontent';
		return parent::init();
	}

	public function run() {
		$this->widget('YumMenu', array(
					'items' => $this->getMenuItems()
					));

		parent::run();
	}

	public function getMenuItems() {
		return array(
				array('label'=>'Users', 'items' => array(
						array('label'=> 'Statistics', 'url'=>array('//user/statistics/index')),
						array('label' => 'User administration', 'url' => array('//user/user/admin')),
						array('label' => 'Create new user', 'url' => array('//user/user/create')),
						array('label' => 'Generate Demo Data', 'url' => array('//user/user/generateData'), 'visible' => Yum::module()->debug),
						)
					),
				array('label'=>'Roles / Access control', 'active' => Yii::app()->controller->id == 'role' || Yii::app()->controller->id == 'permission' || Yii::app()->controller->id == 'action', 'visible' => Yum::hasModule('role'), 'items' => array(
						array('label' => 'Roles', 'url' => array('//role/role/admin')),
						//array('label' => 'Create new role', 'url' => array('//role/role/create')),
//						array('label' => 'Permissions', 'url' => array('//role/permission/admin')),
//						array('label' => 'Grant permission', 'url' => array('//role/permission/create')),
//						array('label' => 'Actions', 'url' => array('//role/action/admin')),
//						array('label' => 'Create new action', 'url' => array('//role/action/create')),
						)
					),
				array('label'=>'Profiles',
						'visible' => Yum::hasModule('profile'),
						'items' => array(
							array('label' => 'Manage profiles', 'url' => array('//profile/profile/admin')),
						//	array('label' => 'Show profile visits', 'url' => array('//profile/profile/visits')),
						//	array('label' => 'Manage profile fields', 'url' => array('//profile/fields/admin')),
						//	array('label' => 'Create profile field', 'url' => array('//profile/fields/create')),
							)
						),
				array('label' => 'Misc', 'items' => array(
				array('label' => 'Text translations', 'url' => array('//user/translation/admin')),
							array('label' => 'Change admin Password', 'url' => array('//user/user/changePassword')),
							array('label' => 'Logout', 'url' => array('//user/user/logout')),
							)
						),
				);

	}
}
?>






