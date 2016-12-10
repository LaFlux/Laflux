<?php
namespace ExtensionsValley\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class LoginController extends Controller
{


    public function getIndex()
    {
        $title = 'ExtensionsValley - Admin Login';
        if (\Auth::guard('admin')->check()) {
            return redirect()->route('extensionsvalley.admin.dashboard')->with(['message' => 'Welcome Back ' . \Auth::guard('admin')->user()->name . '!']);
        }

        return \View::make('Dashboard::login.index', compact('title'));
    }


    public function getAutendicate(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

       /* if (\Auth::guard('admin')->attempt(['email' => $email, 'password' => $password, 'status' => 1], $remember)) {
            return redirect()->route('extensionsvalley.admin.dashboard');

        } else {

            return redirect()->route('extensionsvalley.admin.login')->with(['error' => 'Invalid User Name or Password or Account not yet activated!']);
        }*/

        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (\Auth::guard('admin')->attempt(
                    ['email' => $email
                    , 'password' => $password
                    , 'status' => 1]
                    , $remember)){

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect()->route('extensionsvalley.admin.login')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);


    }

    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, \Auth::guard('admin'));
        }

        return redirect()->route('extensionsvalley.admin.dashboard');
    }

    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }

    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    protected function getFailedLoginMessage()
    {
        return \Lang::has('auth.failed')
                ? \Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }

    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }

    public function logOut()
    {

        \Auth::guard('admin')->logout();
        return redirect()->route('extensionsvalley.admin.login')->with(['message' => 'You have successfully signed Out.']);
    }
}
