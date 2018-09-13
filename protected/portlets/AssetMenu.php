<?php

class AssetMenu extends XPortlet {

    public $title = 'ASSET';

    public function getMenuData() {
        $level = Yii::app()->user->getState('level');
        $idcard = Yii::app()->user->getState('idcard');
        return array(
            array('label' => Yii::t('ui', 'Asset'), 'items' => array(
                    array('label' => Yii::t('ui', 'Department Code'), 'url' => array('/assetType/indexAssetDepartmentCode'),
                        'visible' => Utility::getAccess($idcard, 'assetType', 'indexAssetDepartmentCode') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Type Asset'), 'url' => array('/assetType/index'),
                        'visible' => Utility::getAccess($idcard, 'assetType', 'index') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'List Asset'), 'url' => array('/asset/index'),
                        'visible' => Utility::getAccess($idcard, 'asset', 'index') == 0 ? false : true),
                )),
            array('label' => Yii::t('ui', 'Pengajuan'), 'items' => array(
                    //array('label'=>Yii::t('ui','Form Asset'), 'url'=>array('/asset/createAsset')),
                    array('label' => Yii::t('ui', 'Form MAT'), 'url' => array('/mutation/index'),
                        'visible' => Utility::getAccess($idcard, 'mutation', 'index') == 0 ? false : true),
                    array('label' => Yii::t('ui', 'Form Disposal'), 'url' => array('/mutation/indexDisposal'),
                        'visible' => Utility::getAccess($idcard, 'mutation', 'indexDisposal') == 0 ? false : true),
                )),
                //  array('label'=>Yii::t('ui','Approval'), 'items'=>array(
                // 	array('label'=>Yii::t('ui','Verifikasi'), 'url'=>array('/mutation/index')),
                // )),
        );
    }

    protected function renderContent() {
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->getMenuData(),
        ));
    }

}
