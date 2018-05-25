<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatItemMessageItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'is_myself' => $this->is_myself,
            'creator' => $this->user->name,
            'created' => $this->created_at->diffForHumans(),
            'body' => $this->body,
        ];
    }
}
