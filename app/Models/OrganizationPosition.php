<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'parent_id',
        'order_number',
        'organization_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order_number');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function members()
    {
        return $this->hasMany(OrganizationMember::class, 'organization_position_id');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Check if a position is an ancestor of another position (to prevent circular references)
     */
    public function isAncestorOf($positionId)
    {
        $current = $this->find($positionId);

        while ($current && $current->parent_id) {
            if ($current->parent_id == $this->id) {
                return true;
            }
            $current = $current->parent;
        }

        return false;
    }

    /**
     * Compute the depth/level of this position in the hierarchy
     */
    public function computeDepth()
    {
        $depth = 0;
        $current = $this;

        while ($current && $current->parent) {
            $depth++;
            $current = $current->parent;
        }

        return $depth;
    }
}