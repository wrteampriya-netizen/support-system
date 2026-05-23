<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Role;
use Override;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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
    #[Override]
    public function sendPasswordResetNotification($token)
    {
        $notification = new ResetPasswordNotification($token);

        $this->notify(new ResetPasswordNotification($token));
    }
    public function teams()
    {
        $this->belongsToMany(Team::class);
    }
    public function tickets()
    {
        return $this->hasManyThrough(
            ticket::class,
            assign_ticket::class,
            'user_id', // Foreign key on assign_tickets table
            'id',        // Foreign key on tickets table (usually ticket id)
            'id',        // Local key on users table
            'tickets_id' // Local key on assign_tickets table

        );
    }
    
}
