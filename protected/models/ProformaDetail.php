<?php

class ProformaDetail extends CActiveRecord
{    
   
    public $keyWord;
    public $accName;
    public $total;
    
    public function tableName()
    {
        return 'tr_invDetail';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('invID, itemModel, itemDesc, unitPrice, unitQty', 'required',),
                array('unitPrice, unitQty', 'numerical',),
                array('invID, itemModel, itemDesc, unitPrice, unitQty, keyWord, total, items' , 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                    'invID' => 'No. Invoice',                    
                    'itemModel' => 'Model',
                    'itemDesc' => 'Deskripsi',
                    'unitPrice' => 'Harga',
                    'unitQty' => 'Qty',
            );
    }

    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.invNo',$this->keyWord,false);  
            $criteria->compare('h.poName',$this->keyWord,false);  
            $criteria->compare('h.poNo',$this->keyWord,false);  
            
            $criteria->alias = 'h';                            
            $criteria->select=" 
                     invNo, invDate, poNo, poName, sa.accName, invTotal, invDisc, invTotalWtx, invDP, salesAcc 
                        " ;
            $criteria->join = "	
                    left join tr_invDetail dt on dt.invID = h.invID
                    left join ms_salesAccount sa on sa.accNo = h.salesAcc
                    ";

            $criteria->limit = 20;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,                      
            ));                    

    }
    
    public function GetInvDetail($invNo)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>'  a.itemModel, a.unitPrice, a.unitQty, a.itemDesc ',
            'condition'=>"                       
                    a.invID = :cat " ,                                
            'params'=>array(
                ':cat' => $invNo,                            
            )
        ); 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,                       
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
    }
    
protected function beforeSave()
    {            
        if(parent::beforeSave())
        {
            if($this->isNewRecord)
            {
                    $this->inputTime=new CDbExpression('getdate()');
                    $this->inputUN=Yii::app()->user->name;
                    $this->modifTime=new CDbExpression('getdate()');
                    $this->modifUN=Yii::app()->user->name;
            }
            else
                    $this->modifTime=new CDbExpression('getdate()');
                    $this->modifUN=Yii::app()->user->name;
            return true;
        }
        else
                return false;
    }
}
