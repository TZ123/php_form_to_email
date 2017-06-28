<?php
    // process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        if ( empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        if(isInjected($email)){
            echo "value not accepted";
            exit;
        }

        $recipient = "tylerziegelman@gmail.com";

        $subject = "New message received from $name";

        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $headers = "From: $name <$email>";

        if (mail($recipient, $subject, $email_content, $headers)) {
            http_response_code(200);
            echo "Thank You! Your message has been sent and will be seen soon";
        } else {
            http_response_code(500);
            echo "Sorry about that! There was an error on our part :( .";
        }

    } else {
        http_response_code(403);
        echo "An error has occured. Go ahead and give it another try!";
    }

    function IsInjected($str)
{
    $injections = array('(\n+)',
                '(\r+)',
                '(\t+)',
                '(%0A+)',
                '(%0D+)',
                '(%08+)',
                '(%09+)'
                );
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    if(preg_match($inject,$str))
        {
        return true;
    }
    else
        {
        return false;
    }
}

?>