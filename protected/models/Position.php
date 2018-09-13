<?php

class Position extends CActiveRecord
{
    public function tableName()
	{
            return 'Position';
	}
        
        public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
    
    
}
