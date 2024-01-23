<?php

namespace App\Model;

class UserDao {
  public function search(User $u){

    $sql = "SELECT * FROM user WHERE emailUser = ?";

    $stmt = Conn::getConn()->prepare($sql);
    $stmt->bindValue(1, $u->getEmailU());
    $stmt->execute();

    if($stmt->rowCount() == 1){
      
      if($row = $stmt->fetch()){

        $idUser = $row['idUser'];
        $usernameUser = $row['usernameUser'];
        $emailUser = $row['emailUser'];
        $passwordUser = $row['passwordUser'];

        $user_result = new User();
        $user_result->setIdU($idUser);

        $hashed_password = $row['passwordUser'];
        if(password_verify($u->getPasswordU(), $hashed_password)){
          return $user_result;
        }
      }
    }
  }

  public function create(User $u){

    //testar se já existe um usuário com este email
    $sql = 'SELECT * FROM user WHERE emailUser = ?';
    $stmt = Conn::getConn()->prepare($sql);
    $stmt->bindValue(1,$u->getEmailU());

    $stmt->execute();

    if($stmt->rowCount() == 1){  // se for encontrado
      $return = "ok";
      return $return;
    } else {
        $sql = 'INSERT INTO user (usernameUser, emailUser, passwordUser) VALUES (?,?,?)';
   
        $stmt = Conn::getConn()->prepare($sql); 
        $stmt->bindValue(1, $u->getUsernameU());
        $stmt->bindValue(2, $u->getEmailU());
        $stmt->bindValue(3, $u->getPasswordU());
        $stmt->execute();
    }    
}




























}
?>