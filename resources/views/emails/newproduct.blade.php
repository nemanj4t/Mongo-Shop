@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header')
            Header Title
        @endcomponent
    @endslot
{{-- Body --}}
    This is our main message 
{{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                Ok
            @endcomponent
        @endslot
    @endisset
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            Super FOOTER!
        @endcomponent
    @endslot
@endcomponent