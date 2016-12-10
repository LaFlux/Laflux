<?php
namespace ExtensionsValley\Dashboard;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    /*
        |--------------------------------------------------------------------------
        | Password Reset Controller
        |--------------------------------------------------------------------------
        |
        | This controller is responsible for handling password reset requests
        | and uses a simple trait to include this behavior. You're free to
        | explore this trait and override any methods you wish to tweak.
        |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getResetView()
    {

        $title = 'ExtensionsValley - Reset Password';

        if (\Auth::guard('admin')->check()) {
            return redirect()->route('extensionsvalley.admin.dashboard')->with(['message' => 'Welcome Back ' . \Auth::guard('admin')->user()->name . '!']);
        }

        return \View::make('Dashboard::login.password', compact('title'));
    }

    public function postResetData(Request $request)
    {

        $validation = \Validator::make(\Input::only('email'), ['email' => 'required|email']);

        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.reset')->withErrors($validation);
        }

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('message', trans($response));

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url('admin/password/reset', $this->token))
            ->line('If you did not request a password reset, no further action is required.');
    }

    public function getResetConfirm($token)
    {


        $title = 'ExtensionsValley - Create New Password';

        if (\Auth::guard('admin')->check()) {
            return redirect()->route('extensionsvalley.admin.dashboard')->with(['message' => 'Welcome Back ' . \Auth::guard('admin')->user()->name . '!']);
        }

        return \View::make('Dashboard::login.passwordconfirm', compact('title', 'token'));
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return isset($this->subject) ? $this->subject : 'Your Password Reset Link';
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $validation = \Validator::make(\Input::all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.passwordconfirm')->withErrors($validation);
        }

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath());

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);

        $user->save();

        Auth::login($user);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/admin/dashboard';
    }
}
