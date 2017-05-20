<?php

/**
 * This is the model class for table "payment".
 *
 * The followings are the available columns in table 'payment':
 * @property integer $id
 * @property integer $uid
 * @property string $email
 * @property string $txn_id
 * @property integer $traffic
 * @property string $datetime
 * @property string $activity
 */
class Payment extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid, email, txn_id, traffic, datetime, activity', 'required'),
            array('uid, traffic', 'numerical', 'integerOnly' => true),
            array('email, txn_id', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uid, email, txn_id, traffic, datetime, activity', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'uid' => 'Uid',
            'email' => 'Email',
            'txn_id' => 'Txn',
            'traffic' => 'Traffic',
            'datetime' => 'Datetime',
            'activity' => 'Activity',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('txn_id', $this->txn_id, true);
        $criteria->compare('traffic', $this->traffic);
        $criteria->compare('datetime', $this->datetime, true);
        $criteria->compare('activity', $this->activity, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Payment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
