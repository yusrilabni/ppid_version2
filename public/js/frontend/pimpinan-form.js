/**
 * JavaScript untuk form create dan edit officials
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all form functionality
    initializeTabs();
    initializeSpouseField();
    initializeDynamicSections();
});

/**
 * Tab functionality
 */
function initializeTabs() {
    // Tab button functionality
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                btn.classList.add('text-gray-500', 'border-transparent');
            });

            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Add active class to clicked button
            this.classList.remove('text-gray-500', 'border-transparent');
            this.classList.add('active', 'text-blue-600', 'border-blue-600');

            // Show corresponding tab content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.remove('hidden');

            // When switching to family tab, check visibility and update field
            if (tabId === 'keluarga') {
                updateSpouseLabel();
                toggleSpouseVisibility();
            }
        });
    });
}

/**
 * Spouse field management
 */
function initializeSpouseField() {
    const maritalStatusSelect = document.getElementById('marital_status');
    const jenisKelaminSelect = document.getElementById('jenis_kelamin');
    const spouseNameFieldKeluarga = document.getElementById('spouse_name_field_family');
    const spouseNameLabelKeluarga = document.getElementById('spouse_name_label_family');

    if (!maritalStatusSelect || !jenisKelaminSelect || !spouseNameFieldKeluarga) return;

    function toggleSpouseVisibility() {
        const familyTab = document.getElementById('keluarga');
        const isFamilyTabActive = familyTab && !familyTab.classList.contains('hidden');

        // Handle visibility for keluarga tab - show when in keluarga tab and conditions are met
        if (spouseNameFieldKeluarga) {
            if (maritalStatusSelect.value === 'Menikah' && jenisKelaminSelect.value !== '' && isFamilyTabActive) {
                spouseNameFieldKeluarga.classList.remove('hidden');
            } else {
                spouseNameFieldKeluarga.classList.add('hidden');
            }
        }
    }

    function updateSpouseLabel() {
        // Update label for keluarga tab
        if (jenisKelaminSelect && spouseNameLabelKeluarga) {
            const jenisKelamin = jenisKelaminSelect.value;
            let labelText = '';

            if (jenisKelamin === 'Laki-laki') {
                labelText = 'Nama Istri';
            } else if (jenisKelamin === 'Perempuan') {
                labelText = 'Nama Suami';
            } else {
                labelText = 'Nama Suami/Istri';
            }

            spouseNameLabelKeluarga.textContent = labelText;
        }
    }

    function handleMaritalAndGenderChange() {
        updateSpouseLabel();
        toggleSpouseVisibility();
    }

    // Tab switch event
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(() => {
                toggleSpouseVisibility();
            }, 100); // Delay to ensure tab has switched
        });
    });

    // Event listeners
    if (maritalStatusSelect) {
        maritalStatusSelect.addEventListener('change', handleMaritalAndGenderChange);
    }
    if (jenisKelaminSelect) {
        jenisKelaminSelect.addEventListener('change', handleMaritalAndGenderChange);
    }

    // Initialize on page load
    updateSpouseLabel();
    toggleSpouseVisibility();
}

/**
 * Initialize all dynamic sections
 */
function initializeDynamicSections() {
    initializeChildren();
    initializeCareerHistory();
    initializeEducation();
    initializeTraining();
    initializeOrganizationalHistory();
    initializeAwards();
}

/**
 * Children (family) section management
 */
