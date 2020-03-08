<?php

namespace App\Form\Model;

/*
 * Modèle de formulaire
 *   chaque propriété du modèle est relié à un champ du formulaire
 *   suite à la soumission du formulaire, le modèle sera rempli et renvoyé
 */
class ContactFormModel
{
    /* uniquement en php 7.4 : typage des propriétés
    private ?string $firstname = null;
    private ?string $lastname = null;
    private ?string $email = null;
    private ?string $message = null;*/

    private $firstname = null;
    private $email = null;
    private $message = null;

    // getters / setters
    public function setFirstName(?string $firstname):void { $this->firstname = $firstname; }
    public function setEmail(?string $email):void { $this->email = $email; }
    public function setMessage(?string $message):void { $this->message = $message; }

    public function getFirstname():?string { return $this->firstname; }
    public function getEmail():?string { return $this->email; }
    public function getMessage():?string { return $this->message; }
}









