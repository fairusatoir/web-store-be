@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>
                        Tambah Foto barang
                    </strong>
                </div>
                <div class="card-body card-block">
                    <form action={{ route('product-galleries.store') }} method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-2">

                            <div class="form-group col-lg-6">
                                <label for="products_id" class="form-control-label">Nama barang</label>
                                <select name="products_id" class="form-control @error('products_id') is-invalid @enderror">
                                    @foreach ($products as $product)
                                        <option value={{ $product->id }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('products_id')
                                    <div class="text-muted">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="photo" class="form-control-label">Foto Barang</label>
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input form-control @error('photo') is-invalid @enderror"
                                        name="photo" id="customFile" accept="image/*" required>
                                    <label class="custom-file-label form-control-label" id="customFileLabel"
                                        for="customFile">Upload
                                        Foto</label>
                                    @error('photo')
                                        <div class="text-muted">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row mb-2">

                            <div class="form-group offset-lg-6 col-lg-6">
                                <div class="custom-control custom-checkbox @error('is_default') is-invalid @enderror">
                                    <input type="checkbox" name="is_default" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Jadikan Default</label>
                                    @error('is_default')
                                        <div class="text-muted">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit" onsubmit="return checkFoto()">
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
    <script>
        const customFileInput = document.getElementById('customFile');
        const customFileLabel = document.getElementById('customFileLabel');

        customFileInput.addEventListener('change', function() {
            const fileName = this.files[0].name;
            customFileLabel.textContent = fileName;
        });
    </script>
@endpush
