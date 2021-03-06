<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;
class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                //'products_image'         => 'required',
                //'manufacturers_id'       => 'required',
                'products_quantity'      => 'required',
                //'products_model'         => 'required',
                'products_price'         => 'required',
                //'products_date_added'    => 'required',
                'products_weight'        => 'required',
                'products_status'        => 'required',
                //'products_tax_class_id'  => 'required',
                'products_weight_unit'   => 'required',
                //'low_limit'              => 'required'
        ];
    }

     public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            
            $checkRecord = DB::table('products_attributes')->where([
                        'options_id'       =>   $this->products_options_id,
                        'products_id'      =>   $this->id, 
                        'options_values_id'=>   $this->products_options_values_id,  
                ])->whereNotIn('products_attributes_id',[$this->products_attributes_id]
                    )
                ->get();

            if ( count($checkRecord) > 0 ) {

                $validator->errors()->add('products_options_id', 'Option allready exits.');
            }

        });
    }
}
