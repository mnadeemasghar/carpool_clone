@extends('layouts.website')

@section('content')
<div class="card shadow mb-5 border-0">
    <div class="card-header bg-primary text-white p-4">
        <h3 class="card-title m-0">{!! $page !!}</h3>
    </div>
    <div class="card-body p-5">
        {!! $content !!}
    </div>
</div>
@endsection
