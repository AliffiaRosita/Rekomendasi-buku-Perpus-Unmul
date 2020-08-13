<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
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
            'nama_pengunjung' =>'required',
            'nim'=> 'required | numeric|unique:pengunjung',
            'fakultas'=>'required',
            'angkatan' => 'required | numeric',
            'email'=>'required| unique:users',
            'password'=>'required| min:8',
            'foto' =>'mimes:JPG,JPEG,PNG,jpg,jpeg,png|max:3000',
        ];
        return $rules;
    }
    public function messages()
    {
        return[
            'nama_pengunjung.required'=>'Nama Pengunjung wajib diisi',
            'nim.required'=>'NIM wajib diisi',
            'nim.unique'=>'NIM telah terdaftar',
            'nim.numeric'=>'NIM harus angka',
            'fakultas.required'=>'Fakultas wajib diisi',
            'angkatan.required'=>'Angkatan wajib diisi',
            'email.required'=>'Email wajib diisi',
            'email.unique'=>'Email telah terdaftar',
            'password.min'=>'Password Minimal minimal harus 8 karakter.',
            'password.required'=>'Password wajib diisi',
            'foto.mimes'=>'Extensi Foto Harus .jpg, .png, atau .jpeg',
            'foto.max'=>'Ukuran Foto Maksimal 3 MB.'
        ];
    }
}
