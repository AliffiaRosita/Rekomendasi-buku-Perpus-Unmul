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
        $pengunjung_id = \Request::segments()[1];
        $rules=[
            'nama_pengunjung' =>'required',
            'nim'=> 'sometimes|required | numeric|unique:pengunjung,nim,'.$pengunjung_id,
            'fakultas'=>'required',
            'angkatan' => 'required | numeric',
            'email'=>'sometimes|email|required| unique:users',
            'password'=>'required| min:8',
            'foto_profil' =>'mimes:JPG,JPEG,PNG,jpg,jpeg,png|max:3000',
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
            'foto_profil.mimes'=>'Extensi Foto Harus .jpg, .png, atau .jpeg',
            'foto_profil.max'=>'Ukuran Foto Maksimal 3 MB.'
        ];
    }
}
