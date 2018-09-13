<?php

class APDocumentList extends CActiveRecord
{
    public $docCheck;
    public $invDocName;
    
    public function tableName()
    {
        return 'ms_docList';
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('', 'safe', 'on'=>'search'),
        );
    }           
    
}
