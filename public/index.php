<?php  
require '../vendor/autoload.php';  
require '../src/models/cliente.php';  
require '../src/models/produto.php';  
require '../src/models/compra.php';  
require '../src/models/pagamento.php';
require '../src/models/Produtocompra.php';  
require '../src/handlers/exception.php';

use Illuminate\Database\Capsule\Manager as DB;

$config = include('../src/config.php');

$app = new \Slim\App(['settings'=> $config]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$capsule->getContainer()->singleton(
  Illuminate\Contracts\Debug\ExceptionHandler::class,
  App\Exceptions\Handler::class
);

function response($response, $data) {
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->write(json_encode($data));
}

//-------------------------------------------------------------------
//Clientes
$app->get('/cliente/', function($request, $response) {
  return $response->getBody()->write(Cliente::all()->toJson());
});

$app->get('/cliente/{cpf}/', function($request, $response, $args) {
  $cpf = $args['cpf'];
  $cliente = Cliente::find($cpf);
  if(is_null($cliente))
    return $response->withStatus(404);
  return $response->getBody()->write($cliente->toJson());
});

$app->put('/cliente/{cpf}/', function($request, $response, $args) {
  $cpf = $args['cpf'];
  $data = $request->getParsedBody();
  $cliente = Cliente::find($cpf);

  if(is_null($cliente))
    return $response->withStatus(404);

  $cliente->nome = $data['nome'] ?: $cliente->nome; 
  $cliente->datadenascimento = $data['datadenascimento'] ?: $cliente->datadenascimento;
  $cliente->cep = $data['cep'] ?: $cliente->cep;
  $cliente->logradouro = $data['logradouro'] ?: $cliente->logradouro;
  $cliente->numero = $data['numero'] ?: $cliente->numero;
  $cliente->cidade = $data['cidade'] ?: $cliente->cidade;
  $cliente->estado = $data['estado'] ?: $cliente->estado;
  $cliente->telefone = $data['telefone'] ?: $cliente->telefone;

  $cliente->save();

  return $response->getBody()->write($cliente->toJson());
});

$app->post('/cliente/', function($request, $response, $args) {
  $data = $request->getParsedBody();
  $cliente = new Cliente();
  $cliente->cpf = $data['cpf'];
  $cliente->nome = $data['nome'];
  $cliente->datadenascimento = $data['datadenascimento'];
  $cliente->cep = $data['cep'];
  $cliente->logradouro = $data['logradouro'];
  $cliente->numero = $data['numero'];
  $cliente->cidade = $data['cidade'];
  $cliente->estado = $data['estado'];
  $cliente->telefone = $data['telefone'];

  $cliente->save();

  return $response->withStatus(201)->getBody()->write($cliente->toJson());
});

$app->delete('/cliente/{cpf}/', function($request, $response, $args) {
  $cpf = $args['cpf'];
  $cliente = Cliente::find($cpf);
  $cliente->delete();

  return $response->withStatus(200);
});


//-------------------------------------------------------------------
//Produto
$app->get('/produto/', function($request, $response) {
  return $response->getBody()->write(Produto::all()->toJson());
});

$app->get('/produto/{codigodebarras}/', function($request, $response, $args) {
  $codigodebarras = $args['codigodebarras'];
  $produto = Produto::find($codigodebarras);
  if(is_null($produto))
    return $response->withStatus(404);
  return $response->getBody()->write($produto->toJson());
});


$app->put('/produto/{codigodebarras}/', function($request, $response, $args) {
  $codigodebarras = $args['codigodebarras'];
  $data = $request->getParsedBody();
  $produto = Produto::find($codigodebarras);

  if(is_null($produto))
    return $response->withStatus(404);

  $produto->nome = $data['nome'] ?: $produto->nome; 
  $produto->preco = $data['preco'] ?: $produto->preco;
  $produto->custo = $data['custo'] ?: $produto->custo;
  $produto->quantidade = $data['quantidade'] ?: $produto->quantidade;
  $produto->unidade = $data['unidade'] ?: $produto->unidade;

  $produto->save();

  return $response->getBody()->write($produto->toJson());
});

$app->put('/produto/{codigodebarras}/adicionar/quantidade/', function($request, $response, $args) {
  $codigodebarras = $args['codigodebarras'];
  $data = $request->getParsedBody();
  $produto = Produto::find($codigodebarras);

  if(is_null($produto))
    return $response->withStatus(404);

  $produto->quantidade = $data['quantidade']+$produto->quantidade;
  $produto->save();

  return $response->getBody()->write($produto->toJson());
});


$app->post('/produto/', function($request, $response, $args) {
  $data = $request->getParsedBody();
  $produto = new Produto();
  $produto->Idproduto = $data['Idproduto'];
  $produto->codigodebarras = $data['codigodebarras'];
  $produto->nome = $data['nome'];
  $produto->preco = $data['preco'];
  $produto->custo = $data['custo'];
  $produto->quantidade = $data['quantidade'];
  $produto->unidade = $data['unidade'];

  $produto->save();

  return $response->withStatus(201)->getBody()->write($produto->toJson());
});

$app->delete('/produto/{codigodebarras}/', function($request, $response, $args) {
  $codigodebarras = $args['codigodebarras'];
  $produto = Produto::find($codigodebarras);
  $produto->delete();

  return $response->withStatus(200);
});


//-------------------------------------------------------------------
//Compra
$app->get('/compra/', function($request, $response) {
 /* return $response->getBody()->write(Compra::all()->toJson());*/
  return response($response, Compra::all());
});

$app->get('/compra/{id}/', function($request, $response, $args) {
  $id = $args['id'];
  $compra = Compra::find($id);
  if(is_null($compra))
    return $response->withStatus(404);
  return $response->getBody()->write($compra->toJson());
});

$app->get('/compra/cliente/{cpf}/', function($request, $response, $args) {
  $cpf = $args['cpf'];
  $compra = Compra::where('cpfcliente',$cpf)->get();
  return $response->getBody()->write($compra->toJson());
});

$app->post('/compra/', function($request, $response, $args) {
  $data = $request->getParsedBody();

  $cliente = Cliente::find($data['cpfcliente']);
  if(is_null($cliente))
    return $response->withStatus(404);

  $compra = new Compra();
  $compra->cpfcliente =  $cliente->cpfcliente;
  $compra->valor = $data['valor'];
  $compra->data = $data['data'];
  $compra->save();

  return $response->withStatus(201)->getBody()->write($produto->toJson());
});



//-------------------------------------------------------------------
//Pagamento
$app->get('/pagamento/', function($request, $response) {
  return $response->getBody()->write(Pagamento::all()->toJson());
});

$app->get('/pagamento/{id}/', function($request, $response, $args) {
  $id = $args['id'];
  $pagamento = Pagamento::find($id);
  if(is_null($pagamento))
    return $response->withStatus(404);
  return $response->getBody()->write($pagamento->toJson());
});

$app->get('/pagamento/cliente/{cpf}/', function($request, $response, $args) {
  $cpf = $args['cpf'];
  $pagamento = Pagamento::where('cpfcliente',$cpf)->get();
  return $response->getBody()->write($pagamento->toJson());
});

$app->post('/pagamento/', function($request, $response, $args) {
  $data = $request->getParsedBody();

  $cliente = Cliente::find($data['cpfcliente']);
  if(is_null($cliente))
    return $response->withStatus(404);

  $pagamento = new Pagamento();
  $pagamento->cpfcliente = $cliente->cpfcliente;
  $pagamento->valor = $data['valor'];
  $pagamento->data = $data['data'];
  $pagamento->tipo = $data['tipo'];
  $pagamento->save();

  return $response->withStatus(201)->getBody()->write($produto->toJson());
});

$app->run();