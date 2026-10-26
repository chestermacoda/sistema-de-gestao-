@extends('admin.Layout.layouts')

@section('content')
    <div class="page-content">
        <!-- Page Header -->
        <div class="page-header">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <h1 class="page-title">Clientes</h1>
                    <p class="page-subtitle">Gerencie todos os clientes do sistema de distribuição de água</p>
                </div>
                <button class="btn btn-primary" onclick="openModal('modal-novo-cliente')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    Novo Cliente
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <livewire:admin.clientes.clientes-stats />

        <!-- Filtros Dinâmicos -->
        <div>
            <!-- Filtros Dinâmicos -->
            <div class="card" style="padding: var(--space-md) var(--space-lg); margin-bottom: var(--space-lg);">
                <div style="display: flex; gap: var(--space-md); align-items: center; flex-wrap: wrap;">

                    <!-- Busca -->
                    <div style="position: relative; flex: 1; min-width: 250px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2"
                            style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="text" class="form-input" wire:model.live.debounce.300ms="search"
                            placeholder="Buscar por nome, matrícula, CPF/CNPJ..." style="padding-left: 2.5rem;">
                    </div>

                    <!-- Filtro Categoria -->
                    <select class="form-select" wire:model.live="categoriaFilter" style="width: auto; min-width: 160px;">
                        <option value="">Todas as Categorias</option>
                        <option value="Residencial">Residencial</option>
                        <option value="Comercial">Comercial</option>
                        <option value="Industrial">Industrial</option>
                        <option value="Público">Público</option>
                        <option value="Rural">Rural</option>
                    </select>

                    <!-- Filtro Status Cliente -->
                    <select class="form-select" wire:model.live="statusFilter" style="width: auto; min-width: 160px;">
                        <option value="">Todos os Status</option>
                        <option value="Ativo">Ligação Ativa</option>
                        <option value="Cortada">Ligação Cortada</option>
                        <option value="Inadimplente">Inadimplente</option>
                        <option value="Desativado">Desativado</option>
                    </select>

                    <!-- Filtro Zona -->
                    <select class="form-select" wire:model.live="zonaFilter" style="width: auto; min-width: 160px;">
                        <option value="">Todas as Zonas</option>
                        @if($zona)
                            @foreach($zona as $z)
                                <option value="{{ $z->nome }}">{{$z->nome}}</option>
                            @endforeach
                        @endif
                 
                    </select>

                    <!-- Filtro Status Leitura (NOVO) -->
                    {{-- <select class="form-select" wire:model.live="leituraStatusFilter"
                        style="width: auto; min-width: 160px;">
                        <option value="">Status Leitura</option>
                        <option value="Normal">Normal</option>
                        <option value="Anomalia">Anomalia</option>
                        <option value="Revisar">Revisar</option>
                        <option value="Editada">Editada</option>
                    </select> --}}

                    <!-- Exportar -->
                    <button class="btn btn-outline btn-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="margin-right: 6px;">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                        Exportar
                    </button>
                </div>
            </div>

            <!-- Clients Table -->
            <div class="card" style="margin: 0; margin-bottom: var(--space-xl);">
                <div class="card-header">
                    <h3 class="card-title">Lista de Clientes</h3>
                    <div style="display: flex; gap: var(--space-sm); align-items: center;">
                        <span style="font-size: var(--small-size); color: var(--text-muted);">
                            Mostrando {{ $this->clientes->firstItem() ?? 0 }}-{{ $this->clientes->lastItem() ?? 0 }}
                            de {{ $this->clientes->total() }}
                        </span>

                        <!-- Paginação Manual Estilizada -->
                        <div style="display: flex; gap: 4px;">
                            @if (!$this->clientes->onFirstPage())
                                <button class="btn btn-sm btn-ghost" wire:click="previousPage" wire:loading.attr="disabled">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </button>
                            @else
                                <button class="btn btn-sm btn-ghost" disabled>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                </button>
                            @endif

                            @foreach ($this->clientes->getUrlRange(1, $this->clientes->lastPage()) as $page => $url)
                                @if ($page == $this->clientes->currentPage())
                                    <button class="btn btn-sm btn-primary" style="min-width: 32px; justify-content: center;"
                                        wire:click="gotoPage({{ $page }})">
                                        {{ $page }}
                                    </button>
                                @elseif (
                                    $page == 1 ||
                                        $page == $this->clientes->lastPage() ||
                                        ($page >= $this->clientes->currentPage() - 1 && $page <= $this->clientes->currentPage() + 1))
                                    <button class="btn btn-sm btn-ghost" style="min-width: 32px; justify-content: center;"
                                        wire:click="gotoPage({{ $page }})">
                                        {{ $page }}
                                    </button>
                                @elseif ($page == $this->clientes->currentPage() - 2 || $page == $this->clientes->currentPage() + 2)
                                    <span
                                        style="color: var(--text-muted); padding: 0 4px; display: flex; align-items: center;">...</span>
                                @endif
                            @endforeach

                            @if ($this->clientes->hasMorePages())
                                <button class="btn btn-sm btn-ghost" wire:click="nextPage" wire:loading.attr="disabled">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </button>
                            @else
                                <button class="btn btn-sm btn-ghost" disabled>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="table-container">
                    <table id="tabelaClientes">
                        <thead>
                            <tr>
                                <th style="width: 40px;">
                                    <input type="checkbox" style="accent-color: var(--primary);">
                                </th>
                                <th>Cliente / Matrícula</th>
                                <th>BI/Nuit</th>
                                <th>Categoria</th>
                                <th>Zona / Bairro</th>
                                <th>Hidrômetro</th>
                                <th>Última Leitura</th>
                                <th>Status</th>
                                <th style="width: 120px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->clientes as $cliente)
                                @php
                                    $medidor = $cliente->medidor;
                                    $ultimaLeitura = $cliente->ultimaLeitura;

                                    $iniciais = $this->getIniciais($cliente->nome_completo);
                                    $avatarColors = $this->getAvatarColor($cliente->categoria_consumo);
                                    $catBadge = $this->getCategoriaBadge($cliente->categoria_consumo);
                                    $statusBadge = $this->getStatusBadge($cliente->status);
                                    $leituraStatusBadge = $this->getLeituraStatusBadge($ultimaLeitura);
                                    $consumo = $this->getConsumo($ultimaLeitura);
                                    $anomalia = $this->getAnomaliaDescricao($ultimaLeitura);
                                @endphp

                                <tr wire:key="cliente-row-{{ $cliente->id }}">
                                    <td>
                                        <input type="checkbox" style="accent-color: var(--primary);">
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: var(--space-md);">
                                            <div
                                                style="width: 40px; height: 40px; border-radius: 50%;
                                        background: linear-gradient(135deg, {{ $avatarColors }});
                                        display: flex; align-items: center; justify-content: center;
                                        color: white; font-weight: 600; font-size: var(--label-size);">
                                                {{ $iniciais }}
                                            </div>
                                            <div>
                                                <div
                                                    style="font-weight: 600; color: var(--text-primary); font-size: var(--label-size);">
                                                    {{ $cliente->nome_completo }}
                                                </div>
                                                <div
                                                    style="font-size: var(--small-size); color: var(--text-muted); font-family: monospace;">
                                                    {{ $cliente->numero_matricula }}
                                                </div>
                                                @if ($cliente->leituras_count > 0)
                                                    <div style="font-size: 0.6875rem; color: var(--text-muted);">
                                                        {{ $cliente->leituras_count }} leitura(s) registrada(s)
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-size: var(--label-size); font-family: monospace;">
                                        {{ $cliente->bi ?? ($cliente->nuit ?? '-') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $catBadge['class'] }}" style="{{ $catBadge['style'] }}">
                                            {{ $cliente->categoria_consumo }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size: var(--label-size); color: var(--text-primary);">
                                            {{ $cliente->zona_distribuicao ?? '-' }}
                                        </div>
                                        <div style="font-size: var(--small-size); color: var(--text-muted);">
                                            {{ $cliente->bairro ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($medidor)
                                            <div
                                                style="font-size: var(--label-size); font-family: monospace; color: var(--text-primary);">
                                                {{ $medidor->numero_hidrometro }}
                                            </div>
                                            <div style="font-size: var(--small-size); color: var(--text-muted);">
                                                {{ $medidor->diametro ?? '-' }}mm |
                                                Inst. {{ $ultimaLeitura?->data_instalacao?->format('d/m/Y') ?? '-' }}
                                            </div>
                                        @else
                                            <div style="font-size: var(--label-size); color: var(--text-muted);">
                                                —
                                            </div>
                                            <div style="font-size: var(--small-size); color: var(--text-muted);">
                                                Sem hidrômetro
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ultimaLeitura)
                                            <div
                                                style="font-size: var(--label-size); color: var(--text-primary); font-weight: 600;">
                                                {{ $consumo }}
                                            </div>
                                            <div style="font-size: var(--small-size); color: var(--text-muted);">
                                                {{ $ultimaLeitura->data_leitura?->format('d/m/Y') ?? '-' }}
                                            </div>
                                            @if ($anomalia)
                                                <div style="font-size: 0.6875rem; color: var(--warning); margin-top: 2px;"
                                                    title="{{ $anomalia }}">
                                                    ⚠ {{ $ultimaLeitura->tipo_anomalia }}
                                                </div>
                                            @endif
                                            @if ($ultimaLeitura->editada)
                                                <div style="font-size: 0.6875rem; color: var(--info); margin-top: 2px;">
                                                    ✎ Editada em {{ $ultimaLeitura->editado_em?->format('d/m/Y') }}
                                                </div>
                                            @endif
                                        @elseif($cliente->status === 'Cortada')
                                            <div
                                                style="font-size: var(--label-size); color: var(--danger); font-weight: 600;">
                                                —
                                            </div>
                                            <div style="font-size: var(--small-size); color: var(--danger);">
                                                Ligação cortada
                                            </div>
                                        @else
                                            <div style="font-size: var(--label-size); color: var(--text-muted);">
                                                —
                                            </div>
                                            <div style="font-size: var(--small-size); color: var(--text-muted);">
                                                Sem leitura
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 4px;">
                                            <span class="badge {{ $statusBadge['class'] }}">
                                                {{ $statusBadge['text'] }}
                                            </span>
                                            {{-- @if ($ultimaLeitura)
                                                <span class="badge {{ $leituraStatusBadge['class'] }}"
                                                    style="font-size: 0.625rem;">
                                                    {{ $leituraStatusBadge['text'] }}
                                                </span>
                                            @endif --}}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: var(--space-xs);">
                                            <button class="btn btn-sm btn-ghost"
                                                wire:click="$dispatch('ver-cliente',{ idCliente: {{ $cliente->id }} })"
                                                title="Visualizar">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-sm btn-ghost" {{-- wire:click='$dispatch("carregarClienteEdicao", { clienteId: {{ $cliente->id }} })' --}}
                                                wire:click="$dispatch('cliente-editar',{ clienteId: {{ $cliente->id }} })"
                                                title="Editar">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-sm btn-ghost"
                                                wire:click="$dispatch('historico-cliente',{ idCliente: {{ $cliente->id }}})"
                                                title="Histórico">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <polyline points="12 6 12 12 16 14" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 60px 20px;">
                                        <div style="color: var(--text-muted);">
                                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1"
                                                style="margin: 0 auto 16px; opacity: 0.4;">
                                                <circle cx="11" cy="11" r="8" />
                                                <path d="m21 21-4.3-4.3" />
                                            </svg>
                                            <p
                                                style="font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                                                Nenhum cliente encontrado
                                            </p>
                                            <p style="font-size: var(--small-size); color: var(--text-muted);">
                                                @if ($this->search || $this->categoriaFilter || $this->statusFilter || $this->zonaFilter || $this->leituraStatusFilter)
                                                    Tente ajustar os filtros de busca
                                                    <br>
                                                    <button
                                                        wire:click="$set('search', ''); $set('categoriaFilter', ''); $set('statusFilter', ''); $set('zonaFilter', ''); $set('leituraStatusFilter', '')"
                                                        class="btn btn-primary" style="margin-top: 16px;">
                                                        Limpar filtros
                                                    </button>
                                                @else
                                                    Comece cadastrando um novo cliente
                                        </div>
                            @endif
                            </p>
                </div>
                </td>
                </tr>
                @endforelse
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ============================================ -->
    <!-- MODAL: NOVO CLIENTE (Completo - Água)       -->
    <!-- ============================================ -->
    <livewire:admin.clientes.create />
    <!-- ============================================ -->
    <!-- MODAL: EDITAR CLIENTE                         -->
    <!-- ============================================ -->
    <livewire:admin.clientes.editar-cliente />

    <!-- ============================================ -->
    <!-- MODAL: VER CLIENTE (Visualização Completa)    -->
    <!-- ============================================ -->
    <livewire:admin.clientes.ver-cliente />
    <!-- ============================================ -->
    <!-- MODAL: HISTÓRICO DO CLIENTE                   -->
    <!-- ============================================ -->
    <livewire:admin.clientes.historico-cliente />

    <!-- ============================================ -->
    <!-- MODAL: HISTÓRICO DO CLIENTE                   -->
    <!-- ============================================ -->
    {{-- <livewire:admin.clientes.historico-cliente /> --}}



    <div id="toast-container"
        style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
    </div>
    <script>
        // Close modal on overlay click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                    modal.classList.remove('active');
                });
                document.body.style.overflow = '';
            }
        });

        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }

        // Search table
        function searchTable(inputId, tableId) {
            const input = document.getElementById(inputId);
            const filter = input.value.toLowerCase();
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let found = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? '' : 'none';
            }
        }



        // Tab switching - Novo Cliente
        // Chave única para evitar conflito com outros modais
        const STORAGE_KEY_CLIENTE = 'active_tab_novo_cliente';

        function switchTabNovo(btn, tabId) {
            // 1. Lógica Visual: Remove active de todas as abas do modal de cliente
            document.querySelectorAll('#modal-novo-cliente .tab').forEach(t => t.classList.remove('active'));

            // Ativa o botão clicado ou busca pelo seletor (caso seja chamado via script)
            if (btn) {
                btn.classList.add('active');
            } else {
                document.querySelector(`#modal-novo-cliente .tab[onclick*="${tabId}"]`)?.classList.add('active');
            }

            // 2. Esconde conteúdos e mostra o alvo
            document.querySelectorAll('.tab-content-novo').forEach(c => c.style.display = 'none');
            const targetContent = document.getElementById(tabId);
            if (targetContent) targetContent.style.display = 'block';

            // 3. Salva no LocalStorage
            localStorage.setItem(STORAGE_KEY_CLIENTE, tabId);
        }

        // 4. Recupera a aba ao carregar a página ou após refresh do Livewire
        function restoreClienteTab() {
            const savedTab = localStorage.getItem(STORAGE_KEY_CLIENTE);
            if (savedTab) {
                switchTabNovo(null, savedTab);
            }
        }

        // Executa ao carregar o DOM
        document.addEventListener('DOMContentLoaded', restoreClienteTab);

        // 5. Mantém a aba após uploads ou atualizações do Livewire
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', () => {
                restoreClienteTab();
            });
        });

        // 6. Função para limpar ao salvar com sucesso
        function clearClienteTab() {
            localStorage.removeItem(STORAGE_KEY_CLIENTE);
        }



        // Tab switching - Editar Cliente
        function switchTabEditar(btn, tabId) {
            document.querySelectorAll('#modal-editar-cliente .tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.tab-content-editar').forEach(c => c.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }

        // Tab switching - Histórico
        function switchTabHist(btn, tabId) {
            document.querySelectorAll('#modal-historico-cliente .tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.tab-content-hist').forEach(c => c.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }

        // Actions
        function salvarRascunho() {
            alert('Rascunho salvo com sucesso!');
        }

        function cadastrarCliente() {
            alert('Cliente cadastrado com sucesso!\n\nMatrícula: MAT-2026-009999\nHidrômetro: H-9999-XX');
            closeModal('modal-novo-cliente');
        }

        function salvarEdicao() {
            alert('Alterações salvas com sucesso!');
            closeModal('modal-editar-cliente');
        }
    </script>
@endsection
