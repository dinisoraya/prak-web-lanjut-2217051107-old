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
    
    public function profile($nama = '', $kelas = '', $npm = '')
{
    $data = [
        'nama' => $nama,
        'kelas' => $kelas,
        'npm' => $npm
    ];

    return view('profile', $data);
}

public function create(){
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
    ], [
        'nama.required' => 'Nama tidak boleh kosong.',
        'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        'npm.required' => 'NPM tidak boleh kosong.',
        'npm.size' => 'NPM harus terdiri dari 10 digit.',
    ]);

    $user = UserModel::create($validatedData);

    $user->load('kelas');

    return view('profile', [
        'nama' => $user->nama,
        'npm' => $user->npm,
        'nama_kelas' => $user->kelas->nama_kelas ?? 'Kelas tidak ditemukan',
    ]);
}



}