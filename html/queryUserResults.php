<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/queryUserResults.css">
    <title>User Results</title>
</head>
<?php
include 'navBar.php';
?>
<body style="margin-top:7em">

<div class="main">
<div id="breadcrumbs"></div>
<div id="keyword">

</div>
<div class="columns">
    <div class="grid-container">
            <?php include 'config.php';
                //only admin can use this page
                if (isset($_SESSION['user']) && $_SESSION['user'] === "admin"){
                    
                echo "<div class=\"grid-entry\">";
                if($_SERVER["REQUEST_METHOD"] === "GET"){
                    if (isset($_GET["name"]) && $_GET["name"] != ""){
                        $name = $_GET["name"];
                        echo "<h2>Searched: ".$name."</h2></br>";
                        $name = "%".$name."%";

                        $sql = "SELECT username, firstname, lastname, disabled FROM users WHERE username LIKE :first OR firstname LIKE :last";
                        $statement = $pdo->prepare($sql);
                        $statement->execute(array(':first' => $name, ':last' => $name));
                        echo "<table><tr><th>Username</th><th>Name</th><th>Disabled</th></tr>";
                        while($row = $statement->fetch()){
                            echo "<tr><td><a href=\"getUserProfile.php?user=".$row['username']."\">".$row['username']."</a></td>";
                            echo "<td>".$row['firstname']." ".$row['lastname']."</td>";
                            if ($row['disabled'] == 0){
                                echo"<td style=\"color:green\">False</td></tr>";
                            }
                            else{
                                echo"<td style=\"color:red\">True</td></tr>";
                            }
                        }
                        echo "</table>";
                        $pdo = null;
                        $results = null;
                    }
                    else if (isset($_GET["email"]) && $_GET["email"] != ""){
                        $email = $_GET["email"];
                        echo "<h2>Searched: ".$email."</br></h2>";

                        $sql = "SELECT username, email FROM users WHERE email LIKE ?";
                        $statement = $pdo->prepare($sql);
                        $statement->execute(["$email%"]);
                        echo "<table><tr><th>Username</th><th>Email</th></tr>";
                        while($row = $statement->fetch()){
                            echo "<tr><td>".$row['username']."</td>";
                            echo "<td>".$row['email']."</td></tr>";
                        }
                        echo "</table>";
                        $pdo = null;
                        $results = null;
                    }
                    else if (isset($_GET["post"]) && $_GET["post"] != ""){
                        $post = $_GET["post"];
                        echo "<h2>Searched: ".$post."</br></h2>";

                        $sql = "SELECT username, ptitle FROM post WHERE ptitle LIKE ?";
                        $statement = $pdo->prepare($sql);
                        $statement->execute(["%$post%"]);
                        echo "<table><tr><th>Username/Post Owner</th><th>Post</th></tr>";
                        while($row = $statement->fetch()){
                            echo "<tr><td>".$row['username']."</td>";
                            echo "<td>".$row['ptitle']."</td></tr>";
                        }
                        echo "</table>";
                        $pdo = null;
                        $results = null;
                    }
                }
            }
            else{
                exit();
            }
            ?>
    </div>
</div>
</div>
</body>
<?php include 'footer.php'; ?>
</html>