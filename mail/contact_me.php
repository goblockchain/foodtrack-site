<?php
// Check for empty fields
if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}


require('../vendor/autoload.php');

use SendGrid\Mail\Mail;

$email = new Mail();
$email->setFrom("app153943990@heroku.com", "PLANTIU");

$name = strip_tags(htmlspecialchars($_POST['name']));
$emailAddress = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$email->addTo(
    "fale.henrique@gmail.com",
    "Contato do site",
    [
        'nome' => $name,
        'telefone' => $phone,
        'email' => $emailAddress,
        'mensagem' => $message
    ]
);

$email->setTemplateId("d-6e057f78ab9145f093291068c34c288d");
$sendgrid = new \SendGrid('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');
try {
    $sendgrid->send($email);
    echo"OK";
} catch (\Exception $e) {
    http_response_code(500);
}

?>
