<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/21
 * Time: 17:20
 */

namespace app\index\controller;


use app\index\logic\Sethistory;
use think\Controller;
use think\Request;

class Record extends Controller
{
    public function get_last_history(){
        return Sethistory::get_last_record();
    }

    public function new_record(Request $request){
        $form = json_decode($request->param('form'), true);
        $money = $form['money'];
        $type = $form['type'];
        $desc = $form['description'];
        return Sethistory::new_record($money, $desc, $type);
    }
}