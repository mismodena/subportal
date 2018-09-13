<?php

class FinanceMenu extends XPortlet {

    public $title = 'Proforma Invoice';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
            array('label' => Yii::t('ui', 'Proforma Invoice'), 'items' => array(
                    array('label' => Yii::t('ui', 'Form'), 'url' => array('/invoice/createPI'),
                        'visible' => Utility::getAccess($idcard, 'invoice', 'createPI') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Form Item'), 'url' => array('/invoice/createPIItem'),
                        'visible' => Utility::getAccess($idcard, 'invoice', 'createPIItem') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Daftar PI'), 'url' => array('/invoice/indexPI'),
                        'visible' => Utility::getAccess($idcard, 'invoice', 'indexPI') == 0 ? false : true),
                //array('label'=>Yii::t('ui','Verifikasi CN'), 'url'=>array('/campaign/approval')),
                )),
            array('label' => Yii::t('ui', 'Finance'), 'items' => array(
                    array('label' => Yii::t('ui', 'Verifikasi'), 'url' => array('/invoice/verifyPI'),
                        'visible' => Utility::getAccess($idcard, 'invoice', 'verifyPI') == 0 ? false : true),
                //array('label'=>Yii::t('ui','Verifikasi CN'), 'url'=>array('/campaign/approval')),
                )),
        );
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
