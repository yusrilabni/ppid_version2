/**
 * JavaScript untuk form create dan edit officials
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all form functionality
    initializeTabs();
    initializeOrganizationField();
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
 * Organization field visibility based on position selection
 */
function initializeOrganizationField() {
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
function initializeSpouseField() {
    const maritalStatusSelect = document.getElementById('marital_status');
    const jenisKelaminSelect = document.getElementById('jenis_kelamin');
    const spouseNameField = document.getElementById('spouse_name_field');
    const spouseNameLabel = document.getElementById('spouse_name_label');

    if (!maritalStatusSelect || !jenisKelaminSelect || !spouseNameField) return;

    function toggleSpouseVisibility() {
        const familyTab = document.getElementById('keluarga');
        const isFamilyTabActive = familyTab && !familyTab.classList.contains('hidden');

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

    // Event listeners
    if (maritalStatusSelect) {
        maritalStatusSelect.addEventListener('change', handleMaritalAndGenderChange);
    }
    if (jenisKelaminSelect) {
        jenisKelaminSelect.addEventListener('change', handleMaritalAndGenderChange);
    }

    // Initialize on page load
    updateSpouseLabel();
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

        // Get current child count
        const existingChildren = childrenContainer.querySelectorAll('.child-item');
        const childIndex = existingChildren.length;

        // Clone template
        const newChild = childTemplate.firstElementChild.cloneNode(true);

        // Update name attributes with proper index
        const nameInput = newChild.querySelector('input[name*="[name]"]');
        if (nameInput) {
            nameInput.name = `children[${childIndex}][name]`;
            nameInput.value = ''; // Clear value
        }

        // Add event listener to remove button
        const removeButton = newChild.querySelector('.remove-child');
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                const childItem = e.target.closest('.child-item');
                if (childItem) {
                    const childItems = childrenContainer.querySelectorAll('.child-item');
                    if (childItems.length > 1) {
                        childItem.remove();
                        updateChildrenIndices();
                    } else {
                        // If only one item, clear its fields
                        childItem.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                }
            });
        }

        // Add to container
        childrenContainer.appendChild(newChild);

        // Update indices after adding
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
                    // If it's the last item, clear fields instead of removing
                    childItem.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            }
        }
    });

    // Function to update child indices
    function updateChildrenIndices() {
        const childItems = childrenContainer.querySelectorAll('.child-item');
        childItems.forEach((item, index) => {
            const nameInput = item.querySelector('input[name*="[name]"]');
            if (nameInput) {
                nameInput.name = `children[${index}][name]`;
            }
        });
    }

    // Initialize indices on page load
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

    // Add career functionality
    addCareerButton.addEventListener('click', function(e) {
        e.preventDefault();

        // Get current career count
        const existingCareers = careerContainer.querySelectorAll('.career-item');
        const careerIndex = existingCareers.length;

        // Clone template
        const newCareer = careerTemplate.firstElementChild.cloneNode(true);

        // Update name attributes with proper index
        newCareer.querySelectorAll('input').forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('[]')) {
                const newName = name.replace('[]', `[${careerIndex}]`);
                input.setAttribute('name', newName);
                input.value = ''; // Clear value
            }
        });

        // Add event listener to remove button
        const removeButton = newCareer.querySelector('.remove-career');
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                const careerItem = e.target.closest('.career-item');
                if (careerItem) {
                    const careerItems = careerContainer.querySelectorAll('.career-item');
                    if (careerItems.length > 1) {
                        careerItem.remove();
                        updateCareerIndices();
                    } else {
                        // If only one item, clear its fields
                        careerItem.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                }
            });
        }

        // Add to container
        careerContainer.appendChild(newCareer);

        // Update indices after adding
        updateCareerIndices();
    });

    // Event delegation for remove buttons
    careerContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-career')) {
            e.preventDefault();
            const careerItem = e.target.closest('.career-item');
            if (careerItem) {
                const careerItems = careerContainer.querySelectorAll('.career-item');
                if (careerItems.length > 1) {
                    careerItem.remove();
                    updateCareerIndices();
                } else {
                    // If it's the last item, clear fields instead of removing
                    careerItem.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            }
        }
    });

    // Function to update career indices
    function updateCareerIndices() {
        const careerItems = careerContainer.querySelectorAll('.career-item');
        careerItems.forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('[') && name.includes(']')) {
                    const fieldName = name.match(/\[(.*?)\]/g)?.[1]?.replace(/[\[\]]/g, '');
                    if (fieldName) {
                        input.name = `career_histories[${index}][${fieldName}]`;
                    }
                }
            });
        });
    }

    // Initialize indices on page load
    updateCareerIndices();
}

/**
 * Education section management
 */
