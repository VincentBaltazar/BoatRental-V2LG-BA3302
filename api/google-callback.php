<?php
session_start();
require 'vendor/autoload.php';

use Google\Client as Google_Client;

$client = new Google_Client(['client_id' => 'YOUR_CLIENT_ID']);  // Specify the CLIENT_ID of the app that accesses the backend
$id_token = json_decode(file_get_contents('php://input'), true)['credential'];

try {
    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
        $userid = $payload['sub'];
        $email = $payload['email'];
        $firstName = $payload['given_name'];
        $lastName = $payload['family_name'];

        // Check if user exists in the database
        include_once('includes/connection.php');
        $sql = "SELECT * FROM account WHERE email = ? LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['logged_in'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['accountType'] = $user['accountType'];
        } else {
            // If user doesn't exist, insert new user
            $sql = "INSERT INTO account (firstName, lastName, email, accountType) VALUES (?, ?, ?, 'tourist')";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("sss", $firstName, $lastName, $email);
            $stmt->execute();
            $user_id = $stmt->insert_id;

            $_SESSION['logged_in'] = true;
            $_SESSION['id'] = $user_id;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['accountType'] = 'tourist';
        }

        $redirectUrl = '';
        if ($_SESSION['accountType'] == 'admin') {
            $redirectUrl = 'adminIndex.php';
        } elseif ($_SESSION['accountType'] == 'tourist') {
            $redirectUrl = 'index.php';
        } else {
            $redirectUrl = 'captainIndex.php';
        }

        echo $redirectUrl;
    } else {
        echo 'Invalid ID token.';
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
