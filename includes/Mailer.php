<?php
namespace includes;

class Mailer
{
    static private $host = 'smtp.qq.com';
    static private $port = 465;
    static private $username = '3024046831@qq.com';
    static private $password = 'dztfpelnjuqbdhda';
    static private $SMTPSecure = 'ssl';
    static private $formName = 'd3zz.com';


    /**
     * @param $recipientAddr
     * @param $recipientName
     * @param $subject
     * @param $content
     * @return bool
     * @throws \Exception
     */
    static public function sendMail($recipientAddr, $recipientName, $subject, $content)
    {
        $mailer = new \PHPMailer();
        $mailer->isSMTP();

        $mailer->Host = static::$host;
        $mailer->Port = static::$port;
        $mailer->SMTPAuth = true;
        $mailer->Username = static::$username;
        $mailer->Password = static::$password;
        $mailer->SMTPSecure = static::$SMTPSecure;

        $mailer->setFrom($mailer->Username, static::$formName);
        $mailer->addAddress($recipientAddr, $recipientName);
        $mailer->isHTML(true);

        $mailer->Subject = $subject;
        $mailer->Body = $content;
        if ($mailer->send()) {
          return true;
        } else throw new \Exception($recipientAddr.' 邮件发送失败');
    }

}