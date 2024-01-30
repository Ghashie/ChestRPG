<?php

namespace App\Model;

use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class WebSocket implements MessageComponentInterface
{  // Armazena o nome de usuário associado a cada conexão
    protected $client;
    protected $messageHistory = []; // Armazena o histórico de mensagens

    public function __construct()
    {
        $this->client = new \SplObjectStorage;
        $this->clientNames = [];
        $this->messageHistory = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Adicione essas linhas para permitir qualquer origem
        $conn->httpRequest->addHeader('Access-Control-Allow-Origin', '*');
        $conn->httpRequest->addHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        $conn->httpRequest->addHeader('Access-Control-Allow-Headers', 'Content-Type');
        
        $tableId = $this->getTableIdFromQueryString($conn->httpRequest->getUri()->getQuery());
        $this->client->attach($conn, ['tableId' => $tableId]);

        error_log("Nova conexão estabelecida: {$conn->resourceId} (Mesa: {$tableId})");

        $username = $this->getUsernameFromDatabase($conn);
        $this->setClientName($conn, $username);

        $this->sendWelcomeMessage($conn);
        $this->sendChatHistory($conn, $tableId);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $user = $this->getClientName($from);
        $tableId = $this->getClientTableId($from);

        $formattedMessage = "{$user} (Mesa: {$tableId}): {$msg}";

        $this->messageHistory[$tableId][] = $formattedMessage;

        // Enviar a mensagem apenas para os usuários da mesma mesa
        foreach ($this->client as $client) {
            $clientId = intval($client->resourceId);
            $clientTableId = $this->getTableIdFromConnection($client);

            if ($clientTableId === $tableId) {
                $client->send($formattedMessage);
            }
        }

        echo "{$user}: {$msg} (Mesa: {$tableId})\n";
    }


    public function onClose(ConnectionInterface $conn)
    {
        $this->client->detach($conn);
        $user = $this->getClientName($conn);
        error_log("Conexão encerrada: {$conn->resourceId} ({$user})");
        $this->broadcast("Usuário {$user} saiu da mesa.");
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        error_log("Erro: {$e->getMessage()}");
        $conn->close();
    }

    private function getClientName(ConnectionInterface $conn)
    {
        if (isset($this->clientNames[$conn->resourceId])) {
            return $this->clientNames[$conn->resourceId];
        }

        return "NomePadrao";
    }

    private function setClientName(ConnectionInterface $conn, $username)
    {
        $this->clientNames[$conn->resourceId] = $username;
    }

    private function sendWelcomeMessage(ConnectionInterface $conn)
    {
        $user = $this->getClientName($conn);
        $conn->send("Bem-vindo, {$user}!");
        $this->broadcast("Usuário {$user} entrou na mesa.");
    }

    private function sendChatHistory(ConnectionInterface $conn, $tableId)
    {
        if (isset($this->messageHistory[$tableId])) {
            foreach ($this->messageHistory[$tableId] as $message) {
                $conn->send($message);
            }
        }
    }


    private function getTableIdFromQueryString($queryString)
    {
        parse_str($queryString, $queryArray);
        return isset($queryArray['idTable']) ? $queryArray['idTable'] : null;
    }

    private function getClientTableId(ConnectionInterface $conn)
    {
        $clientData = $this->client->offsetGet($conn);
        return isset($clientData['tableId']) ? $clientData['tableId'] : null;
    }

    private function getUsernameFromDatabase(ConnectionInterface $conn)
    {
        $tableId = $this->getClientTableId($conn);

        $stmt = Conn::getConn()->prepare('SELECT usernameUser FROM user u 
                          JOIN members m ON u.idUser = m.idUser
                          JOIN tables t ON m.idTable = t.idTable
                          WHERE t.idTable = :tableId');

        $stmt->bindValue(':tableId', $tableId, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            return $result['usernameUser'];
        } else {
            return "NomePadrao";
        }
    }

    private function getTableIdFromConnection(ConnectionInterface $conn)
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        return $this->getTableIdFromQueryString($queryString);
    }



    private function broadcast($message)
    {
        foreach ($this->client as $client) {
            $client->send($message);
        }
    }

}
