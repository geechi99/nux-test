<?php
namespace App\Services\Contracts;

use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Collection;

interface LinkServiceInterface
{
    public function createForUser(User $user): Link;
    public function regenerate(Link $link): Link;
    public function deactivate(Link $link): void;
    public function isValid(Link $link): bool;
    public function playLucky(Link $link): array;
    public function lastResults(Link $link, int $limit = 3): Collection;
}
