<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //User View Page
    public function index()
    {
        $users = User::where('status', 0)->paginate(5);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */

     //User view create page
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */

     //Execute User Create
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);


            if ($request->role == "administrator") {
                $user->assignRole("administrator");
            } else if ($request->role == "staff") {
                $user->assignRole("staff");
            } 

            return redirect()->back()->with('success', 'User created successfully');

        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

     //Execute User Update
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        if($request->password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->role == "administrator") {
            $user->syncRoles();
            $user->assignRole("administrator");
        } else if ($request->role == "staff") {
            $user->syncRoles();
            $user->assignRole("staff");
        } 

        return redirect()->back()->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */

     //Execute User Soft Delete
    public function destroy(User $user)
    {
        $user->update([
            'status' => 1,
        ]);
        return redirect()->back()->with('success', 'User deleted successfully');
    }


    //Execute Export Users
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
