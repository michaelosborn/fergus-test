<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * @property string $label
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Business extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;
}
