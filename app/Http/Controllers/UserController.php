<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $perPage = $request->get('perPage') ?? 10;
            $name = $request->get('name') ?? '';
            $email = $request->get('email') ?? '';
            // $role = $request->get('role') ?? '';
            $status = $request->get('status') ?? '';

            $users = User::where('is_delete', 0)
                ->orderByDesc('created_at');

            // Handle Filter, Search
            if (!empty($name)) {
                $users->where('name', 'LIKE', "%$name%");
            }
            if (!empty($email)) {
                $users->where('email', 'LIKE', "%$email%");
            }
            // if (!empty($role)) {
            //     $users->where('role', 'LIKE', "%$role%");
            // }
            if (isset($status) && $status !== '') {
                $users->where('is_active', '=', $status);
            }

            $paginate = $users->paginate($perPage);
            $paginate->getCollection()->transform(function ($user) {
                $user->active_text = $user->is_active ? 'Đang hoạt động' : 'Tạm khóa';
                return $user;
            });

            return response()->json([
                'paginate' => $paginate
            ]);
        }
        return view('admin.pages.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $role = $request->input('role');
        $status = $request->input('status');
        $password = $request->input('password');

        $created = User::create([
            'name' => $name,
            'email' => $email,
            // 'role' => $role,
            'is_active' => $status,
            'password' => $password,
        ]);

        return response()->json([
            'message' => "Created new user",
            'user' => $created,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $name = $request->input('name');
        $email = $request->input('email');
        $role = $request->input('role');
        $status = $request->input('status');
        $password = $request->input('password');

        $newRecord = array_filter(
            [
                'name' => $name,
                'email' => $email,
                // 'role' => $role,
                'is_active' => $status,
                'password' => $password,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
