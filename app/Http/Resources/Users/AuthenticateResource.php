<?php

declare(strict_types=1);

namespace App\Http\Resources\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $accessToken
 * @property User $user
 */
class AuthenticateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->accessToken,
            'user' => new UserResource($this->user),
        ];
    }
}
