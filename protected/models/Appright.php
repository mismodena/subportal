<?php

class Appright extends CActiveRecord
{
        public $description;

        public function tableName()
	{
		return 'tr_appright';
	}

	public function rules()
	{
            return array(
                    array('menuid, namacabang, location, processid', 'required'),
                    array('menuid, processid, inactive', 'numerical', 'integerOnly'=>true),
                    array('namacabang, optfield1', 'length', 'max'=>60),
                    array('location', 'length', 'max'=>6),
                    array('category', 'length', 'max'=>10),
                    array('inputpic, updatepic', 'length', 'max'=>24),
                    array('noted', 'length', 'max'=>100),
                    array('inputdate, updatedate', 'safe'),
                    array('menuid, namacabang, location, processid, category, inactive, inputdate, inputpic, updatedate, updatepic, optfield1, noted', 'safe', 'on'=>'search'),
            );
	}

	public function relations()
	{
            return array(
                'location' => array(self::BELONGS_TO, 'MsIcloc', 'location'),
            );
        }

        public function attributeLabels()
	{
		return array(
			'menuid' => 'Menuid',
			'namacabang' => 'Namacabang',
			'location' => 'Location',
			'processid' => 'Processid',
			'category' => 'Category',
			'inactive' => 'Inactive',
			'inputdate' => 'Inputdate',
			'inputpic' => 'Inputpic',
			'updatedate' => 'Updatedate',
			'updatepic' => 'Updatepic',
			'optfield1' => 'Optfield1',
			'noted' => 'Noted',
		);
	}

        public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('menuid',$this->menuid);
		$criteria->compare('namacabang',$this->namacabang,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('processid',$this->processid);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('inactive',$this->inactive);
		$criteria->compare('inputdate',$this->inputdate,true);
		$criteria->compare('inputpic',$this->inputpic,true);
		$criteria->compare('updatedate',$this->updatedate,true);
		$criteria->compare('updatepic',$this->updatepic,true);
		$criteria->compare('optfield1',$this->optfield1,true);
		$criteria->compare('noted',$this->noted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
                
}
