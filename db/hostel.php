<?php
    include 'db.php';

    class HostelManagement
    {
        //
        // Client
        //
        function getClient(&$outClient)
        {
            $stmt = $dbConn->prepare('SELECT * FROM client;');
            
            if (!$stmt->execute())  
                return false;
            
            $outClient = $stmt->fetchAll(); 
            return true;
        }          

        function newClient($firstName, $lastName, $address, $phoneNumber, $email, $userName, $password)
        {
            $stmt = $dbConn->prepare('INSERT INTO client(first_name,last_name,adress,phone_number,email,username,password)
                                    VALUES(:first_name,:last_name,:adress,:phone_number,:email,:username,:password);');
            $stmt->bindValue(':first_name', $firstName);
            $stmt->bindValue(':last_name', $lastName);
            $stmt->bindValue(':adress', $address);
            $stmt->bindValue(':phone_number', $phoneNumber);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':username', $userName);
            $stmt->bindValue(':password', $password);

            return $stmt->execute() ? true : false;
        }   
        
        function editClient($clientId, $firstName, $lastName, $address, $phoneNumber, $email)
        {
            $stmt = $dbConn->prepare('UPDATE client SET first_name = :first_name, last_name = :last_name,
                                    adress = :adress, phone_number = :phone_number, email = :email,
                                    username :username, password = :password
                                    WHERE client_id = :client_id;');
            $stmt->bindValue(':first_name', $firstName);
            $stmt->bindValue(':last_name', $lastName);
            $stmt->bindValue(':adress', $address);
            $stmt->bindValue(':phone_number', $phoneNumber);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':username', $userName);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':client_id', $clientId);

            return $stmt->execute() ? true : false;
        }    
        
        function removeClient($clientId)
        {
            $stmt = $dbConn->prepare('DELETE FROM client WHERE client_id = :client_id;');    
            $stmt->bindValue(':client_id', $clientId);  

            return $stmt->execute() ? true : false;
        }         

        //
        // hostel
        //
        function getHostel(&$outHostel)
        {
            $stmt = $dbConn->prepare('SELECT * FROM hostel;');
            
            if (!$stmt->execute())  
                return false;
            
            $outHostel = $stmt->fetchAll(); 
            return true;
        }          

        function newHostel($hostelSizeId, $hostelGradeId, $address)
        {
            $stmt = $dbConn->prepare('INSERT INTO hostelgrade(hostelsize_size_id,hostelgrade_grade_id,address)
                                    VALUES(:hostelsize_size_id,:hostelgrade_grade_id,:address);');
            $stmt->bindValue(':hostelsize_size_id', $hostelSizeId);
            $stmt->bindValue(':hostelgrade_grade_id', $hostelGradeId);
            $stmt->bindValue(':address', $address);

            return $stmt->execute() ? true : false;
        }   
        
        function editHostel($hostelId, $hostelSizeId, $hostelGradeId, $address)
        {
            $stmt = $dbConn->prepare('UPDATE hostel SET hostelSizeId = :hostelSizeId, hostelGradeId = :hostelGradeId,
                                    address = :address
                                    WHERE hostel_id = :hostel_id;');
            $stmt->bindValue(':address', $description);
            $stmt->bindValue(':hostel_id', $hostelId);

            return $stmt->execute() ? true : false;
        }    
        
        function removeHostel($hostelId)
        {
            $stmt = $dbConn->prepare('DELETE FROM hostehostellgrade WHERE hostel_id = :hostel_id;');    
            $stmt->bindValue(':hostel_id', $hostelId);  

            return $stmt->execute() ? true : false;
        }  

        //
        // hostelgrade
        //
        function getHostelGrade(&$outHostelGrade)
        {
            $stmt = $dbConn->prepare('SELECT * FROM hostelgrade;');
            
            if (!$stmt->execute())  
                return false;
            
            $outHostelGrade = $stmt->fetchAll(); 
            return true;
        }          

        function newHostelGrade($description)
        {
            $stmt = $dbConn->prepare('INSERT INTO hostelgrade(description) VALUES(:description);');
            $stmt->bindValue(':description', $description);

            return $stmt->execute() ? true : false;
        }   
        
        function editHostelGrade($hostelGradeId, $description)
        {
            $stmt = $dbConn->prepare('UPDATE hostelgrade SET description = :description 
            WHERE grade_id = :grade_id;');
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':grade_id', $hostelGradeId);

            return $stmt->execute() ? true : false;
        }    
        
        function removeHostelGrade($hostelGradeId)
        {
            $stmt = $dbConn->prepare('DELETE FROM hostelgrade WHERE grade_id = :grade_id;');    
            $stmt->bindValue(':grade_id', $hostelGradeId);  

            return $stmt->execute() ? true : false;
        }  

        //
        // hostelprice
        //
        function getHostelPrice(&$outHostelPrice, $priceId)
        {
            $stmt = $dbConn->prepare('SELECT * FROM hostelprice WHERE hostelprice_id = :price_id;');
            $stmt->bindValue(':price_id', $priceId);
            
            if (!$stmt->execute())  
                return false;
            
            $outHostelPrice = $stmt->fetchAll(); 
            return true;
        }          

        function newHostelPrice($weeksDaysPrice, $weekEndPrice, $arrivedDate, $leaveDate, $hostelSizeId, $hostelGradeId)
        {
            $stmt = $dbConn->prepare('INSERT INTO hostelprice(weeksdaysprice,weekendprice,arriveddate,leavedate,hostelsize_size_id,hostelgrade_grade_id)
                                    VALUES(:weeksdaysprice,:weekendprice,:arriveddate,:leavedate,:hostelsize_size_id,:hostelgrade_grade_id);');
            $stmt->bindValue(':weeksdaysprice', $weeksDaysPrice);
            $stmt->bindValue(':weekendprice', $weekEndPrice);
            $stmt->bindValue(':arriveddate', $arrivedDate);
            $stmt->bindValue(':leavedate', $leaveDate);
            $stmt->bindValue(':hostelsize_size_id', $hostelSizeId);
            $stmt->bindValue(':hostelgrade_grade_id', $hostelGradeId);

            return $stmt->execute() ? true : false;
        }   
        
        function editHostelPrice($hostelPriceId, $weeksDaysPrice, $weekEndPrice, $arrivedDate, $leaveDate, $hostelSizeId, $hostelGradeId)
        {
            $stmt = $dbConn->prepare('UPDATE hostelprice SET weeksdaysprice = :weeksdaysprice,
                                    weekendprice = :weekendprice, arriveddate = :arriveddate,
                                    leavedate = :leavedate, hostelsize_size_id = :hostelsize_size_id,
                                    hostelgrade_grade_id =:hostelgrade_grade_id 
                                    WHERE hostelprice_id = :hostelprice_id;');
            $stmt->bindValue(':weeksdaysprice', $weeksDaysPrice);
            $stmt->bindValue(':weekendprice', $weekEndPrice);
            $stmt->bindValue(':arriveddate', $arrivedDate);
            $stmt->bindValue(':leavedate', $leaveDate);
            $stmt->bindValue(':hostelsize_size_id', $hostelSizeId);
            $stmt->bindValue(':hostelgrade_grade_id', $hostelGradeId);
            $stmt->bindValue(':hostelprice_id', $hostelPriceId);

            return $stmt->execute() ? true : false;
        }    
        
        function removeHostelPrice($hostelPrice)
        {
            $stmt = $dbConn->prepare('DELETE FROM hostelprice
                                    WHERE hostelprice_id = :hostelprice_id;');    
            $stmt->bindValue(':hostelprice_id', $hostelPrice);  

            return $stmt->execute() ? true : false;
        }  

        //
        // hostel_reserve
        //
        function getHostelReserve(&$outHostelReserve)
        {
            $stmt = $dbConn->prepare('SELECT * FROM hostel_reserve;');
            
            if (!$stmt->execute())  
                return false;
            
            $outHostelReserve = $stmt->fetchAll(); 
            return true;
        }          

        function newHostelReserve($hostelId, $reserveId, $reservedDate)
        {
            $stmt = $dbConn->prepare('INSERT INTO hostel_reserve(hostel_hostel_id,reserve_reserve_id,reserved_date)
                                    VALUES(:hostel_hostel_id,:reserve_reserve_id,:reserved_date);');
            $stmt->bindValue(':hostel_hostel_id', $hostelId);
            $stmt->bindValue(':reserve_reserve_id', $reserveId);
            $stmt->bindValue(':reserved_date', $reservedDate);

            return $stmt->execute() ? true : false;
        }   
        
        function editHostelReserve($hostelReserve, $hostelId, $reserveId, $reservedDate)
        {
            $stmt = $dbConn->prepare('UPDATE hostel_reserve SET hostel_hostel_id = :hostel_hostel_id,
                                    reserve_reserve_id = :reserve_reserve_id,reserved_date = :reserved_date
                                    WHERE room_reserve_id = :room_reserve_id;');
            $stmt->bindValue(':hostel_hostel_id', $hostelId);
            $stmt->bindValue(':reserve_reserve_id', $reserveId);
            $stmt->bindValue(':reserved_date', $reservedDate);
            $stmt->bindValue(':room_reserve_id', $hostelReserve);

            return $stmt->execute() ? true : false;
        }    
        
        function removeHostelReserve($hostelReserve)
        {
            $stmt = $dbConn->prepare('DELETE FROM hostel_reserve WHERE room_reserve_id = :room_reserve_id;');    
            $stmt->bindValue(':room_reserve_id', $hostelReserve);  

            return $stmt->execute() ? true : false;
        }  

        //
        // hostelsize
        //
        function getHostelSize(&$outHostelSize)
        {
            $stmt = $dbConn->prepare('SELECT * FROM hostelsize;');
            
            if (!$stmt->execute())  
                return false;
            
            $outHostelsize = $stmt->fetchAll(); 
            return true;
        }          

        function newHostelSize($description, $interior)
        {
            $stmt = $dbConn->prepare('INSERT INTO hostelsize(description,interior)
                                    VALUES(:description,:interior);');
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':interior', $interior);

            return $stmt->execute() ? true : false;
        }   
        
        function editHostelSize($hostelSizeId, $description, $interior)
        {
            $stmt = $dbConn->prepare('UPDATE hostelsize SET description = :description,
            interior = :interior WHERE size_id = :size_id;');
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':interior', $interior);
            $stmt->bindValue(':size_id', $hostelSizeId);

            return $stmt->execute() ? true : false;
        }    
        
        function removeHostelSize($hostelSizeId)
        {
            $stmt = $dbConn->prepare('DELETE FROM hostelsize
                                    WHERE size_id = :size_id;');    
            $stmt->bindValue(':size_id', $hostelSizeId);  

            return $stmt->execute() ? true : false;
        } 

        //
        // reserve
        //
        function getReserve(&$outReserve)
        {
            $stmt = $dbConn->prepare('SELECT * FROM reserve;');
            
            if (!$stmt->execute())  
                return false;
            
            $outReserve = $stmt->fetchAll(); 
            return true;
        }          

        function newReserve($timeReserved, $cancel, $discount, $checkedIn, $checkedOut, $clientId)
        {
            $stmt = $dbConn->prepare('INSERT INTO reserve(time_reserved,cancel,discount,checked_in,checked_out,client_client_id)
                                    VALUES(:time_reserved,:cancel,:discount,:checked_in,:checked_out,:client_client_id);');
            $stmt->bindValue(':time_reserved', $timeReserved);
            $stmt->bindValue(':cancel', $cancel);
            $stmt->bindValue(':discount', $discount);
            $stmt->bindValue(':checked_in', $checkedIn);
            $stmt->bindValue(':checked_out', $checkedOut);            
            $stmt->bindValue(':client_client_id', $clientId);

            return $stmt->execute() ? true : false;
        }   
        
        function editReserve($reserveId, $timeReserved, $cancel, $discount, $checkedIn, $checkedOut, $clientId)
        {
            $stmt = $dbConn->prepare('UPDATE reserve SET time_reserved = :time_reserved,cancel = :cancel,
                                    discount = :discount,checked_in = :checked_in,checked_out = :checked_out,
                                    client_client_id = :client_client_id
                                    WHERE reserve_id = :reserve_id;');
            $stmt->bindValue(':time_reserved', $timeReserved);
            $stmt->bindValue(':cancel', $cancel);
            $stmt->bindValue(':discount', $discount);
            $stmt->bindValue(':checked_in', $checkedIn);
            $stmt->bindValue(':checked_out', $checkedOut);            
            $stmt->bindValue(':client_client_id', $clientId);
            $stmt->bindValue(':reserve_id', $hostereserveIdlSizeId);

            return $stmt->execute() ? true : false;
        }    
        
        function removeReserve($reserveId)
        {
            $stmt = $dbConn->prepare('DELETE FROM reserve WHERE reserve_id = :reserve_id;');    
            $stmt->bindValue(':reserve_id', $reserveId);  

            return $stmt->execute() ? true : false;
        } 
    }
?>
