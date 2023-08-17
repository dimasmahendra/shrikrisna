<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()) {   // Check is user logged in
            return redirect()->route('customer.index');
        } else {
            return redirect()->route('login');
        }
    }

    public function dashboardIndex()
    {
        return view('cms.content');
    }

    public function changePassword(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        if (empty($user)) {
            return back()->with("error", "User Not Found");
        }
        if (Hash::check($request->oldpassword, $user->password) == false) {
            return back()->with("error", "Incorrect Old Password");
        } 
        if ($user->status != "active") {
            return back()->with("error", "User Not Active");
        }

        $user->password = Hash::make($request->changepassword);
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();
        return back()->with("message", "Success");
    }
}
