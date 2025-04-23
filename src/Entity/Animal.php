<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Controller\AnimalEditarFotoController;
use App\Controller\AnimalFotoUploadController;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['animal:read']],
    denormalizationContext: ['groups' => ['animal:write']],
    paginationEnabled: false,
    operations: [
        new Get(normalizationContext: ['groups' => ['animal:read']]),
        new GetCollection(
            paginationEnabled: false
        ),
        new Post(
            security: "is_granted('ROLE_ADMIN')",
            inputFormats: ['multipart' => ['multipart/form-data']],
            controller: AnimalFotoUploadController::class,
            deserialize: false,
            validationContext: ['groups' => ['Default']]
        ),
        new Post(
            uriTemplate: '/animals/{id}/actualizar',
            controller: AnimalEditarFotoController::class,
            deserialize: false,
            inputFormats: ['multipart' => ['multipart/form-data']],
            name: 'animal_actualizar',
            validationContext: ['groups' => ['Default']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'tipo' => 'exact',
    'raza' => 'partial'
])]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['animal:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write', 'visita:read'])]
    #[Assert\NotBlank(message: "El tipo es obligatorio")]
    #[Assert\Choice(choices: ['Toro', 'Vaca', 'Maute', 'Novilla'], message: "Tipo inválido")]
    private ?string $tipo = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write'])]
    #[Assert\NotBlank(message: "La raza es obligatoria")]
    private ?string $raza = null;

    #[ORM\Column]
    #[Groups(['animal:read', 'animal:write'])]
    #[Assert\NotNull(message: "La edad es obligatoria")]
    private ?string $edad = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    #[Assert\Positive(message: "El peso debe ser mayor que cero")]
    private ?int $peso = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['animal:read', 'animal:write'])]
    #[Assert\NotBlank(message: "La descripción es obligatoria")]
    private ?string $descripcion = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $lote = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    #[Assert\Positive(message: "Los litros promedio deben ser positivos")]
    private ?float $litrosPromedio = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $padre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $madre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $procedencia = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $foto = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    #[Assert\Positive(message: "El precio debe ser mayor a 0")]
    private ?float $precio = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    #[Assert\Positive(message: "El precio del lote debe ser mayor a 0")]
    private ?float $precioLote = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?bool $prenada = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getRaza(): ?string
    {
        return $this->raza;
    }

    public function setRaza(string $raza): static
    {
        $this->raza = $raza;

        return $this;
    }

    public function getEdad(): ?string
    {
        return $this->edad;
    }

    public function setEdad(string $edad): static
    {
        $this->edad = $edad;

        return $this;
    }

    public function getPeso(): ?int
    {
        return $this->peso;
    }

    public function setPeso(?int $peso): static
    {
        $this->peso = $peso;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getLote(): ?string
    {
        return $this->lote;
    }

    public function setLote(?string $lote): static
    {
        $this->lote = $lote;

        return $this;
    }

    public function getLitrosPromedio(): ?float
    {
        return $this->litrosPromedio;
    }

    public function setLitrosPromedio(?float $litrosPromedio): static
    {
        $this->litrosPromedio = $litrosPromedio;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getPadre(): ?string
    {
        return $this->padre;
    }

    public function setPadre(?string $padre): static
    {
        $this->padre = $padre;

        return $this;
    }

    public function getMadre(): ?string
    {
        return $this->madre;
    }

    public function setMadre(?string $madre): static
    {
        $this->madre = $madre;

        return $this;
    }

    public function getProcedencia(): ?string
    {
        return $this->procedencia;
    }

    public function setProcedencia(?string $procedencia): static
    {
        $this->procedencia = $procedencia;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(?float $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getPrecioLote(): ?float
    {
        return $this->precioLote;
    }

    public function setPrecioLote(?float $precioLote): static
    {
        $this->precioLote = $precioLote;

        return $this;
    }

    public function isPrenada(): ?bool
    {
        return $this->prenada;
    }

    public function setPrenada(?bool $prenada): static
    {
        $this->prenada = $prenada;

        return $this;
    }
}
