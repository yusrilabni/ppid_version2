/**
 * Dynamic Form Manager untuk semua form dinamis
 */

export default class DynamicFormManager {
    constructor() {
        // Default configuration
        this.sections = {};
    }

    /**
     * Initialize all dynamic sections
     */
    initializeSections() {
        // Default sections configuration
        const sectionsConfig = [
            {
                name: 'child',
                containerId: 'children_fields',
                addButtonId: 'add_child',
                templateId: 'child_template',
                fieldPrefix: 'children'
            },
            {
                name: 'career',
                containerId: 'career_fields',
                addButtonId: 'add_career',
                templateId: 'career_template',
                fieldPrefix: 'career_histories'
            },
            {
                name: 'education',
                containerId: 'education_fields',
                addButtonId: 'add_education',
                templateId: 'education_template',
                fieldPrefix: 'educations'
            },
            {
                name: 'training',
                containerId: 'training_fields',
                addButtonId: 'add_training',
                templateId: 'training_template',
                fieldPrefix: 'training_histories'
            },
            {
                name: 'organizational',
                containerId: 'organizational_fields',
                addButtonId: 'add_organizational',
                templateId: 'organizational_template',
                fieldPrefix: 'organizational_histories'
            },
            {
                name: 'award',
                containerId: 'award_fields',
                addButtonId: 'add_award',
                templateId: 'award_template',
                fieldPrefix: 'awards'
            }
        ];

        // Initialize each section
        sectionsConfig.forEach(config => {
            this.initializeSection(config);
        });
    }

