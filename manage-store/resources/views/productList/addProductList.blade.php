@extends('layouts.home')
@section('content')
<div class="product">
    <div class="Add">
        <div>
            <p>Create Product</p>
        </div>
        <div>
            <a href="{{ url('productList') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form method="POST" action="/productList">
            @csrf
            <div class="productDetail">
                <div class="productInfo1">
                    <label>Name Product:</label><br>
                    <input type="text" name="nameProduct" id="NameProduct" placeholder="Enter Name Product"><br>
                    <label>Id Product:</label>
                    <input type="text" name="idProduct" id="ProductSlug" placeholder="Enter Id Product"><br>
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
                    <label>Description:</label><br>
                    <textarea name="descriptionProduct" id="editor"></textarea>
                </div>
                <div class="productInfo2">
                    <div class="productPrice">
                        <label>New Price:</label><br>
                        <input type="number" name="newPriceProduct" step="0.01" min="0" value="{{ old('newPriceProduct', 0) }}" placeholder="Enter New Price Product"><br>
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
        <script>
            function generateSlug(str) {
                return str
                    .toLowerCase()
                    .normalize('NFD')                         // tách dấu tiếng Việt
                    .replace(/[\u0300-\u036f]/g, '')          // xóa dấu
                    .replace(/[^a-z0-9\s-]/g, '')             // bỏ ký tự đặc biệt
                    .trim()
                    .replace(/\s+/g, '-')                     // thay khoảng trắng bằng dấu gạch ngang
                    .replace(/-+/g, '-');                     // gộp nhiều dấu - liền nhau
            }
        
            document.getElementById('NameProduct').addEventListener('input', function() {
                const slug = generateSlug(this.value);
                document.getElementById('ProductSlug').value = slug;
            });
        </script>
        <script>
            function filterSubCategories() {
                const selectedCategory = document.getElementById("category").value;
                const subcategorySelect = document.getElementById("subcategory");
                const options = subcategorySelect.options;

                for (let i = 0; i < options.length; i++) {
                    const option = options[i];
                    const belongsTo = option.getAttribute("data-category");
        
                    if (!belongsTo || selectedCategory === "") {
                        option.style.display = "";
                    } else {
                        option.style.display = (belongsTo === selectedCategory) ? "" : "none";
                    }
                }

            subcategorySelect.value = ""; // Reset selection
        }
        </script>
    </div>
</div>
@endsection