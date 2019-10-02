@if($feedData->count()>0)
    <ul class="list-unstyled">
    @foreach($feedData as $fk => $status)
        @include('statuses._status',  ['user' => $status->user])
    @endforeach
    </ul>
    <div class="mt-5">
        {!! $feedData->render() !!}
    </div>
@endif