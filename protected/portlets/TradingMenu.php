<?php

class TradingMenu extends XPortlet {

    public $title = 'Trading Term';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
            array('label' => Yii::t('ui', 'Master'), 'items' => array(
                    array('label' => Yii::t('ui', 'Term Item'), 'url' => array('/trading/masterIndex'),
                        'visible' => Utility::getAccess($idcard, 'trading', 'masterIndex') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Term Customer'), 'url' => array('/trading/termIndex'),
                        'visible' => Utility::getAccess($idcard, 'trading', 'termIndex') == 0 ? false : true),
                )),
            array('label' => Yii::t('ui', 'Transaction'), 'items' => array(
                    array('label' => Yii::t('ui', 'Claim'), 'url' => array('/trading/claimIndex'),
                        'visible' => Utility::getAccess($idcard, 'trading', 'claimIndex') == 0 ? false : true),
//                        array('label'=>Yii::t('ui','Retur'), 'url'=>array('/trading/returIndex')), 
                )),
        );
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
