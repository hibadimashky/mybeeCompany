<?php

namespace Modules\Product\Models\Transformers\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Product\Models\Transformers\ModifierClassResource;

class ModifierClassCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => ModifierClassResource::collection($this->collection),
        ];
    }
}
