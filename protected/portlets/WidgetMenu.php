<?php
class WidgetMenu extends XPortlet
{
	public $title='Widgets';

	public function getMenuData()
	{
		return array(
			array('label'=>Yii::t('ui','User Info'), 'items'=>array(
				array('label'=>Yii::t('ui','List view'), 'url'=>array('/person/index')),
				array('label'=>Yii::t('ui','Grid view'), 'url'=>array('/person/admin')),
				array('label'=>Yii::t('ui','Detail view'), 'url'=>array('/person/view', 'id'=>1)),
				array('label'=>Yii::t('ui','Tree view'), 'url'=>array('/site/widget', 'view'=>'treeview')),
				array('label'=>Yii::t('ui','Multilevel menu'), 'url'=>array('/site/widget', 'view'=>'menu')),
				array('label'=>Yii::t('ui','Breadcrumbs'), 'url'=>array('/site/widget', 'view'=>'breadcrumbs')),
			)),
			array('label'=>Yii::t('ui','Product Info'), 'items'=>array(
				array('label'=>Yii::t('ui','Autocomplete new'), 'url'=>array('/site/widget', 'view'=>'autocomplete')),
				array('label'=>Yii::t('ui','Autocomplete old'), 'url'=>array('/site/widget', 'view'=>'autocomplete_legacy')),
				array('label'=>Yii::t('ui','Masked textfield'), 'url'=>array('/site/widget', 'view'=>'maskedtextfield')),
				array('label'=>Yii::t('ui','Multiple file upload'), 'url'=>array('/site/widget', 'view'=>'multifileupload')),
				array('label'=>Yii::t('ui','Datepicker'), 'url'=>array('/site/widget', 'view'=>'datepicker')),
				array('label'=>Yii::t('ui','Star rating'), 'url'=>array('/site/widget', 'view'=>'starrating')),
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