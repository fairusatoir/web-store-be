@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="box-title">{{ __('message.title.product.gallery') }} {{ $data->name }}</h4>
                </div>
                <div class="card-body--">
                    <div class="table-stats order-table ov-h">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name Barang</th>
                                    <th>Foto</th>
                                    <th>Default</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->galleries as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>
                                            <img src={{ url($item->photo) }} alt="">
                                        </td>
                                        <td>{{ $item->is_default ? 'Ya' : 'Tidak' }}</td>
                                        <td>
                                            <form
                                                action={{ route('product-galleries.destroy', ['product_gallery' => $item->id]) }}
                                                method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-5">
                                            {{ __('message.available') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
