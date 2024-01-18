<?php
/*
 * Nome da classe: firebaseRDB
 * Versão: 1.0
 * Autor: Devisty
 */

class firebaseRDB {
    function __construct($url = null) {
        if (isset($url)) {
            $this->url = $url; // Atribui a URL fornecida à propriedade $url
        } else {
            throw new Exception("Database URL must be specified"); // Lança uma exceção se a URL não for fornecida
        }
    }

    // Método para fazer uma solicitação HTTP usando cURL
    public function grab($url, $method, $par = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (isset($par)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $par);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $html = curl_exec($ch);
        return $html;
        curl_close($ch);
    }

    // Método para inserir dados em uma tabela *PUT*
    public function insert($table, $data) {
        $path = $this->url . "/$table.json"; // Constrói a URL para a tabela específica
        $grab = $this->grab($path, "POST", json_encode($data)); // Realiza uma solicitação POST com os dados
        return $grab;
    }

    // Método para atualizar dados em uma tabela *UPDATE*
    public function update($table, $uniqueID, $data) {
        $path = $this->url . "/$table/$uniqueID.json"; // Constrói a URL para o registro específico na tabela
        $grab = $this->grab($path, "PATCH", json_encode($data)); // Realiza uma solicitação PATCH com os dados atualizados
        return $grab;
    }

    // Método para excluir um registro de uma tabela *DELETE*
    public function delete($table, $uniqueID) {
        $path = $this->url . "/$table/$uniqueID.json"; // Constrói a URL para o registro específico na tabela
        $grab = $this->grab($path, "DELETE"); // Realiza uma solicitação DELETE
        return $grab;
    }

    // Método para recuperar dados de um caminho no banco de dados *GET*
    public function retrieve($dbPath, $queryKey = null, $queryType = null, $queryVal = null) {
        if (isset($queryType) && isset($queryKey) && isset($queryVal)) {
            $queryVal = urlencode($queryVal);
            if ($queryType == "EQUAL") {
                $pars = "orderBy=\"$queryKey\"&equalTo=\"$queryVal\"";
            } elseif ($queryType == "LIKE") {
                $pars = "orderBy=\"$queryKey\"&startAt=\"$queryVal\"";
            }
        }
        $pars = isset($pars) ? "?$pars" : "";
        $path = $this->url . "/$dbPath.json$pars"; // Constrói a URL para o caminho no banco de dados com os parâmetros de consulta
        $grab = $this->grab($path, "GET"); // Realiza uma solicitação GET
        return $grab;
    }
}