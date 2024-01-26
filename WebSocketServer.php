<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nova conexão! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Verifica se a mensagem é um comando de rolar dados
        if (strpos($msg, 'rolar_dados') === 0) {
            $this->handleDiceRoll($from, $msg);
        } else {
            // Broadcast da mensagem para todos os clientes
            foreach ($this->clients as $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Conexão {$conn->resourceId} fechada\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e){
        echo "Erro: {$e->getMessage()}\n";
        $conn->close();
    }

 
private function handleDiceRoll(ConnectionInterface $from, $msg)
{
    // Implemente a lógica de rolar dados e envie o resultado apenas para o cliente que solicitou
    // Exemplo: analise $msg para obter o tipo de dado e a quantidade, role o dado e envie o resultado apenas para $from
    $from->send("Resultado do dado: ...");
}

}

$server = IoServer::factory(
    new WsServer(new Chat()),
    8080
);

$server->run();
