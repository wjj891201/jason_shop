<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\rbac\Rule;
use Yii;

/**
 * Description of AuthorRule
 *
 * @author Administrator
 */
class AuthorRule extends Rule
{

    public $name = "isAuthor";

    public function execute($user, $item, $params)
    {
        $action = Yii::$app->controller->action->id;
        if ($action == 'delete')
        {
            $cateid = Yii::$app->request->get('id');
            $cate = Category::findOne($cateid);
            return $cate->adminid == $user;
        }
        return true;
    }

}
