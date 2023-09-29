<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\role;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Datauser = User::paginate(6);
        return view('admin.user.index')->with([
            'user' => $Datauser,
            'title' => 'data user'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return view('admin.user.edit')->with([
            'userData' => user::find($id),
            'title' => 'update user',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'saldo' => 'required'
        ]);

        $user = user::findOrFail($id);
        $user->name = $request->name;
        $user->saldo = $request->saldo;

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Data berhasil di update');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user_id = user::findOrFail($id);
        $user_id->delete();
        return back()->with('succes', 'Data berhasil di hapus');
    }
}
