<style>
    .pagination-wrapper {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem !important;
    }

    .pagination-wrapper .pagination-controls {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $onFirstPage = $paginator->onFirstPage();
    $hasMorePages = $paginator->hasMorePages();
    $firstItem = $paginator->firstItem() ?? 0;
    $lastItem = $paginator->lastItem() ?? 0;
    $total = $paginator->total();
@endphp

@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <!-- Info de registros -->
        <span class="pagination-info">
            Mostrando <strong>{{ $firstItem }}-{{ $lastItem }}</strong> de <strong>{{ $total }}</strong>
            registros
        </span>

        <!-- Controles de paginação -->
        <div class="pagination-controls">
            <!-- Botão Anterior -->
            @if (!$onFirstPage)
                <button class="btn btn-sm btn-ghost pagination-btn" wire:click="previousPage" wire:loading.attr="disabled"
                    title="Página anterior">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </button>
            @else
                <button class="btn btn-sm btn-ghost pagination-btn" disabled title="Primeira página">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </button>
            @endif

            <!-- Números das páginas -->
            @foreach ($paginator->getUrlRange(1, $lastPage) as $page => $url)
                @if ($page == $currentPage)
                    <!-- Página Ativa -->
                    <button class="btn btn-sm btn-primary pagination-page-btn active"
                        wire:click="gotoPage({{ $page }})" title="Página {{ $page }}">
                        {{ $page }}
                    </button>
                @elseif ($page == 1 || $page == $lastPage || ($page >= $currentPage - 1 && $page <= $currentPage + 1))
                    <!-- Páginas visíveis (primeira, última, e adjacentes) -->
                    <button class="btn btn-sm btn-ghost pagination-page-btn" wire:click="gotoPage({{ $page }})"
                        title="Ir para página {{ $page }}">
                        {{ $page }}
                    </button>
                @elseif ($page == $currentPage - 2 || $page == $currentPage + 2)
                    <!-- Reticências -->
                    <span class="pagination-ellipsis">...</span>
                @endif
            @endforeach

            <!-- Botão Próximo -->
            @if ($hasMorePages)
                <button class="btn btn-sm btn-ghost pagination-btn" wire:click="nextPage" wire:loading.attr="disabled"
                    title="Próxima página">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            @else
                <button class="btn btn-sm btn-ghost pagination-btn" disabled title="Última página">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            @endif
        </div>

        <!-- Info de página atual -->
        <span class="pagination-page-info">
            Página {{ $currentPage }} de {{ $lastPage }}
        </span>
    </div>
@endif
