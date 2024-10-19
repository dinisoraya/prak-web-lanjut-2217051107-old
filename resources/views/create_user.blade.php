@extends('layouts.app')
@section('content')

<div>
    <div class="mb-3 mt-2 m-3">
        <a href="{{ route('user.list') }}" class="btn btn-success">List User</a>
    </div>
    <form class ="input" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="container mt-5">
            <h1 class="text-center">Input Data</h1>
            <div class="mb-3">
                <label for="nama">Nama :</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"><br>
                @error('nama')
                    <div style="color: red;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="npm">NPM :</label>
                <input type="text" id="npm" name="npm" value="{{ old('npm') }}"><br>
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
                        <option value="{{ $kelasItem->id }}" {{ old('kelas_id') == $kelasItem->id ? 'selected' : '' }}>
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

            <div>
                <label for="foto" class="form-label">Foto</label>
                <input type="file" id="foto" name="foto"><br><br>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
</div>

@endsection