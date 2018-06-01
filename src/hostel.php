<?php
// abstracts the data between us and the database
class HostelReservation
{
    public function __construct($dbConn)
    {
        $this->_dbConn = $dbConn;
    }

    //
    // Client
    //
    public function getClient(&$outClient)
    {
        $stmt = $this->_dbConn->prepare('SELECT * FROM client;');

        if (!$stmt->execute()) {
            throw exception('getClient: não foi possível executar a query!');
        }

        $outClient = $stmt->fetch();
        return true;
    }

    public function getNewClientId()
    {
        return $this->_dbConn->lastInsertId();
    }

    public function doesUserExist($username)
    {
        $stmt = $this->_dbConn->prepare(
            'SELECT * FROM client WHERE username = :username;'
        );
        $stmt->bindValue(':username', $username);

        if (!$stmt->execute()) {
            throw exception('getClient: não foi possível executar a query!');
        }

        $outClient = $stmt->fetch();
        return $outClient != false;
    }

    public function loginClient($username, $password)
    {
        $stmt = $this->_dbConn->prepare('SELECT * FROM client WHERE username = :username');
        $stmt->bindValue(':username', $username);        

        if (!$stmt->execute()) {
            throw exception('getClientWithDetails: não foi possível executar a query!');
        }

        $outClient = $stmt->fetch();

        if ($outClient == false) {
            return 0;
        }

        if (password_verify($password, $outClient['password'])) {
            return $outClient['id'];
        } else {
            return 0;
        }
    }

