<?php

namespace App\Model;

class TableDao {

    public function create(Table $t){
        $sql = 'INSERT INTO tables (nameTable, descriptionTable, passwordTable, idAdmin, codeTable) VALUES (?, ? , ?, ?, ?)';

        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindvalue(1, $t->getNameT());
        $stmt->bindvalue(2, $t->getDescriptionT());
        $stmt->bindvalue(3, $t->getPasswordT());
        $stmt->bindvalue(4, $t->getIdFK());
        $stmt->bindvalue(5, $t->getCodeT());

        $stmt->execute();
    }

    public function read(){

        $sql = 'SELECT * FROM tables';
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } else {
            return [];
        }
    }

    public function update(Table $t){

        $sql = 'UPDATE tables SET nameTable = ?, descriptionTable = ?, passwordTable = ?, idAdmin = ?, codeTable = ? WHERE idTable = ?';
        
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindvalue(1, $t->getNameT());
        $stmt->bindvalue(2, $t->getDescriptionT());
        $stmt->bindvalue(3, $t->getPasswordT());
        $stmt->bindvalue(4, $t->getIdFK());
        $stmt->bindvalue(5, $t->getCodeT());

        $stmt->execute();
    }

    public function readUpdate($t){
        $sql = 'SELECT * FROM tables WHERE idTable = ?';
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindvalue(1, $t);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } else {
            return [];
        }
    }

    public function delete($id){
        $sql = 'DELETE FROM tables WHERE idTable = ?';
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindvalue(1, $id);
        $stmt->execute();
    }
}
?>