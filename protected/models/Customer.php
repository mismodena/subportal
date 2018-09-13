<?php

class Customer extends AccpacActiveRecord
{
    public $keyWord;
    
    public function tableName()
    {
        return 'ARCUS';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

   
        
    
    
    
}
