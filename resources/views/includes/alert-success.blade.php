@if (session('suc'))
    <div class="alert alert-success" role="alert">
        {{ session('suc') }}
    </div>
@endif
