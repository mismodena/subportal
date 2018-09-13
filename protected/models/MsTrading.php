<?php

class MsTrading extends CActiveRecord
{    
   
    public $keyWord;      
    public $isTT;
    public function tableName()
    {
        return 'ms_trading';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('tradCode, tradSource, tradPeriod, tradDesc', 'required',),
                array('tradID, tradCode,', 'unique',),
                array('tradValueFrom, tradValueTo,', 'numerical',),
                array('tradPercentage,', 'numerical','max'=>100),
                array('tradID, tradCode, tradDesc, tradSource, tradPeriod, tradValueFrom, tradValueTo, tradPercentage, tradStatus, isTT, keyWord, isPL', 'safe', 'on'=>'search'),
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

    public function getTradingTerm($id){
        $this->attributeLabels();
            
        $criteria=new CDbCriteria;        

        $criteria->alias = 'ms';                            
        $criteria->select=" ms.tradID, ms.tradCode, ms.tradDesc, 
                            case
                                    when dt.isPL IS NULL then ms.isPL
                                    else dt.isPL end as isPL,
                            case 
                                    when dt.tradSource IS NULL then ms.tradSource
                                    else dt.tradSource end as tradSource,
                            case 
                                    when dt.tradPeriod IS NULL then ms.tradPeriod
                                    else dt.tradPeriod end as tradPeriod,
                            case 
                                    when dt.tradValueFrom IS NULL then ms.tradValueFrom
                                    else dt.tradValueFrom end as tradValueFrom,
                            case 
                                    when dt.tradValueTo IS NULL then ms.tradValueTo
                                    else dt.tradValueTo end as tradValueTo,
                            case 
                                    when dt.tradPercentage IS NULL then ms.tradPercentage
                                    else dt.tradPercentage end as tradPercentage " ;
        $criteria->join = " left join ms_tradingTermDetail dt on dt.tradID = ms.tradID and termID = '".$id."' ";
        $criteria->order = " ms.tradcode ASC ";
        //$criteria->limit = 20;

        return $this->findAll($criteria);       
    }
    
    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.tradCode',$this->keyWord,true,'OR');    
            $criteria->compare('h.tradDesc',$this->keyWord,true,'OR');    
            
            $criteria->alias = 'h';                            
            $criteria->select=" tradID, tradCode, tradDesc, tradSource, tradPeriod, tradValueFrom, tradValueTo, tradPercentage, tradStatus " ;
            $criteria->join = " ";

            //$criteria->limit = 20;

            return new ActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'tradCode ASC',
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
