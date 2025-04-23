<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Visita;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class VisitaPersister implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private Security $security,
        private EntityManagerInterface $em
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
{
    if (!$data instanceof Visita) {
        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }

    if ($operation instanceof Delete) {
        $this->em->remove($data);
        $this->em->flush();
        return null;
    }

    $user = $this->security->getUser();

    if (!$user instanceof User) {
        throw new \LogicException('El usuario autenticado no es válido');
    }

    // ✅ Validaciones de fecha solo en POST o PUT
    if ($operation instanceof Post || $operation instanceof Put) {
        $fecha = $data->getFecha();
        $minDate = (new \DateTime())->modify('+2 days')->setTime(0, 0);

        if ($fecha < $minDate) {
            throw new \RuntimeException('Debes agendar tu visita con al menos 2 días de anticipación.');
        }

        $hora = (int) $fecha->format('H');
        if ($hora < 8 || $hora > 17) {
            throw new \RuntimeException('La hora debe estar entre 8:00 a.m. y 5:00 p.m.');
        }

        // Validar duplicado (excepto si es la misma)
        $repo = $this->em->getRepository(Visita::class);
        $idActual = $data->getId() ?? $uriVariables['id'] ?? null;
        $existente = $repo->findOneBy(['fecha' => $fecha]);

        if ($existente && $existente->getId() !== $idActual) {
            throw new \RuntimeException('Ya existe una visita registrada para esa fecha y hora.');
        }
    }

    // ✅ Asignar usuario y nombreVisitante solo en POST si no vienen
    if ($operation instanceof Post) {
        if (!$data->getUsuario()) {
            $data->setUsuario($user);
        }

        if (!$data->getNombreVisitante()) {
            $data->setNombreVisitante($user->getNombre());
        }
    }

    // ✅ Restaurar datos originales en PUT si vienen vacíos
    if ($operation instanceof Put) {
        $id = $data->getId() ?? $uriVariables['id'] ?? null;
        if ($id) {
            $original = $this->em->getRepository(Visita::class)->find($id);
            if ($original) {
                if (!$data->getUsuario()) {
                    $data->setUsuario($original->getUsuario());
                }
                if (!$data->getNombreVisitante()) {
                    $data->setNombreVisitante($original->getNombreVisitante());
                }
            }
        }
    }

    return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
}

}
