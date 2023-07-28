<!DOCTYPE html>
<?php
    include('dbcon.php');
    if($conn)
    {
        if(isset($_POST['submit']))
        {
            if(!empty($_POST['name']) && !empty($_POST['contact']) && !empty($_POST['email']))
            {
                $name = $_POST['name'];
                $con = $_POST['contact'];
                $email = $_POST['email'];
                $subject = $_POST['subject'];
                $msg = $_POST['message'];
                $ip = $_SERVER['REMOTE_ADDR'];
                
                if (!preg_match ("/^[a-zA-z]*$/", $name) ) 
                {  
                    $nameErr = "*Only alphabets and whitespace are allowed.";
                } 
                else
                {  
                    if (!preg_match ('/^[0-9]{10}+$/', $con) )
                    {  
                        $conErr = "*Contact field must be filled properly";  
                    } 
                    else 
                    {  
                        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^"; 
                        if (!preg_match ($pattern, $email) )
                        {  
                            $emailErr = "*Email valid email";
                        }
                        else 
                        {  
                            if(empty($subject))
                            {
                                $subErr = "*Subject must not be empty";
                            }
                            else
                            {
                                if(empty($msg))
                                {
                                    $msgErr = "*Message must not be empty";
                                }
                                else
                                {
                                    echo "<script>alert('else1');</script>";
                                    $query = "INSERT INTO `contact_form`(`name`, `contact`, `email`, `subject`, `message`, `ipadd`, `datetime`) VALUES ('$name', '$con', '$email', '$subject', '$msg', '$ip', current_timestamp())";
                                    $data = mysqli_query($conn, $query);
                                    if ($data) 
                                    {
                                        session_start();
                                        $_SESSION['name'] = $name;
                                        $_SESSION['contact'] = $con;
                                        $_SESSION['email'] = $email;
                                        $_SESSION['subject'] = $subject;
                                        $_SESSION['message'] = $msg;
                                        $_SESSION['ipa'] = $ip;

                                        header('location: email.php');
                                    }
                                    else
                                    {
                                        echo "<script>alert('Some Error occured at mysql');</script>";
                                    }
                                }
                            }
                        }    
                    }   
                } 
            }
            else
            {
                echo "<script>alert('Fields must not be empty');</script>";
            }
        }
    }
    else{
        echo "<script>alert('Connection error');</script>";
    }
    ?>
<html>
    <head>
        <title>
            Form
        </title>
    </head>
    <body>
        <h1> Fill this feedback form </h1>
        <form action="" method="post">
            Name: <input type="text" placeholder="Enter Name" value="<?php echo $name;?>" name="name">
            <p>
            <?php if(!empty($nameErr))
            { 
                echo $nameErr;
            } ?>
            </p>
            <br>
            Contact Number: <input type="text" placeholder="Enter Contact" value="<?php echo $con;?>" name="contact"> 
            <p>
            <?php if(!empty($conErr))
            { 
                echo $conErr;
            } ?>
            </p>
            <br>
            Email: <input type="text" placeholder="Enter Email" value="<?php echo $email;?>" name="email">
            <p>
            <?php if(!empty($emailErr))
            { 
                echo $emailErr;
            } ?>
            </p>
            <br>
            Subject: <input type="text" placeholder="Enter Subject" value="<?php echo $subject;?>" name="subject">
            <p>
            <?php if(!empty($subErr))
            { 
                echo $subErr;
            } ?>
            </p>
            <br>
            Message:
            <textarea name="message" rows="4" cols="50" placeholder="Enter your message here"><?php echo $msg;?></textarea> <br><br>
            <p>
            <?php if(!empty($msgErr))
            { 
                echo $msgErr;
            } ?>
            </p>
            <br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
</html>