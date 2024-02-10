@extends('admin.layout.main')

@section('content')
    @include('admin.layout.partial.alert')

    {!!Form::model($attributeGroup, ['method' => 'put', 'route' => ['admin.attribute-group.update', [$attributeGroup->attribute_group_id]]]) !!}

    @include('admin.attribute.attribute-group.form')

    {!! Form::close() !!}

    {!! Form::open(['method' => 'delete', 'route' => ['admin.attribute-group.destroy', ['attribute_group' => $attributeGroup->attribute_group_id]], 'id' => 'delete-form','style' => 'display: none']) !!}
    <button type="submit">Delete</button>
    {!! Form::close() !!}

    @push('scripts')

        <script type="text/javascript">
            $(function () {
                $('button#delete').on('click', function () {
                    if (confirm('Are you sure want to delete this attribute group?')) {
                        $("#delete-form").submit();
                    }
                });
            });
        </script>
    @endpush

@endsection
