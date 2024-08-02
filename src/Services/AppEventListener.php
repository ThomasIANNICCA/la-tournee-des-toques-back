<?php

namespace App\Services;

use App\Entity\Truck;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, method: 'addSlug', entity: Truck::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'addSlug', entity: Truck::class)]

class AppEventListener 
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function addSlug(Truck $truck)
    {
        $name = $truck->getName();
        $slug = $this->slugger->slug($name);
        $truck->setSlug($slug);
    }  
}