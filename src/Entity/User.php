<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      collectionOperations={
 *           "get_admin_users"={
 *               "method"="GET",
 *               "path"="/admin/users",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *            "add_user"={
 *               "method"="POST",
 *               "path"="/admin/users",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                 "security_message"="Acces non autorisé",
 *          },
 *      },
 *      itemOperations={
 *           "get_admin_users_id"={
 *               "method"="GET",
 *               "path"="/admin/users/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *                  "defaults"={"id"=null},
 *          },
 *            "modifier_admin_users_id"={
 *               "method"="PUT",
 *               "path"="/admin/users/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *                  "defaults"={"id"=null},
 *          },
 *            "delete_users"={
 *               "method"="DELETE",
 *               "path"="/admin/users/{id}",
 *                 "security"="(is_granted('ROLE_ADMIN'))",
 *                  "security_message"="Acces non autorisé",
 *              }
 *      },
 *       normalizationContext={"groups"={"user:read"}},
 *       denormalizationContext={"groups"={"user:write"}},
 *     attributes={"pagination_items_per_page"=1},
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"admin"="User","apprenant" = "Apprenant","formateur"="Formateur","cm"="ComminutyManger"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read"})
     * @Assert\NotBlank
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read"})
     * @Assert\NotBlank
     */
    private $fisrtname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read"})
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read"})
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read"})
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     * @Groups({"user:write"})
     */
    private $archivage;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="User")
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     */
    private $profil;

    /**
     * @Groups({"user:write"})
     */
    private $plainPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibele();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }

    public function getFisrtname(): ?string
    {
        return $this->fisrtname;
    }

    public function setFisrtname(string $fisrtname): self
    {
        $this->fisrtname = $fisrtname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoto()
    {
        if($this->photo)
        {
            $data = stream_get_contents($this->photo);
            if(!$this->photo){
                fclose($this->photo);
            }


            return base64_encode($data);
        }else
        {
            return null;
        }
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

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

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @param $plainPassword
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
