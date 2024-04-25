<?php

namespace App\Controller;
namespace App\Controller\Footer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConditionsGeneralesController extends AbstractController
{
    public function conditionsGenerales(): Response
    {
        return $this->render('footer/conditions_generales.html.twig');
    }
}
