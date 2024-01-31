<?php
require_once '../Model/conn.php';
require_once '../Model/membersDao.php';
require_once '../Model/members.php';
require_once '../Model/user.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['idUser']) && isset($_POST['exit'])) {
    $tableId = $_POST['exit'];

    // Criar uma instância de Members
    $members = new \App\Model\Members();
    $members->setIdTM($tableId);
    $members->setIdUM($_SESSION['idUser']);

    // Chamar o método leaveTable
    $membersDao = new \App\Model\MembersDao();
    $membersDao->leaveTable($members);
    
    header("Location: mesa.php");
    exit();
} else {
    header("Location: ../Login/loginUser.php");
    exit();
}
?>
