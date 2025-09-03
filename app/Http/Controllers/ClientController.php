<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;  
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
   public function index(Request $request)
{
    if ($request->expectsJson()) {
        return Client::all(); 
    }

    $clients = Client::all();
    return view('view-clients', compact('clients'));
}
    
    public function addForm()
    {
        return view('add-client');
    }

    // Store Client Data & check if email id already exists
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
    'first_name' => 'required|string|max:255',
    'last_name'  => 'required|string|max:255',
    'phone'      => 'required|string|max:15',
    'email'      => 'required|email|unique:clients,email',
    'remarks'    => 'nullable|string|max:200',
], [
    'email.unique' => 'This email is already registered.',
]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Client::create($request->only([
        'first_name',
        'last_name',
        'phone',
        'email',
        'remarks'
    ]));

       return redirect()->back()->with('client_added', true);
    }

    // Edit Client Data
    public function editForm($id)
    {
        $client = Client::findOrFail($id);
        return view('edit-client', compact('client'));
    }

    // Update Client Data
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:15',
            'email'      => 'required|email|unique:clients,email,' . $id,
            'remarks'    => 'nullable|string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client->update($request->all());

       return redirect()->back()->with('client_updated', true);

    }

   public function destroy($id)
{
    try {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json([
            'status' => 'success', 
            'message' => 'Client deleted successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => 'Failed to delete client'
        ], 500);
    }
}
}
