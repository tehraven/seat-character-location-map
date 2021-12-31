@extends('web::layouts.grids.3-9')

@section('title', trans('characterlocationmap::global.browser_title'))
@section('page_header', trans('characterlocationmap::global.page_title'))
@section('page_description', trans('characterlocationmap::global.page_subtitle'))


@section('left')
@include('characterlocationmap::left', ['allRegions' => $allRegions, 'region' => $region, 'characters' => $characters])
@stop

@section('right')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $region->name }}</h3>
    </div>
    <div class="card-body" id='svgMap'></div>
</div>
@stop

@push('javascript')
<script>
    function htmlDecode(input) {
        var doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }

    var didInit = false;
    function init() {
        if (didInit) return;
        didInit = true;
        document.getElementById('legend').remove();
        document.getElementById('controls').remove();
        document.querySelectorAll("[id^=rect]").forEach(el => el.style.fill = 'white');
        setTimeout(function() {
            @foreach($characters as $character)
            try {
                if(!!document.querySelector("#rect{{ $character->location->solar_system->system_id }}")) {
                    document.querySelector("#rect{{ $character->location->solar_system->system_id }}").style.fill = 'gray';
                    document.querySelector("use#sys{{ $character->location->solar_system->system_id }}").innerHTML = '<title>{{ $character->name }} ({{ $character->user->main_character->name }})</title>';
                }
            } catch(e) {
                console.error(e);
            }        
            @endforeach
        }, 500);
    };

    var svg = document.getElementById('svgMap');
    svg.outerHTML = htmlDecode(`{{ $svg }}`);

    init();
</script>
@endpush