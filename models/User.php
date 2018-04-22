<?php

namespace app\models;

use Yii;
use Yii\db\Expression;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $uid
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $status
 * @property int $contact_email
 * @property int $contact_phone
 * @property string $created
 * @property string $updated
 *
 * @property Message[] $fromMessages
 * @property Message[] $toMessages
 * @property PhoneNumber[] $phoneNumbers
 * @property Trip[] $trips
 */
class User extends \yii\db\ActiveRecord
{

    const STATUS_INSERTED =  0;
    const STATUS_ACTIVE =  1;
    const STATUS_BLOCKED =  2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'username', 'email', 'password'], 'required'],
            [['status'], 'integer'],
            [['email'],'email'],
            [['created', 'updated'], 'safe'],
            [['uid', 'password'], 'string', 'max' => 60],
            [['username'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 255],
            [['contact_email', 'contact_phone'], 'string', 'max' => 1],
            [['uid'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord){
            $this->setUid();
        }
     
       return  parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord){
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        }
        $this->updated = new Expression('NOW()');
        return  parent::beforeSave($insert);
    }

    private function setUid()
    {   
        $this->uid = Yii::$app->getSecurity()->generatePasswordHash(date('YmdHis').rand(1,999999));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'status' => 'Status',
            'contact_email' => 'Contact Email',
            'contact_phone' => 'Contact Phone',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormMessages()
    {
        return $this->hasMany(Message::className(), ['from_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToMessages()
    {
        return $this->hasMany(Message::className(), ['to_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhoneNumbers()
    {
        return $this->hasMany(PhoneNumber::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trip::className(), ['user_id' => 'id']);
    }
}
