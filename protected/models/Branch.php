<?php

class Branch extends CActiveRecord
{
    public function tableName()
	{
            return 'Cabang';
	}
        
        public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
    
    
}
