<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\GiftEvent;
use App\Models\UserGiftEvent;
use Illuminate\Http\Request;

class GiftEventsController extends Controller
{
    public function useHint(Request $request, $giftId, $type)
    {
        $userGift = UserGiftEvent::firstOrCreate([
            'user_id' => $request->userId,
            'gift_event_id' => $giftId
        ]);

        $field = match ($type) {
            'text' => 'used_text',
            'image' => 'used_image',
            'sound' => 'used_sound',
        };

        $userGift->$field = true;
        $userGift->save();

        return response()->json(['ok' => true]);
    }

    public function complete(Request $request, $giftId)
    {
        $gift = GiftEvent::findOrFail($giftId);

        $userGift = UserGiftEvent::firstOrCreate([
            'user_id' => $request->userId,
            'gift_event_id' => $giftId
        ]);

        if ($userGift->completed) {
            return back(); // evitar duplicados
        }

        $points = $this->calculatePoints($gift, $userGift);

        $userGift->completed = true;
        $userGift->points_earned = $points;
        $userGift->save();

        $user = User::find($request->userId);
        $user->addPoints($points);

        return back()->with('success', '¡Regalo completado!');
    }

    public function calculatePoints($giftEvent, $userGift)
    {
        $usedHints = collect([
            $userGift->used_text,
            $userGift->used_image,
            $userGift->used_sound
        ])->filter()->count();

        return match ($usedHints) {
            0 => 30,
            1 => 20,
            2 => 15, // ajusto aquí, antes tenías duplicado 20
            default => 10,
        };
    }
}