<?php

class SendMail extends CI_Controller
{
    // function send_mail()
    // {
    //     $this->load->library('email');

    //     $email_config = Array(
    //         'protocol' => 'sendmail',
    //         'mailpath' => 'C:/xampp/sendmail/sendmail.exe',
    //         'charset'  => 'iso-8859-1',
    //         'mailtype' => 'html',
    //         'starttls' => true,
    //         'newline'  => "\r\n",
    //         'wordwrap' => true
    //     );

    //     $this->email->initialize($email_config);
    //     $this->email->from('piu@ugm.ac.id', 'Reminder 3');
    //     $this->email->to('rafika1504@gmail.com');
    //     $this->email->subject('Email Test 12');
    //     $this->email->message('Hello world');

    //     if ($this->email->send()) {
    //         echo "Sukses";
    //     } else {
    //         echo "Fail";
    //     }
    // }

    public function send_mail()
    {
        $email_config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.mailtrap.io',
            'smtp_port' => 25,
            'smtp_user' => '41ccbcfd835ea5',
            'smtp_pass' => '0e254a6c1f5c95',
            'newline'   => "\r\n"
        );

        $this->load->library('email');
        $this->email->initialize($email_config);
        $this->email->from('piu@ugm.ac.id', 'Reminder');
        $this->email->to('rafika1504@gmail.com');
        $this->email->subject('Email Test 12');
        $this->email->message('Hello world');

        if($this->email->send()){
            echo "Sukses";
        }else{
            echo $this->email->print_debugger();
        }
    }
}