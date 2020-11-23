<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * collectionOperations={
 *           "get_admin_competences"={
 *               "method"="GET",
 *               "path"="/admin/competences",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Vous n'avez pas accés à cette ressource",
 *          },
 *          "create_competence"={
 *               "method"="POST",
 *               "path"="/admin/competences",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Vous n'avez pas accés à cette ressource",
 *          }
 *     },
 * itemOperations={
 *           "get_admin_competences_id"={
 *               "method"="GET",
 *               "path"="/admin/competences/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Vous n'avez pas accés à cette ressource",
 *          },
 *            "put_admin_competences_id"={
 *               "method"="PUT",
 *               "path"="/admin/competences/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Vous n'avez pas accés à cette ressource",
 *              }
 *          },
 *      normalizationContext={"groups"={"competence:read"}},
 *       denormalizationContext={"groups"={"competence:write"},
 *     }
 * )
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:read","competence:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Groups({"competence:read","competence:write"})
     */
    private $descriptif;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence")
     * @Groups({"competence:read","competence:write"})
     */
    private $niveaux;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competence")
     * @Groups({"competence:read"})
     */
    private $groupeCompetences;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }
}
