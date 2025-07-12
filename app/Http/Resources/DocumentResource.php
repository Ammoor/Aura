<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    private string $appName;
    public function __construct()
    {
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
            'documentName' => $this->name,
            'document' => Storage::disk('s3')->url($this->appName . $this->local_path)
        ];
    }
}
