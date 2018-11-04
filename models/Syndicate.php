<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "syndicate".
 *
 * @property integer $id
 * @property integer $draw_id
 * @property integer $creator_user_id
 * @property integer $num_lines
 * @property integer $num_shares
 * @property string $cost_per_share
 * @property integer $syndie_style
 * @property integer $syndie_lines_per_person
 * @property integer $number_of_draws
 * @property integer $min_players
 * @property integer $max_players
 * @property integer $players
 * @property integer $syndicate_status_id
 * @property integer $privacy_level_id
 * @property string $privacy_code
 * @property string $name
 * @property string $message
 *
 * @property Line[] $lines
 * @property Draw $draw
 * @property Game $game
 * @property SyndicateStatus $syndicateStatus
 * @property User $creatorUser
 * @property Ticket $transactionItem
 * @property SyndicateMember[] $syndicateMembers
 */
class Syndicate extends \yii\db\ActiveRecord
{

    const PRIVACY_PRIVATE = 1;
    const PRIVACY_PUBLIC = 2;
    const PRIVACY_FRIENDS = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'syndicate';
    }

    public function getCostOfLines()
    {
        $sum = 0;
        foreach ($this->lines as $l) {
            $sum += $l->game->price_per_line;
        }
        return $sum;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['draw_id', 'creator_user_id', 'num_lines', 'num_shares', 'syndie_style', 'syndie_lines_per_person', 'number_of_draws', 'min_players', 'max_players', 'syndicate_status_id'], 'integer'],
            [['cost_per_share'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['message'], 'string', 'max' => 255],
            [['privacy_level_id'], 'integer'],
            [['draw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Draw::className(), 'targetAttribute' => ['draw_id' => 'id']],
            [['syndicate_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => SyndicateStatus::className(), 'targetAttribute' => ['syndicate_status_id' => 'id']],
            [['creator_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'draw_id' => 'Draw',
            'privacy_level_id' => 'Privacy Level',
            'creator_user_id' => 'Creator User ID',
            'num_lines' => 'Num Lines',
            'num_shares' => 'Num Shares',
            'cost_per_share' => 'Cost Per Share',
            'syndie_style' => 'Syndie Style',
            'syndie_lines_per_person' => 'Lines Per Person',
            'number_of_draws' => 'Number Of Draws',
            'min_players' => 'Min Players',
            'max_players' => 'Max Players',
            'syndicate_status_id' => 'Syndicate Status ID',
            'name' => 'Name',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLines()
    {
        return $this->hasMany(Line::className(), ['syndicate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDraw()
    {
        return $this->hasOne(Draw::className(), ['id' => 'draw_id']);
    }

    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }

    public function getPrivacyLevel()
    {
        return $this->hasOne(PrivacyLevel::className(), ['id' => 'privacy_level_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicateStatus()
    {
        return $this->hasOne(SyndicateStatus::className(), ['id' => 'syndicate_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatorUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['syndicate_id' => 'id']);
    }

    public function getHasCurrentUser()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        $sql = "SELECT count(*) as c FROM ticket WHERE syndicate_id = $this->id AND ticket_status_id = 3 AND user_id = " . Yii::$app->user->id;
        $c = Yii::$app->dbhelper->getOne($sql, 'c');
        if ($c > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSyndicateMembers()
    {
        return $this->hasMany(SyndicateMember::className(), ['syndicate_id' => 'id']);
    }

    public function getAvailablePrivacies()
    {
        if (in_array(Yii::$app->user->identity->type, [User::TYPE_AFFILIATE, User::TYPE_SPONSOR])) {
            return [
                self::PRIVACY_PUBLIC => 'Public'
            ];
        } else {
            return [
                self::PRIVACY_PUBLIC => 'Public',
                self::PRIVACY_FRIENDS => 'Friends',
                self::PRIVACY_PRIVATE => 'Private'
            ];
        }

    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->privacy_level_id == self::PRIVACY_PRIVATE) {
                $this->privacy_code = substr(md5(time() . $this->id), 0, 6);
            } else {
                $this->privacy_code = '';
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return ActiveQuery
     */
    public static function findJoinable()
    {
        return self::find()
            ->where([
                'or',
                ['max_players' => 0],
                ['max_players' => null],
                'max_players > players'
            ])
            ->andWhere(['!=', 'name', '']);
    }

    public function getIsFull()
    {
        if (!$this->max_players) return false;

        return $this->players >= $this->max_players;
    }

    public function can($type)
    {
        if ($type == 'share') {
            return $this->hasCurrentUser && !$this->isFull;
        } else if ($type == 'join') {
					if ($this->creator_user_id == Yii::$app->user->id) {
						return false;
					} else {
            return !$this->isFull;
					}
        } else {
            throw new NotSupportedException();
        }
    }

    /**
     * @return ActiveQuery
     */
    public static function findSponsors()
    {
        return self::findJoinable()->joinWith(['creatorUser'])->andWhere(['user.type' => User::TYPE_SPONSOR]);
    }

    /**
     * @return ActiveQuery
     */
    public static function findAffiliates()
    {
        return self::findJoinable()->joinWith(['creatorUser'])->andWhere(['user.type' => User::TYPE_AFFILIATE]);
    }

    /**
     * @return ActiveQuery
     */
    public static function findUsers()
    {
        return self::findJoinable()->joinWith(['creatorUser'])->andWhere(['user.type' => User::TYPE_USER]);
    }

    public function calculatePlayers()
    {
        return $this->players = $this->getTickets()->andWhere(['ticket_status_id' => Ticket::STATUS_IN_PLAY])->count();
    }
}