function initializeEducation() {
    const educationContainer = document.getElementById('education_fields');
    const addEducationButton = document.getElementById('add_education');
    const educationTemplate = document.getElementById('education_template');

    if (!educationContainer || !addEducationButton || !educationTemplate) return;

    // Add education functionality
    addEducationButton.addEventListener('click', function(e) {
        e.preventDefault();

        // Get current education count
        const existingEducations = educationContainer.querySelectorAll('.education-item');
        const educationIndex = existingEducations.length;

        // Clone template
        const newEducation = educationTemplate.firstElementChild.cloneNode(true);

        // Update name attributes with proper index
        newEducation.querySelectorAll('input').forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('[]')) {
                const newName = name.replace('[]', `[${educationIndex}]`);
                input.setAttribute('name', newName);
                input.value = ''; // Clear value
            }
        });

        // Add event listener to remove button
        const removeButton = newEducation.querySelector('.remove-education');
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                const educationItem = e.target.closest('.education-item');
                if (educationItem) {
                    const educationItems = educationContainer.querySelectorAll('.education-item');
                    if (educationItems.length > 1) {
                        educationItem.remove();
                        updateEducationIndices();
                    } else {
                        // If only one item, clear its fields
                        educationItem.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                }
            });
        }

        // Add to container
        educationContainer.appendChild(newEducation);

        // Update indices after adding
        updateEducationIndices();
    });

    // Event delegation for remove buttons
    educationContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-education')) {
            e.preventDefault();
            const educationItem = e.target.closest('.education-item');
            if (educationItem) {
                const educationItems = educationContainer.querySelectorAll('.education-item');
                if (educationItems.length > 1) {
                    educationItem.remove();
                    updateEducationIndices();
                } else {
                    // If it's the last item, clear fields instead of removing
                    educationItem.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            }
        }
    });

    // Function to update education indices
    function updateEducationIndices() {
        const educationItems = educationContainer.querySelectorAll('.education-item');
        educationItems.forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('[') && name.includes(']')) {
                    const fieldName = name.match(/\[(.*?)\]/g)?.[1]?.replace(/[\[\]]/g, '');
                    if (fieldName) {
                        input.name = `educations[${index}][${fieldName}]`;
                    }
                }
            });
        });
    }

    // Initialize indices on page load
    updateEducationIndices();
}

/**
 * Training section management
 */
function initializeTraining() {
    const trainingContainer = document.getElementById('training_fields');
    const addTrainingButton = document.getElementById('add_training');
    const trainingTemplate = document.getElementById('training_template');

    if (!trainingContainer || !addTrainingButton || !trainingTemplate) return;

    // Add training functionality
    addTrainingButton.addEventListener('click', function(e) {
        e.preventDefault();

        // Get current training count
        const existingTrainings = trainingContainer.querySelectorAll('.training-item');
        const trainingIndex = existingTrainings.length;

        // Clone template
        const newTraining = trainingTemplate.firstElementChild.cloneNode(true);

        // Update name attributes with proper index
        newTraining.querySelectorAll('input').forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('[]')) {
                const newName = name.replace('[]', `[${trainingIndex}]`);
                input.setAttribute('name', newName);
                input.value = ''; // Clear value
            }
        });

        // Add event listener to remove button
        const removeButton = newTraining.querySelector('.remove-training');
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                const trainingItem = e.target.closest('.training-item');
                if (trainingItem) {
                    const trainingItems = trainingContainer.querySelectorAll('.training-item');
                    if (trainingItems.length > 1) {
                        trainingItem.remove();
                        updateTrainingIndices();
                    } else {
                        // If only one item, clear its fields
                        trainingItem.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                }
            });
        }

        // Add to container
        trainingContainer.appendChild(newTraining);

        // Update indices after adding
        updateTrainingIndices();
    });

    // Event delegation for remove buttons
    trainingContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-training')) {
            e.preventDefault();
            const trainingItem = e.target.closest('.training-item');
            if (trainingItem) {
                const trainingItems = trainingContainer.querySelectorAll('.training-item');
                if (trainingItems.length > 1) {
                    trainingItem.remove();
                    updateTrainingIndices();
                } else {
                    // If it's the last item, clear fields instead of removing
                    trainingItem.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            }
        }
    });

    // Function to update training indices
    function updateTrainingIndices() {
        const trainingItems = trainingContainer.querySelectorAll('.training-item');
        trainingItems.forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('[') && name.includes(']')) {
                    const fieldName = name.match(/\[(.*?)\]/g)?.[1]?.replace(/[\[\]]/g, '');
                    if (fieldName) {
                        input.name = `training_histories[${index}][${fieldName}]`;
                    }
                }
            });
        });
    }

    // Initialize indices on page load
    updateTrainingIndices();
}

/**
 * Organizational History section management
 */
