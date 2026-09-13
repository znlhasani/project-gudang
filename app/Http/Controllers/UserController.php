<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil keyword dari form search
        $keyword = $request->input('search');

        // Query User
        $users = User::when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', "%{$keyword}%")
                             ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->orderBy('id', 'desc') // urutkan dari id terbesar (terbaru) ke kecil
            ->paginate(10);

        // biar search tetap kebawa saat pagination
        $users->appends($request->all());

        return view('users.index', compact('users', 'keyword'));
    }


    public function makeUser($id)
    {
        $user = User::findOrFail($id);

        $user->role = 'user';    // turunkan jadi user
        $user->save();           // ✅ simpan ke database

        return redirect()->route('users.index')->with('success', $user->name . ' berhasil diturunkan menjadi user.');
    }

    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'admin';   // ubah role
        $user->save();

        return redirect()->back()->with('success', 'User berhasil dijadikan admin.');
    }

    public function demote($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'user';    // turunkan ke user
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diturunkan ke user.');
    }


}
