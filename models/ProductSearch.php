<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\elasticsearch\ActiveRecord;

/**
 * Description of ProductSearch
 *
 * @author xm_pc
 */
class ProductSearch extends ActiveRecord
{

    //put your code here

    public function arrayAttributes()
    {
        return ['productid', 'title', 'descr'];
    }

    public static function index()
    {
        return 'imooc_shop';
    }

    public static function type()
    {
        return 'products';
    }

}
