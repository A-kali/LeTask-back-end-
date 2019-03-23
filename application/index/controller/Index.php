<?php
namespace app\index\controller;

use think\Cookie;
use think\Session;

class Index
{
    public function index()
    {
        Session::set('name','test');
        Cookie::set(session_name(),session_id());
        //return Session::get();
        return '233';
    }
}
