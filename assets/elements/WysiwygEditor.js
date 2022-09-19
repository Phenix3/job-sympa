import FroalaEditor from 'froala-editor';

class WysiwygEditor extends HTMLTextAreaElement {
    connectedCallback() {
        FroalaEditor(this);
    }
}

customElements.define('wysiwyg-editor', WysiwygEditor, {extends: true});