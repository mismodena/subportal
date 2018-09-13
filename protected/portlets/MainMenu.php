<?php

class MainMenu extends CWidget {
   

    public function run() {

        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
               /* array(
                    'label' => Yii::t('ui', 'FPP (Kas Kecil)'),
                    'url' => array('/formPP/index'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'formPP', 'index') == 0 ? false : true
                ),
                //array(
                //	'label'=>Yii::t('ui', 'CN + PKP'),
                //	'url'=>array('/campaign/index'),
                //	'active'=>$this->isMenuItemActive(array(
                //		'site'=>array('widget'),						
                //	)),                                    
                //),
                array(
                    'label' => Yii::t('ui', 'FPP (AP)'),
                    'url' => array('/invoice/inkuiri'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'invoice', 'inkuiri')== 0 ? false : true
                ),
                array(
                    'label' => Yii::t('ui', 'Proforma Invoice'),
                    'url' => array('/invoice/indexPI'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'invoice', 'indexPI')== 0 ? false : true
                ),
                array(
                    'label' => Yii::t('ui', 'CN + PKP'),
                    'url' => array('/invoice/index'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )), 
                    'visible'=> Utility::getAccess($idcard, 'invoice', 'index')== 0 ? false : true
                ),
                array(
                    'label' => Yii::t('ui', 'HRIS'),
                    'url' => array('/HRIS/index'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'HRIS', 'index')== 0 ? false : true
                ),
                array(
                    'label' => Yii::t('ui', 'Asset'),
                    'url' => array('/asset/index'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'asset', 'index')== 0 ? false : true
                ),
                array(
                    'label' => Yii::t('ui', 'Trading Term'),
                    'url' => array('/trading/masterIndex'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'trading', 'masterIndex')== 0 ? false : true
                ),
                array(
                    'label' => Yii::t('ui', 'Document Flow'),
                    'url' => $level == 'SD' ? array('/document/request') : array('/document/index'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'document', 'request')== 0 && Utility::getAccess($idcard, 'document', 'index')== 0  ? false : true
                ),*/
                array(
                    'label' => Yii::t('ui', 'BQ - TQ - BBT'),
                    'url' => array('/bq/balanceIndex'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'bq', 'balanceIndex')== 0 ? false : true
                ),
                /*array(
                    'label' => Yii::t('ui', 'Linea'),
                    'url' => array('/linea/index'),
                    'active' => $this->isMenuItemActive(array(
                        'site' => array('widget'),
                    )),
                    'visible'=> Utility::getAccess($idcard, 'linea', 'index')== 0 ? false : true
                ),*/
                array(
                    'label' => Yii::t('ui', 'Utility'),
                    'url' => array('/user/admin'),
                    'active' => $this->isMenuItemActive(array(
                        //'site'=>array('widget'),
                        'user' => array('index', 'admin', 'view', 'update', 'create'),
                        'moarole' => array('index', 'admin', 'view', 'update', 'create'),
                    )),
                    'visible' => Yii::app()->user->isRole('Admin') && !Yii::app()->user->isGuest,
                ),
                array(
                    'label' => Yii::t('ui', 'Login'),
                    'url' => array('/site/login'),
                    'visible' => Yii::app()->user->isGuest,
                ),
                array(
                    'label' => Yii::t('ui', 'Logout') . ' - ' . Yii::app()->user->name,
                    'url' => array('/site/logout'),
                    'visible' => !Yii::app()->user->isGuest,
                ),
            ),
        ));
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if the currently requested URL matches given pattern of the menu item
     * @param array the pattern to be checked ('controller'=>array('action1','action2') or 'controller'=>array('*'))
     * @return boolean whether the menu item is active
     */
    protected function isMenuItemActive($pattern) {
        $route = $this->controller->getRoute();
        foreach ($pattern as $controller => $actions) {
            foreach ($actions as $action) {
                if ($action == '*' && $this->controller->uniqueID == $controller)
                    return true;
                elseif ($route == $controller . '/' . $action)
                    return true;
            }
        }
        return false;
    }

}

?>