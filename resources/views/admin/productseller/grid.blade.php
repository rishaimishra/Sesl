@section('grid-title')
    <h2> Products  Listing </h2>
@endsection

@section('grid-actions')
    <a href="{{ route('admin.product.create') }}" class="btn btn-sm btn-primary">Create New</a>
@endsection

@section('grid-content')
    <div class="body">
        {!! $grid !!}
    </div>
@endsection
