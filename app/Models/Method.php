<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Method extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    public function task(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function scopeAllData(Builder $query, array $data): Collection
    {
        # code...
        $period = collect($data);
        
        $test = $query->with(['task' => function ($query) {
            $query->where('current_year', Carbon::now()->format('Y'));
        }])->orderBy('id')->get();

        $test = $test->map(function ($item) use ($period) {
            $period = $period->mapWithKeys(function ($value, $key) use ($item) {
                $item = $item->task->map(function ($dataItem, $dataKey) use ($value) {
                    if ($value === $dataItem->current_month) {
                        return $dataItem;
                    }
                })->filter(function ($filterValue, $filterKey) {
                    return  $filterValue != null;
                });
                return [$value => $item];
            });
            return [$item, $period];
        });
        
        return $test;
    }
}
