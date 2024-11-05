<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    // protected function getDateFromTabAttribute()
    // {
    //     return Carbon::createFromFormat(config('app.date_input_format'), $this->date_from)->translatedFormat(config('app.date_format_month'));
    // }

    // protected function getDateToTabAttribute()
    // {
    //     return Carbon::createFromFormat(config('app.date_input_format'), $this->date_to)->translatedFormat(config('app.date_format_month'));
    // }
    protected function getDateFromTabAttribute()
    {
        return Carbon::createFromFormat(config('app.date_input_format'), $this->date_from)->format(config('app.date_format_id'));
    }

    protected function getDateToTabAttribute()
    {
        return Carbon::createFromFormat(config('app.date_input_format'), $this->date_to)->format(config('app.date_format_id'));
    }

    protected function getNameStatusAttribute()
    {
        if (empty($this->status)) {
            return __('global.Ongoing');
        }
        if ($this->status == 1) {
            return __('global.finished');
        }
        if ($this->status == 2) {
            return __('global.approach');
        }
    }

    const periodMonth = [
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
    ];

}
