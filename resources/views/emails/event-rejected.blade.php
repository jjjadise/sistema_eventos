<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"></head>
<body style="font-family: sans-serif; background: #f4f4f4; padding: 32px;">
    <div style="max-width: 560px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div style="background: #dc2626; padding: 32px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 22px;">Atualização sobre seu evento</h1>
        </div>
        <div style="padding: 32px;">
            <p style="color: #374151;">Olá, <strong>{{ $event->responsible_name }}</strong>!</p>
            <p style="color: #374151;">Infelizmente, após análise da nossa equipe, o evento abaixo <strong style="color: #dc2626;">não pôde ser aprovado</strong>:</p>
            <div style="background: #fff1f2; border-left: 4px solid #dc2626; padding: 16px; border-radius: 8px; margin: 20px 0;">
                <strong style="color: #b91c1c; font-size: 18px;">{{ $event->title }}</strong><br>
                <span style="color: #6b7280; font-size: 14px;">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y \à\s H:i') }}</span>
            </div>
            <div style="background: #fef9c3; border-left: 4px solid #ca8a04; padding: 16px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0 0 6px 0; font-size: 13px; font-weight: bold; color: #92400e;">Motivo da rejeição:</p>
                <p style="margin: 0; color: #374151; font-size: 14px;">{{ $reason }}</p>
            </div>
            <p style="color: #374151;">Se acredita que houve um engano ou deseja enviar uma nova solicitação corrigida, entre em contato respondendo este e-mail.</p>
        </div>
        <div style="background: #f9fafb; padding: 16px; text-align: center;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">Sistema de Eventos © {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
