<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignType extends Model
{
    use HasFactory;

    public const ABUTMENT_EXTERNAL = 1;
    public const WING_EXTERNAL = 2;
    public const WING_EXTERNAL_LL = 3;
    public const ABUTMENT_INTERNAL = 4;
    public const WING_INTERNAL = 5;
}
