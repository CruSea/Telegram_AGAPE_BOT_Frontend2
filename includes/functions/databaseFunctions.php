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

    public function get_Menu_ID($menuName,$connection)
    {

        $sql = 'SELECT * FROM Menus where Name = ?';
        $q= $connection->prepare($sql);
        $q->execute(array($menuName));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Menu_ID'];

    }

    public function get_Menu_Name($menuID,$connection)
    {
        $sql = 'SELECT * FROM Menus where Menu_ID = ?';
        $q= $connection->prepare($sql);
        $q->execute(array($menuID));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data['Name'];
    }

    public function delete_Bot($botID,$connection)
    {
        $sql = 'Delete From Bots Where Bot_ID = ?';
        $query = $connection->prepare($sql);
        $query->execute(array($botID));
    }
    
    public function delete_Menu($menuID,$connection)
    {
        $sql = 'Delete From Menus Where Menu_ID = ?';
        $query = $connection->prepare($sql);
        $query->execute(array($menuID));
    }
    public function delete_Sub_Menu($subID,$connection)
    {
        $sql = 'Delete From Sub_Menus Where Sub_Menu_ID = ?';
        $query = $connection->prepare($sql);
        $query->execute(array($subID));
    }

}
?>