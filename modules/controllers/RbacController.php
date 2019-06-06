<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\modules\models\Rbac;

/**
 * Description of RbacController
 *
 * @author Administrator
 */
class RbacController extends CommonController
{

    public $mustlogin = ['createrole', 'roles', 'assignitem', 'createrule'];

    public function actionCreaterole()
    {
        if (Yii::$app->request->isPost)
        {
            $auth = Yii::$app->authManager;
            $role = $auth->createRole(null);
            $post = Yii::$app->request->post();
            if (empty($post['name']) || empty($post['description']))
            {
                throw new \Exception('参数错误');
            }
            $role->name = $post['name'];
            $role->description = $post['description'];
            $role->ruleName = empty($post['rule_name']) ? null : $post['rule_name'];
            $role->data = empty($post['data']) ? null : $post['data'];
            if ($auth->add($role))
            {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }
        return $this->render('_createitem');
    }

    public function actionRoles()
    {
        $auth = Yii::$app->authManager;
        $data = new ActiveDataProvider([
            'query' => (new Query)->from($auth->itemTable)->where(['type' => 1])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 5],
        ]);
        return $this->render('_items', ['dataProvider' => $data]);
    }

    public function actionAssignitem($name)
    {
        $name = htmlspecialchars($name);
        $auth = Yii::$app->authManager;
        $parent = $auth->getRole($name);
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if (Rbac::addChild($post['children'], $name))
            {
                Yii::$app->session->setFlash('info', '分配成功');
            }
        }

        $children = Rbac::getChildrenByName($name);

        $roles = Rbac::getOptions($auth->getRoles(), $parent);
        $permissions = Rbac::getOptions($auth->getPermissions(), $parent);
        return $this->render('_assignitem', ['parent' => $name, 'roles' => $roles, 'permissions' => $permissions, 'children' => $children]);
    }

    public function actionCreaterule()
    {
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if (empty($post['class_name']))
            {
                throw new \Exception('参数错误');
            }
            $className = "app\\models\\" . $post['class_name'];
            if (!class_exists($className))
            {
                throw new \Exception('规则类不存在');
            }
            $rule = new $className;
            if (Yii::$app->authManager->add($rule))
            {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }
        return $this->render('_createrule');
    }

}
