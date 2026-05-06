<div class="bmo-screen" data-screen="filter">
    <div class="row" style="padding-bottom: 100px;">
        @foreach($rooms as $room )
            <div class="col-3 p-4" style="--i: {{ $loop->index }}">
                <div class="filter-item text-center" onclick="bmoApp.setFilterRoom('{!! $room->name !!}')" data-sroom="{{ $room->name }}">
                    <!-- <h1 class="w-100">{{ $room }}</h1> -->
                    <img src="{{ $room->icon_path }}" alt="" style="height: 20vw;">
                </div>
            </div>
        @endforeach
    </div>  
</div>