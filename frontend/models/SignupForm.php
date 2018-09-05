<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password2;
    public $phone;

//    public $captcha;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('frontend_signup','Это Имя уже занято')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('frontend_signup','Такой email адрес уже существует!')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password', 'validatePassword'],

            ['password2', 'required'],
            ['password2', 'string', 'min' => 6],

            ['phone', 'string'],
            // verifyCode needs to be entered correctly
//            ['captcha', 'captcha'],

        ];
    }
    public function validatePassword($attr, $params, $valid)
    {
       if($this->password !== $this->password2){
           $this->addError($attr,Yii::t('frontend_signup','Пароли не совпадают'));
       }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        //@todo если есть значение null которое нужно записать в бд можно ли использовать валидацию выше?
        $user = new User();

        if($this->password !== $this->password2){
            return null;
        }

        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        /**
         * @todo вывод о том что пароли не совпадают
         */
        
        if($user->save()) {
            $this->sendEmail($user);
            return $user;
        }

    }

    /**
     * @param User $user
     * @return bool
     */
    protected function sendEmail(User $user) {
        if (!$user) {
            return false;
        }
        $this->sendForUser($user);
        $this->sendForAdmin($user);
    }


    /**
     * @param $user
     * @return bool
     */
    protected function sendForUser($user) {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'signupUser-html', 'text' => 'signupUser-text'],
                ['user' => $user]
            )
            ->setFrom([ Yii::$app->confs->get('supportEmail') => Yii::$app->name . ' ('.Yii::t('frontend_signup','автоматически').')'])
            ->setTo($this->email)
            ->setSubject(Yii::t('frontend_signup','Вы зарегистрировались в') .' '. Yii::$app->name)
            ->send();
    }


    /**
     * @param $user
     * @return bool
     */
    protected function sendForAdmin($user) {
        $email = Yii::$app->confs->get('supportEmail');
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'signupUserForAdmin-html', 'text' => 'signupUserForAdmin-text'],
                ['user' => $user]
            )
            ->setFrom([ $email => Yii::$app->name . ' ('.Yii::t('frontend_signup','автоматически').')'])
            ->setTo($email)
            ->setSubject(Yii::t('frontend_signup','Зарегистрирован пользователь:') . ' ' . Yii::$app->name)
            ->send();
    }

    public function attributeLabels()
    {
        return [
            'username'=>Yii::t('frontend_signup','Ваше полное имя'),
            'password'=>Yii::t('frontend_signup','Введите пароль'),
            'password2'=>Yii::t('frontend_signup','Повторите пароль'),
            'phone'=>Yii::t('frontend_signup','Телефон'),
        ];
    }
}
