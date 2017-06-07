<?php  
class Compra extends \Illuminate\Database\Eloquent\Model {  
	public $timestamps = false;
  	protected $table = 'tbcompra';
  	protected $primaryKey = 'Idcompra';
    protected $fillable = [
        'Idcompra',
        'cpfcliente',
        'valor',
        'data',
    ];

    public function cliente(){
        return $this->belongsTo('Models\compra', 'cpfcliente');
    }
}
