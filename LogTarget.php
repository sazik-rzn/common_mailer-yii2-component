<?php

namespace sazik\mailer;

class LogTarget extends \yii\log\Target {

    /**
     * @var array the configuration array for creating a [[\yii\mail\MessageInterface|message]] object.
     * Note that the "to" option must be set, which specifies the destination email address(es).
     */
    public $message = [];


    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        if (empty($this->message['to'])) {
            throw new InvalidConfigException('The "to" option must be set for EmailTarget::message.');
        }
    }

    /**
     * Sends log messages to specified email addresses.
     * Starting from version 2.0.14, this method throws LogRuntimeException in case the log can not be exported.
     * @throws LogRuntimeException
     */
    public function export() {
        if (empty($this->message['subject'])) {
            $this->message['subject'] = 'Application Log';
        }
        $messages = array_map([$this, 'formatMessage'], $this->messages);
        $body = wordwrap(implode("\n", $messages), 70);
        $message = $this->composeMessage($body);
        if (!$message->send()) {
            throw new LogRuntimeException('Unable to export log through email!');
        }
    }

    /**
     * Composes a mail message with the given body content.
     * @param string $body the body content
     * @return \yii\mail\MessageInterface $message
     */
    protected function composeMessage($body) {
        $mailer = $this->common_mailer;
        $message = $mailer->compose();
        $message = new \sazik\mailer\Message;
        $message->setBody($body);
        $message->setFrom($this->message['from']);
        $message->setTo($this->message['to']);
        $message->setSubject($this->message['subject']);    
        return $mailer;
    }

}
