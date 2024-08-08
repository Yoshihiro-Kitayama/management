<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => 'required | max:255',
            'price' => 'required | integer',
            'stock' => 'required | integer',
            'company_id' => 'required | max:255',
            'comment' => 'max:1000',
        ];
    }

    public function attributes()
{
    return [
        'product_name' => '商品名',
        'price' => '価格',
        'stock' => '在庫数',
        'company_id' => 'メーカー名',
        'comment' => 'コメント',
    ];
}

/**
 * エラーメッセージ
 *
 * @return array
 */
public function messages() {
    return [
        'product_name.required' => '商品名を20文字以内で入力してください。',
        'name.max' => ':attributeは:max字以内で入力してください。',
        'price.required' => ':attributeを入力してください。',
        'stock.required' => ':attributeは必須項目です。',
        'company_id.required' => ':attributeを選択してください。',
        'comment.max' => ':attributeは:max字以内で入力してください。',
    ];
}
}