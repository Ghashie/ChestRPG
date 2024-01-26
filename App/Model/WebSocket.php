<?php 

namespace App\Model;

use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class WebSocket implements MessageComponentInterface{
    protected $client;

    public function __construct() {
        $this->client = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->client->attach($conn);
        echo "Nova conexão estabelecida: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->client as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }

        echo "Usuario {$from->resourceId} enviou: {$msg}\n";
    }

    public function onClose(ConnectionInterface $conn) {
        $this->client->detach($conn);
        echo "Conexão encerrada: {$conn->resourceId}\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Erro: {$e->getMessage()}\n";
        $conn->close();
    }
}


?>