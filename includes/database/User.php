<?php
class USER
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
    public function register($fname,$lname,$uname,$umail,$upass)
    {
       try
       {
           $new_password = password_hash($upass, PASSWORD_DEFAULT);
   
           $stmt = $this->db->prepare("INSERT INTO users(user_name,user_email,user_pass) 
                                                       VALUES(:uname, :umail, :upass)");
              
           $stmt->bindparam(":uname", $uname);
           $stmt->bindparam(":umail", $umail);
           $stmt->bindparam(":upass", $new_password);            
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    public function login($uname,$upass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM Registered_Users WHERE User_Name=:uname LIMIT 1");
          $stmt->execute(array(':uname'=>$uname));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
            
             if($upass==$userRow['Pssword'])
             {  
               if($userRow['User_Status']=='Confirmed')
            { 
                if($userRow['User_Type']=='Student')
                {
                $_SESSION['user_session'] = $userRow['User_Id'];
                return 1;
                }
                else if($userRow['User_Type']=='Teacher')
                {
                $_SESSION['user_session'] = $userRow['User_Id'];
                return 2;
                }
                
            }
            else if($userRow['User_Status']=='new')
            {
               return 4;
            }
            else if($userRow['User_Status']=='ignored')
            {
                return 5;
            }
            else if($userRow['User_Status']=='blocked')
            {
                return 6;
            }
             }
           
             else
             {
                return 3;
             }
          }
          return 7;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
}
?>