<?php

class CashbookDetail extends AccpacActiveRecord
{
    public $formatedAmount;
    
    public function tableName()
    {
        return 'CBBTDT';
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
        
    public function afterFind() {
        $this->formatedAmount = Yii::app()->format->number(($this->DTLAMOUNT));
    return parent::afterFind();
}
    
}
