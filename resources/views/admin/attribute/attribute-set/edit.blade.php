@extends('admin.layout.main')

@section('content')
    @include('admin.layout.partial.alert')

    {!!Form::model($attributeSet, ['method' => 'put', 'route' => ['admin.attribute-set.update', [$attributeSet->attribute_set_id]]]) !!}

    @include('admin.attribute.attribute-set.form')

    {!! Form::close() !!}

    {!! Form::open(['method' => 'delete', 'route' => ['admin.attribute-set.destroy', ['attribute_set' => $attributeSet->attribute_set_id]], 'id' => 'delete-form','style' => 'display: none']) !!}
    <button type="submit">Delete</button>
    {!! Form::close() !!}

    @push('scripts')

        <script type="text/javascript">
            $(function () {
                $('button#delete').on('click', function () {
                    if (confirm('Are you sure want to delete this attribute set?')) {
                        $("#delete-form").submit();
                    }
                });
            });
        </script>
    @endpush

@endsection
