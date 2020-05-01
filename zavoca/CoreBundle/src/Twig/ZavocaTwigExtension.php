<?php


namespace Zavoca\CoreBundle\Twig;


use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zavoca\CoreBundle\Enums\EnumInterface;
use Zavoca\CoreBundle\Enums\Roles;
use Zavoca\CoreBundle\Enums\UserStatus;

class ZavocaTwigExtension extends AbstractExtension
{
    /**
     * @var Environment
     */
    protected $twig;

    public function __construct(Environment $twig)
    {

        $this->twig = $twig;
    }


    public function getFunctions()
    {
        return [
            new TwigFunction('displayRoles', [$this, 'displayRoles']),
            new TwigFunction('displayUserStatus', [$this, 'displayUserStatus']),
            new TwigFunction('displayDate', [$this, 'displayDate']),
        ];
    }

    public function displayDate(\DateTime $date, $time = false)
    {

        if ($time) {
            date_format($date, 'g:ia \o\n l jS F Y');
        }

        return date_format($date, 'l jS F Y');
    }

    public function displayRoles($values)
    {
        $type = Roles::class;
        $roles = $this->displayEnums($values, $type);

        return $this->twig->render('zavoca\micro\roleList.html.twig', ['roles', $roles]);
    }

    public function displayUserStatus($value)
    {

        $label = UserStatus::getLabel($value);

        $class = UserStatus::getClassByKey($value);

        return $this->twig->render('zavoca\micro\userStatus.html.twig', ['label'=> $label, 'class' => $class]);
    }

    protected function displayEnums($values, $type)
    {
        /**
         * @var EnumInterface $type
         */
        $list = [];

        foreach ($values as $value) {
            $list[$value] = $type::getLabel($value);
        }

        return $list;
    }
}