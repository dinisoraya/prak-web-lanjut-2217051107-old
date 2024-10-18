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
            $foto->move(public_path('upload/img'), $fotoPath);
        } else {
            $fotoPath = null;
        }

        $this->userModel->create([
            'nama' => $request->input('nama'),
            'npm' => $request->input('npm'),
            'kelas_id' => $request->input('kelas_id'),
            'foto' => $fotoPath,
        ]);

        return redirect()->to('/user/list')->with('success', 'User berhasil ditambahkan');
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
        // Update data user lainnya
        $user->nama = $request->nama;
        $user->npm = $request->npm;
        $user->kelas_id = $request->kelas_id;
        // Cek apakah ada file foto yang di-upload
        if ($request->hasFile('foto')) {
            // Ambil nama file foto lama dari database
            $oldFilename = $user->foto;
            // Hapus foto lama jika ada
            if ($oldFilename) {
                $oldFilePath = public_path('upload/img/' . $oldFilename);
                // Cek apakah file lama ada dan hapus
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Hapus foto lama dari folder
                }
            }
            // Simpan file baru dengan storeAs
            // Simpan file baru dengan storeAs ke public/upload/img
            $file = $request->file('foto');
            $newFilename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/img'), $newFilename); // Menyimpan file ke public/upload/img
// Update nama file di database
            $user->foto = $newFilename;

        }
        // Simpan perubahan pada user
        $user->save();
        return redirect()->route('user.list')->with('success', 'User Berhasil di Update');
    }
    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();
        return redirect()->to('/user/list')->with('success', 'User Berhasil di Hapus');
    }

    // public function show($id)
    // {
    //     $user = $this->userModel->getUser($id);
    //     $data = [
    //         'title' => 'Profile',
    //         'user' => $user,
    //     ];

    //     return view('profile', $data);
    // }

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