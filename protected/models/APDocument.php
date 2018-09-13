<?php

class APDocument extends CActiveRecord
{    
   
    public $keyWord;      
    public $docName;
    

    public function tableName()
    {
        return 'tr_apDoc';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('recNo, docID, docValue, catID', 'required',),
                array('invID, docID, docValue, docName, invDocOrder, descDoc', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                    'docID' => 'Dokumen',
                    'docValue' => 'Check',
                    'descDoc' => 'Ket.',
            );
    }

    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.apInvNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.poNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.bapbNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.reffNo',$this->keyWord,true,'OR');        
            $criteria->compare('h.apSupplier',$this->keyWord,true,'OR');        
            
            $criteria->alias = 'h';                            
            $criteria->select=" 
                     h.apInvID, apSupplier, apDesc, apInvNo, apInvDate, apDueDate, poNo, bapbNo, reffNo, ppNo, status, apInvTotal, recNo                    
                        " ;
            $criteria->join = "	
                    
                    ";

            $criteria->limit = 20;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'apInvDate DESC',
                  )
            ));                    

    }
    
    public function GetInvDetail($recNo)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>'  a.apDocID, a.recNo, a.docID, a.docValue, d.invDocName docName, invDocOrder, a.descDoc',
            'join'=>'left join ms_docCategory d on a.docID = d.invDocID',
            'condition'=>"                       
                    a.recNo = :cat " ,                                
            'params'=>array(
                ':cat' => $recNo,                            
            )
        ); 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,                       
            'pagination'=>array(
                'pageSize'=>20,                
            ),
            'sort'=>array(
                'defaultOrder'=>'invDocOrder ASC',
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
