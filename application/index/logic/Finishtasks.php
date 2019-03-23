<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/20
 * Time: 0:05
 */

namespace app\index\logic;

use app\index\model\Challenge;
use app\index\model\Daily;
use app\index\model\Maintask;
use app\index\model\Multistage;
use app\index\model\Sidequest;
use think\Model;

class Finishtasks extends Model
{
    /**
     * @param $id
     * 根据id删除当前记录
     * 用户金额增加
     * return 下一条记录
     */
    public function finish_maintask($id){
        $data = Maintask::where('id',$id)->field('money,title')->find();
        Sethistory::new_record($data['money'],$data['title']);
        Maintask::destroy($id);
        return Gettasks::get_all_tasks();
    }

    public function finish_sidequest($id){
        $data = Sidequest::where('id',$id)->field('money,title')->find();
        Sethistory::new_record($data['money'],$data['title']);
        Sidequest::destroy($id);
        return Gettasks::get_all_tasks();
    }

    public function finish_daily($id){
        $data = Daily::where('id',$id)->field('money,title')->find();
        Sethistory::new_record($data['money'],$data['title']);
        Daily::update(['id'=>$id, 'isFinished'=>true, 'lastResetTime'=>Date('Y-m-d')]);
        return Gettasks::get_all_tasks();
    }


    public function finish_challenge($id){
        $data = Challenge::where('id',$id)->field('money,title')->find();
        Sethistory::new_record($data['money'],$data['title']);
        Challenge::destroy($id);
        return Gettasks::get_all_tasks();
    }

    public function finish_multistage($id){
        $data = Multistage::where('id',$id)->field('money,title,stage,total_stage')->find();
        Sethistory::new_record($data['money'],$data['title'].'（阶段）');
        if($data['stage']+1==$data['total_stage']){
            Multistage::destroy($id);
        }else{
            Multistage::where('id',$id)->setInc('stage',1);
        }
        return Gettasks::get_all_tasks();
    }

}