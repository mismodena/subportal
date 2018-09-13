<?php

class APDetail extends CActiveRecord
{    
   
    public $keyWord;      
    
    public function tableName()
    {
        return 'tr_apDetail';
    }
    
    public function convert_dots($param1)
    {
            $paramA = (string) $param1;
            $explode_titik = explode(".", $paramA);
            $paramB = $explode_titik[0];
            $jumlah = strlen($paramB);
            $result = "";
            while(true){
                if($jumlah > 3){
                    $jumlah = $jumlah - 3;
                    $result = "," . substr($paramB, $jumlah, 3) . $result;
                } else {
                    $result = substr($paramB, 0, $jumlah) . $result;
                    break;
                }
            }
            $titik = isset($explode_titik[1]) && $explode_titik[1] != "" ? "." . $explode_titik[1] : "";
            return $result . $titik;
    }

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('apInvNo, apInvoiceID,  invStatus', 'required',),
                array('apInvNo,', 'unique',),
                array('apInvNo, apInvoiceID, apInvDate, apDueDate,rejected, apInvTotal, poNo, apInvDetDesc, invStatus, '
                    . ' keyword,', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
              
            );
    }

    
    
    public function GetInvDetail($recNo)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>'  apInvoiceID, apInvNo, apInvDate, apDueDate, apInvTotal, poNo, apInvDetDesc,rejected',            
            'condition'=>"                       
                    a.apInvoiceID = :cat " ,                                
            'params'=>array(
                ':cat' => $recNo,                            
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

    public function getInvNo($invID)
    {                       
        $criteria=array(
                'select'=>' apInvNo ',
                'condition'=>" apInvoiceID = :apInvoiceID " ,                
                'params'=>array(
                    ':apInvoiceID' => "$invID",                            
                )
        ); 

        $models=$this->findAll($criteria);
        //$models=$this->findAll();
        $retur='';
        $totalRow = count($models);
        foreach($models as $i => $model) {
            if($i==0){
                $retur = $model->apInvNo;
            } 
            else
            {
                $retur = $retur . ', '. $model->apInvNo;
            }
        }
        return $retur;
    }
}
