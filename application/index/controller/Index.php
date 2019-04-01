<?php
namespace app\index\controller;

use app\index\model\Chart;

class Index
{
    public function index()
    {
        return Chart::where('date', Date('Y-m-d'))->find() == null ;
    }
}
