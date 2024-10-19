<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\UserModel;

class UserController extends Controller
{
    public $userModel;
    public $kelasModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->kelasModel = new Kelas();
    }

    //     public function profile($nama = '', $kelas = '', $npm = '')
// {
//     $data = [
//         'nama' => $nama,
//         'kelas' => $kelas,
//         'npm' => $npm
//     ];

    //     return view('profile', $data);
// }

    public function index()
    {
        $data = [
            'title' => 'List User',
            'users' => $this->userModel->getUser(),
        ];

        return view('list_user', $data);
    }

    public function create()
    {
        $kelasModel = new Kelas();

        $kelas = $kelasModel->getKelas();

        $data = [
            'title' => 'Create User',
            'kelas' => $kelas,
        ];

        return view('create_user', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'npm' => 'required|string|size:10',
            'kelas_id' => 'required|exists:kelas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'npm.required' => 'NPM tidak boleh kosong.',
            'npm.size' => 'NPM harus terdiri dari 10 digit.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = time() . '_' . $foto->getClientOriginalName();
            // $foto->move(public_path('upload/img'), $fotoPath);
            $foto->storeAs('uploads', $fotoPath); 
        } else {
            $fotoPath = null;
        }

        $this->userModel->create([
            'nama' => $request->input('nama'),
            'npm' => $request->input('npm'),
            'kelas_id' => $request->input('kelas_id'),
            'foto' => $fotoPath,
        ]);

        return redirect()->to('/')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $kelasModel = new Kelas();
        $kelas = $kelasModel->getKelas();
        $title = 'Edit User';
        return view('edit_user', compact('user', 'kelas', 'title'));
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);
        $user->nama = $request->nama;
        $user->npm = $request->npm;
        $user->kelas_id = $request->kelas_id;
        if ($request->hasFile('foto')) {
            $oldFilename = $user->foto;
            if ($oldFilename) {
                $oldFilePath = public_path('storage/uploads/' . $oldFilename);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); 
                }
            }
            $file = $request->file('foto');
            $newFilename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $newFilename, 'public');
            $user->foto = $newFilename;

        }
        $user->save();
        return redirect()->route('user.list')->with('success', 'User Berhasil di Update');
    }
    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();
        return redirect()->to('/')->with('success', 'User Berhasil di Hapus');
    }

    public function show($id){
        $user = UserModel::findOrFail($id);
        $kelas = Kelas::find($user->kelas_id); // Jika ingin menampilkan nama kelas
        return view('profile', [
            'title' => 'Profile',
            'user' => $user,
            'nama_kelas' => $kelas ? $kelas->nama_kelas : null, // Pastikan nama kelas ada, jika tidak tampilkan null
        ]);
    }
}