<?php

namespace app\modules\controllers;

use yii\web\Controller;
use app\modules\controllers\CommonController;

class DefaultController extends CommonController
{

    protected $mustlogin = ['index'];

    public function actionIndex()
    {
        $this->layout = "layout1";
        return $this->render('index');
    }

}
