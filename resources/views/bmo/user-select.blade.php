<div id="user-select" class="screen">
    <div class="row">
        @foreach ($users as $user)
        <div class="col-6" onclick="setUser({{ $user->id }})">
                @if($user->id == 1)
                <img src="bmo.png" class="w-100">
            @else
                <img src="bma.png" class="w-100">
            @endif
            {{ $user->name }}
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    
</script>
@endpush