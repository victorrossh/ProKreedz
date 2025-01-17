<?php
class Database
{
    # Variável que guarda a conexão PDO.
    protected static $db;
    # Private construct - garante que a classe só possa ser instanciada internamente.
    private function __construct()
    {
        # Informações sobre o banco de dados:
        $db_host = DB_HOST;
        $db_nome = DB_NAME;
        $db_usuario = DB_USER;
        $db_senha = DB_PASS;
        $db_driver = DB_TYPE;
        try
        {
            # Atribui o objeto PDO à variável $db.
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
            # Garante que o PDO lance exceções durante erros.
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Garante que os dados sejam armazenados com codificação UFT-8.
            self::$db->exec('SET NAMES utf8');
        }
        catch (PDOException $e)
        {
            # Então não carrega nada mais da página.
            die("Connection Error: " . $e->getMessage());
        }
    }
    # Método estático - acessível sem instanciação.
    public static function conexao()
    {
        # Garante uma única instância. Se não existe uma conexão, criamos uma nova.
        if (!self::$db)
        {
            new Database();
        }
        # Retorna a conexão.
        return self::$db;
    }
}