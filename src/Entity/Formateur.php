<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      collectionOperations={
 *           "get_formateurs"={
 *               "method"="GET",
 *               "path"="/formateurs",
 *               "security"="(is_granted('ROLE_CM'))",
 *               "security_message"="Acces non autorisé",
 *          },
 *            "add_formateur"={
 *               "method"="POST",
 *               "path"="/formateurs",
 *               "security"="is_granted('ROLE_ADMIN')",
 *               "security_message"="Acces non autorisé",
 *          }
 *      },
 *      itemOperations={
 *           "get_formateurs_id"={
 *               "method"="GET",
 *               "path"="/formateurs/{id}",
 *                "defaults"={"id"=null},
 *                "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *            "modifier_formateurs_id"={
 *               "method"="PUT",
 *               "path"="/formateurs/{id}",
 *                "security"="(is_granted('ROLE_FORMATEUR'))",
 *                  "security_message"="Acces non autorisé",
 *          }
 *      },
 *       normalizationContext={"groups"={"formateur:read","user:read"}},
 *       denormalizationContext={"groups"={"formateur:write","user:write"}}
 *
 * )
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur extends User
{

}
