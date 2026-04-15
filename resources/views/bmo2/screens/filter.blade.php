    <div class="bmo-screen" data-screen="filter">
    @include('bmo2.components.header')
    <div class="row">
        @foreach($rooms as $room )
            <div class="col-3 p-4">
                <div class="filter-item text-center" onclick="bmoApp.setFilterRoom('{!! $room->name !!}')" data-sroom="{{ $room->name }}">
                    <!-- <h1 class="w-100">{{ $room }}</h1> -->
                    <img src="{{ $room->icon_path }}" alt="" style="height: 20vw;">
                </div>
            </div>
        @endforeach
    </div>  
</div>