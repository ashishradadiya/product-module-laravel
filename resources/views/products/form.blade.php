@extends('layouts.app')

@inject('idEncoder', 'App\Services\IdEncodeDecodeService')

@php 
    $id = isset($product) ? $product->id : 0; 
    $addUpdateLabel = isset($product) ? 'Update' : 'Add';
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 my-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $addUpdateLabel }} Product</span>
                            <a href="{{ route('product.list') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($product) ? route('product.update') : route('product.store') }}" method="POST" enctype="multipart/form-data" id="product-form" novalidate>
                            @csrf
                            @if(isset($product))
                                @method('PUT')
                            @endif
                            <input type="hidden" name="id" value="{{ $idEncoder->encodeId($id) }}"/>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', isset($product) ? $product->name : '') }}" required>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Category Dropdown -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (isset($product) && $product->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Price" min="0" value="{{ old('price', isset($product) ? $product->price : '') }}" required>
                                @error('price')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control" {{ isset($product) ? '' : 'required' }}>
                                @if(isset($product) && $product->image)
                                    <p><a href="{{ asset('storage/product_images/' . $product->image) }}" target="_blank">Click here to view Image</a></p>
                                @endif
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ (old('is_active', isset($product) ? $product->is_active : false)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ $addUpdateLabel }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function() {
        var isFileRequired = true; // Flag to manage file upload required validation
        // Add jQuery validation rules
        $('#product-form').validate({
            rules: {
                name: {
                    required: true
                },
                category_id: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                image: {
                    // Conditional required rule based on form state
                    fileRequired: isFileRequired,
                    accept: "image/*"
                }
            },
            messages: {
                name: "Please provide a valid name.",
                category_id: "Please select a category.",
                price: {
                    required: "Please enter a price",
                },
                image: {
                    fileRequired: "Please select an image.",
                    accept: "Please upload an image with a valid extension (png, jpeg, jpg, gif)."
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                // Display errors beneath the input fields
                error.addClass("text-danger");
                error.insertAfter(element);
            }
        });

        $.validator.addMethod('fileRequired', function(value, element, arg) {
            if(isFileRequired === true) {
                return true;
            } else {
                return false;
            }
        });

        @if(isset($product))
            isFileRequired = true;
        @endif

        // Track if file is changed
        $('#image').on('change', function() {
            isFileRequired = true;
        });
    });
</script>
@endpush