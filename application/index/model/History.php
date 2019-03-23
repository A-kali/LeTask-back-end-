<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 16:10
 */

namespace app\index\model;


use think\Model;

class History extends Model{

    public $id;
    public $date;
    public $money;
    public $type;
    public $description;
}