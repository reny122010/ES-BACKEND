<?php  
class Cliente extends \Illuminate\Database\Eloquent\Model {  
	public $timestamps = false;
  	protected $table = 'tbcliente';
  	protected $primaryKey = 'cpf';
    protected $fillable = [
        'cpf',
        'nome',
        'email',
        'datadenascimento',
        'cep',
        'logradouro',
        'numero',
        'cidade',
        'bairro',
        'estado',
        'telefone',
    ];
}
