<?php


namespace Zavoca\CoreBundle\Intent\Core;


use Doctrine\ORM\EntityManagerInterface;
use Zavoca\CoreBundle\Intent\AbstractIntent;

class EntityCreatedParticularMonthIntent extends AbstractIntent
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function getName()
    {
        return "Entity created per month";
    }

    public function getDescription()
    {
        return "Returns a list of objects that have been created for a particular month. For previous month, it is -1.";
    }

    public function execute()
    {
        $month = $this->get('zavoca_list_month');
        $class = $this->get('zavoca_list_entity_class');

        $repository = $this->entityManager->getRepository($class);


        //title and description
        if ($month == 0) {
            //current month
            $this->set('zavoca_list_title', date('F Y'));
        } else {
            $currentMonth = date('F');
            $monthInQuestion =  date("F", strtotime ( $month.' month' , strtotime ( $currentMonth ) )) ;
            $this->set('zavoca_list_title', $monthInQuestion . ' ' . date('Y'));
        }
        $this->set('zavoca_list_description',$this->get('zavoca_list_description'));

    }

    public function inputDefinition()
    {
        return array_merge($this->getInputMandatoryDef(),[
            'zavoca_list_lazy',
            'zavoca_list_description',
            'zavoca_list_pagination',
            'zavoca_list_search_params'
        ]);
    }

    public function inputMandatoryDefinition()
    {
        return [
          'zavoca_list_entity_class',
          'zavoca_list_month'
        ];
    }

    public function outputDefinition(): array
    {
        return [
            'zavoca_list',
            'zavoca_list_title',
            'zavoca_list_description'
        ];
    }
}