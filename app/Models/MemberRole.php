<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRole extends Model
{
    use HasFactory;

    public const DESIGNER = 1;
    public const SUPERVISOR = 2;
    public const MANAGER = 3;
    public const OTHER = 4;
}
