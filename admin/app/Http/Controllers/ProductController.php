<?php

namespace App\Http\Controllers;

use App\Events\ProductUpdatedEvent;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\ProductCreated;
use App\Jobs\ProductDeleted;
use App\Jobs\ProductUpdated;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Microservices\UserService;

class ProductController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $this->userService->allows('view', 'products');

        $products = Product::Paginate(10);

        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $this->userService->allows('view', 'products');

        return new ProductResource(Product::find($id));
    }

    public function store(ProductCreateRequest $request)
    {
        $this->userService->allows('edit', 'products');

        $product = Product::create($request->only('title', 'description', 'image', 'price'));

        event(new ProductUpdatedEvent());

        ProductCreated::dispatch($product->toArray())->onQueue('checkout_queue');

        return response($product, Response::HTTP_CREATED);
    }

    public function update(ImageUploadRequest $request, $id)
    {
        $this->userService->allows('edit', 'products');

        $product = Product::find($id);

        $product->update($request->only('title', 'description', 'image', 'price'));

        event(new ProductUpdatedEvent());

        ProductUpdated::dispatch($product->toArray());

        return response($product, Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        $this->userService->allows('edit', 'products');

        Product::destroy($id);

        ProductDeleted::dispatch($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
