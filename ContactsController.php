<?php

require_once 'ContactsGateWay.php';

class ContactsController
{
    private $db;
    private $requestMethod;

    private $contactGateWay;
    private $id;

    public function __construct($db,$requestMethod,$id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->id = $id;

        $this->contactGateWay = new ContactsGateway($db);
    }

    public function processRequest()
    {
        switch($this->requestMethod)
        {
            case 'GET':
                if ($this->id)
                {
                    $response = $this->getContactById($this->id);
                }
                else
                {
                    $response = $this->getAllContacts();
                }
            break;
            case 'POST':
                $response = $this->createContact();
            break;
            case 'PUT':
                if ($this->id)
                {
                    $response = $this->updateContact($this->id);
                }
            break;
            case 'DELETE':
                $response = $this->deleteContact($this->id);
            break;
        }
        
        header($response['status_code_header']);
        if ($response['body']) 
        {
            echo $response['body'];
        }
    }

    public function getAllContacts()
    {
        $result = $this->contactGateWay->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);

        return $response;
    }

    public function getContactById($id)
    {
        $result = $this->contactGateWay->find($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);

        return $response;
    }

    public function createContact()
    {
        $input = (array) json_decode(file_get_contents('php://input'),TRUE);

        // validar datos del input

        $this->contactGateWay->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 200 Created';
        $response['body'] = null;
    }

    public function updateContact($id)
    {
        $result = $this->contactGateWay->find($id);
        if ($result)
        {
            $input = (array) json_decode(file_get_contents('php://input'),TRUE);
            $this->contactGateWay->update($id,$input);

            $response['status_code_header'] = 'HTTP/1.1 200 Updated';
            $response['body'] = null;
        }
        else
        {
            // 404 NOT FOUND
        }
    }

    public function deleteContact($id)
    {
        $this->contactGateWay->delete($id);

        $response['status_code_header'] = 'HTTP/1.1 200 Deleted';
        $response['body'] = null;
    }
}


?>