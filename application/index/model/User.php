<?php
/**
 * Created by PhpStorm.
 * User: DOS
 * Date: 2019/3/20
 * Time: 0:31
 */

namespace app\index\model;


use think\Model;

class User extends Model
{
    public $username;
    public $password;
    public $score;
}