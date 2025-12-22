<div style="font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color: #222">
    <h2>Olá {{ $user->name }},</h2>

    <p>Por segurança, a administração do site requisitou que todos os usuários ativem a autenticação de dois fatores (2FA).</p>

    <p>Para completar o processo e garantir acesso contínuo à sua conta, siga este link e configure sua 2FA:</p>

    <p><a href="{{ url('/two-factor') }}">Configurar Autenticação de Dois Fatores</a></p>

    <p>Se você já ativou a 2FA, ignore este e-mail.</p>

    <p>Atenciosamente,<br>Equipe</p>
</div>