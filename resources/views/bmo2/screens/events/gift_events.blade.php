<div class="bmo-screen" data-screen="gift_events">
    <div style="    height: 100%;
    display: flex;
    justify-content: space-evenly;
    align-items: center;">
        <input type="hidden" name="currentGift" id="currentGift" onchange="console.log('Gift changed, recalculating points...'); recalculatePointsForCurrentGift();">

        @foreach ($giftData as $gift)
            <div style="display: flex; flex-direction: column; justify-content: space-around; align-items: center; font-size: 3rem"
            class="gift" data-id="{{ $gift['gift_event']['id'] ?? $gift['id'] }}">
                <img style="width: 400px" src="/card/gift{{ $gift['gift_event']['id'] ?? $gift['id'] }}.png" alt="">
                {{ $gift['name'] ?? $gift['gift_event']['name'] }}
            </div>
        @endforeach
    </div>

    <div class="bmo-dni-close" style="right: 62px;top: 53px;">
        <img src="/card/cross.png" alt="Close Icon" onclick="bmoApp.loadScreen('tasks')">
    </div>
</div>
<script>
    document.querySelectorAll('.gift').forEach(gift => {
        gift.addEventListener('click', function () {

            const giftId = this.dataset.id;
            document.getElementById('currentGift').value = giftId;
            document.querySelectorAll('.gift-hints-wrapper').forEach(g => g.style.display = 'none');
            document.getElementById('gift' + giftId).style.display = 'flex';
            bmoApp.loadScreen('gift_events_hints');

        });
    });
    const currentGiftInput = document.getElementById('currentGift');

    const descriptor = Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value');
    Object.defineProperty(currentGiftInput, 'value', {
        set(newValue) {
            descriptor.set.call(this, newValue);
            recalculatePointsForCurrentGift();
        },
        get() {
            return descriptor.get.call(this);
        }
    });
    document.querySelectorAll('.hint').forEach(btn => {
        btn.addEventListener('click', function () {
            const type = this.dataset.type;
            const giftId = document.getElementById('currentGift').value;
            const userId = bmo.currentUser;
            btn.style.opacity = 0.5; // Marcar como usado inmediatamente
            fetch(`/gift/${giftId}/hint/${type}?userId=${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

        });
    });

    if (currentGiftInput) {
        currentGiftInput.addEventListener('change', () => {
            console.log('Gift changed, recalculating points...');
            recalculatePointsForCurrentGift();
        });
    }


</script>