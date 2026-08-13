<div>

    <div class="modal-overlay" id="modal-ver-cliente" wire:ignore.self>
        <div class="modal modal-lg" style="max-width: 800px;">
            <!-- Header -->
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                        {{ $this->getIniciaisNome() }}
                    </div>
                    <div>
                        <h3 class="modal-title">{{ $nome_completo }}</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                            {{ $numero_matricula }} | BI: {{ $bi }}
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: var(--space-sm); align-items: center;">
                    <span class="badge {{ $this->getStatusBadgeClass() }}">{{ $this->getStatusLabel() }}</span>
                    <button class="modal-close" wire:click="fecharModal" type="button">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-xl);">
                    <!-- Coluna Esquerda -->
                    <div>
                        <!-- Dados Cadastrais -->
                        <div style="margin-bottom: var(--space-lg);">
                            <h4
                                style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                                Dados Cadastrais
                            </h4>
                            <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span style="color: var(--text-muted); font-size: var(--label-size);">Nome</span>
                                    <span
                                        style="font-weight: 500; font-size: var(--label-size);">{{ $nome_completo }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span style="color: var(--text-muted); font-size: var(--label-size);">BI</span>
                                    <span
                                        style="font-family: monospace; font-size: var(--label-size);">{{ $bi }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span style="color: var(--text-muted); font-size: var(--label-size);">E-mail</span>
                                    <span style="font-size: var(--label-size);">{{ $email }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span
                                        style="color: var(--text-muted); font-size: var(--label-size);">Telefone</span>
                                    <span style="font-size: var(--label-size);">{{ $telefone }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span
                                        style="color: var(--text-muted); font-size: var(--label-size);">Nascimento</span>
                                    <span style="font-size: var(--label-size);">{{ $data_nascimento }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div>
                            <h4
                                style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                                Endereço de Instalação
                            </h4>
                            <div
                                style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md);">
                                <p style="font-size: var(--label-size); color: var(--text-primary); line-height: 1.6;">
                                    {!! $endereco_completo !!}<br>
                                    @if ($zona_distribuicao)
                                        <span style="color: var(--tertiary);">{{ $zona_distribuicao }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Direita -->
                    <div>
                        <!-- Dados da Ligação -->
                        <div style="margin-bottom: var(--space-lg);">
                            <h4
                                style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                                Dados da Ligação
                            </h4>
                            <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span
                                        style="color: var(--text-muted); font-size: var(--label-size);">Matrícula</span>
                                    <span
                                        style="font-family: monospace; font-size: var(--label-size);">{{ $numero_matricula }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span
                                        style="color: var(--text-muted); font-size: var(--label-size);">Categoria</span>
                                    <span class="badge badge-success"
                                        style="font-size: var(--small-size);">{{ $categoria_consumo }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span style="color: var(--text-muted); font-size: var(--label-size);">Ramal</span>
                                    <span style="font-size: var(--label-size);">{{ $diametro_ramal }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span
                                        style="color: var(--text-muted); font-size: var(--label-size);">Economias</span>
                                    <span style="font-size: var(--label-size);">{{ $numero_economias }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                                    <span style="color: var(--text-muted); font-size: var(--label-size);">Data
                                        Ligação</span>
                                    <span style="font-size: var(--label-size);">{{ $data_ligacao }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Hidrômetro -->
                        <div style="margin-bottom: var(--space-lg);">
                            <h4
                                style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                                Hidrômetro
                            </h4>
                            <div
                                style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md);">
                                <div
                                    style="display: flex; justify-content: space-between; margin-bottom: var(--space-xs);">
                                    <span style="color: var(--text-muted); font-size: var(--small-size);">Número</span>
                                    <span
                                        style="font-family: monospace; font-size: var(--label-size);">{{ $numero_hidrometro }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; margin-bottom: var(--space-xs);">
                                    <span style="color: var(--text-muted); font-size: var(--small-size);">Marca /
                                        Tipo</span>
                                    <span style="font-size: var(--label-size);">{{ $marca_hidrometro }} —
                                        {{ $tipo_hidrometro }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; margin-bottom: var(--space-xs);">
                                    <span
                                        style="color: var(--text-muted); font-size: var(--small-size);">Diâmetro</span>
                                    <span style="font-size: var(--label-size);">{{ $diametro_hidrometro }}</span>
                                </div>
                                <div
                                    style="display: flex; justify-content: space-between; margin-bottom: var(--space-xs);">
                                    <span style="color: var(--text-muted); font-size: var(--small-size);">Leitura
                                        Atual</span>
                                    <span
                                        style="font-weight: 700; font-size: var(--label-size); color: var(--primary);">{{ number_format($leitura_atual, 0, ',', '.') }}
                                        m³</span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: var(--text-muted); font-size: var(--small-size);">Última
                                        Leitura</span>
                                    <span style="font-size: var(--small-size);">{{ $data_ultima_leitura }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Fatura Atual -->
                        @if ($valor_fatura_atual > 0)
                            <div
                                style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius-md); padding: var(--space-lg); color: white;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-sm);">
                                    <span style="font-size: var(--small-size); opacity: 0.9;">Fatura Atual</span>
                                    <span style="font-size: var(--label-size); font-weight: 600;">Vence
                                        {{ $vencimento_fatura }}</span>
                                </div>
                                <div style="font-size: 1.75rem; font-weight: 700;">Kz
                                    {{ number_format($valor_fatura_atual, 2, ',', '.') }}</div>
                                <div style="display: flex; gap: var(--space-sm); margin-top: var(--space-md);">
                                    <button class="btn btn-sm"
                                        style="background: rgba(255,255,255,0.2); color: white; border: none;"
                                        wire:click="verFatura" type="button">
                                        Ver Fatura
                                    </button>
                                    <button class="btn btn-sm"
                                        style="background: white; color: var(--primary); border: none;"
                                        wire:click="pagarFatura" type="button">
                                        Pagar
                                    </button>
                                </div>
                            </div>
                        @else
                            <div
                                style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                <span style="color: var(--text-muted); font-size: var(--label-size);">Nenhuma fatura
                                    pendente</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn btn-outline" wire:click="fecharModal" type="button">Fechar</button>
                <button class="btn btn-secondary" wire:click="abrirEdicao" type="button">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                    </svg>
                    Editar Cliente
                </button>
            </div>
        </div>
    </div>

</div>
