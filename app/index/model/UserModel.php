<?php
/* 
 * 数据库操作类
 */
namespace app\index\model;

use core\lib\Model;


class UserModel extends Model
{

    public function test()
    {
        $model = new Model('default');

        $sql = 'select * from news where id<10';
        $res = $model->query($sql, 'all', true);
        $res = $model->insert('news', array('id' => null, 'title' => 'prepare sql test', 'content' => 'test sql', 'status' => '1'));
        $res = $model->delete('news', 'id=2000000');
        $res = $model->update('news', array('title' => 'ptest', 'content' => 'test'), 'id = 1');
        $arr = array('update news set status = 0 where id = 1', 'update news set status = 0 where id = 2');
        $res = $model->execTransaction($arr);
        dump($res);

    }
}