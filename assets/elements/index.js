import WysiwygEditor from './WysiwygEditor';
import SelectSelectize from './SelectSelectize';
import {DatePicker} from "./DatePicker";
import ActionButton from "./ActionButton";


customElements.define('wysiwyg-editor', WysiwygEditor, {extends: 'textarea'});
customElements.define('select-selectize', SelectSelectize, {extends: 'select'});
customElements.define('date-time-picker', DatePicker, {extends: 'input'});
customElements.define('action-button', ActionButton);