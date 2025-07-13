<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    private string $appName;
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->appName = config('app.name');
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userProfileImage' => Storage::disk('s3')->url($this->appName . '/' . $this->profile_image_path),
            'userFirstName' => $this->first_name,
            'userLastName' => $this->last_name,
            'userEmail' => $this->email,
            'userAccountCreatedAt' => $this->created_at,
        ];
    }
}
