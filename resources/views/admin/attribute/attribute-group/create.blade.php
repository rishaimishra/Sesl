@extends('admin.layout.main')

@section('content')
    @include('admin.layout.partial.alert')

    {!!Form::open(['route' => 'admin.attribute-group.store']) !!}


    @include('admin.attribute.attribute-group.form')
    {!! Form::close() !!}

@endsection