function initializeChildren() {
    const childrenContainer = document.getElementById('children_fields');
    const addChildButton = document.getElementById('add_child');
    const childTemplate = document.getElementById('child_template');

    if (!childrenContainer || !addChildButton || !childTemplate) return;

    // Add child functionality
    addChildButton.addEventListener('click', function(e) {
        e.preventDefault();
        const existingChildren = childrenContainer.querySelectorAll('.child-item');
        const childIndex = existingChildren.length > 0 ? existingChildren.length : 1;
        const newChild = childTemplate.firstElementChild.cloneNode(true);
        newChild.querySelectorAll('input').forEach(input => {
            const name = input.getAttribute('name');
            if(name) {
                input.name = name.replace('[]', `[${childIndex}]`);
            }
            input.value = '';
        });
        
        const firstItem = childrenContainer.querySelector('.child-item');
        if(firstItem && firstItem.querySelector('input').value === ''){
             childrenContainer.innerHTML = ''; // Clear the empty placeholder
        }

        childrenContainer.appendChild(newChild);
        updateChildrenIndices();
    });

    // Event delegation for remove buttons
    childrenContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-child')) {
            e.preventDefault();
            const childItem = e.target.closest('.child-item');
            if (childItem) {
                const childItems = childrenContainer.querySelectorAll('.child-item');
                if (childItems.length > 1) {
                    childItem.remove();
                    updateChildrenIndices();
                } else {
                    childItem.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            }
        }
    });

    function updateChildrenIndices() {
        const childItems = childrenContainer.querySelectorAll('.child-item');
        childItems.forEach((item, index) => {
            const nameInput = item.querySelector('input[name*="[name]"]');
            if (nameInput) {
                nameInput.name = `children[${index}][name]`;
            }
        });
    }
    updateChildrenIndices();
}


/**
 * Career History section management
 */
function initializeCareerHistory() {
    const careerContainer = document.getElementById('career_fields');
    const addCareerButton = document.getElementById('add_career');
    const careerTemplate = document.getElementById('career_template');

    if (!careerContainer || !addCareerButton || !careerTemplate) return;

    addCareerButton.addEventListener('click', function(e) {
        e.preventDefault();
        const newCareer = careerTemplate.firstElementChild.cloneNode(true);
        newCareer.querySelectorAll('input').forEach(input => input.value = '');
        careerContainer.appendChild(newCareer);
        updateCareerIndices();
    });

    careerContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-career')) {
            e.preventDefault();
            const careerItem = e.target.closest('.career-item');
            if (careerContainer.querySelectorAll('.career-item').length > 1) {
                careerItem.remove();
            } else {
                careerItem.querySelectorAll('input').forEach(input => input.value = '');
            }
            updateCareerIndices();
        }
    });

    function updateCareerIndices() {
        careerContainer.querySelectorAll('.career-item').forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) input.setAttribute('name', name.replace(/\[\d*\]/, `[${index}]`));
            });
        });
    }
    updateCareerIndices();
}

function initializeEducation() {
    const container = document.getElementById('education_fields');
    const addButton = document.getElementById('add_education');
    const template = document.getElementById('education_template');

    if (!container || !addButton || !template) return;

    addButton.addEventListener('click', function(e) {
        e.preventDefault();
        const newItem = template.firstElementChild.cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(newItem);
        updateIndices();
    });
    
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-education')) {
            e.preventDefault();
            if (container.querySelectorAll('.education-item').length > 1) {
                e.target.closest('.education-item').remove();
            } else {
                e.target.closest('.education-item').querySelectorAll('input').forEach(input => input.value = '');
            }
            updateIndices();
        }
    });

    function updateIndices() {
        container.querySelectorAll('.education-item').forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if(name) input.setAttribute('name', name.replace(/\[\d*\]/, `[${index}]`));
            });
        });
    }
    updateIndices();
}

function initializeTraining() {
    const container = document.getElementById('training_fields');
    const addButton = document.getElementById('add_training');
    const template = document.getElementById('training_template');

    if (!container || !addButton || !template) return;

    addButton.addEventListener('click', function(e) {
        e.preventDefault();
        const newItem = template.firstElementChild.cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(newItem);
        updateIndices();
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-training')) {
            e.preventDefault();
            if (container.querySelectorAll('.training-item').length > 1) {
                e.target.closest('.training-item').remove();
            } else {
                e.target.closest('.training-item').querySelectorAll('input').forEach(input => input.value = '');
            }
            updateIndices();
        }
    });

    function updateIndices() {
        container.querySelectorAll('.training-item').forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if(name) input.setAttribute('name', name.replace(/\[\d*\]/, `[${index}]`));
            });
        });
    }
    updateIndices();
}

