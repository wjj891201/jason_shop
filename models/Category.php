<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;

class Category extends ActiveRecord
{

    public function behaviors()
    {
        return [
                [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'adminid',
                'updatedByAttribute' => null,
                'value' => Yii::$app->admin->id
            ],
        ];
    }

    public static function tableName()
    {
        return "{{%category}}";
    }

    public function attributeLabels()
    {
        return [
            'parentid' => '上级分类',
            'title' => '分类名称'
        ];
    }

    public function rules()
    {
        return [
                ['parentid', 'required', 'message' => '上级分类不能为空', 'except' => 'rename'],
                ['title', 'required', 'message' => '标题名称不能为空'],
                ['createtime', 'safe']
        ];
    }

    public function add($data)
    {
        $data['Category']['createtime'] = time();
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public function getData()
    {
        $cates = self::find()->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    public function getTree($cates, $pid = 0)
    {
        $tree = [];
        foreach ($cates as $cate)
        {
            if ($cate['parentid'] == $pid)
            {
                $tree[] = $cate;
                $tree = array_merge($tree, $this->getTree($cates, $cate['cateid']));
            }
        }
        return $tree;
    }

    public function setPrefix($data, $p = "|-----")
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while ($val = current($data))
        {
            $key = key($data);
            if ($key > 0)
            {
                if ($data[$key - 1]['parentid'] != $val['parentid'])
                {
                    $num ++;
                }
            }
            if (array_key_exists($val['parentid'], $prefix))
            {
                $num = $prefix[$val['parentid']];
            }
            $val['title'] = str_repeat($p, $num) . $val['title'];
            $prefix[$val['parentid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = ['添加顶级分类'];
        foreach ($tree as $cate)
        {
            $options[$cate['cateid']] = $cate['title'];
        }
        return $options;
    }

    public function getTreeList()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->setPrefix($tree);
    }

    public static function getMenu()
    {
        $top = self::find()->where('parentid = :pid', [":pid" => 0])->limit(11)->orderby('createtime asc')->asArray()->all();
        $data = [];
        foreach ((array) $top as $k => $cate)
        {
            $cate['children'] = self::find()->where("parentid = :pid", [":pid" => $cate['cateid']])->limit(10)->asArray()->all();
            $data[$k] = $cate;
        }
        return $data;
    }

    /**
     * getChild 递归查询所有子类数据
     *
     */
    public function getChild($pid)
    {
        $data = self::find()->where('parentid = :pid', [":pid" => $pid])->all();
        if (empty($data))
        {
            return [];
        }
        $children = [];
        foreach ($data as $child)
        {
            $children[] = [
                "id" => $child->cateid,
                "text" => $child->title,
                "children" => $this->getChild($child->cateid)
            ];
        }
        return $children;
    }

    /**
     * 查询所有的顶级分类
     *
     */
    public function getPrimaryCate()
    {
        $data = self::find()->where("parentid = :pid", [":pid" => 0]);
        if (empty($data))
        {
            return [];
        }
        $pages = new \yii\data\Pagination(['totalCount' => $data->count(), 'pageSize' => '10']);
        $data = $data->orderBy('createtime desc')->offset($pages->offset)->limit($pages->limit)->all();
        if (empty($data))
        {
            return [];
        }
        $primary = [];
        foreach ($data as $cate)
        {
            $primary[] = [
                'id' => $cate->cateid,
                'text' => $cate->title,
                'children' => $this->getChild($cate->cateid)
            ];
        }
        return ['data' => $primary, 'pages' => $pages];
    }

}
