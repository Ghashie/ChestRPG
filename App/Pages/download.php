<?php

if (isset($_GET['idTable']) && isset($_GET['filename'])) {
  $idTable = $_GET['idTable'];
  $filename = $_GET['filename'];
  $file_path = 'pdf/' . $filename; // Verifique o caminho correto

  if (file_exists($file_path)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    readfile($file_path);
    exit;
  } else {
    echo "Arquivo não encontrado.";
  }
} else {
  echo "Parâmetros inválidos.";
}
