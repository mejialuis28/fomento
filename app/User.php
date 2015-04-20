<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract {

	use Authenticatable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nombres', 'documento', 'apellidos', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


    /**
     * Tipo de usuario asociado al usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo('App\TipoUsuario','tipoUsuario');
    }

    /**
     * Inventario del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventario()
    {
        return $this->hasMany('App\Inventario');
    }

    /**
     * Un usuario puede ser administrador.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin()
    {
        return $this->hasOne('App\Administrador','usuario');
    }

}
