<?php
class APMenu extends XPortlet
{
	public $title='AP Invoice';

	public function getMenuData()
	{
		return array(
                array('label'=>Yii::t('ui','User'), 'items'=>array(
				array('label'=>Yii::t('ui','Pengajuan'), 'url'=>array('/FormPP/createFPP')),				
                array('label'=>Yii::t('ui','Daftar FPP (AP)'), 'url'=>array('/FormPP/indexFPP')), 
                array('label'=>Yii::t('ui','Log Book'), 'url'=>array('/invoice/logbook')),
				array('label'=>Yii::t('ui','Inkuiri'), 'url'=>array('/invoice/inkuiri')),
				//array('label'=>Yii::t('ui','Status Invoice'), 'url'=>array('/invoice/logbookInvoice')),
				//array('label'=>Yii::t('ui','Verifikasi CN'), 'url'=>array('/campaign/approval')),
			)),
				array('label'=>Yii::t('ui','Accounting'), 'items'=>array(
                array('label'=>Yii::t('ui','Verifikasi FPP'), 'url'=>array('/formPP/veriAcct')),
			)),
                array('label'=>Yii::t('ui','Finance'), 'items'=>array(
				array('label'=>Yii::t('ui','Penerimaan Dokumen'), 'url'=>array('/invoice/createAP')),
				//array('label'=>Yii::t('ui','Penerimaan Penagihan'), 'url'=>array('/invoice/createAPP')),				
                array('label'=>Yii::t('ui','Daftar Penerimaan'), 'url'=>array('/invoice/indexAP')),
				array('label'=>Yii::t('ui','Serah Terima User'), 'url'=>array('/invoice/delegation')),
                array('label'=>Yii::t('ui','Pembayaran FPP'), 'url'=>array('/formPP/verifikasiFPP')),
                array('label'=>Yii::t('ui','Jatuh  Tempo'), 'url'=>array('/invoice/indexJT')),
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