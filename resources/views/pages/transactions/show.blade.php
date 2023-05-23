<table class="table table-bordered">
    <tr>
        <th>Nama</th>
        <td>{{ $data->name }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $data->email }}</td>
    </tr>
    <tr>
        <th>Nomor</th>
        <td>{{ $data->number }}</td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td>{{ $data->address }}</td>
    </tr>
    <tr>
        <th>Total Transaksi</th>
        <td>{{ $data->transaction_total }}</td>
    </tr>
    <tr>
        <th>Status Transaksi</th>
        <td>
            @if ($data->transaction_status === 'FAILED')
                <span class="badge badge-danger">
            @elseif($data->transaction_status === 'SUCCESS')
                <span class="badge badge-info">
            @elseif($data->transaction_status === 'PENDING')
                <span class="badge badge-primary">
            @else
                <span>
            @endif

            {{ $data->transaction_status }}</span>
        </td>
    </tr>
    <tr>
        <th>Pembelian Produk</th>
        <td>
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                </tr>
                @foreach ($data->details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->product->type }}</td>
                        <td>{{ $detail->product->price }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>

<div class="row">
    <div class="col-4">
        <a href="{{ route('transactions.set-status', ['transaction' => $data->id]) }}?status=SUCCESS"
            class="btn btn-success btn-block">
            <i class="fa fa-check"></i> Set Success
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('transactions.set-status', ['transaction' => $data->id]) }}?status=PENDING"
            class="btn btn-warning btn-block">
            <i class="fa fa-spinner"></i> Set Pending
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('transactions.set-status', ['transaction' => $data->id]) }}?status=FAILED"
            class="btn btn-danger btn-block">
            <i class="fa fa-times"></i> Set Failed
        </a>
    </div>
</div>
