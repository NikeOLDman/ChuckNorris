<?php

namespace App\Service;

use App\Entity\Joke;

class Mailer
{
    public function generateEmail(Joke $joke)
    {
        $to  = $joke->getUserEmail();
        $subject = "Funny joke from Chuck Norris";
        $message = $joke->getJoke();
        $headers  = array(
            'From' => 'chuck@sorokinpro.ru',
            'Reply-To' => 'chuck@sorokinpro.ru',
            'X-Mailer' => 'PHP/' . phpversion()
        );
        mail($to, $subject, $message, $headers);
        return true;
    }
}
