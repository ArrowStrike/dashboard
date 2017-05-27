<?php
/**
 * Created by PhpStorm.
 * User: vtarasenkovs
 * Date: 5/18/17
 * Time: 4:02 PM
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 1000);

        return $this->render(
            '@App/lucky/number.html.twig',
            [
                'number' => $number,
            ]
        );
    }
}