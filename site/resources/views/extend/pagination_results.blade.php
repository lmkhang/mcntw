@if($pagination->total() > 0)
    <div class="">
        Total records: {!! $pagination->total() !!} [{{ (($pagination->currentPage()-1)*$pagination->perPage())+1 }}
        ->{{ ((($pagination->currentPage()-1)*$pagination->perPage())+$pagination->count()) }}]
    </div>
@endif