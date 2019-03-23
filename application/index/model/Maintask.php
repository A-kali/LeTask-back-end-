<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 14:56
 */

namespace app\index\model;


use think\Model;

class Maintask extends Model
{
    public $id;
    public $title;
    public $content;
    public $money;
    public $taskline;

}