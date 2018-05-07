<?php
    class HostelReservation
    {
        public function __construct($dbConn)
        {
            $this->m_dbConn = $dbConn;
        }

        //
        // Client
        //
        public function getClient(&$outClient)
        {
            $stmt = $this->m_dbConn->prepare('SELECT * FROM client;');

            if (!$stmt->execute()) {
                throw exception('HostelManagement::getClient: não foi possível executar a query!');
            }

            $outClient = $stmt->fetch();
            return true;
        }

        public function doesUserExist($username)
        {
            $stmt = $this->m_dbConn->prepare('SELECT * FROM client
              WHERE username = :username;');
            $stmt->bindValue(':username', $username);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::getClient: não foi possível executar a query!');
            }

            $outClient = $stmt->fetch();
            return $outClient != false;
        }

        public function loginClient($username, $password)
        {
            $stmt = $this->m_dbConn->prepare('SELECT * FROM client WHERE username = :username');
            $stmt->bindValue(':username', $username);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::getClientWithDetails: não foi possível executar a query!');
            }

            $outClient = $stmt->fetch();

            if ($outClient == false) {
                return false;
            }

            return password_verify($password, $outClient['password']);
        }

        public function newClient($firstName, $lastName, $address, $phoneNumber, $email, $username, $password)
        {
            if ($this->doesUserExist($username) === true) {
                return false;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->m_dbConn->prepare('INSERT INTO client(first_name,last_name,address,phone_number,email,username,password)
                                    VALUES(:first_name,:last_name,:address,:phone_number,:email,:username,:password);');
            $stmt->bindValue(':first_name', $firstName);
            $stmt->bindValue(':last_name', $lastName);
            $stmt->bindValue(':address', $address);
            $stmt->bindValue(':phone_number', $phoneNumber);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $password);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::newClient: não foi possível executar a query!');
            }

            return true;
        }

        public function editClient($clientId, $firstName, $lastName, $address, $phoneNumber, $email)
        {
            $stmt = $this->m_dbConn->prepare('UPDATE client SET first_name = :first_name, last_name = :last_name,
                                    address = :address, phone_number = :phone_number, email = :email,
                                    username :username, password = :password
                                    WHERE client_id = :client_id;');
            $stmt->bindValue(':first_name', $firstName);
            $stmt->bindValue(':last_name', $lastName);
            $stmt->bindValue(':address', $address);
            $stmt->bindValue(':phone_number', $phoneNumber);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':client_id', $clientId);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::editClient: não foi possível executar a query!');
            }
        }

        public function removeClient($clientId)
        {
            $stmt = $this->m_dbConn->prepare('DELETE FROM client WHERE client_id = :client_id;');
            $stmt->bindValue(':client_id', $clientId);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::removeClient: não foi possível executar a query!');
            }
        }

        //
        // hostel
        //
        public function getHostel()
        {
            $stmt = $this->m_dbConn->prepare('SELECT * FROM hostel;');

            if (!$stmt->execute()) {
                throw exception('HostelManagement::getHostel: não foi possível executar a query!');
            }

            $outHostel = $stmt->fetchAll();
            return $outHostel;
        }

        public function newHostel($address, $roomPrice, $roomsAvailable)
        {
            $stmt = $this->m_dbConn->prepare('INSERT INTO hostelgrade(address,room_price,rooms_available)
                                    VALUES(:address,:room_price,:rooms_available);');
            $stmt->bindValue(':address', $address);
            $stmt->bindValue(':room_price', $roomPrice);
            $stmt->bindValue(':rooms_available', $roomsAvailable);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::newHostel: não foi possível executar a query!');
            }
        }

        public function editHostel($hostelId, $address, $roomPrice, $roomsAvailable)
        {
            $stmt = $this->m_dbConn->prepare('UPDATE hostel SET address = :address
                                    room_price = :room_price, rooms_available = :rooms_available
                                    WHERE id = :hostel_id;');

            $stmt->bindValue(':address', $address);
            $stmt->bindValue(':room_price', $roomPrice);
            $stmt->bindValue(':rooms_available', $roomsAvailable);
            $stmt->bindValue(':hostel_id', $hostelId);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::editHostel: não foi possível executar a query!');
            }
        }

        public function removeHostel($hostelId)
        {
            $stmt = $this->m_dbConn->prepare('DELETE FROM hostel WHERE id = :hostel_id;');
            $stmt->bindValue(':hostel_id', $hostelId);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::removeHostel: não foi possível executar a query!');
            }
        }

        //
        // reservation
        //
        public function getReservations()
        {
            $stmt = $this->m_dbConn->prepare('SELECT * FROM reservation;');

            if (!$stmt->execute()) {
                throw exception('HostelManagement::getReservations: não foi possível executar a query!');
            }

            $outReservations = $stmt->fetchAll();
            return $outReservations;
        }

        public function newReservation($clientId, $hostelId, $reservationStart, $reservationEnd)
        {
            $stmt = $this->m_dbConn->prepare('INSERT INTO reservation(client_id,hostel_id,reservation_start,reservation_end)
                                      VALUES(:client_id,:hostel_id,:reservation_start,:reservation_end);');

            $stmt->bindValue(':client_id', $clientId);
            $stmt->bindValue(':hostel_id', $hostelId);
            $stmt->bindValue(':reservation_start', $reservationStart);
            $stmt->bindValue(':reservation_end', $reservationEnd);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::newReservation: não foi possível executar a query!');
            }
        }

        public function editReservation($reservationId, $clientId, $hostelId, $reservationStart, $reservationEnd)
        {
            $stmt = $this->m_dbConn->prepare('UPDATE reservation SET client_id = :client_id,
                                      hostel_id = :hostel_id, reservation_start = :reservation_start, reservation_end = :reservation_end
                                      WHERE id = :id;');

            $stmt->bindValue(':client_id', $clientId);
            $stmt->bindValue(':hostel_id', $hostelId);
            $stmt->bindValue(':reservation_start', $reservationStart);
            $stmt->bindValue(':reservation_end', $reservationEnd);
            $stmt->bindValue(':id', $reservationId);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::editReservation: não foi possível executar a query!');
            }
        }

        public function removeReservation($reservationId)
        {
            $stmt = $this->m_dbConn->prepare('DELETE FROM reservation WHERE id = :id;');

            $stmt->bindValue(':id', $reservationId);

            if (!$stmt->execute()) {
                throw exception('HostelManagement::removeReservation: não foi possível executar a query!');
            }
        }

        // db connection
        private $m_dbConn;
    }
