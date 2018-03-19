<?php

namespace sazik\mailer;

class Recipient {

    public $email = false;
    public $to = 0;
    public $cc = 0;
    public $bcc = 0;
    public $reply_to = 0;

    public function compose() {
        $recipient = [
            'to' => $this->to,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'reply_to' => $this->reply_to
        ];
        $flag_setted = 0;
        if ($this->cc === 1) {
            $flag_setted++;
        }
        if ($this->bcc === 1) {
            $flag_setted++;
        }
        if ($this->to === 1) {
            $flag_setted++;
        }
        if ($this->reply_to === 1) {
            $flag_setted++;
        }
        if ($this->email && $flag_setted === 1) {
            $recipient['email'] = $this->email;
            return $recipient;
        }
        return false;
    }

}
