@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>
                        {{ __('message.title.product.create') }}
                    </strong>
                </div>
                <div class="card-body card-block">
                    <form action={{ route('products.store') }} method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label">Nama barang</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="type" class="form-control-label">Tipe barang</label>
                                <input type="text" name="type" value="{{ old('type') }}"
                                    class="form-control @error('type') is-invalid @enderror">
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Deskirpsi barang</label>
                            <textarea name="description" id="" cols="30" rows="10"
                                class="form-control ckeditor @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="price" class="form-control-label">Harga barang</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="number" name="price" value="{{ old('price') }}"
                                        class="form-control @error('price') is-invalid @enderror">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="quantity" class="form-control-label">Kwantitas barang</label>
                                <input type="number" name="quantity" value="{{ old('quantity') }}"
                                    class="form-control @error('quantity') is-invalid @enderror">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">
                                Tambah barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('afterjs')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('.ckeditor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
