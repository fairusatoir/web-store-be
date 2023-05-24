@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>
                        Ubah Barang
                    </strong>
                    <small>{{ $item->name }}</small>
                </div>
                <div class="card-body card-block">
                    <form action={{ route('products.update', $item->id) }} method="post">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name" class="form-control-label">Nama barang</label>
                                <input type="text" name="name" value="{{ old('name') ?? $item->name }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="text-muted">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="type" class="form-control-label">Tipe barang</label>
                                <input type="text" name="type" value="{{ old('type') ?? $item->type }}"
                                    class="form-control @error('type') is-invalid @enderror">
                                @error('type')
                                    <div class="text-muted">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Deskirpsi barang</label>
                            <textarea name="description" id="" cols="30" rows="10"
                                class="form-control ckeditor @error('description') is-invalid @enderror">{{ old('description') ?? $item->description }}</textarea>
                            @error('description')
                                <div class="text-muted">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="price" class="form-control-label">Harga barang</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="number" name="price" value="{{ old('price') ?? $item->price }}"
                                        class="form-control @error('price') is-invalid @enderror">
                                </div>
                                @error('price')
                                    <div class="text-muted">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="quantity" class="form-control-label">Kwantitas barang</label>
                                <input type="number" name="quantity" value="{{ old('quantity') ?? $item->quantity }}"
                                    class="form-control @error('quantity') is-invalid @enderror">
                                @error('quantity')
                                    <div class="text-muted">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">
                                Ubah barang
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
