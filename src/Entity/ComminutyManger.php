<?php

namespace App\Entity;

use App\Repository\ComminutyMangerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComminutyMangerRepository::class)
 */
class ComminutyManger extends User
{

}
