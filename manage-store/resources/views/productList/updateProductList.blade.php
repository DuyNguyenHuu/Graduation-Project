@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div class="title">
                <p>Update Product</p>
            </div>
            <div style="display: flex">
                <div><a href="{{ route('productList.attribute', ['productList' => $productDescription->IdProduct]) }}" style="text-decoration: none">Attributes</a></div>
                <div><a href="{{ url('productList') }}" style="text-decoration: none;">Back</a></div>
            </div>
        </div>
        <div class="formUpdate">
            <form method="POST" action="/productList/{{ $productDescription->IdProduct }}">
                @csrf
                @method('PUT')
                <div class="productDetail">
                    <div class="productInfo1">
                        <label>Name Product:</label><br>
                        <input type="text" name="nameProduct" id="NameProduct" value="{{ $productDescription->NameProduct }}"><br>
                        <label>Id Product:</label>
                        <input type="text" name="idProduct" id="ProductSlug" value="{{ $productDescription->IdProduct }}"><br>
                        <label>Type Product:</label>
                        <select name="typeProduct">
                            <option value=""{{ $productDescription->TypeProduct == '' ? 'selected' : '' }}>Type Product</option>
                            <option value="Undefine Product"{{ $productDescription->TypeProduct == 'Undefine Product' ? 'selected' : '' }}>Undefine Product</option>
                            <option value="New Arrival"{{ $productDescription->TypeProduct == 'New Arrival' ? 'selected' : '' }}>New Arrival</option>
                            <option value="Flash Deal"{{ $productDescription->TypeProduct == 'Flash Deal' ? 'selected' : '' }}>Flash Deal</option>
                            <option value="Best Product"{{ $productDescription->TypeProduct == 'Best Product' ? 'selected' : '' }}>Best Product</option>
                            <option value="Top Product"{{ $productDescription->TypeProduct == 'Top Product' ? 'selected' : '' }}>Top Product</option>
                        </select>
                        <label>ImageURL:</label><br>
                        <input type="text" name="imageURLProduct" value="{{ $productDescription->ImageURL }}"><br>
                        <label>Status:</label><br>
                        <select name="statusProduct">
                            <option value="Publish"{{ $productDescription->StatusProduct == 'Publish' ? 'selected' : '' }}>Publish</option>
                            <option value="UnPublish"{{ $productDescription->StatusProduct == 'UnPublish' ? 'selected' : '' }}>UnPublish</option>
                        </select><br>
                        <label>Tags:</label><br>
                        <div class="tag-input-container">
                            <ul id="tagList"></ul>
                            <input type="text" id="tagInput" placeholder="Enter tag and press Enter">
                        </div>
                        <input type="hidden" name="tags" id="tagsHidden">
                        <label>Description:</label><br>
                        <textarea name="descriptionProduct" id="editor">{!! $productDescription->Description !!}</textarea>
                    </div>
                    <div class="productInfo2">
                        <div class="productPrice">
                            <label>New Price:</label><br>
                            <input type="number" name="newPriceProduct" step="0.01" min="0" value="{{ $productDescription->NewPrice }}"><br>
                            <label>Old Price:</label><br>
                            <input type="number" name="oldPriceProduct" step="0.01" min="0" value="{{ $productDescription->OldPrice }}"><br>
                        </div>
                        <div class="productCategory">
                            <label>Category:</label>
                            <select id="category" name="categoryProduct"  onchange="filterSubCategories()">
                                <option value="">Category</option>
                                @foreach ($categoryList as $row)
                                    <option value="{{ $row->IdCategory }}" {{ $row->IdCategory == optional($productCategory)->IdCategory ? 'selected' : '' }}>
                                        {{ $row->NameCategory }}
                                    </option>

                                @endforeach
                            </select>
                            <label>Sub Category:</label>
                            <select id="subcategory" name="subCategoryProduct">
                                <option value="">Sub Category</option>
                                @foreach ($subCategoryList as $row)
                                    <option value="{{ $row->IdSub }}" data-category="{{ $row->IdSubCategory }}"
                                        {{ $row->IdSub == optional($productCategory)->IdSub ? 'selected' : '' }}>
                                        {{ $row->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit">Submit</button>
            </form>
            <script>
                CKEDITOR.replace('editor');
            </script>
            <script>
                document.getElementById('NameProduct').addEventListener('input', function() {
                    const slug = generateSlug(this.value);
                    document.getElementById('ProductSlug').value = slug;
                });
            </script>
            <script>
                document.getElementById('category')
                    .addEventListener('change', function () {
                        filterSubCategories('category', 'subcategory');
                    });
            </script>
            <script>
                const initialTags = "{{ $productDescription->Tag ?? '' }}"
                    .split(',')
                    .map(tag => tag.trim())
                    .filter(tag => tag !== '');

                initTagInput('tagInput', 'tagList', 'tagsHidden', initialTags);
            </script>
        </div>
    </div>
    @include('components.fail')
@endsection