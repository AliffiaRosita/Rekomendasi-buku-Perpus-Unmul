<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
        $rules=[
            'judul' =>'required',
            'penerbit'=> 'required',
            'isbn' => 'required',
            'tempat_terbit'=>'required',
            'foto' =>'mimes:JPG,JPEG,PNG,jpg,jpeg,png|max:3000',
        ];
        return $rules;
    }
    public function messages()
    {
        return[
            'judul.required'=>'Judul Buku wajib diisi',
            'penerbit.required'=>'Penerbit wajib diisi',
            'isbn.required'=>'ISBN wajib diisi',
            'tempat_terbit.required'=>'tempat terbit wajib diisi',
            'foto.mimes'=>'Extensi Foto Harus .jpg, .png, atau .jpeg',
            'foto.max'=>'Ukuran Foto Maksimal 3 MB.'
        ];
    }
}
