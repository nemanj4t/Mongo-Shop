@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-2">
            @if(isset($subCategories))
                <categories :category="{{ $category }}" :max-price="{{ $maxPrice }}"
                            :sub-categories="{{ $subCategories }}"
                            :products="{{ $products }}">
                </categories>
            @elseif(isset($filters))
                <categories :category="{{ $category }}" :max-price="{{ $maxPrice }}"
                            :filters="{{ json_encode($filters) }}"
                            :products="{{ $products }}">
                </categories>
            @endif

        </div>
        <div class="col-10">
            <products category_name="{{$category->name}}"></products>
        </div>
    </div>
@endsection
