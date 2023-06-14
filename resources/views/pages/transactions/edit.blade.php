@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <small>
                        {{__('message.title.transaction.update')}}
                    </small>
                    <strong>{{ $data->uuid }}</strong>
                </div>
                <div class="card-body card-block">
                    <form action={{ route('transactions.update', $data->id) }} method="post">
                        @method('PUT')
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label">Nama Pemesang</label>
                                <input type="text" name="name" value="{{ old('name') ?? $data->name }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="email" class="form-control-label">Email</label>
                                <input type="text" name="email" value="{{ old('email') ?? $data->email }}"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="number" class="form-control-label">Nomor Kontak</label>
                                <div class="input-group mb-3">
                                    {{-- <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"></span>
                                    </div> --}}
                                    <input type="text" name="number" value="{{ old('number') ?? $data->number }}"
                                        class="form-control @error('number') is-invalid @enderror">
                                </div>
                                @error('number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="address" class="form-control-label">Alamat Pemesang</label>
                                <input type="text" name="address" value="{{ old('address') ?? $data->address }}"
                                    class="form-control @error('address') is-invalid @enderror">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">
                                Ubah Data Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
