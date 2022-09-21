import '@selectize/selectize';
import '@selectize/selectize/dist/css/selectize.css';

class SelectSelectize extends HTMLSelectElement {

    connectedCallback() {
        const options = {};
        const maxItems = parseInt(this.getAttribute('data-max-items'));
        if (maxItems) {
            Object.assign(options, {maxItems});
        }
        console.log('select-selectize called');
        $(this).selectize(options);
    }

}

customElements.define('select-selectize', SelectSelectize, {extends: 'select'});