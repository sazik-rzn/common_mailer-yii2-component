
# common_mailer-yii2-component

**Install:**

 1.  composer require sazik-rzn/common_mailer-yii2-component 
 2. Configure component - add next to "components" section in yor
    common/main.php
    
    `'mailere'=>[ 
    'class'=>'sazik\mailer\Mailer',  
    'url'=>'http://mailer.rumex.ru' 
  ]`
        
----------


**Usage :**

    $mailer = \Yii::$app->mailere; // Get component instance
    $message = $mailer->compose(); // Create new message instance
    $message->setFrom('test@optica100.ru')// Set from
            ->setSubject('test')//Set subject
            ->setBody('test')//Set text
            ->setTo('sazonov@rumex.ru');//Set recipient(s)
    $result = $mailer->send(); // Send messge

