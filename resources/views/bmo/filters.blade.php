<div class="filters row w-100 p-5">
    @php
        $i = 0;
    @endphp
    <div class="col-12">
        <div class="row d-flex justify-content-end">
            <div class="col-3 d-flex justify-content-end">
                <button class="w-100 filter-item" style="font-size: 2.5rem" onclick="hideFilters()">Volver</button>
            </div>
        </div>
    </div>
    @foreach($rooms as $room )
        <div class="col-3 p-4">
            <div class="filter-item" onclick="setFilterRoom('{!! $room !!}')" data-sroom="{{ $room }}">
                <!-- <h1 class="w-100">{{ $room }}</h1> -->
                @if($i % 2 == 0)
                    <img src="icons/washin.png" alt="" style="height: 15vw;">
                @else
                    <img src="icons/bed.png" alt="" style="height: 15vw;">
                @endif
                <h3 class="pt-4">{{ $room }}</h2>
            </div>
        </div>
        @php
            $i++;
        @endphp
    @endforeach
</div>