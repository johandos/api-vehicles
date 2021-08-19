<?php
namespace App\Controller;
use App\Repository\VehiclesRepository;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class vehicleController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class VehiclesController
{
    public $vehicleRepository;

    public function __construct(VehiclesRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @Route("vehicle", name="add_vehicle", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = $request->request->all();
        $vehicle = new \stdClass();
        $vehicle->vin = $data['vin'];
        $vehicle->modelCar = $data['model_car'];
        $vehicle->color = $data['color'];
        $vehicle->enrollment = $data['enrollment'];
        $vehicle->customerId = $data['customer_id'];

        $this->vehicleRepository->saveVehicles($vehicle);

        return new JsonResponse(['status' => 'vehicle created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("vehicle/{id}", name="get_one_vehicle", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $vehicle = $this->vehicleRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $vehicle->getId(),
            'color' => $vehicle->getColor(),
            'modelo' => $vehicle->getModelCar(),
            'bastidor' => $vehicle->getVin(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("vehicles", name="get_all_vehicles", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $vehicles = $this->vehicleRepository->findAll();
        $data = [];

        foreach ($vehicles as $vehicle) {
            $data[] = [
                'id' => $vehicle->getId(),
                'color' => $vehicle->getColor(),
                'model' => $vehicle->getCustomerId(),
                'enrollment' => $vehicle->getEnrollment(),
                'customer_id' => $vehicle->getCustomerId(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("vehicle/{id}", name="update_vehicle", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $vehicle = $this->vehicleRepository->findOneBy(['id' => $id]);
        $data = $request->request->all();
        if (isset($data['vin'])){
            $vehicle->setVin($data['vin']);
        }
        if (isset($data['model_car'])){
            $vehicle->setModelCar($data['model_car']);
        }
        if (isset($data['color'])){
            $vehicle->setColor($data['color']);
        }
        if (isset($data['enrollment'])){
            $vehicle->setEnrollment($data['enrollment']);
        }
        if (isset($data['customer_id'])){
            $vehicle->setCustomerId($data['customer_id']);
        }
        $this->vehicleRepository->updateVehicles($vehicle);

        return new JsonResponse(['status' => 'vehicle updated!'], Response::HTTP_OK);
    }

    /**
     * @Route("vehicle/{id}", name="delete_vehicle", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $vehicle = $this->vehicleRepository->findOneBy(['id' => $id]);

        $this->vehicleRepository->removeVehicles($vehicle);

        return new JsonResponse(['status' => 'vehicle deleted'], Response::HTTP_OK);
    }
}

?>