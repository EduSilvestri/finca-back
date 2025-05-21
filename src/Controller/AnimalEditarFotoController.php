<?php

namespace App\Controller;

use App\Entity\Animal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsController]
class AnimalEditarFotoController
{
    public function __invoke(Request $request, EntityManagerInterface $em)
    {
        try {
            $id = $request->attributes->get('id');
            $animal = $em->getRepository(Animal::class)->find($id);

            if (!$animal) {
                return new JsonResponse(['error' => 'Animal no encontrado'], 404);
            }

            // Asignar campos si están presentes
            $map = [
                'tipo' => 'setTipo',
                'nombre' => 'setNombre',
                'raza' => 'setRaza',
                'edad' => 'setEdad',
                'descripcion' => 'setDescripcion',
                'peso' => 'setPeso',
                'color' => 'setColor',
                'padre' => 'setPadre',
                'madre' => 'setMadre',
                'procedencia' => 'setProcedencia',
                'litrosPromedio' => 'setLitrosPromedio',
                'lote' => 'setLote',
                'precio' => 'setPrecio',
                'precioLote' => 'setPrecioLote',
                'prenada' => 'setPrenada',
            ];

            foreach ($map as $key => $setter) {
                if ($request->request->has($key)) {
                    $value = $request->request->get($key);

                    if ($key === 'prenada') {
                        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                    }
            
                    $animal->$setter($value);
                }
            }

            $file = $request->files->get('foto');
            if ($file) {
                $filename = (new \DateTime())->format('YmdHis') . '.' . $file->guessExtension();
                $file->move('uploads/animales', $filename);
                $animal->setFoto('/uploads/animales/' . $filename);
            }

            $em->flush();

            return new JsonResponse(['message' => 'Animal actualizado con éxito']);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => 'Error inesperado',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
