<?php

namespace Luinuxscl\WordpressIntegration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WordpressCredential extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_url',    // endpoint o URL del sitio WordPress
        'username',    // usuario para autenticación
        'password',    // contraseña para autenticación
        'is_default',  // indica si la credencial es la predeterminada
        'site_name',   // nombre del sitio de WordPress
        'credentialable_id', // ID del modelo asociado
        'credentialable_type', // Tipo del modelo asociado
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relación polimórfica para asociar credenciales con cualquier modelo.
     */
    public function credentialable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Boot method to handle default credential logic.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (self::count() == 0) {
                $model->is_default = true;
            } elseif ($model->is_default) {
                self::where('is_default', true)->update(['is_default' => false]);
            }
        });

        static::updating(function ($model) {
            if ($model->is_default) {
                self::where('is_default', true)->where('id', '!=', $model->id)->update(['is_default' => false]);
            }
        });
    }
}
