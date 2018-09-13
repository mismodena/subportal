<?php

/**
 * This is the model class for table "ms_moarole".
 *
 * The followings are the available columns in table 'ms_moarole':
 * @property string $idcard
 * @property integer $appcode
 * @property string $name
 * @property string $initial
 * @property integer $divid
 * @property integer $moastatus
 * @property string $branch
 * @property string $email
 * @property string $parent
 * @property string $inpdate
 * @property string $inppic
 * @property string $upddate
 * @property string $updpic
 * @property string $ipaddress
 */
class Moarole extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ms_moarole';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idcard, appcode', 'required'),
			array('appcode, divid, moastatus', 'numerical', 'integerOnly'=>true),
			array('idcard, parent', 'length', 'max'=>10),
			array('name, inppic, updpic, ipaddress', 'length', 'max'=>50),
			array('initial', 'length', 'max'=>5),
			array('branch, email', 'length', 'max'=>60),
			array('inpdate, upddate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idcard, appcode, name, initial, divid, moastatus, branch, email, parent, inpdate, inppic, upddate, updpic, ipaddress', 'safe', 'on'=>'search'),
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
			'idcard' => 'Id Card',
			'appcode' => 'Module',
			'name' => 'User Name',
			'initial' => 'Initial',
			'divid' => 'Devision',
                        'moastatus' => 'Apv Status',
			'branch' => 'Branch',
			'email' => 'Email',
			'parent' => 'Superior',
			'inpdate' => 'Inpdate',
			'inppic' => 'Inppic',
			'upddate' => 'Upddate',
			'updpic' => 'Updpic',
                        'ipaddress' => 'IP Address',
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

		$criteria->compare('idcard',$this->idcard,true);
		$criteria->compare('appcode',$this->appcode);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('initial',$this->initial,true);
		$criteria->compare('divid',$this->divid);
                $criteria->compare('moastatus',$this->moastatus);
		$criteria->compare('branch',$this->branch,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('parent',$this->parent,true);
		$criteria->compare('inpdate',$this->inpdate,true);
		$criteria->compare('inppic',$this->inppic,true);
		$criteria->compare('upddate',$this->upddate,true);
		$criteria->compare('updpic',$this->updpic,true);
                $criteria->compare('ipaddress',$this->ipaddress,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Moarole the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        protected function beforeSave()
        {
            if(parent::beforeSave())
            {
                foreach ($this->getTableSchema()->columns as $column) {
                if ($column->allowNull == 1 && $this->getAttribute($column->name) == '')
                        $this->setAttribute($column->name, null);
                }
                if($this->isNewRecord)
                {
                        $this->inpdate=new CDbExpression('getdate()');
                        $this->inppic=Yii::app()->user->name;
                        $this->upddate=new CDbExpression('getdate()');
                        $this->updpic=Yii::app()->user->name;
			$this->ipaddress=  Utility::getUserIP();
                }
                else
                        $this->upddate=new CDbExpression('getdate()');
                        $this->updpic=Yii::app()->user->name;
			$this->ipaddress=  Utility::getUserIP();
                return true;
            }
            else
                    return false;
        }
}
