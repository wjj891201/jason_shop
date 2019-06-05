<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\models;

use yii\db\ActiveRecord;
USE Yii;

class Rbac extends ActiveRecord
{

    public static function getOptions($data, $parent)
    {
        $return = [];
        foreach ($data as $obj)
        {
            if (!empty($parent) && $parent->name != $obj->name && Yii::$app->authManager->canAddChild($parent, $obj))
            {
                $return[$obj->name] = $obj->description;
            }
        }
        return $return;
    }

    public static function addChild($children, $name)
    {
        $auth = Yii::$app->authManager;
        $itemObj = $auth->getRole($name);
        if (empty($itemObj))
        {
            return false;
        }
        $trans = Yii::$app->db->beginTransaction();
        try
        {
            $auth->removeChildren($itemObj);
            foreach ($children as $item)
            {
                $obj = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                $auth->addChild($itemObj, $obj);
            }
            $trans->commit();
        } catch (\Exception $e)
        {
            $trans->rollBack();
            return false;
        }
        return true;
    }

}
