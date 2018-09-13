<?php
class UtilityMenu extends XPortlet
{
	public $title='Utility Menu';

	public function getMenuData()
	{
		return array(
			array('label'=>Yii::t('ui','User Info'), 'items'=>array(
				array('label'=>Yii::t('ui','Form User'), 'url'=>array('/user/create')),
				array('label'=>Yii::t('ui','Daftar User'), 'url'=>array('/user/admin')),
			)),
                       /* array('label'=>Yii::t('ui','Moa Role'), 'items'=>array(
				array('label'=>Yii::t('ui','Config Moa'), 'url'=>array('/moarole/create')),
				array('label'=>Yii::t('ui','Moa List'), 'url'=>array('/moarole/admin')),
			)),*/
                        array('label'=>Yii::t('ui','Rights'), 'items'=>array(
				array('label'=>Yii::t('ui','Assignments'), 'url'=>array('/rights/assignment/view')),
                                array('label'=>Yii::t('ui','Permissions'), 'url'=>array('/rights/authItem/permissions')),
                                array('label'=>Yii::t('ui','Roles'), 'url'=>array('/rights/authItem/roles')),
                                array('label'=>Yii::t('ui','Tasks'), 'url'=>array('/rights/authItem/tasks')),
                                array('label'=>Yii::t('ui','Operations'), 'url'=>array('/rights/authItem/operations')),
			)),
		);
	}

	protected function renderContent()
	{
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->getMenuData(),
		));
	}
}