<?php

class MsTradingTermDetail extends CActiveRecord
{    
   
    public $keyWord;      
    
    public function tableName()
    {
        return 'ms_tradingTermDetail';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('tradCode, tradSource, tradPeriod, tradDesc', 'required',),
                //array('tradCode,', 'unique',),
                array('tradValueFrom, tradValueTo,', 'numerical',),
                array('tradPercentage,', 'numerical','max'=>100),
                array('termID, tradID, tradCode, tradDesc, tradSource, tradPeriod, tradValueFrom, tradValueTo, tradPercentage, tradStatus, keyWord,isPL', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                "tradID" => "ID",
                "tradCode" => "Kode Trading",
                "tradDesc" => "Deskripsi",
                "tradSource" => "Sell In/ Out",
                "tradPeriod" => "Periode Klaim",
                "tradValueFrom" => "Penjualan Dari",
                "tradValueTo" => "Sampai Dengan",
                'tradPercentage'=>"Persentase",
            );
    }

    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.termID',$this->keyWord,true);    

            
            $criteria->alias = 'h';                            
            $criteria->select=" termID, tradID, tradCode, tradDesc, tradSource, tradPeriod, tradValueFrom, tradValueTo, tradPercentage, tradStatus " ;
            $criteria->join = " ";

            //$criteria->limit = 20;

            return new ActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'tradCode ASC',
                  )
            ));                    

    }

    public function GetTradDetail($tradNo)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>'  termID, tradID, tradCode, tradDesc, tradSource, tradPeriod, tradValueFrom, tradValueTo, tradPercentage, tradStatus, isPL ',
            'condition'=>"                       
                    a.termID = :cat " ,                                
            'params'=>array(
                ':cat' => $tradNo,                            
            )
        ); 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'tradCode ASC',
            ),
            'pagination'=>array(
                'pageSize'=>30,
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