    public function newClient($firstName, $lastName, $address, $phoneNumber, $email, $username, $password)
    {
        if ($this->doesUserExist($username) === true) {
            return false;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->_dbConn->prepare(
            'INSERT INTO client(first_name,last_name,address,
            phone_number,email,username,password)
            VALUES (:first_name,:last_name,:address,
            :phone_number,:email,:username,:password);'
        );
        $stmt->bindValue(':first_name', $firstName);
        $stmt->bindValue(':last_name', $lastName);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':phone_number', $phoneNumber);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);

        if (!$stmt->execute()) {
            throw exception('newClient: não foi possível executar a query!');
        }

        return true;
    }

    public function editClient($clientId, $firstName, $lastName, $address, $phoneNumber, $email)
    {
        $stmt = $this->_dbConn->prepare(
            'UPDATE client SET first_name = :first_name, last_name = :last_name,
            address = :address, phone_number = :phone_number, email = :email,
            username :username, password = :password
            WHERE client_id = :client_id;'
        );
        $stmt->bindValue(':first_name', $firstName);
        $stmt->bindValue(':last_name', $lastName);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':phone_number', $phoneNumber);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':client_id', $clientId);

        if (!$stmt->execute()) {
            throw exception('editClient: não foi possível executar a query!');
        }
    }

    public function removeClient($clientId)
    {
        $stmt = $this->_dbConn->prepare(
            'DELETE FROM client
            WHERE client_id = :client_id;'
        );
        $stmt->bindValue(':client_id', $clientId);

        if (!$stmt->execute()) {
            throw exception(
                'removeClient: não foi possível executar a query!'
            );
        }
    }

    //
    // hostel
    //
    public function getHostel()
    {
        $stmt = $this->_dbConn->prepare('SELECT * FROM hostel;');

        if (!$stmt->execute()) {
            throw exception('getHostel: não foi possível executar a query!');
        }

        $outHostel = $stmt->fetchAll();
        return $outHostel;
    }

    public function getAllHostelsInfo()
    {
        $stmt = $this->_dbConn->prepare('SELECT * FROM hostel ORDER BY address;');

        if (!$stmt->execute()) {
            throw exception('getAllHostelsInfo: não foi possível executar a query!');
        }

        $outHostel = $stmt->fetchAll();
        return $outHostel;
    }

    public function getHostelInfo($hostelId)
    {
        $stmt = $this->_dbConn->prepare(
            'SELECT * FROM hostel WHERE id = :id ORDER BY address;'
        );
        $stmt->bindValue(':id', $hostelId);

        if (!$stmt->execute()) {
            throw exception('getHostel: não foi possível executar a query!');
        }

        $outHostel = $stmt->fetch();
        return $outHostel;
    }

    public function isCurrentlyReserved($hostelId, $clientId)
    {
        $stmt = $this->_dbConn->prepare(
            'SELECT * FROM reservation WHERE
            client_id=:client_id AND hostel_id=:hostel_id
            AND reservation_start >= DATE(NOW());'
        );
        $stmt->bindValue(':hostel_id', $hostelId);
        $stmt->bindValue(':client_id', $clientId);

        if (!$stmt->execute()) {
            throw exception(
                'isCurrentlyReserved: não foi possível executar a query!'
            );
        }

        $outHostel = $stmt->fetch();
        
        return $outHostel != false;        
    }

    public function newHostel($address, $roomPrice, $roomsAvailable = 0)
    {
        $stmt = $this->_dbConn->prepare(
            'INSERT INTO hostelgrade(address,room_price,rooms_available)
            VALUES(:address,:room_price,:rooms_available);'
        );
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':room_price', $roomPrice);
        $stmt->bindValue(':rooms_available', $roomsAvailable);

        if (!$stmt->execute()) {
            throw exception(
                'newHostel: não foi possível executar a query!'
            );
        }
    }

    public function editHostel($hostelId, $address, $roomPrice, $roomsAvailable)
    {
        $stmt = $this->_dbConn->prepare(
            'UPDATE hostel SET address = :address
            room_price = :room_price, rooms_available = :rooms_available
            WHERE id = :hostel_id;'
        );

        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':room_price', $roomPrice);
        $stmt->bindValue(':rooms_available', $roomsAvailable);
        $stmt->bindValue(':hostel_id', $hostelId);

        if (!$stmt->execute()) {
            throw exception(
                'editHostel: não foi possível executar a query!'
            );
        }
    }

    public function removeHostel($hostelId)
    {
        $stmt = $this->_dbConn->prepare('DELETE FROM hostel WHERE id = :hostel_id');
        $stmt->bindValue(':hostel_id', $hostelId);

        if (!$stmt->execute()) {
            throw exception(
                'removeHostel: não foi possível executar a query!'
            );
        }
    }

    //
    // reservation
    //
    public function getReservations()
    {
        $stmt = $this->_dbConn->prepare('SELECT * FROM reservation;');

        if (!$stmt->execute()) {
            throw exception(
                'getReservations: não foi possível executar a query!'
            );
        }

        $outReservations = $stmt->fetchAll();
        return $outReservations;
    }

    public function newReservation(
        $clientId, $hostelId, $reservationStart,
        $reservationEnd
    ) {
        $stmt = $this->_dbConn->prepare(
            'INSERT INTO reservation(client_id,hostel_id,reservation_start,
            reservation_end)
            VALUES(:client_id,:hostel_id,:reservation_start,
            :reservation_end);'
        );

        $stmt->bindValue(':client_id', $clientId);
        $stmt->bindValue(':hostel_id', $hostelId);
        $stmt->bindValue(':reservation_start', $reservationStart);
        $stmt->bindValue(':reservation_end', $reservationEnd);

        if (!$stmt->execute()) {
            throw exception('newReservation: não foi possível executar a query!');
        }
    }

    public function editReservation(
        $reservationId, $clientId, $hostelId, $reservationStart,
        $reservationEnd
    ) {
        $stmt = $this->_dbConn->prepare(
            'UPDATE reservation SET client_id = :client_id,
            hostel_id = :hostel_id,
            reservation_start = :reservation_start,
            reservation_end = :reservation_end
            WHERE id = :id;'
        );

        $stmt->bindValue(':client_id', $clientId);
        $stmt->bindValue(':hostel_id', $hostelId);
        $stmt->bindValue(':reservation_start', $reservationStart);
        $stmt->bindValue(':reservation_end', $reservationEnd);
        $stmt->bindValue(':id', $reservationId);

        if (!$stmt->execute()) {
            throw exception('editReservation: não foi possível executar a query!');
        }
    }

    public function removeReservation($reservationId)
    {
        $stmt = $this->_dbConn->prepare('DELETE FROM reservation WHERE id = :id;');

        $stmt->bindValue(':id', $reservationId);

        if (!$stmt->execute()) {
            throw exception('removeReservation: não foi possível executar a query!');
        }
    }

    // db connection
    private $_dbConn;
}
