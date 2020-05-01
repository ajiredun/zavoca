<?php


namespace Zavoca\CoreBundle\Intent\Core;


use Doctrine\ORM\EntityManagerInterface;
use Zavoca\CoreBundle\Exception\IntentException;
use Zavoca\CoreBundle\Intent\AbstractIntent;
use Zavoca\CoreBundle\Service\Interfaces\ZavocaMessagesInterface;

class HandleFormTypeIntent extends AbstractIntent
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ZavocaMessagesInterface
     */
    protected $zavocaMessages;

    public function __construct(EntityManagerInterface $entityManager, ZavocaMessagesInterface $zavocaMessages)
    {
        $this->entityManager = $entityManager;
        $this->zavocaMessages = $zavocaMessages;
    }

    public function getName()
    {
        return "Handle Form Details";
    }

    public function getDescription()
    {
        return "Handle the form submission of the the particular form";
    }

    public function execute()
    {
        $entity = $this->get('zavoca_form_entity');
        if ($entity) {
            $form = $this->get('zavoca_form');
            $form->handleRequest($this->get('request'));

            if ($form->isSubmitted() && $form->isValid()) {
                $entity = $form->getData();

                $this->entityManager->flush();
                $this->zavocaMessages->addSuccess("Updated Successfully!");
            }
        } else {
            throw new IntentException("You should provide an entity to handle it");
        }
    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),[]);
    }

    public function inputMandatoryDefinition()
    {
        return [
            'zavoca_form_entity',
            'zavoca_form',
            'request'
        ];
    }

    public function outputDefinition(): array
    {
        return [
            'zavoca_form'
        ];
    }

}