<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Trader extends Model
{
 use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'owner_contact_number',
        'password',
        'whatsapp_number',
        'telegram_number',
        'social_media_link',
        'store_id',
        'city',
        'store_description'
    ];
    // Relationships
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    protected $hidden = [
        'password',
    ];
}
