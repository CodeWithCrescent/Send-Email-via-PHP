<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // retrieve form data
    $mail_from = $_POST['mail_from']; //Badilisha Hapa, weka email yako kama unataka iwe fixed
    $app_password = $_POST['app_password']; // Na Hapa weka app password za email yako, hizi unazipata kwenye Google App Password 
    $name = $_POST['name'];
    $phone = $_POST['phone']; //Sijaitumia popote hii, incase ukitaka kuitumia you just pass $phone
    $email = $_POST['email_to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // create PHPMailer object
    $mail = new PHPMailer(true);

    // configure SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $mail_from;
    $mail->Password = $app_password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // set email content
    $mail->setFrom($mail_from, $name);
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // attempt to send email
    try {
        $mail->send();
        $success = true;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!-- Nichek +255 676827992 kama hujaelewa popote -->

<!DOCTYPE html>
<html>
<head>
    <title>Email Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
		body {
			background-color: #f2f2f2;
		}
        .text-center {
            text-align: center;
        }
        .required {
            color: red;
        }
        .success, .error {
            text-align: center;
        }
		form {
			background-color: #fff;
			padding: 20px;
			max-width: 500px;
			margin: auto;
			box-shadow: 0 0 10px rgba(0,0,0,0.2);
			border-radius: 5px;
			font-family: Arial, sans-serif;
		}
		input[type=text], input[type=email], input[type=tel], textarea {
			width: 100%;
			padding: 12px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
			margin-top: 6px;
			margin-bottom: 16px;
			resize: vertical;
		}
		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
		}
		input[type=submit]:hover {
			background-color: #45a049;
		}
</style>
<body>
    <div class="container">
        <h1 class="text-center">Email Me</h1>
        <?php if (isset($success) && $success) { ?>
            <p class="success">Your message has been sent!</p>
        <?php } else { ?>
            <?php if (isset($error)) { ?>
                <p class="error">An error occurred: <?php echo $error; ?></p>
            <?php } ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <label for="mail_from"><span class="required">From *</span></label>
                <input type="email" id="mail_from" name="mail_from" placeholder="Your Email.." required>

                <label for="app_password"><span class="required">Google App Password *</span></label>
                <input type="text" id="app_password" name="app_password" placeholder="Paste Your Google App Password.." required>

                <label for="name">Name<span class="required">*</span></label>
                <input type="text" id="name" name="name" placeholder="Your name.." required>

                <label for="email">Email To<span class="required">*</span></label>
                <input type="email" id="email_to" name="email_to" placeholder="Recipient Email.." required>

                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" placeholder="Your phone number..">

                <label for="subject">Subject<span class="required">*</span></label>
                <input type="text" id="subject" name="subject" placeholder="Your email subject" required>

                <label for="message">Message<span class="required">*</span></label>
                <textarea id="message" name="message" placeholder="Write something.." rows="5" required></textarea>

                <input type="submit" value="Submit">
            </form>
        <?php } ?>
    </div>
</body>
</html>
