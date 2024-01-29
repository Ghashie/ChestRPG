<?php

namespace App\Model;

require_once 'charactercard.php';

class CharacterCardDao{

  public function create(CharacterCard $cc){
    $sql = 'INSERT INTO charactercard (idCharacter, idUserFk, idTableFk, characterPDF) VALUES (?, ?, ?, ?)';
    $stmt = Conn::getConn()->prepare($sql);
    $stmt->bindvalue(1, $cc->getIdCharacter());
    $stmt->bindvalue(2, $cc->getIdUserFk()->getIdU());
    $stmt->bindvalue(3, $cc->getIdTableFk()->getIdT());
    $stmt->bindvalue(4, $cc->getCharacterPDF());
  }
  
}