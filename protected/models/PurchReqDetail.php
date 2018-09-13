<?php

class PurchReqDetail extends AccpacActiveRecord
{
    public $formatedAmount;
    public $ACCTDESC;
    
    public function tableName()
    {
        return 'PTPRD';
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
        $this->formatedAmount = Yii::app()->format->number(($this->HCURRVAL));
    return parent::afterFind();
    }
    
    public function getDetail($id)
    {   
        $criteria=new CDbCriteria;
        
        $criteria=array(
            'alias'=>'a',
            'select'=>"  RQNHSEQ, RQNLREV, FMTITEMNO, ITEMDESC, 
                        case RQRDDATE
                        when 0 then ''
                        else dbo.fnGetAccpacDate(RQRDDATE) end as RQRDDATE ,
                        GLACCTFULL, SCURRVAL  ",
            'condition'=>"                       
                    RQNNUMBER = :cat " ,                                
            'params'=>array(
                ':cat' => $id,                            
            )
        ); 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,            
            'pagination'=>array(
                'pageSize'=>40,
            ),
        ));
    }
    
}
