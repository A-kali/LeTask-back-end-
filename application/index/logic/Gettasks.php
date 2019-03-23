<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 23:26
 */

namespace app\index\logic;

use app\index\model\Challenge;
use app\index\model\Daily;
use app\index\model\Maintask;
use app\index\model\Multistage;
use app\index\model\Sidequest;
use app\index\model\Addition;
use think\Model;

class Gettasks extends Model
{
    public static function get_all_tasks()
    {
        return [
            'maintask' => self::get_maintasks(),
            'sidequest' => self::get_sidequest(),
            'daily' => self::get_daily(),
            'challenge' => self::get_challenge(),
            'multistage' => self::get_multistage(),
            'addition' => self::get_addition(),
        ];
    }

    public static function get_maintasks()
    {
        $data = Maintask::where('1=1')->find();
        return $data;

    }

    public static function get_sidequest()
    {
        return Sidequest::select();
    }


    public static function get_daily()
    {
        self::check_daily();
        return Daily::where('isFinished', false)->select();
    }


    protected static function check_daily()
    {
        $money = -Daily::whereTime('lastResetTime', '<', Date('Y-m-d'))
            ->where('isFinished', false)
            ->sum('money');
        $money = $money-Sidequest::whereTime('date','<', Date('Y-m-d'))->sum('money');
        if ($money != 0) {
            $money = $money - Sidequest::count();
            Sethistory::new_record($money, '未完成限时任务', '惩罚');
        }
        Daily::whereTime('lastResetTime', '<', Date('Y-m-d'))
            ->update([
                'lastResetTime' => Date('Y-m-d'),
                'isFinished' => false,
            ]);
        Sidequest::whereTime('date','<', Date('Y-m-d'))
            ->update(['date'=>Date('Y-m-d')]);

    }

    public static function get_challenge()
    {
        $data = Challenge::select();
        return $data;
    }

    public static function accept_challenge($id)
    {
        Challenge::update(['id' => $id, 'isAccepted' => true]);
        return ['log' => "success"];
    }

    public static function get_multistage()
    {
        $data = Multistage::select();
        foreach ($data as $item) {
            $item['percentage'] = (int)($item['stage'] / $item['total_stage'] * 100);

        }
        return $data;
    }

    public static function get_addition(){
        return Addition::select();
    }

}