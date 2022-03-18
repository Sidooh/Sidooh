<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductSetting
 *
 * @property int $id
 * @property float $g_percentage
 * @property float $u_percentage
 * @property float $o_percentage
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereGPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereOPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereUPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereUpdatedAt($value)
 * @mixin IdeHelperProductSetting
 */
class ProductSetting extends Model
{
    //
}
