<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request){
        $buscar=$request->input('Form');
        $cliente = new \GuzzleHttp\Client();
        $response = $cliente->request('GET','https://www.googleapis.com/books/v1/volumes?q='.$buscar);
        $datos = json_decode($response->getBody()->getContents(), true);
        //recorrer elementos
        $libros=[];
        foreach($datos['items'] as $libro){
            $libros[]=[
                'titulo'=>$libro['volumeInfo']['title'],
                'hojas'=>$libro['volumeInfo']['pageCount'],
                'fecha'=>$libro['volumeInfo']['publishedDate'],
                'autor'=>$libro['volumeInfo']['authors'],
                'descripcion'=>$libro['volumeInfo']['description'],
                'lenguaje'=>$libro['volumeInfo']['language'],
                'portada'=>$libro['volumeInfo']['imageLinks']['thumbnail'],
            ];
        }
        return view('index',['libros' => $libros]);
    }
    public function share(){
        return view('share');
    }
}
