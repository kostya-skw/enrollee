<?php
namespace frontend\controllers;

use common\models\Spec;
use Yii;
use yii\base\InvalidParamException;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\Profile;
use common\models\ProfileForm;
//use common\models\Person;
use frontend\models\LoginFormFrontend;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\UserFrontend;
use frontend\models\Agreement;
use frontend\models\UserSettingsForm;
use kartik\mpdf\Pdf;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'user-settings', 'profile', 'return-to-edit', 'profile-to-pdf', 'spec-list', 'spec-items'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'logout',
                            'user-settings',
                            'profile',
                            'return-to-edit',
                            'profile-to-pdf',
                            'spec-list',
                            'spec-items',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'return-to-edit' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginFormFrontend();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionConfidential()
    {
        return $this->render('confidential');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests confirm email.
     *
     * @return mixed
     */
    public function actionNewEmailConfirm($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('New email token cannot be blank.');
        }

        $user = UserFrontend::findByNewEmailToken($token);

        if(!empty($user)){
            $user->status=UserFrontend::STATUS_ACTIVE;
            $user->save();
            Yii::$app->getSession()->setFlash('success','Успешно! Email адрес подтвержден.');
        }
        else{
            Yii::$app->getSession()->setFlash('warning','Wrong password reset token.!');
            //throw new InvalidParamException('Wrong password reset token.');
        }

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    /**
     * User settings.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionUserSettings()
    {
        $model = new UserSettingsForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->update()) {
                Yii::$app->session->setFlash('success', 'New settings was saved.');
            }
        }

        return $this->render('usersettings', [
            'model' => $model,
        ]);
    }

    /**
     * Abitur application.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionProfile()
    {
        $id = Yii::$app->getUser()->getId();
        $user = UserFrontend::findIdentity($id);

        if ($user->consent_processing_personal_data!=1) {

            $model = new Agreement();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->AcceptConsentProcessingPersonalData()) {
                    Yii::$app->session->setFlash('success', 'Согласие на обработку персональных данных принято!');
                    return  Yii::$app->getResponse()->redirect(Url::to(['site/profile']));
                } else {
                    Yii::$app->session->setFlash('warning', 'Упс, что-то пошло не так. Ты можешь проверить введенные данные, вдруг в них закралась ошибка!');
                }
            }

            return $this->render('agreement', [
                'model' => $model,
            ]);
        }
        else {

            $profile = new Profile();
            $profile->loadModel($user->id_profile);

            if (in_array($profile->status, [Profile::STATUS_NEW])) {

                $model = new ProfileForm();
                $model->loadModel($profile->id);

                if ($model->load(Yii::$app->request->post())) {

                    Yii::$app->request->post('submit') == 'save&done' ?
                        $model->status = Profile::STATUS_REVIEW
                        : $model->status = Profile::STATUS_NEW;

                    if ($model->save()) {

                        $model->status == Profile::STATUS_REVIEW ?
                            Yii::$app->session->setFlash('success', 'Сохранено успешно и готово к рассмотрению в приемной комиссии. Не забудьте взять оригиналы документов.')
                            : Yii::$app->session->setFlash('success', 'Сохранено успешно');

                        $id = Yii::$app->getUser()->getId();
                        $user = UserFrontend::findIdentity($id);
                        if ($user->id_profile != $model->id) {
                            $user->id_profile = $model->id;
                            $user->save();
                        }

                        return  Yii::$app->getResponse()->redirect(Url::to(['site/profile']));

                    } else {
                        Yii::$app->session->setFlash('warning', 'Упс, что-то пошло не так. Ты можешь проверить введенные данные, вдруг в них закралась ошибка!');
                    }
                }


                $specitems = Profile::getSpecsAllWithChoice($model->edu_base);

                return $this->render('profile', [
                    'model' => $model,
                    'specitems' => $specitems,
                ]);

            } else {

                return $this->render('profileView', [
                    'model' => $profile,
                ]);

            }
        }
    }

    /**
     * Abitur application return to edit.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionReturnToEdit()
    {

        $id = Yii::$app->getUser()->getId();
        $user = UserFrontend::findIdentity($id);
        $profile = Profile::findById($user->id_profile);

        if (in_array($profile->status, [Profile::STATUS_REVIEW])) {

            $profile->updateAttributes(['status' => Profile::STATUS_NEW]);
            return  Yii::$app->getResponse()->redirect(Url::to(['site/profile']));

        } else {
            Yii::$app->session->setFlash('warning', 'С текущим статусом заявления его вернуть не получится.');
        }

    }

    /**
     * Abitur application export to pdf.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionProfileToPdf()
    {

        $id = Yii::$app->getUser()->getId();
        $user = UserFrontend::findIdentity($id);
        $profile = Profile::findById($user->id_profile);

        // get your HTML raw content without any layouts or scripts
//        $content = $this->renderPartial('abiturApplicationToPdf', ['model'=>$profile]);
        $content = $this->renderPartial('profileToPdf', ['model'=>$profile]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'mode' => Pdf::MODE_UTF8,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Заявление'],
            // call mPDF methods on the fly
            'methods' => [
//                'SetHeader'=>['Регистрационный номер ______________________________ '],
//                'SetFooter'=>['Заявление абитуриента - страница {PAGENO}'],
            ],
            // margin
            'marginLeft' => 30,
            'marginRight' => 15,
            'marginTop' => 12,
            'marginBottom' => 12,
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();

    }


    /**
     * Spec items.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionSpecItems($base = null) {

        $specitems = Profile::getSpecsAllWithChoice($base);

        return $this->renderAjax('_specitems', ['specitems' => $specitems]);

    }

    /**
     * Spec list.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionSpecList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query();
            $query->select('id, CONCAT_WS(" ", `code`, `name`) AS text')
                ->from('spec')
                ->where(['like', 'name', $q])
                ->OrWhere(['like', 'code', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Spec::find($id)->name];
        }
        return $out;
    }

}
