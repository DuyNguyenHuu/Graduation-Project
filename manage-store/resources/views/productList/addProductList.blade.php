@extends('layouts.home')
@section('content')
    <div class="product">
        <div class="Add">
            <div class="title">
                <p>Create Product</p>
            </div>
            <div class="action">
                <a href="{{ url('productList') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form method="POST" action="/productList">
                @csrf
                <div class="productDetail">
                    <div class="productInfo1">
                        <label>Name Product:</label><br>
                        <input type="text" name="nameProduct" id="NameProduct" placeholder="Enter Name Product" required><br>
                        <label>Id Product:</label>
                        <input type="text" name="idProduct" id="ProductSlug" placeholder="Enter Id Product" required><br>
                        <label>Type Product:</label>
                        <select name="typeProduct">
                            <option value="">Type Product</option>
                            <option value="Undefine Product">Undefine Product</option>
                            <option value="New Arrival">New Arrival</option>
                            <option value="Flash Deal">Flash Deal</option>
                            <option value="Best Product">Best Product</option>
                            <option value="Top Product">Top Product</option>
                        </select>
                        <label>ImageURL:</label><br>
                        <input type="text" name="imageURLProduct" placeholder="Enter ImageURL Product"><br>
                        <label>Status:</label><br>
                        <select name="statusProduct">
                            <option value="Publish">Publish</option>
                            <option value="UnPublish">UnPublish</option>
                        </select><br>
                        <label>Tags:</label><br>
                        <div class="tag-input-container">
                            <ul id="tagList"></ul>
                            <input type="text" id="tagInput" placeholder="Enter Tags">
                        </div>
                        <input type="hidden" name="tags" id="tagsHidden">
                        <label>Description:</label><br>
                        <textarea name="descriptionProduct" id="editor"></textarea>
                    </div>
                    <div class="productInfo2">
                        <div class="productPrice">
                            <label>New Price:</label><br>
                            <input type="number" name="newPriceProduct" step="0.01" min="0" value="{{ old('newPriceProduct', 0) }}" placeholder="Enter New Price Product" required><br>
                            <label>Old Price:</label><br>
                            <input type="number" name="oldPriceProduct" step="0.01" min="0" value="{{ old('oldPriceProduct', 0) }}" placeholder="Enter Old Price Product"><br>
                        </div>
                        <div class="productCategory">
                            <label>Category:</label>
                            <select id="category" name="categoryProduct" onchange="filterSubCategories()">
                                <option value="">Category</option>
                                @foreach ($categoryList as $row)
                                    <option value="{{ $row->IdCategory }}">{{ $row->NameCategory }}</option>
                                @endforeach
                            </select>
                            <label>Sub Category:</label>
                            <select id="subcategory" name="subCategoryProduct">
                                <option value="">Sub Category</option>
                                @foreach ($subCategoryList as $row)
                                    <option value="{{ $row->IdSub }}" data-category="{{ $row->IdSubCategory }}">{{ $row->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit">Submit</button>
            </form>
            <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace('editor');
            </script>
            <script src="{{ asset('utils/slug.js') }}"></script>
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
                initTagInput('tagInput', 'tagList', 'tagsHidden', 'initialTags');
            </script>
        </div>
    </div>
    @include('components.fail')
@endsection