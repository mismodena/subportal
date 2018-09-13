<?php

class LineaMenu extends XPortlet {

    public $title = 'Linea Menu';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
            array('label' => Yii::t('ui', 'Main'), 'items' => array(
                    array('label' => Yii::t('ui', 'Nilai Linea'), 'url' => array('/linea/index'),
//                        'visible' => Utility::getAccess($idcard, 'HRIS', 'createContract') == 0 ? false : true),
//                    array('label' => Yii::t('ui', 'Daftar Kontrak'), 'url' => array('/HRIS/index'),
//                        'visible' => Utility::getAccess($idcard, 'HRIS', 'index') == 0 ? false : true),
                    )),
        ));
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
