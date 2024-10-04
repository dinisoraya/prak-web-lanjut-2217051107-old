@extends('layouts.app')

@section('content')

<div>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div>
            <label for="nama">Nama :</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}"><br>
            @error('nama')
                <div style="color: red;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div>
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
                \ @foreach ($kelas as $kelasItem)
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

        <button type="submit">Submit</button>
    </form>
</div>
@endsection