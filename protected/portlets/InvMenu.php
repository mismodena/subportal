<?php

class InvMenu extends XPortlet {

    public $title = 'CN + PKP Menu';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
            array('label' => Yii::t('ui', 'Pembayaran'), 'items' => array(
                    array('label' => Yii::t('ui', 'Cek Pembayaran'), 'url' => array('/invoice/index')),
                )),
            array('label' => Yii::t('ui', 'Credit Note'), 'items' => array(
                    array('label' => Yii::t('ui', 'Upload CN'), 'url' => array('/campaign/create'),
                        'visible' => Utility::getAccess($idcard, 'campaign', 'create') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Daftar CN'), 'url' => array('/campaign/index'),
                        'visible' => Utility::getAccess($idcard, 'campaign', 'index') == 0 ? false : true),
                )),
            array('label' => Yii::t('ui', 'PKP'), 'items' => array(
                    array('label' => Yii::t('ui', 'Pembatalan'), 'url' => array('/invoice/cancel'),
                        'visible' => Utility::getAccess($idcard, 'invoice', 'cancel') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Retur'), 'url' => array('/invoice/retur'),
                        'visible' => Utility::getAccess($idcard, 'invoice', 'retur') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Alokasi'), 'url' => array('/invoice/alokasi'),
                        'visible' => Utility::getAccess($idcard, 'invoice', 'alokasi') == 0 ? false : true),
                )),
        );
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
