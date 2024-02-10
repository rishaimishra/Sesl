@extends('admin.layout.main')

@section('content')
    @include('admin.layout.partial.alert')

    {!!Form::open(['route' => 'admin.attribute.store']) !!}


    @include('admin.attribute.attribute.form')
    {!! Form::close() !!}

@endsection
