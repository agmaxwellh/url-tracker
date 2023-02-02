<?php

namespace KaanTanis\UrlTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlTrackerTable extends Model
{
    use HasFactory;

    protected $table = 'url_tracker_table';
    protected $guarded = [];

    public function trackerLog(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UrlTrackerLogTable::class, 'url_tracker_table_id');
    }
}
