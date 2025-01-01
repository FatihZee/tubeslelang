<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show($id_user)
    {
        $user = User::findOrFail($id_user);
        return view('users.show', compact('user'));
    }

    public function edit($id_user)
    {
        $user = User::findOrFail($id_user);

        if (!session()->has('previous_url')) {
            session(['previous_url' => url()->previous()]);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);

        $request->validate([
            'email' => "sometimes|required|email|unique:users,email,{$id_user},id_user",
            'username' => "sometimes|required|string|max:255|unique:users,username,{$id_user},id_user",
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $id_user . ',id_user',
            'password' => 'sometimes|nullable|string|min:8',
            'role' => 'sometimes|required|string',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'username' => $request->username ?? $user->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role ?? $user->role,
        ]);

        session()->forget('previous_url');

        if (Auth::user()->role === 'admin') {
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } else {
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
        }
    }

    public function destroy($id_user)
    {
        $user = User::findOrFail($id_user);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function exportPdf()
    {
        $users = User::all(); // Mengambil semua data users

        $pdf = Pdf::loadView('users.export-pdf', compact('users'));

        return $pdf->download('users-list.pdf');
    }
    public function exportCsv()
{
    $users = User::all(); // Mengambil semua data users

    $filename = "users.csv";
    $handle = fopen($filename, 'w+'); // Membuka atau membuat file CSV

    // Tambahkan header kolom
    fputcsv($handle, ['Name', 'Email', 'Username', 'Role']);

    // Isi data pengguna ke dalam file CSV
    foreach ($users as $user) {
        fputcsv($handle, [
            $user->name,
            $user->email,
            $user->username,
            $user->role,
        ]);
    }

    fclose($handle); // Tutup file CSV setelah selesai

    // Download file CSV dan hapus setelah selesai di-download
    return response()->download($filename)->deleteFileAfterSend(true);
}

}