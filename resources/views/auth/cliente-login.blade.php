<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AquaNexus - Gestão de Fornecimento de Água</title>
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-page">
        <div class="login-container">
            <!-- Brand Side -->
            <div class="login-brand">
                <div class="water-drop"></div>
                <div class="water-drop"></div>
                <div class="water-drop"></div>
                <div class="brand-content">
                    <div class="brand-logo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                        </svg>
                    </div>
                    <h1 class="brand-title">{{ App\Models\Company::where('id', 1)->first()->nome_fantasia }}</h1>
                    {{-- <p class="brand-subtitle">Sistema integrado de gestão e distribuição de fornecimento de água</p> --}}
                    <p class="brand-subtitle">{{ App\Models\Company::where('id', 1)->first()->razao_social }}</p>

                    <div class="brand-features">
                        <div class="brand-feature">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                            Gestão de clientes e medidores
                        </div>
                        <div class="brand-feature">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                            Faturamento e cobrança automatizada
                        </div>
                        <div class="brand-feature">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                            Monitoramento de consumo em tempo real
                        </div>
                        <div class="brand-feature">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                            Alertas de vazamentos e anomalias
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Side -->
            <div class="login-form-section">
                <div class="login-header">
                    <h2>Bem-vindo de volta</h2>
                    <p>Entre com suas credenciais para acessar o sistema</p>
                </div>

                <form class="login-form" method="POST" action="{{ route('cliente.login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="telefone" :value="__('telefone')">N° Telefone Cliente</label>
                        <div class="input-wrapper">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                            <input type="text" class="form-input" placeholder="+258 84 810 7874" name="telefone"
                                value="{{ old('telefone') }}" required>
                        </div>
                        <x-input-error :messages="$errors->get('telefone')" class="mt-2" style="color:var(--danger)" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password" :value="__('Password')">
                            Senha
                            <a href="#">Esqueceu a senha?</a>
                        </label>
                        <div class="input-wrapper">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" name="password" class="form-input" id="password"
                                placeholder="••••••••" required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">
                                <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" style="color:var(--danger)" class="mt-2" />
                    </div>

                    <div class="login-options">
                        <label class="remember-me">
                            <input type="checkbox" id="remember_me" name="remember">
                            <span>Lembrar-me</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="margin-right: 8px;">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" x2="3" y1="12" y2="12" />
                        </svg>
                        Entrar no Sistema
                    </button>
                </form>

                <div class="login-divider">ou</div>

                <button class="btn btn-outline" style="width: 100%; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 8px;">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    Suporte Técnico
                </button>

                <div class="login-footer">
                    <p>© 2026 AquaNexus. Todos os direitos reservados.</p>
                    <p style="margin-top: var(--space-xs);">Versão 2.4.1 | <a href="#">Política de
                            Privacidade</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" x2="23" y1="1" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        function handleLogin(e) {
            e.preventDefault();
            // Simulate login - redirect to dashboard
            const btn = e.target.querySelector('.btn-login');
            btn.innerHTML =
                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px; animation: spin 1s linear infinite;"><circle cx="12" cy="12" r="10" stroke-dasharray="60" stroke-dashoffset="20"/></svg> Entrando...';
            btn.disabled = true;

            setTimeout(() => {
                window.location.href = 'home.html';
            }, 1500);
        }
    </script>
</body>

</html>
