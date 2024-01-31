<?php
require_once '../Model/conn.php';
require_once '../Model/tablesDao.php';
require_once '../Model/membersDao.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['idUser']) && isset($_POST['delete'])) {
    $tableId = $_POST['delete'];

    $membersDao = new \App\Model\MembersDao();
    $membersDao->deleteMembersByTableId($tableId);

    $tableDao = new \App\Model\TablesDao();
    $tableDao->deleteTable($tableId);
    header("Location: mesa.php");
    exit();
} else {
    header("Location: ../Login/loginUser.php");
    exit();
}