    /**
     * Create default item template for sections without specific template
     */
    createDefaultItem(sectionName, fieldPrefix) {
        const div = document.createElement('div');
        div.className = `${sectionName}-item mb-4 p-4 border rounded-lg`;

        // Different templates based on section
        const templates = {
            child: `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anak</label>
                        <input type="text" name="${fieldPrefix}[][name]" placeholder="Nama anak"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            education: `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang Pendidikan</label>
                        <input type="text" name="${fieldPrefix}[][degree]" placeholder="SMA, S1, S2, dll"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Institusi</label>
                        <input type="text" name="${fieldPrefix}[][institution]" placeholder="Nama institusi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                        <input type="number" name="${fieldPrefix}[][start_year]" placeholder="2020"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                        <input type="number" name="${fieldPrefix}[][end_year]" placeholder="2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            career: `
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="${fieldPrefix}[][title]" placeholder="Nama jabatan"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instansi/OPD</label>
                        <input type="text" name="${fieldPrefix}[][organization_name]" placeholder="Nama instansi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                        <input type="number" name="${fieldPrefix}[][start_year]" placeholder="2020"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                        <input type="number" name="${fieldPrefix}[][end_year]" placeholder="2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="${fieldPrefix}[][description]" placeholder="Tambahkan keterangan (opsional)"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            training: `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Diklat</label>
                        <input type="text" name="${fieldPrefix}[][name]" placeholder="Nama diklat"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="${fieldPrefix}[][year]" placeholder="2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                        <input type="text" name="${fieldPrefix}[][organizer]" placeholder="Nama penyelenggara"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            organizational: `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi</label>
                        <input type="text" name="${fieldPrefix}[][organization_name]" placeholder="Nama organisasi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="${fieldPrefix}[][position]" placeholder="Jabatan di organisasi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="${fieldPrefix}[][start_year]" placeholder="2020-2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            award: `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penghargaan</label>
                        <input type="text" name="${fieldPrefix}[][title]" placeholder="Nama penghargaan"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemberi</label>
                        <input type="text" name="${fieldPrefix}[][issuer]" placeholder="Nama pemberi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="${fieldPrefix}[][year]" placeholder="2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="${fieldPrefix}[][description]" placeholder="Deskripsi (opsional)"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `
        };

        div.innerHTML = templates[sectionName] || '';

        return div;
    }
    }

    /**
     * Initialize a single dynamic section
     */
    initializeSection(config) {
        const { name, containerId, addButtonId, templateId, fieldPrefix } = config;
        
        const container = document.getElementById(containerId);
        const addButton = document.getElementById(addButtonId);
        const template = document.getElementById(templateId);

        if (!container || !addButton) return;

        // Store section reference
        this.sections[name] = {
            container,
            addButton,
            template,
            fieldPrefix
        };

        // Event listener for delete buttons
        container.addEventListener('click', (e) => {
            if (e.target.classList.contains(`remove-${name}`)) {
                e.preventDefault();
                this.removeItem(name, e.target);
            }
        });

        // Event listener for add button
        addButton.addEventListener('click', (e) => {
            e.preventDefault();
            this.addItem(name);
        });

        // Update indices initially
        this.updateIndices(name);
    }

    /**
     * Add new item to a section
     */
    addItem(sectionName) {
        const section = this.sections[sectionName];
        if (!section) return;

        const container = section.container;
        const template = section.template;
        const fieldPrefix = section.fieldPrefix;

        let newItem;
        
        if (template && template.firstElementChild) {
            newItem = template.firstElementChild.cloneNode(true);
            // Remove template attributes
            newItem.removeAttribute('data-template');
            newItem.classList.remove('hidden');
        } else {
            // Create from existing first item
            const firstItem = container.querySelector(`.${sectionName}-item`);
            if (firstItem) {
                newItem = firstItem.cloneNode(true);
                // Clear values
                newItem.querySelectorAll('input, textarea, select').forEach(field => {
                    field.value = '';
                });
            } else {
                newItem = this.createDefaultItem(sectionName, fieldPrefix);
            }
        }

        // Add to container
        container.appendChild(newItem);
        
        // Update indices
        this.updateIndices(sectionName);
    }

    /**
     * Remove item from a section
     */
    removeItem(sectionName, target) {
        const section = this.sections[sectionName];
        if (!section) return;

        const container = section.container;
        
        const itemToRemove = target.closest(`.${sectionName}-item`);

        if (itemToRemove) {
            const items = container.querySelectorAll(`.${sectionName}-item`);
            if (items.length > 1) {
                itemToRemove.remove();
                this.updateIndices(sectionName);
            } else {
                // Clear inputs if it's the last item
                itemToRemove.querySelectorAll('input, textarea, select').forEach(field => {
                    field.value = '';
                });
            }
        }
    }

    /**
     * Update indices for a section
     */
    updateIndices(sectionName) {
        const section = this.sections[sectionName];
        if (!section) return;

        const container = section.container;
        const fieldPrefix = section.fieldPrefix;
        const items = container.querySelectorAll(`.${sectionName}-item`);

        items.forEach((item, index) => {
            // Update all form fields
            item.querySelectorAll('input, textarea, select').forEach(field => {
                const nameAttr = field.getAttribute('name');
                if (nameAttr && nameAttr.includes('[') && nameAttr.includes(']')) {
                    const matches = nameAttr.match(/\[([^\]]+)\]/g);
                    if (matches && matches.length > 1) {
                        const fieldName = matches[matches.length - 1].replace(/[\[\]]/g, '');
                        field.name = `${fieldPrefix}[${index}][${fieldName}]`;
                    } else if (matches && matches.length === 1) {
                        const fieldName = matches[0].replace(/[\[\]]/g, '');
                        field.name = `${fieldPrefix}[${index}][${fieldName}]`;
                    }
                }
            });
        });
    }

    /**
     * Create default item template
     */
    createDefaultItem(sectionName, fieldPrefix) {
        const div = document.createElement('div');
        div.className = `${sectionName}-item mb-4 p-4 border rounded-lg`;
        
        // Different templates based on section
        const templates = {
            child: `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anak</label>
                        <input type="text" name="${fieldPrefix}[][name]" placeholder="Nama anak"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            education: `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang Pendidikan</label>
                        <input type="text" name="${fieldPrefix}[][degree]" placeholder="SMA, S1, S2, dll"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Institusi</label>
                        <input type="text" name="${fieldPrefix}[][institution]" placeholder="Nama institusi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                        <input type="number" name="${fieldPrefix}[][start_year]" placeholder="2020"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                        <input type="number" name="${fieldPrefix}[][end_year]" placeholder="2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            career: `
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="${fieldPrefix}[][title]" placeholder="Nama jabatan"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instansi/OPD</label>
                        <input type="text" name="${fieldPrefix}[][organization_name]" placeholder="Nama instansi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                        <input type="number" name="${fieldPrefix}[][start_year]" placeholder="2020"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                        <input type="number" name="${fieldPrefix}[][end_year]" placeholder="2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="${fieldPrefix}[][description]" placeholder="Tambahkan keterangan (opsional)"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            training: `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Diklat</label>
                        <input type="text" name="${fieldPrefix}[][name]" placeholder="Nama diklat"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="${fieldPrefix}[][year]" placeholder="2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                        <input type="text" name="${fieldPrefix}[][organizer]" placeholder="Nama penyelenggara"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            organizational: `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi</label>
                        <input type="text" name="${fieldPrefix}[][organization_name]" placeholder="Nama organisasi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="${fieldPrefix}[][position]" placeholder="Jabatan di organisasi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="${fieldPrefix}[][start_year]" placeholder="2020-2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `,
            award: `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penghargaan</label>
                        <input type="text" name="${fieldPrefix}[][title]" placeholder="Nama penghargaan"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemberi</label>
                        <input type="text" name="${fieldPrefix}[][issuer]" placeholder="Nama pemberi"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="${fieldPrefix}[][year]" placeholder="2024"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="${fieldPrefix}[][description]" placeholder="Deskripsi (opsional)"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <button type="button" class="remove-${sectionName} mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `
        };

        div.innerHTML = templates[sectionName] || '';
        
        return div;
    }
}

