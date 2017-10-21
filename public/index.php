        <?php
        //Including database.php File From includes/database Directory
        require_once '../includes/database/dbconfig.php';
        require '../includes/database/database.php';
        require '../includes/functions/databaseFunctions.php';
        //Connecting to the Database
        $connection = Database::connect();
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $api = new databaseAPI();
        $page=null;
        $botSelected=null;
        $valid=true;
        $validMenu = true;
        

        //Getting $page From Global _GET Variable
        if(!empty($_GET['page']))
        {
            $page=$_REQUEST['page'];
        }
        //Getting forum from global $_GET variable
        if(!empty($_GET['botSelected']))
        {
            $botSelected=$_REQUEST['botSelected'];
        }
        
        //Getting $startrow from Global _GET variable
        if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) 
        {
            $startrow = 0;
        } 
        else 
        {
            $startrow = (int)$_GET['startrow'];
        }
        //Geting Form Values From  Global _Post Variable
        if (!empty($_POST)) 
        {
            if($page=='menu')
            {
                // keep Track Validation Errors
                echo $botSelected;
                $botID = $api->get_Bot_ID($botSelected,$connection);
                echo $botID;
                $menuNameError = null;
                $menuDescError = null;
                // Keep Track Form Values
                $menuName = trim($_POST['menuName']);
                $menuDesc = trim($_POST['menuDesc']);
                //Validate Forum Title
                if (empty($menuName)) 
                {
                    $menuNameError = 'Please Enter Menu Name!';
                    $validMenu = false;
                }
                //Insert Data In To Forums Table
                if ($validMenu) 
                {
                    $sql = "INSERT INTO Menus (Bot_ID,Name,Description) VALUES (?,?,?)";
                    $q = $connection->prepare($sql);
                    $q->execute(array($botID,$menuName,$menuDesc));
                    header("Location: index.php?page=registered");
                }
            }
            else if($page=='submenu')
            {
                // keep Track Validation Errors
                $botNameError = null;
                $botTokenError = null;
                $botDescError = null;
                // Keep Track Form Values
                $botName = trim($_POST['botName']);
                $botToken = trim($_POST['botToken']);
                $botDesc = trim($_POST['botDesc']);
                //Validate Forum Title
                if (empty($botName)) 
                {
                    $botNameError = 'Please Enter Bot Name!';
                    $valid = false;
                }
                //Validate Forum Topic 
                if (empty($botToken)) 
                {   
                    $botTokenError= 'Please Enter Token!';
                    $valid = false;
                }
                //Insert Data In To Forums Table
                if ($valid) 
                {
                    $sql = "INSERT INTO Bots (Name,Token,Description) VALUES (?,?,?)";
                    $q = $connection->prepare($sql);
                    $q->execute(array($botName,$botToken,$botDesc));
                    header("Location: index.php?page=registered");
                }

            }
            else
            {
                 // keep Track Validation Errors
                $botNameError = null;
                $botTokenError = null;
                $botDescError = null;
                // Keep Track Form Values
                $botName = trim($_POST['botName']);
                $botToken = trim($_POST['botToken']);
                $botDesc = trim($_POST['botDesc']);
                //Validate Forum Title
                if (empty($botName)) 
                {
                    $botNameError = 'Please Enter Bot Name!';
                    $valid = false;
                }
                //Validate Forum Topic 
                if (empty($botToken)) 
                {   
                    $botTokenError= 'Please Enter Token!';
                    $valid = false;
                }
                //Insert Data In To Forums Table
                if ($valid) 
                {
                    $sql = "INSERT INTO Bots (Name,Token,Description) VALUES (?,?,?)";
                    $q = $connection->prepare($sql);
                    $q->execute(array($botName,$botToken,$botDesc));
                    header("Location: index.php?page=registered");
                }

            }
        }
        else
        {
            if($page=='addNewBot'||$page=='registered'||$page=='addMenu')
            {   
                $sql = "SELECT * FROM Bots ";
                $q = $connection->prepare($sql);
                $q->execute();
                $sql1 = 'SELECT * FROM Bots ';//LIMIT '.$startrow.', 5';
                $data = $q->fetch(PDO::FETCH_ASSOC);
                $count=$q->rowCount();
            }
            if($page=='viewMenu')
            {
                $botID = $api->get_Bot_ID($botSelected,$connection);
                $sql = "SELECT * FROM Menus Where Bot_ID = ?";
                $q = $connection->prepare($sql);
                $q->execute(array($botID));
                $sql1 = 'SELECT * FROM Menus Where Bot_ID = "'.$botID.'" LIMIT '.$startrow.', 5';
                $data = $q->fetch(PDO::FETCH_ASSOC);
                $count=$q->rowCount();
            }
            
        }
        Database::disconnect();//Disconnecting the connection with the database
        ?>
        <?php include("../includes/layouts/header.php");?><!--Including header.php File From includes/layouts Directory-->
        <ul><!--The Beginning of Navigation Bar Menus-->
            <li class="active"><a href="#" >Manage Bots</a></li>
            <li><a href="#" >About Us</a></li>
            <li><a href="#" >Contact Us</a></li>
            <li><a href="#" >Logout</a></li>
        <div class="clearfix">
        </div>
        </ul><!--The End of Navigation Bar Menus-->
        <script>
        $("span.menu").click(function()
        {
            $(".top-nav ul").slideToggle(500, function()
            {});
        });
        </script>
        </div>
        </div>
        </div>
        <!--The Main Content of This Page Start Here-->
        <div class="about"><!--The Beginning of About div-->
        <div class="container"><!--The Beginning of Main Container-->
        <div class="about-md1"><!--The Beginning of about-md1 div-->
        <!--The Beginning of col-md-3 col-2 div-->
        <div class="col-md-3 col-2">
        <!--Beginning of forums by status well-->
        <div class="well">
            <p><a href="index.php?page=addNewBot">Add New Bot</a></p>
            <p><a href="manageForums.php?page=confirmed">Registered Bots</a></p>
        </div>
        <!--End of forums by status well-->
        </div>
        <!--The End of col-md-3 col-2 div-->
        <!--The Beginning of col-md-9 col-2 div-->
        <div class="col-md-9 col-2">
        <!--The Beginning of Row div-->
        <div class="row">
        <?php 
        if($page=='addNewBot'||$page=='registered'||$page=='addMenu')
        {
            $no=1;//For Numbering
           
            echo '<h4>Registered Bots</h4><br />';

            echo '<table class="table table-striped table-bordered">';//The Beginning of the table
            echo '<thead>';//The Beginning of table header
            echo '<tr>';
            echo '<th>NO.</th>';
            echo '<th>Bot ID</th>';
            echo '<th>Bot Name</th>';
            echo '<th>Token</th>';
            echo '<th>Actions</th>';
            echo '</tr>';
            echo '</thead>';//The End Of Table Header
            echo '<tbody>';//The End Of Table Body
            foreach($connection->query($sql1) as$row) //to iterate trough all fetched rows and fill them to the body of table
            //Using foreach loop
            {
            echo '<tr>';
            echo '<td width=2>'. $no.'.'. '</td>';
            echo '<td width=100>'.$row['Bot_ID'].'</td>';
            echo '<td width=150>'.$row['Name'].'</td>';
            echo '<td>'.$row['Token'].'</td>';
            //Possible Action Buttons For New,Ignored And Blocked Forums
            
            echo '<td width=200 class="text-center">';
            echo '<a class="btn btn-default" href="index.php?page=addMenu&botSelected='.$row['Name'].'">Add Menu</a>';
            echo ' ';
            echo '<a class="btn btn-default" href="index.php?page=viewMenu&botSelected='.$row['Name'].'">Menus</a>';
            echo '</td>';
            echo '</tr>';
            
            //Possible Action Buttons For Suspended Forums
           
            $no++;
            }
            //The End Of Table Body
            echo '</tbody>';//The End of table body
            echo '</table>';//The End of table
            //Pagination
            //Pagenate Selected Page
            
            //Go To Next
            if($count>$startrow+5)
            echo '<a class="btn btn-info" href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+5).'&page='.$pagenate.'">Next</a>';
            echo '  ';
            //Go To Previous
            $prev = $startrow - 5;
            if ($prev >= 0)
            echo '<a class="btn btn-success" href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'&page='.$pagenate.'">Previous</a>';
        }
        else if($page=='viewMenu')
        {

            $no=1;//For Numbering

            echo '<h4>Registered Menus Under '.$botSelected.' Bot</h4><br />';
           
            echo '<table class="table table-striped table-bordered">';//The Beginning of the table
            echo '<thead>';//The Beginning of table header
            echo '<tr>';
            echo '<th>NO.</th>';
            echo '<th>Menu ID</th>';
            echo '<th>Bot</th>';
            echo '<th>Menu Name</th>';
            echo '<th>Actions</th>';
            echo '</tr>';
            echo '</thead>';//The End Of Table Header
            echo '<tbody>';//The End Of Table Body
            foreach($connection->query($sql1) as$row) //to iterate trough all fetched rows and fill them to the body of table
            //Using foreach loop
            {
            echo '<tr>';
            echo '<td width=2>'. $no.'.'. '</td>';
            echo '<td width=100>'.$row['Menu_ID'].'</td>';
            echo '<td width=150>'.$api->get_Bot_Name($row['Bot_ID'],$connection).'</td>';
            echo '<td>'.$row['Name'].'</td>';
            //Possible Action Buttons For New,Ignored And Blocked Forums
            
            echo '<td width=250 class="text-center">';
            echo '<a class="btn btn-default" href="index.php?page=addMenu&menuSelected='.$row['Name'].'">Add Sub Menu</a>';
            echo ' ';
            echo '<a class="btn btn-default" href="index.php?page=viewMenu&menuName='.$row['Name'].'">Sub Menus</a>';
            echo '</td>';
            echo '</tr>';
            
            //Possible Action Buttons For Suspended Forums
           
            $no++;
            }
            //The End Of Table Body
            echo '</tbody>';//The End of table body
            echo '</table>';//The End of table
            
        }
        //Forum Successfully Suspended Message
       
        //Forum Successfully Deleted Message
        
        if(!$valid||$page=='addNewBot')
        {
            echo "<script type='text/javascript'>
            $(document).ready(function(){
            $('#addNewBot').modal('show');
            });
            </script>";
        }

         if(!$valid||$page=='addMenu')
        {
            echo "<script type='text/javascript'>
            $(document).ready(function(){
            $('#addNewMenu').modal('show');
            });
            </script>";
        }

        if($page=='added')
        {
            echo "<script type='text/javascript'>
            $(document).ready(function(){
            $('#messageModal').modal('show');
            });
            </script>";
        }
        ?>
        
        <!--Add New Bot Modal Begin Here-->
        <div class="modal fade" id="addNewBot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <!--The Modal Dialog Start Here-->
        <div class="modal-dialog">
        <!--The Beginning Of Modal Content-->
        <div class="modal-content">
        <!--The Beginning Of Modal Header-->
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        <h3 class="modal-title" id="myModalLabel" >Add New Bot</h3>
        </div>
        <!--The End Of Modal Header-->
        <!--The Beginning Of Modal Body-->
        <div class="modal-body">
        <!--Add New Bot Form Begin Here-->
        <?php 
        echo '<form class="form-horizontal" role="form" action="index.php?page=error" method="post">';

            //Name Form Group Begin Here
            echo '<div class="form-group ';
            echo !empty($botNameError)?'has-error':'';
            echo '">';
            echo '<label class="control-label col-md-3" for="botName">Bot Name</label><div class="col-md-6">';
            echo '<input type="text" class="form-control" id="botName" placeholder="Enter Bot Name?" name="botName">';
            echo '</div>';
            if (!empty($botNameError)):
            echo $botNameError;
            endif; 
            echo '</div>';
            //Name Form Group End Here
            
            //Token Form Group Begin Here
            echo '<div class="form-group ';
            echo !empty($botTokenError)?'has-error':'';
            echo '">';
            echo '<label class="control-label col-md-3" for="botToken">Bot Token</label><div class="col-md-6">';
            echo '<input type="text" class="form-control" id="botToken" placeholder="Enter Bot Token?" name="botToken">';
            echo '</div>';
            if (!empty($botTokenError)):
            echo $botTokenError;
            endif; 
            echo '</div>';
            //Token Form Group End Here
            
            //Description Form Group Begin Here
            echo '<div class="form-group ';
            echo '">';
            echo '<label class="control-label col-md-3" for="botDesc">Description</label><div class="col-md-6">';
            echo '<input type="text" class="form-control" id="botDesc" placeholder="Enter Description?" name="botDesc">';
            echo '</div>';
            echo '</div>';
            //Description form Group End Here

            //Submit Form Group Begin Here
            echo '<div class="form-group">';
            echo '<div class="col-md-offset-3 col-md-4">';
            echo '<button type="submit" class="btn btn-success">Register Bot</button>';
            echo '</div>';
            echo '</div>';
            //Submit Form Group End Here

            echo '</form>';
        ?>
        <!--Add New Bot Form End Here-->
        <!--The Beginning Of Modal Footer-->
        <div class="modal-footer">
        <button type="button" class="btn btn-default"data-dismiss="modal">Close</button>
        </div>
        <!--The End Of Modal Footer-->
        </div>
        <!--The End Of Modal Body-->
        </div>
        <!--The End Of Modal Content-->
        </div>
        <!--The End Of Modal Dialog-->
        </div>
        <!--End of Add New Bot Modal-->

        <!--Add New Menu Modal Begin Here-->
        <div class="modal fade" id="addNewMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <!--The Modal Dialog Start Here-->
        <div class="modal-dialog">
        <!--The Beginning Of Modal Content-->
        <div class="modal-content">
        <!--The Beginning Of Modal Header-->
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        <h3 class="modal-title" id="myModalLabel" >Add New Menu</h3>
        </div>
        <!--The End Of Modal Header-->
        <!--The Beginning Of Modal Body-->
        <div class="modal-body">
        <!--Add New Bot Form Begin Here-->
        <?php 
        echo '<form class="form-horizontal" role="form" action="index.php?page=menu&botSelected='.$botSelected.'" method="post">';

            //Menu Name Form Group Begin Here
            echo '<div class="form-group ';
            echo !empty($menuNameError)?'has-error':'';
            echo '">';
            echo '<label class="control-label col-md-3" for="menuName">Menu Name</label><div class="col-md-6">';
            echo '<input type="text" class="form-control" id="menuName" placeholder="Enter Menu Name?" name="menuName">';
            echo '</div>';
            if (!empty($menuNameError)):
            echo $menuNameError;
            endif; 
            echo '</div>';
            //Menu Name Form Group End Here
            
            
            //Description Form Group Begin Here
            echo '<div class="form-group ';
            echo '">';
            echo '<label class="control-label col-md-3" for="menuDesc">Description</label><div class="col-md-6">';
            echo '<input type="text" class="form-control" id="menuDesc" placeholder="Enter Description?" name="menuDesc">';
            echo '</div>';
            echo '</div>';
            //Description form Group End Here

            //Submit Form Group Begin Here
            echo '<div class="form-group">';
            echo '<div class="col-md-offset-3 col-md-4">';
            echo '<button type="submit" class="btn btn-success">Register Menu</button>';
            echo '</div>';
            echo '</div>';
            //Submit Form Group End Here

            echo '</form>';
        ?>
        <!--Add New Bot Form End Here-->
        <!--The Beginning Of Modal Footer-->
        <div class="modal-footer">
        <button type="button" class="btn btn-default"data-dismiss="modal">Close</button>
        </div>
        <!--The End Of Modal Footer-->
        </div>
        <!--The End Of Modal Body-->
        </div>
        <!--The End Of Modal Content-->
        </div>
        <!--The End Of Modal Dialog-->
        </div>
        <!--End of Add New Bot Modal-->

         <!--Add New Sub Menu Modal Begin Here-->
        <div class="modal fade" id="addNewMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <!--The Modal Dialog Start Here-->
        <div class="modal-dialog">
        <!--The Beginning Of Modal Content-->
        <div class="modal-content">
        <!--The Beginning Of Modal Header-->
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        <h3 class="modal-title" id="myModalLabel" >Add New Sub Menu</h3>
        </div>
        <!--The End Of Modal Header-->
        <!--The Beginning Of Modal Body-->
        <div class="modal-body">
        <!--Add New Bot Form Begin Here-->
        <?php 
        echo '<form class="form-horizontal" role="form" action="index.php?page=subMenu&menuSelected='.$menuSelected.'" method="post">';

            //Menu Name Form Group Begin Here
            echo '<div class="form-group ';
            echo !empty($menuNameError)?'has-error':'';
            echo '">';
            echo '<label class="control-label col-md-3" for="menuName">Menu Name</label><div class="col-md-6">';
            echo '<input type="text" class="form-control" id="menuName" placeholder="Enter Menu Name?" name="menuName">';
            echo '</div>';
            if (!empty($menuNameError)):
            echo $menuNameError;
            endif; 
            echo '</div>';
            //Menu Name Form Group End Here
            
            
            //Description Form Group Begin Here
            echo '<div class="form-group ';
            echo '">';
            echo '<label class="control-label col-md-3" for="menuDesc">Description</label><div class="col-md-6">';
            echo '<input type="text" class="form-control" id="menuDesc" placeholder="Enter Description?" name="menuDesc">';
            echo '</div>';
            echo '</div>';
            //Description form Group End Here

            //Submit Form Group Begin Here
            echo '<div class="form-group">';
            echo '<div class="col-md-offset-3 col-md-4">';
            echo '<button type="submit" class="btn btn-success">Register Menu</button>';
            echo '</div>';
            echo '</div>';
            //Submit Form Group End Here

            echo '</form>';
        ?>
        <!--Add New Bot Form End Here-->
        <!--The Beginning Of Modal Footer-->
        <div class="modal-footer">
        <button type="button" class="btn btn-default"data-dismiss="modal">Close</button>
        </div>
        <!--The End Of Modal Footer-->
        </div>
        <!--The End Of Modal Body-->
        </div>
        <!--The End Of Modal Content-->
        </div>
        <!--The End Of Modal Dialog-->
        </div>
        <!--End of Add New Bot Modal-->


        <!--Beginning of message modal-->
        <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <!--The Modal Dialog Start Here-->
        <div class="modal-dialog">
        <!--The Beginning Of Modal Content-->
        <div class="modal-content">
        <!--The Beginning Of Modal Header-->
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        <h3 class="modal-title" id="myModalLabel" >Succedded</h3>
        </div>
        <!--The End Of Modal Header-->
        <!--The Beginning Of Modal Body-->
        <div class="modal-body">
        <!--Beginning of add new forum form-->
        <?php 
        echo '<span>Forum successfully added.!</span>';
        ?>
        <!--End of add new forum form-->
        <!--The Beginning Of Modal Footer-->
        <div class="modal-footer">
        <button type="button" class="btn btn-default"data-dismiss="modal">Close</button>
        </div>
        <!--The End Of Modal Footer-->
        </div>
        <!--The End Of Modal Body-->
        </div>
        <!--The End Of Modal Content-->
        </div>
        <!--The End Of Modal Dialog-->
        </div>
        <!--End of message modal-->
        </div><!--The End of Row div-->
        </div><!--The End of col-md-9 col-2-->
        <div class="clearfix"> </div>
        </div><!--The End of About-md1 div-->
        </div><!--The End of Main Container-->
        </div><!--The End of About div-->
        <!--Including Layout Files from includes/layouts Directory-->
        <?php //include("../includes/layouts/inprofile.php") ?><!--Including inprofile.php File From includes/layouts/ Directory-->
        <?php include("../includes/layouts/footer.php");?><!--Including footer.php File From includes/layouts/ Directory-->