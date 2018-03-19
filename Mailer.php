<?php

namespace common\components\Mailer;

class Mailer {

    /**
     *
     * @var Message 
     */
    public $message = false;

    public function compose() {
        $this->message = new Message;
        return $this->message;
    }

    public static function send() {
        if ($this->message) {
            $message = $this->message->prepare();
            $this->message = false;
            if ($message) {
                $obj_to_send = [
                    'message' => json_encode($message)
                ];
                $result = file_get_contents('http://mailer.rumex.ru', false, stream_context_create(array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => http_build_query($obj_to_send)
                    )
                )));

                $result = json_decode($result, true);
                if (isset($result['id'])) {
                    return true;
                }
            }
        }
        return false;
    }

}
