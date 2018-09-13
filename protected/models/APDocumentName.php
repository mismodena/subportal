<?php

class APDocumentName extends CActiveRecord
{
    public $docName;
    public $invDocName;
    
    public function tableName()
    {
        return 'ms_docCategory';
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('invDocID, invDocName', 'safe', 'on'=>'search'),
        );
    }           
    
}