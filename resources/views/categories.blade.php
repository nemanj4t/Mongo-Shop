@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-2">
            <categories :category="{{ $category }}"></categories>
        </div>
        <div class="col-10">
            <products category_name="{{$category->name}}"></products>
        </div>
    </div>
@endsection
