@extends('admin.layout.edit')

<style>
    .cursor{
        cursor: pointer;
    }
    .show-tick{
        width: 100% !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if($addressArea->id)
        {!! Form::model($addressArea, ['route' => ['admin.address-section.update', $addressArea->id], 'method' => 'put', 'files' => true]) !!}
    @else
        {!! Form::open(['route' => 'admin.address-area.store', 'method' => 'post']) !!}
    @endif

    @if($addressArea->id)
        <input type="hidden" name="id" value="{{ $addressArea->id }}">
    @endif

    <h4>{{ $addressArea->id ? 'Edit'  : 'Create'}} Address Area</h4>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="header">
                    <h2>Area Details</h2>
                </div>
                <div class="body">
                    <div class="row">


                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::materialText('Name', 'name', old('name', ($addressArea->name)), $errors->first('ward_number')) !!}
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('chiefdoms', 'Chiefdoms') !!}
                                <select name="address_id" class="selectpicker" id="join_person">
                                    @foreach($area as $ckey => $chiefdom)
                                        <option class="A" id="{{$ckey}}" value="{{$chiefdom}}"
                                        >{{$chiefdom}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="col-sm-12">
                            <div class="form-group">
                                <button id="save" type="submit" class="btn btn-primary btn-lg waves-effect">{{($addressArea->id)?"Update":"Save"}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

@endsection


@push('scripts')

    <script src="{{ asset('admin/js/jquery.geocomplete.js') }}"></script>

    <script>



            jQuery(document).ready(function () {

                jQuery(".add-more").on('click', function () {
                    var objClone = jQuery(this).closest('.col-sm-12').clone(true, true);
                    //console.log(objClone.find("input:text").attr("name"));
                    //console.log(jQuery.type(objClone.find("input:text").attr("name")));
                    objClone.find("input:text").val("").prop('readonly',false);
                    objClone.find('.add-more').remove();
                    objClone.find('.remove-more').show();

                    jQuery(this).closest('.col-sm-12').after(objClone);
                });

                jQuery(".remove-more").on('click', function () {
                    jQuery(this).closest('.col-sm-12').remove();
                });


            });
    </script>


@endpush

