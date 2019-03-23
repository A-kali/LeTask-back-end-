<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 15:46
 */

namespace app\index\model;


use think\Model;

class Challenge extends Model
{
    public $id;
    public $title;
    public $content;
    public $money;
    public $isAccepted;
    public $taskline;
    public $belong_to;
}