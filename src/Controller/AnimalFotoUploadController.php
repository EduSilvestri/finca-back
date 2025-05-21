<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Entity\Animal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsController]
class AnimalFotoUploadController
{
    public function __invoke(Request $request, EntityManagerInterface $em)
    {
        $file = $request->files->get('foto');
        $filename = null;

        if ($file) {
            $filename = (new \DateTime())->format('YmdHis') . '.' . $file->guessExtension();

            try {
                $file->move('uploads/animales', $filename);
            } catch (FileException $e) {
                return new JsonResponse(['error' => 'No se pudo guardar la imagen'], 500);
            }
        }

        // Campos obligatorios
        $tipo = $request->request->get('tipo');
        $nombre = $request->request->get('nombre');
        $raza = $request->request->get('raza');
        $edad = $request->request->get('edad');
        $descripcion = $request->request->get('descripcion');

        // Validación básica
        if (!$tipo || !$raza || !$edad || !$descripcion) {
            return new JsonResponse(['error' => 'Faltan datos obligatorios'], 400);
        }

        if ($tipo !== 'Maute' && !$nombre) {
            return new JsonResponse(['error' => 'El nombre es obligatorio para este tipo'], 400);
        }

        // Crear y asignar campos al animal
        $animal = new Animal();
        $animal->setTipo($tipo);
        if ($tipo !== 'Maute') {
            $animal->setNombre($nombre ?? '');
        }
        $animal->setRaza($raza);
        $animal->setEdad($edad);
        $animal->setDescripcion($descripcion);

        if ($filename) {
            $animal->setFoto('/uploads/animales/' . $filename);
        }

        // Campos opcionales
        $animal->setPeso($request->request->get('peso'));
        $animal->setColor($request->request->get('color'));
        $animal->setPadre($request->request->get('padre'));
        $animal->setMadre($request->request->get('madre'));
        $animal->setProcedencia($request->request->get('procedencia'));
        $animal->setLitrosPromedio($request->request->get('litrosPromedio'));
        $animal->setLote($request->request->get('lote'));
        $animal->setPrecio($request->request->get('precio'));
        $animal->setPrecioLote($request->request->get('precioLote'));

        $prenadaValor = $request->request->get('prenada');
        $animal->setPrenada(filter_var($prenadaValor, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE));

        $em->persist($animal);
        $em->flush();

        return new JsonResponse(['message' => 'Animal creado con éxito'], 201);
    }
}
