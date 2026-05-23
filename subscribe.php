<?php
$conn = new mysqli("localhost", "root", "Sravani@777", "farmdirect");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email exists
        $check = $conn->prepare("SELECT email FROM newsletter_subscribers WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "exists";
        } else {
            $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "error";
            }
            $stmt->close();
        }
    } else {
        echo "invalid";
    }
}
$conn->close();
?>