/**
 * Tab functionality
 */
export function initializeTabs() {
    // Wait for DOM to be ready and elements to exist
    function setupTabFunctionality() {
        const tabButtons = document.querySelectorAll('button.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        if (tabButtons.length === 0) {
            console.error('No tab buttons found!');
            return;
        }

        console.log(`Found ${tabButtons.length} tab buttons and ${tabContents.length} tab contents`);

        tabButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Add active class to clicked button
                this.classList.remove('text-gray-500', 'border-transparent');
                this.classList.add('active', 'text-blue-600', 'border-blue-600');

                // Show corresponding tab content
                const tabId = this.getAttribute('data-tab');
                if (tabId) {
                    const targetContent = document.getElementById(tabId);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');

                        // When switching to family tab, ensure spouse visibility is updated
                        if (tabId === 'keluarga') {
                            if (typeof window.updateSpouseLabel === 'function') {
                                window.updateSpouseLabel();
                            }
                            if (typeof window.toggleSpouseVisibility === 'function') {
                                window.toggleSpouseVisibility();
                            }
                        }
                    } else {
                        console.error(`Tab content with id '${tabId}' not found`);
                    }
                } else {
                    console.error('Tab button missing data-tab attribute:', this);
                }
            });
        });

        // Initially show the first tab content if no active tab is found
        const activeTabButton = document.querySelector('button.tab-button.active');
        if (!activeTabButton && tabButtons.length > 0) {
            // By default, show first tab content
            const firstTabId = tabButtons[0].getAttribute('data-tab');
            if (firstTabId) {
                const firstTabContent = document.getElementById(firstTabId);
                if (firstTabContent) {
                    firstTabContent.classList.remove('hidden');
                }
            }
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupTabFunctionality);
    } else {
        setupTabFunctionality();
    }
}

/**
 * Organization field management
 */
export function initializeOrganizationField() {
    const positionSelect = document.getElementById('position_id');
    const organizationField = document.getElementById('organization_field');

    if (!positionSelect || !organizationField) return;

    function toggleOrganizationField() {
        const selectedOption = positionSelect.options[positionSelect.selectedIndex];
        const positionName = selectedOption.text;

        if (positionName.toLowerCase().includes('kepala')) {
            organizationField.classList.remove('hidden');
        } else {
            organizationField.classList.add('hidden');
        }
    }

    positionSelect.addEventListener('change', toggleOrganizationField);
    toggleOrganizationField(); // Initial check
}
export function initializeOrganizationField() {
    const positionSelect = document.getElementById('position_id');
    const organizationField = document.getElementById('organization_field');

    if (!positionSelect || !organizationField) return;

    function toggleOrganizationField() {
        const selectedOption = positionSelect.options[positionSelect.selectedIndex];
        const positionName = selectedOption.text;

        if (positionName.toLowerCase().includes('kepala')) {
            organizationField.classList.remove('hidden');
        } else {
            organizationField.classList.add('hidden');
        }
    }

    positionSelect.addEventListener('change', toggleOrganizationField);
    toggleOrganizationField(); // Initial check
}

/**
 * Spouse field management
 */
export function initializeSpouseFields() {
    const maritalStatusSelect = document.getElementById('marital_status');
    const jenisKelaminSelect = document.getElementById('jenis_kelamin');
    const spouseNameField = document.getElementById('spouse_name_field');
    const spouseNameLabel = document.getElementById('spouse_name_label');

    if (!maritalStatusSelect || !jenisKelaminSelect || !spouseNameField) return;

    function toggleSpouseVisibility() {
        // Check if family tab is currently active
        const familyTab = document.getElementById('keluarga');
        const isFamilyTabActive = !familyTab.classList.contains('hidden');

        if (maritalStatusSelect.value === 'Menikah' && jenisKelaminSelect.value !== '' && isFamilyTabActive) {
            spouseNameField.classList.remove('hidden');
        } else {
            spouseNameField.classList.add('hidden');
        }
    }

    function updateSpouseLabel() {
        if (jenisKelaminSelect && spouseNameLabel) {
            const jenisKelamin = jenisKelaminSelect.value;
            if (jenisKelamin === 'Laki-laki') {
                spouseNameLabel.textContent = 'Nama Istri';
            } else if (jenisKelamin === 'Perempuan') {
                spouseNameLabel.textContent = 'Nama Suami';
            } else {
                spouseNameLabel.textContent = 'Nama Suami/Istri';
            }
        }
    }

    function handleMaritalAndGenderChange() {
        updateSpouseLabel();
        // Only update visibility if family tab is active
        if (!document.getElementById('keluarga').classList.contains('hidden')) {
            toggleSpouseVisibility();
        }
    }

    // Initialize on page load
    if (maritalStatusSelect && jenisKelaminSelect) {
        updateSpouseLabel();
    }
}