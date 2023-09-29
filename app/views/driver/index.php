<?php
    // include required phpmailer files
    require APPROOT . '/libraries/PHPMailer.php';
    require APPROOT . '/libraries/SMTP.php';
    require APPROOT . '/libraries/Exception.php';

    // Define namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Create instance of phpmailer
    $mail = new PHPMailer();

    // Set mailer to use smtp
    $mail->isSMTP();

    // Define smtp host
    $mail->Host = 'smtp.gmail.com';

    // Enable smtp authentication
    $mail->SMTPAuth = true;

    // Set smtp encryption type (ssl/tls)
    $mail->SMTPSecure = 'tls';

    // Port to connect smtp
    $mail->Port = '587';

    // Set gmail username
    $mail->Username = 'dasunthathsara974@gmail.com';

    // Set gmail password
    $mail->Password = 'Dasun@974';

    // Email subject
    $mail->Subject = 'Test email from Localhost by Dasun';

    // Set sender email
    try {
        $mail->setFrom('dasun.thathsara.sri@gmail.com');
    } catch (Exception $e) {
        print_r(e);
    }

    // Email body
    $mail->Body = 'Hello Dasun';

    // Add recipient
try {
    $mail->addAddress('dasun.thathsara.sri@gmail.com');
} catch (Exception $e) {
    print_r(e);
}

// Send email
    try {
        $mail->Send();
    } catch (Exception $e) {
        print_r(e);
    }

    // Close smtp connection
    $mail->smtpClose();
?>

<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'dashboard';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Driver Dashboard</h1>
        </div>
    </section>
</main>

<?php require APPROOT.'/views/inc/footer.php'; ?>
