<?php

namespace App\Model;

require_once 'tables.php';
class TablesDao
{

    public function create(Tables $t)
    {
        $uniqueId = uniqid(); // Generates a unique ID/Code
        $code = base_convert($uniqueId, 16, 36); // Converts the unique ID to base 36 to include letters
        $code = substr($code, 0, 6); // Truncates the code to 6 characters

        $sql = 'INSERT INTO tables (nameTable, descriptionTable, passwordTable, idAdmin, codeTable) VALUES (?, ? , ?, ?, ?)';

        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindvalue(1, $t->getNameT());
        $stmt->bindvalue(2, $t->getDescriptionT());
        $stmt->bindvalue(3, $t->getPasswordT());
        $stmt->bindvalue(4, $t->getIdFK()->getIdU());
        $stmt->bindvalue(5, $code);

        $stmt->execute();

        header("Location: ../Pages/usersTable.php");
    }

    public function joinTable($idUser, $code)
    {
        $table = $this->getTableByCode($code);

        if ($table) {
            $member = new Members($idUser, $table['idTable']);
            $memberDao = new MembersDao();
            $memberDao->join($member);
        } else {
            echo 'Mesa não encontrada!';
        }
    }

    public function read()
    {
        $sql = 'SELECT * FROM tables';
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } else {
            return [];
        }
    }

    public function editTable($idTable, $newName, $newDescription)
    {
        $sql = 'UPDATE tables SET nameTable = ?, descriptionTable = ? WHERE idTable = ?';
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(1, $newName);
        $stmt->bindValue(2, $newDescription);
        $stmt->bindValue(3, $idTable);
        $stmt->execute();
    }

    public function deleteTable($idTable)
    {
        $sql = 'DELETE FROM tables WHERE idTable = ?';
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(1, $idTable);
        $stmt->execute();
    }

    public function getTableByCode($code)
    {
        $sql = 'SELECT * FROM tables WHERE codeTable = ?';
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(1, $code);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } else {
            return null;
        }
    }

    public function getTablesByUserId($idUser)
    {
        $sql = 'SELECT t.*, m.isAdmin 
            FROM tables t 
            LEFT JOIN members m ON t.idTable = m.idTable 
            WHERE m.idUser = :idUser OR t.idAdmin = :idUser';

        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':idUser', $idUser, \PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } else {
            return [];
        }
    }

    public function getTableById($idTable)
    {
        $sql = 'SELECT * FROM tables WHERE idTable = ?';

        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(1, $idTable);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


}
