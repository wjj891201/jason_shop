<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use Yii;

class RbacController extends Controller
{

    public function actionInit()
    {
        $trans = Yii::$app->db->beginTransaction();
        try
        {
            $dir = dirname(dirname(__FILE__)) . '/modules/controllers';
            $controllers = glob($dir . '/*');
            $permissions = [];
            foreach ($controllers as $controller)
            {
                $content = file_get_contents($controller);
                preg_match('/class ([a-zA-Z]+)Controller/', $content, $match);
                $cName = $match[1];
                $permissions[] = strtolower($cName . '/*');
                preg_match_all('/public function action([a-zA-Z_]+)/', $content, $matches);
                foreach ($matches[1] as $aName)
                {
                    $permissions[] = strtolower($cName . '/' . $aName);
                }
            }
            $auth = Yii::$app->authManager;
            foreach ($permissions as $permission)
            {
                if (!$auth->getPermission($permission))
                {
                    $obj = $auth->createPermission($permission);
                    $obj->description = $permission;
                    $auth->add($obj);
                }
            }
            $trans->commit();
            echo "import success \n";
        } catch (\Exception $e)
        {
            $trans->rollback();
            echo "import failed \n";
        }
    }

}
