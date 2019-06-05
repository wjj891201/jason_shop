<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use app\modules\models\Admin;
use yii\data\Pagination;
use app\modules\controllers\CommonController;
use app\modules\models\Rbac;

class ManageController extends CommonController
{

    protected $mustlogin = ['mailchangepass', 'managers', 'reg', 'del', 'changeemail', 'changepass', 'assign'];

    public function actionMailchangepass()
    {
        $this->layout = false;
        $time = Yii::$app->request->get("timestamp");
        $adminuser = Yii::$app->request->get("adminuser");
        $token = Yii::$app->request->get("token");
        $model = new Admin;
        $myToken = $model->createToken($adminuser, $time);
        if ($token != $myToken)
        {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        //5分钟失效
        if (time() - $time > 300)
        {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->changePass($post))
            {
                Yii::$app->session->setFlash('info', '密码修改成功');
            }
        }
        $model->adminuser = $adminuser;
        return $this->render("mailchangepass", ['model' => $model]);
    }

    public function actionManagers()
    {
        $this->layout = "layout1";
        $model = Admin::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['manage'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("managers", ['managers' => $managers, 'pager' => $pager]);
    }

    public function actionReg()
    {
        $this->layout = 'layout1';
        $model = new Admin;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->reg($post))
            {
                Yii::$app->session->setFlash('info', '添加成功');
            }
            else
            {
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }
        $model->adminpass = '';
        $model->repass = '';
        return $this->render('reg', ['model' => $model]);
    }

    public function actionDel()
    {
        $adminid = (int) Yii::$app->request->get("adminid");
        if (empty($adminid) || $adminid == 1)
        {
            $this->redirect(['manage/managers']);
            return false;
        }
        $model = new Admin;
        if ($model->deleteAll('adminid = :id', [':id' => $adminid]))
        {
            Yii::$app->session->setFlash('info', '删除成功');
            $this->redirect(['manage/managers']);
        }
    }

    public function actionChangeemail()
    {
        $this->layout = 'layout1';
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->changeemail($post))
            {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $model->adminpass = "";
        return $this->render('changeemail', ['model' => $model]);
    }

    public function actionChangepass()
    {
        $this->layout = "layout1";
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->changepass($post))
            {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $model->adminpass = '';
        $model->repass = '';
        return $this->render('changepass', ['model' => $model]);
    }

    public function actionAssign($adminid)
    {
        $adminid = (int) $adminid;
        if (empty($adminid))
        {
            throw new \Exception('参数错误');
        }
        $admin = Admin::findOne($adminid);
        if (empty($admin))
        {
            throw new \yii\web\NotAcceptableHttpException('admin not found');
        }
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            $children = !empty($post['children']) ? $post['children'] : [];
            if (Rbac::grant($adminid, $children))
            {
                Yii::$app->session->setFlash('info', '授权成功');
            }
        }
        $auth = Yii::$app->authManager;
        $roles = Rbac::getOptions($auth->getRoles(), null);
        $permissions = Rbac::getOptions($auth->getPermissions(), null);

        $children = Rbac::getChildrenByUser($adminid);
        return $this->render('_assign', ['roles' => $roles, 'permissions' => $permissions, 'admin' => $admin->adminuser, 'children' => $children]);
    }

}
