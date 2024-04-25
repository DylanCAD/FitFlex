<?php

namespace App\Controller;
namespace App\Controller\Footer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PolitiqueConfidentialiteController extends AbstractController
{
    public function politiqueConfidentialite(): Response
    {
        return $this->render('footer/politique_confidentialite.html.twig');
    }
}
