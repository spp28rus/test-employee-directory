<?php

namespace App\Http\Resources;

use App\Models\Skill;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var Skill
         */
        $skill = $this;

        return [
            'id' => $skill->id,
            'title' => $skill->title,
        ];
    }
}
