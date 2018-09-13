<?php

class FppDetail extends CActiveRecord
{
    
    public $formatedAmount;
    public $TOTAL;
    public function tableName()
    {
            return 'tr_fppDetail';
    }

    public function rules()
    {
        return array(
            array('fppID', 'required'),
            array('fppDetailValue', 'numerical'),
            array('fppID, fppDetailID, inputUN, modifUN, fppInvNo', 'length', 'max'=>50),
            array('fppDesc', 'length', 'max'=>200),
            array('inputTime, modifTime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('fppID, fppDetailID, fppDesc, fppDetailValue, inputUN, inputTime, modifUN, modifTime, formatedAmount, TOTAL, fppInvNo', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array(
            'fppID' => 'Fpp',
            'fppDetailID' => 'Fpp Detail',
            'fppDesc' => 'Fpp Desc',
            'fppDetailValue' => 'Fpp Detail Value',
            'inputUN' => 'Input Un',
            'inputTime' => 'Input Time',
            'modifUN' => 'Modif Un',
            'modifTime' => 'Modif Time',
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('fppID',$this->fppID,true);
        $criteria->compare('fppDetailID',$this->fppDetailID,true);
        $criteria->compare('fppDesc',$this->fppDesc,true);
        $criteria->compare('fppDetailValue',$this->fppDetailValue);
        $criteria->compare('inputUN',$this->inputUN,true);
        $criteria->compare('inputTime',$this->inputTime,true);
        $criteria->compare('modifUN',$this->modifUN,true);
        $criteria->compare('modifTime',$this->modifTime,true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
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
    
            
    public function GetFppDetail($fppNo)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>'  a.fppDetailID, a.fppID, a.fppDesc, a.fppDetailValue, a.fppInvNo ',
            'condition'=>"                       
                    a.fppID = :cat " ,                                
            'params'=>array(
                ':cat' => $fppNo,                            
            )
        ); 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'fppDesc ASC',
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
    }
    
    public function GetDetailTotal($fppNo)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>' abs(sum(fppDetailValue)) formatedAmount ',
            'condition'=>"                       
                    a.fppID = :cat " ,                                
            'params'=>array(
                ':cat' => $fppNo,                            
            )
        ); 

        return  $this->find($criteria)->formatedAmount;
    }
}
