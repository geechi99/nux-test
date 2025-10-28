<?php

namespace App\Services;

use App\Models\Link;
use App\Models\PlayResult;
use App\Models\User;
use App\Services\Contracts\LinkServiceInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class LinkService implements LinkServiceInterface
{
    public function createForUser(User $user): Link
    {
        return Link::create([
            'user_id' => $user->id,
            'token' => Str::random(40),
            'active' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function regenerate(Link $link): Link
    {
        $link->update(['active' => false]);

        return Link::create([
            'user_id' => $link->user_id,
            'token' => Str::random(40),
            'active' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function deactivate(Link $link): void
    {
        $link->update(['active' => false]);
    }

    public function isValid(Link $link): bool
    {
        if (!$link->active) return false;
        if (!$link->expires_at) return false;

        $expires = $link->expires_at instanceof Carbon ? $link->expires_at : Carbon::parse($link->expires_at);
        return $expires->isFuture();
    }

    public function playLucky(Link $link): array
    {
        $random = random_int(1, 1000);
        $isWin = ($random % 2 === 0);

        if ($random > 900) {
            $percent = 0.7;
        } elseif ($random > 600) {
            $percent = 0.5;
        } elseif ($random > 300) {
            $percent = 0.3;
        } else {
            $percent = 0.1;
        }

        $amount = $isWin ? round($random * $percent, 2) : 0.00;

        $result = PlayResult::create([
            'link_id' => $link->id,
            'random_number' => $random,
            'win' => $isWin,
            'amount' => $amount,
        ]);

        return [
            'random' => $random,
            'win' => $isWin,
            'amount' => $amount,
            'result' => $result,
        ];
    }

    public function lastResults(Link $link, int $limit = 3): Collection
    {
        return $link->results()->orderBy('created_at', 'desc')->limit($limit)->get();
    }
}
