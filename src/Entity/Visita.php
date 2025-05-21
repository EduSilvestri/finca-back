<?php

namespace App\Entity;

use App\Repository\VisitaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\State\VisitaPersister;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;



#[ORM\Entity(repositoryClass: VisitaRepository::class)]
#[ApiResource(
    processor: VisitaPersister::class,
    normalizationContext: ['groups' => ['visita:read']],
    denormalizationContext: ['groups' => ['visita:write']],
    operations: [
        new Get(
            security: "is_granted('ROLE_ADMIN') or object.getUsuario() == user"
        ),

        new GetCollection(),

        new Post(
            validationContext: ['groups' => ['visita:crear']]
        ),

        new Put(
            security: "is_granted('ROLE_ADMIN') or object.getUsuario() == user",
            validationContext: ['groups' => ['visita:editar']]
        ),

        new Patch( 
            security: "is_granted('ROLE_ADMIN') or object.getUsuario() == user",
            validationContext: ['groups' => ['Default']]
        ),

        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
    ]
)]
class Visita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['visita:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['visita:read', 'visita:write'])]
    #[Assert\NotNull(message: "La fecha es obligatoria", groups: ["visita:crear", "visita:editar"])]
    #[Assert\GreaterThan("+1 day", message: "Debes agendar la visita con al menos 2 días de anticipación", groups: ["visita:crear", "visita:editar"])]    
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255)]
    #[Groups(['visita:read'])]
    private ?string $nombreVisitante = null;

    #[ORM\Column(length: 20)]
    #[Groups(['visita:read', 'visita:write'])]
    #[Assert\NotBlank(message: "El teléfono es obligatorio")]
#[Assert\Length(
    min: 7,
    max: 20,
    minMessage: "El teléfono debe tener al menos {{ limit }} dígitos",
    maxMessage: "El teléfono no puede tener más de {{ limit }} caracteres"
)]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['visita:read', 'visita:write'])]
    private ?string $comentario = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['visita:read', 'visita:write'])]
    #[Assert\Choice(
        choices: ['pendiente', 'confirmada', 'cancelada'],
        message: "El estado debe ser: pendiente, confirmada o cancelada"
    )]
    private ?string $estado = null;

    #[ORM\ManyToOne(inversedBy: 'visitas', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visita:read', 'visita:write'])]
    // #[Assert\NotNull(message: "El usuario es obligatorio")]
    private ?User $usuario = null;

    #[ORM\Column(length: 60)]
    #[Groups(['visita:read', 'visita:write'])]
    private ?string $tipoAnimal = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getNombreVisitante(): ?string
    {
        return $this->nombreVisitante;
    }

    public function setNombreVisitante(string $nombreVisitante): static
    {
        $this->nombreVisitante = $nombreVisitante;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getTipoAnimal(): ?string
    {
        return $this->tipoAnimal;
    }

    public function setTipoAnimal(string $tipoAnimal): static
    {
        $this->tipoAnimal = $tipoAnimal;

        return $this;
    }

}
