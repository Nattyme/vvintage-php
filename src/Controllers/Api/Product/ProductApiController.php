<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api;

use Vvintage\Routing\RouteData;
use Vvintage\Services\Admin\Product\AdminProductService;
use Vvintage\DTO\Product\ProductDTO;

class ProductApiController
{
    private AdminProductService $svc;

    public function __construct()
    {
        $this->svc = new AdminProductService();
        header('Content-Type: application/json; charset=utf-8');
    }

    public function show(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        $product = $this->svc->getProductById($id);
        if (!$product) { http_response_code(404); echo json_encode(['error'=>'Not found']); return; }

        echo json_encode($this->svc->toApiArray($product), JSON_UNESCAPED_UNICODE);
    }

    public function store(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $errors = $this->svc->validateApi($data);
        if ($errors) { http_response_code(422); echo json_encode(['errors'=>$errors]); return; }

        $dto = ProductDTO::fromArray($data);
        $id = $this->svc->createProduct($dto);
        echo json_encode(['success'=>true, 'id'=>$id]);
    }

    public function update(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $errors = $this->svc->validateApi($data, $id);
        if ($errors) { http_response_code(422); echo json_encode(['errors'=>$errors]); return; }

        $dto = ProductDTO::fromArray($data);
        $ok = $this->svc->updateProduct($id, $dto);
        echo json_encode(['success'=>$ok]);
    }

    public function delete(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        $ok = $this->svc->deleteProduct($id);
        echo json_encode(['success'=>$ok]);
    }

    public function uploadImages(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        // ВАЖНО: сюда прилетит POST multipart/form-data → доступны $_FILES
        $result = $this->svc->addImages($id, $_FILES['images'] ?? null);
        if (!$result['success']) { http_response_code(422); }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function reorderImages(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $ok = $this->svc->reorderImages($id, $data['order'] ?? []);
        echo json_encode(['success'=>$ok]);
    }
}
