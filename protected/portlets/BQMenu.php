<?php

class BQMenu extends XPortlet {

    public $title = 'BQ - TQ - BBT';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
            array('label' => Yii::t('ui', 'Master'), 'items' => array(
                    array('label' => Yii::t('ui', 'Pengaturan'), 'url' => array('/bq/setupIndex'),
                        'visible' => Utility::getAccess($idcard, 'bq', 'setupIndex') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Persentase'), 'url' => array('/bq/termIndex'),
                        'visible' => Utility::getAccess($idcard, 'bq', 'termIndex') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Pengajuan Saldo'), 'url' => array('/bq/uploadIndex'),
                        'visible' => Utility::getAccess($idcard, 'bq', 'uploadIndex') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Saldo'), 'url' => array('/bq/balanceIndex'),
                        'visible' => Utility::getAccess($idcard, 'bq', 'balanceIndex') == 0 ? false : true),
                )),
            array('label' => Yii::t('ui', 'Transaction'), 'items' => array(
                    array('label' => Yii::t('ui', 'Target Dealer'), 'url' => array('/bq/openIndex'),
                        'visible' => Utility::getAccess($idcard, 'bq', 'openIndex') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Klaim'), 'url' => array('/bq/claim'),
                        'visible' => Utility::getAccess($idcard, 'bq', 'claim') == 0 ? false : true),
//                array('label' => Yii::t('ui', 'Verifikasi'), 'url' => array('/bq/verify'),
//                        'visible' => Utility::getAccess($idcard, 'bq', 'verify') == 0 ? false : true),
//                        array('label'=>Yii::t('ui','Retur'), 'url'=>array('/trading/returIndex')), 
                )),
            array('label' => Yii::t('ui', 'Report'), 'items' => array(
                    array('label' => Yii::t('ui', 'Realisasi'), 'url' => array('/bq/rptRealisasi'),
                        'visible' => Utility::getAccess($idcard, 'bq', 'rptRealisasi') == 0 ? false : true),       
                    array('label' => Yii::t('ui', 'Per Q'), 'url' => array('/bq/rptQ'),
                        'visible' => Utility::getAccess($idcard, 'bq', 'rptQ') == 0 ? false : true),       
                )),
        );
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
