<?php
namespace App\Model;

class Table{
    private $idTable, $nameTable, $descriptionTable, $passwordTable, $idAdminFk, $codeTable;

    public function getIdT(){
        return $this->idTable;
    }

    public function setIdT($idT){
        $this->idTable = $idT;
    }

    public function getIdFK(){
        return $this->idAdminFk;
    }

    public function setIdFK($idFK){
        $this->idAdminFk = $idFK;
    }

    public function getNameT(){
        return $this->nameTable;
    }

    public function setNameT($nameT){
        $this->nameTable = $nameT;
    }

    public function getDescriptionT(){
        return $this->descriptionTable;
    }

    public function setDescriptionT($descT){
        $this->descriptionTable = $descT;
    }

    public function getPasswordT(){
        return $this->passwordTable;
    }

    public function setPasswordT($passT){
        $this->passwordTable = $passT;
    }

    public function getCodeT(){
        return $this->codeTable;
    }

    public function setCodeT($codeT){
        $this->codeTable = $codeT;
    }
}
?>