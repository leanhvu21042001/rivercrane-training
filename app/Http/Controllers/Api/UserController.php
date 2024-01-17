<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', [User::class]);

        $perPage = $request->get('perPage') ?? 10;
        $name = $request->get('name');
        $email = $request->get('email');
        $role = $request->get('role');
        $status = $request->get('status');

        $users = User::notDelete()
            ->byName($name)
            ->byEmail($email)
            ->byRole($role)
            ->active($status)
            ->orderByDesc('created_at');

        $paginate = $users->paginate($perPage);

        return response()->json([
            'paginate' => $paginate
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', [User::class]);

        $name = $request->input('name');
        $email = $request->input('email');
        $role = $request->input('role');
        $status = $request->input('status');
        $password = $request->input('password');

        $created = User::create([
            'name' => $name,
            'email' => $email,
            'group_role' => $role,
            'is_active' => $status,
            'password' => $password,
        ]);

        return response()->json([
            'message' => "Created new user",
            'user' => $created,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', [User::class]);

        $user = User::where('id', '=', $id)->first();

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->authorize('update', [User::class]);

        $name = $request->input('name');
        $email = $request->input('email');
        $role = $request->input('role');
        $status = $request->input('status');
        $password = $request->input('password');

        $newRecord = array_filter(
            [
                'name' => $name,
                'email' => $email,
                'group_role' => $role,
                'is_active' => $status,
                'password' => $password ? bcrypt($password) : '',
            ],
            'strlen'
        );

        $updated = User::where('id', '=', $id)->update($newRecord);

        return response()->json([
            'message' => "Updated user",
            'user' => $updated,
        ]);
    }

    /**
     * Set is_delete = true from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // Truyền $id vào để kiểm tra.
        $this->authorize('delete', [User::class]);

        if ((int)$id === (int)Auth::user()->id) {
            return response()->json([
                'message' => "Can not delete",
            ], 403);
        }

        $deleted = User::where('id', '=', $id)->update([
            'is_delete' => 1,
            'remember_token' => '',
        ]);

        return response()->json([
            'message' => "Deleted user",
            'user' => $deleted,
        ]);
    }
}
