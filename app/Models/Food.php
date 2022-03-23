<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Meal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Food
 *
 * @property int $id
 * @property string $name
 * @property int $calories
 * @property int $carbs
 * @property Meal $meal
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\FoodFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Food newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food query()
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCarbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereMeal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereUserId($value)
 * @mixin \Eloquent
 */
class Food extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'calories',
        'carbs',
        'meal',
        'user_id',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meal' => Meal::class,
        'date' => 'datetime:Y-m-d',
    ];

    /**
     * Scope a query to only include Food for a given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<Food> $query
     * @return \Illuminate\Database\Eloquent\Builder<\App\Models\Food>
     */
    public function scopeForDate(\Illuminate\Database\Eloquent\Builder $query, \Carbon\Carbon $date): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('date', '=', $date->format('Y-m-d'));
//        return $query->where('date', '=', $date->toString());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Food>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
