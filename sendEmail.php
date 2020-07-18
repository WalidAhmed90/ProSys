Gr<?php
$title = "ProSys";
$subtitle = "Send Email";
include("include/head.php");
include ('db/db_connect.php');
session_start();

$username = $_SESSION["usrnm"];
//
include("libraries/sendgrid-php/sendgrid-php.php");
$sendgrid = new SendGrid('SendGridApi');

//Check if form is submitted by POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['btnSendMail'])) {
        $recipient = $_POST['recipient'];
        $subject = $_POST['subject'];
        $msgBody = $_POST['msgBody'];

        //Setting up SendGrid
        $email = new SendGrid\Email();

        $email
        ->addTo($recipient)
        ->setFrom('$fromEmail')
        ->setFromName($username)
        ->setSubject($subject)
        ->setHtml($msgBody);

        try {
            $res = $sendgrid->send($email);
            if ($res->getCode() == 200){
                //Email send successfully
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=t');
            }
            else{
                header('Location:' . $_SERVER['PHP_SELF'] . '?status=f');
            }

        } catch (\SendGrid\Exception $e) {
            echo $e->getCode();
            foreach ($e->getErrors() as $er) {
                echo $er;
                exit;
            }
        }




    }
}
?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php
