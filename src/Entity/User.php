<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields="email", message="cet email existe déjà.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotNull(message="L'Email doit être renseigné !")
     */
    private $email;


    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotNull(message="Le mot de passe doit être renseigné !")
     */
    private $password;

     /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le nom doit être renseigné !")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le prénom doit être renseigné !")
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer", length=10)
     * @Assert\Regex("/^0[0-9]{9}$/")
     * @Assert\NotNull(message="Le téléphone doit être renseigné !")
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $administrateur;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $actif;

    /**
     * @ORM\ManyToMany(targetEntity=Sortie::class)
     */
    private $estInscrit;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="estOrganisee")
     */
    private $sortiesOrganisees;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    public function __construct()
    {
        $this->estInscrit = new ArrayCollection();
        $this->sortiesOrganisees = new ArrayCollection();
        $this->administrateur = false;
        $this->actif = true; 
    }

    public function getId(): ?int
    {
        return $this->id;
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

     /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = array ('ROLE_USER'); 
        if($this->administrateur){
            $roles[] = 'ROLE_ADMIN';
        }
       return $roles;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdministrateur(): ?bool
    {
        return $this->administrateur;
    }

    public function setAdministrateur(bool $administrateur): self
    {
        
        $this->administrateur = $administrateur;

        return $this;
    }

    public function getActif(): ?bool
    {   
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getEstInscrit(): Collection
    {
        return $this->estInscrit;
    }

    public function addEstInscrit(Sortie $estInscrit): self
    {
        if (!$this->estInscrit->contains($estInscrit)) {
            $this->estInscrit[] = $estInscrit;
        }

        return $this;
    }

    public function removeEstInscrit(Sortie $estInscrit): self
    {
        if ($this->estInscrit->contains($estInscrit)) {
            $this->estInscrit->removeElement($estInscrit);
        }

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getSortiesOrganisees(): Collection
    {
        return $this->sortiesOrganisees;
    }

    public function addSortiesOrganisee(Sortie $sortiesOrganisee): self
    {
        if (!$this->sortiesOrganisees->contains($sortiesOrganisee)) {
            $this->sortiesOrganisees[] = $sortiesOrganisee;
            $sortiesOrganisee->setEstOrganisee($this);
        }

        return $this;
    }

    public function removeSortiesOrganisee(Sortie $sortiesOrganisee): self
    {
        if ($this->sortiesOrganisees->contains($sortiesOrganisee)) {
            $this->sortiesOrganisees->removeElement($sortiesOrganisee);
            // set the owning side to null (unless already changed)
            if ($sortiesOrganisee->getEstOrganisee() === $this) {
                $sortiesOrganisee->setEstOrganisee(null);
            }
        }

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

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
        // $this->plainPassword = null;
    }
}
