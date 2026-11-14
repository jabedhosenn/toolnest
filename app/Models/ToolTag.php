<?php

namespace App\Models;

use Database\Factories\ToolTagFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['tool_id', 'name', 'slug'])]
class ToolTag extends Model
{
    /** @use HasFactory<ToolTagFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Tool, $this>
     */
    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }
}
