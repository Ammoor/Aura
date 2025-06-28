<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userProfileImage' => Storage::disk('s3')->url($this->profile_image_path),
            'userFirstName' => $this->first_name,
            'userLastName' => $this->last_name,
            'userEmail' => $this->email,
            'userAccountCreatedAt' => $this->created_at,
        ];
    }
}
