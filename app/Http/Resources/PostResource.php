<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [ 
            'uuid' => $this->uuid,
            'image' => asset('storage/'. $this->image),
            'auther' => $this->whenLoaded('user'),
            'description' => $this->description,
            'date' => Carbon::parse($this->created_at)->diffForHumans(),
            'total_likers' => $this->likers->count(),
            'latest_likers' =>  $this->latest_likers->pluck('name'),
        ];
    }
}
