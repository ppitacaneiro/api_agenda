<?php

class ContactsGateway
{
    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM contactos";

        try
        {   
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }
        catch(PDOException $e)
        {   
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $sql = "SELECT * FROM contactos WHERE id = ?";

        try
        {   
            $statement = $this->db->prepare($sql);
            $statement->execute(array($id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }
        catch(PDOException $e)
        {   
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        $sql = 
        "
            INSERT INTO 
            contactos
            (nombre,telefono,email)
            VALUES 
            (:nombre,:telefono,:email)
        ";

        try
        {
            $statement = $this->db->prepare($sql);
            $statement->execute(array(
                'nombre' => $input['nombre'],
                'telefono' => $input['telefono'],
                'email' => $input['email']
            ));

            return $statement->rowCount();
        }
        catch(PDOException $e)
        {   
            exit($e->getMessage());
        }
    }

    public function update($id, Array $input)
    {
        $sql = 
        "
            UPDATE
            contactos
            SET
                nombre = :nombre,
                telefono = :telefono,
                email = :email
            WHERE 
                id = :id
        ";

        try 
        {
            $statement = $this->db->prepare($sql);
            $statement->execute(array(
                'nombre' => $input['nombre'],
                'telefono' => $input['telefono'],
                'email' => $input['email'],
                'id' => (int) $id
            ));

            return $statement->rowCount();
        }
        catch(PDOException $e)
        {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $sql = 
        "   
            DELETE
            FROM 
            contactos
            WHERE
            id = ?
        ";

        try 
        {
            $statement = $this->db->prepare($sql);
            $statement->execute(array($id));

            return $statement->rowCount();
        }
        catch(PDOException $e)
        {
            exit($e->getMessage());
        }
    }
}



?>