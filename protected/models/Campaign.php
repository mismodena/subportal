<?php

class Campaign extends AccpacActiveRecord
{
    
    public $keyWord;
    
    public function tableName()
    {
        return 'MIS_CampaignInfo';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
        return array(
            array('campaignNo', 'unique'),  
            array('campaignNo, CNStartDate, excelFiles, campaignCategory', 'required'),                        
            
            array('campaignName, campaignCategory', 'length', 'max'=>100),  
            array('campaignDesc', 'length', 'max'=>500),            
            array('campaignFrom, campaignTo, inputTime, modifTime, campaignApproval, CNStartDate', 'safe'),
            array('excelFiles', 'file', 'types'=>'xls', 'on'=>'create'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('campaignNo, campaignFrom, campaignTo, campaignDesc, campaignName, keyWord, excelFiles, campaignApproval,CNStartDate, campaignCategory, pkpBranch', 'safe', 'on'=>'search'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'campaignNo' => 'Nomor',
            'campaignName' => 'Nama Promo',
            'campaignFrom' => 'Periode',
            'campaignTo' => 'Tanggal Akhir',
            'campaignDesc' => 'Keterangan',            
            'CNStartDate' => 'Tanggal Berlaku', 
            'campaignCategory' => 'Kategori', 
            
        );
    }
    
    public function search()
	{
            $this->attributeLabels();
             
            $criteria=new CDbCriteria;
            
            $criteria->compare('campaignNo',$this->keyWord,true, 'OR');
            $criteria->compare('campaignName',$this->keyWord,true, 'OR');
            $criteria->compare('campaignDesc',$this->keyWord,true, 'OR');            
            

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                           // 'defaultOrder'=>'orderDate DESC',
                        )
            ));
	}
        
        public function searchApproval()
	{
            $this->attributeLabels();
            $idcard = Yii::app()->user->getState('idcard');
            $user = Yii::app()->user->name;
            
            $criteria=new CDbCriteria;
            
            $criteria->compare('campaignNo',$this->keyWord,true, 'OR');
            $criteria->compare('campaignName',$this->keyWord,true, 'OR');
            $criteria->compare('campaignDesc',$this->keyWord,true, 'OR');            
            $criteria->addCondition("b.pic = '".$idcard."'"); 
            $criteria->addCondition('b.persetujuan is null');
            
            $criteria->alias = 'a';                            
            $criteria->select=' * ';
            $criteria->join = ' left join MIS_CampaignApproval b on a.campaignNo = b.campaignID ';
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                           // 'defaultOrder'=>'orderDate DESC',
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
