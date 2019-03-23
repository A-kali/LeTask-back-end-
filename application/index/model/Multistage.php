<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 15:46
 */

namespace app\index\model;


use think\Model;

class Multistage extends Model
{
    public $id;
    public $title;
    public $content;
    public $money;
    public $stage;
    public $total_stage;
    public $taskline;
}