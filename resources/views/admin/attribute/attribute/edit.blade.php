@extends('admin.layout.main')

@section('content')
    @include('admin.layout.partial.alert')

    {!!Form::model($attribute, ['method' => 'put', 'route' => ['admin.attribute.update', [$attribute->attribute_id]]]) !!}

    @include('admin.attribute.attribute.form')

    {!! Form::close() !!}

    @isset($attribute)
        {!! Form::open(['method' => 'delete', 'route' => ['admin.attribute.destroy', ['attribute' => $attribute->attribute_id]], 'id' => 'delete-form','style' => 'display: none']) !!}
        <button type="submit">Delete</button>
        {!! Form::close() !!}
    @endisset

    @push('scripts')

        <script type="text/javascript">
            $(function () {
                $('button#delete').on('click', function () {
                    if (confirm('Are you sure want to delete this attribute?')) {
                        $("#delete-form").submit();
                    }
                });
            });
        </script>
    @endpush

@endsection
