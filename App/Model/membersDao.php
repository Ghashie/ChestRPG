<?php

namespace App\Model;


class MembersDao{
   
  public function join(Members $m){
    $sql = 'INSERT INTO members (idTable, idUser, isAdmin) VALUES (?, ?, ?)';
    $stmt = Conn::getConn()->prepare($sql);
    $stmt->bindvalue(1, $m->getIdTM()->getIdT());
    $stmt->bindvalue(2, $m->getIdUM()->getIdU());
    $stmt->bindvalue(3, $m->getIsAdmin());
    $stmt->execute();
  }
}
?>