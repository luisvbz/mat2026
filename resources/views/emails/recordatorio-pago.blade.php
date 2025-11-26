<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <title>
    </title>
    <!--[if !mso]><!-- -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            margin: 13px 0;
        }
    </style>
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--[if lte mso 11]>
    <style type="text/css">
        .mj-outlook-group-fix { width:100% !important; }
    </style>
    <![endif]-->
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
    </style>
    <!--<![endif]-->
    <style type="text/css">
        @media only screen and (min-width:480px) {
            .mj-column-per-100 {
                width: 100% !important;
                max-width: 100%;
            }
        }
    </style>
    <style type="text/css">
        @media only screen and (max-width:480px) {
            table.mj-full-width-mobile {
                width: 100% !important;
            }

            td.mj-full-width-mobile {
                width: auto !important;
            }
        }
    </style>
</head>

<body>
    <div style="">
        <!--[if mso | IE]>
    <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
    >
        <tr>
            <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
    <![endif]-->
        <div style="margin:0px auto;max-width:600px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                            <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">

                        <tr>

                            <td
                                class="" style="vertical-align:top;width:600px;"
                            >
                    <![endif]-->
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    style="vertical-align:top;" width="100%">
                                    <tr>
                                        <td align="center"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                style="border-collapse:collapse;border-spacing:0px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:450px;">
                                                            <img height="auto"
                                                                src="https://iepdivinosalvador.net.pe/wp-content/uploads/2020/10/logo_web.png"
                                                                style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;"
                                                                width="450" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <p
                                                style="border-top:solid 4px #8B2724;font-size:1px;margin:0px auto;width:100%;">
                                            </p>
                                            <!--[if mso | IE]>
                                    <table
                                        align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 4px #8B2724;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px"
                                    >
                                        <tr>
                                            <td style="height:0;line-height:0;">
                                                &nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                    <![endif]-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <div
                                                style="font-family:helvetica;font-size:20px;line-height:1;text-align:center;color:#000000;">
                                                <b>RECORDATORIO DE PAGO N° {{ $numero }}</b></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="justify"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <div
                                                style="font-family:helvetica;font-size:20px;line-height:1;text-align:justify;color:#000000;">
                                                Estimado(a). <b> {{ $padre->apellidos }}, {{ $padre->nombres }}</b>.
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="justify"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <div
                                                style="font-family:helvetica;font-size:18px;line-height:1;text-align:justify;color:#000000;">
                                                @if (count($meses) > 1)
                                                    A traves del presente le recordamos que tiene pendiente la
                                                    cancelación las siguientes pensiones por el servicio educativo que
                                                    su menor hijo(a) <b>{{ $alumno->nombre_completo }}</b> está
                                                    recibiendo:
                                                @else
                                                    A traves del presente le recordamos que tiene pendiente la
                                                    cancelación de la pensión por el servicio educativo que su menor
                                                    hijo(a) <b>{{ $alumno->nombre_completo }}</b> está recibiendo:
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <table cellpadding="0" cellspacing="0" width="100%" border="0"
                                                style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:18px;line-height:22px;table-layout:auto;width:100%;border:none;">
                                                <tr
                                                    style="border-bottom:1px solid #ecedee;text-align:left;padding:15px 0;">
                                                    <th style="padding: 0 15px;">Pensión</th>
                                                    <th style="padding: 0 0 0 15px;">Monto</th>
                                                </tr>
                                                @php $total = 0.00; @endphp
                                                @foreach ($meses as $mes)
                                                    <tr>
                                                        <td style="padding: 0 15px;">Pensión del mes de
                                                            {{ $mes->mes | mes }}</td>
                                                        <td style="padding: 0 0 0 15px;"> S./ {{ $mes->costo }}</td>
                                                    </tr>
                                                    @php $total = $total + $mes->costo; @endphp
                                                @endforeach
                                                <tr>
                                                    <td style="padding: 0 15px; text-align: right;"><b>Total
                                                            adeudado</b></td>
                                                    <td style="padding: 0 0 0 15px;"><b>S./
                                                            {{ number_format($total, 2, '.', ',') }}</b></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="justify"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <div
                                                style="font-family:helvetica;font-size:18px;line-height:1;text-align:justify;color:#000000;">
                                                @if (count($meses) > 1)
                                                    Por tal motivo se le solicita regularizar lo mas pronto posible los
                                                    pagos requeridos. Asimismo se le recuerda que una vez realizado la
                                                    cancelación de la pensión debe adjuntar el voucher en la plataforma
                                                    <a
                                                        href="https://matricula2026.iepdivinosalvador.net.pe/registrar-pago">Matricula
                                                        2026</a> seleccionado el concepto de pensión.
                                                @else
                                                    Por tal motivo se le solicita regularizar lo mas pronto posible el
                                                    pago requerido. Asimismo se le recuerda que una vez realizado la
                                                    cancelación de la pensión debe adjuntar el voucher en la plataforma
                                                    <a
                                                        href="https://matricula2026.iepdivinosalvador.net.pe/registrar-pago">Matricula
                                                        2026</a> seleccionado el concepto de pensión.
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="justify"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <div
                                                style="font-family:helvetica;font-size:18px;line-height:1;text-align:justify;color:#000000;">
                                                Agradeciendo su atención y comprensión, se despide muy cordialmente,
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <div
                                                style="font-family:helvetica;font-size:18px;line-height:1;text-align:center;color:#000000;">
                                                Atentamente</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"
                                            style="font-size:0px;padding:10px 25px;padding-right:30px;word-break:break-word;">
                                            <div
                                                style="font-family:helvetica;font-size:18px;line-height:1;text-align:right;color:#000000;">
                                                La Dirección</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <p
                                                style="border-top:solid 4px #8B2724;font-size:1px;margin:0px auto;width:100%;">
                                            </p>
                                            <!--[if mso | IE]>
                                    <table
                                        align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 4px #8B2724;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px"
                                    >
                                        <tr>
                                            <td style="height:0;line-height:0;">
                                                &nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                    <![endif]-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="justify"
                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                            <div
                                                style="font-family:helvetica;font-size:15px;line-height:1;text-align:justify;color:#000000;">
                                                Este correo es enviado automáticamente por nuestro sistema. Si tiene
                                                alguna duda comuniquese por los canales habituales. No responda a esta
                                                dirección de corre electrónico.</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!--[if mso | IE]>
                    </td>

                    </tr>

                    </table>
                    <![endif]-->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </div>
</body>

</html>
