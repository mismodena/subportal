<?php

class DocumentDetail extends CActiveRecord
{    
   
    public $keyWord; 
	public $fromDate;
	public $toDate;
	public $check;
	public $invTotal;
	public $customer;
        
    
    public function tableName()
    {
        return 'tr_docDetail';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('docNumber, docType,', 'required',),
                             
                array('docID, docNumber, docType, status, keyWord, nextStep, rcvNote', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                "docNumber" => "Doc. Number",
                "status" => "Status",              
                "docType" => "Type",
            );
    }

    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.docNumber',$this->keyWord,true,'OR');    
            
            $criteria->alias = 'h';                            
            $criteria->select=" docNumber, status, dt.custName customer, i.invnetwtx invTotal" ;
            $criteria->join = " left join SGTDAT..MIS_PAJAK_DETAIL dt on dt.invNumber = h.docNumber 
								left join SGTDAT..OEINVH i on i.INVNUMBER = h.docNumber ";

            //$criteria->limit = 20;

            return new ActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'docNumber ASC',
                  )
            ));                    

    }
    
    public function getSJDetail($docNum)
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

           $criteria->addCondition(" docNumber = '$docNum' and docType = 'SJ' and qtyShipment > 0");  
            
            $criteria->alias = 'dt';                            
            $criteria->select="  docNumber, dt.docID, itemNo, itemName, qtyOrder, qtyShipment " ;
            $criteria->join = " left join tr_docDetailItem di on dt.docID = di.docID ";

            //$criteria->limit = 20;

            return new ActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'docNumber ASC',
                  )
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
