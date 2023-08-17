<?php

namespace App\Http\Controllers\Rbac;

use Exception;
use App\Models\User;
use App\Models\AuthRole;
use App\Models\AuthAccess;
use App\Models\AuthPermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleManagementController extends Controller
{
    public function index(Request $request)
    {
        $model = AuthRole::orderBy('id', 'ASC');
        if ($request->has('search')) {
            $model->where('role_name','ILIKE','%'.$request->input('search').'%');
        }
        if ($request->has('filter')) {
            if (in_array( $request->input('filter'), ["active", "nonactive"])) {
                $model->where('status','LIKE', $request->input('filter'));
            } else {
                abort(404);
            }
        }

        $role = $model->paginate(10);

        return view('cms.rbac.role.index', [
            "role" => $role
        ]);
    }

    public function create()
    {
        $dataaccess = AuthAccess::getAllAccess();
        return view('cms.rbac.role.create', [
            'access' => $dataaccess
        ]);
    }

    public function store(Request $request)
    {
        try {
            if ($request->access_control_count > 0) {
                $model = new AuthRole;
                $model->role_name = $request->role_name;
                $model->status = $request->status;
                if ($model->save()) {
                    $roleId = $model->id;
                    foreach ($request->permission as $key => $value) {
                        $permission = new AuthPermission;
                        $permission->role_id = $model->id;
                        $permission->route_name = $key;
                        $permission->is_active = $value;
                        $permission->save();
                    }
                    return redirect(route('rbac.role.index'))->with("message", "Saved");
                }
            } else {
                return redirect(route('rbac.role.create'))->with("error", "Please choose Access Control");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        $role = AuthRole::find($id);
        $model = new AuthPermission;
        $permission = $model->dataView($model->select('route_name', 'is_active')->where([
            'role_id' => $role->id
        ])->orderBy('id')->get());
        // dd($permission);

        $dataaccess = AuthAccess::getAllAccess();

        return view('cms.rbac.role.edit', [
            'id' => $id,
            'role' => $role,
            'access' => $dataaccess,
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->access_control_count > 0) {
                $model = AuthRole::find($id);
                $model->role_name = $request->role_name;
                $model->status = $request->status;
                if ($model->save()) {
                    foreach ($request->permission as $key => $value) {
                        $permission = AuthPermission::where([
                            'role_id' => $model->id,
                            'route_name' => $key
                        ])->first();
                        if (empty($permission)) {
                            $insertpermission = new AuthPermission;
                            $insertpermission->role_id = $model->id;
                            $insertpermission->route_name = $key;
                            $insertpermission->is_active = $value;
                            $insertpermission->save();
                        } else {
                            $permission->is_active = $value;
                            $permission->save();
                        }
                    }
                    return redirect(route('rbac.role.index'))->with("message", "Updated");
                }
            } else {
                return redirect(route('rbac.role.edit', [$id]))->with("error", "Please choose Access Control");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        $user = User::where([
                    ['role_id', '=', $id]
                ])->get();
        if (count($user) > 0) {
            return response()->json([
				"status" => 500,
				"error" => "Role is used"
			], 500);
        } else {
            AuthPermission::where([
                ['role_id', '=', $id]
            ])->get()->each(function ($permission, $key) {
                $permission->delete();
            });

            $model = AuthRole::find($id);
            $model->delete();
            return true;
        }
    }
}
