<?php

namespace App\Model;

class MembersDao
{
  public function join(Members $m)
  {
    $sql = 'INSERT INTO members (idTable, idUser, isAdmin) VALUES (?, ?, ?)';
    $stmt = Conn::getConn()->prepare($sql);
    $stmt->bindvalue(1, $m->getIdTM());
    $stmt->bindvalue(2, $m->getIdUM()->getIdU());
    $stmt->bindvalue(3, $m->getIsAdmin());
    $stmt->execute();
  }

  public function getMembersByTableId($idTable){
    $sql = "SELECT m.idUser, m.isAdmin, u.usernameUser
            FROM members m
            INNER JOIN user u ON m.idUser = u.idUser
            WHERE m.idTable = ?
            
            UNION
            
            SELECT t.idAdmin as idUser, 1 as isAdmin, u.usernameUser
            FROM tables t
            INNER JOIN user u ON t.idAdmin = u.idUser
            WHERE t.idTable = ?";

    $stmt = Conn::getConn()->prepare($sql);
    $stmt->bindValue(1, $idTable);
    $stmt->bindValue(2, $idTable);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $result;
    } else {
      return [];
    }
  }

}
?>