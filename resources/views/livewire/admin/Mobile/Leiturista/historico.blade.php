<div>
    <section class="mobile-section" id="section-historico" wire:ignore.self>

        {{-- FILTROS (ABAS) --}}
        <div class="historico-filtros">

            <select wire:change='setFiltro($event.target.value)' class="form-select" id="suporteAssunto">
                @for ($i = 0; $i < 12; $i++)
                    @php
                        $mes = now()->subMonths($i);
                    @endphp
                    <option value="{{ $mes->format('m') }}">
                        {{ $mes->translatedFormat('F Y') }}
                    </option>
                @endfor
            </select>

            {{-- <button class="historico-filtro-chip {{ $filtro === 'hoje' ? 'active' : '' }}" wire:click="setFiltro('hoje')">
                Hoje
            </button>

            <button class="historico-filtro-chip {{ $filtro === 'ontem' ? 'active' : '' }}"
                wire:click="setFiltro('ontem')">
                Ontem
            </button>

            <button class="historico-filtro-chip {{ $filtro === 'semana' ? 'active' : '' }}"
                wire:click="setFiltro('semana')">
                Esta Semana
            </button>

            <button class="historico-filtro-chip {{ $filtro === 'mes' ? 'active' : '' }}" wire:click="setFiltro('mes')">
                Este Mês
            </button> --}}

        </div>

        {{-- LISTA --}}
        @foreach ($leituras as $leitura)
            @php
                $cliente = $leitura->cliente;
                $consumo = ($leitura->leitura_atual ?? 0) - ($leitura->leitura_anterior ?? 0);

                $anomalia = $consumo > 1000; // regra exemplo
            @endphp

            <div class="historico-card">

                <div class="historico-card-header">
                    <span class="historico-mes">
                        {{ \Carbon\Carbon::parse($leitura->created_at)->format('F/Y') }}
                    </span>

                    <span class="historico-status {{ $anomalia ? 'anomalia' : 'ok' }}">
                        {{ $anomalia ? '⚠ Anomalia' : '✓ Concuido' }}
                    </span>
                </div>

                <div class="historico-endereco">
                    {{ $cliente->endereco ?? 'Sem endereço' }} - {{ $cliente->nome_completo }}
                </div>

                <div class="historico-dados">

                    <div class="historico-dado">
                        <div class="historico-dado-valor">{{ $leitura->leitura_atual }}</div>
                        <div class="historico-dado-label">Atual</div>
                    </div>

                    <div class="historico-dado">
                        <div class="historico-dado-valor">{{ $leitura->leitura_anterior }}</div>
                        <div class="historico-dado-label">Anterior</div>
                    </div>

                    <div class="historico-dado">
                        <div class="historico-dado-valor">{{ $consumo }}</div>
                        <div class="historico-dado-label">Consumo</div>
                    </div>

                </div>

                <div class="historico-footer">
                    <span class="historico-data">
                        {{ \Carbon\Carbon::parse($leitura->created_at)->format('d/m/Y H:i') }}
                    </span>

                    <span class="historico-consumo">
                        {{ $leitura->cliente->medidor->numero_hidrometro }}
                    </span>
                </div>

            </div>
        @endforeach

        {{-- PAGINAÇÃO (IGUAL AO SEU HTML) --}}
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-xl);">

            <span style="font-size: var(--small-size); color: var(--text-muted);">
                Página {{ $leituras->currentPage() }} de {{ $leituras->lastPage() }}
            </span>

            <div style="display: flex; gap: var(--space-xs);">

                {{-- ANTERIOR --}}
                <button class="btn btn-sm btn-ghost" wire:click="previousPage"
                    @if ($leituras->onFirstPage()) disabled @endif>
                    ◀
                </button>

                {{-- PÁGINAS --}}
                @for ($i = 1; $i <= $leituras->lastPage(); $i++)
                    <button wire:click="gotoPage({{ $i }})"
                        class="btn btn-sm {{ $leituras->currentPage() == $i ? 'btn-primary' : 'btn-ghost' }}"
                        style="min-width: 32px; justify-content: center;">
                        {{ $i }}
                    </button>
                @endfor

                {{-- PRÓXIMO --}}
                <button class="btn btn-sm btn-ghost" wire:click="nextPage"
                    @if (!$leituras->hasMorePages()) disabled @endif>
                    ▶
                </button>

            </div>

        </div>

    </section>
</div>
