<?php

namespace App;

use App\Models\CreditCard\Card;
use App\Models\Feedback\Feedback;
use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Models\Order\PreOrder;
use App\Models\PlaceService\Place;
use App\Models\Product\Product;
use App\Models\Provider\Provider;
use App\Models\Reward\Reward;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $active
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActive($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Eminiarts\NovaPermissions\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User role($roles, $guard = null)
 * @property string|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @property int|null $company_id
 * @property string|null $social_key
 * @property string|null $social_driver
 * @property int|null $edit
 * @property-read \App\Models\Provider\Provider|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlaceService\Place[] $place
 * @property-read int|null $place_count
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEdit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialKey($value)
 * @property-read \App\Models\CreditCard\Card $creditCard
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order\Cart[] $curt
 * @property-read int|null $curt_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feedback\Feedback[] $myFeedback
 * @property-read int|null $my_feedback_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order\Order[] $order
 * @property-read int|null $order_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order\Order[] $orderProfile
 * @property-read int|null $order_profile_count
 * @property-read \App\Models\PlaceService\Place $geoLocationCompany
 */
class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password',
        'phone','last_name','company_id',
        'social_key','social_driver','image',
        'edit','bonus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function company()
    {
        return $this->belongsTo(Provider::class,'company_id');
    }

    public function place()
    {
        return $this->hasMany(Place::class);
    }

    public function curt()
    {
        return $this->hasMany(Cart::class);
    }

    public function creditCard()
    {
        return $this->hasOne(Card::class);
    }


    public function myFeedback()
    {
        return $this->hasMany(Feedback::class,'who_id')->with('company');
    }

    public function order()
    {
        return $this->hasMany(Order::class)->orderByDesc('id');
    }

    public function orderForFeedback()
    {
        return $this->hasMany(Order::class)->with('provider')
                                ->WhereNotNull('provider_id');
    }

    public function orderProfile()
    {
        return $this->hasMany(Order::class)->orderByDesc('id')->with('place');
    }

    public function preOrder()
    {
        return $this->hasMany(PreOrder::class);
    }

}
