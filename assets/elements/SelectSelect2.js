import 'select2/dist/js/select2';
import 'select2/dist/js/i18n/en';
import 'select2/dist/js/i18n/fr';
import 'select2/dist/css/select2.css';

export default class SelectSelect2 extends HTMLSelectElement {
    connectedCallback() {
        $(this).select2();
    }
}