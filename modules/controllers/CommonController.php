<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;

class CommonController extends Controller
{

    public $layout = 'layout1';
    protected $actions = [];
    protected $except = [];
    protected $mustlogin = [];
    protected $verbs = [];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'user' => 'admin',
//                'only' => $this->actions,
                'except' => $this->except,
                'rules' => [
                        [
                        'allow' => false,
                        'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
                        'roles' => ['?']
                    ],
                        [
                        'allow' => true,
                        'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => $this->verbs
            ]
        ];
    }

    public function init()
    {
        /*
          if (Yii::$app->session['admin']['isLogin'] != 1)
          {
          return $this->redirect(['/admin/public/login']);
          }
         */
    }

}
