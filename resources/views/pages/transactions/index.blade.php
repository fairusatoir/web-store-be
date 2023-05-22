@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>
                        Daftar Transaksi
                    </strong>
                </div>
                <div class="card-body card-block">
                    <div class="table-stats order-table ov-h">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Nomor</th>
                                    <th>Total Transaksi</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->transaction_total }}</td>
                                        <td>
                                            @if ($item->transaction_status === 'FAILED')
                                                <span class="badge badge-danger">
                                                @elseif($item->transaction_status === 'SUCCESS')
                                                    <span class="badge badge-info">
                                                    @elseif($item->transaction_status === 'PENDING')
                                                        <span class="badge badge-warning">
                                                        @else
                                                            <span>
                                            @endif

                                            {{ $item->transaction_status }}</span>
                                        </td>
                                        <td>
                                            {{-- @if ($item->transaction_status === 'PENDING')
                                                <a href="{{ route('transactions.status', ['transaction' => $item->id]) }}?status=SUCCESS"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <a href="{{ route('transactions.status', ['transaction' => $item->id]) }}?status=FAILED"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            @endif --}}
                                            <a href="#mymodal"
                                                data-remote={{ route('transactions.show', ['transaction' => $item->id]) }}
                                                data-toggle="modal" data-target="#mymodal"
                                                data-title="Detail Transaksi {{ $item->uuid }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href={{ route('products.edit', ['product' => $item->id]) }}
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action={{ route('products.destroy', ['product' => $item->id]) }}
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
                                        <td colspan="7" class="text-center p-5">
                                            Data tidak tersedia
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
