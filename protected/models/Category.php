<?php
class Category extends CActiveRecord
{
	public function tableName()
	{
            return 'ms_category';
	}

	public function rules()
	{
            return array(
                array('categoryID, categoryDesc, inputUN, modifUN', 'length', 'max'=>50),
                array('inputTime, modifTime', 'safe'),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
                array('categoryID, categoryDesc, inputUN, inputTime, modifUN, modifTime', 'safe', 'on'=>'search'),
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
                'categoryID' => 'Category',
                'categoryDesc' => 'Category Desc',
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

            $criteria->compare('categoryID',$this->categoryID,true);
            $criteria->compare('categoryDesc',$this->categoryDesc,true);
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
        
        public function suggestCategory($keyword, $limit=20)
	{		
                $criteria=array(
			'condition'=>'
                            categoryDesc LIKE :cat ',
			'order'=>'categoryDesc',
			'limit'=>$limit,
			'params'=>array(
                            ':cat' => "%$keyword%",                            
			)
		);
            
		$models=$this->findAll($criteria);
                //$models=$this->findAll();
		$data=array();
		foreach($models as $model) {
	    	$data[] = array(
	    		'id'=>$model->categoryID,
	        	'text'=>$model->categoryDesc,
	        );
		}
		return $data;
	}
}