function initializeOrganizationalHistory() {
    const container = document.getElementById('organizational_fields');
    const addButton = document.getElementById('add_organizational');
    const template = document.getElementById('organizational_template');

    if (!container || !addButton || !template) return;

    addButton.addEventListener('click', function(e) {
        e.preventDefault();
        const newItem = template.firstElementChild.cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(newItem);
        updateIndices();
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-organizational')) {
            e.preventDefault();
            if (container.querySelectorAll('.organizational-item').length > 1) {
                e.target.closest('.organizational-item').remove();
            } else {
                e.target.closest('.organizational-item').querySelectorAll('input').forEach(input => input.value = '');
            }
            updateIndices();
        }
    });
    
    function updateIndices() {
        container.querySelectorAll('.organizational-item').forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if(name) input.setAttribute('name', name.replace(/\[\d*\]/, `[${index}]`));
            });
        });
    }
    updateIndices();
}

function initializeAwards() {
    const container = document.getElementById('award_fields');
    const addButton = document.getElementById('add_award');
    const template = document.getElementById('award_template');

    if (!container || !addButton || !template) return;

    addButton.addEventListener('click', function(e) {
        e.preventDefault();
        const newItem = template.firstElementChild.cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(newItem);
        updateIndices();
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-award')) {
            e.preventDefault();
            if (container.querySelectorAll('.award-item').length > 1) {
                e.target.closest('.award-item').remove();
            } else {
                e.target.closest('.award-item').querySelectorAll('input').forEach(input => input.value = '');
            }
            updateIndices();
        }
    });

    function updateIndices() {
        container.querySelectorAll('.award-item').forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if(name) input.setAttribute('name', name.replace(/\[\d*\]/, `[${index}]`));
            });
        });
    }
    updateIndices();
}

function validatePhoto(input) {
    const file = input.files[0];
    const photoNameDisplay = document.getElementById('photoNameDisplay');
    const photoSizeDisplay = document.getElementById('photoSizeDisplay');
    const photoIcon = document.getElementById('photoIcon');
    const photoErrorMessage = document.getElementById('photoErrorMessage');

    photoErrorMessage.textContent = '';
    photoErrorMessage.classList.add('hidden');
    photoIcon.classList.remove('fa-check-circle', 'fa-times-circle', 'text-green-500', 'text-red-500');
    photoIcon.classList.add('fa-cloud-upload-alt', 'text-gray-400');

    if (file) {
        const fileSize = file.size;
        const fileName = file.name;
        const maxFileSize = 2 * 1024 * 1024; // 2MB

        if (fileSize > maxFileSize) {
            photoErrorMessage.textContent = 'Ukuran file melebihi batas maksimal 2MB.';
            photoErrorMessage.classList.remove('hidden');
            input.value = '';
            photoNameDisplay.textContent = '';
            photoNameDisplay.classList.add('hidden');
            photoSizeDisplay.textContent = '';
            photoSizeDisplay.classList.add('hidden');
            photoIcon.classList.remove('fa-cloud-upload-alt', 'text-gray-400');
            photoIcon.classList.add('fa-times-circle', 'text-red-500');
            return;
        }
        
        photoNameDisplay.textContent = `File: ${fileName}`;
        photoSizeDisplay.textContent = `Ukuran: ${(fileSize / 1024).toFixed(2)} KB`;
        photoNameDisplay.classList.remove('hidden');
        photoSizeDisplay.classList.remove('hidden');
        photoNameDisplay.classList.add('text-green-600');
        photoSizeDisplay.classList.add('text-green-600');
        photoIcon.classList.remove('fa-cloud-upload-alt', 'text-gray-400');
        photoIcon.classList.add('fa-check-circle', 'text-green-500');
    } else {
        photoNameDisplay.textContent = '';
        photoNameDisplay.classList.add('hidden');
        photoSizeDisplay.textContent = '';
        photoSizeDisplay.classList.add('hidden');
        photoNameDisplay.classList.remove('text-green-600');
        photoSizeDisplay.classList.remove('text-green-600');
    }
}
