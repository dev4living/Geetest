<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/4/11
 * Time: 12:45
 *
 *_______________%%%%%%%%%_______________________
 *______________%%%%%%%%%%%%_____________________
 *______________%%%%%%%%%%%%%____________________
 *_____________%%__%%%%%%%%%%%___________________
 *____________%%%__%%%%%%_%%%%%__________________
 *____________%%%_%%%%%%%___%%%%_________________
 *___________%%%__%%%%%%%%%%_%%%%________________
 *__________%%%%__%%%%%%%%%%%_%%%%_______________
 *________%%%%%___%%%%%%%%%%%__%%%%%_____________
 *_______%%%%%%___%%%_%%%%%%%%___%%%%%___________
 *_______%%%%%___%%%___%%%%%%%%___%%%%%%_________
 *______%%%%%%___%%%__%%%%%%%%%%%___%%%%%%_______
 *_____%%%%%%___%%%%_%%%%%%%%%%%%%%__%%%%%%______
 *____%%%%%%%__%%%%%%%%%%%%%%%%%%%%%_%%%%%%%_____
 *____%%%%%%%__%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%____
 *___%%%%%%%__%%%%%%_%%%%%%%%%%%%%%%%%_%%%%%%%___
 *___%%%%%%%__%%%%%%_%%%%%%_%%%%%%%%%___%%%%%%___
 *___%%%%%%%____%%__%%%%%%___%%%%%%_____%%%%%%___
 *___%%%%%%%________%%%%%%____%%%%%_____%%%%%____
 *____%%%%%%________%%%%%_____%%%%%_____%%%%_____
 *_____%%%%%________%%%%______%%%%%_____%%%______
 *______%%%%%______;%%%________%%%______%________
 *________%%_______%%%%________%%%%______________
 */


return [
    // 语言设置
    'lang'              => 'zh-cn',
    // 极验 ID
    'geetest_id'        => env('GEETEST_ID'),
    // 极验 KEY
    'geetest_key'       => env('GEETEST_KEY'),
    // 校验地址
    'geetest_url'       => '/geetest',
    // 客户端错误提示
    'client_fail_alert' => '请正确完成验证码操作',
    // 服务端错误提示
    'server_fail_alert' => '验证码校验失败',
];