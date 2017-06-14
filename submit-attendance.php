<?php

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

if (getenv('BUGSNAG_API_KEY', null) != null) {
    $bugsnag = Bugsnag\Client::make(getenv('BUGSNAG_API_KEY'));
    Bugsnag\Handler::register($bugsnag);
}

date_default_timezone_set('America/Kentucky/Louisville');

$today = new \Carbon\Carbon();
$monthsOfAttendance = array(
    2, //Oct
    11, //Nov

    1, //Jan
    2, //Feb
    3, //Mar
    4, //Apr
    5  //May
);

//if it's monday
if (in_array($today->format('n'), $monthsOfAttendance) && $today->format('N') == 1) {

    //sleep to as to assume randomness
    sleep(rand(30, 140));

    $headers = 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n";

    $attendance = rand(40, 52);
    $practiceDate = \Carbon\Carbon::now();

    $mail = new \PHPMailer\PHPMailer\PHPMailer($throwExceptions = true);

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = getenv('SMTP_HOST');  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = getenv('SMTP_USER');                 // SMTP username
    $mail->Password = getenv('SMTP_PASSWORD');                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(getenv('FROM_EMAIL'), getenv('FROM_NAME'));
    $mail->addReplyTo(getenv('FROM_EMAIL'), getenv('FROM_NAME'));
    $mail->addAddress(getenv('TO'));                                // Set email format to HTML

    $mail->Subject = getenv('SUBJECT_PREFIX').' - '.$practiceDate->format('M jS');
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = "Attendance last night was ".$attendance.".";

    $mail->send();

    echo '['.\Carbon\Carbon::now()->toDateTimeString().'] an attendance of '.$attendance.' has been submitted';
}