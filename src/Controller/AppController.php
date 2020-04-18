<?php


namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Zavoca\CoreBundle\Controller\AbstractZavocaController;
use Zavoca\CoreBundle\Service\Interfaces\ZavocaMessagesInterface;
use Symfony\Component\Routing\Annotation\Route;
use Zavoca\CoreBundle\Enums\Roles;

class AppController extends AbstractZavocaController
{
    /**
     * @Route("/test", name="zavoca_core_test")
     * @IsGranted(Roles::ROLE_VIEWER)
     *
     * @param ZavocaMessagesInterface $zavocaMessages
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function test(ZavocaMessagesInterface $zavocaMessages)
    {

        $zavocaMessages->addWarning('Redirected from APP BUNDLE /test to /');

        return $this->redirectToRoute('zavoca_core_main');
    }
}