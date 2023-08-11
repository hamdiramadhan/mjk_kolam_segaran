@extends('layouts.app')

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-user"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">Edit User</h5>
            <form class="row g-3" method="POST" action="{{ route('users.update', encrypt($user->id)) }}">
                @csrf
                <div class="col-md-12">
                    <label for="Nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}"
                        placeholder="Masukkan Nama">
                </div>
                <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" value="{{ $user->email }}" name="email"
                        placeholder="Email">
                </div>

                <div class="col-md-12">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}"
                        placeholder="Username">
                </div>
                <div class="col-md-12">
                    <label for="role" class="form-label">Role</label>
                    <select id="role_id" name="role_id" class="form-control select22">
                        @foreach ($roles as $r)
                            @php $selected = ''; @endphp
                            @if ($r->id == $user->role_id)
                                @php $selected = 'selected'; @endphp
                            @endif
                            <option {!! $selected !!} value="{{ $r->id }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="no_hp" class="form-label">Nomor HP (WA)</label>
                    <input type="text" class="form-control" id="no_hp" value="{{ $user->no_hp }}" name="no_hp"
                        placeholder="Masukkan Nomor Whatsapp (62877129387)">
                    <span style="color: red">Untuk Notifikasi Whatsapp</span>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan Password">
                </div>
                <div class="col-md-12">
                    <label for="input6" class="form-label">Ulang Password</label>
                    <input type="password" name="re_password" class="form-control" id="re_password"
                        placeholder="Ulangi Password">
                </div>

                <div class="col-md-12">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select class="form-control select22" name="tahun" placeholder="Pilih Tahun" required="">
                        @php
                            $list_tahun = App\Models\Setting::get_tahun();
                        @endphp
                        @foreach ($list_tahun as $tahun)
                            <option {{ Auth::user()->tahun == $tahun ? 'selected' : '' }} value="{{ $tahun }}">
                                {{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="tahun" class="form-label">Opd</label>
                    <select class="form-control select22" name="opd_id" placeholder="Pilih OPD" required="">
                        <option value="">Pilih</option>
                        @foreach ($list_opd as $uk)
                            <option {{ $user->opd_id == $uk->id ? 'selected' : '' }} value="{{ $uk->id }}">
                                {{ $uk->unit_id }}
                                {{ $uk->unit_name }}</option>
                            @foreach ($uk->subOpd as $ukk)
                                <option {{ $user->opd_id == $ukk->id ? 'selected' : '' }} value="{{ $ukk->id }}">
                                    ---{{ $ukk->unit_id }}
                                    {{ $ukk->unit_name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="col-md-10">

                </div>
                <div class="col-md-2">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <a href="{{ route('users.index') }}" type="button" class="btn btn-danger px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
