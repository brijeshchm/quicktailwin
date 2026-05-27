import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import { createIcons, icons } from 'lucide';

// Initial render
document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

// Make available globally for Livewire/AJAX re-renders
window.lucide = { createIcons: () => createIcons({ icons }) };