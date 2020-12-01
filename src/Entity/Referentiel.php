<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  @ApiResource(
 *     routePrefix="/admin",
 *      collectionOperations={
 *           "get_referentiels"={
 *               "method"="GET",
 *               "path"="/referentiels",
 *               "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *               "security_message"="Acces non autorisé",
 *          },
 *          "get_referentiels_grpcompetence"={
 *               "method"="GET",
 *               "path"="/referentiels/grpecompetences",
 *               "security"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_CM'))",
 *               "security_message"="Acces non autorisé",
 *          },
 *            "add_referentiel"={
 *               "method"="POST",
 *               "path"="/referentiels",
 *               "security"="is_granted('POST_REF', object)",
 *               "security_message"="Acces non autorisé",
 *          }
 *      },
 *      itemOperations={
 *           "get_referentiel_id"={
 *               "method"="GET",
 *               "path"="/referentiels/{id}",
 *                "defaults"={"id"=null},
 *                "security"="(is_granted('GET_REF_ID', object))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *
 *            "get_referentiel_id_grpcompetence"={
 *               "method"="GET",
 *               "path"="/referentiels/{id}/gprecompetences/{id1}",
 *                "security"="(is_granted('GET_ID_GRP', object))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *            "update_referentiel_id"={
 *               "method"="PUT",
 *               "path"="/referentiels/{id}",
 *                "security"="(is_granted('PUT_REF', object))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *            "delete_referentiel_id"={
 *               "method"="DELETE",
 *               "path"="/referentiels/{id}",
 *                "security"="(is_granted('DELETE_REF', object))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *      },
 *       normalizationContext={"groups"={"referentiel:read"}},
 *       denormalizationContext={"groups"={"referentiel:write"}},
 * )
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"referentiel:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Groups({"referentiel:read","referentiel:write"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write"})
     */
    private $programme;

    /**
     * @ORM\Column(type="text")
     * @Groups({"referentiel:read","referentiel:write"})
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="text")
     * @Groups({"referentiel:read","referentiel:write"})
     */
    private $critereEvaluation;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="referentiels")
     * @Groups({"referentiel:read", "referentiel:write"})
     */
    private $grpCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promos;

    public function __construct()
    {
        $this->grpCompetences = new ArrayCollection();
        $this->promos = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGrpCompetences(): Collection
    {
        return $this->grpCompetences;
    }

    public function addGrpCompetence(GroupeCompetence $grpCompetence): self
    {
        if (!$this->grpCompetences->contains($grpCompetence)) {
            $this->grpCompetences[] = $grpCompetence;
        }

        return $this;
    }

    public function removeGrpCompetence(GroupeCompetence $grpCompetence): self
    {
        $this->grpCompetences->removeElement($grpCompetence);

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->setReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

        return $this;
    }
}
