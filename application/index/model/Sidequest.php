<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 15:19
 */

namespace app\index\model;


use think\Model;

class Sidequest extends Model
{
    public $id;
    public $title;
    public $content;
    public $money;
    public $tasks_list;
}