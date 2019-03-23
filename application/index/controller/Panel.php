<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 14:54
 */

namespace app\index\controller;

use app\index\logic\Gettasks;
use app\index\logic\Sethistory;
use app\index\model\Addition;
use app\index\model\User;
use think\Request;
use think\Controller;
use think\Loader;

class Panel extends Controller
{
    public function get_all_tasks(){
        return Gettasks::get_all_tasks();
    }

    public function finish_task(Request $request){
        $finish = Loader::model('Finishtasks','logic');
        $type = $request->param('type');
        $id = $request->param('id');
        switch ($type){
            case "maintask":
                return $finish->finish_maintask($id);
            case "sidequest":
                return $finish->finish_sidequest($id);
            case "daily":
                return $finish->finish_daily($id);
            case "challenge":
                return $finish->finish_challenge($id);
            case "multistage":
                return $finish->finish_multistage($id);
            default:
                return ['log' => $request->param()];
        }
    }

    public function finish_addition_task(Request $request){
        $id = $request->param('id');
        $count = $request->param('count');
        $data = Addition::where('id',$id)->field('money,title')->find();
        Sethistory::new_record($data['money']*$count,$data['title']);
        return Gettasks::get_all_tasks();
    }

    public function delete_task(Request $request){
        $type = $request->param('type');
        $id = $request->param('id');
        $task = Loader::model($type);
        $task->destroy($id);
        return Gettasks::get_all_tasks();
}

    public function get_user_info(Request $request){
        $money = User::get(0)->value('score');
        return ['money'=>$money];
    }

    public function accept_challenge(Request $request){
        return Gettasks::accept_challenge($request->param('id'));
    }
}

