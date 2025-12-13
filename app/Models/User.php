<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     /** حملات المعلن */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    /** مهام الناشر */
    public function publisherTasks()
    {
        return $this->hasMany(PublisherTask::class, 'publisher_id');
    }

    /** محفظة المستخدم */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /** سجلات المعاملات */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /** طلبات السحب */
    public function withdrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class);
    }

    /** فواتير المعلن */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
