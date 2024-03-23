<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\IdEncodeDecodeService;

class ProductRequest extends FormRequest
{
    protected $idEncodeDecodeService;

    public function __construct(IdEncodeDecodeService $idEncodeDecodeService)
    {
        $this->idEncodeDecodeService = $idEncodeDecodeService;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Decode the ID
        $decodedId = $this->idEncodeDecodeService->decodeId($this->input('id'));

        $rules = [
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ];

        if ($decodedId <= 0) { // If it's not an update operation, require image field
            $rules['image'] = 'required|image';
        } 
        else { // If it's an update operation, make image field nullable
            $rules['image'] = 'nullable|image';
        }

        return $rules;
    }
}
