<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // some other functions go here

    protected function authenticated(Request $request, $user)
    {
      // return $user;
        // to admin dashboard
        if($user->isAdmin()) {
            return redirect(route('admin_dashboard'));
        }

        // to user dashboard
        else if($user->isDistributor()) {
            return redirect(route('distributor_dashboard'));
        }

         // to user dashboard
         else if($user->isDealer()) {
            return redirect(route('dealer_dashboard'));
        }

         // to user dashboard
         else if($user->isRto()) {
            return redirect(route('rto_dashboard'));
        }

        abort(404);
    }
    public function changePassword() {
       return view('auth.passwords.reset');
    }
    public function updatePassword(Request $request) {
        
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'confirm_password' => ['required','same:new_password'],
        ]);

        User::find(Auth::getUser()->id)->update(['password'=> Hash::make($request->new_password)]);

        if(Auth::getUser()->isAdmin()) {
            return redirect(route('admin_dashboard'));
        }

        // to user dashboard
        else if(Auth::getUser()->isDistributor()) {
            return redirect(route('distributor_dashboard'));
        }

         // to user dashboard
         else if(Auth::getUser()->isDealer()) {
            return redirect(route('dealer_dashboard'));
        }

         // to user dashboard
         else if(Auth::getUser()->isRto()) {
            return redirect(route('rto_dashboard'));
        }
        //return redirect()->back();
    }
    public function logout(){
        Auth::logout();
        return redirect('login');
    }
}
