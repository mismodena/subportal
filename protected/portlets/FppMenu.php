<?php

class FppMenu extends XPortlet {

    public $title = 'FPP Menu';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
            array('label' => Yii::t('ui', 'Permohonan FPP'), 'items' => array(
                    array('label' => Yii::t('ui', 'Form FPP'), 'url' => array('/formPP/create'),
                        'visible' => Utility::getAccess($idcard, 'formPP', 'create') == 0 ? false : true
                    ),
                    array('label' => Yii::t('ui', 'Daftar FPP'), 'url' => array('/formPP/index'),
                        'visible' => Utility::getAccess($idcard, 'formPP', 'index') == 0 ? false : true
                    ),
                //array('label'=>Yii::t('ui','Persetujuan FPP'), 'url'=>array('/formPP/approval')),
                )),
            array('label' => Yii::t('ui', 'Finance - Accounting'), 'items' => array(
                    array('label' => Yii::t('ui', 'Review Accounting'), 'url' => array('/formPP/accounting'),
                        'visible' => Utility::getAccess($idcard, 'formPP', 'accounting') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Review Finance'), 'url' => array('/formPP/finance'),
                        'visible' => Utility::getAccess($idcard, 'formPP', 'finance') == 0 ? false : true),
                )),
        );
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
