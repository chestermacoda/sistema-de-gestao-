



// Modal functions
document.addEventListener('livewire:init', () => {
    console.log('Livewire pronto');
    Livewire.on('showToast', (event) => {
        const data = event[0] ?? event;
        showToast(data.message, data.type);
    });

    Livewire.on('closeModal', (event) => {
        const id = event[0] ?? event;
        closeModal(id);
    });

    Livewire.on('openModal', (event) => {
        const id = event[0] ?? event;
        openModal(id);
    });




    Livewire.on('confirm-action', (data) => {

        const message = data.message ?? 'Tens a certeza?';

        if (!confirm(message)) {
            return;
        }

        // chama o backend Livewire action
        Livewire.dispatch(data.action, data.payload);
    });
});


function toggleProfileDropdown(event) {
    event.stopPropagation();
    const dropdown = event.currentTarget.closest('.header-profile-dropdown');
    if (dropdown) {
        dropdown.classList.toggle('active');
    }
}

// Fechar ao clicar fora (Corrigido para lidar com o ::before)
document.addEventListener('click', function (e) {
    const dropdown = document.querySelector('.header-profile-dropdown');

    if (dropdown && dropdown.classList.contains('active')) {
        // Se clicou no botão em si, o toggle já resolve.
        // Se clicou estritamente fora do menu (ou na camada pseudo-elemento), fechamos:
        const menu = dropdown.querySelector('.header-profile-menu');
        const btn = dropdown.querySelector('.header-profile-btn');

        if (!menu.contains(e.target) && !btn.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    }
});

// Fechar o dropdown ao clicar em qualquer lugar fora dele
document.addEventListener('click', function (e) {
    const dropdown = document.querySelector('.header-profile-dropdown');

    // Se o dropdown existe, está aberto (.active) e o clique foi FORA dele
    if (dropdown && dropdown.classList.contains('active') && !dropdown.contains(e.target)) {
        dropdown.classList.remove('active');
    }
});

// Função de Logout corrigida para interceptar o formulário do Laravel
function logout(event) {
    if (!confirm('Tem certeza que deseja sair do sistema?')) {
        if (event) event.preventDefault(); // Trava o envio se clicar em Cancelar
        return false;
    }
}

function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal on overlay click
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// Close modal on escape key
document.addEventListener('keydown', function (e) {
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

// Tab switching
function switchTab(tabGroup, tabId) {
    const group = document.querySelector('[data-tab-group="' + tabGroup + '"]');
    if (group) {
        group.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        group.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        event.target.classList.add('active');
    }
}

// Notification toast


function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');

    const colors = {
        success: 'var(--success)',
        danger: 'var(--danger)',
        warning: 'var(--warning)',
        info: 'var(--primary)'
    };

    const bgColors = {
        success: 'var(--success-light)',
        danger: 'var(--danger-light)',
        warning: 'var(--warning-light)',
        info: 'rgba(0, 51, 102, 0.08)'
    };

    toast.style.cssText = `
                background: ${bgColors[type] || bgColors.info};
                color: ${colors[type] || colors.info};
                padding: var(--space-md) var(--space-lg);
                border-radius: var(--radius-md);
                font-size: var(--label-size);
                font-weight: 600;
                box-shadow: var(--shadow-lg);
                display: flex;
                align-items: center;
                gap: var(--space-sm);
                animation: slideIn 0.3s ease;
                border-left: 3px solid ${colors[type] || colors.info};
            `;

    const icons = {
        success: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>',
        danger: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>',
        warning: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>',
        info: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/></svg>'
    };

    toast.innerHTML = `${icons[type] || icons.info}<span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 3000);
    }, 4000);
}


// Confirm delete
function confirmDelete(message, callback) {
    if (confirm(message || 'Tem certeza que deseja excluir este item?')) {
        callback();
    }
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    let valid = true;
    form.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#DC2626';
            valid = false;
        } else {
            field.style.borderColor = '';
        }
    });
    return valid;
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
