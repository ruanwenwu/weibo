@foreach(['success','danger','warning','info'] as $type)
    @if(session()->has($type))
        <div class="flash-message">
            <p class="alert alert-{{ $type }}">
                {{session()->get($type)}}
            </p>
        </div>
    @endif
@endforeach