<?php

namespace app\modules\controllers;

use yii\web\Controller;
use app\modules\models\Admin;
use Yii;

class PublicController extends Controller
{

    public function actionLogin()
    {
        $this->layout = false;
        $model = new Admin;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->login($post))
            {
                $this->redirect(['default/index']);
                Yii::$app->end(); //结束
            }
        }
        return $this->render("login", ['model' => $model]);
    }

    public function actionLogout()
    {
        /* Yii::$app->session->removeAll();
          if (!isset(Yii::$app->session['admin']['isLogin']))
          {
          $this->redirect(['public/login']);
          Yii::$app->end();
          } */
        Yii::$app->admin->logout(false);
        return $this->goback(); //从哪个页面过的再跳回哪个页面
    }

    public function actionSeekpassword()
    {
        $this->layout = false;
        $model = new Admin;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->seekPass($post))
            {
                Yii::$app->session->setFlash('info', '电子邮件已经发送成功，请查收');
            }
        }
        return $this->render("seekpassword", ['model' => $model]);
    }

}
