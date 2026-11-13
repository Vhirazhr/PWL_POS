@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Profil Saya</h3>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Mode Tampilan Profil --}}
        @if ($user->nama && !request()->routeIs('profile.edit'))
            <div class="row">
                <div class="col-md-4 text-center">
                    @php
                        $imageUrl = $user->image ?: asset('adminlte/dist/img/avatar.png');
                    @endphp

                    <img
                        src="{{ $imageUrl }}"
                        alt="Foto profil {{ $user->nama }}"
                        width="120"
                        height="120"
                        class="rounded-circle img-thumbnail mb-2"
                        style="object-fit: cover;"
                        loading="lazy"
                        onerror="this.onerror=null;this.src='{{ asset('adminlte/dist/img/avatar.png') }}';"
                    >
                    <form action="{{ route('profile.edit') }}" method="GET">
                        <button class="btn btn-warning btn-sm mt-2">Ubah Profil</button>
                    </form>
                </div>

                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th>Username</th>
                            <td>: {{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>: {{ $user->nama }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>: {{ $user->level->level_nama ?? 'Pengguna' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        {{-- Mode Edit Profil --}}
        @elseif (request()->routeIs('profile.edit'))
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                    @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Foto Profil</label><br>
                    @php
                        $imagePreview = $user->image ?: asset('adminlte/dist/img/avatar.png');
                    @endphp

                    <img
                        src="{{ $imagePreview }}"
                        alt="Pratinjau foto profil"
                        width="100"
                        height="100"
                        class="rounded-circle img-thumbnail mb-2"
                        style="object-fit: cover;"
                        onerror="this.onerror=null;this.src='{{ asset('adminlte/dist/img/avatar.png') }}';"
                    >
                    <input type="file" name="image" class="form-control-file">
                    <small class="text-muted">Format: jpg, jpeg, png. Maks: 1MB</small>
                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('profile') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>

        {{-- Jika belum ada data --}}
        @else
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                    @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Foto Profil</label><br>
                    <input type="file" name="image" class="form-control-file">
                    <small class="text-muted">Format: jpg, jpeg, png. Maks: 1MB</small>
                    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-success">Simpan Profil</button>
            </form>
        @endif
    </div>
</div>
@endsection
