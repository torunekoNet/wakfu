<?php

/**
 * This is the model class for table "setting".
 *
 * The followings are the available columns in table 'setting':
 * @property string $section
 * @property string $name
 * @property string $value
 */
class Setting extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'setting';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('section, name, value', 'required'),
            array('section, name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('section, name, value', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'section' => 'Section',
            'name' => 'Name',
            'value' => 'Value',
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

        $criteria = new CDbCriteria;

        $criteria->compare('section', $this->section, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('value', $this->value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Setting the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function get($section, $name)
    {
        $setting = Setting::model()->findByAttributes(array(
            'section' => $section,
            'name' => $name
        ));
        if (empty($setting)) return null;

        return CJSON::decode($setting->value);
    }

    public function set($section, $name, $value)
    {
        $setting = Setting::model()->findByAttributes(array(
            'section' => $section,
            'name' => $name
        ));
        if (empty($setting)) return false;

        if (is_array($value)) {
            $value = array_values($value);
            $value = CJSON::encode($value);
        }
        $setting->value = $value;
        return $setting->save();
    }
}