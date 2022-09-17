<?php
namespace App\Library;
use DB;
use App\Models\User;


class Helper
{
    public static function CheckRefer($refer)
    {
        $user = DB::table('users')->where('token', $refer)->first();
        if ($user) {
            return [
                'status' => true,
                'data'   => $user
            ];
        } else {
            return [
                'status' => false,
                'data'   => []
            ];
        }
    }

    public static function setting()
    {
        $setting = DB::table('settings')->first();
        if ($setting) {
            return $setting;
        } else {
            return [
                'status' => false,
                'data'   => []
            ];
        }
    }

    public static function updateColumn($table = 'users', $column, $value)
    {
        try {
            DB::table($table)
            ->where('id', user_id())
            ->update(array($column => $value));
            return true;
        } catch (\Exceptiion $e) {
            require false;
        }

    }

    public static function getTaskData($task_type)
    {
        switch ($task_type) {
            case 1:
                $position = auth()->user()->spin_one_pos;
                $task_position_name = 'spin_one_pos';
                $task_limit = 'spin_one_limit';
                $task_impressiontime = 'spin_one_impressiontime';
                $task_breaktime = 'spin_one_breaktime';
                $task_clicktime = 'spin_one_clicktime';
                $task_dollar = 'spin_one_dollar';
            break;
            case 2:
                $position = auth()->user()->spin_two_pos;
                $task_position_name = 'spin_two_pos';
                 $task_limit = 'spin_two_limit';
                $task_impressiontime = 'spin_two_impressiontime';
                $task_breaktime = 'spin_two_breaktime';
                $task_clicktime = 'spin_two_clicktime';
                $task_dollar = 'spin_two_dollar';
                break;
            case 3:
                $position = auth()->user()->mathquiz_one_pos;
                $task_position_name = 'mathquiz_one_pos';
                $task_limit = 'mathquiz_one_limit';
                $task_impressiontime = 'mathquiz_one_impressiontime';
                $task_breaktime = 'mathquiz_one_breaktime';
                $task_clicktime = 'mathquiz_one_clicktime';
                $task_dollar = 'mathquiz_one_dollar';
                break;
            case 4:
                $position = auth()->user()->mathquiz_two_pos;
                $task_position_name = 'mathquiz_two_pos';
                $task_limit = 'mathquiz_two_limit';
                $task_impressiontime = 'mathquiz_two_impressiontime';
                $task_breaktime = 'mathquiz_two_breaktime';
                $task_clicktime = 'mathquiz_two_clicktime';
                $task_dollar = 'mathquiz_two_dollar';
                break;
            case 5:
                $position = auth()->user()->watchvideo_one_pos;
                $task_position_name = 'watchvideo_one_pos';
                 $task_limit = 'watchvideo_one_limit';
                $task_impressiontime = 'watchvideo_one_impressiontime';
                $task_breaktime = 'watchvideo_one_breaktime';
                $task_clicktime = 'watchvideo_one_clicktime';
                $task_dollar = 'watchvideo_one_dollar';
                break;
            case 6:
                $position = auth()->user()->watchvideo_two_pos;
                $task_position_name = 'watchvideo_two_pos';
                $task_limit = 'watchvideo_two_limit';
                $task_impressiontime = 'watchvideo_two_impressiontime';
                $task_breaktime = 'watchvideo_two_breaktime';
                $task_clicktime = 'watchvideo_two_clicktime';
                $task_dollar = 'watchvideo_two_dollar';
                break;
            case 7:
                $position = auth()->user()->scratchcard_one_pos;
                $task_position_name = 'scratchcard_one_pos';
                $task_limit = 'scratchcard_one_limit';
                $task_impressiontime = 'scratchcard_one_impressiontime';
                $task_breaktime = 'scratchcard_one_breaktime';
                $task_clicktime = 'scratchcard_one_clicktime';
                $task_dollar = 'scratchcard_one_dollar';
                break;
            case 8:
                $position = auth()->user()->scratchcard_two_pos;
                $task_position_name = 'scratchcard_two_pos';
                $task_limit = 'scratchcard_two_limit';
                $task_impressiontime = 'scratchcard_two_impressiontime';
                $task_breaktime = 'scratchcard_two_breaktime';
                $task_clicktime = 'scratchcard_two_clicktime';
                $task_dollar = 'scratchcard_two_dollar';
                break;
            default:
                 return [
                    'success' => false,
                    'message' => "Invalid Task."
                ];
        }

        return [
            'success' =>true,
            'position' => $position,
            'task_position_name' => $task_position_name,
            'task_limit' => $task_limit,
            'task_impressiontime' => $task_impressiontime,
            'task_breaktime' => $task_breaktime,
            'task_clicktime' => $task_clicktime,
            'task_dollar' => $task_dollar
        ];

    }
}
