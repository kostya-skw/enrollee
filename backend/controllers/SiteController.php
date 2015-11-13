<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use common\models\Profile;
use common\models\ProfileForm;
use common\models\Person;
use backend\models\LoginFormBackend;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'profiles',
                            'profile-view',
                            'profile-edit',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginFormBackend();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionProfiles()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Profile::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render(
            'profiles',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProfileView($id)
    {
        $model = Profile::findById($id);
        return $this->render(
            'profileView',[
                'model' => $model,
            ]);
    }

    public function actionProfileEdit($id)
    {
        $model = new ProfileForm();
        $model->loadModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Успешно сохранено!');
                return  Yii::$app->getResponse()->redirect(Url::to(['site/profile-view', 'id'=>$model['id']]));
            } else {
                Yii::$app->session->setFlash('warning', 'Упс, что-то пошло не так. Проверте введенные данные, вдруг в них закралась ошибка!');
            }
        }


        $specitems = Profile::getSpecsAllWithChoice($model->edu_base);

        return $this->render(
            'profileEdit',[
                'model' => $model,
                'specitems' => $specitems,
            ]);
    }

}
