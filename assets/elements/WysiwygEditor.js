import FroalaEditor from 'froala-editor';

export default class WysiwygEditor extends HTMLTextAreaElement {
    connectedCallback() {
        FroalaEditor(this);
    }
}
