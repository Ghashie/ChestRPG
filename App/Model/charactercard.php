<?php

namespace App\Model;

class CharacterCard{
  private $idCharacter, $idUserFk, $idTableFk, $characterPDF;


  public function getIdCharacter(){
    return $this->idCharacter;
  }

  public function setIdCharacter($idC){
    $this->idCharacter = $idC;
  }

  public function getIdUserFk(){
    return $this->idUserFk;
  }

  public function setIdUserFk($idU){
    $this->idUserFk = $idU;
  }

  public function getIdTableFk(){
    return $this->idTableFk;
  }

  public function setIdTableFk($idT){
    $this->idTableFk = $idT;
  }

  public function getCharacterPDF(){
    return $this->characterPDF;
  }

  public function setCharacterPDF($pdf){
    $this->characterPDF = $pdf;
  }
}
