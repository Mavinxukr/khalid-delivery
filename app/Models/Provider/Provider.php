<?php

namespace App\Models\Provider;

use App\Models\Category\Category;
use App\Models\Feedback\CompanyFeedback;
use App\Models\Feedback\Feedback;
use App\Models\Payment\Payment;
use App\Models\PlaceService\Place;
use App\Models\Product\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Provider\Provider
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property float $balance
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Payment\Payment $payment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $phone_number
 * @property int $active
 * @property int $category_id
 * @property-read \App\Models\Category\Category $categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider wherePhoneNumber($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\Product[] $product
 * @property-read int|null $product_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\Product[] $productTop
 * @property-read int|null $product_top_count
 * @property-read \App\Models\Provider\SettingProvider $providerSetting
 * @property-write mixed $raw
 * @property string $website
 * @property string $email
 * @property string $chamber_of_commerce
 * @property-read \App\Models\Provider\CompanyCreditCard $creditCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Provider\Language[] $languages
 * @property-read int|null $languages_count
 * @property-read \App\Models\Provider\CompanySchedule $schedule
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereChamberOfCommerce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereWebsite($value)
 */
class Provider extends Model
{
    use Notifiable;

    protected $fillable = [
        'balance','category_id','phone_number',
        'name','email','website','company_number',
        'chamber_of_commerce','image',
        'street_address', 'city',
        'state', 'country', 'zip', 'count', 'charge'
    ];

    protected $hidden = [
        'balance','updated_at','created_at',
        'active', 'category_id'
    ];
    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id','provider_id','payment_provider');

    }
    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function providerSetting()
    {
        return $this->hasOne(SettingProvider::class);
    }
    public function productTop()
    {
        return $this->hasMany(Product::class,'provider_id')
                    ->orderBy('id','DESC')
                    ->take(3);
    }
    public function product()
    {
        return $this->hasMany(Product::class,'provider_id');
    }
    public function languages()
    {
        return $this->belongsToMany(Language::class,'provider_language');
    }
    public function schedule()
    {
        return $this->hasOne(CompanySchedule::class);
    }
    public function users()
    {
        return $this->hasMany(User::class,'company_id');
    }
    public function creditCard()
    {
        return $this->hasOne(CompanyCreditCard::class);
    }
    public function geoLocation()
    {
        return $this->hasOne(Place::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class,'whom_id');
    }


    public function companyFeedback()
    {
        return $this->hasMany(CompanyFeedback::class,'provider_id');
    }

}
