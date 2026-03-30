import DynamicFormManager, { 
    initializeTabs, 
    initializeOrganizationField, 
    initializeSpouseFields 
} from '../dynamic-form.js';

document.addEventListener('DOMContentLoaded', function() {
    // Initialize dynamic form sections
    const formManager = new DynamicFormManager();
    formManager.initializeSections();
    
    // Initialize tabs functionality
    initializeTabs();
    
    // Initialize organization field visibility
    initializeOrganizationField();
    
    // Initialize spouse fields
    initializeSpouseFields();
});