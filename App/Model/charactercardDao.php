<?php

namespace App\Model;

require_once 'charactercard.php';

class CharacterCardDao
{

  public function insertCharacterCard(CharacterCard $characterCard)
  {
    try {
      $conn = Conn::getConn();

      $sql = "INSERT INTO charactercard (idUser, idTable, characterPDF) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(1, $characterCard->getIdUserFk()->getIdU());
      $stmt->bindValue(2, $characterCard->getIdTableFk());
      $stmt->bindValue(3, $characterCard->getCharacterPDF(), \PDO::PARAM_LOB); // Adicione o tipo de parâmetro para dados LOB

      $stmt->execute();

      return true;
    } catch (\PDOException $e) {
      return false;
    }
  }

  public function getCharacterCardsByUserAndTable($idUser, $idTable)
  {
    try {
      $conn = Conn::getConn();

      // Selecione os registros da tabela charactercard com base no usuário e na mesa
      $sql = "SELECT * FROM charactercard WHERE idUser = ? AND idTable = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(1, $idUser->getIdU()); // Use getIdUser() ao invés de getIdU()
      $stmt->bindValue(2, $idTable);

      $stmt->execute();

      // Retorne um array de objetos CharacterCard
      return $stmt->fetchAll(\PDO::FETCH_CLASS, 'App\\Model\\CharacterCard');
    } catch (\PDOException $e) {
      return [];
    }
  }

  public function deleteCharacterCard($idCharacter)
  {
    try {
      $conn = Conn::getConn();

      // Excluir a ficha com base no ID
      $sql = "DELETE FROM charactercard WHERE idCharacter = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(1, $idCharacter);
      $stmt->execute();

      return true;
    } catch (\PDOException $e) {
      return false;
    }
  }
}
