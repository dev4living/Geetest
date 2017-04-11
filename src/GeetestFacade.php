<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/4/10
 * Time: 19:27
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


namespace ProtobiaAlpha\Geetest;

use \Illuminate\Http\Request;

class GeetestFacade
{
    /**
     * 校验极验验证码
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public static function validate(Request $request) {
        /** @noinspection PhpParamsInspection */
        list($geetest_challenge, $geetest_validate, $geetest_seccode) =
            array_values($request->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'));
        $data = [
            "user_id"     => session('geetest_user_id'),
            "client_type" => "web",
            "ip_address"  => $request->ip(),
        ];

        if (session('gtserver') == 1) {
            return self::successValidate($geetest_challenge, $geetest_validate,
                                         $geetest_seccode, $data);
        } else {
            return self::failValidate($geetest_challenge, $geetest_validate,
                                      $geetest_seccode);
        }
    }

    /**
     * 宕机校验
     *
     * @param $geetest_challenge
     * @param $geetest_validate
     * @param $geetest_seccode
     * @return int
     */
    public static function failValidate($geetest_challenge, $geetest_validate,
                                        $geetest_seccode) {
        $geetest = self::init();

        return $geetest->fail_validate($geetest_challenge, $geetest_validate,
                                       $geetest_seccode);
    }

    /**
     * 正常校验
     *
     * @param $geetest_challenge
     * @param $geetest_validate
     * @param $geetest_seccode
     * @param $data
     * @return int
     */
    public static function successValidate($geetest_challenge, $geetest_validate,
                                           $geetest_seccode, $data) {
        $geetest = self::init();

        return $geetest->success_validate($geetest_challenge, $geetest_validate,
                                          $geetest_seccode, $data);
    }

    /**
     * 初始化极验 SDK
     *
     * @return \GeetestLib
     */
    public static function init() {
        $captcha_id  = \Config::get('geetest.geetest_id');
        $private_key = \Config::get('geetest.geetest_key');

        return new \GeetestLib($captcha_id, $private_key);
    }

    /**
     * 生成校验代码
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public static function generate(Request $request) {
        $geetest    = self::init();
        $geetest_id = str_random(10);
        $data       = [
            "user_id"     => $geetest_id,
            "client_type" => "web",
            "ip_address"  => $request->ip(),
        ];
        $status     = $geetest->pre_process($data, 1);
        session(['gtserver' => $status, 'geetest_user_id' => $geetest_id]);

        return $geetest->get_response_str();
    }

    /**
     * 生成前端极验模版
     *
     * @param string $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function render($product = 'float') {
        return view('geetest::geetest', [
            'product'     => $product,
            'geetest_url' => \Config::get('geetest.geetest_url', 'geetest'),
        ]);
    }
}