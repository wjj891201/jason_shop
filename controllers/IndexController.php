<?php

namespace app\controllers;

use app\controllers\CommonController;
use app\models\Product;
use Yii;

class IndexController extends CommonController
{

    protected $except = ['index'];

    public function actionIndex()
    {
//        Yii::$app->asyncLog->send(['this is indexcontroller']);
        $this->layout = "layout1";
        $data['tui'] = Product::find()->where('istui = "1" and ison = "1"')->orderby('createtime desc')->limit(4)->all();
        $data['new'] = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(4)->all();
        $data['hot'] = Product::find()->where('ison = "1" and ishot = "1"')->orderby('createtime desc')->limit(4)->all();
        $data['all'] = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(7)->all();
        return $this->render("index", ['data' => $data]);
    }

    public function actionError()
    {
        echo "404";
        exit;
    }

}
