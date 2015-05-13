<div style="margin:0;padding:0;min-width:100%;background-color:#17a143">
    <center style="display:table;table-layout:fixed;width:100%;min-width:620px;background-color:#17a143">
        <table style="border-collapse:collapse;border-spacing:0;width:650px;min-width:650px">
            <tbody><tr><td style="padding:0;vertical-align:top;font-size:1px;line-height:1px">&nbsp;</td></tr></tbody>
        </table>

        <table style="border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;width:602px">
            <tbody><tr><td style="padding:0;vertical-align:top;font-size:1px;line-height:1px;background-color:#15963e;width:1px">&nbsp;</td></tr>
            <tr><td style="padding:32px 0;vertical-align:top"><div style="font-size:26px;font-weight:700;letter-spacing:-0.02em;line-height:32px;color:#e9eff5;font-family:sans-serif;text-align:center" align="center">Sistema de reservas - Dirección Fomento Cultural</div></td></tr>
            </tbody>
        </table>

        <table style="border-collapse:collapse;border-spacing:0;font-size:1px;line-height:1px;background-color:#15963e;Margin-left:auto;Margin-right:auto" width="602">
            <tbody><tr><td style="padding:0;vertical-align:top">?</td></tr>
            </tbody></table>

        <table style="border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto">
            <tbody><tr>
                <td style="padding:0;vertical-align:top;font-size:1px;line-height:1px;background-color:#15963e;width:1px">?</td>
                <td style="padding:0;vertical-align:top">
                    <table style="border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;width:600px;background-color:#ffffff;font-size:14px;table-layout:fixed">
                        <tbody><tr>
                            <td style="padding:0;vertical-align:top;text-align:left">
                                <div><div style="font-size:32px;line-height:32px">&nbsp;</div></div>
                                <table style="border-collapse:collapse;border-spacing:0;table-layout:fixed;width:100%">
                                    <tbody><tr>
                                        <td style="padding:0;vertical-align:top;padding-left:32px;padding-right:32px;word-break:break-word;word-wrap:break-word">
                                            <h2 style="Margin-top:0;color:#29853f;font-style:italic;font-weight:normal;font-size:26px;line-height:34px;Margin-bottom:20px;font-family:sans-serif"><strong style="font-weight:bold">Préstamos pendientes de devolución.</strong></h2>
                                            <h3 style="Margin-top:0;color:#555;font-weight:normal;font-size:18px;line-height:26px;Margin-bottom:16px;font-family:Georgia,serif">Cordial Saludo./h3>
                                            <h3 style="Margin-top:0;color:#555;font-weight:normal;font-size:18px;line-height:26px;Margin-bottom:16px;font-family:Georgia,serif">Notificamos que al día de hoy los préstamos relacionados a continuación no han sido devueltos al laboratorio de fomento cultural: </h3>

                                            <table style="border:1px solid green; width:100%;">
                                                <thead style="font-size:12px; text-align:center; color: white; font-weight:bold; background-color:#17a143; font-family: Arial, Helvetica, sans-serif;">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Responsable</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Fin</th>
                                                </tr>
                                                </thead>

                                                <tbody style="font-size:12px; text-align:center; font-family: Arial, Helvetica, sans-serif;">
                                                    @foreach($prestamos as $prestamo)
                                                        <tr>
                                                            <td>{{ $prestamo->id }}</td>
                                                            <td>{{ $prestamo->user->nombres.' '.$prestamo->user->apellidos }}</td>
                                                            <td>{{ $prestamo->fechaInicio->format('d/m/Y h:i A') }}</td>
                                                            <td>{{ $prestamo->fechaFin->format('d/m/Y h:i A') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            </br>
                                            </br>

                                            <p style="Margin-top:0;color:#565656;font-family:Georgia,serif;font-size:16px;line-height:25px;Margin-bottom:24px">Agradecemos su pronta gestión para agilizar la devolución de dichos préstamos.</p>

                                        </td>
                                    </tr>
                                    </tbody></table>

                                <div style="font-size:8px;line-height:8px">&nbsp;</div>
                            </td>
                        </tr>
                        </tbody></table>
                </td>
                <td style="padding:0;vertical-align:top;font-size:1px;line-height:1px;background-color:#15963e;width:1px">?</td>
            </tr>
            </tbody></table>


        <div style="font-size:1px;line-height:32px;width:100%">&nbsp;</div>

    </center>
</div>