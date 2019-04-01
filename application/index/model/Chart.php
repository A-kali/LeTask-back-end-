<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/30
 * Time: 22:11
 */

namespace app\index\model;


use think\Model;

class Chart extends Model
{
    public $id;
    public $date;

    public $consume;
    public $profit;
    public $pure_profit;

    public $push_up;
    public $running;
    public $muscle_mass;
}