<?php
class CNDealer extends XPortlet
{
	public $title='CN Dealer Menu';

	public function getMenuData()
	{
		return array(
			array('label'=>Yii::t('ui','CN Dealer'), 'items'=>array(
				array('label'=>Yii::t('ui','Upload CN'), 'url'=>array('/campaign/create')),
				array('label'=>Yii::t('ui','Daftar CN'), 'url'=>array('/campaign/index')),
                                //array('label'=>Yii::t('ui','Verifikasi CN'), 'url'=>array('/campaign/approval')),
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