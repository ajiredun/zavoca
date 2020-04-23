<?php


namespace Zavoca\CoreBundle\Intent\Core;


use Doctrine\ORM\EntityManagerInterface;
use Zavoca\CoreBundle\Exception\IntentException;
use Zavoca\CoreBundle\Intent\AbstractIntent;

class GetEntityByIdIntent extends AbstractIntent
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getName()
    {
        return 'Get an Entity';
    }

    public function getDescription()
    {
        return "Get an entity by it's classname and id";
    }

    public function execute()
    {
        $entityClass = $this->get('entity_class');
        $entityId = $this->get('entity_id');

        $entity = $this->entityManager->getRepository($entityClass)->findOneById($entityId);

        if (!$entity) {
            throw new IntentException('The entity id ' .$entityId .' is not found. ');
        }

        $this->set('entity',$entity);
    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),[]);
    }

    public function inputMandatoryDefinition()
    {
        return [
            'entity_class',
            'entity_id'
        ];
    }

    public function outputDefinition(): array
    {
        return [
            'entity'
        ];
    }
}