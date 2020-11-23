<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 * collectionOperations={
 *           "get_admin_profils"={
 *               "method"="GET",
 *               "path"="/admin/profils",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé"
 *          },
 *           "get_admin_profils_id_users"={
 *               "method"="GET",
 *               "path"="/admin/profils/{id}/users",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé"
 *          },
 *          "create_profil"={
 *               "method"="POST",
 *               "path"="/admin/profils",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé"
 *          }
 *     },
 * itemOperations={
 *           "get_admin_profils_id"={
 *               "method"="GET",
 *               "path"="/admin/profils/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé"
 *          },
 *            "put_admin_profils_id"={
 *               "method"="PUT",
 *               "path"="/admin/profils/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *            "delete_profil"={
 *               "method"="DELETE",
 *               "path"="/admin/profils/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *              }
 *          },
 *      normalizationContext={"groups"={"profil:read"}},
 *       denormalizationContext={"groups"={"profil:write"},
 *     "disable_type_enforcement"=true
 *     },
 *     attributes={
 *          "pagination_items_per_page"=1,
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"profil:read","profil:write"})
     * @Assert\NotBlank
     */
    private $libele;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     * @Groups({"profil:read","profil:write"})
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Groups({"profil:read"})
     */
    private $User;

    public function __construct()
    {
        $this->User = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibele(): ?string
    {
        return $this->libele;
    }

    public function setLibele(string $libele): self
    {
        $this->libele = $libele;

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->User->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }
}
