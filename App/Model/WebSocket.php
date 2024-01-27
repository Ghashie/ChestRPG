<?php

namespace App\Model;

use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class WebSocket implements MessageComponentInterface
{
    protected $clientNames;  // Armazena o nome de usuário associado a cada conexão
    protected $client;
    protected $messageHistory; // Armazena o histórico de mensagens

    public function __construct()
    {
        $this->client = new \SplObjectStorage;
        $this->clientNames = [];
        $this->messageHistory = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->client->attach($conn);
        error_log("Nova conexão estabelecida: {$conn->resourceId}");
        $this->sendWelcomeMessage($conn);
        $this->sendChatHistory($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $user = $this->getClientName($from);

        $formattedMessage = "{$user}: {$msg}";

        $this->messageHistory[] = $formattedMessage;

        foreach ($this->client as $client) {
            $client->send($formattedMessage);
        }

        echo "Usuário {$user} enviou: {$msg}\n";
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
        // Obtenha o nome do usuário associado à conexão
        if (isset($this->clientNames[$conn->resourceId])) {
            return $this->clientNames[$conn->resourceId];
        }

        return "NomePadrao"; // Substitua isso pela lógica real
    }

    private function sendWelcomeMessage(ConnectionInterface $conn)
    {
        $user = $this->getClientName($conn);
        $conn->send("Bem-vindo, {$user}!");
        $this->broadcast("Usuário {$user} entrou na mesa.");
    }

    private function sendChatHistory(ConnectionInterface $conn)
    {
        foreach ($this->messageHistory as $message) {
            $conn->send($message);
        }
    }

    private function broadcast($message)
    {
        foreach ($this->client as $client) {
            $client->send($message);
        }
    }
}
