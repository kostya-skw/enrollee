<?php
namespace frontend\controllers;

use common\models\Spec;
use Yii;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\Profile;
use common\models\ProfileForm;
use frontend\models\UserFrontend;
use frontend\models\Agreement;
use kartik\mpdf\Pdf;


/**
 * Site controller
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['profile', 'return-to-edit', 'profile-to-pdf', 'spec-list', 'spec-items'],
                'rules' => [
                    [
                        'actions' => [
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
     * Profile.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionMy()
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
                $model->contact_email = $user->email;
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

                        return  Yii::$app->getResponse()->redirect(Url::to(['profile/my']));

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
            return  Yii::$app->getResponse()->redirect(Url::to(['profile/my']));

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
