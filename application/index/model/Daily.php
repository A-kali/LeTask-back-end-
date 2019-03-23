<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/19
 * Time: 15:46
 */

namespace app\index\model;


use think\Model;

class Daily extends Model
{
    public $id;
    public $content	;
    public $title;
    public $money;
    public $taskline;
    public $isFinished;
    public $lastResetTime;

}