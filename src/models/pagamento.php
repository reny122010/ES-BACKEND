<?php  
class Pagamento extends \Illuminate\Database\Eloquent\Model {  
	public $timestamps = false;
  	protected $table = 'tbpagamento';
  	protected $primaryKey = 'Id';
    protected $fillable = [
        'Id',
        'cpfcliente',
        'valor',
        'data',
        'tipo',
    ];

    public function cliente(){
        return $this->belongsTo('Models\cliente', 'cpfcliente');
    }
}
