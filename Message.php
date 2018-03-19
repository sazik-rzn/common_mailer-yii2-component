<?php

namespace sazik\mailer;

class Message {

    public $recipients = [];
    public $subject = 'No subject';
    public $body = false;
    public $from = false;
    public $fromName = false;

    public function prepare() {        
        if (!$this->fromName) {
            $this->fromName = $this->from;
        }
        if ($this->body && $this->from && $this->fromName && !empty($this->recipients)) {
            return [
                'subject' => $this->subject,
                'body' => $this->body,
                'from' => $this->from,
                'from_name' => $this->fromName,
                'recipients' => $this->recipients
            ];
        }
        return false;
    }

    public function setBcc($bcc) {
        if (is_array($bcc)) {
            foreach ($bcc as $key => $value) {
                if ((is_int($key) && !is_array($value)) || is_array($value)) {
                    $this->setBcc($value);
                } elseif (!is_int($key) && !is_array($value)) {
                    $this->setBcc($key);
                }
            }
        } else {
            $recipient = new Recipient;
            $recipient->email = $bcc;
            $recipient->bcc = 1;
            $recipient = $recipient->compose();
            if ($recipient) {
                $this->recipients[] = $recipient;
            }
        }
        return $this;
    }

    public function setCc($cc) {
        if (is_array($cc)) {
            foreach ($cc as $key => $value) {
                if ((is_int($key) && !is_array($value)) || is_array($value)) {
                    $this->setCC($value);
                } elseif (!is_int($key) && !is_array($value)) {
                    $this->setCC($key);
                }
            }
        } else {
            $recipient = new Recipient;
            $recipient->email = $cc;
            $recipient->cc = 1;
            $recipient = $recipient->compose();
            if ($recipient) {
                $recipient = $recipient->compose();
                if ($recipient) {
                    $this->recipients[] = $recipient;
                }
            }
        }
        return $this;
    }

    public function setFrom($from) {
        $this->from = $from;
        return $this;
    }

    public function setFromName($fromName) {
        $this->fromName = $fromName;
        return $this;
    }

    public function setReplyTo($replyTo) {
        if (is_array($replyTo)) {
            foreach ($replyTo as $key => $value) {
                if ((is_int($key) && !is_array($value)) || is_array($value)) {
                    $this->setReplyTo($value);
                } elseif (!is_int($key) && !is_array($value)) {
                    $this->setReplyTo($key);
                }
            }
        } else {
            $recipient = new Recipient;
            $recipient->email = $replyTo;
            $recipient->reply_to = 1;
            $recipient = $recipient->compose();
            if ($recipient) {
                $this->recipients[] = $recipient;
            }
        }
        return $this;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    public function setBody($text) {
        $this->body = $text;
        return $this;
    }

    public function setTo($to) {
        if (is_array($to)) {
            foreach ($to as $key => $value) {
                if ((is_int($key) && !is_array($value)) || is_array($value)) {
                    $this->setTo($value);
                } elseif (!is_int($key) && !is_array($value)) {
                    $this->setTo($key);
                }
            }
        } else {
            $recipient = new Recipient;
            $recipient->email = $to;
            $recipient->to = 1;
            $recipient = $recipient->compose();
            if ($recipient) {
                $this->recipients[] = $recipient;
            }
        }
        return $this;
    }

}
