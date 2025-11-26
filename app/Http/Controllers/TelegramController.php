<?php

namespace App\Http\Controllers;

use App\Models\CronogramaPagos;
use App\Models\Matricula;
use App\Models\Pension;
use Illuminate\Http\Request;
use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\GetMe;
use unreal4u\TelegramAPI\Telegram\Methods\GetUpdates;
use unreal4u\TelegramAPI\Telegram\Methods\GetWebhookInfo;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Types\Inline\Query\Result\Article;
use unreal4u\TelegramAPI\Telegram\Types\InputMessageContent\Text;
use unreal4u\TelegramAPI\Telegram\Types\Update;
use unreal4u\TelegramAPI\TgLog;
use unreal4u\TelegramAPI\Abstracts\TelegramTypes;

class TelegramController extends Controller
{

    public function updates(Request $request)
    {
        $loop = Factory::create();
        $tgLog = new TgLog('1584444429:AAGPh3Gc7vBxA5VGHNW3pZOhJCTUR4d5YiI', new HttpClientRequestHandler($loop));

        $update = new Update($request->all());
        if (!empty($update->message)) {
            $mesage = $update->message->text;
            if (!is_numeric($mesage)) {
                return;
            }

            $dni = trim($update->message->text);
            $matricula = Matricula::where('codigo', "IEPDS-{$dni}-2026")->where('estado', 1)->first();
            $pensionMarzo = '';
            $pensionAbril = '';
            $pensionMayo = '';
            $pensionJunio = '';
            $pensionJulio = '';
            $pensionAgosto = '';
            $pensionSeptiembre = '';
            $pensionOctubre = '';
            $pensionNoviembre = '';
            $pensionDiciembre = '';

            if ($matricula) {
                $pagoMarzo = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '03')->first();
                $pagoAbril = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '04')->first();
                $pagoMayo = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '05')->first();
                $pagoJunio = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '06')->first();
                $pagoJulio = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '07')->first();
                $pagoAgosto = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '08')->first();
                $pagoSeptiembre = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '09')->first();
                $pagoOctubre = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '10')->first();
                $pagoNoviembre = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '11')->first();
                $pagoDiciembre = Pension::where('codigo_matricula', $matricula->codigo)->where('estado', 1)->where('mes', '12')->first();

                $pensionMarzo = $pagoMarzo ? "✅ Pension de Marzo - <b>Pagada</b>" : "⏳ Pensión de Marzo - <b>Pendiente</b>";
                $pensionAbril = $pagoAbril ? "✅ Pension de Abril - <b>Pagada</b>" : "⏳ Pensión de Abril - <b>Pendiente</b>";
                $pensionMayo = $pagoMayo ? "✅ Pension de Mayo - <b>Pagada</b>" : "⏳ Pensión de Mayo - <b>Pendiente</b>";
                $pensionJunio = $pagoJunio ? "✅ Pension de Junio - <b>Pagada</b>" : "⏳ Pensión de Junio - <b>Pendiente</b>";
                $pensionJulio = $pagoJulio ? "✅ Pension de Julio - <b>Pagada</b>" : "⏳ Pensión de Julio - <b>Pendiente</b>";
                $pensionAgosto = $pagoAgosto ? "✅ Pension de Agosto - <b>Pagada</b>" : "⏳ Pensión de Agosto - <b>Pendiente</b>";
                $pensionSetiembre = $pagoSeptiembre ? "✅ Pension de Setiembre - <b>Pagada</b>" : "⏳ Pensión de Setiembre - <b>Pendiente</b> ";
                $pensionOctubre = $pagoOctubre ? "✅ Pension de Octubre - <b>Pagada</b>" : "⏳ Pensión de Octubre - <b>Pendiente</b>";
                $pensionNoviembre = $pagoNoviembre ? "✅ Pension de Noviembre - <b>Pagada</b>" : "⏳ Pensión de Noviembre - <b>Pendiente</b>";
                $pensionDiciembre = $pagoDiciembre ? "✅ Pension de Diciembre - <b>Pagada</b>" : "⏳ Pensión de Diciembre - <b>Pendiente</b>";

                $sendMessage = new SendMessage();
                $sendMessage->chat_id = $update->message->chat->id;
                $sendMessage->parse_mode = 'HTML';
                //$sendMessage->text = $matricula->alumno->nombre_completo;
                $sendMessage->text = <<<HTML
                    <b>{$matricula->alumno->nombre_completo}</b>
                     {$pensionMarzo}
                     {$pensionAbril}
                     {$pensionMayo}
                     {$pensionJunio}
                     {$pensionJulio}
                     {$pensionAgosto}
                     {$pensionSetiembre}
                     {$pensionOctubre}
                     {$pensionNoviembre}
                     {$pensionDiciembre}
                    HTML;
                //$sendMessage->text = "<b>{{ $matricula->alumno->nombre_completo}}<br></b>".$pensionesText;
                $tgLog->performApiRequest($sendMessage);
            } else {
                $sendMessage = new SendMessage();
                $sendMessage->chat_id = $update->message->chat->id;
                $sendMessage->text = "No se ha encontrado la matricula con el DNI {$dni}";
                $tgLog->performApiRequest($sendMessage);
            }
        }
        $loop->run();
    }
}
