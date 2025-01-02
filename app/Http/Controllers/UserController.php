<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; 
use Barryvdh\DomPDF\Facade\Pdf; // Library untuk export PDF

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::all(); // Ambil semua data user
        return view('users.index', compact('users')); // Kirim ke view
    }

    // Menampilkan form untuk membuat user baru
    public function create()
    {
        return view('users.create');
    }

    // Menyimpan user baru ke database
    public function store(Request $request)
    {
        $request->validate([ // Validasi data input
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        // Membuat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Hash password untuk keamanan
            'role' => $request->role,
        ]);

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Menampilkan detail user berdasarkan ID
    public function show($id_user)
    {
        $user = User::findOrFail($id_user); // Cari user berdasarkan ID
        return view('users.show', compact('user'));
    }

    // Menampilkan form edit untuk user tertentu
    public function edit($id_user)
    {
        $user = User::findOrFail($id_user); // Cari user berdasarkan ID

        // Menyimpan URL sebelumnya untuk navigasi balik
        if (!session()->has('previous_url')) {
            session(['previous_url' => url()->previous()]);
        }

        return view('users.edit', compact('user'));
    }

    // Mengupdate data user di database
    public function update(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user); // Cari user berdasarkan ID

        $request->validate([ // Validasi data input
            'email' => "sometimes|required|email|unique:users,email,{$id_user},id_user",
            'username' => "sometimes|required|string|max:255|unique:users,username,{$id_user},id_user",
            'password' => 'sometimes|nullable|string|min:8', // Password tidak wajib, hanya jika diisi
            'role' => 'sometimes|required|string',
        ]);

        // Update data user
        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'username' => $request->username ?? $user->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role ?? $user->role,
        ]);

        // Menghapus URL sebelumnya dari session
        session()->forget('previous_url');

        // Redirect sesuai role user
        if (Auth::user()->role === 'admin') {
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } else {
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
        }
    }

    // Menghapus user dari database
    public function destroy($id_user)
    {
        $user = User::findOrFail($id_user); // Cari user berdasarkan ID
        $user->delete(); // Hapus user

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // Mengekspor daftar user ke dalam format PDF
    public function exportPdf()
    {
        $users = User::all(); // Ambil semua data user

        // Generate PDF dari view
        $pdf = Pdf::loadView('users.export-pdf', compact('users'));

        // Download file PDF
        return $pdf->download('users-list.pdf');
    }

    // Mengekspor daftar user ke dalam format CSV
    public function exportCsv()
    {
        $users = User::all(); // Ambil semua data user

        $filename = "users.csv";
        $handle = fopen($filename, 'w+'); // Membuka atau membuat file CSV

        // Menambahkan header kolom
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

        fclose($handle); // Tutup file setelah selesai

        // Download file CSV dan hapus setelah selesai di-download
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
