<?php

class Department extends CActiveRecord
{
    public function tableName()
	{
            return 'Department';
	}
        
        public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
    

}
