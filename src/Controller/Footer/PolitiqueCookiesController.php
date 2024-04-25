<?php

namespace App\Controller;
namespace App\Controller\Footer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PolitiqueCookiesController extends AbstractController
{
    public function politiqueCookies(): Response
    {
        return $this->render('footer/politique_cookies.html.twig');
    }
}
