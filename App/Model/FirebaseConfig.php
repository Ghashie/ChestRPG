<?php
require 'vendor/autoload.php';  // Carrega o autoloader do Composer

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseConfig {
    private static $firebase;  // Variável estática para armazenar a instância do Firebase

    public static function getFirebase() {
        if (!self::$firebase) {  // Se ainda não temos uma instância do Firebase, criamos uma
            $serviceAccount = \Kreait\Firebase\ServiceAccount::fromJsonFile(__DIR__.'/../../firebase_credentials.json');
            self::$firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        }

        return self::$firebase;  // Retorna a instância do Firebase
    }
}
?>
