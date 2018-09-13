<?php

class HRISMenu extends XPortlet {

    public $title = 'HRIS Menu';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
            array('label' => Yii::t('ui', 'Kontrak Kerja'), 'items' => array(
                    array('label' => Yii::t('ui', 'Form Kontrak'), 'url' => array('/HRIS/createContract'),
                        'visible' => Utility::getAccess($idcard, 'HRIS', 'createContract') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Daftar Kontrak'), 'url' => array('/HRIS/index'),
                        'visible' => Utility::getAccess($idcard, 'HRIS', 'index') == 0 ? false : true),
                )),
            array('label' => Yii::t('ui', 'P R M D'), 'items' => array(
                    array('label' => Yii::t('ui', 'Form PRMD'), 'url' => array('/HRIS/createPrmd'),
                        'visible' => Utility::getAccess($idcard, 'HRIS', 'createPRMD') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Daftar PRMD'), 'url' => array('/HRIS/indexPrmd'),
                        'visible' => Utility::getAccess($idcard, 'HRIS', 'indexPRMD') == 0 ? false : true),
                )),
        );
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
