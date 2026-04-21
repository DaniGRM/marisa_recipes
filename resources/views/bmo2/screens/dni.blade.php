<link rel="stylesheet" href="{{ asset('css/bmo-card.css') }}">
    
<div class="bmo-screen justify-content-center" data-screen="dni">
    <div style="height: 100%; padding: 40px">
        <div class="bmo-dni-card-inner">
            <!-- Front de la tarjeta -->
            <div class="bmo-dni-face bmo-dni-front-face">
                @include('bmo2.card.front')
            </div>
            
            <!-- Back de la tarjeta -->
            <div class="bmo-dni-face bmo-dni-back-face">
                @include('bmo2.card.back')
            </div>
        </div>
    </div>
    
</div>