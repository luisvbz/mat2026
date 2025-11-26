<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach($matriculas as $grado)
    <div class="page-break">
        <h4 style="text-align: center;">{{ $grado->nivel }} - {{ $grado->grado }} Grado</h4>
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <tr>
                @foreach($grado->alumnos as $index => $alumno)
                <td style="width: 25%; padding: 10px; vertical-align: top;">
                    <img src="https://api-qrserver-com.translate.goog/v1/create-qr-code/?size=150x150&data={{ $alumno->dni }}" alt="QR" style="padding: 5px; border: 1px solid #000;">
                    <p style="margin-top: 10px; font-size: 12px; text-align: center;">{{ $alumno->alumno }}</p>
                </td>
                @if(($index + 1) % 4 == 0)
            </tr>
            <tr>
                @endif
                @endforeach
            </tr>
        </table>
    </div>
    @endforeach
</body>
</html>
