<?php

/**
 * This is the model class for table "tr_moa".
 *
 * The followings are the available columns in table 'tr_moa':
 * @property string $moaseq
 * @property string $audtdate
 * @property integer $appcode
 * @property string $docnum
 * @property integer $moanum
 * @property string $moastatus
 * @property string $chkidcard
 * @property string $chkmail
 * @property string $chkcomment
 * @property string $chkedidcard
 * @property string $chkeddate
 * @property string $chkedipadr
 */
class Moa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tr_moa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('appcode', 'required'),
			array('appcode, moanum', 'numerical', 'integerOnly'=>true),
			array('audtdate', 'length', 'max'=>9),
			array('docnum, chkedipadr', 'length', 'max'=>60),
			array('moastatus', 'length', 'max'=>5),
			array('chkidcard, chkedidcard', 'length', 'max'=>40),
			array('chkmail', 'length', 'max'=>80),
			array('chkcomment', 'length', 'max'=>250),
			array('chkeddate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('moaseq, audtdate, appcode, docnum, moanum, moastatus, chkidcard, chkmail, chkcomment, chkedidcard, chkeddate, chkedipadr', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'moaseq' => 'Moaseq',
			'audtdate' => 'Audtdate',
			'appcode' => 'Appcode',
			'docnum' => 'Docnum',
			'moanum' => 'Moanum',
			'moastatus' => 'Moastatus',
			'chkidcard' => 'Chkidcard',
			'chkmail' => 'Chkmail',
			'chkcomment' => 'Chkcomment',
			'chkedidcard' => 'Chkedidcard',
			'chkeddate' => 'Chkeddate',
			'chkedipadr' => 'Chkedipadr',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('moaseq',$this->moaseq,true);
		$criteria->compare('audtdate',$this->audtdate,true);
		$criteria->compare('appcode',$this->appcode);
		$criteria->compare('docnum',$this->docnum,true);
		$criteria->compare('moanum',$this->moanum);
		$criteria->compare('moastatus',$this->moastatus,true);
		$criteria->compare('chkidcard',$this->chkidcard,true);
		$criteria->compare('chkmail',$this->chkmail,true);
		$criteria->compare('chkcomment',$this->chkcomment,true);
		$criteria->compare('chkedidcard',$this->chkedidcard,true);
		$criteria->compare('chkeddate',$this->chkeddate,true);
		$criteria->compare('chkedipadr',$this->chkedipadr,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Moa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
