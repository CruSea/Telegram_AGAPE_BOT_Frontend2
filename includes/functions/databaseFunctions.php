<?php 
class databaseAPI
{   
	//Getting Lab title using lab number
    public function get_Bot_ID($botName,$connection)
    {
        $sql = 'SELECT * FROM Bots where Name = ?';
        $q= $connection->prepare($sql);
        $q->execute(array($botName));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Bot_ID'];
    }

    public function get_Bot_Name($botID,$connection)
    {
        $sql = 'SELECT * FROM Bots where Bot_ID = ?';
        $q= $connection->prepare($sql);
        $q->execute(array($botID));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Name'];
    }
    //Getting Discussion topic using discussion number
    public function Discussion_Topic($discussionNo,$pdo)
    {
        $sql = 'SELECT * FROM Lab_Discussion_Topics where Discussion_No = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($discussionNo));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Discussion_Topic'];
    }
    public function Forum_Topic($forumNo,$pdo)
    {
        $sql = 'SELECT * FROM Forums where Forum_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($forumNo));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Forum_Topic'];
    }
    public function First_Name($id,$pdo)
    {
       $sql = 'SELECT * FROM Registered_Users where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['First_Name'];
    }
    public function Last_Name($id,$pdo)
    {
       $sql = 'SELECT * FROM Registered_Users where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Last_Name'];
    }
    public function User_Name($id,$pdo)
    {
        $sql = 'SELECT * FROM Registered_Users where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['User_Name'];
    }
    public function User_Grade_Level($id,$pdo)
    {
        $sql = 'SELECT * FROM Registered_Users where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Grade_Level'];
    }
    public function Lab_Added_By($labNo,$pdo)
    {
        $sql = 'SELECT * FROM Labs where Lab_No = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($labNo));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Added_By'];
    }
    //Retriving First_Name from School_Id table Using User_Id
    public function First_Name_School($id,$pdo)
    {
        $sql = 'SELECT * FROM School_Id where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['First_Name'];
    }
    //Retriving Last_Name from School_Id table using User_Id
    public function Last_Name_School($id,$pdo)
    {
        $sql = 'SELECT * FROM School_Id where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Last_Name'];
    }
    //Retriving User_type from School_Id table using User_Id
    public function User_Type_School($id,$pdo)
    {
        $sql = 'SELECT * FROM School_Id where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['User_Type'];
    }
    //Checking Whether or not a given user id exist in School_Id table
    public function Id_Exist($id,$pdo)
    {
        $sql = 'SELECT * FROM School_Id where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        if($data->rowCount()>0)
        {
            return true;
        }
        else 
            return false;

    }
    //Checking a user is valid or not by matching its first name last name and user id
    public function  Valid_User($id,$firstName,$lastName,$userType)
    {
        $sql = 'SELECT * FROM School_Id where User_Id = ?';
        $q= $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        if(($firstName==$data['First_Name'])&&($lastName==$data['Last_Name'])&&($userType==$data['User_Type']))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

}
?>