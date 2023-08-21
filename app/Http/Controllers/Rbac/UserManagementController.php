<?php

namespace App\Http\Controllers\Rbac;

use Config;
use Carbon\Carbon;
use App\Models\User;
use App\Models\AuthRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $model = User::orderBy('id')->where('status', '<>', 2);
        if ($request->has('search')) {
            $model->where('name','ILIKE','%'.$request->input('search').'%')
                    ->orWhere('email','ILIKE','%'.$request->input('search').'%');
        }
        if ($request->has('filter')) {
            if (in_array( $request->input('filter'), ["active", "nonactive"])) {
                $status = ($request->input('filter') == "active") ? 1 : 0;
                $model->where('status','=', $status);
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
            return redirect(route('rbac.users.index'))->with('error','Password is not match.');
        }

        $model = new User;
        $model->id_role = $request->id_role;
        $model->name = $request->username;
        $model->email = $request->email;
        $model->password = Hash::make($request->password);
        $model->photo = "no-image.svg";
        $model->is_reset = 0;
        $model->verify_at = Carbon::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s", strtotime($request->start_date)))->timezone(Config::get('app.timezone'))->format('Y-m-d H:i:sO');
        $model->status = ($request->status == "active") ? 1 : 0;
        $model->save();

        return redirect(route('rbac.users.index'))->with("message", "Saved");
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
        $model = User::where('id', $id)->first();
        $model->id_role = $request->id_role;
        $model->name = $request->username;
        $model->status = ($request->status == "active") ? 1 : 0;
        $model->save();

        return redirect(route('rbac.users.index'))->with("message", "Updated");
    }

    public function resetPasswordedit(Request $request)
    {
        return view('cms.rbac.users.reset-password', [
            "model" => $request->datamaster
        ]);
    }

    public function resetPassword(Request $request, $id)
    {
        if ($request->password != $request->confirmpassword) {
            return redirect(route('rbac.users.index'))->with('error','Error');
        }

        $model = User::where('id', $id)->first();
        $model->password = Hash::make($request->password);
        $model->save();

        return redirect(route('rbac.users.index'))->with("message", "Updated");
    }

    public function destroy(Request $request, $id)
    {
        try {            
            $model = User::find($id);
            $model->forceDelete();

            return response()->json([
                'status' => true,
                'message' => 'Data Deleted',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
