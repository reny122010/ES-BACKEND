<?php  
class Produto extends \Illuminate\Database\Eloquent\Model {  
	public $timestamps = false;
  	protected $table = 'tbproduto';
  	protected $primaryKey = 'codigodebarras';
    protected $fillable = [
        'Idproduto',
        'codigodebarras',
        'nome',
        'preco',
        'custo',
        'quantidade',
        'unidade',
    ];
}
