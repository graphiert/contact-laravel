<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "username" => $this->username,
            "phone" => $this->phone,
            "email" => $this->email ??= null,
            "gender" => $this->gender,
            "profile" => isset($this->profile) ? Storage::url($this->profile) : null,
        ];
    }
}
