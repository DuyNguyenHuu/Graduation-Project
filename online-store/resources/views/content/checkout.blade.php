@extends('layouts.template')

@section('content')
    <div class="deliInfo">
        <h2>Delivery Information</h2>
        @if ($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <label>Full Name:</label><br>
            <input type="text" name="fullname" value="{{ session('delivery_info')['fullname'] ?? ''}}" required><br>
            <label>Phone:</label><br>
            <input type="text" name="phone" value="{{ session('delivery_info')['phone'] ?? ''}}" required><br>
            <label>City/Province:</label>
            <select name="province" id="province" required>
                <option value="">-- Select Province --</option>
            </select><br>
            <label>Commune/Ward:</label>
            <select name="ward" id="ward" required >
                <option value="">-- Select Ward --</option>
            </select><br>
            <label>Address:</label><br>
            <input type="text" name="address" value="{{ session('delivery_info')['address'] ?? ''}}" required><br>
            <label>Note:</label><br>
            <input type="text" name="note" value="{{ session('delivery_info')['note'] ?? ''}}"><br>
            <input type="hidden" name="province_name" id="province_name">
            <input type="hidden" name="ward_name" id="ward_name">
            <button type="submit">Continue</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let selectedProvince = "{{ session('delivery_info')['province'] ?? ''}}";
            let selectedWard = "{{ session('delivery_info')['ward'] ?? ''}}";

            // Load danh sách tỉnh
            $.get("https://provinces.open-api.vn/api/v2/p", function (data) {
                data.forEach(item => {
                    let isSelected = item.code == selectedProvince ? 'selected' : '';
                    $('#province').append(`<option value="${item.code}" ${isSelected}>${item.name}</option>`);
                });

                // Nếu đã có province chọn sẵn → trigger change để load ward
                if(selectedProvince){
                    $('#province').trigger('change');
                }
            });

            // Khi chọn tỉnh → load xã/phường
            $('#province').on('change', function () {
                let provinceCode = $(this).val();
                $('#ward').html('<option value="">-- Select Ward --</option>');

                $('#province_name').val($("#province option:selected").text());

                if (provinceCode) {
                    $.get(`https://provinces.open-api.vn/api/v2/p/${provinceCode}?depth=2`, function (data) {
                        data.wards.forEach(ward => {
                            let isSelected = ward.code == selectedWard ? 'selected' : '';
                            $('#ward').append(`<option value="${ward.code}" ${isSelected}>${ward.name}</option>`);
                        });
                        if (selectedWard) {
                            $('#ward_name').val($("#ward option:selected").text());
                        }
                    });
                }
            });
            $('#ward').on('change', function () {
                $('#ward_name').val($("#ward option:selected").text());
            });
        })
    </script>

@endsection
