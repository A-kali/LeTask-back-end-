<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/23
 * Time: 15:26
 */

namespace app\index\model;


use think\Model;

class Addition extends Model
{
    public $id;
    public $title;
    public $content;
    public $taskline;
    public $money;
}