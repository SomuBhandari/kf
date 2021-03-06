<?php
    @require_once("db_connection.php");
    require("PHPMailer-5.2-stable/PHPMailerAutoload.php");

    //Checking session for valid user
    if(!array_key_exists("valid_user", $_SESSION) && empty($_SESSION["valid_user"]))
    {
        header('location:index.php');
    }


    if(array_key_exists("id", $_GET) && !empty($_GET["id"]))
    {
        header('Location:../verify.php?id='.$_GET["id"].'');
    }

    $nameerror = $emailerror = $phonenumbererror = $gendererror = $doberror = $rollnoerror = $institutionerror = " ";
    $name = $email = $phonenumbererror = $gender = $dob = $rollno = $institution =" ";
    $boolen = false;

    if($_SERVER["REQUEST_METHOD"]=="POST") {

    //Checking the validation for name
    if(empty($_POST["name"])) {
      $nameerror = "Name Required...";
      $boolen = false;
    }else {
        $name = validate_input($_POST["name"]);
        $boolen = true;
    }

    //Checking the validation for email
    if(empty($_POST["email"])) {
       $emailerror = "E-mail Required...";
       $boolen = false;
    }else if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
        // $emailerror = "Invalid E-mail...";
        // $boolen = false;
    }else {
      $email = $_POST["email"];
      $boolen = true;
    }

    //Checking the validation for gender
    if(empty($_POST["gender"])) {
        $gendererror = "Gender Required...";
        $boolen = false;
    }else {
        $gender = $_POST["gender"];
        $boolen = true;
    }

    //Checking the validation for number
    if(empty($_POST["phonenumber"])) {
        $phonenumbererror = "Gender Required...";
        $boolen = false;
    }else {
        $phonenumber = $_POST["phonenumber"];
        $boolen = true;
    }

    //Checking the validation for roll number
    if(empty($_POST["dob"])) {
        $doberror = "Date Of Birth Required...";
        $boolen = false;
    }else {
        $dob = $_POST["dob"];
        $boolen = true;
    }

    //Checking the validation for institution
    if(empty($_POST["institution"])) {
        $institutionerror = "Institution Required...";
        $boolen = false;
    }else {
        $institution = $_POST["institution"];
        $boolen = true;
    }

    //Checking the validation for institution
    if(empty($_POST["rollno"])) {
        $rollnoerror = "Roll Number Required...";
        $boolen = false;
    }else {
        $rollno = $_POST["rollno"];
        $boolen = true;
    }


    }


    function validate_input($data) {
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    if($boolen)
    {

     function AddUser() {
        $email = $_POST["email"];
        $name = $_POST["name"];
        $gender = $_POST["gender"];
        $phonenumber = $_POST["phonenumber"];
        $dob = $_POST["dob"];
        $institution = $_POST["institution"];
        $rollno = $_POST["rollno"];
        $user_id = $_SESSION['valid_user'];
        $unique_id = generateRandomString();
        $verifyLink = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."/?id=".$unique_id."";

        //Generating the KF ID
        $id="KF".rand(1,99999);
        $query= "SELECT id FROM participants_participant  where id='$id'";
        $result = mysqli_query($GLOBALS['connect'], $query);
        if ($result === true ){
            $KF_ID = $id;
        }
        else{
            $KF_ID="KF".rand(1,99999);
        }
        if($email && $name && $gender && $phonenumber && $dob && $institution && $unique_id && $rollno)
        {
        $sql = "INSERT INTO participants_participant (`name`,`email`,`phone`,`dob`,`gender`,`roll_no`,`institution`,`unique_id`,`verified`,`user_id`,`kf_id`) VALUES
            ('$name','$email','$phonenumber','$dob','$gender','$rollno','$institution','$unique_id',0,'$user_id','$KF_ID')";

        $result = $GLOBALS['connect']->query ($sql);

        if(!$result)
            echo mysqli_error($GLOBALS['connect']);

        if($result)
        {

            unset ($_SESSION["valid_user"]);
            session_destroy();

// $mail->setFrom('amit@gmail.com', 'Amit Agarwal');     //Set who the message is to be sent from
// $mail->addReplyTo('labnol@gmail.com', 'First Last');  //Set an alternative reply-to address
// $mail->addAddress('josh@example.net', 'Josh Adams');  // Add a recipient
// $mail->addAddress('ellen@example.com');               // Name is optional
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');
// $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
// $mail->addAttachment('/usr/labnol/file.doc');         // Add attachments
// $mail->addAttachment('/images/image.jpg', 'new.jpg'); // Optional name
// $mail->isHTML(true);                                  // Set email format to HTML

// $mail->Subject = 'Here is the subject';
// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

// //Read an HTML message body from an external file, convert referenced images to embedded,
// //convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

// if(!$mail->send()) {
//    echo 'Message could not be sent.';
//    echo 'Mailer Error: ' . $mail->ErrorInfo;
//    exit;
// }

// echo 'Message has been sent';

            if($result)
            {

            $mail = new PHPMailer;

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.zoho.com';                       // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'info@kiitfest.org';                   // SMTP username
            $mail->Password = '57t0n$lJ86%6';               // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
            $mail->Port = 465;
            $mail->AuthType = 'LOGIN';                               //Set the SMTP port number - 587 for authenticated
            $mail->setFrom('info@kiitfest.org', 'KIITFEST 5.0');
            $mail->addAddress($email);     // Add a recipient
                           // Name is optional
            $mail->Subject = 'Verify your Email';
            $mail->Body    = 'Greetings from KIITFEST!!
<br>You have successfully registered for KIITFEST 5.0 and now, you are a part of our very own legacy of over 4 years of jubilant celebration of arts, music, creativity. We hope to see your Undying Spirit relive the Chronicles of True Participation, Immense Zest and Pure Valediction. These are your credentials: KF ID: '.$KF_ID.' EMAIL: '.$email.'

<br>The next step to be a true part of KIITFEST 5.0 and for our verification VERIFICATION LINK:'.$verifyLink . '<br><b> Your KFID : ' .$KF_ID;
            $mail->AltBody = $verifyLink . $KF_ID;
                // $mail->subject = "My subject";
                // $mail->txt = "Hello world!";
                // $mail->headers = "From: webmaster@example.com" . "\r\n" .
                // "CC: somebodyelse@example.com";


                if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                   echo '<script>';
                   echo 'setTimeout(function(){swal("Congratulations!", "Mail Sent", "success")},150)';
                   echo '</script>';

                }
                  echo '<script>';
                echo 'setTimeout(function(){window.location.href = "https://kiitfest.org/index.html";},900)';
                  echo '</script>';
                // echo '<script>';
                // echo 'setTimeout(function(){window.location.href = "index.php";},700)';
                // echo '</script>';
            }
        }
        else
        {
            mysqli_error($GLOBALS['connect']);
        }
        }
    }

     function SignUp() {
        // $user = $_POST["username"];
        // $sql = "SELECT * FROM auth_user WHERE username = '$user'";
        // $result = mysqli_query($GLOBALS['connect'], $sql);
        // if(!$result)
        // {
        //     echo mysqli_error($GLOBALS['connect']);
        // }
        // if(!$row = mysqli_fetch_assoc($result))
        // {
           AddUser();

        // }
        // else {
        //     echo '<script>alert("Already Registered")</script>';

        // }
    }
     if(isset($_POST["submit"])) {
       SignUp();
       unset($_POST);
       // header(location:$_SERVER["PHP_SELF"]);
       //header('Location: '.$_SERVER["PHP_SELF"]);
       mysqli_close($GLOBALS['connect']);
       $boolen = false;
    }
}

