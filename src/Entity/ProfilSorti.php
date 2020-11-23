<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilSortiRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "getProfilsorti"={
 *               "method"="GET",
 *               "path"="/admin/profilsorti",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé"
 *          },
 *           "profilsorties_id_apprenants"={
 *               "method"="GET",
 *               "path"="/admin/promo/id/profilsorti",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé"
 *          },
 *          "create_profilSorti"={
 *               "method"="POST",
 *               "path"="/admin/profilsorti",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé"
 *          }
 *     },
 * itemOperations={
 *           "get_admin_profilsorti_id"={
 *               "method"="GET",
 *               "path"="/admin/profilsorti/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé"
 *          },
 *            "put_admin_profilsorties_id"={
 *               "method"="PUT",
 *               "path"="/admin/profilsorti/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *              }
 *          },
 *       normalizationContext={"groups"={"profilSorti:read","apprenant:read"}},
 *       denormalizationContext={"groups"={"profilSorti:write"}},
 *       attributes={"pagination_enabled"=true, "pagination_items_per_page"=2}
 * )
 * @ORM\Entity(repositoryClass=ProfilSortiRepository::class)
 */
class ProfilSorti
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"apprenant:read", "profilSorti:read","profilSorti:write"})
     * @Assert\NotBlank
     */
    private $libele;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilSorti")
     * @Groups({"profilSorti:read","profilSorti:write"})
     */
    private $apprenants;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $archivage;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setProfilSorti($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilSorti() === $this) {
                $apprenant->setProfilSorti(null);
            }
        }

        return $this;
    }


}
