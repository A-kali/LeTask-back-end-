<?php

namespace app\index\controller;


use app\index\model\Chart;
use app\index\model\History;
use think\Controller;
use think\Request;

class Charts extends Controller
{
    public function get_chart()
    {
        self::auto_set_chart();
        $data = array_values(Chart::order('id desc')->column('id, date, consume, profit, pure_profit'));
//        $profit = array_values(Chart::column('id, date, profit'));
//        $pure_profit = array_values(Chart::column('id, date, pure_profit'));
//        return ['consume' => $consume, 'profit' => $profit, 'pure_profit' => $pure_profit];
        return $data;
    }

    public function set_chart(Request $request)
    {
        switch ($request->param('type')) {
            case '俯卧撑':
                $type = 'push_up';
                break;
            case '跑步':
                $type = 'running';
                break;
            case '肌肉量':
                $type = 'muscle_mass';
                break;
        }
        $value = $request->param('value');

        if (Chart::where('date', Date('Y-m-d'))->update([$type => $value]) == 0) {
            $chart = new Chart(['date' => Date('Y-m-d'), $type => $value]);
            $chart->save();
        }
        return self::get_chart();
    }

    public static function auto_set_chart()
    {
        $consume = -History::whereTime('date', '>', date('Y-m-d H:i:s', strtotime('-1 day 23:59:59', time())))
            ->where('money', '<', '0')
            ->sum('money');
        $profit = History::whereTime('date', '>', date('Y-m-d H:i:s', strtotime('-1 day 23:59:59', time())))
            ->where('money', '>', '0')
            ->sum('money');
        $pure_profit = $profit - $consume;
        if (Chart::where('date', Date('Y-m-d'))->find() == null) {
            $chart = new Chart([
                'date' => Date('Y-m-d'),
                'consume' => $consume,
                'profit' => $profit,
                'pure_profit' => $pure_profit
            ]);
            $chart->save();
        } else {
            Chart::where('date', Date('Y-m-d'))
                ->update([
                    'consume' => $consume,
                    'profit' => $profit,
                    'pure_profit' => $pure_profit
                ]);
        }
    }
}