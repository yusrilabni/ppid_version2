<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lhkpn extends Model
{
    use HasFactory;

    protected $fillable = [
        'official_id',
        'organization_id',
        'position_id',
        'full_name',
        'report_year',
        'report_type',
        'report_date',
        'total_wealth',
        'file_path',
    ];

    /**
     * Get the official that owns the LHKPN.
     */
    public function official()
    {
        return $this->belongsTo(Official::class);
    }

    /**
     * Get the organization that owns the LHKPN.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the position that owns the LHKPN.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}