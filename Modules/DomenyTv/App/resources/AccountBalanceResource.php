<?php

namespace Modules\DomenyTv\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
