<?php

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class EmailSender {

    
    public function sendEmail($productsArr) {
        $mail = new PHPMailer;
        // if(!empty($productsArr) {
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
                $mail->isSMTP(true);                                            
                $mail->Host       = 'smtp.gmail.com';                   
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'vainius.daraskevicius@gmail.com';                     
                $mail->Password   = '';                              
                $mail->SMTPSecure = 'ssl';            
                $mail->Port       = 465;                                    
            
                $mail->setFrom('vainius.daraskevicius@gmail.com');
                $mail->addAddress('vainius.daraskevicius@gmail.com');     
            
                $orderPrice = 0;
                $cartCount = count($productsArr);
                $counter = 0;
     
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = "Candyshop receipt";
                $mail->Body    = "We are happy to announce that the order has just been accepted.<br>"
                 . "Wait a little and the purchased goods will reach you soon!<br><br>"
                 . "<b>Your product cart:</b>"
                 . "<table style='border-collapse: collapse; border: 1px solid;'> "
                 . "<tr style='border-collapse: collapse; border: 1px solid;'> "
                 . "<th style='border-collapse: collapse; border: 1px solid;'>Image</th>"
                 . "<th style='border-collapse: collapse; border: 1px solid;'>Name</th>"
                 . "<th style='border-collapse: collapse; border: 1px solid;'>Price</th>"
                 . "<th style='border-collapse: collapse; border: 1px solid;'>Quantity</th>"
                 . "<th style='border-collapse: collapse; border: 1px solid;'>Total product price</th>"
                 . "<th style='border-collapse: collapse; border: 1px solid;'>Order price</th>"
                 . "</tr>"; 
                 foreach($productsArr as $product => $value) {
                    $mail->Body .=
                    "<tr style='border-collapse: collapse; border: 1px solid;'>"
                    . "<td style='border-collapse: collapse; border: 1px solid;'><img src=/'" . $value['productImage'] . "' alt='' border=3 height=50 width=50</img></td>"
                    . "<td style='border-collapse: collapse; border: 1px solid;'>" . $value['productName'] . "</td>" 
                    . "<td style='border-collapse: collapse; border: 1px solid;'>" . $value['productPrice'] . "</td>" 
                    . "<td style='border-collapse: collapse; border: 1px solid;'>" . $value['quantity'] . "</td>" 
                    . "<td style='border-collapse: collapse; border: 1px solid;'>" . $value['productPrice'] * $value['quantity'] . "</td>";
                    $orderPrice += $value['productPrice'] * $value['quantity'];
                    $counter++;
                    if($counter == $cartCount) {
                        $mail->Body .= "<td style='border-collapse: collapse; border: 1px solid;'>" . $orderPrice . "</td>"; 
                    }
                    $mail->Body .= "</tr>";
                 }
                $mail->Body .= "</table>";
    
                $lol =  $mail->send();
                 return $lol;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        // }
    }
}













