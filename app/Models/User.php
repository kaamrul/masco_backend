<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use App\Library\Enum;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Vite;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasPermissionsTrait;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'user_type',
        'gender',
        'dob',
        'location',
        'ethnicity',
        'status',
        'avatar',
        'operator_id',
        'email_verified_at',
        'customer_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $appends = [
        'full_name'
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function emergency()
    {
        return $this->hasOne(EmergencyContact::class, 'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'user_id', 'id');
    }

    public function operator()
    {
        return $this->belongsTo(self::class, 'operator_id');
    }

    /**
     * Get all of the user's attachments.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /*=====================Helper Methods======================*/
    public function getFullNameAttribute()
    {
        $name = $this->first_name;

        if ($this->m_name) {
            $name .= ' ' . $this->m_name;
        }
        $name .= ' ' . $this->last_name;

        return $name;
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address;
        $fullAddress = 'N/A';

        if ($address) {
            $fullAddress = $address->home_street_address . ', ' .
                $address->home_suburb . ', ' . $address->home_city . ', ' . $address->home_post_code;
        }

        return $fullAddress;
    }

    public function getIsAdultAttribute()
    {
        return Carbon::parse($this->dob)->diffInYears(now()) >= 18;
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->diffInYears(now());
    }

    public static function getAuthUser()
    {
        return auth()->user();
    }

    public static function getAll()
    {
        return self::all();
    }

    public function role()
    {
        return $this->roles()->first();
    }

    public function getRole()
    {
        return $this->roles()->get();
    }

    public function isSuperAdmin()
    {
        return $this->user_type == Enum::USER_TYPE_SUPER_ADMIN;
    }

    public function isAdmin()
    {
        return $this->user_type == Enum::USER_TYPE_ADMIN;
    }

    public function isEmployee()
    {
        return $this->user_type == Enum::USER_TYPE_EMPLOYEE;
    }

    public function isCustomer()
    {
        return $this->user_type == Enum::USER_TYPE_CUSTOMER;
    }


    public function isMember()
    {
        return $this->user_type == Enum::USER_TYPE_CUSTOMER;
    }

    public static function getAuthUserRole()
    {
        return auth()->user()->roles()->first();
    }

    public static function getUsersByType(string $type)
    {
        return self::where('user_type', $type)->get();
    }


    public function getAvatar(): string
    {
        $path = public_path($this->avatar);

        if ($this->avatar && is_file($path) && file_exists($path)) {
            return asset($this->avatar);
        }

        return Vite::asset(Enum::NO_AVATAR_PATH);
    }

    public function getPhotoId(): string
    {
        $path = public_path($this->photo_id);

        if ($this->photo_id && is_file($path) && file_exists($path)) {
            return asset($this->photo_id);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public static function getActiveEmployee()
    {
        return self::with('employee')
            ->where('user_type', Enum::USER_TYPE_EMPLOYEE)
            ->where('status', Enum::STATUS_ACTIVE)
            ->get();
    }

    public function scopeWithoutDatabaseUser($query)
    {
        return $query->whereNot('id', 1);
    }

    public function scopeHasAdminPanelAccess($query)
    {
        return $query->whereIn('user_type', [Enum::USER_TYPE_ADMIN, Enum::USER_TYPE_EMPLOYEE]);
    }

    public static function getActiveAdminEmployeeByStatus(int $status)
    {
        return self::whereHas('employee')->with('employee')
            ->withoutDatabaseUser()
            ->hasAdminPanelAccess()
            ->where('status', $status)
            ->get();
    }

    public static function getActiveAdminEmployeeByTeamId(int $team_id)
    {
        return self::whereHas('employee')->with('employee', 'operator')
            ->withoutDatabaseUser()
            ->hasAdminPanelAccess()
            ->where('team_id', $team_id);
    }



    public static function getVerifiedNominated()
    {
        return self::whereUserType(Enum::USER_TYPE_CUSTOMER)
            ->whereNotNull('email_verified_at')
            ->get();
    }

    public static function getVerifiedSeconded()
    {
        return self::whereUserType(Enum::USER_TYPE_CUSTOMER)
            ->whereNotNull('email_verified_at')
            ->get();
    }

    public static function scopeIsMember($query)
    {
        return $query->where('user_type', Enum::USER_TYPE_CUSTOMER);
    }

    public static function getTotalActiveCustomer($from, $to)
    {
        return self::where('user_type', Enum::USER_TYPE_CUSTOMER)
            ->where('status', Enum::STATUS_ACTIVE)
            ->whereBetween('created_at', [$from, $to])
            ->count('id');
    }
}
