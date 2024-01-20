<?php
namespace App\Model;

class User{
  private $idUser, $usernameUser, $emailUser, $passwordUser;

  public function getIdU(){
    return $this->idUser;
  }
  public function setIdU($idU){
    $this->idUser = $idU;
  }

  public function getUsernameU(){
    return $this->usernameUser;
  }

  public function setUsernameU($uU){
    $this->usernameUser = $uU;
  }

  public function getEmailU(){
    return $this->emailUser;
  }

  public function setEmailU($eU){
    $this->emailUser = $eU;
  }

  public function getPasswordU(){
    return $this->passwordUser;
  }

  public function setPasswordU($pU){
    $this->passwordUser = $pU;
  }
}
?>