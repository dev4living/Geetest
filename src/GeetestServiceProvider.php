<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/4/11
 * Time: 12:36
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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class GeetestServiceProvider extends ServiceProvider
{
    /**
     * BOOT 服务
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function boot(Request $request) {
        $this->loadViewsFrom(__DIR__ . '/views', 'geetest');
        $this->publishes([
                             __DIR__ . '/views'      => base_path('resources/views/vendor/geetest'),
                             __DIR__ . '/config.php' => config_path('geetest.php'),
                         ]);
        Route::get('geetest', 'ProtobiaAlpha\Geetest\GeetestController@getGeetest');
        Validator::extend('geetest', function () use ($request) {
            /** @noinspection PhpParamsInspection */
            list($geetest_challenge, $geetest_validate, $geetest_seccode) =
                array_values($request->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'));

            $data = [
                "user_id"     => session('geetest_user_id'),
                "client_type" => "web",
                "ip_address"  => $request->ip(),
            ];
            if (session()->get('gtserver') == 1) {
                return GeetestLib::successValidate($geetest_challenge, $geetest_validate, $geetest_seccode,
                                                   $data);
            } else {
                return GeetestLib::failValidate($geetest_challenge, $geetest_validate, $geetest_seccode);
            }
        });
        Blade::extend(function ($value) {
            return preg_replace('/@define(.+)/', '<?php ${1}; ?>', $value);
        });
    }

    /**
     * 注册服务
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('geetest', function () {
            return $this->app->make('ProtobiaAlpha\Geetest\Geetest');
        });
    }
}