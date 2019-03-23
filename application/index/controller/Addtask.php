<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 15:55
 */

namespace app\index\controller;
use think\Controller;
use think\Request;

class Addtask extends Controller
{
    public function index(Request $request){
        $form = json_decode($request->param('form'), true);
        foreach($form as $k=>$v){
            if( !$v )
                unset($form[$k] );
        }
        unset($form['type']);
        $type = $request->param('type');
        $task = model($type);
        $task->data($form);
        $task->save();
        return ['log'=>'success'];
    }
}