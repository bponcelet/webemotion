<?php
/**
 * Web eMotion — contact form handler.
 * Sends the form from index.html to info@webemotion.be using PHP mail().
 */

const TO_ADDRESS   = 'info@webemotion.be';
// Must be an address on your own domain, otherwise the host may refuse or spam-flag the mail.
const FROM_ADDRESS = 'no-reply@webemotion.be';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#contact', true, 303);
    exit;
}

function fail(): void {
    header('Location: index.html?error=1#contact', true, 303);
    exit;
}

// Spam trap: real visitors never fill this hidden field.
if (!empty($_POST['website'])) {
    header('Location: thanks.html', true, 303);
    exit;
}

$clean = static function (string $key, int $max): string {
    $v = trim((string)($_POST[$key] ?? ''));
    return mb_substr($v, 0, $max);
};

$name    = $clean('name', 120);
$email   = $clean('email', 200);
$need    = $clean('need', 80);
$message = $clean('message', 5000);

// Block header injection in single-line fields.
foreach ([$name, $email, $need] as $field) {
    if (preg_match('/[\r\n]/', $field)) {
        fail();
    }
}

if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail();
}

$allowedNeeds = ['A web application', 'A mobile app', 'Architecture or CMS consultancy', 'Something else'];
if (!in_array($need, $allowedNeeds, true)) {
    $need = 'Not specified';
}

$subject = '=?UTF-8?B?' . base64_encode('Website enquiry — ' . $name) . '?=';
$body = "New message from the Web eMotion website\n\n"
      . "Name:    {$name}\n"
      . "Email:   {$email}\n"
      . "Need:    {$need}\n\n"
      . "Message:\n{$message}\n";

$headers = [
    'From'                      => 'Web eMotion website <' . FROM_ADDRESS . '>',
    'Reply-To'                  => $email,
    'MIME-Version'              => '1.0',
    'Content-Type'              => 'text/plain; charset=UTF-8',
    'Content-Transfer-Encoding' => '8bit',
];

if (mail(TO_ADDRESS, $subject, $body, $headers)) {
    header('Location: thanks.html', true, 303);
} else {
    fail();
}
exit;
