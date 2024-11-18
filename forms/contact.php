<?php
// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Nettoyer l'email
    $objet = htmlspecialchars($_POST['objet']);                  // Échapper les caractères spéciaux
    $message = htmlspecialchars($_POST['message']);              // Échapper les caractères spéciaux

    // Vérifier que tous les champs sont remplis
    if (!empty($email) && !empty($objet) && !empty($message)) {
        try {
            // Création de l'objet PHPMailer
            $mail = new PHPMailer(true);

            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'libertaff.contact@gmail.com';  // Ton adresse Gmail
            $mail->Password = 'xhrg wvjq rwah nmym';    // Ton mot de passe ou mot de passe d'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Sécuriser la connexion avec STARTTLS
            $mail->Port = 587;  // Port SMTP pour STARTTLS

            // Destinataire et expéditeur
            $mail->setFrom($email, 'Message du site');  // Adresse de l'expéditeur (celle du formulaire)
            $mail->addAddress('libertaff.contact@gmail.com'); // Remplace par ton adresse e-mail
            $mail->addReplyTo($email); // Cette ligne ajoute l'adresse de l'utilisateur comme destinataire de la réponse
            // Sujet et corps du message
            $mail->Subject = $objet;
            $mail->Body    = "Message reçu de : $email\n\n$message";  // Contenu du message

            // Envoyer l'e-mail
            if ($mail->send()) {
                echo 'Votre mail a été envoyé :) !';
            }
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Accès non autorisé.";
}
?>
