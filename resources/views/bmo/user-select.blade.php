<div id="user-select" class="screen">
    <div class="row pb-3 d-flex justify-content-center">
        <img src="choosefighter.png" style="width: 80%">
    </div>
    <div class="row">
        @foreach ($users as $user)
        <div class="col-6" onclick="setUser({{ $user->id }})">
            @if($user->id == 1)
                <img src="bmo-card.png" class="w-100">
            @else
                <img src="bma-card.png" class="w-100">
            @endif
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    
</script>
@endpush