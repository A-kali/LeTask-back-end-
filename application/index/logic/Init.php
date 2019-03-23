<?php

namespace app\index\logic;

use app\index\model\User;
use think\Model;
use think\Session;
use think\Cookie;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Init extends Model
{
    public function sendMail($mailbox)
    {

        $vcode = rand(1000, 9999);
        /** @var PHPMailer $mail */
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.qq.com';
            $mail->SMTPAuth = true;
            $mail->CharSet = "UTF-8";
            $mail->SMTPSecure = 'ssl';
            $mail->Username = 'hsaki@foxmail.com';                 // SMTP username          你自己的邮箱账号
            $mail->Password = 'balqrzmtpegxdjai';
            $mail->Port = 465;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                )
            );
            $mail->setFrom('hsaki@qq.com', '创点企业');
            $mail->addAddress($mailbox);
            $mail->isHTML(true);
            $mail->Subject = '邮箱验证';
            $mail->Body = '非常感谢您使用嘉木平台，为了验证您的邮箱地址，请输入以下验证码：' . $vcode;
            $mail->send();
            Session::init(['expire'=>300]);
            Session::set('vcode', $vcode);
            Session::set('mailbox', $mailbox);
            Cookie::set(session_name(), session_id());
            return ['stat' => 1, 'log'=>'邮件发送成功'];
        } catch (Exception $e) {
            return ['stat'=>0, 'log'=>$mail->ErrorInfo];
        }
    }

    static public $salt = "2g8h9n$%^DFG";

    public function register($password, $openid)
    {
        $user = new User([
            'nickname' => Session::get('mailbox'),
            'mailbox' => Session::get('mailbox'),
            'password' => md5(md5($password).self::$salt),
            'wx_openid' => $openid,
        ]);
        $user->save();
        Session::delete('vcode');
        return ['stat'=>1, 'log'=>'注册成功'];
    }

    public function login($mailbox, $password)
    {
        $user = new User();
        $ciphertext = $user->where('mailbox',$mailbox)->value('password');
        $password = md5(md5($password).self::$salt);
        if ($ciphertext == $password) {
            $userinfo = $user->getProfile();
            Session::set('mailbox', $mailbox);
            Cookie::set(session_name(), session_id());
            return array_merge(['stat'=>1,'log'=>'登录成功'],$userinfo[$mailbox]);
        }
        return ['stat' => 0, 'log' => '用户不存在或密码错误'];
    }
}