?>


<html lang="en"><head>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="manifest" href="manifest.json">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<title>KIITFEST18</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
/* Style the footer */
.footer {
    background-color: white;
    padding: 10px;
    padding-top: 10px;
}
</style>
</head>
<body>

<div class="content"><center>
<img src="kf.png" height="150px" style="padding-bottom: 10px"><br>
<font style="font-family: 'Open Sans', sans-serif;font-size: 22px;color: #292929;">KIIT FEST 5.0</font><br><br>
<font style="font-family: 'Open Sans', sans-serif;font-size: 12px;color: #a09f9f;">
  <?php
    if(array_key_exists("valid_user_name", $_SESSION) && !empty($_SESSION["valid_user_name"]))
    {
        echo '<h3>Username :'.$_SESSION["valid_user_name"].' Dob format: yyyy/mm/dd</h3>';
    }
  ?>
</font>
</center>
 </div>

<div class="container">
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Name">
            <div style="color:red;"><?php echo $nameerror;?></div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">E-MAIL</label>
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" required placeholder="E-mail address">
            <div style="color:red;"><?php echo $emailerror;?></div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Phone Number</label>
            <input type="number" class="form-control" name="phonenumber" aria-describedby="emailHelp" placeholder="Phone Number">
            <div style="color:red;"><?php echo $phonenumbererror?></div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Gender</label>
            <select  name="gender" class="form-control">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Others</option>
            </select>
            <div style="color:red;"><?php echo $gendererror;?></div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Date Of Birth</label>
            <input type="date" class="form-control" name="dob" aria-describedby="emailHelp" placeholder="Date Of Birth">
        </div>
        <div style="color:red;"><?php echo $doberror?></div>
        <div class="form-group">
            <label for="exampleInputEmail1">Roll Number</label>
            <input type="number" class="form-control" name="rollno" aria-describedby="emailHelp" placeholder="Roll Number">
            <div style="color:red;"><?php echo $rollnoerror?></div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Institution</label>
            <input type="text" class="form-control" name="institution" aria-describedby="emailHelp" placeholder="Institution">
            <div style="color:red;"><?php echo $institutionerror?></div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<div class="footer">

</div><center><div style="margin-top: 30px;bottom: 0px;height: 30px;width: 100%; font-size: 12px;color: gray">Made with <i class="fas fa-heart" style="color: red;"></i> by <b>KIITFEST WEB TEAM</b>
</div></center>




</body>
</html>
