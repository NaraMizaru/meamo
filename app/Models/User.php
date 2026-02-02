<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'google_id',
        'role',
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

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAdminWeb(): bool
    {
        return $this->role === 'admin_web';
    }

    /**
     * Normalize phone number to '08...' format.
     */
    public function setPhoneNumberAttribute($value)
    {
        // Remove non-numeric characters
        $value = preg_replace('/\D/', '', $value);

        // If starts with 62, replace with 0
        if (str_starts_with($value, '62')) {
            $value = '0' . substr($value, 2);
        }
        // If doesn't start with 0, prepend 0 (assuming it's a valid number starting with 8 usually)
        elseif (!str_starts_with($value, '0')) {
            $value = '0' . $value;
        }

        $this->attributes['phone_number'] = $value;
    }

    /**
     * Get WhatsApp URL (wa.me/628...).
     */
    public function getWhatsappUrlAttribute()
    {
        if (!$this->phone_number)
            return null;

        $phone = $this->phone_number;
        // If starts with 0, replace with 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return "https://wa.me/{$phone}";
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}