function initializeOrganizationalHistory() {
    const organizationalContainer = document.getElementById('organizational_fields');
    const addOrganizationalButton = document.getElementById('add_organizational');
    const organizationalTemplate = document.getElementById('organizational_template');

    if (!organizationalContainer || !addOrganizationalButton || !organizationalTemplate) return;

    // Add organizational functionality
    addOrganizationalButton.addEventListener('click', function(e) {
        e.preventDefault();

        // Get current organizational count
        const existingOrganizations = organizationalContainer.querySelectorAll('.organizational-item');
        const organizationalIndex = existingOrganizations.length;

        // Clone template
        const newOrganizational = organizationalTemplate.firstElementChild.cloneNode(true);

        // Update name attributes with proper index
        newOrganizational.querySelectorAll('input').forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('[]')) {
                const newName = name.replace('[]', `[${organizationalIndex}]`);
                input.setAttribute('name', newName);
                input.value = ''; // Clear value
            }
        });

        // Add event listener to remove button
        const removeButton = newOrganizational.querySelector('.remove-organizational');
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                const organizationalItem = e.target.closest('.organizational-item');
                if (organizationalItem) {
                    const organizationalItems = organizationalContainer.querySelectorAll('.organizational-item');
                    if (organizationalItems.length > 1) {
                        organizationalItem.remove();
                        updateOrganizationalIndices();
                    } else {
                        // If only one item, clear its fields
                        organizationalItem.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                }
            });
        }

        // Add to container
        organizationalContainer.appendChild(newOrganizational);

        // Update indices after adding
        updateOrganizationalIndices();
    });

    // Event delegation for remove buttons
    organizationalContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-organizational')) {
            e.preventDefault();
            const organizationalItem = e.target.closest('.organizational-item');
            if (organizationalItem) {
                const organizationalItems = organizationalContainer.querySelectorAll('.organizational-item');
                if (organizationalItems.length > 1) {
                    organizationalItem.remove();
                    updateOrganizationalIndices();
                } else {
                    // If it's the last item, clear fields instead of removing
                    organizationalItem.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            }
        }
    });

    // Function to update organizational indices
    function updateOrganizationalIndices() {
        const organizationalItems = organizationalContainer.querySelectorAll('.organizational-item');
        organizationalItems.forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('[') && name.includes(']')) {
                    const fieldName = name.match(/\[(.*?)\]/g)?.[1]?.replace(/[\[\]]/g, '');
                    if (fieldName) {
                        input.name = `organizational_histories[${index}][${fieldName}]`;
                    }
                }
            });
        });
    }

    // Initialize indices on page load
    updateOrganizationalIndices();
}

/**
 * Awards section management
 */
function initializeAwards() {
    const awardContainer = document.getElementById('award_fields');
    const addAwardButton = document.getElementById('add_award');
    const awardTemplate = document.getElementById('award_template');

    if (!awardContainer || !addAwardButton || !awardTemplate) return;

    // Add award functionality
    addAwardButton.addEventListener('click', function(e) {
        e.preventDefault();

        // Get current award count
        const existingAwards = awardContainer.querySelectorAll('.award-item');
        const awardIndex = existingAwards.length;

        // Clone template
        const newAward = awardTemplate.firstElementChild.cloneNode(true);

        // Update name attributes with proper index
        newAward.querySelectorAll('input').forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('[]')) {
                const newName = name.replace('[]', `[${awardIndex}]`);
                input.setAttribute('name', newName);
                input.value = ''; // Clear value
            }
        });

        // Add event listener to remove button
        const removeButton = newAward.querySelector('.remove-award');
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                const awardItem = e.target.closest('.award-item');
                if (awardItem) {
                    const awardItems = awardContainer.querySelectorAll('.award-item');
                    if (awardItems.length > 1) {
                        awardItem.remove();
                        updateAwardIndices();
                    } else {
                        // If only one item, clear its fields
                        awardItem.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                }
            });
        }

        // Add to container
        awardContainer.appendChild(newAward);

        // Update indices after adding
        updateAwardIndices();
    });

    // Event delegation for remove buttons
    awardContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-award')) {
            e.preventDefault();
            const awardItem = e.target.closest('.award-item');
            if (awardItem) {
                const awardItems = awardContainer.querySelectorAll('.award-item');
                if (awardItems.length > 1) {
                    awardItem.remove();
                    updateAwardIndices();
                } else {
                    // If it's the last item, clear fields instead of removing
                    awardItem.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            }
        }
    });

    // Function to update award indices
    function updateAwardIndices() {
        const awardItems = awardContainer.querySelectorAll('.award-item');
        awardItems.forEach((item, index) => {
            item.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('[') && name.includes(']')) {
                    const fieldName = name.match(/\[(.*?)\]/g)?.[1]?.replace(/[\[\]]/g, '');
                    if (fieldName) {
                        input.name = `awards[${index}][${fieldName}]`;
                    }
                }
            });
        });
    }

    // Initialize indices on page load
    updateAwardIndices();
}