<div class="preview-comprovante-container" style="height: 100%; display: flex; flex-direction: column;">
    @if ($carregando)
        <div style="flex:1; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:16px;">
            <div
                style="width:40px; height:40px; border:3px solid #e5e7eb; border-top-color:#2563eb; border-radius:50%; animation:spin 1s linear infinite;">
            </div>
            <p style="color:#6b7280; font-size:14px;">Gerando comprovante...</p>
        </div>
        <style>
            @keyframes spin {
                to {
                    transform: rotate(360deg)
                }
            }
        </style>
    @else
        <!-- Toolbar -->
        <div
            style="padding:12px 16px; border-bottom:1px solid #e5e7eb; background:#f9fafb; display:flex; justify-content:space-between; align-items:center;">
            <div style="font-size:13px; font-weight:600; color:#374151; display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                    <polyline points="14 2 14 8 20 8" />
                </svg>
                @if ($pagamentoConfirmado)
                    <span style="color:#059669;">✓ Comprovante Gerado</span>
                @else
                    <span style="color:#d97706;">⚠ Pré-visualização</span>
                @endif
            </div>

            <div style="display:flex; gap:8px;">
                @if ($pagamentoConfirmado && $pdfUrl)
                    <a href="{{ $pdfUrl }}" target="_blank"
                        style="padding:6px 12px; background:#2563eb; color:white; border-radius:6px; text-decoration:none; font-size:12px; font-weight:500; display:flex; align-items:center; gap:4px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                        Baixar PDF
                    </a>
                @endif

                <button type="button" wire:click="gerarPreview"
                    style="padding:6px 12px; background:white; border:1px solid #d1d5db; color:#374151; border-radius:6px; font-size:12px; font-weight:500; cursor:pointer; display:flex; align-items:center; gap:4px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M23 4v6h-6" />
                        <path d="M1 20v-6h6" />
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15" />
                    </svg>
                    Atualizar
                </button>
            </div>
        </div>

        <!-- Preview HTML -->
        <div style="flex:1; overflow:hidden; background:#525659;">
            <iframe srcdoc="{{ $htmlPreview }}" style="width:100%; height:100%; border:none;"
                title="Pré-visualização do Comprovante" sandbox="allow-same-origin">
            </iframe>
        </div>

        <!-- Info bar -->
        <div
            style="padding:10px 16px; border-top:1px solid #e5e7eb; background:#f9fafb; font-size:12px; color:#6b7280; display:flex; justify-content:space-between; align-items:center;">
            <div>
                @if ($faturaId)
                    Fatura #{{ $faturaId }}
                    @if ($valorPago)
                        <span style="margin-left:8px; color:#2563eb; font-weight:600;">
                            MZN {{ number_format($valorPago, 2, ',', '.') }}
                        </span>
                    @endif
                @else
                    Nenhuma fatura selecionada
                @endif
            </div>
            <div>
                @if ($metodoPagamento)
                    {{ $metodoPagamento }}
                @endif
                @if ($dataPagamento)
                    <span style="margin-left:8px;">• {{ \Carbon\Carbon::parse($dataPagamento)->format('d/m/Y') }}</span>
                @endif
            </div>
        </div>
    @endif
</div>
