import WysiwygEditor from './WysiwygEditor';
import SelectSelectize from './SelectSelectize';
import SelectSelect2 from './SelectSelect2';
import { DatePicker } from "./DatePicker";
import ActionButton from "./ActionButton";
import { BookmarkButtonElement } from '../../react/controllers/BookmarkButton';
import { SocialAccountEditor } from './SocialAccountsEditor';


customElements.get('wysiwyg-editor') || customElements.define('wysiwyg-editor', WysiwygEditor, { extends: 'textarea' });
customElements.get('select-selectize') || customElements.define('select-selectize', SelectSelectize, { extends: 'select' });
customElements.get('select-select2') || customElements.define('select-select2', SelectSelect2, { extends: 'select' });
customElements.get('date-time-picker') || customElements.define('date-time-picker', DatePicker, { extends: 'input' });
customElements.get('action-button') || customElements.define('action-button', ActionButton);

customElements.define('bookmark-button', BookmarkButtonElement);

customElements.define('social-accounts-editor', SocialAccountEditor, {extends: 'textarea'});
