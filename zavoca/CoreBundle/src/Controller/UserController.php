<?php


namespace Zavoca\CoreBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Zavoca\CoreBundle\Entity\System;
use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Flow\User\UserDetailsFlow;
use Zavoca\CoreBundle\Flow\User\UserTabsFlow;
use Zavoca\CoreBundle\Flow\User\WidgetUserFlow;
use Zavoca\CoreBundle\Form\SystemType;
use Zavoca\CoreBundle\Form\UserBaseType;
use Zavoca\CoreBundle\Service\FlowFactory;
use Zavoca\CoreBundle\Service\Interfaces\ContextManagerInterface;
use Zavoca\CoreBundle\Service\Interfaces\ControlManagerInterface;
use Zavoca\CoreBundle\Service\Interfaces\ZavocaMessagesInterface;
use Zavoca\CoreBundle\Enums\Roles;
use Zavoca\CoreBundle\Utils\PageAction;

/**
 * @Route("/user")
 */
class UserController extends AbstractZavocaController
{
    /**
     * @Route("/profile/{user}", name="zavoca_core_user_profile")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function profile($user = null, Request $request, ControlManagerInterface $controlManager, ContextManagerInterface $contextManager)
    {
        $contextManager->setPageTitle('Profile');
        $contextManager->addPageAction($this->getPAViewUsers());
        $contextManager->addPageAction($this->getPAAddUser());

        if (is_null($user)) {
            $user = $this->getUser();
        } else {
            $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($user);
            if (!$user) {
                throw new \Exception("Invalid User");
            }
        }

        $widgetUserResponse = $controlManager->execute(WidgetUserFlow::class, [
            'user' => $user,
            'user_details' => true
        ]);

        //render the user tabs
        $userTabsResponse = $controlManager->execute(UserTabsFlow::class, [
            'user' => $user,
            'request' => $request
        ]);

        //render the user details
        $userDetailsResponse = $controlManager->execute(UserDetailsFlow::class, [
            'zavoca_form_class' => UserBaseType::class,
            'user' => $user,
            'request' => $request
        ]);

        return $this->render('zavoca/core/user/default.html.twig',[
            'widgetUserResponse' => $widgetUserResponse,
            'userTabsResponse' => $userTabsResponse,
            'userDetailsResponse' => $userDetailsResponse
        ]);
    }

    /**
     * @Route("/list", name="zavoca_core_user_list")
     * @IsGranted(Roles::ROLE_USER_MANAGEMENT_VIEWER)
     */
    public function list(ControlManagerInterface $controlManager, ContextManagerInterface $contextManager)
    {
        $contextManager->setPageTitle('Users');


        /*$flowResponse = $controlManager->execute($changeSystemSettingsFlow,[
            'system_id' => 3,
            'zavoca_form_class' => SystemType::class,
            'entity_class' => System::class
        ],true);*/

        return $this->render('zavoca/core/main/main.html.twig',[

        ]);
    }

    /**
     * @Route("/theme/{area}/{value}", name="zavoca_core_user_theme")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function updateTheme($area = null, $value = null)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $success = true;
        $message = "Theme's setting changed.";

        switch ($area) {
            case "dark-theme":

                if ($user->getAutoDarkMode()) {
                    $success = false;
                    $message = "You should disable Automatic Dark Mode.";
                } else {
                    if ($value == 1) {
                        $user->setDarkTheme(true);
                    } else {
                        $user->setDarkTheme(false);
                    }
                }
                break;
            case "background-navbar":
                $user->setBackgroundNavbar($value);
                break;
            case "background-logo":
                $user->setBackgroundLogo($value);
                break;
            case "background-sidebar":
                $user->setBackgroundSidebar($value);
                break;
            default:
                $success = false;
                //do nothing
        }

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['success'=>$success, 'message'=>$message]);
    }


    protected function getPAViewUsers()
    {
        return new PageAction(
            'View Users',
            'zavoca_core_user_list',
            PageAction::PRIMARY,
            'fas fa-users'
        );
    }

    protected function getPAAddUser()
    {
        return new PageAction(
            'Add User',
            'zavoca_core_user_list',
            PageAction::SECONDARY,
            'fas fa-user-plus'
        );
    }
}