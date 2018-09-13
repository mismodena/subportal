<?php

class DocumentMenu extends XPortlet {

    public $title = 'Document Menu';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
//                        array('label'=>Yii::t('ui','Generate Document'), 'items'=>array(
//                        array('label'=>Yii::t('ui','Generate Faktur'), 'url'=>array('/document/create')),
//                    )),					
            array('label' => Yii::t('ui', 'General'), 'items' => array(
                    array('label' => Yii::t('ui', 'Logbook'), 'url' => array('/document/logbook'),
                        'visible' => Utility::getAccess($idcard, 'document', 'logbook') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'List Document'), 'url' => array('/document/index'),
                        'visible' => Utility::getAccess($idcard, 'document', 'index') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Export Document'), 'url' => array('/document/exportExcel'),
                        'visible' => Utility::getAccess($idcard, 'document', 'exportExcel') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Follow Up'), 'url' => array('/document/followup'),
                        'visible' => Utility::getAccess($idcard, 'document', 'followup') == 0 ? false : true),
                )),
            array('label' => Yii::t('ui', 'Sales'), 'items' => array(
                    array('label' => Yii::t('ui', 'Nota Penagihan'), 'url' => array('/document/request'),
                        'visible' => Utility::getAccess($idcard, 'document', 'request') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Faktur TTTFP'), 'url' => array('/document/indextt'),
                        'visible' => Utility::getAccess($idcard, 'document', 'indextt') == 0 ? false : true),
                )),
            array('label' => Yii::t('ui', 'Finance'), 'items' => array(
                    array('label' => Yii::t('ui', 'MD Review'), 'url' => array('/document/review'),
                        'visible' => Utility::getAccess($idcard, 'document', 'review') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'TR Review'), 'url' => array('/document/treview'),
                        'visible' => Utility::getAccess($idcard, 'document', 'treview') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Gagal Tertagih'), 'url' => array('/document/failed'),
                        'visible' => Utility::getAccess($idcard, 'document', 'failed') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Giro / Transfer'), 'url' => array('/document/indexgiro'),
                        'visible' => Utility::getAccess($idcard, 'document', 'indexgiro') == 0 ? false : true),
                )),
        );
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
