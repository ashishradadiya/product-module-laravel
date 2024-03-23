<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\IdEncodeDecodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Log;

class ProductController extends Controller
{
    
    protected $idEncodeDecodeService;
    
    public function __construct(IdEncodeDecodeService $idEncodeDecodeService)
    {
        $this->idEncodeDecodeService = $idEncodeDecodeService;
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function listProduct()
    {
        $products = Product::all();
        return view('products.list', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProduct()
    {
        $categories = Category::all();
        return view('products.form', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProduct(ProductRequest $request)
    {
        try {
            $imageName = $this->uploadFile($request->file('image'));

            // Create the product
            $newProduct  = Product::create([
                'name' => $request->input('name'),
                'category_id' => $request->input('category_id'),
                'price' => $request->input('price'),
                'description' => $request->input('description'),
                'image' => $imageName,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            Log::info('Product: #'.$newProduct->id.' created successfully.');
            // Redirect with success message
            return redirect()->route('product.list')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            // Log error message
            Log::error('Error occurred while creating product: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function editProduct($id)
    {
        $decodedId = $this->idEncodeDecodeService->decodeId($id);
        $product = Product::find($decodedId);
        if($product === null) {
            return redirect()->back()->with('error', 'Product not exists.');
        }
        $categories = Category::all();
        return view('products.form', compact('product', 'categories'));
    }
    
    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(ProductRequest $request)
    {
        try {
            $decodedId = $this->idEncodeDecodeService->decodeId($request->input('id'));
            $product = Product::find($decodedId);
            if($product === null) {
                return redirect()->back()->with('error', 'Product not exists.');
            }

            $data = [
                'name' => $request->input('name'),
                'category_id' => $request->input('category_id'),
                'price' => $request->input('price'),
                'description' => $request->input('description'),
                'is_active' => $request->has('is_active') ? true : false,
            ];

            // Handle image update
            if ($request->hasFile('image')) {
                $oldImagePath = 'public/product_images/' . $product->image;
                $newImageName = $this->uploadFile($request->file('image'));

                // Delete old image if exists
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
                $data['image'] = $newImageName;
            }

            // Update product
            $product->update($data);
            Log::info('Product: #'.$product->id.' updated successfully.');
            return redirect()->route('product.list')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            // Log error message
            Log::error('Error occurred while updating product: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Generate a unique name for the uploaded image file.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    private function generateImageName($file)
    {
        return time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    }


    /**
     * Upload image file.
     *
     * @param  \Illuminate\Http\File  $file
     * @return string
     */
    private function uploadFile($file)
    {
        $imageName = $this->generateImageName($file);
        $imagePath = $file->storeAs('public/product_images', $imageName);
        Log::info('Added new file: '. $imagePath);
        return $imageName;
    }

}
