<?php
$fromName = $_POST['fromName'];
$fromEmail = $_POST['fromEmail'];
$toEmail = $_POST['toEmail'];
$moreInfo = utf8_decode($_POST['moreInfo']);
$pageTitle = utf8_decode($_POST['pageTitle']);
$pageURL = $_POST['pageUrl'];

//Validate first
if(empty($fromName)||empty($toEmail)) 
{
    echo "<p>Du måste ange Namn och E-post!</p><div class='clear'></div>";
    exit;
}

if(IsInjected($toEmail))
{
    echo "Felaktig e-post!";
    exit;
}

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$email_from = 'info@hagersten.org';//<== update the email address
$email_subject = "$fromName vill tipsa dig om sidan $pageTitle";
$email_body = "<h1>Hej!</h1> \n <p>$fromName vill tipsa dig om sidan $pageTitle \n <a href='$pageURL'>$pageURL</a>\n\n hos H&auml;gerstens F&ouml;rsamling</p>";
$email_body .= "<p><strong>Personligt meddelande fr&aring;n $fromName</strong>:</p><p>$moreInfo</p>";
    
$to = "$toEmail";

$headers .= "From: $fromEmail \r\n";





//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
echo "<p><strong>Tack!</strong></p><p style='clear:both;'>Ditt tips är nu skickat.</p>";


// Function to validate against any email injection attempts
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