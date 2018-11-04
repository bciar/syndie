<?php

namespace app\models;

use Yii;

/**
 * Class User
 * @package app\models
 * @property Wallet $wallet
 * @property Brand $brand
 * @property string $brombat_id
 * @property string $exaloc_id
 * @property string $type
 * @property string $exaloc_token
 * @property string $exalocTokenDecrypted
 * @property string $dob
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property string city
 * @property string postcode
 * @property boolean $tac
 */
class User extends \dektrium\user\models\User
{

    const TYPE_USER = 'user';
    const TYPE_SPONSOR = 'sponsor';
    const TYPE_AFFILIATE = 'affiliate';

    public function getUserRole()
    {
        return $this->hasOne(UserRole::className(), ['user_id' => 'id']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [

            [['username', 'dob', 'address1', 'city', 'postcode'], 'required', 'on' => 'deposit']

        ]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialAccounts()
    {
        return $this->hasMany(SocialAccount::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicates()
    {
        return $this->hasMany(Syndicate::className(), ['creator_user_id' => 'id']);
    }

    public function getTransactions()
    {
        return $this->hasMany(TransactionHistory::className(), ['user_id' => 'id']);
    }

    public function getSyndicatesImIn()
    {
        return $this->hasMany(Syndicate::className(), ['id' => 'syndicate_id'])->viaTable(Ticket::tableName(), [
            'user_id' => 'id'], function($query){
                          $query->onCondition(['ticket_status_id' => 
                             3]);
                      }
				);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicateMembers()
    {
        return $this->hasMany(SyndicateMember::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Token::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWallet()
    {
        return $this->hasOne(Wallet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['user_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $wallet = new Wallet();
            $wallet->user_id = $this->id;
            $wallet->save(false);
        }

    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

        } else {
            if ($this->wallet) {
                $this->wallet->delete();
            }
        }

    }

    public function attributeLabels()
    {
        return [
            'dob' => 'Date of Birth',
				];
		}
    public function getAvatarPath()
    {
        return Yii::getAlias("@app/images/profile/{$this->id}.jpg");
    }

    public function getAvatar()
    {
        if (file_exists($this->getAvatarPath())) {
            return 'data:image/PNG;base64,' . base64_encode(file_get_contents($this->getAvatarPath()));
        } else {
            return false;
        }
    }

    public function getShareUrl($link)
    {
        $url = Yii::$app->urlManager;
        $image_url = $url->createAbsoluteUrl(['site/ad', 'id' => $this->id]);
        //$url = $url->createAbsoluteUrl($link);
        return "https://www.facebook.com/sharer.php?caption=[caption]&description=[description]&u=$link&picture=$image_url";
    }

    public function getExalocTokenDecrypted()
    {
        return Yii::$app->security->decryptByPassword(utf8_decode($this->exaloc_token), $this->id);
    }
}
