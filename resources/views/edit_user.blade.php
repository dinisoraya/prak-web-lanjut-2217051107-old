@extends('layouts.app')

@section('content')

<div>
    <div class="mb-3 mt-2 m-3">
        <a href="{{ route('user.list') }}" class="btn btn-success">List User</a>
    </div>
    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container mt-5">
            <h1 class="text-center">Edit Data</h1>
            <div class="mb-3">
                <label for="nama">Nama :</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}"><br>
                @error('nama')
                    <div style="color: red;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="npm">NPM :</label>
                <input type="text" id="npm" name="npm" value="{{ old('nama', $user->npm) }}"><br>
                @error('npm')
                    <div style="color: red;">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <label for="kelas">Kelas :</label>
                <select name="kelas_id" id="kelas_id">
                    @foreach ($kelas as $kelasItem)
                        <option value="{{ $kelasItem->id }}" {{ $kelasItem->id == $user->kelas_id ? 'selected' : '' }}>
                            {{ $kelasItem->nama_kelas }}
                        </option>
                    @endforeach
                </select><br>
                @error('kelas_id')
                    <div style="color: red;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input class="form-control" type="file" id="foto" name="foto">
                @if ($user->foto)
                    <img src="{{ asset('upload/img/' . $user->foto) }}" alt="Foto User" width="100">
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route(name: 'user.list') }}" class="btn btn-danger">Kembali</a>
    </form>
</div>