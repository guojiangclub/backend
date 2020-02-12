<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Backend\Http\Controllers;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AuthController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use iBrand\Sms\Facade as Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthAdminController extends AuthController
{
    public function getLogin()
    {
	    if ($this->guard()->check()) {
		    return redirect($this->redirectPath());
	    }

	    $time = time();
	    $salt = 'changdou-admin-login-sing';
	    $sign = md5(http_build_query(['key' => config('ibrand.app.sign_key'), 'salt' => $salt, 'time' => $time]));

	    return view('admin::admin-login-ibrand', compact('time', 'salt', 'sign'));
    }

    public function postLogin(Request $request)
    {
        $username = !$this->isMail(request($this->username())) ? 'username' : 'email';

        $credentials = $request->only([$this->username(), 'password', 'code']);


        if (config('ibrand.backend.sms_login')) {
            $admin = Administrator::where("$username", request('username'))->where('status', 1)->first();

            if (!$admin or !$admin->mobile) {
                return redirect()->back()->withInput()->withErrors(['username' => '账号不存在或未绑定手机']);
            }

            $mobile = $admin->mobile;

            $credentials_code = [
                'mobile' => $mobile,
                'verifyCode' => request('code'),
            ];

            if (!request('code')) {
                return redirect()->back()->withInput()->withErrors(['code' => '验证码不能为空']);
            }

            if (!Sms::checkCode($mobile, \request('code'))) {
                return redirect()->back()->withInput()->withErrors(['code' => '验证码不正确']);
            }

            unset($credentials['code']);
        }

        $validator = Validator::make($credentials, [
            $this->username() => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $new_credentials[$username] = $credentials[$this->username()];
        $new_credentials['password'] = $credentials['password'];

        if ($this->guard()->attempt($new_credentials)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    public function getMobile(Request $request)
    {
        $username = !$this->isMail(request($this->username())) ? 'username' : 'email';

        if ($user = Administrator::where("$username", $request->username)->where('status', 1)->first() and $user->mobile) {
            return response()->json([
                'data' => $user,
                'status' => true,
            ]);
        }

        return response()->json([
            'msg' => '管理员账号不存在或未绑定手机号码',
            'status' => false,
        ]);
    }

    public function getLogout(Request $request)
    {
        if (config('ibrand.backend.scenario') == 'normal' || !config('ibrand.backend.scenario')) {
            $this->guard()->logout();

            $request->session()->invalidate();

            return redirect(config('admin.route.prefix'));
        }

        $this->guard()->logout();
        Auth::guard('account')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        Cookie::queue(Cookie::forget('ibrand_log_uuid'));
        Cookie::queue(Cookie::forget('ibrand_log_sso_user'));
        Cookie::queue(Cookie::forget('ibrand_log_application_name'));
        Cookie::queue(Cookie::forget('ibrand_log_sso_user'));

        return redirect('/account/login');

    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : config('admin.route.prefix');
    }

    protected function isMail($Argv)
    {
        $RegExp = '/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';

        return preg_match($RegExp, $Argv) ? $Argv : false;
    }

    public function getSetting(Content $content)
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin.user_setting'));
            $form = $this->settingForm();
            $form->tools(
                function (Form\Tools $tools) {
                    $tools->disableBackButton();
                    $tools->disableListButton();
                }
            );
            $content->body($form->edit(Admin::user()->id));
        });
    }

    /**
     * Update user setting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSetting()
    {
        return $this->settingForm()->update(Admin::user()->id);
    }

    /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {
        return Administrator::form(function (Form $form) {
            $form->display('username', trans('admin.username'));
            $form->text('name', trans('admin.name'))->rules('required');
            $form->email('email', trans('Email'));
            $form->mobile('mobile', trans('Mobile'));
            $form->image('avatar', trans('admin.avatar'));
            $form->password('password', trans('admin.password'))->rules('confirmed|required');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->setAction(admin_base_path('auth/setting'));

            $form->ignore(['password_confirmation']);

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });

            $form->saved(function () {
                admin_toastr(trans('admin.update_succeeded'));

                return redirect(admin_base_path('auth/setting'));
            });
        });
    }
}
