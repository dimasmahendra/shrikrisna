<?php

namespace App\Http\Controllers\Rbac;

use App\Models\User;
use App\Models\AuthRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $model = User::orderBy('id');
        if ($request->has('search')) {
            $model->where('name','ILIKE','%'.$request->input('search').'%')
                    ->orWhere('email','ILIKE','%'.$request->input('search').'%');
        }
        if ($request->has('filter')) {
            if (in_array( $request->input('filter'), ["active", "nonactive"])) {
                $model->where('status','LIKE', $request->input('filter'));
            } else {
                abort(404);
            }
        }

        $users = $model->paginate(10);
        
        return view('cms.rbac.users.index', [
            "users" => $users,
            "roles" => AuthRole::active()->get()
        ]);
    }

    public function store(Request $request)
    {
        if ($request->password != $request->confirmpassword) {
            return redirect(route('rbac.users.index'))->with('error','Error');
        }

        $model = new User;
        $model->name = $request->username;
        $model->email = $request->email;
        $model->role_id = $request->role_id;
        $model->password = Hash::make($request->password);
        $model->status = $request->status;

        return $model->save();
    }

    public function edit(Request $request)
    {
        return view('cms.rbac.users.edit', [
            "model" => $request->datamaster,
            "roles" => AuthRole::active()->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->password != $request->confirmpassword) {
            return redirect(route('rbac.users.index'))->with('error','Error');
        }

        $model = User::find($id);
        $model->name = $request->username;
        $model->email = $request->email;
        $model->role_id = $request->role_id;
        if ($request->password != null || $request->password != "") {
            $model->password = Hash::make($request->password);
        }
        $model->status = $request->status;
        return $model->save();
    }

    public function destroy($id)
    {
        User::where([
            'id' => $id
        ])
        ->update(['status' => 'nonactive']);
        
        $model = User::find($id);
        $model->delete();
        return redirect(route('rbac.users.index'))->with("message", "Deleted");
    }
}
