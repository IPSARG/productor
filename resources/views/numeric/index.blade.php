@extends('layouts.main')

@section('section-title', 'Normas') 

@push('scriptsHead')
    <script>
        $(function(){
            var sits = $('.sit_norm');
                norms = $('.prod_norm');
            $(sits).each(function(iSit,elSit){ 
                $(norms).each(function(iNorm,elNorm){ 
                    var sit = $(elSit).html().replace(/\s+/g, '');
                        norm = $(elNorm).html().replace(/\s+/g, '');
                    if(new String(sit).valueOf() == new String(norm).valueOf()){
                        $(elSit).parent().removeClass('bg-secondary').addClass('bg-success');
                    }
                });
            });
        })
    </script>
@endpush

@section('content')
    <div class="row my-4">
        <div class="col-md-7">
            <div class="row">
                <div class="col-12">
                    @include('numeric.modules.new_norm')
                </div>
                <div class="col-12 mt-4">
                    @include('numeric.modules.norm_type') 
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <div class="col-12">
                     @include('numeric.modules.posted_norms')
                </div>
                <div class="col-12 mt-4">
                    @include('numeric.modules.sit_norms')
                </div>
            </div>
        </div>
    </div>
    @include('numeric.modals.search_norm')
    @include('numeric.modals.search_norm_type')
@stop