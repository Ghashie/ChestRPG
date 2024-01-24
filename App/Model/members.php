<?php

namespace App\Model;

class Members{
  private $idUser, $idTable, $isAdmin;

  public function getIdUM(){
    return $this->idUser;
  }

  public function setIdUM($idUM){
    $this->idUser = $idUM;
  }

  public function getIdTM(){
    return $this->idTable;
  }

  public function setIdTM($idTM){
    $this->idTable = $idTM;
  }

  public function getIsAdmin(){
    return $this->isAdmin;
  }

  public function setIsAdmin($isAdmin){
    $this->isAdmin = $isAdmin;
  }
}
?>