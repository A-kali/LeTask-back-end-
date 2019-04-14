<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/21
 * Time: 17:21
 */

namespace app\index\logic;
use app\index\controller\Charts;
use app\index\model\History;
use app\index\model\User;

class Sethistory
{
    public static function get_last_record(){
        $page = 1;

        return History::order('id desc')
            ->page($page, 25)
            ->select();
    }

    public static function new_record($money, $description, $type='完成任务'){
        if($type=="消费"||$type=="娱乐")
            $money = -$money;
        $history = new History([
            'money'=> $money,
            'description' => $description,
            'type' => $type,
        ]);
        $history->save();
        User::where('id',0)->setInc('score',$money);
        Charts::auto_set_chart();
        return ['log'=>'success'];
    }
}