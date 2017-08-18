<?php

namespace App\Http\Controllers;

use App\Leitura;
use App\User;
use Google\Cloud\Vision\VisionClient;
use Illuminate\Http\Request;

class LeituraController extends Controller
{
    public function registrar(Request $request)
    {
        $user = User::where('api_token', $request->api_token)->first();
        $leitura = new Leitura();
        $leitura->leitura = $request->leitura;
        $leitura->user_id = $user->id;
        $leitura->save();

        //Salva a imagem
        $path = $request->imagem->storeAs('leituras', $leitura->id . '.jpg');

        return response()->json(true);
    }

    public function detectarTexto(Request $request)
    {
        //Gera um id aleatorio
        $name = str_random(8);

        //Realiza upload da imagem
        $path = $request->imagem->storeAs('temp', $name . '.jpg');


        //Id do projeto
        $projectId = '15657998552';

        //Define variavel de ambiente para autenticacao
        //putenv('GOOGLE_APPLICATION_CREDENTIALS='.app_path()."/google_auth.json");


        //$client = new Google_Client();
        //$client->useApplicationDefaultCredentials();

        //namespace Google\Cloud\Samples\Vision;
        //use Google\Cloud\Vision\VisionClient;

// $projectId = 'YOUR_PROJECT_ID';
// $path = 'path/to/your/image.jpg'

        $return = null;


        $vision = new VisionClient([
            'projectId' => $projectId,
            'keyFilePath' => app_path().'/credentials.json'
        ]);
        $image = $vision->image(file_get_contents(storage_path()."/app/".$path), ['TEXT_DETECTION']);
        $result = $vision->annotate($image);
        print("Texts:\n");
        foreach ((array)$result->text() as $text) {
            $return .= $text->description() . PHP_EOL;
        }

        response()->json($return);
    }
}
