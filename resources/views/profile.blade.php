@extends('layouts.app') 
@section('content')
<div class="card">
    <!-- <div class="img-bx">
            <img src="{{ asset('assets/img/diginigi.jpg') }}" alt="img" />
        </div> -->
    <div class="img-bx">
        <img src="{{ asset('upload/img/' . $user->foto) }}" alt="img" />
    </div>
    <div class="content"></div>
    <div class="detail">
        <h2>
            <div class="row">
                <span>Nama</span><span>: {{$user->nama}}</span>
            </div>
            <div class="row">
                <span>NPM</span><span>: {{$user->npm}}</span>
            </div>
            <div class="row">
                <span>Kelas</span><span>: {{$nama_kelas ?? 'Kelas tidak ditemukan' }}</span>
            </div>
        </h2>
    </div>
</div>
</div>
@endsection