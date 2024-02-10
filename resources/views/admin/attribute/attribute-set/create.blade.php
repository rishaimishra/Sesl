@extends('admin.layout.main')

@section('content')
    @include('admin.layout.partial.alert')

    {!!Form::open(['route' => 'admin.attribute-set.store']) !!}


    @include('admin.attribute.attribute-set.form')
    {!! Form::close() !!}

@endsection
