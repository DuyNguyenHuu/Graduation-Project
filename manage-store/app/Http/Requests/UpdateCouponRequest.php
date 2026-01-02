<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'code'          => 'required|string|min:6|',
            'condition'      => 'required|numeric|min:0',
            'discounttype'  => 'required',
            'discountvalue' => 'required|numeric|min:0',
            'startdate'     => 'required|date',
            'enddate'       => 'required|date|after_or_equal:startdate',
            'time'          => 'required|integer|min:1',
            'status'        => 'required|in:0,1',
        ];
    }
}