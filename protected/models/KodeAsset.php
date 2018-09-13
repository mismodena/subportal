<?php

class KodeAsset extends CActiveRecord
{
    public function tableName()
	{
            return 'ms_kodeAsset';
	}
        
        public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
    

}
