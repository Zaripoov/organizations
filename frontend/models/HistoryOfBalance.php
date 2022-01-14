<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "history_of_balance".
 *
 * @property int $id
 * @property int $organization_id
 * @property float $sum
 * @property string|null $description
 * @property int $created_at
 *
 * @property Organizations $organization
 */
class HistoryOfBalance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history_of_balance';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'sum'], 'required'],
            [['organization_id'], 'integer'],
            //[['sum'], 'string'],
            [['description'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ],
                'value' => new Expression('CURRENT_TIMESTAMP()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'organization_id' => 'Организация',
            'sum' => 'Сумма',
            'description' => 'Описание',
            'created_at' => 'Дата',
        ];
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organizations::className(), ['id' => 'organization_id']);
    }

    public function updateSumUp($id){
        $this->organization_id = $id;
        $organizations = Organizations::findOne($id);
        $organizations->sum += $this->sum;
        $this->sum = "+".$this->sum;

        if($this->save() && $organizations->update()){
            Yii::$app->session->setFlash('success', 'Операция прошла успешно');
            return true;
        }
    }

    public function updateSumDown($id){
        $this->organization_id = $id;
        $organizations = Organizations::findOne($id);
        if($organizations->sum < $this->sum) {
            Yii::$app->session->setFlash('danger', 'У вас на счету только '.$organizations->sum.' рубль');
            return false;
        }
        $organizations->sum = $organizations->sum - $this->sum;
        $this->sum = "-".$this->sum;
        if($this->save() && $organizations->update()){
            Yii::$app->session->setFlash('success', 'Операция прошла успешно');
            return true;
        }
    }
}
