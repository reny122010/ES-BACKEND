<?php  
class Produtocompra extends \Illuminate\Database\Eloquent\Model {  
	public $timestamps = false;
  	protected $table = 'tbprodutosparacompra';
  	protected $primaryKey = 'Id';
    protected $fillable = [
        'Id',
        'idcompra',
        'idproduto',
        'quantidade',
        'valor',
    ];
}
