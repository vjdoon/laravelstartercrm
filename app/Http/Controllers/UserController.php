<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
{
    $users = User::all();
    return view('view-users', compact('users'));
}

 public function addForm()
    {
        return view('add-user');
    }

 public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:50|unique:users,username',
        'password' => 'required|string|min:5|max:255',
        'usertype' => 'required|string|in:admin,user',
    ], [
        'username.unique' => 'This username is already registered.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    User::create([
        'username'  => $request->username,
        'password'  => Hash::make($request->password),
        'usertype' => $request->usertype,
    ]);

    return redirect()->back()->with('success', 'User added successfully!');
}
public function checkUsername(Request $request)
{
    $exists = User::where('username', $request->username)->exists();
    return response()->json(['available' => !$exists]);
}

/*public function editForm($id)
    {
        $user = User::findOrFail($id);
        return view('edit-user', compact('user'));
    }

    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'usertype' => 'required|string|in:admin,user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update($request->all());

        return redirect()->back()->with('user_updated', true);
    }*/

public function destroy($id)
{
    // Prevent deletion of user with ID 1
    if ($id == 1) {
        return response()->json(['status' => 'error', 'message' => 'User with ID 1 cannot be deleted'], 400);
    }
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['status' => 'success', 'message' => 'User deleted']);
}
}