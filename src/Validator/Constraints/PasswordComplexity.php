<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordComplexity extends Constraint
{
    public $message = 'Le mot de passe doit contenir au moins une lettre majuscule, un chiffre, un caractère spécial et doit avoir une longueur d\'au moins 8 caractères.';
}