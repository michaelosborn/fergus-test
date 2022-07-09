<?php

namespace App\Models;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @property int $id
 * @property string $label
 * @property string $description
 * @property JobStatus $status
 * @property int $business_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Job extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable, SoftDeletes;

    protected $casts = [
        'status' => JobStatus::class,
        'created_at' => 'datetime:d M Y',
        'updated_at' => 'datetime:d M Y',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JobContact::class);
    }

    /**
     * Get all of the notes for the job.
     */
    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JobNote::class);
    }
}
