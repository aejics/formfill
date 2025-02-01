<!--    
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp-mail.outlook.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'a11531@aejics.org';
        $mail->Password   = $env["pass"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
        $mail->setFrom('a11531@aejics.org', 'FormFill');
        $mail->addAddress('a11531@aejics.org', 'Marco Pisco');     //Add a recipient
        $mail->addCC('marco@marcopisco.com');
        
            //Attachments
        $mail->addAttachment('filledforms/' . $nomeficheiro);         //Add attachments
        
            //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Documento gerado e preenchido';
        $mail->Body    = utf8_decode('Envio o formulário preenchido por ' . $_COOKIE["nomedapessoa"] . '. Está anexado neste email.');
        
        $mail->send();
 -!>