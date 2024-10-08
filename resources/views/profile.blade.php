@extends('layouts.app2')
@section('container')
    <div class="card">
        <div class="img-bx">
            <img src="{{ asset('assets/img/diginigi.jpg') }}" alt="img" />
        </div>
        <div class="content">
            <div class="detail">
                <h2>
                    <div class="row">
                        <span>Nama</span><span>: <?= $nama ?></span>
                    </div>
                    <div class="row">
                        <span>NPM</span><span>: <?= $npm ?></span>
                    </div>
                    <div class="row">
                        <span>Kelas</span><span>: <?= $nama_kelas ?? 'Kelas tidak ditemukan' ?></span>
                    </div>
                </h2>
            </div>
        </div>
    </div>
@endsection