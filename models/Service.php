<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
 * @property integer $uid
 * @property string $email
 * @property integer $traffic
 * @property integer $used
 * @property integer $left
 * @property string $pac
 * @property string $server
 * @property integer $port
 * @property string $rules
 * @property integer $status
 */
class Service extends RedActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'service';
    }

    public function primaryKey()
    {
        return 'uid';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid, email', 'required'),
            array('uid, traffic, used, left, port, status', 'numerical', 'integerOnly' => true),
            array('email, server', 'length', 'max' => 255),
            array('pac, rules', 'safe'),
            array('uid, email, traffic, used, left, pac, server, port, rules, status', 'safe', 'on' => 'search'),
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
            'user' => array(CActiveRecord::BELONGS_TO, 'User', 'uid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'uid' => 'Uid',
            'email' => 'Email',
            'traffic' => 'Traffic',
            'used' => 'Used',
            'left' => 'Left',
            'pac' => 'PAC',
            'server' => 'Server',
            'port' => 'Port',
            'rules' => 'Customer Rules',
            'status' => 'Status',
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

        $criteria->compare('uid', $this->uid);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('traffic', $this->traffic);
        $criteria->compare('used', $this->used);
        $criteria->compare('left', $this->left);
        $criteria->compare('pac', $this->pac, true);
        $criteria->compare('server', $this->server, true);
        $criteria->compare('port', $this->port);
        $criteria->compare('rules', $this->rules, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Service the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
