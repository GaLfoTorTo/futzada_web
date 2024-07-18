<?php

//namespace App\Helpers;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;

// FUNÇÃO PARA UPLOAD DE ARQUIVOS
function upload($data) {
    //TENTAR SALVAR O USUÁRIO
    try {
        // REGATAR OBJETO DA REQUEST
        $request = $data['request'];
        // DEFININDO PASTA ONDE SERÃO SALVOS OS ARQUIVOS
        $pasta = $data['pasta'];
        // VERIFICAR SE EXISTE UM ARQUIVO NOS DADOS RECEBIDOS
        if ($request->hasFile('foto')) {
            // RESGATAR ARQUIVO
            $file = $request->file('foto');
            // RENOMEAR ARQUIVO
            $nome_arquivo = renameData($file->getClientOriginalName());
            // RESGATAR A EXTENSÃO ORIGINAL DO ARQUIVO
            $ext = $file->getClientOriginalExtension();
            // DEFINIR CAMINHO DE SALVAMENTO DO ARQUIVO 
            $path_file = 'public/upload/' . $pasta . '/' . $nome_arquivo;
            // VERIFICAR SE A EXTENSÃO DO ARQUIVO É OU NÃO UMA IMAGEM
            if (in_array($ext, ['png', 'jpeg', 'jpg', 'jiff'])) {
                // SE FOR, CRIAR INSTÂNCIA DE IMAGE A PARTIR DA IMAGEM ENVIADA
                $img = Image::read($file->path());
                // RESGATAR LARGURA
                $width = $img->width();
                // VERIFICAR SE A LARGURA É MAIOR QUE 800 PX
                if ($width > 1024) {
                    // SE MAIOR, REDIMENSIONAR IMAGEM PARA UMA LARGURA DE 1024 PX MANTENDO ALTURA COMPATÍVEL
                    $img->resize(1024, null, function ($const) {
                        $const->aspectRatio();
                    });
                }
                // MOVER IMAGEM PARA O CAMINHO INDICADO NA STORAGE
                $imgData = (string) $img->encode();
                Storage::put($path_file, $imgData);
                // RETORNAR CAMINHO DA IMAGEM
                return '/storage/'.$path_file;     
            }
        }
    }catch(\Exception $e) {
        //CAPTURAR ERRO E ENVIAR PARA O LOG
        Log::channel('arquivos')->error("[Erro de upload arquivos][Usuario][Arquivos]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
        //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
        return response()->json(['message' => 'Houve um erro ao salvar o arquivo.'], 400);
    }
}

function renameData($nome){
    //REMOVER ESPAÇOS
    $new_name = str_replace(' ', '_', $nome);
    //LETRAS COM ACENTO / CARACTERES ESPECIAIS
    $comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');
    //LETRAS SEM ACENTO / CARACTERES ESPECIAIS
    $semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U');
    //SUBUSTITUIR LETRAS COM ACENTROS POR SEM ACENTO
    $new_nome = str_replace($comAcentos, $semAcentos, $new_name);
    //RETORNAR NOVO NOME
    return $new_nome;
}

function removeCharEspeciais($text){
    //REMOVER ESPAÇOS
    $new_text = str_replace(' ', '', $text);
    //PADRÃO DE CARACTERES ESPECIAIS
    $padrao = '/[^a-zA-Z0-9\s]/';
    //SUBISTITUIR CARACTERS
    $new_text = preg_replace($padrao, '', $new_text);
    //RETORNAR NOVO TEXTO
    return $new_text;
}